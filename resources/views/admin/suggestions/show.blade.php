@extends('layouts.app')
@section('title', 'View Suggestion')
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8"><a href="{{ route('admin.suggestions.index') }}" class="text-primary hover:underline mb-2 inline-block"><i class="fas fa-arrow-left mr-1"></i>Back to Suggestions</a><h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-2">Suggestion Details</h1></div>
    @if(session('success'))<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>@endif
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
        <div class="space-y-4">
            <div><label class="text-sm font-medium text-gray-700 dark:text-gray-300">User:</label><p class="mt-1 text-gray-900 dark:text-white">{{ $suggestion->user->name }}</p></div>
            <div><label class="text-sm font-medium text-gray-700 dark:text-gray-300">Email:</label><p class="mt-1 text-gray-900 dark:text-white">{{ $suggestion->user->email }}</p></div>
            <div><label class="text-sm font-medium text-gray-700 dark:text-gray-300">Title:</label><p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $suggestion->title }}</p></div>
            <div><label class="text-sm font-medium text-gray-700 dark:text-gray-300">Message:</label><p class="mt-1 text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $suggestion->message }}</p></div>
            <div><label class="text-sm font-medium text-gray-700 dark:text-gray-300">Status:</label><p class="mt-1"><span class="px-3 py-1 text-sm font-semibold rounded-full @if($suggestion->status=='pending')bg-yellow-100 text-yellow-800@elseif($suggestion->status=='reviewed')bg-blue-100 text-blue-800@elseif($suggestion->status=='implemented')bg-green-100 text-green-800@else bg-red-100 text-red-800@endif">{{ ucfirst($suggestion->status) }}</span></p></div>
            <div><label class="text-sm font-medium text-gray-700 dark:text-gray-300">Submitted:</label><p class="mt-1 text-gray-900 dark:text-white">{{ $suggestion->created_at->format('M d, Y h:i A') }}</p></div>
        </div>
        <form method="POST" action="{{ route('admin.suggestions.status', $suggestion) }}" class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">@csrf @method('PUT')
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Update Status:</label>
            <select name="status" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white">
                <option value="pending" {{ $suggestion->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="reviewed" {{ $suggestion->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                <option value="implemented" {{ $suggestion->status == 'implemented' ? 'selected' : '' }}>Implemented</option>
                <option value="rejected" {{ $suggestion->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <button type="submit" class="mt-4 w-full bg-primary text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition font-semibold"><i class="fas fa-save mr-2"></i>Update Status</button>
        </form>
    </div>
</div>
@endsection
