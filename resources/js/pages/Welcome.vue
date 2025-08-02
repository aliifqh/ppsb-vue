<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { Coffee, Heart } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

// Animated text effect
const animatedText = ref('Coming Soon');
const isTyping = ref(true);

onMounted(() => {
    const text = 'Coming Soon';
    let index = 0;
    
    const typeWriter = () => {
        if (index < text.length) {
            animatedText.value = text.substring(0, index + 1);
            index++;
            setTimeout(typeWriter, 150);
        } else {
            setTimeout(() => {
                isTyping.value = false;
                setTimeout(() => {
                    isTyping.value = true;
                    index = 0;
                    animatedText.value = '';
                    typeWriter();
                }, 2000);
            }, 1000);
        }
    };
    
    typeWriter();
});
</script>

<template>
    <PublicLayout>
        <Head title="Coming Soon - Website dalam Pembuatan">
            <link rel="preconnect" href="https://rsms.me/" />
            <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        </Head>
        
        <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 flex items-center justify-center p-6">
            <!-- Background Pattern -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
                <div class="absolute top-40 left-40 w-80 h-80 bg-pink-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
            </div>

            <!-- Main Content -->
            <div class="relative z-10 text-center max-w-4xl mx-auto">
                <!-- Logo/Brand -->
                <div class="mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl shadow-lg mb-6">
                        <span class="text-2xl font-bold text-white">🚀</span>
                    </div>
                    <h1 class="text-4xl md:text-6xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-4">
                        PPSB Al-Mukmin Ngruki
                    </h1>
                </div>

                <!-- Animated Coming Soon Text -->
                <div class="mb-8">
                    <h2 class="text-3xl md:text-5xl font-bold text-gray-800 dark:text-white mb-4">
                        <span class="inline-block min-w-[300px] text-left">
                            {{ animatedText }}<span v-if="isTyping" class="animate-pulse">|</span>
                        </span>
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto leading-relaxed">
                        Website kami sedang dalam tahap pengembangan yang serius. 
                        Tim developer kami sedang bekerja keras untuk memberikan pengalaman terbaik untuk Anda.
                    </p>
                </div>

                <!-- Formulir Pendaftaran Button -->
                <div class="mb-8">
                    <a 
                        href="/formulir" 
                        class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-teal-500 to-blue-600 text-white text-lg font-semibold rounded-xl hover:from-teal-600 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1"
                    >
                        <span class="mr-2">📝</span>
                        Daftar Sekarang
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>

                <!-- Progress Bar -->
                <div class="mb-12 max-w-md mx-auto">
                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                        <span>Progress Development</span>
                        <span>60%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-3 rounded-full transition-all duration-1000 ease-out" style="width: 60%"></div>
                    </div>
                </div>

                <!-- Features Preview -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 max-w-4xl mx-auto">
                    <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mb-4 mx-auto">
                            <span class="text-2xl">⚡</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 dark:text-white mb-2">Super Fast</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Website yang cepat dan responsif untuk pengalaman terbaik</p>
                    </div>
                    
                    <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mb-4 mx-auto">
                            <span class="text-2xl">🎨</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 dark:text-white mb-2">Modern Design</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Desain modern dan elegan yang memukau</p>
                    </div>
                    
                    <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-white/20">
                        <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900/30 rounded-lg flex items-center justify-center mb-4 mx-auto">
                            <span class="text-2xl">🔒</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 dark:text-white mb-2">Secure</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Keamanan tingkat tinggi untuk data Anda</p>
                    </div>
                </div>

                <!-- Developer Credit -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl p-8 shadow-xl border border-white/20 max-w-2xl mx-auto mb-8">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-4">
                            <span class="text-2xl font-bold text-white">A</span>
                        </div>
                        <div class="text-left">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">Aliifqh</h3>
                            <p class="text-gray-600 dark:text-gray-400">Full Stack Developer</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-center mb-6">
                        "Membangun website yang luar biasa membutuhkan dedikasi, kreativitas, dan secangkir kopi yang tak terhitung jumlahnya. 
                        Stay tuned untuk sesuatu yang spektakuler! ✨"
                    </p>
                    
                    <!-- Social Links -->
                    <div class="flex justify-center space-x-4">
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

            <!-- Floating Elements -->
            <div class="absolute top-20 left-20 animate-bounce">
                <div class="w-4 h-4 bg-blue-400 rounded-full opacity-60"></div>
            </div>
            <div class="absolute bottom-20 right-20 animate-bounce animation-delay-1000">
                <div class="w-6 h-6 bg-purple-400 rounded-full opacity-60"></div>
            </div>
            <div class="absolute top-1/2 left-10 animate-pulse">
                <div class="w-3 h-3 bg-pink-400 rounded-full opacity-60"></div>
            </div>
        </div>
    </PublicLayout>
</template>

<style scoped>
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

.animation-delay-1000 {
    animation-delay: 1s;
}
</style>
