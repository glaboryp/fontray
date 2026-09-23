<script setup>
import { computed, inject } from 'vue'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const route = inject('route')

const props = defineProps({
  status: {
    type: String,
    default: '',
  },
})

const form = useForm({})

const submit = () => {
  form.post(route('verification.send'))
}

const verificationLinkSent = computed(
  () => props.status === 'verification-link-sent'
)
</script>

<template>
  <GuestLayout>
    <Head title="Verificar correo" />

    <div class="mb-4 text-sm text-bench-400">
      ¡Gracias por registrarte! Antes de comenzar, ¿podrías verificar tu
      dirección de correo electrónico haciendo clic en el enlace que te acabamos
      de enviar? Si no recibiste el correo, con gusto te enviaremos otro.
    </div>

    <div
      v-if="verificationLinkSent"
      class="mb-4 text-sm font-medium text-confirm"
    >
      Se ha enviado un nuevo enlace de verificación a la dirección de correo
      electrónico que proporcionaste durante el registro.
    </div>

    <form @submit.prevent="submit">
      <div class="mt-4 flex items-center justify-between">
        <PrimaryButton
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Reenviar correo de verificación
        </PrimaryButton>

        <Link
          :href="route('logout')"
          method="post"
          as="button"
          class="rounded-md text-sm text-bench-400 underline hover:text-bench-100 focus:outline-none focus:ring-2 focus:ring-index-500 focus:ring-offset-2 focus:ring-offset-bench-900"
        >
          Cerrar sesión
        </Link>
      </div>
    </form>
  </GuestLayout>
</template>
