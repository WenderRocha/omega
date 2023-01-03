<template>
    <AuthenticatedLayout title="Dashboard">
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-2xl font-bold leading-tight">
                    {{ wallet.name }} {{ calendarDate }}
                </h2>

                <Button external variant="black" target="_blank" class="items-center gap-2 max-w-xs"
                        v-slot="{ iconSizeClasses }" href="https://github.com/kamona-wd/kui-laravel-breeze">
                    <GithubIcon aria-hidden="true" :class="iconSizeClasses"/>
                    <span>Star on Github</span>
                </Button>
            </div>
        </template>


        <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
                <WalletCard title="Banca inicial" :value="wallet.initialBalance"/>
                <WalletCard title="Banca atual" :value="wallet.balance"/>
                <WalletCard title="Lucro / Prejuizo" :value="wallet.result"/>
                <WalletCard title="Take" :value="wallet.take"/>
                <WalletCard title="Stop" :value="wallet.stop"/>
            </div>
        </div>

        <div  class="mt-10 p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
                <div>
                    <label for="assets" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ativo</label>
                    <select v-model="tradeForm.assets" id="assets" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Ativo</option>
                        <option value="EUR/USD">EUR/USD</option>
                        <option value="EUR/GBP">EUR/GBP</option>
                        <option value="USD/CHF">USD/CHF</option>
                        <option value="USD/CAD">USD/CAD</option>
                    </select>
                </div>
                <div>
                    <label for="payout" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Payout</label>
                    <input @keyup="calcIncome" v-model="tradeForm.payout" type="text" id="payout" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="87%" required>
                </div>
                <div>
                    <label for="value" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Valor</label>
                    <input @keyup="calcIncome" v-model="tradeForm.value" type="text" id="value" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="R$ 26,00" required>
                </div>
                <div>
                    <label for="income" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lucro</label>
                    <input v-model="getIncomeFormatted" type="text" id="income" class="bg-gray-50 border border-gray-300 text-emerald-500 font-bold text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled placeholder="" required>
                </div>
                <div>
                    <label for="assets" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ativo</label>
                    <select v-model="tradeForm.orderType" id="assets" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="CALL">Compra</option>
                        <option value="PUT">Venda</option>
                    </select>
                </div>
            </div>
            <div class="mt-10 flex items-center justify-center gap-4 ">
                <Button  @click="scoreWin" :disabled="tradeForm.processing" variant="success" size="base"
                        class="uppercase">
                    Win
                </Button>
                <Button @click="scoreDraw" :disabled="tradeForm.processing" variant="warning" size="base"
                        class="uppercase">
                    Empate
                </Button>
                <Button @click="scoreLoss" :disabled="tradeForm.processing" variant="danger" size="base"
                        class="uppercase">
                    Loss
                </Button>
            </div>
        </div>

        <div class="mt-10 grid md:grid-cols-2 gap-4">
            <div
                class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 flex flex-col justify-center">
                <v-date-picker @click="getManagementByDate" v-model="calendarDate" :attributes='calendarAttributes'
                               :is-dark="calendarDarkTheme" is-expanded :model-config="modelConfig"/>
                <div class="mt-5 flex justify-center">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">WIN</span>
                    <span
                        class="bg-yellow-100 text-yellow-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-200 dark:text-yellow-900">EMPATE</span>
                    <span
                        class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">LOSS</span>
                    <span
                        class="bg-gray-100 text-gray-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">SEM
                            OPERAR</span>
                </div>
            </div>
            <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 ">
                <h6 class="capitalize dark:text-white">Assertividade Geral</h6>
                <div class="mt-10 flex justify-center">
                    <apexchart width="450" type="pie" :options="assertivenessChartOptions"
                               :series="assertivenessChartSeries"></apexchart>
                </div>
            </div>
        </div>

        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-3">
            <div class="w-full p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
                <div class="mb-5">
                    <h6 class="capitalize dark:text-white">Rendimento anual </h6>
                    <p class="mb-0 text-sm leading-normal dark:text-white dark:opacity-60">
                    </p>
                </div>
                <div class="mt-5 w-full flex items-center justify-center">
                    <apexchart id="barChart" type="bar" width="450px" :options="barOptionsMonth"
                               :series="barSeriesMonth">
                    </apexchart>
                </div>
            </div>
            <div class="w-full p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
                <div class="mb-5">
                    <h6 class="capitalize dark:text-white">Desempenho mensal </h6>
                </div>
                <div class="mt-5 w-full flex items-center justify-center">
                    <apexchart id="barChart" type="bar" width="450px" :options="barOptionsMonth"
                               :series="barSeriesMonth">
                    </apexchart>
                </div>
            </div>
        </div>

        <div class="mt-10  p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 ">
            <h6 class="capitalize dark:text-white">Book Trade</h6>
            <div class="mt-5 overflow-x-auto relative">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">
                            Data
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Trades
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Placar
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Investimento
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Win
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Loss
                        </th>

                        <th scope="col" class="py-3 px-6">
                            Renda
                        </th>
                        <th scope="col" class="py-3 px-6">
                            %
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Saldo
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="management" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <span
                                class="text-sm font-bold leading-normal text-black dark:text-gray-400">{{
                                    management.date
                                }}</span>
                        </th>
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <span class="text-sm font-bold leading-normal text-black dark:text-gray-400"> {{
                                    management.qtdTrades
                                }}</span>
                        </th>
                        <td class="py-4 px-6">
                            <div class="flex gap-2">
                                <span class="text-sm font-bold leading-normal text-emerald-500">{{ management.qtdWin }} -</span>
                                <span class="text-sm font-bold leading-normal text-red-500">{{
                                        management.qtdLoss
                                    }} -</span>
                                <span class="text-sm font-bold leading-normal text-yellow-500">{{
                                        management.qtdDraw
                                    }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-sm font-bold leading-normal text-purple-500"> {{
                                    management.totalInvestment
                                }}</span>
                        </td>

                        <td class="py-4 px-6">
                            <span class="text-sm font-bold leading-normal text-emerald-500">{{management.valueWin }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-sm font-bold leading-normal text-red-500">{{management.valueLoss }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex gap-2">
                                <span v-show="true"
                                      class="text-sm font-bold leading-normal text-emerald-500">{{ management.profit }}
                                </span>
                                <span v-show="false"
                                      class="text-sm font-bold leading-normal text-red-500">{{ management.profit }}
                                </span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <p class="mb-0 text-sm leading-normal dark:text-white dark:opacity-60">
                                <span class="font-semibold">{{ management.resultPercentage }}% </span>
                            </p>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-sm font-bold leading-normal text-cyan-500">+ {{
                                    management.dayBalance
                                }} </span>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>


    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
import Button from '@/Components/Button.vue'
import {GithubIcon} from '@/Components/Icons/brands'
import WalletCard from "@/Components/Shared/WalletCard.vue";
import {computed, reactive, ref} from "vue";
import {isDark} from '@/Composables'
import {Inertia} from '@inertiajs/inertia'
import {useForm} from "@inertiajs/inertia-vue3";
import {useToast} from "vue-toast-notification";
import 'vue-toast-notification/dist/theme-sugar.css';

const $toast = useToast();

const props = defineProps({
    wallet: Object,
    management: Object,
    trades: Object,
    date: String
})

//START CALENDAR
let calendarDarkTheme = ref(isDark);
const calendarDate = ref(props.date);
const calendarAttributes = props.wallet.managements
const modelConfig = {
    type: 'string', mask: 'DD-MM-YYYY', // Uses 'iso' if missing
}

function getManagementByDate() {
    Inertia.get(route('wallet.show', props.wallet.id, calendarDate.value), {date: calendarDate.value}, {replace: true})
}

//END CALENDAR

//START PIE CHART ASSERTIV
let assertivenessChartOptions = reactive({
    labels: ['Vitorias', 'Derrotas'],
    colors: ['#00e396', '#ff788f']
});
const assertivenessChartSeries = [props.wallet.qtdWin, props.wallet.qtdLoss]
//START PIE CHART ASSERTIV

//START BAR CHART MONTH
const barSeriesMonth = [

    {
        name: 'Lucro',
        data: [props.wallet.result, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
    },
    {
        name: 'Prejuizo',
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
    },
]
let barOptionsMonth = reactive({
    chart: {
        type: 'bar',
        background: 'transparent'
    },
    theme: {
        mode: 'light'
    },
    colors: ['#00e396', '#ff788f'],
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '70%',
            endingShape: 'rounded'
        },
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dez'],
    },
    yaxis: {
        title: {
            text: 'R$ (Reais)'
        }
    },
    fill: {
        opacity: 1
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return "R$ " + val + " Reais"
            }
        }
    }
})
//END BAR CHART MONTH

//START TRADE FORM
const tradeForm = useForm({
    management_id: props.management.id,
    date: calendarDate.value,
    assets: 'EUR/USD',
    payout: '82',
    value: 26,
    income: 0,
    orderType: 'CALL',
    operational: 'Retração M5',
    observation: 'Digite sua observação',
    tradeResult: ''
})

const getIncomeFormatted = ref('0');

const calcIncome = () => {
    let income = (tradeForm.payout / 100) * tradeForm.value;
    tradeForm.income = income;
    getIncomeFormatted.value =  (new Intl.NumberFormat('pt-br', { style: 'currency', currency: 'BRL' }).format(income));
}

calcIncome();


const scoreWin = () => {
    calcIncome();
    tradeForm.tradeResult = 'win'
    submitTradeForm('win')
}
const scoreDraw = () => {
    tradeForm.tradeResult = 'draw'
    tradeForm.income = 0
    submitTradeForm('draw')
}
const scoreLoss = () => {
    tradeForm.income = tradeForm.value
    tradeForm.tradeResult = 'loss'
    submitTradeForm('loss')
}

function submitTradeForm(result) {
    tradeForm.post(route('trade.store'), {
        onSuccess: (page) => {
            if (result === 'win') {

                $toast.success(`é Take + ${getIncomeFormatted.value}`, {
                    // override the global option
                    position: 'top-right'
                })
            } else if (result === 'loss') {
                $toast.error(`Loss - ${tradeForm.value}`, {
                    // override the global option
                    position: 'top-right'
                })
            } else {
                $toast.warning(`Empate = R$ 0,0`, {
                    // override the global option
                    position: 'top-right'
                })
            }
        },
        onError: (errors) => {
            $toast.error('Oops, tente novamente mais tarde...', {
                // override the global option
                position: 'top-right'
            })
        },
    })
}
//END TRADE FORM

</script>
