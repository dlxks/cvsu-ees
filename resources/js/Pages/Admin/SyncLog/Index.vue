<template>
  <admin-layout title="Sync Logs">
    <template #header>
      <div class="grid grid-cols-2 px-5 py-3 shadow-md rounded-md">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span>Dialogflow Sync Logs</span>
          </h2>
        </div>
      </div>
    </template>

    <div class="py-12">
      <div class="mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div class="mt-8 text-2xl">History of Dialogflow Syncs</div>
            <div class="mt-6 text-gray-500">
              Below is a read-only log of every time an admin synced the local FAQs to Google Cloud Dialogflow.
            </div>
          </div>
          
          <div class="px-6 py-4">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intents Synced</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message / Error</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="log in syncLogs.data" :key="log.id">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ log.created_at }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ log.admin ? log.admin.name : 'Unknown' }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span :class="[log.status === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800', 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full']">
                      {{ log.status }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ log.synced_intents_count }}</td>
                  <td class="px-6 py-4 text-sm text-gray-500">{{ log.message }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    
    <div class="mx-auto sm:px-6 lg:px-8">
      <jet-pagination class="m-5" :links="syncLogs.links" />
    </div>
  </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import JetPagination from "@/Components/Pagination.vue";

export default {
  components: {
    AdminLayout,
    JetPagination,
  },
  props: {
    syncLogs: Object,
  },
};
</script>
