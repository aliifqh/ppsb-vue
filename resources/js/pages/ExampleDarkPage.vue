<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { useFixedTheme } from '@/composables/useAppearance';

// Force dark theme for this page
useFixedTheme('dark');
</script>

<template>
    <Head title="Example Dark Page" />
    
    <div class="min-h-screen bg-gray-900 text-white p-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl font-bold mb-6">Halaman Contoh Dark Theme</h1>
            <p class="text-gray-300 mb-8">
                Halaman ini selalu menggunakan tema dark, tidak peduli preferensi tema user.
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-800 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4">Card 1</h2>
                    <p class="text-gray-400">
                        Ini adalah contoh card dengan tema dark yang tetap.
                    </p>
                </div>
                
                <div class="bg-gray-800 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4">Card 2</h2>
                    <p class="text-gray-400">
                        Card ini juga menggunakan tema dark yang konsisten.
                    </p>
                </div>
            </div>
            
            <div class="mt-8">
                <a href="/" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</template> 