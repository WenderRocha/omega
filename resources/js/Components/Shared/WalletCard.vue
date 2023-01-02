<template>
    <div>
        <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <h5 class="mb-2 text-1xl font-bold leading-tight text-gray-900 dark:text-white">{{ title }}</h5>
            <h5 class="mb-2 text-1xl font-bold tracking-tight text-gray-900 dark:text-white">{{ value }}</h5>
        </a>
    </div>
</template>

<script setup>
import Button from '@/Components/Button.vue'

const props = defineProps({
    title: String,
    value: String|Number
})
</script>

<style scoped>

</style>
