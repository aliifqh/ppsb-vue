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
    <div class="min-h-screen bg-white">
        <!-- Modern Navbar -->
        <div class="nav-wrapper">
            <nav ref="modernNav" class="modern-nav">
                <!-- Logo -->
                <div class="logo-container">
                    <Link href="/">
                        <img 
                            src="/img/logo-ppin.png" 
                            alt="Logo Al Mukmin" 
                            class="logo"
                            loading="lazy"
                            @load="($event.target as HTMLImageElement).style.display='block'"
                        >
                    </Link>
                </div>
                
                <!-- Navigation Menu -->
                <div class="nav-container">
                    <Link href="/" class="nav-item" :class="{ 'active': $page.url === '/' }">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path d="M9 22V12h6v10"/>
                        </svg>
                        <span>Beranda</span>
                    </Link>
                    
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
        <main class="main-content">
            <slot />
        </main>

        <!-- Modern Footer -->
        <footer class="modern-footer">
            <div class="footer-container">
                <!-- Accreditation Section -->
                <div class="footer-section">
                    <h3 class="footer-title">Akreditasi</h3>
                    <div class="accreditation">
                        <div class="stars">
                            <svg class="star" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg class="star" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg class="star" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg class="star" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg class="star" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                        <div class="accreditation-badge">
                            <span class="badge-text">A</span>
                        </div>
                    </div>
                </div>

                <!-- Share Section -->
                <div class="footer-section">
                    <h3 class="footer-title">Share</h3>
                    <div class="social-links">
                        <a href="#" class="social-link tiktok">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link instagram">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link facebook">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link telegram">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link youtube">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
/* Navbar Styles (Optimized for navbar.blade.php) */
.nav-wrapper {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: transparent;
    padding: 0;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.modern-nav {
    background: #fff;
    padding: 1rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
    display: flex;
    flex-direction: column;
    gap: 15px;
    max-width: 1280px;
    margin: 10px auto;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.logo-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 60px;
}

.logo {
    height: 60px;
    width: auto;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    display: none;
}

.logo[style*="display: block"] {
    display: block !important;
}

.nav-container {
    display: flex;
    flex-direction: row;
    gap: 1.5rem;
    width: 100%;
    justify-content: flex-end;
}

.nav-item {
    flex: 1 1 0%;
    min-width: 0;
    max-width: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 1rem 1.5rem;
    color: #2A6061;
    text-decoration: none;
    border-radius: 8px;
    background: rgba(112, 202, 203, 0.1);
    border: 1px solid rgba(112, 202, 203, 0.2);
    font-weight: 500;
    position: relative;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.nav-item:hover {
    background: rgba(112, 202, 203, 0.2);
    color: #2A6061;
    transform: translateY(-1px);
    border-color: rgba(112, 202, 203, 0.3);
}

.nav-item.active {
    background: #2A6061;
    color: #fff;
    border-color: #2A6061;
    box-shadow: 0 4px 12px rgba(42, 96, 97, 0.2);
}

.nav-item.active .nav-icon {
    filter: brightness(0) invert(1);
}

.nav-icon {
    width: 20px;
    height: 20px;
    transition: transform 0.3s ease;
    flex-shrink: 0;
    filter: brightness(0) saturate(100%) invert(31%) sepia(15%) saturate(1234%) hue-rotate(118deg) brightness(94%) contrast(87%);
}

.nav-item:hover .nav-icon {
    transform: scale(1.1);
}

.nav-item span {
    font-size: 0.95rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-weight: 500;
}

/* Login hanya di desktop */
@media (max-width: 916px) {
    .login-desktop {
        display: none !important;
    }
    .nav-container {
        flex-direction: row !important;
        gap: 0.5rem;
        justify-content: flex-start;
        width: 100%;
    }
    .nav-item {
        margin-bottom: 0;
        padding: 0.6rem 0.7rem;
        font-size: 0.9rem;
        flex: 1 1 0%;
        min-width: 0;
        max-width: none;
    }
    .nav-icon {
        width: 16px;
        height: 16px;
    }
    .logo-container {
        height: 45px;
    }
    .logo {
        height: 45px;
    }
}

@media (min-width: 917px) {
    .login-desktop {
        display: flex !important;
    }
    .modern-nav {
        flex-direction: row;
        align-items: center;
        gap: 30px;
        padding: 1.25rem;
        margin: 15px auto;
    }
    .logo-container {
        flex-shrink: 0;
        height: 50px;
        margin-right: 20px;
    }
    .logo {
        height: 50px;
    }
    .nav-container {
        flex-direction: row;
        justify-content: flex-end;
        gap: 1.5rem;
        width: 100%;
    }
    .nav-item {
        flex: 0 1 auto;
        min-width: 160px;
        max-width: 200px;
        margin-bottom: 0;
        padding: 1rem 1.5rem;
        font-size: 1rem;
    }
    .nav-icon {
        width: 20px;
        height: 20px;
    }
}

/* Main Content */
.main-content {
    margin-top: 20px;
    min-height: calc(100vh - 200px);
}

/* Modern Footer */
.modern-footer {
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
    border-top: 1px solid #e2e8f0;
    padding: 2rem 0;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.footer-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
}

.footer-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #374151;
    margin: 0;
}

/* Accreditation */
.accreditation {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stars {
    display: flex;
    gap: 2px;
}

.star {
    width: 20px;
    height: 20px;
    color: #fbbf24;
}

.accreditation-badge {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(251, 191, 36, 0.3);
}

.badge-text {
    color: #1a1a1a;
    font-weight: 700;
    font-size: 1.1rem;
}

/* Social Links */
.social-links {
    display: flex;
    gap: 1rem;
}

.social-link {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    text-decoration: none;
}

.social-link svg {
    width: 20px;
    height: 20px;
}

.social-link.tiktok {
    background: #000000;
    color: #ffffff;
}

.social-link.instagram {
    background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
    color: #ffffff;
}

.social-link.facebook {
    background: #1877f2;
    color: #ffffff;
}

.social-link.telegram {
    background: #0088cc;
    color: #ffffff;
}

.social-link.youtube {
    background: #ff0000;
    color: #ffffff;
}

.social-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Responsive Footer */
@media (max-width: 768px) {
    .footer-container {
        flex-direction: column;
        gap: 2rem;
    }
}
</style> 