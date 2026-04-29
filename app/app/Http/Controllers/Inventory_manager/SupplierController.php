<?php

namespace App\Http\Controllers\Inventory_manager;

use App\Http\Controllers\Controller;
use App\Models\SupplierInfo;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class SupplierController extends Controller
{
    // Loads the page, fetches suppliers and the items for the dropdown
    public function index()
    {
        $suppliers = SupplierInfo::query()
            ->select(
                'company_name',
                DB::raw('MIN(id) as primary_supplier_id'),
                DB::raw('MAX(contact_number) as contact_number'),
                DB::raw('MAX(email) as email'),
                DB::raw('MAX(image_path) as image_path'),
                DB::raw('SUM(quantity_on_the_way) as quantity_on_the_way'),
                DB::raw('MIN(CASE WHEN eta IS NOT NULL THEN eta END) as eta'),
                DB::raw('COUNT(DISTINCT item_id) as products_count'),
                DB::raw('GROUP_CONCAT(DISTINCT item_id ORDER BY item_id SEPARATOR ",") as item_ids')
            )
            ->groupBy('company_name')
            ->orderBy('company_name')
            ->paginate(10);

        $itemMap = Item::pluck('name', 'id');

        $suppliers->getCollection()->transform(function ($supplier) use ($itemMap) {
            $ids = collect(explode(',', (string) $supplier->item_ids))
                ->filter()
                ->map(fn ($id) => (int) $id);

            $supplier->item_names = $ids
                ->map(fn ($id) => $itemMap[$id] ?? null)
                ->filter()
                ->values()
                ->all();

            return $supplier;
        });
        
        // Fetch all items so we can populate the "Select Item" dropdown in the modal
        $items = Item::all();

        return view('inventory_manager.suppliers', compact('suppliers', 'items'));
    }

    // Handles the "Add Supplier" modal form submission
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name'   => 'required|string|max:255',
            'item_ids'       => 'required|array|min:1',
            'item_ids.*'     => 'exists:items,id',
            'contact_number' => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'supplier_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('supplier_image')) {
            $validated['image_path'] = $request->file('supplier_image')->store('suppliers', 'public');
        }

        DB::transaction(function () use ($validated) {
            $commonData = [
                'company_name' => $validated['company_name'],
                'contact_number' => $validated['contact_number'],
                'email' => $validated['email'] ?? null,
                'image_path' => $validated['image_path'] ?? null,
            ];

            foreach (array_unique($validated['item_ids']) as $itemId) {
                SupplierInfo::updateOrCreate(
                    [
                        'company_name' => $validated['company_name'],
                        'item_id' => $itemId,
                    ],
                    [
                        'contact_number' => $commonData['contact_number'],
                        'email' => $commonData['email'],
                        'image_path' => $commonData['image_path'],
                    ]
                );
            }
        });

        return redirect()->route('inventory_manager.suppliers')->with('success', 'Supplier products saved successfully!');
    }

    public function show(SupplierInfo $supplier)
    {
        $supplier = SupplierInfo::findOrFail($supplier->id);

        $supplierProducts = SupplierInfo::with('item')
            ->where('company_name', $supplier->company_name)
            ->orderBy('item_id')
            ->get();

        $companyOnTheWay = (int) $supplierProducts->sum('quantity_on_the_way');
        $companyEta = $supplierProducts->pluck('eta')->filter()->sort()->first();

        return view('inventory_manager.supplier_details', compact(
            'supplier',
            'supplierProducts',
            'companyOnTheWay',
            'companyEta'
        ));
    }

    public function export()
    {
        $suppliers = SupplierInfo::query()
            ->select(
                'company_name',
                DB::raw('MAX(contact_number) as contact_number'),
                DB::raw('MAX(email) as email'),
                DB::raw('SUM(quantity_on_the_way) as quantity_on_the_way'),
                DB::raw('MIN(CASE WHEN eta IS NOT NULL THEN eta END) as eta'),
                DB::raw('GROUP_CONCAT(DISTINCT item_id ORDER BY item_id SEPARATOR ",") as item_ids')
            )
            ->groupBy('company_name')
            ->orderBy('company_name')
            ->get();

        $itemMap = Item::pluck('name', 'id');
        $filename = 'suppliers_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($suppliers, $itemMap) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Company Name', 'Products', 'Contact Number', 'Email', 'On the way', 'ETA']);

            foreach ($suppliers as $supplier) {
                $productNames = collect(explode(',', (string) $supplier->item_ids))
                    ->filter()
                    ->map(fn ($id) => $itemMap[(int) $id] ?? null)
                    ->filter()
                    ->implode(', ');

                fputcsv($handle, [
                    $supplier->company_name,
                    $productNames ?: 'N/A',
                    $supplier->contact_number,
                    $supplier->email,
                    (int) $supplier->quantity_on_the_way,
                    $supplier->eta,
                ]);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}