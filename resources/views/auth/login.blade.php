@extends('layouts.app')

@section('title', 'Login')

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
    <!-- Left Side - Branding -->
    <div class="hidden lg:flex lg:w-1/2 auth-gradient items-center justify-center p-12">
        <div class="max-w-md text-white">
            <div class="mb-8">
                <i class="fas fa-microchip text-7xl mb-6 opacity-90"></i>
                <h1 class="text-5xl font-bold mb-4">Welcome Back!</h1>
                <p class="text-xl opacity-90 leading-relaxed">Access your SensorHub account to explore sensors, manage projects, and connect with the community.</p>
            </div>
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-2xl"></i>
                    <span class="text-lg">Access to all sensor tutorials</span>
                </div>
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-2xl"></i>
                    <span class="text-lg">Save and track your projects</span>
                </div>
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-2xl"></i>
                    <span class="text-lg">Join the maker community</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 lg:p-24 bg-gray-50 dark:bg-gray-900">
        <div class="w-full max-w-md">
            @if(session('require_verification'))
            <!-- Verification Code Form -->
            <div class="glass-effect rounded-2xl shadow-2xl p-8">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-100 dark:bg-blue-900 mb-4">
                        <i class="fas fa-envelope text-4xl text-primary"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Verify Your Email</h2>
                    <p class="text-gray-600 dark:text-gray-400">We've sent a 6-digit code to</p>
                    <p class="text-primary font-semibold">{{ session('user_email') }}</p>
                </div>

                <form method="POST" action="{{ route('login.verify') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('user_email') }}">
                    
                    <div>
                        <input 
                            id="verification_code" 
                            name="verification_code" 
                            type="text" 
                            maxlength="6" 
                            pattern="[0-9]{6}"
                            required 
                            class="input-field w-full px-4 py-4 text-center text-4xl font-bold tracking-widest border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/20 dark:bg-gray-700 dark:text-white"
                            placeholder="000000"
                            autocomplete="off"
                        >
                        @error('verification_code')
                            <p class="text-red-500 text-sm mt-2"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                        <i class="fas fa-check-circle mr-2"></i>Verify & Login
                    </button>

                    <div class="space-y-3 text-center">
                        <form method="POST" action="{{ route('login.resend') }}" class="inline">
                            @csrf
                            <input type="hidden" name="email" value="{{ session('user_email') }}">
                            <button type="submit" class="text-primary hover:text-purple-600 font-medium text-sm">
                                <i class="fas fa-redo mr-1"></i>Resend Code
                            </button>
                        </form>
                        <div>
                            <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 text-sm">
                                <i class="fas fa-arrow-left mr-1"></i>Back to Login
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            @else
            <!-- Login Form -->
            <div class="glass-effect rounded-2xl shadow-2xl p-8">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 mb-4">
                        <i class="fas fa-sign-in-alt text-4xl text-white"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Sign In</h2>
                    <p class="text-gray-600 dark:text-gray-400">Enter your credentials to access your account</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    
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
                                class="input-field w-full pl-12 pr-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/20 dark:bg-gray-700 dark:text-white" 
                                placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm mt-2"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" 
                                class="h-5 w-5 text-primary focus:ring-primary border-gray-300 rounded cursor-pointer">
                            <label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                                Remember me
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                        <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                    </button>

                    <div class="text-center pt-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-gray-600 dark:text-gray-400">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-primary hover:text-purple-600 font-semibold transition">
                                Create Account
                            </a>
                        </p>
                    </div>
                </form>
            </div>
            @endif

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} SensorHub. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const codeInput = document.getElementById('verification_code');
    if (codeInput) {
        codeInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
        });
    }
</script>
@endpush
