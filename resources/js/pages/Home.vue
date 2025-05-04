<script setup lang="ts">
import Welcome from '@/pages/Welcome.vue';
import HomeFeed from '@/components/HomeFeed.vue';

defineOptions({
    layout: Welcome,
})
</script>

<template>
    <HomeFeed />
</template>
