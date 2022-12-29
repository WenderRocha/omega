<template>
    <!--START NO WALLET CREATED-->
    <div class="flex flex-col justify-center items-center">
        <img class="noWalletSvg" src="/img/no_wallet_created.svg" alt="">
    </div>
    <div class="noWalletContent flex flex-col justify-center items-center ">
        <h4 class="mt-10 mb-5 text-md font-semibold leading-tight">Crie e gerencie suas carteiras</h4>
        <p class="noWalletDescription">Organize suas contas de diferentes fontes como Minha Casa para PF, Minha Empresa para PJ, ou ainda Quotex para organizar sua conta de opções binárias. Controle tudo...</p>
    </div>
    <!--START NO WALLET CREATED-->
</template>

<script setup>
import Button from '@/Components/Button.vue'
import { WalletIcon } from '@/Components/Icons/outline'
</script>


<style scoped>
.noWalletSvg{
    width: 150px;
}
.noWalletDescription{
    max-width: 60%;
}
</style>
