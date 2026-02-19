@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<x-common.page-breadcrumb pageTitle="Manajemen User" />

@if(session('success'))
    <div class="mb-4 rounded-lg border border-success-200 bg-success-50 p-4 text-theme-sm text-success-800 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="mb-4 rounded-lg border border-error-200 bg-error-50 p-4 text-theme-sm text-error-800 dark:border-error-800 dark:bg-error-500/10 dark:text-error-400">{{ session('error') }}</div>
@endif

<x-common.component-card title="Daftar User">
    <form method="GET" class="mb-4 flex flex-wrap items-center gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email..." class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 w-64">
        <select name="role" class="rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800">
            <option value="">Semua Role</option>
            <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="peserta" {{ request('role') === 'peserta' ? 'selected' : '' }}>Peserta</option>
        </select>
        <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Cari</button>
        <a href="{{ route('admin.users.create') }}" class="rounded-lg border border-brand-500 px-4 py-2 text-theme-sm font-medium text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/10">Tambah User</a>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-theme-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-800">
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Nama</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Email</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Role</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Status</th>
                    <th class="pb-3 text-left font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="py-3 font-medium text-gray-800 dark:text-white/90">{{ $u->name }}</td>
                        <td class="py-3">{{ $u->email }}</td>
                        <td class="py-3">{{ ucfirst(str_replace('_', ' ', $u->role ?? 'peserta')) }}</td>
                        <td class="py-3">
                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-theme-xs font-medium {{ $u->is_active ? 'bg-success-100 text-success-700 dark:bg-success-500/20' : 'bg-error-100 text-error-700 dark:bg-error-500/20' }}">{{ $u->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                        </td>
                        <td class="py-3">
                            <div class="flex flex-wrap items-center gap-2">
                                <x-admin.action-badge type="edit" :href="route('admin.users.edit', $u)" />
                                <x-admin.action-badge type="delete" :href="route('admin.users.destroy', $u)" confirm="Yakin hapus pengguna ini?" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-6 text-center text-gray-500">Belum ada user.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $users->links() }}</div>
</x-common.component-card>
@endsection
