<template>
  <admin-layout title="Colleges">
    <template #header>
      <!-- Header -->
      <div class="grid grid-cols-2 px-5 py-3 shadow-md rounded-md">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span>Colleges</span>
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
          </div>
          
          <div class="text-right">
            <jet-button
              class="inline-flex items-center px-4 py-2 mr-2 bg-emerald-200 hover:bg-emerald-300 text-emerald-800 text-sm font-medium rounded-md"
              @click="openModal(true)"
              ><svg
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
                  d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
              New College
            </jet-button>
          </div>
        </div>
      </div>

      <div class="bg-white shadow-xl sm:rounded-lg">
        <div class="flex flex-col">
          <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
              <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <span
                          class="cursor-pointer inline-flex"
                          @click="sort('college_name')"
                        >
                          <div>
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2"
                              v-if="
                                params.field === 'college_name' &&
                                params.direction === 'asc'
                              "
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"
                              />
                            </svg>
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2"
                              v-if="
                                params.field === 'college_name' &&
                                params.direction === 'desc'
                              "
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"
                              />
                            </svg>
                          </div>
                          <div>College Name</div>
                        </span>
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <span class="cursor-pointer" @click="sort('college_desc')">
                          <div class="inline-block">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2"
                              v-if="
                                params.field === 'college_desc' &&
                                params.direction === 'asc'
                              "
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"
                              />
                            </svg>
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2"
                              v-if="
                                params.field === 'college_desc' &&
                                params.direction === 'desc'
                              "
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"
                              />
                            </svg>
                          </div>
                          <div class="inline-block">College Description</div></span
                        >
                      </th>
                      <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Edit</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-if="!colleges.data.length">
                      <td class="p-4 text-center text-sm text-gray-800" colspan="7">
                        <!-- NO data -->
                        <span class="text-red-500 uppercase text-xl">No exam found!</span>
                        <NoData />
                        <!-- NO data -->
                      </td>
                    </tr>
                    <tr v-for="college in colleges.data" :key="college.id">
                      <td class="px-6 py-1 whitespace-nowrap">
                        {{ college.college_name }}
                      </td>
                      <td class="px-6 py-1 whitespace-nowrap">
                        {{ college.college_desc }}
                      </td>
                      <td
                        class="px-6 py-1 space-x-1 whitespace-nowrap text-right text-sm font-medium"
                      >
                        <button
                          @click="edit(college, true)"
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
                          @click="deleteRow(college.id)"
                          class="inline-flex items-center px-2 py-2 mr-2 bg-red-200 hover:bg-red-300 text-red-800 text-sm font-medium rounded-md"
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
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="mx-auto sm:px-6 lg:px-8">
          <jet-pagination class="m-5" :links="colleges.links" />
        </div>
      </div>
    </div>
  </admin-layout>

  <dialog-modal :show="isOpen" @close="openModal(false)">
    <template #title>
      <span v-show="!editMode"> Add New College </span>
      <span v-show="editMode"> Update College </span>
    </template>

    <template #content>
      <!-- Name -->
      <div class="mb-4">
        <jet-label for="college_name" value="College Code (ex. CEIT)" />
        <jet-input
          id="college_name"
          ref="college_name"
          type="text"
          class="mt-1 block w-full"
          v-model="form.college_name"
        />
      </div>

      <!-- Desription -->
      <div class="mb-4">
        <jet-label for="college_desc" value="College Description" />
        <jet-input
          id="college_desc"
          type="text"
          class="mt-1 block w-full"
          v-model="form.college_desc"
          @keyup.enter="save(form)"
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
    colleges: Object,
    filters: Object,
  },

  extends: shared,

  data() {
    return {
      params: {
        search: this.filters.search,
        field: this.filters.field,
        direction: this.filters.direction,
        perpage: this.filters.perpage,
      },

      form: this.$inertia.form({
        college_name: this.college_name,
        college_desc: this.college_desc,
      }),

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
        // this.$refs.taskname.focus();
      } else if (status == false) {
        this.form = {};
        this.isOpen = false;
        this.editMode = false;
      }

      return this.isOpen;
    },

    // Sort function
    sort(field) {
      this.params.field = field;
      this.params.direction = this.params.direction === "asc" ? "desc" : "asc";
    },

    // Save function
    save: function (colleges) {
      this.$inertia.visit("/admin/colleges", {
        method: "post",
        data: colleges,
        onBefore: () => {
          this.disabledClick(true);
        },
        onSuccess: () => {
          this.disabledClick(false), this.openModal(false), (this.form = {});
        },
        preserveScroll: true,
        preserveState: true,
      });
    },

    // Edit mode function
    edit: function (college, status) {
      this.form = Object.assign({}, college);
      this.editMode = true;
      this.openModal(status);
    },

    // Update function
    update: function (college) {
      this.$inertia.visit("/admin/colleges/" + college.id, {
        method: "put",
        data: college,
        onBefore: () => {
          this.disabledClick(true);
        },
        onSuccess: () => {
          this.disabledClick(false), this.openModal(false);
        },
        onFinish: () => (this.form = {}),
        preserveScroll: true,
      });
    },

    // Delete function
    deleteRow: function (id) {
      this.$inertia.visit("/admin/colleges/" + id, {
        method: "delete",
        preserveScroll: true,
        onBefore: () => {
          this.disabledClick(true);
        },
        onSuccess: () => {
          this.disabledClick(false);
        },
      });
    },
  },

  watch: {
    params: {
      handler: throttle(function () {
        let params = pickBy(this.params);

        this.$inertia.get(this.route("admin.colleges.index"), params, {
          replace: true,
          preserveState: true,
        });
      }, 150),
      deep: true,
    },
  },
};
</script>
