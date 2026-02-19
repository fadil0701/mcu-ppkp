@extends('layouts.app')

@section('title', 'Notifikasi Admin')

@section('content')
<x-common.page-breadcrumb pageTitle="Notifikasi Admin" />

@if(session('success'))
    <div class="mb-4 rounded-lg border border-success-200 bg-success-50 p-4 text-theme-sm text-success-800 dark:border-success-800 dark:bg-success-500/10 dark:text-success-400">{{ session('success') }}</div>
@endif

<x-common.component-card title="Daftar Notifikasi">
    @php $user = auth()->user(); @endphp
    @if($user->unreadNotifications->count() > 0)
        <form method="POST" action="{{ route('admin.notifications.mark-all-read') }}" class="mb-4 inline">
            @csrf
            <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Tandai Semua Dibaca</button>
        </form>
    @endif

    <div class="space-y-2">
        @forelse($notifications as $n)
            <div class="rounded-lg border border-gray-200 p-4 {{ $n->read_at ? 'bg-gray-50/50 dark:bg-gray-800/30' : 'bg-white dark:bg-gray-800/50' }} dark:border-gray-800">
                <div class="flex items-start justify-between gap-2">
                    <div class="min-w-0 flex-1">
                        @if(!empty($n->data['title']))
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">{{ $n->data['title'] }}</p>
                        @endif
                        <p class="text-theme-sm text-gray-800 dark:text-white/90">{{ $n->data['message'] ?? class_basename($n->type) }}</p>
                        <p class="mt-1 text-theme-xs text-gray-500">{{ $n->created_at->diffForHumans() }}</p>
                    </div>
                    @if(is_null($n->read_at))
                        <form method="POST" action="{{ route('admin.notifications.mark-read', $n->id) }}" class="shrink-0">
                            @csrf
                            <button type="submit" class="rounded border border-gray-200 px-2 py-1 text-theme-xs text-gray-600 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700">Tandai dibaca</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p class="py-6 text-center text-gray-500">Tidak ada notifikasi.</p>
        @endforelse
    </div>
    <div class="mt-4">{{ $notifications->links() }}</div>
</x-common.component-card>
@endsection
