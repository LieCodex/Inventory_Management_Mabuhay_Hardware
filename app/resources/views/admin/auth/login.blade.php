<x-layouts::auth>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Admin Login')" :description="__('Access the Inventory Management System')" />

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('admin.login.submit') }}" class="flex flex-col gap-6">
            @csrf
            
            <flux:input
                name="email"
                :label="__('Admin Email')"
                :value="old('email')"
                type="email"
                required
                autofocus
                placeholder="admin@mabuhay.com"
            />

            <flux:input
                name="password"
                :label="__('Password')"
                type="password"
                required
                :placeholder="__('Password')"
                viewable
            />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('Login to Dashboard') }}
                </flux:button>
            </div>
        </form>

        <div class="text-center text-sm">
            <flux:link :href="route('login')">{{ __('Back to Standard Login') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>