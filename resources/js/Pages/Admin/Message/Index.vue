<template>
  <admin-layout title="Applicant Inquiries">
    <template #header>
      <!-- Header -->
      <div class="grid grid-cols-2 px-5 py-3 shadow-md rounded-md">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span>Applicant Inquiries</span>
          </h2>
        </div>
        <!-- Header -->

        <!-- Page Buttons -->
        <div align="right">
          <!-- Line buttons and show dropdown -->
          <div class="block" align="right">
            <jet-dropdown>
              <template #trigger>
                <span class="inline-flex rounded-md">
                  <button
                    type="button"
                    class="inline-flex items-center px-4 py-2 mr-2 bg-gray-800 hover:bg-gray-600 text-gray-100 text-sm font-medium rounded-md"
                  >
                    <span>Data Export</span>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="ml-2 -mr-0.5 h-4 w-4"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      stroke-width="2"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"
                      />
                    </svg>
                  </button>
                </span>
              </template>
              <template #content>
                <!-- Export buttons -->
                <div class="px-2 py-2">
                  <div class="py-1">
                    <jet-button
                      @click="exportData('xlsx')"
                      class="inline-flex items-center px-4 py-2 mr-2 bg-blue-200 hover:bg-blue-300 text-blue-800 text-sm font-medium rounded-md"
                    >
                      Export(.xlsx)
                    </jet-button>
                  </div>
                  <div class="py-1">
                    <jet-button
                      @click="exportData('csv')"
                      class="inline-flex items-center px-4 py-2 mr-2 bg-blue-200 hover:bg-blue-300 text-blue-800 text-sm font-medium rounded-md"
                    >
                      Export(.csv)
                    </jet-button>
                  </div>
                </div>
              </template>
            </jet-dropdown>
          </div>
          <!-- Hide in line buttons and show dropdown -->
        </div>
        <!-- End Page Buttons -->
      </div>
    </template>

    <div class="py-12">
      <div class="mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 px-5 py-3">
          <div>
            <div class="inline-block">
              <jet-input
                type="text"
                class="block ml-2 mb-4 w-60"
                placeholder="Search..."
                v-model="params.search"
              />
            </div>
            <!-- View filter -->
            <div class="inline-block">
              <span class="px-1 text-gray-500">Show</span>
              <select
                ref="perpage"
                id="perpage"
                class="mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                v-model="params.perpage"
              >
                <option
                  v-for="perpage in perpages"
                  :key="perpage"
                  :value="perpage"
                  class="capitalize"
                >
                  <span>{{ perpage }}</span>
                </option>
              </select>
              <span class="px-1 text-gray-500">per page</span>
            </div>
            <!-- View filter -->
          </div>
        </div>
      </div>

      <!-- List of exams -->
      <div>
        <div class="px-4 py-2 w-full bg-gray-700">
          <span class="uppercase tracking-wider text-white">List of Inquiries</span>
        </div>
        <div class="flex flex-col">
          <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <!-- NO data -->
            <div v-if="!messages.data.length">
              <div class="w-full py-8">
                <div class="p-4 text-center text-sm text-gray-800">
                  <span class="text-red-500 uppercase text-xl">No inquiries found!</span>
                  <NoData />
                </div>
              </div>
            </div>
            <!-- NO data -->

            <div class="p-4 align-middle sm:px-8 lg:px-10">
              <!-- One row / data / card -->
              <div class="flex flex-wrap">
                <div
                  v-for="(message, id) in messages.data"
                  :key="message.id"
                  class="w-full md:w-6/12 lg:w-4/12"
                >
                  <div
                    class="shadow overflow-hidden border-b border-gray-200 rounded-lg m-2 md:m-2 lg:m-4"
                  >
                    <div
                      class="w-full bg-emerald-500 py-2 px-4 inline-flex text-sm text-white"
                    >
                      <div align="right">Created: {{ message.created_at }}</div>
                    </div>
                    <div class="text-md">
                      <div class="px-2 pt-4">
                        <span class="text-gray-500 px-2">Name:</span>
                        <span> {{ message.name }}</span>
                      </div>
                      <div class="px-2">
                        <span class="text-gray-500 px-2 break-all truncate">
                          Contact:
                        </span>
                        <span> {{ message.contact }}</span>
                      </div>
                      <div class="px-2 pt-4">
                        <span class="text-gray-500 px-2 break-all truncate"
                          >Inquiry:</span
                        >
                        <span> {{ message.inquiry }}</span>
                      </div>
                    </div>
                    <div
                      class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                      <button
                        @click="deleteRow(message.id)"
                        class="inline-flex items-center px-2 py-2 bg-red-200 hover:bg-red-300 text-red-800 text-sm font-medium rounded-md"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-5 w-5"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                          stroke-width="2"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                          />
                        </svg>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- One row / data / card -->
            </div>
          </div>
        </div>
      </div>
      <!-- List of exams -->
    </div>

    <div class="mx-auto sm:px-6 lg:px-8">
      <jet-pagination class="m-5" :links="messages.links" />
    </div>
  </admin-layout>
</template>

<script>
import { reactive, watchEffect } from "vue";
import { pickBy, throttle } from "lodash";
import { Inertia } from "@inertiajs/inertia";
import AdminLayout from "@/Layouts/AdminLayout";
import JetButton from "@/Jetstream/Button";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import JetLabel from "@/Jetstream/Label";
import JetInput from "@/Jetstream/Input";
import JetDropdown from "@/Jetstream/Dropdown";
import JetDropdownLink from "@/Jetstream/DropdownLink";
import JetFormSection from "@/Jetstream/FormSection";
import JetActionMessage from "@/Jetstream/ActionMessage";
import DialogModal from "@/Jetstream/DialogModal";
import JetPagination from "@/Components/Pagination";
import { Link } from "@inertiajs/inertia-vue3";
import shared from "@/Scripts/shared";
import NoData from "@/Components/Fillers/NoData.vue";

export default {
  components: {
    AdminLayout,
    JetButton,
    JetSecondaryButton,
    JetLabel,
    JetInput,
    JetPagination,
    JetDropdown,
    JetDropdownLink,
    JetFormSection,
    JetActionMessage,
    DialogModal,
    Link,
    NoData,
  },

  props: {
    messages: Object,
    filters: Object,
  },

  extends: shared,

  data() {
    return {
      params: {
        search: this.filters.search,
        field: this.filters.field,
        direction: this.filters.direction,
      },

      form: this.$inertia.form({
        inquiry: "",
        contact: "",
      }),

      importOpen: false,
      isOpen: false,
      disabled: null,
      editMode: false,
    };
  },

  methods: {
    // Disable function
    disabledClick: function (s) {
      this.disabled = s;
    },

    // Modal function
    openModal: function (status) {
      if (status == true) {
        this.isOpen = true;
      } else if (status == false) {
        this.form = {};
        this.isOpen = false;
        this.editMode = false;
      }

      return this.isOpen;
    },

    // Delete function
    deleteRow: function (id) {
      this.$inertia.visit("/admin/messages/" + id, {
        method: "delete",
      });
    },

    // Export function
    exportData: function (type) {
      const url = "/admin/export/messages?type=" + type;
      window.location.href = url;
    },
  },

  watch: {
    params: {
      handler: throttle(function () {
        let params = pickBy(this.params);

        this.$inertia.get(this.route("admin.messages.index"), params, {
          replace: true,
          preserveState: true,
        });
      }, 150),
      deep: true,
    },
  },
};
</script>
