<template>
    <AuthenticatedLayout title="Dashboard">
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-2xl font-bold leading-tight">
                    {{ wallet.name }}
                </h2>

                <Button external variant="black" target="_blank" class="items-center gap-2 max-w-xs" v-slot="{ iconSizeClasses }" href="https://github.com/kamona-wd/kui-laravel-breeze">
                    <GithubIcon aria-hidden="true" :class="iconSizeClasses" />
                    <span>Star on Github</span>
                </Button>
            </div>
        </template>


        <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <div class="grid grid-cols-4 gap-4">
                <WalletCard title="Banca inicial" :value="wallet.initialBalance"/>
                <WalletCard title="Banca atual" :value="wallet.balance"/>
                <WalletCard title="Take" :value="wallet.take"/>
                <WalletCard title="Stop" :value="wallet.stop"/>
            </div>
        </div>

        <div class="mt-10 p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <div class="grid grid-cols-2 gap-4">
                <div class="flex justify-center">calendar</div>
                <div class="flex justify-center">
                    <apexchart width="300" type="pie" :options="assertivenessChartOptions" :series="assertivenessChartSeries"></apexchart>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
import Button from '@/Components/Button.vue'
import { GithubIcon } from '@/Components/Icons/brands'
import WalletCard from "@/Components/Shared/WalletCard.vue";
import {reactive} from "vue";


const props = defineProps({
    wallet: Object
})


let assertivenessChartOptions = reactive({
    labels: ['Vitorias', 'Derrotas'],
    colors: ['#00e396', '#ff788f']
});
const assertivenessChartSeries = [props.wallet.qtdWin, props.wallet.qtdLoss]


</script>
