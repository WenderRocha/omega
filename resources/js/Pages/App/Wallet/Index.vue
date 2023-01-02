<template>
    <AuthenticatedLayout title="Dashboard">
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold leading-tight">
                    Carteiras
                </h2>

                <Button @click="showModal" class="mt-5 items-center gap-2 max-w-xs mr-4" v-slot="{ iconSizeClasses }">
                    <WalletIcon aria-hidden="true" :class="iconSizeClasses"/>
                    <span>Nova carteira</span>
                </Button>
            </div>
        </template>

        <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">

            <!--START SHOW WALLETS-->
            <div class="grid md:grid-cols-3 gap-4">
                <Wallet v-for="wallet in wallets"
                        :key="wallet.id"
                        :id="wallet.id"
                        :name="wallet.name"
                        :type="wallet.isBinary"
                        :initial-balance="wallet.initialBalance"/>
            </div>
            <!--END SHOW WALLETS-->

            <!--START NO WALLET CREATED-->
            <div v-if="!props.wallets.length">
                <NoWalletCreated/>
                <div class="flex justify-center">
                    <Button @click="showModal" class="mt-5 items-center gap-2 max-w-xs" v-slot="{ iconSizeClasses }">
                        <WalletIcon aria-hidden="true" :class="iconSizeClasses"/>
                        <span>Abrir carteira</span>
                    </Button>
                </div>
            </div>
            <!--START NO WALLET CREATED-->

            <!--WALLET CREATED-->
            <div>
                <Modal v-if="isShowModal" @close="closeModal">
                    <template  #header>
                        <div class="flex items-center text-lg">
                            {{ (walletForm.name === '') ? 'Nova Carteira' : walletForm.name }}
                        </div>
                    </template>
                    <template #body>

                        <!--Header Wallet-->
                        <div class="grid grid-cols-2 gap-4">
                            <!--Wallet name-->
                            <div class="mb-6">
                                <Input v-model="walletForm.name" label="Nome" placeholder="Minha carteira"/>
                                <div class="py-2 text-red-600" v-if="walletForm.errors.name">{{
                                        walletForm.errors.name
                                    }}
                                </div>
                            </div>
                            <!--Wallet name-->

                            <!--Wallet initial Balance-->
                            <div class="mb-6">
                                <CurrencyInput @keyup="calcTakePercentage" v-model="walletForm.initialBalance"
                                               label="Saldo inicial" placeholder="R$ 0,00"/>
                                <div class="py-2 text-red-600" v-if="walletForm.errors.initialBalance">
                                    {{ walletForm.errors.initialBalance }}
                                </div>
                            </div>
                            <!--Wallet initial Balance-->

                        </div>
                        <!--Header Wallet-->

                        <!--is Binary-->
                        <div v-if="walletForm.isBinary">

                            <div class="grid grid-cols-2 gap-4">
                                <!--select management type -->
                                <div class="mb-6">
                                    <label for="management"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gerênciamento</label>
                                    <select @change="cleanTakeAndStopData" v-model="walletForm.managementType"
                                            id="management"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="fixed">Fixo</option>
                                        <option value="compound">Composto</option>
                                    </select>
                                </div>
                                <!--select management type -->

                                <!--select currency type -->
                                <div class="mb-6">
                                    <label for="countries"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Moeda</label>
                                    <select v-model="walletForm.currency" id="countries"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="BRL">BRL</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </div>
                                <!--select currency type -->
                            </div>

                            <!--management fixed-->
                            <div v-if="walletForm.managementType === 'fixed'" class="grid grid-cols-2 gap-4">
                                <div class="mb-6">
                                    <CurrencyInput v-model="getTake" label="Take" placeholder="R$ 50,00"/>
                                </div>
                                <div class="mb-6">
                                    <CurrencyInput v-model="getStop" label="Stop" placeholder="R$ 25,00"/>
                                </div>
                            </div>
                            <!--management fixed-->

                            <!--management compound-->
                            <div v-if="walletForm.managementType === 'compound'" class="grid grid-cols-2 gap-4">
                                <div class="mb-6">
                                    <div class="mb-6">
                                        <label for="take"
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Take</label>
                                        <input v-model="getTakeFormatted" type="text" id="take" disabled class="font-semibold text-emerald-600 bg-gray-50
                                        border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block
                                        w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                                        dark:focus:border-blue-500" placeholder="R$ 0,00" required>

                                    </div>
                                    <div class="mb-6">
                                        <label for="default-range"
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Defina
                                            seu Take: <span class="font-semibold text-emerald-600">{{
                                                    getTakePercentage
                                                }}%</span></label>
                                        <input @change="calcTakePercentage" v-model="getTakePercentage"
                                               id="default-range" type="range"
                                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                                    </div>
                                </div>
                                <div class="mb-6">
                                    <div class="mb-6">
                                        <label for="take"
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stop</label>
                                        <input v-model="getStopFormatted" type="text" id="take" disabled class="font-semibold text-red-600 bg-gray-50
                                        border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block
                                        w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                                        dark:focus:border-blue-500" placeholder="R$ 0,00" required>
                                    </div>
                                    <div class="mb-6">
                                        <label for="default-range"
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Defina
                                            seu Stop: <span class="font-semibold text-red-600">{{
                                                    getStopPercentage
                                                }}%</span></label>
                                        <input @change="calcStopPercentage" v-model="getStopPercentage"
                                               id="default-range" type="range"
                                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                                    </div>
                                </div>
                            </div>
                            <!--management compound-->

                        </div>
                        <!--is Binary-->

                        <!--Wallet options-->
                        <div class="grid grid-cols-3 gap-4">
                            <!--Wallet toggle is Binary-->
                            <div>
                                <label class="inline-flex relative items-center cursor-pointer">
                                    <input @click="walletForm.isMain = false" @change="cleanTakeAndStopData"
                                           v-model="walletForm.isBinary" type="checkbox" class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Opções Binárias</span>
                                </label>
                            </div>
                            <!--Wallet toggle is Binary-->

                            <!--Wallet is main-->
                            <div v-if="!walletForm.isBinary">
                                <label class="inline-flex relative items-center cursor-pointer">
                                    <input v-model="walletForm.isMain" type="checkbox" class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Carteira principal</span>
                                </label>
                            </div>
                            <!--Wallet is main-->

                            <!--Wallet toggle add to totals-->
                            <div>
                                <label class="inline-flex relative items-center cursor-pointer">
                                    <input v-model="walletForm.addToTotals" type="checkbox" value=""
                                           class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Somar aos totais</span>
                                </label>
                            </div>
                            <!--Wallet toggle add to totals-->
                        </div>
                        <!--Wallet Options-->

                    </template>
                    <template #footer>
                        <div class="flex justify-between">
                            <button @click="closeModal" type="button"
                                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                Cancelar
                            </button>
                            <Button @click="submitWalletForm" :disabled="walletForm.processing"
                                    class="mt-5 items-center gap-2 max-w-xs" v-slot="{ iconSizeClasses }">
                                <WalletIcon v-if="!walletForm.processing" aria-hidden="true" :class="iconSizeClasses"/>
                                <spinner v-else class="mr-2" color="white" size="8"/>
                                <span v-if="!walletForm.processing">Criar carteira</span>
                                <span v-else>Aguarde...</span>
                            </Button>
                        </div>
                    </template>
                </Modal>
            </div>
            <!--WALLET CREATED-->

        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
import Button from '@/Components/Button.vue'
import {WalletIcon} from '@/Components/Icons/outline'
import NoWalletCreated from "@/Components/Shared/NoWalletCreated.vue";
import Wallet from '@/Components/Shared/Wallet.vue'
import CurrencyInput from "@/Components/Shared/CurrencyInput.vue";
import {Modal, Input, Spinner} from 'flowbite-vue';
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

import {computed, ref, useAttrs} from 'vue'
import {useForm} from "@inertiajs/inertia-vue3";

const props = defineProps({
    wallets: Object
})

console.log(props.wallets.length)

const $toast = useToast();
const attrs = useAttrs();

//MODAL CONTENT
const isShowModal = ref(false)

function closeModal() {
    isShowModal.value = false
}

function showModal() {
    isShowModal.value = true
}

//MODAL CONTENT

const getInitialBalance = ref(0);

const getTake = ref(0);
const getTakeFormatted = ref('0');

const getStop = ref(0);
const getStopFormatted = ref('0');

const getTakePercentage = ref(0);
const getStopPercentage = ref(0);


//START WALLET FORM
const walletForm = useForm({
    user_id: attrs.auth.user.id,
    name: '',
    initialBalance: 0,
    balance: 0,
    take: getTake,
    takePercentage: 0,
    stop: getStop,
    stopPercentage: 0,
    currency: 'BRL',
    managementType: 'fixed',
    addToTotals: false,
    isBinary: false,
    isMain: false
})

const cleanTakeAndStopData = () => {
    getTake.value = 0;
    getTakeFormatted.value = '0';

    getStop.value = 0;
    getStopFormatted.value = '0';

    walletForm.takePercentage = 0;
    getTakePercentage.value = 0;

    walletForm.stopPercentage = 0;
    getStopPercentage.value = 0;
}

const calcTakePercentage = () => {
    let result = (getTakePercentage.value / 100) * walletForm.initialBalance
    getTake.value = result;
    getTakeFormatted.value = result.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'});
    walletForm.take = result;
    walletForm.takePercentage = getTakePercentage.value
    walletForm.stopPercentage = getStopPercentage.value

    calcStopPercentage()
}

const calcStopPercentage = () => {
    let result = (getStopPercentage.value / 100) * walletForm.initialBalance
    getStop.value = result;
    getStopFormatted.value = result.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'});
    walletForm.stop = result;
    walletForm.stopPercentage = getStopPercentage.value
    walletForm.takePercentage = getTakePercentage.value
}

const submitWalletForm = () => {

    walletForm.balance = walletForm.initialBalance
    walletForm.post(`${route('wallet.store')}`, {
        onSuccess: (page) => {
            $toast.success('Carteira criada com sucesso!', {
                // override the global option
                position: 'top-right'
            })

            walletForm.reset();
            cleanTakeAndStopData();
            closeModal();
        },
        onError: (errors) => {

            let message = (errors.message) ?? 'Oops, Algo deu errado'
            $toast.error(message, {
                // override the global option
                position: 'top-right'
            })
        },
    })
}

//START WALLET FORM


</script>

