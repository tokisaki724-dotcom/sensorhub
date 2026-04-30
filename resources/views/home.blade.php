@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">Welcome to SensorHub</h1>
            <p class="text-xl md:text-2xl mb-8 text-blue-100">Learn Sensors. Build Projects. Share Ideas.</p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('sensors.index') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Explore Sensors
                </a>
                <a href="{{ route('projects.index') }}" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition">
                    View Projects
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Sensors -->
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center mb-12 text-gray-800 dark:text-white">Featured Sensors</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredSensors as $sensor)
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition transform hover:-translate-y-2 flex flex-col">
                <div class="h-48 bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                    <i class="fas fa-microchip text-8xl text-white"></i>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-2xl font-bold mb-3 text-gray-800 dark:text-white">{{ $sensor->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4 flex-1">{{ Str::limit($sensor->description, 120) }}</p>
                    <a href="{{ route('sensors.show', $sensor->slug) }}" class="text-primary font-semibold hover:underline">
                        Learn More <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-12">
            <a href="{{ route('sensors.index') }}" class="inline-block bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-600 transition">
                View All Sensors
            </a>
        </div>
    </div>
</section>

<!-- Featured Projects -->
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center mb-12 text-gray-800 dark:text-white">Featured Projects</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($featuredProjects as $project)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition flex flex-col">
                <div class="p-8 flex-1 flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <span class="bg-blue-100 dark:bg-blue-900 text-primary px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $project->difficulty }}
                        </span>
                        <span class="text-gray-500 dark:text-gray-400 text-sm">
                            <i class="fas fa-microchip mr-1"></i> {{ $project->sensor->name }}
                        </span>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-800 dark:text-white">{{ $project->title }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4 flex-1">{{ Str::limit($project->description, 150) }}</p>
                    <a href="{{ route('projects.show', $project->slug) }}" class="text-primary font-semibold hover:underline">
                        View Project <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-12">
            <a href="{{ route('projects.index') }}" class="inline-block bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-600 transition">
                View All Projects
            </a>
        </div>
    </div>
</section>

<!-- Latest Tutorials -->
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center mb-12 text-gray-800 dark:text-white">Latest Tutorials</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($latestVideos as $video)
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                <div class="relative pb-[56.25%]">
                    <iframe class="absolute inset-0 w-full h-full" 
                            src="https://www.youtube.com/embed/{{ $video->youtube_id }}" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-lg mb-2 text-gray-800 dark:text-white">{{ $video->title }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">{{ Str::limit($video->description, 80) }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-12">
            <a href="{{ route('videos.index') }}" class="inline-block bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-600 transition">
                View All Tutorials
            </a>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-gradient-to-r from-green-500 to-green-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold mb-6">Have a Project Idea?</h2>
        <p class="text-xl mb-8 text-green-100">Share your sensor project suggestions with our community!</p>
        @auth
            <a href="{{ route('dashboard.suggestions') }}" class="inline-block bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                Submit Your Idea
            </a>
        @else
            <a href="{{ route('register') }}" class="inline-block bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                Join Now to Share Ideas
            </a>
        @endauth
    </div>
</section>
@endsection
