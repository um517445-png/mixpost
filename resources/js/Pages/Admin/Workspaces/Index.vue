<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Panel from '@/Components/Panel/Panel.vue';
</script>

<template>
  <Head title="Workspaces" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Workspaces & Multitenancy</h1>
        <Link href="/mixpost/workspaces/create" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium">
          + New Workspace
        </Link>
      </div>
    </template>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <Panel>
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="border rounded-xl p-6 bg-white shadow-sm hover:shadow-md transition">
              <div class="flex justify-between items-start mb-4">
                <span class="p-3 bg-indigo-50 text-indigo-600 rounded-lg font-bold text-xl">🏢</span>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
              </div>
              <h3 class="text-lg font-bold text-gray-900">Main Agency Workspace</h3>
              <p class="text-sm text-gray-500 mt-1">Default primary tenant space</p>
              <div class="mt-6 pt-4 border-t flex justify-between text-xs text-gray-500">
                <span>Accounts: 12</span>
                <span>Users: 5</span>
              </div>
            </div>
          </div>
        </div>
      </Panel>
    </div>
  </AuthenticatedLayout>
</template>
