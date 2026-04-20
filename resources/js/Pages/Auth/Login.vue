<script setup>
import Checkbox from '@/Components/Checkbox.vue'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { inject } from 'vue'

defineOptions({ name: 'AuthLoginPage' })

const route = inject('route')

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
    default: '',
  },
})

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  })
}
</script>

<template>
  <GuestLayout>
    <Head title="Iniciar sesión" />

    <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="email" value="Correo electrónico" />

        <TextInput
          id="email"
          v-model="form.email"
          type="email"
          class="mt-1 block w-full"
          required
          autofocus
          autocomplete="username"
        />

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-4">
        <InputLabel for="password" value="Contraseña" />

        <TextInput
          id="password"
          v-model="form.password"
          type="password"
          class="mt-1 block w-full"
          required
          autocomplete="current-password"
        />

        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="mt-4 block">
        <label class="flex items-center">
          <Checkbox v-model:checked="form.remember" name="remember" />
          <span class="ms-2 text-sm text-gray-600">Recordarme</span>
        </label>
      </div>

      <div class="mt-4 flex items-center justify-end">
        <Link
          v-if="canResetPassword"
          :href="route('password.request')"
          class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
        >
          ¿Olvidaste tu contraseña?
        </Link>

        <PrimaryButton
          class="ms-4"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Iniciar sesión
        </PrimaryButton>
      </div>

      <div
        class="mt-6 text-center text-sm text-gray-600 border-t border-gray-200 pt-4"
      >
        ¿No tienes cuenta?
        <Link
          :href="route('register')"
          class="font-medium text-primary hover:text-primary-dark underline"
        >
          Crear cuenta
        </Link>
      </div>
    </form>
  </GuestLayout>
</template>
