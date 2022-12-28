<template>
    <AuthenticatedLayout title="Dashboard">
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold leading-tight">
                    Carteiras
                </h2>
            </div>
        </template>

        <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">

            <!--START NO WALLET CREATED-->
            <NoWalletCreated/>
            <!--START NO WALLET CREATED-->

            <!--WALLET CREATED-->
            <div>

            </div>
            <!--WALLET CREATED-->

        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
import Button from '@/Components/Button.vue'
import { WalletIcon } from '@/Components/Icons/outline'
import { GithubIcon } from '@/Components/Icons/brands'
import NoWalletCreated from "@/Components/Shared/NoWalletCreated.vue";
</script>

