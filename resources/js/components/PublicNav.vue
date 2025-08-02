<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';

// Navbar scroll effect
const modernNav = ref<HTMLElement | null>(null);

const handleScroll = () => {
    if (modernNav.value) {
        if (window.scrollY > 0) {
            modernNav.value.style.marginTop = '0';
        } else {
            modernNav.value.style.marginTop = '10px';
        }
    }
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
    <!-- Modern Navbar -->
    <div class="sticky top-0 z-50 bg-transparent p-0 transition-all duration-300 ease-out">
        <nav ref="modernNav" class="bg-white p-4 rounded-xl shadow-lg mx-auto max-w-7xl my-2.5 transition-all duration-300 ease-out flex flex-col gap-4 lg:flex-row lg:items-center lg:gap-8 lg:px-5 lg:my-4">
            <!-- Logo -->
            <div class="flex justify-center items-center h-16 lg:flex-shrink-0 lg:h-12 lg:mr-5">
                <Link href="/" class="block">
                    <img 
                        src="/img/logo-ppin.png" 
                        alt="Logo Al Mukmin" 
                        class="h-16 w-auto transition-all duration-300 ease-out hidden lg:h-12"
                        loading="lazy"
                        @load="($event.target as HTMLImageElement).style.display='block'"
                    >
                </Link>
            </div>
            
            <!-- Navigation Menu -->
            <div class="flex flex-row gap-2 w-full justify-start lg:gap-6 lg:justify-end">
                <Link 
                    href="/" 
                    class="flex-1 min-w-0 max-w-none flex items-center justify-center gap-3 px-2.5 py-2.5 text-sm text-[#2A6061] no-underline rounded-lg bg-[rgba(112,202,203,0.1)] border border-[rgba(112,202,203,0.2)] font-medium relative transition-all duration-300 ease-out hover:bg-[rgba(112,202,203,0.2)] hover:text-[#2A6061] hover:translate-y-[-1px] hover:border-[rgba(112,202,203,0.3)] lg:flex-none lg:min-w-40 lg:max-w-50 lg:mb-0 lg:px-6 lg:py-4 lg:text-base"
                    :class="{ 'bg-[#2A6061] text-white border-[#2A6061] shadow-lg': $page.url === '/' }"
                >
                    <svg class="w-4 h-4 transition-transform duration-300 ease-out flex-shrink-0 filter-[brightness(0)_saturate(100%)_invert(31%)_sepia(15%)_saturate(1234%)_hue-rotate(118deg)_brightness(94%)_contrast(87%)] hover:scale-110 lg:w-5 lg:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path d="M9 22V12h6v10"/>
                    </svg>
                    <span class="text-sm whitespace-nowrap overflow-hidden text-ellipsis font-medium">Beranda</span>
                </Link>
                
                <Link 
                    href="/formulir" 
                    class="flex-1 min-w-0 max-w-none flex items-center justify-center gap-3 px-2.5 py-2.5 text-sm text-[#2A6061] no-underline rounded-lg bg-[rgba(112,202,203,0.1)] border border-[rgba(112,202,203,0.2)] font-medium relative transition-all duration-300 ease-out hover:bg-[rgba(112,202,203,0.2)] hover:text-[#2A6061] hover:translate-y-[-1px] hover:border-[rgba(112,202,203,0.3)] lg:flex-none lg:min-w-40 lg:max-w-50 lg:mb-0 lg:px-6 lg:py-4 lg:text-base"
                    :class="{ 'bg-[#2A6061] text-white border-[#2A6061] shadow-lg': $page.url === '/formulir' }"
                >
                    <svg class="w-4 h-4 transition-transform duration-300 ease-out flex-shrink-0 filter-[brightness(0)_saturate(100%)_invert(31%)_sepia(15%)_saturate(1234%)_hue-rotate(118deg)_brightness(94%)_contrast(87%)] hover:scale-110 lg:w-5 lg:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                        <path d="M14 2v6h6"/>
                        <path d="M16 13H8"/>
                        <path d="M16 17H8"/>
                        <path d="M10 9H8"/>
                    </svg>
                    <span class="text-sm whitespace-nowrap overflow-hidden text-ellipsis font-medium">Formulir</span>
                </Link>
                
                <Link 
                    href="/santri/login" 
                    class="flex-1 min-w-0 max-w-none flex items-center justify-center gap-3 px-2.5 py-2.5 text-sm text-[#2A6061] no-underline rounded-lg bg-[rgba(112,202,203,0.1)] border border-[rgba(112,202,203,0.2)] font-medium relative transition-all duration-300 ease-out hover:bg-[rgba(112,202,203,0.2)] hover:text-[#2A6061] hover:translate-y-[-1px] hover:border-[rgba(112,202,203,0.3)] lg:flex-none lg:min-w-40 lg:max-w-50 lg:mb-0 lg:px-6 lg:py-4 lg:text-base"
                    :class="{ 'bg-[#2A6061] text-white border-[#2A6061] shadow-lg': $page.url.startsWith('/santri') }"
                >
                    <svg class="w-4 h-4 transition-transform duration-300 ease-out flex-shrink-0 filter-[brightness(0)_saturate(100%)_invert(31%)_sepia(15%)_saturate(1234%)_hue-rotate(118deg)_brightness(94%)_contrast(87%)] hover:scale-110 lg:w-5 lg:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 11l3 3L22 4"/>
                        <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
                    </svg>
                    <span class="text-sm whitespace-nowrap overflow-hidden text-ellipsis font-medium">Cek Status</span>
                </Link>
                
                <Link 
                    href="/login" 
                    class="hidden lg:flex flex-1 min-w-0 max-w-none items-center justify-center gap-3 px-6 py-4 text-[#2A6061] no-underline rounded-lg bg-[rgba(112,202,203,0.1)] border border-[rgba(112,202,203,0.2)] font-medium relative transition-all duration-300 ease-out hover:bg-[rgba(112,202,203,0.2)] hover:text-[#2A6061] hover:translate-y-[-1px] hover:border-[rgba(112,202,203,0.3)] lg:flex-none lg:min-w-40 lg:max-w-50 lg:mb-0 lg:text-base"
                >
                    <svg class="w-5 h-5 transition-transform duration-300 ease-out flex-shrink-0 filter-[brightness(0)_saturate(100%)_invert(31%)_sepia(15%)_saturate(1234%)_hue-rotate(118deg)_brightness(94%)_contrast(87%)] hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                    <span class="text-sm whitespace-nowrap overflow-hidden text-ellipsis font-medium">Login Admin</span>
                </Link>
            </div>
        </nav>
    </div>
</template>
