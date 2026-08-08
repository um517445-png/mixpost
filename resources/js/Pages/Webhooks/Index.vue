<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Panel from '@/Components/Panel/Panel.vue';
</script>

<template>
  <Head title="Webhooks Engine" />
  <AuthenticatedLayout>
    <template #header>
      <h1 class="text-2xl font-bold text-gray-900">Webhooks & Event Delivery</h1>
    </template>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <Panel>
        <div class="p-6">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-medium text-gray-900">Configured Endpoints</h2>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium">
              + Add Webhook Endpoint
            </button>
          </div>
          <div class="border rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Target URL</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Events</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">https://api.veyra.app/webhooks/mixpost</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">post.published, post.scheduled</td>
                  <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-indigo-600 hover:text-indigo-900 cursor-pointer">Edit</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </Panel>
    </div>
  </AuthenticatedLayout>
</template>
