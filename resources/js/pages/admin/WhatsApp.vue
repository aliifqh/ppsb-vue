<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Coffee, Heart, Zap, MessageCircle } from 'lucide-vue-next';
import { ref, onMounted } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'WhatsApp',
        href: '/whatsapp',
    },
];

// Animated coffee cup
const coffeeLevel = ref(0);
const isPouring = ref(false);

onMounted(() => {
    const animateCoffee = () => {
        isPouring.value = true;
        const interval = setInterval(() => {
            coffeeLevel.value += 1;
            if (coffeeLevel.value >= 100) {
                clearInterval(interval);
                isPouring.value = false;
                setTimeout(() => {
                    coffeeLevel.value = 0;
                    animateCoffee();
                }, 3000);
            }
        }, 50);
    };
    
    animateCoffee();
});
</script>

<template>
    <Head title="WhatsApp Integration - Coming Soon" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-[70vh] flex items-center justify-center p-6">
            <!-- Background Pattern -->
            <div class="absolute inset-0 overflow-hidden opacity-5">
                <div class="absolute top-20 left-20 w-32 h-32 bg-green-400 rounded-full mix-blend-multiply filter blur-xl animate-pulse"></div>
                <div class="absolute bottom-20 right-20 w-40 h-40 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl animate-pulse animation-delay-2000"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-24 h-24 bg-purple-400 rounded-full mix-blend-multiply filter blur-xl animate-pulse animation-delay-4000"></div>
            </div>

            <!-- Main Content -->
            <div class="relative z-10 text-center max-w-2xl mx-auto">
                <!-- WhatsApp Icon with Animation -->
                <div class="mb-8 relative">
                    <div class="relative inline-block">
                        <div class="w-24 h-24 bg-gradient-to-br from-green-400 to-green-600 rounded-3xl shadow-2xl flex items-center justify-center mb-4 mx-auto transform hover:scale-110 transition-transform duration-300">
                            <MessageCircle class="w-12 h-12 text-white" />
                        </div>
                        <!-- Floating notification dots -->
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full animate-bounce flex items-center justify-center">
                            <span class="text-xs text-white font-bold">3</span>
                        </div>
                    </div>
                </div>

                <!-- Title Section -->
                <div class="mb-8">
                    <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent mb-4">
                        WhatsApp Integration
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 leading-relaxed">
                        Fitur WhatsApp sedang dalam pengembangan intensif. 
                        Kami berkomitmen memberikan pengalaman komunikasi terbaik untuk Anda.
                    </p>
                </div>

                <!-- Progress Section -->
                <div class="mb-8 max-w-md mx-auto">
                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-3">
                        <span class="flex items-center">
                            <Zap class="w-4 h-4 mr-2 text-yellow-500" />
                            Development Progress
                        </span>
                        <span class="font-semibold">5%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-blue-500 h-2 rounded-full transition-all duration-2000 ease-out relative" style="width: 5%">
                            <div class="absolute inset-0 bg-white opacity-30 animate-pulse"></div>
                        </div>
                    </div>
                </div>

                <!-- Features Preview -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-xl p-4 shadow-lg border border-white/20">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mb-3 mx-auto">
                            <MessageCircle class="w-5 h-5 text-green-600" />
                        </div>
                        <h3 class="font-semibold text-gray-800 dark:text-white text-sm mb-1">Auto Reply</h3>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Balasan otomatis yang cerdas</p>
                    </div>
                    
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-xl p-4 shadow-lg border border-white/20">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mb-3 mx-auto">
                            <Zap class="w-5 h-5 text-blue-600" />
                        </div>
                        <h3 class="font-semibold text-gray-800 dark:text-white text-sm mb-1">Real-time</h3>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Notifikasi instan</p>
                    </div>
                    
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-xl p-4 shadow-lg border border-white/20">
                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mb-3 mx-auto">
                            <Heart class="w-5 h-5 text-purple-600" />
                        </div>
                        <h3 class="font-semibold text-gray-800 dark:text-white text-sm mb-1">User Friendly</h3>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Interface yang mudah</p>
                    </div>
                </div>

                <!-- Coffee Section -->
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-2xl p-6 shadow-lg border border-amber-200/50 dark:border-amber-700/30">
                    <div class="flex items-center justify-center mb-4">
                        <div class="relative">
                            <div class="w-16 h-16 bg-gradient-to-br from-amber-600 to-orange-600 rounded-full flex items-center justify-center shadow-lg">
                                <Coffee class="w-8 h-8 text-white" />
                            </div>
                            <!-- Coffee steam animation -->
                            <div class="absolute -top-2 -left-1 w-2 h-4 bg-amber-300 rounded-full opacity-60 animate-pulse"></div>
                            <div class="absolute -top-1 -right-1 w-1.5 h-3 bg-amber-300 rounded-full opacity-60 animate-pulse animation-delay-500"></div>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">
                        Support Developer
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">
                        Jika Anda menyukai fitur ini, pertimbangkan untuk membeli secangkir kopi untuk developer kami. 
                        Setiap donasi membantu kami terus berinovasi! ☕
                    </p>
                    
                    <div class="flex justify-center space-x-3">
                        <a href="https://wa.me/6285888100108" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-lg hover:from-amber-600 hover:to-orange-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <Coffee class="w-4 h-4 mr-2" />
                            Buy Me a Coffee
                        </a>
                        <a href="https://wa.me/6285888100108" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-blue-500 text-white rounded-lg hover:from-green-600 hover:to-blue-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <Heart class="w-4 h-4 mr-2" />
                            Donate
                        </a>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                        Dikembangkan dengan ❤️ oleh Aliifqh
                    </p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 italic">
                        "Kopi adalah bahasa universal developer. Setiap baris kode dibayar dengan secangkir kopi." 
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
@keyframes pulse {
    0%, 100% {
        opacity: 0.6;
        transform: scale(1);
    }
    50% {
        opacity: 1;
        transform: scale(1.1);
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

.animation-delay-500 {
    animation-delay: 0.5s;
}
</style>
