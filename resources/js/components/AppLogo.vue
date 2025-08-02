<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
</script>

<template>
    <div class="flex items-center gap-2">
        <!-- Transparent logo container -->
        <div class="flex aspect-square size-8 items-center justify-center">
            <AppLogoIcon class="size-10 fill-current text-emerald-400" />
        </div>
        
        <!-- Text container -->
        <div class="grid flex-1 text-left text-sm">
            <span class="mb-0.5 truncate leading-tight font-semibold text-gray-100">Al Mukmin Ngruki</span>
        </div>
    </div>
</template>
