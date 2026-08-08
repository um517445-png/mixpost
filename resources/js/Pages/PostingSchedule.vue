<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Panel from '@/Components/Panel/Panel.vue';

const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
const timeslots = ['09:00 AM', '12:00 PM', '03:00 PM', '06:00 PM', '09:00 PM'];
</script>

<template>
  <Head title="Posting Schedule" />
  <AuthenticatedLayout>
    <template #header>
      <h1 class="text-2xl font-bold text-gray-900">Posting Schedule & Automation</h1>
    </template>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <Panel>
        <div class="p-6">
          <h2 class="text-lg font-medium text-gray-900 mb-4">Automated Publishing Timetable</h2>
          <div class="grid grid-cols-1 md:grid-cols-7 gap-4">
            <div v-for="day in days" :key="day" class="p-4 border rounded-lg bg-gray-50">
              <h3 class="font-semibold text-gray-700 mb-2">{{ day }}</h3>
              <div class="space-y-2">
                <div v-for="time in timeslots" :key="time" class="text-xs p-2 bg-white rounded border flex justify-between items-center">
                  <span>{{ time }}</span>
                  <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </Panel>
    </div>
  </AuthenticatedLayout>
</template>
