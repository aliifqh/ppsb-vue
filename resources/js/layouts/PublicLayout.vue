<script setup lang="ts">
import PublicNav from '@/components/PublicNav.vue';
// import PublicFooter from '@/components/PublicFooter.vue';
</script>

<template>
    <div class="min-h-screen bg-white">
        <!-- Navigation -->
        <PublicNav />

        <!-- Main Content -->
        <main class="main-content">
            <slot />
        </main>

        <!-- Footer -->
        <!-- <PublicFooter /> -->
    </div>
</template>

<style scoped>
/* Main Content */
.main-content {
    margin-top: 20px;
    min-height: calc(100vh - 200px);
}
</style>
