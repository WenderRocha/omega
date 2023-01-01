<template>
    <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">

        <div class="flex flex-col items-center pb-10 pt-4">
            <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="/img/undraw_credit_card.png" :alt="name" :title="name"/>
            <h5 class="mb-1 text-md font-bold text-gray-900 dark:text-white">{{ name  }}</h5>
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ (type) ? 'Opções Binarias' : 'Carteira' }}</span>
            <div class="flex flex-col items-center mt-4">
                <span v-show="isMain" class="text-sm text-gray-500 dark:text-gray-400">Principal</span>
                <div class="mt-3">
                            <span class="bg-blue-100 text-blue-800 text-sm font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800" title="Saldo inicial">
                                 R$ {{ initialBalance.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'}) }}
                            </span>
                    <span class="bg-yellow-100 text-yellow-800 text-sm font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-200 dark:text-yellow-900" title="Lucro / Prejuizo">
                               + R$ 00,00
                            </span>
                    <span v-show="true" class="bg-green-100 text-green-800 text-sm font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900" title="Saldo atual">
                                R$ {{ initialBalance.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'}) }}
                            </span>
                    <span v-show="false" class="bg-red-100 text-red-800 text-sm font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">
                                 R$ 50,00
                            </span>
                </div>
            </div>
            <div class="flex mt-4 space-x-3 md:mt-6">
                <Button class="bg-purple-800">
                    <span>Gerênciar</span>
                </Button>
            </div>
        </div>
    </div>
</template>

<script setup>
import Button from '@/Components/Button.vue'

const props = defineProps({
    name: String,
    type: Number,
    initialBalance: Number|String,
    balance: Number|String,
    isMain: Number
})
</script>

<style scoped>

</style>
