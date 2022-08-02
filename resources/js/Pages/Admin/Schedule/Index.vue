<template>
  <admin-layout title="Examinations">
    <template #header>
      <!-- Header -->
      <div class="grid grid-cols-2 px-5 py-3 shadow-md rounded-md">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span>Schedules</span>
          </h2>
        </div>
        <!-- Header -->

        <!-- Page Buttons -->
        <div align="right">
          <!-- Line buttons and show dropdown -->
          <div class="block" align="right"></div>
          <!-- Hide in line buttons and show dropdown -->
        </div>
        <!-- End Page Buttons -->
      </div>
    </template>

    <!-- Search Field and Button -->
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
          <div class="" align="right">
            <div class="inline-block">
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
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                  />
                </svg>
                Create Schedule
              </jet-button>
            </div>

            <div class="inline-block">
              <jet-button
                @click="send"
                class="inline-flex items-center mr-2 mt-3 bg-blue-200 hover:bg-blue-300 text-blue-800 text-sm font-medium rounded-md"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5 mr-2 rotate-90"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  stroke-width="2"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
                  />
                </svg>
                Send Schedules
              </jet-button>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Table -->
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
                          @click="sort('sched_code')"
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
                                params.field === 'sched_code' &&
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
                                params.field === 'sched_code' &&
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
                          <div>Schedule Code</div></span
                        >
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <span
                          class="cursor-pointer inline-flex"
                          @click="sort('exam_name')"
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
                                params.field === 'exam_name' && params.direction === 'asc'
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
                                params.field === 'exam_name' &&
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
                          <div class="inline-block">Exam Name</div></span
                        >
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <span class="cursor-pointer inline-flex" @click="sort('date')">
                          <div>
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2"
                              v-if="params.field === 'date' && params.direction === 'asc'"
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
                                params.field === 'date' && params.direction === 'desc'
                              "
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"
                              />
                            </svg>
                          </div>
                          <div>Date</div>
                        </span>
                      </th>

                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <span
                          class="cursor-pointer inline-flex"
                          @click="sort('ctrl_num')"
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
                                params.field === 'ctrl_num' && params.direction === 'asc'
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
                                params.field === 'ctrl_num' && params.direction === 'desc'
                              "
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"
                              />
                            </svg>
                          </div>
                          <div>Control Number</div>
                        </span>
                      </th>

                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <span class="inline-flex">
                          <div>Exams</div>
                        </span>
                      </th>

                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <span class="cursor-pointer inline-flex" @click="sort('status')">
                          <div>
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2"
                              v-if="
                                params.field === 'status' && params.direction === 'asc'
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
                                params.field === 'status' && params.direction === 'desc'
                              "
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"
                              />
                            </svg>
                          </div>
                          <div>Status</div>
                        </span>
                      </th>
                      <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Edit</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-if="!schedules.data.length">
                      <td class="p-4 text-center text-sm text-gray-800" colspan="7">
                        <span class="text-red-500 uppercase text-xl"
                          >No schedules found!</span
                        >
                        <NoData />
                      </td>
                    </tr>
                    <tr v-for="schedule in schedules.data" :key="schedule">
                      <td class="px-6 py-4 whitespace-nowrap">
                        {{ schedule.sched_code }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        {{ schedule.sched_name }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        {{ schedule.date }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        {{ schedule.applicant_id }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <span v-for="exam in schedule.exams" v-bind:key="exam.id">
                          {{
                            schedule.exams.length >= 2
                              ? exam.subject + ", "
                              : exam.subject
                          }}
                        </span>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <span
                          v-if="schedule.status == 'pending'"
                          class="inline-flex items-center text-orange-800 bg-orange-200 px-2 text-sm font-medium rounded-md"
                        >
                          {{ schedule.status }}
                        </span>
                        <span
                          v-if="schedule.status == 'active'"
                          class="inline-flex items-center text-green-800 bg-green-200 px-2 text-sm font-medium rounded-md"
                        >
                          {{ schedule.status }}
                        </span>
                        <span
                          v-if="schedule.status == 'ended'"
                          class="inline-flex items-center text-red-800 bg-red-200 px-2 text-sm font-medium rounded-md"
                        >
                          {{ schedule.status }}
                        </span>
                      </td>
                      <td
                        class="px-6 py-4 space-x-1 whitespace-nowrap text-right text-sm font-medium"
                      >
                        <button
                          @click="edit(schedule, true)"
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
                          :disabled="disabled"
                          @click="deleteRow(schedule.id)"
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
                              d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"
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
      </div>
      <div class="mx-auto sm:px-6 lg:px-8">
        <jet-pagination class="m-5" :links="schedules.links" />
      </div>
    </div>
  </admin-layout>

  <dialog-modal :show="isOpen" @close="openModal(false)" class="overflow-visible">
    <template #title>
      <span v-show="!editMode"> Create Schedule </span>
      <span v-show="editMode"> Update </span>
    </template>

    <template #content>
      <!-- Name -->
      <div class="mb-4" v-if="editMode">
        <jet-label for="controlnum" value="Control number" />
        <b>{{ form.applicant_id }}</b>
      </div>

      <div class="mb-4">
        <jet-label for="sched_name" value="Exam Name" />
        <jet-input
          id="sched_name"
          ref="sched_name"
          type="text"
          class="mt-1 block w-full"
          v-model="form.sched_name"
          @keyup.enter="save(form)"
        />
      </div>

      <!-- Exams -->
      <div class="mb-4">
        <jet-label for="exams" value="Exams" />
        <div>
          <Multiselect
            v-model="form.exams"
            mode="tags"
            placeholder="Select exams"
            object="true"
            valueProp="id"
            :searchable="true"
            label="subject"
            :options="exam_names"
            @keyup.enter="save(form)"
          />
        </div>
      </div>

      <!-- Control Number Range -->
      <div class="mb-4" v-if="!editMode">
        <jet-label for="range" value="Control Number Range" />
        <div class="w-full inline-flex">
          <Multiselect
            v-model="form.start_ctrl_num"
            valueProp="id"
            :searchable="true"
            label="id"
            :options="applicants"
            :close-on-select="false"
            id="range"
          />
          <span class="mx-2">to</span>
          <Multiselect
            v-model="form.end_ctrl_num"
            valueProp="id"
            :searchable="true"
            label="id"
            :options="applicants"
            :close-on-select="false"
            id="range"
          />
        </div>
      </div>

      <!-- Sched Date -->
      <div class="mb-4">
        <!-- Start -->
        <jet-label for="date" value="Schedule Date" />
        <div class="w-full inline-flex">
          <DatePicker
            v-model="form.date"
            :min-date="new Date()"
            :disabled-dates="{ weekdays: [1, 7] }"
            id="date"
            class="bg-white border rounded w-full"
          >
            <template v-slot="{ inputValue, inputEvents }">
              <input
                :value="inputValue"
                v-on="inputEvents"
                class="bg-white border px-2 py-2 rounded w-full"
              />
            </template>
          </DatePicker>
        </div>
      </div>
    </template>

    <template #footer>
      <jet-secondary-button @click="openModal(false)"> Cancel </jet-secondary-button>

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
import DialogModal from "@/Jetstream/DialogModal";
import JetPagination from "@/Components/Pagination";
import { Link } from "@inertiajs/inertia-vue3";
import shared from "@/Scripts/shared";
import Multiselect from "@vueform/multiselect";
import { DatePicker } from "v-calendar";
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
    DialogModal,
    Link,
    Multiselect,
    DatePicker,
    NoData,
  },

  props: {
    schedules: Object,
    applicants: Object,
    filters: Object,
    exam_names: Array,
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
        exams: [],
        applicant_id: "",
        sched_name: "",
        start_ctrl_num: "",
        end_ctrl_num: "",
        date: "",
      }),

      // Control number checker
      ctrl_numbers: [],

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

    // Save function
    save: function (schedules) {
      this.$inertia.visit("/admin/schedules", {
        method: "post",
        data: this.form,
        onBefore: () => {
          this.disabledClick(true);
        },
        onSuccess: () => {
          this.disabledClick(false), (this.form = {});
          this.isOpen = false;
        },
      });
    },

    // Edit mode function
    edit: function (schedule, status) {
      this.form = Object.assign({}, schedule);
      this.editMode = true;
      this.openModal(status);
    },

    // Update function
    update: function (schedule) {
      this.$inertia.visit("/admin/schedules/" + schedule.id, {
        method: "put",
        data: schedule,
      });
    },

    // Delete function
    deleteRow: function (id) {
      this.$inertia.visit("/admin/schedules/" + id, {
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

    // Send
    send: function () {
      this.$inertia.visit(this.route("admin.send.schedule"), {});
    },

    // Sort function
    sort(field) {
      this.params.field = field;
      this.params.direction = this.params.direction === "asc" ? "desc" : "asc";
    },
  },

  watch: {
    params: {
      handler: throttle(function () {
        let params = pickBy(this.params);

        this.$inertia.get(this.route("admin.schedules.index"), params, {
          replace: true,
          preserveState: true,
        });
      }, 150),
      deep: true,
    },
  },
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
