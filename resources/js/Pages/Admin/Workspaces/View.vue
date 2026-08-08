<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Panel from '@/Components/Panel/Panel.vue';
</script>

<template>
  <Head title="Workspace Details" />
  <AuthenticatedLayout>
    <template #header>
      <h1 class="text-2xl font-bold text-gray-900">Workspace Overview</h1>
    </template>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
      <Panel>
        <div class="p-6">
          <p class="text-gray-600">Managing workspace configurations and active team members.</p>
        </div>
      </Panel>
    </div>
  </AuthenticatedLayout>
</template>
