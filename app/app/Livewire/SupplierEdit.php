<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\LogisticItem;
use App\Models\SupplierInfo;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class SupplierEdit extends Component
{
    use WithFileUploads;

    public $supplierId;
    public $showEditModal = false;

    public $company_name;
    public $contact_number;
    public $email;
    public $item_ids = [];

    public $existing_image_path;
    public $supplier_image;

    public function mount($supplierId)
    {
        $this->supplierId = $supplierId;
        $this->fillSupplierFields();
    }

    private function fillSupplierFields(): void
    {
        $supplier = SupplierInfo::findOrFail($this->supplierId);
        $company = $supplier->company_name;

        $rows = SupplierInfo::where('company_name', $company)->get();

        $this->company_name = $company;
        $this->contact_number = $supplier->contact_number;
        $this->email = $supplier->email;
        $this->item_ids = $rows->pluck('item_id')->unique()->values()->all();
        $this->existing_image_path = $rows->pluck('image_path')->filter()->first();
    }

    public function openEditModal()
    {
        $this->fillSupplierFields();
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetValidation();
        $this->supplier_image = null;
    }

    public function updateSupplier()
    {
        $validated = $this->validate([
            'company_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'item_ids' => 'required|array|min:1',
            'item_ids.*' => 'exists:items,id',
            'supplier_image' => 'nullable|image|max:2048',
        ]);

        $supplier = SupplierInfo::findOrFail($this->supplierId);
        $oldCompany = $supplier->company_name;
        $newCompany = $validated['company_name'];

        $newImagePath = $this->existing_image_path;
        if ($this->supplier_image) {
            $newImagePath = $this->supplier_image->store('suppliers', 'public');
        }

        DB::transaction(function () use ($validated, $oldCompany, $newCompany, $newImagePath) {
            if ($oldCompany !== $newCompany) {
                SupplierInfo::where('company_name', $oldCompany)->update(['company_name' => $newCompany]);
                LogisticItem::where('supplier', $oldCompany)->update(['supplier' => $newCompany]);
            }

            SupplierInfo::where('company_name', $newCompany)->update([
                'contact_number' => $validated['contact_number'],
                'email' => $validated['email'] ?? null,
                'image_path' => $newImagePath,
            ]);

            $selectedIds = collect($validated['item_ids'])->map(fn ($id) => (int) $id)->unique()->values();
            $existingIds = SupplierInfo::where('company_name', $newCompany)->pluck('item_id')->map(fn ($id) => (int) $id);

            $toAdd = $selectedIds->diff($existingIds)->values();
            $toRemove = $existingIds->diff($selectedIds)->values();

            foreach ($toAdd as $itemId) {
                SupplierInfo::create([
                    'company_name' => $newCompany,
                    'item_id' => $itemId,
                    'contact_number' => $validated['contact_number'],
                    'email' => $validated['email'] ?? null,
                    'image_path' => $newImagePath,
                    'quantity_on_the_way' => 0,
                    'eta' => null,
                ]);
            }

            if ($toRemove->isNotEmpty()) {
                SupplierInfo::where('company_name', $newCompany)
                    ->whereIn('item_id', $toRemove->all())
                    ->delete();
            }

            // Recompute "on the way" + eta per item row (pending deliveries only)
            $rows = SupplierInfo::where('company_name', $newCompany)->get();
            foreach ($rows as $row) {
                $baseQuery = LogisticItem::where('supplier', $newCompany)
                    ->where('item_id', $row->item_id)
                    ->where('status', 'pending');

                $row->quantity_on_the_way = (int) $baseQuery->sum('quantity');
                $row->eta = (clone $baseQuery)
                    ->join('logistic_logs', 'logistic_items.logs_id', '=', 'logistic_logs.id')
                    ->min('logistic_logs.date');
                $row->save();
            }
        });

        $this->showEditModal = false;
        $this->supplier_image = null;
        $this->fillSupplierFields();

        session()->flash('success', 'Supplier details updated successfully.');
    }

    public function render()
    {
        return view('livewire.supplier-edit', [
            'items' => Item::orderBy('name')->get(),
        ]);
    }
}

