<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Coffee, Heart, Zap, MessageCircle, Shield, Users, Smartphone } from 'lucide-vue-next';
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

const features = [
    { icon: MessageCircle, title: 'Auto Reply', description: 'Balasan otomatis yang cerdas', color: 'success' },
    { icon: Zap, title: 'Real-time', description: 'Notifikasi instan', color: 'info' },
    { icon: Heart, title: 'User Friendly', description: 'Interface yang mudah', color: 'primary' },
    { icon: Shield, title: 'Secure', description: 'Keamanan terjamin', color: 'warning' },
    { icon: Users, title: 'Multi User', description: 'Dukungan multi pengguna', color: 'secondary' },
    { icon: Smartphone, title: 'Mobile Ready', description: 'Responsif di semua device', color: 'danger' },
];
</script>

<template>
    <Head title="WhatsApp Integration - Coming Soon" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container-fluid py-4">
            <!-- Header Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6 d-flex align-items-center">
                                    <h6 class="mb-0">WhatsApp Integration</h6>
                                    <p class="text-secondary text-sm mb-0 ms-2">Fitur komunikasi terdepan</p>
                                </div>
                                <div class="col-6 text-end">
                                    <ArgonButton color="success" variant="gradient" size="sm">
                                        <MessageCircle class="me-2" />
                                        Coming Soon
                                    </ArgonButton>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <!-- WhatsApp Icon with Animation -->
                            <div class="mb-4">
                                <div class="d-inline-block position-relative">
                                    <div class="icon icon-shape icon-xl bg-gradient-success shadow text-center border-radius-xl mx-auto mb-3">
                                        <MessageCircle class="text-white opacity-10" style="font-size: 2rem;" />
                                    </div>
                                    <!-- Floating notification dots -->
                                    <div class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger">
                                        3
                                    </div>
                                </div>
                            </div>

                            <!-- Title Section -->
                            <div class="mb-4">
                                <h2 class="text-gradient text-primary mb-3">WhatsApp Integration</h2>
                                <p class="text-secondary mb-0">
                                    Fitur WhatsApp sedang dalam pengembangan intensif. 
                                    Kami berkomitmen memberikan pengalaman komunikasi terbaik untuk Anda.
                                </p>
                            </div>

                            <!-- Progress Section -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-sm text-secondary">
                                        <Zap class="me-1" />
                                        Development Progress
                                    </span>
                                    <span class="text-sm font-weight-bold">5%</span>
                                </div>
                                <ArgonProgress value="5" color="success" size="sm" />
                            </div>

                            <!-- Features Preview -->
                            <div class="row mb-4">
                                <div v-for="feature in features" :key="feature.title" class="col-md-4 col-lg-2 mb-3">
                                    <div class="card">
                                        <div class="card-body p-3 text-center">
                                            <div :class="`icon icon-shape icon-sm bg-gradient-${feature.color} shadow text-center border-radius-md mb-2`">
                                                <component :is="feature.icon" class="text-white opacity-10" />
                                            </div>
                                            <h6 class="text-dark text-sm font-weight-bold mb-1">{{ feature.title }}</h6>
                                            <p class="text-secondary text-xs mb-0">{{ feature.description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Coffee Section -->
                            <div class="card bg-gradient-warning">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center justify-content-center mb-3">
                                        <div class="position-relative">
                                            <div class="icon icon-shape icon-lg bg-gradient-warning shadow text-center border-radius-xl">
                                                <Coffee class="text-white opacity-10" style="font-size: 1.5rem;" />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <h6 class="text-dark mb-2">Support Developer</h6>
                                    <p class="text-secondary text-sm mb-3">
                                        Jika Anda menyukai fitur ini, pertimbangkan untuk membeli secangkir kopi untuk developer kami. 
                                        Setiap donasi membantu kami terus berinovasi! ☕
                                    </p>
                                    
                                    <div class="d-flex justify-content-center gap-2">
                                        <ArgonButton color="warning" variant="gradient" size="sm">
                                            <Coffee class="me-2" />
                                            Buy Me a Coffee
                                        </ArgonButton>
                                        <ArgonButton color="success" variant="gradient" size="sm">
                                            <Heart class="me-2" />
                                            Donate
                                        </ArgonButton>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="mt-4">
                                <p class="text-sm text-secondary mb-1">
                                    Dikembangkan dengan ❤️ oleh Aliifqh
                                </p>
                                <p class="text-xs text-secondary italic mb-0">
                                    "Kopi adalah bahasa universal developer. Setiap baris kode dibayar dengan secangkir kopi."
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.text-gradient {
    background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>
