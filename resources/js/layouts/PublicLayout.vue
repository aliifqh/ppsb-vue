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
    <div class="min-h-screen bg-gray-50">
        <!-- Navbar -->
        <div class="nav-wrapper">
            <nav ref="modernNav" class="modern-nav">
                <!-- Logo -->
                <div class="logo-container">
                    <Link href="/">
                        <img src="/img/logo-ppin.png" alt="Logo Al Mukmin" class="logo" loading="lazy">
                    </Link>
                </div>
                
                <!-- Navigation Menu -->
                <div class="nav-container">
                    <Link href="/formulir" class="nav-item" :class="{ 'active': $page.url === '/formulir' }">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                            <path d="M14 2v6h6"/>
                            <path d="M16 13H8"/>
                            <path d="M16 17H8"/>
                            <path d="M10 9H8"/>
                        </svg>
                        <span>Formulir</span>
                    </Link>
                    
                    <Link href="/santri/login" class="nav-item" :class="{ 'active': $page.url.startsWith('/santri') }">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 11l3 3L22 4"/>
                            <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
                        </svg>
                        <span>Cek Status</span>
                    </Link>
                    
                    <Link href="/login" class="nav-item login-desktop">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                            <polyline points="10 17 15 12 10 7"/>
                            <line x1="15" y1="12" x2="3" y2="12"/>
                        </svg>
                        <span>Login Admin</span>
                    </Link>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <main class="flex-1">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Tentang Kami -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900">Tentang Kami</h3>
                        <p class="text-gray-600 text-sm">Pondok Pesantren kami berkomitmen untuk memberikan pendidikan Islam berkualitas dan membentuk generasi yang berakhlak mulia.</p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-emerald-500">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-emerald-500">
                                <span class="sr-only">Instagram</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-emerald-500">
                                <span class="sr-only">YouTube</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Link Cepat -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900">Link Cepat</h3>
                        <ul class="space-y-2">
                            <li>
                                <Link href="/santri/login" class="text-gray-600 hover:text-emerald-500 text-sm">Cek Status</Link>
                            </li>
                        </ul>
                    </div>

                    <!-- Kontak -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900">Kontak</h3>
                        <ul class="space-y-2">
                            <li class="flex items-start space-x-3 text-sm">
                                <svg class="h-5 w-5 text-emerald-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="text-gray-600">Jl. Pondok Pesantren No. 123, Kota, Provinsi</span>
                            </li>
                            <li class="flex items-center space-x-3 text-sm">
                                <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <span class="text-gray-600">+62 813 2729 9927</span>
                            </li>
                            <li class="flex items-center space-x-3 text-sm">
                                <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-gray-600">almukminngruki@gmail.com</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Jam Operasional -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900">Jam Operasional</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li>Sabtu - Kamis: 08:00 - 16:00</li>
                            <li>Jumat: Tutup</li>
                        </ul>
                    </div>
                </div>

                <div class="mt-12 border-t border-gray-200 pt-8">
                    <p class="text-center text-sm text-gray-500">
                        &copy; {{ new Date().getFullYear() }} Pondok Pesantren Al-Mukmin Ngruki. Hak Cipta Dilindungi.
                    </p>
                </div>
            </div>
        </footer>
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
    height: 40px;
    width: auto;
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
    color: #059669;
}

.nav-item.active {
    background-color: #ecfdf5;
    color: #059669;
}

.nav-icon {
    width: 1.25rem;
    height: 1.25rem;
    flex-shrink: 0;
}

.login-desktop {
    background: linear-gradient(135deg, #059669, #10b981);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.login-desktop:hover {
    background: linear-gradient(135deg, #047857, #059669);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
}

@media (max-width: 1280px) {
    .login-desktop {
        display: none !important;
    }
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