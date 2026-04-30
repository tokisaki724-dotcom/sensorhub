@extends('layouts.app')

@section('title', 'Register')

@push('styles')
<style>
    .auth-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .glass-effect {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
    }
    .dark .glass-effect {
        background: rgba(31, 41, 55, 0.95);
    }
    .input-field {
        transition: all 0.3s ease;
    }
    .input-field:focus {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen flex">
    <!-- Left Side - Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 lg:p-24 bg-gray-50 dark:bg-gray-900 order-2 lg:order-1">
        <div class="w-full max-w-md">
            <div class="glass-effect rounded-2xl shadow-2xl p-8">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 mb-4">
                        <i class="fas fa-user-plus text-4xl text-white"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Create Account</h2>
                    <p class="text-gray-600 dark:text-gray-400">Join SensorHub and start your journey</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input id="name" name="name" type="text" required 
                                class="input-field w-full pl-12 pr-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/20 dark:bg-gray-700 dark:text-white @error('name') border-red-500 @enderror" 
                                placeholder="John Doe" 
                                value="{{ old('name') }}">
                        </div>
                        @error('name')
                            <p class="text-red-500 text-sm mt-2"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input id="email" name="email" type="email" required 
                                class="input-field w-full pl-12 pr-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/20 dark:bg-gray-700 dark:text-white @error('email') border-red-500 @enderror" 
                                placeholder="you@example.com" 
                                value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-sm mt-2"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password" name="password" type="password" required 
                                class="input-field w-full pl-12 pr-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/20 dark:bg-gray-700 dark:text-white @error('password') border-red-500 @enderror" 
                                placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm mt-2"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Minimum 8 characters</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password" required 
                                class="input-field w-full pl-12 pr-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/20 dark:bg-gray-700 dark:text-white" 
                                placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                        <i class="fas fa-user-plus mr-2"></i>Create Account
                    </button>

                    <div class="text-center pt-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-gray-600 dark:text-gray-400">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="text-primary hover:text-purple-600 font-semibold transition">
                                Sign In
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} SensorHub. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <!-- Right Side - Branding -->
    <div class="hidden lg:flex lg:w-1/2 auth-gradient items-center justify-center p-12 order-1 lg:order-2">
        <div class="max-w-md text-white">
            <div class="mb-8">
                <i class="fas fa-rocket text-7xl mb-6 opacity-90"></i>
                <h1 class="text-5xl font-bold mb-4">Join SensorHub Today!</h1>
                <p class="text-xl opacity-90 leading-relaxed">Create your account and unlock access to a world of sensors, projects, and tutorials.</p>
            </div>
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-2xl"></i>
                    <span class="text-lg">Free access to sensor guides</span>
                </div>
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-2xl"></i>
                    <span class="text-lg">Save your favorite projects</span>
                </div>
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-2xl"></i>
                    <span class="text-lg">Share ideas with the community</span>
                </div>
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-2xl"></i>
                    <span class="text-lg">Get personalized recommendations</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
