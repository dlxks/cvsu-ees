<template>
  <admin-layout title="Chatbot">
    <template #header>
      <!-- Header -->
      <div class="grid grid-cols-2 px-5 py-3 shadow-md rounded-md">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span>Chatbot Questions</span>
          </h2>
        </div>
        <!-- Header -->
      </div>
    </template>

    <div class="py-12">
      <div class="mx-auto sm:px-6 lg:px-8">
        <div class="mx-auto md:flex md:justify-between md:items-center px-5 py-3">
          <div class="pb-2 sm:pb-0">
            <!-- Search -->
            <div class="block">
              <span class="text-sm text-gray-500">Search: </span>
              <jet-input
                type="text"
                placeholder="Search..."
                v-model="params.search"
                class="px-2 py-1 placeholder-slate-300 text-slate-600 relative bg-white rounded text-sm border-0 mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow"
              />
            </div>
            <!-- Search -->

            <!-- View filter -->
            <div class="block">
              <span class="text-sm text-gray-500">No. per page: </span>
              <select
                ref="perpage"
                id="perpage"
                class="px-2 py-1 placeholder-slate-300 text-slate-600 relative bg-white rounded text-sm border-0 mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow"
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
            </div>
            <!-- View filter -->

            <!-- College filter -->
            <div class="block">
              <span class="text-sm text-gray-500">Category: </span>
              <select
                v-model="params.category"
                id="category"
                class="px-2 py-1 placeholder-slate-300 text-slate-600 relative bg-white rounded text-sm border-0 mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow"
              >
                <option
                  class="capitalize"
                  v-for="category in categories"
                  :value="category"
                >
                  <span>{{ category }}</span>
                </option>
              </select>
            </div>
            <!-- College filter -->

            <!-- clear -->
            <div class="block">
              <jet-button
                value="Clear Filter"
                @click="clearFilters()"
                v-if="
                  this.filters.search != null ||
                  this.filters.field != null ||
                  this.filters.direction != null ||
                  this.filters.category != null ||
                  this.filters.perpage != null
                "
                class="px-2 py-1 bg-white rounded text-sm border-0 mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow"
              >
                Clear Filters
              </jet-button>
            </div>
            <!-- clear -->
          </div>

          <div class="text-right">
            <jet-button
              class="inline-flex items-center px-4 py-2 mr-2 bg-emerald-200 hover:bg-emerald-300 text-emerald-800 text-sm font-medium rounded-md"
              @click="openModal(true)"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 mr-2"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
              New Question
            </jet-button>
          </div>
        </div>
      </div>

      <!-- List of exams -->
      <div>
        <div class="px-4 py-2 w-full bg-gray-700">
          <span class="uppercase tracking-wider text-white">List of Concerns</span>
        </div>
        <div class="flex flex-col">
          <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <!-- NO data -->
            <div v-if="!concerns.data.length">
              <div class="w-full py-8">
                <div class="p-4 text-center text-sm text-gray-800">
                  <span class="text-red-500 uppercase text-xl">No concerns found!</span>
                  <NoData />
                </div>
              </div>
            </div>
            <!-- NO data -->

            <div class="p-4 align-middle sm:px-8 lg:px-10">
              <!-- One row / data / card -->
              <div class="flex flex-wrap">
                <div
                  v-for="(concern, id) in concerns.data"
                  :key="concern.id"
                  class="w-full md:w-6/12 lg:w-4/12"
                >
                  <div
                    class="shadow overflow-hidden border-b border-gray-200 rounded-lg m-2 md:m-2 lg:m-4"
                  >
                    <div class="w-full bg-emerald-500 py-2 px-4 inline-flex">
                      <div align="right">{{ concern.category }}</div>
                    </div>
                    <div class="text-md">
                      <div class="px-2 pt-4">
                        <span class="text-gray-500 px-2">Question:</span>
                        <span> {{ concern.question }}</span>
                      </div>
                      <div class="px-2">
                        <span class="text-gray-500 px-2 break-all truncate">
                          Answer:
                        </span>
                        <span> {{ concern.answer }}</span>
                      </div>
                    </div>
                    <div
                      class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                      <button
                        @click="edit(concern, true)"
                        class="inline-flex items-center px-2 py-2 mr-2 bg-blue-200 hover:bg-blue-300 text-blue-800 text-sm font-medium rounded-md"
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
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                          />
                        </svg>
                      </button>

                      <button
                        @click="deleteRow(concern.id)"
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
      <jet-pagination class="m-5" :links="concerns.links" />
    </div>
  </admin-layout>

  <dialog-modal :show="isOpen" @close="openModal(false)">
    <template #title>
      <span v-show="!editMode"> Add New Concern/Question </span>
      <span v-show="editMode"> Update Concern/Question </span>
    </template>

    <template #content>
      <!-- Category -->
      <div class="mb-4">
        <jet-label for="category" value="Category" />
        <select
          v-show="!editMode"
          :required="true"
          v-model="form.category"
          id="category"
          class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        >
          <option
            class="capitalize"
            v-for="category in categories"
            :key="category"
            :value="category"
          >
            <span>{{ category }}</span>
          </option>
        </select>

        <select
          v-show="editMode"
          :required="true"
          v-model="form.category"
          id="category"
          class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        >
          <option
            class="capitalize"
            v-for="category in categories"
            :key="category"
            :value="category"
          >
            <span>{{ category }}</span>
          </option>
        </select>
      </div>

      <!-- Question -->
      <div class="mb-4">
        <jet-label for="question" value="Question/Label" />
        <textarea
          v-show="!editMode"
          v-model="form.question"
          id="question"
          type="text"
          class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        />
        <textarea
          v-show="editMode"
          v-model="form.question"
          id="question"
          type="text"
          class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        />
      </div>

      <!-- Answer -->
      <div class="mb-4">
        <jet-label for="answer" value="Answer/Information" />
        <textarea
          v-show="!editMode"
          v-model="form.answer"
          id="answer"
          type="text"
          class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        />
        <textarea
          v-show="editMode"
          v-model="form.answer"
          id="answer"
          type="text"
          class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        />
      </div>
    </template>

    <template #footer>
      <jet-secondary-button @click="openModal(false)"> Cancel </jet-secondary-button>

      <jet-button
        class="ml-2"
        v-show="!editMode"
        @click="save(form)"
        :class="{ 'opacity-25': disabled }"
        :disabled="disabled"
      >
        Save
      </jet-button>

      <jet-button
        class="ml-2"
        :class="{ 'opacity-25': disabled }"
        :disabled="disabled"
        v-show="editMode"
        @click="update(form)"
      >
        Update
      </jet-button>
    </template>
  </dialog-modal>

  <!-- Import modal -->
  <dialog-modal :show="importOpen" @close="importModal(false)">
    <template #title>
      <span> Import Data </span>
    </template>

    <template #content>
      <div class="mb-4">
        <jet-input
          type="file"
          class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 my-2"
          v-model="importForm.data_file"
        >
        </jet-input>
      </div>
    </template>

    <template #footer>
      <jet-secondary-button @click="importModal(false)"> Cancel </jet-secondary-button>

      <jet-button class="ml-2" @click="importData(importForm)"> Import </jet-button>
    </template>
  </dialog-modal>
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
    concerns: Object,
    filters: Object,
  },

  extends: shared,

  data() {
    return {
      params: {
        search: this.filters.search,
        field: this.filters.field,
        direction: this.filters.direction,
        category: this.filters.category,
        perpage: this.filters.perpage,
      },

      form: this.$inertia.form({
        category: "",
        question: "",
        answer: "",
      }),

      importForm: this.$inertia.form({
        data_file: null,
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

    // Import function
    importModal: function (status) {
      if (status == true) {
        this.importOpen = true;
      } else if (status == false) {
        this.importOpen = false;
      }

      return this.importOpen;
    },

    // Save function
    save: function (form) {
      this.$inertia.visit("/admin/chatbot", {
        method: "post",
        data: form,
        onSuccess: () => {
          this.form = {};
        },
        preserveScroll: true,
        preserveState: true,
      });
    },

    // Import data function
    importData: function (importForm) {
      this.$inertia.post(
        this.route("admin.chatbot.import", this.importForm),
        this.importForm,
        {}
      );

      this.$inertia.visit(route("admin.send.notif"), {
        method: "get",
        data: result,
      });
    },
    // Edit mode function
    edit: function (concern, status) {
      this.form = Object.assign({}, concern);
      this.editMode = true;
      this.openModal(status);
    },

    // Update function
    update: function (concern) {
      this.$inertia.visit("/admin/chatbot/" + concern.id, {
        method: "put",
        data: concern,
        onSuccess: () => {
          this.disabledClick(false), this.openModal(false);
        },
        onFinish: () => (this.form = {}),
        preserveScroll: true,
      });
    },

    // Delete function
    deleteRow: function (id) {
      this.$inertia.visit("/admin/chatbot/" + id, {
        method: "delete",
      });
    },

    // Clear filters

    clearFilters: function () {
      this.$inertia.get(this.route("admin.chatbot.index"), {});
    },
  },

  watch: {
    params: {
      handler: throttle(function () {
        let params = pickBy(this.params);

        this.$inertia.get(this.route("admin.chatbot.index"), params, {
          replace: true,
          preserveState: true,
        });
      }, 150),
      deep: true,
    },
  },
};
</script>
