<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

// Navbar scroll effect with glassmorphism
const modernNav = ref<HTMLElement | null>(null);
const isScrolled = ref(false);

const handleScroll = () => {
    if (modernNav.value) {
        const scrollY = window.scrollY;
        isScrolled.value = scrollY > 20;
        
        if (scrollY > 20) {
            modernNav.value.style.marginTop = '0';
            modernNav.value.style.backdropFilter = 'blur(20px)';
            modernNav.value.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
        } else {
            modernNav.value.style.marginTop = '16px';
            modernNav.value.style.backdropFilter = 'blur(10px)';
            modernNav.value.style.backgroundColor = 'rgba(255, 255, 255, 0.85)';
        }
    }
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
    // Initialize on mount
    handleScroll();
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});

// Get current page for active state
const page = usePage();
</script>

<template>
    <!-- Modern Glassmorphism Navbar -->
    <div class="sticky top-0 z-50 bg-transparent p-4 transition-all duration-500 ease-out">
        <nav 
            ref="modernNav" 
            class="bg-transparent backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl mx-auto max-w-7xl transition-all duration-500 ease-out"
            :class="{
                'shadow-2xl backdrop-blur-2xl border-white/20': isScrolled,
                'shadow-xl backdrop-blur-xl border-white/10': !isScrolled
            }"
        >
            <!-- Desktop Layout -->
            <div class="hidden lg:flex items-center justify-between px-8 py-4">
                <!-- Logo Section -->
                <div class="flex items-center space-x-8">
                    <Link href="/" class="flex items-center space-x-3 group">
                        <div class="relative">
                            <img 
                                src="/img/logo-ppin.png" 
                                alt="Logo PPIN" 
                                class="h-12 w-auto transition-all duration-300 group-hover:scale-105"
                                loading="lazy"
                            >
                            <div class="absolute inset-0 bg-gradient-to-r from-[#2A6061]/20 to-[#70CACB]/20 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                    </Link>
                </div>

                <!-- Desktop Navigation -->
                <div class="flex items-center space-x-2">
                    <Link 
                        href="/" 
                        class="flex items-center space-x-2 px-6 py-3 text-[#2A6061] font-medium rounded-xl transition-all duration-300 hover:bg-[#2A6061] hover:text-white hover:shadow-lg hover:-translate-y-0.5"
                        :class="{ 'bg-[#2A6061] text-white shadow-lg': page.url === '/' }"
                    >
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path d="M9 22V12h6v10"/>
                        </svg>
                        <span>Beranda</span>
                    </Link>
                    
                    <Link 
                        href="/formulir" 
                        class="flex items-center space-x-2 px-6 py-3 text-[#2A6061] font-medium rounded-xl transition-all duration-300 hover:bg-[#2A6061] hover:text-white hover:shadow-lg hover:-translate-y-0.5"
                        :class="{ 'bg-[#2A6061] text-white shadow-lg': page.url === '/formulir' }"
                    >
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                            <path d="M14 2v6h6"/>
                            <path d="M16 13H8"/>
                            <path d="M16 17H8"/>
                            <path d="M10 9H8"/>
                        </svg>
                        <span>Formulir</span>
                    </Link>
                    
                    <Link 
                        href="/santri/login" 
                        class="flex items-center space-x-2 px-6 py-3 text-[#2A6061] font-medium rounded-xl transition-all duration-300 hover:bg-[#2A6061] hover:text-white hover:shadow-lg hover:-translate-y-0.5"
                        :class="{ 'bg-[#2A6061] text-white shadow-lg': page.url.startsWith('/santri') }"
                    >
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 11l3 3L22 4"/>
                            <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
                        </svg>
                        <span>Cek Status</span>
                    </Link>
                    
                    <div class="w-px h-8 bg-gray-300 mx-2"></div>
                    
                    <Link 
                        href="/login" 
                        class="flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-[#2A6061] to-[#70CACB] text-white font-medium rounded-xl transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 hover:from-[#70CACB] hover:to-[#2A6061]"
                    >
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                            <polyline points="10 17 15 12 10 7"/>
                            <line x1="15" y1="12" x2="3" y2="12"/>
                        </svg>
                        <span>Login Admin</span>
                    </Link>
                </div>
            </div>

            <!-- Mobile Layout (Responsive with Labels) -->
            <div class="lg:hidden px-2 py-3">
                <div class="flex items-center justify-between">
                    <!-- Logo Section -->
                    <div class="flex items-center">
                        <Link href="/" class="flex items-center space-x-2 group">
                            <div class="relative">
                                <img 
                                    src="/img/logo-ppin.png" 
                                    alt="Logo PPIN" 
                                    class="h-8 w-auto sm:h-10 transition-all duration-300 group-hover:scale-105 xs:hidden"
                                    loading="lazy"
                                >
                                <div class="absolute inset-0 bg-gradient-to-r from-[#2A6061]/20 to-[#70CACB]/20 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                        </Link>
                    </div>
                    
                    <!-- Mobile Navigation Menu -->
                    <div class="flex items-center space-x-1 sm:space-x-2">
                        <Link 
                            href="/" 
                            class="flex flex-col items-center justify-center w-16 h-14 sm:w-18 sm:h-16 text-[#2A6061] font-medium rounded-lg transition-all duration-300 hover:bg-[#2A6061] hover:text-white hover:shadow-lg hover:-translate-y-0.5"
                            :class="{ 'bg-[#2A6061] text-white shadow-lg': page.url === '/' }"
                        >
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path d="M9 22V12h6v10"/>
                            </svg>
                            <span class="text-xs font-medium mt-1 whitespace-nowrap">Beranda</span>
                        </Link>
                        
                        <Link 
                            href="/formulir" 
                            class="flex flex-col items-center justify-center w-16 h-14 sm:w-18 sm:h-16 text-[#2A6061] font-medium rounded-lg transition-all duration-300 hover:bg-[#2A6061] hover:text-white hover:shadow-lg hover:-translate-y-0.5"
                            :class="{ 'bg-[#2A6061] text-white shadow-lg': page.url === '/formulir' }"
                        >
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                                <path d="M14 2v6h6"/>
                                <path d="M16 13H8"/>
                                <path d="M16 17H8"/>
                                <path d="M10 9H8"/>
                            </svg>
                            <span class="text-xs font-medium mt-1 whitespace-nowrap">Formulir</span>
                        </Link>
                        
                        <Link 
                            href="/santri/login" 
                            class="flex flex-col items-center justify-center w-16 h-14 sm:w-18 sm:h-16 text-[#2A6061] font-medium rounded-lg transition-all duration-300 hover:bg-[#2A6061] hover:text-white hover:shadow-lg hover:-translate-y-0.5"
                            :class="{ 'bg-[#2A6061] text-white shadow-lg': page.url.startsWith('/santri') }"
                        >
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 11l3 3L22 4"/>
                                <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
                            </svg>
                            <span class="text-xs font-medium mt-1 whitespace-nowrap">Cek Status</span>
                        </Link>
                        
                        <div class="w-px h-10 sm:h-12 bg-gray-300 mx-1 sm:mx-2"></div>
                        
                        <Link 
                            href="/login" 
                            class="flex flex-col items-center justify-center w-16 h-14 sm:w-18 sm:h-16 bg-gradient-to-r from-[#2A6061] to-[#70CACB] text-white font-medium rounded-lg transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 hover:from-[#70CACB] hover:to-[#2A6061]"
                        >
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                                <polyline points="10 17 15 12 10 7"/>
                                <line x1="15" y1="12" x2="3" y2="12"/>
                            </svg>
                            <span class="text-xs font-medium mt-1 whitespace-nowrap">Login</span>
                        </Link>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</template>
