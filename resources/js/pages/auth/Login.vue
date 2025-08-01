<script setup lang="ts">
import {
    Link,
    useForm
} from '@inertiajs/vue3';
import AuthLayout from '@/layouts/AuthLayout.vue';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AuthLayout 
        title="Welcome back" 
        description="Enter your credentials to access your account"
    >
        <form @submit.prevent="submit" class="space-y-6">
            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                    Email
                </label>
                <input id="email" v-model="form.email" type="email"
                    class="w-full px-4 py-3 bg-white/50 dark:bg-white/10 border border-gray-200 dark:border-white/20 rounded-lg text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all duration-200"
                    placeholder="Your email address" required autofocus autocomplete="username">
                <div v-if="form.errors.email" class="mt-1 text-sm text-red-600 dark:text-red-400">
                    {{ form.errors.email }}
                </div>
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                    Password
                </label>
                <input id="password" v-model="form.password" type="password"
                    class="w-full px-4 py-3 bg-white/50 dark:bg-white/10 border border-gray-200 dark:border-white/20 rounded-lg text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all duration-200"
                    placeholder="Enter your password" required autocomplete="current-password">
                <div v-if="form.errors.password" class="mt-1 text-sm text-red-600 dark:text-red-400">
                    {{ form.errors.password }}
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input v-model="form.remember" type="checkbox"
                        class="w-4 h-4 text-blue-600 bg-white/50 dark:bg-white/10 border-gray-300 dark:border-white/20 rounded focus:ring-blue-500 focus:ring-2">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Remember me</span>
                </label>
                <Link v-if="route().has('password.request')" :href="route('password.request')"
                    class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 transition-colors duration-200">
                Forgot password?
                </Link>
            </div>

            <!-- Submit Button -->
            <button type="submit" :disabled="form.processing"
                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-transparent disabled:opacity-50 disabled:cursor-not-allowed shadow-lg">
                <span v-if="form.processing" class="flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Signing in...
                </span>
                <span v-else>Continue</span>
            </button>

            <!-- Divider -->
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300 dark:border-white/20"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white/70 dark:bg-transparent text-gray-500 dark:text-gray-400">OR</span>
                </div>
            </div>

            <!-- Social Login Buttons -->
            <div class="space-y-3">
                <button type="button"
                    class="w-full flex items-center justify-center px-4 py-3 bg-white/50 dark:bg-white/10 border border-gray-200 dark:border-white/20 rounded-lg text-gray-700 dark:text-white hover:bg-white/70 dark:hover:bg-white/20 transition-all duration-200 backdrop-blur-sm">
                    <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="currentColor"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="currentColor"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                        <path fill="currentColor"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                    Continue with Google
                </button>
            </div>

            <!-- Sign Up Link -->
            <div class="text-center">
                <p class="text-gray-600 dark:text-gray-300 text-sm">
                    Don't have an account?
                    <Link :href="route('register')"
                        class="text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 font-medium transition-colors duration-200">
                    Sign up
                    </Link>
                </p>
            </div>
        </form>

        <!-- Error Messages -->
        <div v-if="form.errors.email || form.errors.password"
            class="mt-4 p-4 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 rounded-lg backdrop-blur-sm">
            <div class="text-red-600 dark:text-red-400 text-sm">
                <div v-if="form.errors.email">{{ form.errors.email }}</div>
                <div v-if="form.errors.password">{{ form.errors.password }}</div>
            </div>
        </div>
    </AuthLayout>
</template>
