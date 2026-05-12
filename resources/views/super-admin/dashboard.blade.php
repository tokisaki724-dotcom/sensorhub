@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-gray-900 rounded-lg border border-gray-800 shadow-sm overflow-hidden mb-8">
            <div class="px-6 py-6 lg:px-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <p class="text-sm font-semibold text-blue-300 uppercase">SensorHub Control Center</p>
                        <h1 class="text-3xl sm:text-4xl font-bold text-white mt-2">Super Admin Dashboard</h1>
                        <p class="text-gray-300 mt-2 max-w-2xl">Manage platform access, review activity, and move quickly into content operations.</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('super-admin.users.index') }}" class="inline-flex items-center justify-center px-5 py-3 rounded-lg bg-primary text-white font-semibold hover:bg-blue-600 transition">
                            <i class="fas fa-users-cog mr-2"></i>Manage Accounts
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center px-5 py-3 rounded-lg bg-white text-gray-900 font-semibold hover:bg-gray-100 transition">
                            <i class="fas fa-toolbox mr-2"></i>Admin Tools
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center justify-center px-5 py-3 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 transition">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 border-t border-gray-800">
                <a href="https://sensorshub.infinityfree.me/" target="_blank" class="flex items-center gap-3 px-6 py-4 text-gray-200 hover:bg-gray-800 transition">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-600 text-white">
                        <i class="fas fa-flask"></i>
                    </span>
                    <span>
                        <span class="block font-semibold">Simulation</span>
                        <span class="block text-sm text-gray-400">Open external lab</span>
                    </span>
                </a>
                <a href="{{ route('super-admin.profile') }}" class="flex items-center gap-3 px-6 py-4 text-gray-200 hover:bg-gray-800 transition sm:border-l sm:border-gray-800">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600 text-white">
                        <i class="fas fa-user"></i>
                    </span>
                    <span>
                        <span class="block font-semibold">Profile</span>
                        <span class="block text-sm text-gray-400">Update account details</span>
                    </span>
                </a>
                <a href="{{ route('super-admin.suggestions.index') }}" class="flex items-center gap-3 px-6 py-4 text-gray-200 hover:bg-gray-800 transition sm:border-l sm:border-gray-800">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-amber-500 text-gray-950">
                        <i class="fas fa-lightbulb"></i>
                    </span>
                    <span>
                        <span class="block font-semibold">Suggestions</span>
                        <span class="block text-sm text-gray-400">{{ $stats['pending_suggestions'] }} pending review</span>
                    </span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-2 bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Account Overview</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Current platform access by role.</p>
                    </div>
                    <a href="{{ route('super-admin.users.index') }}" class="text-sm font-semibold text-primary hover:underline">Manage</a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="rounded-lg border border-gray-200 dark:border-gray-800 p-5">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Users</p>
                            <i class="fas fa-user text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-3">{{ $stats['users'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Learner accounts</p>
                    </div>
                    <div class="rounded-lg border border-gray-200 dark:border-gray-800 p-5">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Admins</p>
                            <i class="fas fa-user-tie text-emerald-600 dark:text-emerald-400"></i>
                        </div>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-3">{{ $stats['admins'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Content operators</p>
                    </div>
                    <div class="rounded-lg border border-gray-200 dark:border-gray-800 p-5">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Super Admins</p>
                            <i class="fas fa-user-shield text-purple-600 dark:text-purple-400"></i>
                        </div>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-3">{{ $stats['super_admins'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Full access</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Review Queue</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Items needing admin attention.</p>
                <div class="mt-6 rounded-lg bg-amber-50 dark:bg-amber-950 border border-amber-200 dark:border-amber-900 p-5">
                    <p class="text-sm font-semibold text-amber-800 dark:text-amber-200">Pending Suggestions</p>
                    <p class="text-4xl font-bold text-amber-900 dark:text-amber-100 mt-2">{{ $stats['pending_suggestions'] }}</p>
                    <a href="{{ route('super-admin.suggestions.index') }}" class="inline-flex items-center mt-5 text-sm font-semibold text-amber-800 dark:text-amber-200 hover:underline">
                        Review suggestions<i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <a href="{{ route('super-admin.sensors.index') }}" class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-5 shadow-sm hover:border-blue-300 dark:hover:border-blue-700 transition">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Sensors</p>
                    <i class="fas fa-microchip text-blue-600 dark:text-blue-400"></i>
                </div>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-3">{{ $stats['sensors'] }}</p>
            </a>
            <a href="{{ route('super-admin.projects.index') }}" class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-5 shadow-sm hover:border-emerald-300 dark:hover:border-emerald-700 transition">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Projects</p>
                    <i class="fas fa-project-diagram text-emerald-600 dark:text-emerald-400"></i>
                </div>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-3">{{ $stats['projects'] }}</p>
            </a>
            <a href="{{ route('super-admin.products.index') }}" class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-5 shadow-sm hover:border-purple-300 dark:hover:border-purple-700 transition">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Products</p>
                    <i class="fas fa-shopping-cart text-purple-600 dark:text-purple-400"></i>
                </div>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-3">{{ $stats['products'] }}</p>
            </a>
            <a href="{{ route('super-admin.videos.index') }}" class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 p-5 shadow-sm hover:border-red-300 dark:hover:border-red-700 transition">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Videos</p>
                    <i class="fas fa-video text-red-600 dark:text-red-400"></i>
                </div>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-3">{{ $stats['videos'] }}</p>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Recent Accounts</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Newest registered accounts.</p>
                    </div>
                    <a href="{{ route('super-admin.users.index') }}" class="text-sm font-semibold text-primary hover:underline">View all</a>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($recentUsers as $user)
                        <div class="px-6 py-4 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3 min-w-0 flex-1">
                                <div class="w-10 h-10 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center overflow-hidden flex-shrink-0">
                                    @if($user->profile_image && file_exists(public_path($user->profile_image)))
                                        <img src="{{ asset($user->profile_image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-user text-gray-500"></i>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $user->email }}</p>
                                </div>
                            </div>
                            <span class="shrink-0 px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200">{{ ucwords(str_replace('_', ' ', $user->role)) }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">No accounts yet</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Recent Suggestions</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Latest feedback from users.</p>
                    </div>
                    <a href="{{ route('super-admin.suggestions.index') }}" class="text-sm font-semibold text-primary hover:underline">Review</a>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($recentSuggestions as $suggestion)
                        <div class="px-6 py-4">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 dark:text-white truncate">{{ Str::limit($suggestion->title, 56) }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">by {{ $suggestion->user->name ?? 'Deleted user' }}</p>
                                </div>
                                <span class="shrink-0 px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">{{ ucfirst($suggestion->status) }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">No suggestions yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
