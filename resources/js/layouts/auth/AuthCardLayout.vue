<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <!-- Background with Animated Blobs -->
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 flex items-center justify-center p-6 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute top-40 left-40 w-80 h-80 bg-pink-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
        </div>

        <!-- Main Content -->
        <div class="relative z-10 w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-8">
                <Link :href="route('home')" class="inline-flex items-center gap-2 font-medium">
                    <div class="flex h-16 w-auto items-center justify-center">
                        <img 
                            src="/img/LOGO-NGRUKI-PPIN-PUTIH.png" 
                            alt="Logo PPIN Ngruki" 
                            class="h-16 w-auto"
                            loading="lazy"
                        />
                    </div>
                </Link>
            </div>

            <!-- Auth Card -->
            <div class="bg-white/70 dark:bg-white/10 backdrop-blur-xl rounded-2xl border border-white/30 dark:border-white/20 shadow-2xl p-8">
                <!-- Header -->
                <div class="text-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ title }}</h1>
                    <p class="text-gray-600 dark:text-gray-300">{{ description }}</p>
                </div>

                <!-- Content -->
                <div class="space-y-6">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Animated blob background */
@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

/* Glassmorphism effects */
.backdrop-blur-xl {
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
}
</style>
