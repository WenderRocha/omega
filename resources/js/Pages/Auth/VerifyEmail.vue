<template>
    <GuestLayout title="Email Verification">
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            Obrigado por se cadastrar! acesse seu E-mail e clique no link que te enviamos
            para confirmar sua conta
        </div>

        <div
            class="mb-4 text-sm font-medium text-green-600"
            v-if="verificationLinkSent"
        >
            Um novo link de verificação foi enviado para o E-mail informado!
        </div>

        <form @submit.prevent="submit">
            <div class="flex items-center justify-between mt-4">
                <Button
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Reenviar E-mail de verificação
                </Button>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="text-sm text-blue-600 hover:underline dark:text-blue-400"
                >
                   Sair
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Link, useForm } from '@inertiajs/inertia-vue3'
import GuestLayout from '@/Layouts/Guest.vue'
import Button from '@/Components/Button.vue'

const props = defineProps({
    status: String
})

const form = useForm()

const submit = () => {
    form.post(route('verification.send'))
}

const verificationLinkSent = computed(() => props.status === 'verification-link-sent')
</script>
