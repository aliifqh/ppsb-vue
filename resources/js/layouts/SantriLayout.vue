<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

// Props untuk menerima data santri dari parent component
interface Props {
    santri?: any;
    isLoggedIn?: boolean;
}

withDefaults(defineProps<Props>(), {
    santri: null,
    isLoggedIn: false
});
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Navbar Santri -->
        <div class="nav-wrapper">
            <nav class="modern-nav">
                <!-- Logo -->
                <div class="logo-container">
                    <Link href="/">
                        <img src="/img/LOGO-PPIN-NGRUKI.png"
                             alt="Logo PPIN Ngruki"
                             class="logo"
                             width="36"
                             height="36"
                             loading="lazy"
                             decoding="async">
                    </Link>
                </div>
                
                <!-- Navigation Menu -->
                <div class="nav-container">
                    <template v-if="isLoggedIn && santri">
                        <Link :href="`/santri/dashboard/${santri.nomor_pendaftaran}`" 
                              class="nav-item" 
                              :class="{ 'active': $page.url.includes('/santri/dashboard') }">
                            <svg class="nav-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path d="M9 22V12h6v10"/>
                            </svg>
                            <span>Beranda</span>
                        </Link>
                        
                        <Link :href="`/santri/pembayaran/${santri.nomor_pendaftaran}`" 
                              class="nav-item" 
                              :class="{ 'active': $page.url.includes('/santri/pembayaran') }">
                            <svg class="nav-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M2 6h20v12H2z"/>
                                <path d="M12 10c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                                <path d="M6 10v4M18 10v4"/>
                            </svg>
                            <span>Pembayaran</span>
                        </Link>
                        
                        <Link :href="`/santri/ujian/${santri.nomor_pendaftaran}`" 
                              class="nav-item" 
                              :class="{ 'active': $page.url.includes('/santri/ujian') }">
                            <svg class="nav-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span>Ujian</span>
                        </Link>
                        
                        <Link :href="`/santri/data/${santri.nomor_pendaftaran}`" 
                              class="nav-item" 
                              :class="{ 'active': $page.url.includes('/santri/data') }">
                            <svg class="nav-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>Data</span>
                        </Link>
                    </template>
                    
                    <template v-else>
                        <Link href="/santri/login" 
                              class="nav-item" 
                              :class="{ 'active': $page.url.includes('/santri/login') }">
                            <svg class="nav-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 11l3 3L22 4"/>
                                <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
                            </svg>
                            <span>Login Santri</span>
                        </Link>
                    </template>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <main class="flex-1">
            <slot />
        </main>

        <!-- Footer Santri -->
        <div class="mt-8 border-t border-gray-200 pt-6">
            <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                <div class="flex items-center space-x-4">
                    <template v-if="$page.url.includes('/santri/login')">
                        <Link href="/" class="text-teal-600 hover:text-teal-500">
                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali ke Beranda
                        </Link>
                    </template>
                    
                    <template v-else-if="isLoggedIn && santri">
                        <Link href="/" class="text-teal-600 hover:text-teal-500">
                            Kembali ke Beranda
                        </Link>
                    </template>
                    
                    <template v-else>
                        <Link :href="`/santri/dashboard/${santri?.nomor_pendaftaran}`" class="text-teal-600 hover:text-teal-500">
                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali ke Dashboard
                        </Link>
                    </template>
                </div>
                
                <template v-if="isLoggedIn && santri">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-teal-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-sm text-gray-700">{{ santri.nama }}</span>
                        </div>
                        
                        <form :action="`/santri/logout`" method="POST" class="d-inline">
                            <input type="hidden" name="_token" :value="$page.props.csrf_token">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-gradient-to-r from-teal-600 to-teal-500 hover:from-teal-700 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<style scoped>
.nav-wrapper {
    position: sticky;
    top: 0;
    z-index: 50;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(229, 231, 235, 0.5);
}

.modern-nav {
    max-width: 1280px;
    margin: 10px auto 0;
    padding: 0 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: margin-top 0.3s ease;
}

.logo-container {
    flex-shrink: 0;
}

.logo {
    height: 36px;
    width: 36px;
    display: none;
}

.logo[loaded] {
    display: block;
}

.nav-container {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    text-decoration: none;
    color: #374151;
    font-weight: 500;
    transition: all 0.2s ease;
}

.nav-item:hover {
    background-color: #f3f4f6;
    color: #0d9488;
}

.nav-item.active {
    background-color: #f0fdfa;
    color: #0d9488;
}

.nav-icon {
    width: 1.25rem;
    height: 1.25rem;
    flex-shrink: 0;
}

@media (max-width: 768px) {
    .nav-container {
        gap: 0.5rem;
    }
    
    .nav-item {
        padding: 0.5rem;
    }
    
    .nav-item span {
        display: none;
    }
}
</style> 