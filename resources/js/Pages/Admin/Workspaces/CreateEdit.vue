<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Panel from '@/Components/Panel/Panel.vue';
</script>

<template>
  <Head title="Create Workspace" />
  <AuthenticatedLayout>
    <template #header>
      <h1 class="text-2xl font-bold text-gray-900">Create New Workspace</h1>
    </template>
    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <Panel>
        <div class="p-6 space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Workspace Name</label>
            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g. Real Estate Division" />
          </div>
          <div class="flex justify-end space-x-3">
            <Link href="/mixpost/workspaces" class="px-4 py-2 border rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</Link>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium">Save Workspace</button>
          </div>
        </div>
      </Panel>
    </div>
  </AuthenticatedLayout>
</template>
