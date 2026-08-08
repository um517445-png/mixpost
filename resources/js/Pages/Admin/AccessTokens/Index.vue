<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Panel from '@/Components/Panel/Panel.vue';
</script>

<template>
  <Head title="Access Tokens" />
  <AuthenticatedLayout>
    <template #header>
      <h1 class="text-2xl font-bold text-gray-900">API Access Tokens (Sanctum)</h1>
    </template>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <Panel>
        <div class="p-6">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-medium text-gray-900">Personal Access Tokens</h2>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium">
              + Generate Token
            </button>
          </div>
          <div class="border rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Token Name</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Abilities</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Last Used</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Automation Script Token</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">posts:create, posts:publish</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Just now</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 hover:text-red-900 cursor-pointer">Revoke</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </Panel>
    </div>
  </AuthenticatedLayout>
</template>
