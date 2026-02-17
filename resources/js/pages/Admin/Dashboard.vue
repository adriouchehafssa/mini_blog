<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
          <p v-if="admin" class="text-sm text-gray-600">Welcome, {{ admin.name }}</p>
        </div>
        <button
          @click="logout"
          class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
        >
          Logout
        </button>
      </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Stats Card 1 -->
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-1">
              <p class="text-sm text-gray-600">Total Users</p>
              <p class="text-3xl font-bold text-gray-900">1,234</p>
            </div>
            <div class="bg-blue-100 rounded-full p-3">
              <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
              </svg>
            </div>
          </div>
        </div>

        <!-- Stats Card 2 -->
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-1">
              <p class="text-sm text-gray-600">Total Posts</p>
              <p class="text-3xl font-bold text-gray-900">567</p>
            </div>
            <div class="bg-green-100 rounded-full p-3">
              <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
            </div>
          </div>
        </div>

        <!-- Stats Card 3 -->
        <div class="bg-white rounded-lg shadow p-6">
          <div class="flex items-center">
            <div class="flex-1">
              <p class="text-sm text-gray-600">Active Sessions</p>
              <p class="text-3xl font-bold text-gray-900">89</p>
            </div>
            <div class="bg-purple-100 rounded-full p-3">
              <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Admin Info Card -->
      <div v-if="admin" class="mt-8 bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-xl font-semibold text-gray-900">Admin Information</h2>
        </div>
        <div class="p-6">
          <div class="space-y-3">
            <div>
              <span class="font-medium text-gray-700">Name:</span>
              <span class="ml-2 text-gray-900">{{ admin.name }}</span>
            </div>
            <div>
              <span class="font-medium text-gray-700">Email:</span>
              <span class="ml-2 text-gray-900">{{ admin.email }}</span>
            </div>
            <div v-if="admin.email_verified_at">
              <span class="font-medium text-gray-700">Email Verified:</span>
              <span class="ml-2 text-green-600">✓ Verified</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Activity -->
      <div class="mt-8 bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-xl font-semibold text-gray-900">Recent Activity</h2>
        </div>
        <div class="p-6">
          <p class="text-gray-600">No recent activity to display.</p>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

// recupere les données dadmin connecté
const page = usePage();
const admin = computed(() => (page.props.auth as any).admin);
const logout = () => {
  router.post('/admin/logout');
};
</script>
