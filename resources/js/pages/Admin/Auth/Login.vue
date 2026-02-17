<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full bg-white shadow-md rounded-lg p-8">
      <div class="mb-8">
        <h2 class="text-3xl font-bold text-center text-gray-900">Admin Login</h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          Sign in to access the admin dashboard
        </p>
      </div>

      <form @submit.prevent="submit">
        <!-- Email -->
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
            Email Address
          </label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            required
            autofocus
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            :class="{ 'border-red-500': form.errors.email }"
          />
          <div v-if="form.errors.email" class="mt-1 text-sm text-red-600">
            {{ form.errors.email }}
          </div>
        </div>

        <!-- Password -->
        <div class="mb-4">
          <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
            Password
          </label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            :class="{ 'border-red-500': form.errors.password }"
          />
          <div v-if="form.errors.password" class="mt-1 text-sm text-red-600">
            {{ form.errors.password }}
          </div>
        </div>

        <!-- Remember Me -->
        <div class="mb-6 flex items-center">
          <input
            id="remember"
            v-model="form.remember"
            type="checkbox"
            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
          />
          <label for="remember" class="ml-2 block text-sm text-gray-900">
            Remember me
          </label>
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          :disabled="form.processing"
          class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <span v-if="form.processing">Signing in...</span>
          <span v-else>Sign in</span>
        </button>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';/*Envoie les données à Laravel*/

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post('/admin/login', {
    onFinish: () => {
      form.password = '';
    },
  });
};
</script>

