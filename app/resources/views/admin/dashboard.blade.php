<x-layouts::app :title="__('User Management')">
    <div class="space-y-6">
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-bold text-zinc-800 dark:text-zinc-100">Staff Management</h2>
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-100 text-sm font-semibold text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <section class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                    <h3 class="mb-4 font-semibold text-zinc-800 dark:text-zinc-100">Active Staff Accounts</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="text-zinc-500 uppercase text-xs border-b border-zinc-100 dark:border-zinc-800">
                                <tr>
                                    <th class="py-3 px-2">Name</th>
                                    <th class="py-3 px-2">Username</th>
                                    <th class="py-3 px-2">Role</th>
                                    <th class="py-3 px-2">Created At</th>
                                    <th class="py-3 px-2 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-zinc-700 dark:text-zinc-200">
                                @foreach($users as $user)
                                <tr class="border-t border-zinc-100 dark:border-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                    <td class="py-3 px-2 font-medium">{{ $user->name }}</td>
                                    <td class="py-3 px-2 text-zinc-500">{{ $user->username }}</td>
                                    <td class="py-3 px-2">
                                        <span class="rounded-full px-2 py-0.5 text-xs font-medium 
                                            {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30' : 'bg-blue-100 text-blue-700 dark:bg-blue-900/30' }}">
                                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-2 text-zinc-500">{{ $user->created_at->format('M d, Y') }}</td>
                                    <td class="py-3 px-2 text-right">
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?')">
                                                @csrf @method('DELETE')
                                                <button class="text-rose-500 hover:text-rose-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

            <div class="space-y-4">
                <section class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                    <h3 class="mb-4 font-semibold text-zinc-800 dark:text-zinc-100">Add New User</h3>
                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <flux:input name="name" label="Full Name" placeholder="e.g. Rexian" required />
                        <flux:input name="username" label="Username" placeholder="e.g. rexian_admin" required />
                        <flux:input name="email" type="email" label="Email Address" placeholder="staff@mabuhay.com" required />
                        
                        <flux:select name="role" label="System Role">
                            <option value="cashier">Cashier</option>
                            <option value="inventory_manager">Inventory Manager</option>
                            <option value="admin">Admin</option>
                        </flux:select>

                        <flux:input name="password" type="password" label="Initial Password" required />

                        <flux:button type="submit" variant="primary" class="w-full bg-emerald-600 hover:bg-emerald-700">
                            Create Account
                        </flux:button>
                    </form>
                </section>
            </div>
        </div>
    </div>
</x-layouts::app>