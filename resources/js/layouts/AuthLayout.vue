<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AuthLayout from '@/layouts/auth/AuthCardLayout.vue';
import { useFixedTheme } from '@/composables/useAppearance';

// Force dark theme for auth layout
useFixedTheme('dark');

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <Head :title="title" />
    <AuthLayout :title="title" :description="description">
        <slot />
    </AuthLayout>
</template>
