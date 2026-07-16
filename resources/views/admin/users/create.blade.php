@extends('layouts.admin')

@section('title', 'Add User')

@section('content')
    <x-breadcrumb :breadcrumbs="[
        ['title' => 'Users', 'url' => route('admin.users.index')],
        ['title' => 'Add User', 'url' => null],
    ]" />

    <x-page-header title="Add User" subtitle="Create a new system user." icon="lucide:user-plus" />

    <div class="max-w-lg bg-card border border-border rounded-xl p-6">
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1.5">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full px-3 py-2 text-sm border border-input rounded-lg bg-background focus:outline-none focus:ring-2 focus:ring-ring/40">
                @error('name') <p class="text-xs text-destructive mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-3 py-2 text-sm border border-input rounded-lg bg-background focus:outline-none focus:ring-2 focus:ring-ring/40">
                @error('email') <p class="text-xs text-destructive mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Password</label>
                <input type="password" name="password" required
                    class="w-full px-3 py-2 text-sm border border-input rounded-lg bg-background focus:outline-none focus:ring-2 focus:ring-ring/40">
                @error('password') <p class="text-xs text-destructive mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Role</label>
                <select name="role" required
                    class="w-full px-3 py-2 text-sm border border-input rounded-lg bg-background focus:outline-none focus:ring-2 focus:ring-ring/40">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role') <p class="text-xs text-destructive mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-2 pt-2">
                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium bg-primary text-primary-foreground rounded-lg hover:opacity-90 transition-opacity">
                    Create User
                </button>
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-sm font-medium text-muted-foreground hover:text-foreground transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
