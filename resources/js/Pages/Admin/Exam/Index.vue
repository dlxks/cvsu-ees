<template>
  <admin-layout title="Examinations">
    <template #header>
      <!-- Header -->
      <div class="grid grid-cols-2 px-5 py-3 shadow-md rounded-md">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span>Examinations</span>
          </h2>
        </div>
        <!-- Header -->
      </div>
    </template>

    <div class="py-12">
      <!-- Search Field and Button -->
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
              class="inline-flex items-center mr-2 bg-emerald-200 hover:bg-emerald-300 text-emerald-800 text-sm font-medium rounded-md"
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
                  d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"
                />
              </svg>
              Create Exam
            </jet-button>
          </div>
        </div>
      </div>

      <!-- List of exams -->
      <div>
        <div class="px-4 py-2 w-full bg-gray-700">
          <span class="uppercase tracking-wider text-white">List of Exams</span>
        </div>
        <div class="flex flex-col">
          <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <!-- NO data -->
            <div v-if="!exams.data.length">
              <div class="w-full py-8">
                <div class="p-4 text-center text-sm text-gray-800">
                  <span class="text-red-500 uppercase text-xl">No exam found!</span>
                  <NoData />
                </div>
              </div>
            </div>
            <!-- NO data -->

            <div class="p-4 align-middle sm:px-8 lg:px-10">
              <!-- One row / data / card -->
              <div class="flex flex-wrap">
                <div
                  v-for="(exam, id) in exams.data"
                  :key="exam.id"
                  class="w-full md:w-6/12 lg:w-4/12"
                >
                  <div
                    class="shadow overflow-hidden border-b border-gray-200 rounded-lg m-2 md:m-2 lg:m-4"
                  >
                    <div class="w-full bg-emerald-500 py-2 px-4 inline-flex">
                      <span class="mr-2 text-xl text-white"> {{ exam.exam_code }}</span>
                      <div align="right">
                        <!-- Active/Inactive -->
                        <!-- Active -->
                        <span
                          v-if="exam.status == 'active'"
                          class="inline-flex items-center text-emerald-800 bg-emerald-200 px-2 text-sm font-medium rounded-md"
                        >
                          Active
                        </span>
                        <!-- Inactive -->
                        <span
                          v-if="exam.status == 'inactive'"
                          class="inline-flex items-center text-red-800 bg-red-200 px-2 text-sm font-medium rounded-md"
                        >
                          Inactive
                        </span>
                        <!-- Active/Inactive -->
                      </div>
                    </div>
                    <div class="text-md">
                      <div class="px-2 pt-4">
                        <span class="text-gray-500 px-2">Title:</span>
                        <span> {{ exam.subject }}</span>
                      </div>
                      <div class="px-2">
                        <span class="text-gray-500 px-2 break-all truncate">
                          Description:
                        </span>
                        <span> {{ exam.description }}</span>
                      </div>
                      <div class="px-2">
                        <span class="text-gray-500 px-2 break-all truncate">
                          Duration:
                        </span>
                        <span> {{ exam.duration }}</span>
                      </div>
                    </div>
                    <div
                      class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                      <button
                        @click="show(exam)"
                        class="inline-flex items-center px-2 py-2 mr-2 bg-yellow-200 hover:bg-yellow-300 text-yellow-800 text-sm font-medium rounded-md"
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
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                          />
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                          />
                        </svg>
                      </button>

                      <button
                        @click="edit(exam, true)"
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
                        @click="deleteRow(exam.id)"
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
      <jet-pagination class="m-5" :links="exams.links" />
    </div>
  </admin-layout>

  <dialog-modal :show="isOpen" @close="openModal(false)">
    <template #title>
      <span> Create Exam </span>
    </template>

    <template #content>
      <!-- Subject -->
      <div class="mb-4">
        <jet-label for="subject" value="Subject" />
        <jet-input
          id="subject"
          type="text"
          class="mt-1 block w-full"
          v-model="form.subject"
          v-show="!editMode"
          @keyup.enter="save(form)"
        />
        <jet-input
          id="subject"
          type="text"
          class="mt-1 block w-full"
          v-model="form.subject"
          v-show="editMode"
          @keyup.enter="update(form)"
        />
      </div>

      <!-- Description -->
      <div class="mb-4">
        <jet-label for="description" value="Description" />
        <textarea
          id="description"
          type="text"
          class="px-2 py-1  relative bg-white rounded mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm block w-full"
          v-model="form.description"
          v-show="!editMode"
          @keyup.enter="save(form)"
        />
        <textarea
          id="description"
          type="text"
          class="px-2 py-1  relative bg-white rounded mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm block w-full"
          v-model="form.description"
          v-show="editMode"
          @keyup.enter="update(form)"
        />
      </div>

      <!-- Duration -->
      <div class="mb-4">
        <jet-label for="duration" value="Duration (in minutes)" />
        <jet-input
          id="duration"
          type="number"
          class="mt-1 block w-full"
          v-model="form.duration"
          v-show="!editMode"
          @keyup.enter="save(form)"
        />
        <jet-input
          id="duration"
          type="number"
          class="mt-1 block w-full"
          v-model="form.duration"
          v-show="editMode"
          @keyup.enter="update(form)"
        />
      </div>

      <!-- Status -->
      <div class="mb-4" v-show="editMode">
        <jet-label for="status" value="Status" />
        <select
          ref="status"
          id="status"
          class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
          v-model="form.status"
          @keyup.enter="update(form)"
        >
          <option
            v-for="status in status"
            :key="status"
            :value="status"
            class="capitalize"
          >
            <span>{{ status }}</span>
          </option>
        </select>
      </div>
    </template>

    <template #footer>
      <jet-secondary-button @click="openModal(false)"> Close </jet-secondary-button>

      <jet-button
        class="ml-2"
        v-show="!editMode"
        :class="{ 'opacity-25': disabled }"
        :disabled="disabled"
        @click="save(form)"
        @keyup.enter="save(form)"
      >
        Save
      </jet-button>

      <jet-button
        class="ml-2"
        :class="{ 'opacity-25': disabled }"
        :disabled="disabled"
        v-show="editMode"
        @click="update(form)"
        @keyup.enter="update(form)"
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
    exams: Object,
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
        subject: this.subject,
        description: this.description,
        duration: this.duration,
        status: "",
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

    show: function (id) {
      this.$inertia.visit(route("admin.exams.show", id));
    },

    // Save function
    save: function (exams) {
      this.$inertia.visit("/admin/exams", {
        method: "post",
        data: exams,
        onBefore: () => {
          this.disabledClick(true);
        },
        onSuccess: () => {
          this.disabledClick(false), (this.form = {});
        },
      });
    },

    // Edit mode function
    edit: function (exam, status) {
      this.form = Object.assign({}, exam);
      this.editMode = true;
      this.openModal(status);
    },

    // Update function
    update: function (exam) {
      this.$inertia.visit("/admin/exams/" + exam.id, {
        method: "put",
        data: exam,
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
      this.$inertia.visit("/admin/exams/" + id, {
        method: "delete",
      });
    },

    // Active / inactive status
    statusChange: function (status, exam) {
      this.$inertia.visit("/admin/status/" + exam, {
        method: "post",
        data: status,
      });
    },
  },

  watch: {
    params: {
      handler: throttle(function () {
        let params = pickBy(this.params);

        this.$inertia.get(this.route("admin.exams.index"), params, {
          replace: true,
          preserveState: true,
        });
      }, 150),
      deep: true,
    },
  },
};
</script>
