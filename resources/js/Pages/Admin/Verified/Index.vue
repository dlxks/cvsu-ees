<template>
  <admin-layout title="Examinations">
    <template #header>
      <!-- Header -->
      <div class="grid grid-cols-2 px-5 py-3 shadow-md rounded-md">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span>Results Verification</span>
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
                      @click="exportData('xlsx')"
                      class="inline-flex items-center px-4 py-2 mr-2 bg-blue-200 hover:bg-blue-300 text-blue-800 text-sm font-medium rounded-md"
                    >
                      Export(.csv)
                    </jet-button>
                  </div>
                  <div class="py-1">
                    <jet-button
                      @click="exportPDF()"
                      class="inline-flex items-center px-4 py-2 mr-2 bg-blue-200 hover:bg-blue-300 text-blue-800 text-sm font-medium rounded-md"
                    >
                      Save PDF
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

    <!-- Search Field and Button -->
    <div class="py-12">
      <div class="mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 px-5 py-3">
          <div>
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

            <!-- Status Filter -->
            <span class="text-sm text-gray-500 w-2">Status: </span>
            <select
              ref="status"
              id="status"
              class="px-2 py-1 placeholder-slate-300 text-slate-600 relative bg-white rounded text-sm border-0 mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow"
              v-model="params.status"
            >
              <option
                v-for="qualification in qualifications"
                :key="qualification"
                :value="qualification"
                class="capitalize"
              >
                <span>{{ qualification }}</span>
              </option>
            </select>
            <!-- Status Filter -->

            <!-- Course filter -->
            <div class="block">
              <div class="lg:w-60" >
                <span class="text-sm text-gray-500">Select Course: </span>
                <div class="text-xs">
                  <Multiselect
                    v-model="params.course"
                    placeholder="Select course"
                    valueProp="course_name"
                    :searchable="true"
                    label="course_desc"
                    :options="courses"
                    class="text-xs"
                  />
                </div>
              </div>
            </div>
            <!-- Course filter -->

            <!-- clear -->
            <div class="block">
              <jet-button
                value="Clear Filter"
                @click="clearFilters()"
                v-if="
                  this.filters.search != null ||
                  this.filters.field != null ||
                  this.filters.direction != null ||
                  this.filters.course != null ||
                  this.filters.status != null ||
                  this.filters.perpage != null
                "
                class="px-2 py-1 bg-white rounded text-sm border-0 mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow"
              >
                Clear Filters
              </jet-button>
            </div>
            <!-- clear -->
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
                        <span class="cursor-pointer flex"> ID </span>
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <span class="cursor-pointer flex" @click="sort('applicant_id')">
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                            v-if="
                              params.field === 'applicant_id' &&
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
                              params.field === 'applicant_id' &&
                              params.direction === 'desc'
                            "
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"
                            />
                          </svg>
                          Control Number
                        </span>
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <span class="cursor-pointer flex" @click="sort('name')">
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                            v-if="params.field === 'name' && params.direction === 'asc'"
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
                            v-if="params.field === 'name' && params.direction === 'desc'"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"
                            />
                          </svg>
                          Name
                        </span>
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <span class="cursor-pointer flex" @click="sort('rating')">
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                            v-if="params.field === 'rating' && params.direction === 'asc'"
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
                              params.field === 'rating' && params.direction === 'desc'
                            "
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"
                            />
                          </svg>
                          Rating
                        </span>
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <span class="cursor-pointer flex" @click="sort('course_applied')">
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                            v-if="
                              params.field === 'course_applied' &&
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
                              params.field === 'course_applied' &&
                              params.direction === 'desc'
                            "
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"
                            />
                          </svg>
                          Course
                        </span>
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <span class="cursor-pointer flex" @click="sort('status')">
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                            v-if="params.field === 'status' && params.direction === 'asc'"
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
                          Status
                        </span>
                      </th>
                      <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Edit</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-if="!verifieds.data.length">
                      <td class="p-4 text-center text-sm text-gray-800" colspan="7">
                        <span class="text-red-500 uppercase text-xl"
                          >No Results Found</span
                        >
                        <NoData />
                      </td>
                    </tr>
                    <tr
                      v-for="(verified, index) in verifieds.data"
                      v-bind:key="verified.id"
                      class="text-sm"
                    >
                      <td class="px-6 py-1 whitespace-nowrap">
                        {{ index + 1 }}
                      </td>
                      <td class="px-6 py-1 whitespace-nowrap">
                        {{ verified.applicant_id }}
                      </td>
                      <td class="px-6 py-1 whitespace-nowrap">
                        {{ verified.name }}
                      </td>
                      <td class="px-6 py-1 whitespace-nowrap">
                        {{ verified.rating }}
                      </td>
                      <td class="px-6 py-1 whitespace-nowrap">
                        {{ verified.course_applied }}
                      </td>
                      <td class="px-6 py-1 whitespace-nowrap">
                        <span
                          v-if="verified.status == 'pending'"
                          class="inline-flex items-center text-orange-800 bg-orange-200 px-2 text-sm font-medium rounded-md"
                        >
                          {{ verified.status }}
                        </span>
                        <span
                          v-if="verified.status == 'qualified'"
                          class="inline-flex items-center text-green-800 bg-green-200 px-2 text-sm font-medium rounded-md"
                        >
                          {{ verified.status }}
                        </span>
                        <span
                          v-if="verified.status == 'not qualified'"
                          class="inline-flex items-center text-red-800 bg-red-200 px-2 text-sm font-medium rounded-md"
                        >
                          {{ verified.status }}
                        </span>
                      </td>
                      <td
                        class="px-6 py-1 space-x-1 whitespace-nowrap text-right text-sm font-medium"
                      >
                        <button
                          class="inline-flex items-center px-4 py-2 bg-blue-200 hover:bg-blue-300 text-blue-800 text-sm font-medium rounded-md"
                          v-if="verified.status == 'pending'"
                          @click="verify(verified)"
                        >
                          Verify
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 ml-1"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                          </svg>
                        </button>
                        <button
                          class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md"
                          :class="
                            verified.status == 'qualified'
                              ? 'bg-emerald-200 hover:bg-emerald-300 text-emerald-800'
                              : 'bg-red-200 hover:bg-red-300 text-red-800'
                          "
                          v-if="
                            verified.status == 'qualified' ||
                            verified.status == 'not qualified'
                          "
                          @click="verify(verified)"
                        >
                          Verified
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 ml-1"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
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
          <jet-pagination class="m-5" :links="verifieds.links" />
        </div>
      </div>
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
import JetPagination from "@/Components/Pagination";
import { Link } from "@inertiajs/inertia-vue3";
import shared from "@/Scripts/shared";
import Multiselect from "@vueform/multiselect";
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
    Link,
    Multiselect,
    NoData,
  },

  extends: shared,

  props: {
    verifieds: Object,
    filters: Object,
    courses: Object,
  },

  data() {
    return {
      isOpen: false,
      disabled: null,
      editMode: false,

      params: {
        search: this.filters.search,
        field: this.filters.field,
        direction: this.filters.direction,
        course: this.filters.course,
        status: this.filters.status,
      },
    };
  },

  methods: {
    // Sort function
    sort(field) {
      this.params.field = field;
      this.params.direction = this.params.direction === "asc" ? "desc" : "asc";
    },

    // Verify
    verify: function (result) {
      this.$inertia.visit(route("admin.verified.show", result));
      this.form = Object.assign({}, result);
    },

    // Export function
    exportData: function (type) {
      const url = "/admin/export/verified?type=" + type;
      window.location.href = url;
    },

    // Export function
    exportPDF: function () {
      const url = "/admin/pdf/verified";
      window.location.href = url;
    },

    //Clear filters
    clearFilters: function () {
      this.$inertia.get(this.route("admin.verified.index"), {});
    },
  },

  watch: {
    params: {
      handler: throttle(function () {
        let params = pickBy(this.params);

        this.$inertia.get(this.route("admin.verified.index"), params, {
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
<style src="@vueform/multiselect/themes/tailwind.css"></style>
