<template>
  <admin-layout title="Dashboard">
    <template #header>
      <!-- Header -->
      <div class="grid grid-cols-2 px-5 py-3 shadow-md rounded-md">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span>Dashboard</span>
          </h2>
        </div>
        <!-- Header -->
      </div>
    </template>

    <!-- Full dashboard -->
    <div>
      <div class="flex flex-wrap mt-8">
        <!-- Left side -->
        <div class="w-full lg:w-8/12">
          <div class="px-4 py-2 w-full bg-gray-700">
            <span class="uppercase tracking-wider text-white">Statistics</span>
          </div>
          <div class="relative md:pt-6 pb-6 pt-12">
            <div class="mx-auto w-full">
              <div>
                <div class="flex flex-wrap">
                  <!-- Card -->
                  <div class="w-full lg:w-6/12 xl:w-4/12 px-4">
                    <div
                      class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg"
                    >
                      <div class="flex-auto p-4">
                        <div class="flex flex-wrap">
                          <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                            <h5 class="text-gray-400 uppercase font-bold text-xs">
                              Applicants
                            </h5>
                            <span class="font-semibold text-xl text-gray-700">
                              {{ noOfApplicants }}
                            </span>
                          </div>
                          <div class="relative w-auto pl-4 flex-initial">
                            <Link
                              class="cursor-pointer"
                              :href="route('admin.applicants.index')"
                            >
                              <div
                                class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-red-500"
                              >
                                <svg
                                  xmlns="http://www.w3.org/2000/svg"
                                  class="h-5 w-5"
                                  viewBox="0 0 20 20"
                                  fill="currentColor"
                                >
                                  <path
                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"
                                  />
                                </svg>
                              </div>
                            </Link>
                          </div>
                        </div>
                        <p class="text-sm text-gray-400 mt-4">
                          <Link
                            class="cursor-pointer mr-2 text-emerald-500 hover:text-emerald-700 hover:animate-pulse"
                            :href="route('admin.applicants.index')"
                          >
                            <span class="inline-flex">
                              See more
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                              >
                                <path
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M13 7l5 5m0 0l-5 5m5-5H6"
                                />
                              </svg>
                            </span>
                          </Link>
                        </p>
                      </div>
                    </div>
                  </div>
                  <!-- Card -->
                  <!-- Card -->
                  <div class="w-full lg:w-6/12 xl:w-4/12 px-4">
                    <div
                      class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg"
                    >
                      <div class="flex-auto p-4">
                        <div class="flex flex-wrap">
                          <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                            <h5 class="text-gray-400 uppercase font-bold text-xs">
                              Exams
                            </h5>
                            <span class="font-semibold text-xl text-gray-700">
                              {{ noOfExams }}
                            </span>
                          </div>
                          <div class="relative w-auto pl-4 flex-initial">
                            <Link
                              class="cursor-pointer"
                              :href="route('admin.exams.index')"
                            >
                              <div
                                class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-emerald-500"
                              >
                                <svg
                                  xmlns="http://www.w3.org/2000/svg"
                                  class="h-5 w-5"
                                  viewBox="0 0 20 20"
                                  fill="currentColor"
                                >
                                  <path
                                    fill-rule="evenodd"
                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                    clip-rule="evenodd"
                                  />
                                </svg>
                              </div>
                            </Link>
                          </div>
                        </div>
                        <p class="text-sm text-gray-400 mt-4">
                          <Link
                            class="cursor-pointer mr-2 text-emerald-500 hover:text-emerald-700 hover:animate-pulse"
                            :href="route('admin.exams.index')"
                          >
                            <span class="inline-flex">
                              See more
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                              >
                                <path
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M13 7l5 5m0 0l-5 5m5-5H6"
                                />
                              </svg>
                            </span>
                          </Link>
                        </p>
                      </div>
                    </div>
                  </div>
                  <!-- Card -->
                  <!-- Card -->
                  <div class="w-full lg:w-6/12 xl:w-4/12 px-4">
                    <div
                      class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg"
                    >
                      <div class="flex-auto p-4">
                        <div class="flex flex-wrap">
                          <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                            <h5 class="text-gray-400 uppercase font-bold text-xs">
                              Pending Schedules
                            </h5>
                            <span class="font-semibold text-xl text-gray-700">
                              {{ noOfSched }}
                            </span>
                          </div>
                          <div class="relative w-auto pl-4 flex-initial">
                            <Link
                              class="cursor-pointer"
                              :href="route('admin.schedules.index')"
                            >
                              <div
                                class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-blue-500"
                              >
                                <svg
                                  xmlns="http://www.w3.org/2000/svg"
                                  class="h-5 w-5"
                                  viewBox="0 0 20 20"
                                  fill="currentColor"
                                >
                                  <path
                                    fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd"
                                  />
                                </svg>
                              </div>
                            </Link>
                          </div>
                        </div>
                        <p class="text-sm text-gray-400 mt-4">
                          <Link
                            class="cursor-pointer mr-2 text-emerald-500 hover:text-emerald-700 hover:animate-pulse"
                            :href="route('admin.schedules.index')"
                          >
                            <span class="inline-flex">
                              See more
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                              >
                                <path
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M13 7l5 5m0 0l-5 5m5-5H6"
                                />
                              </svg>
                            </span>
                          </Link>
                        </p>
                      </div>
                    </div>
                  </div>
                  <!-- Card -->
                </div>
              </div>
            </div>
          </div>

          <!-- Table div -->
          <div class="px-4 py-2 w-full bg-gray-700 mt-12">
            <span class="uppercase tracking-wider text-white"
              >Incoming Exam Schedules</span
            >
          </div>
          <div class="relative md:pt-6 pb-6 pt-12">
            <div class="flex flex-col">
              <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                  <div
                    class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"
                  >
                    <table class="min-w-full divide-y divide-gray-200">
                      <thead class="bg-gray-50">
                        <tr>
                          <th
                            scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                          >
                            Schedule Code
                          </th>
                          <th
                            scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                          >
                            Exam Name
                          </th>
                          <th
                            scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                          >
                            Date
                          </th>

                          <th
                            scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                          >
                            Status
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
                        <tr v-for="schedule in schedules.data" :key="schedule.id">
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
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="mx-auto sm:px-6 lg:px-8">
                <jet-pagination class="m-5" :links="schedules.links" />
              </div>
            </div>
          </div>

          <!-- Table div -->
        </div>
        <!-- Left side -->

        <!-- Right side -->
        <div class="w-full lg:w-4/12">
          <div class="px-4 py-2 w-full bg-emerald-600">
            <span class="uppercase tracking-wider text-white">Calendar</span>
          </div>
          <div class="relative md:pt-6 pb-6 pt-12">
            <div class="mx-auto w-full">
              <!-- <h5>Calendar</h5> -->
              <div class="px-4">
                <Calendar :attributes="attrs" disable-page-swipe is-expanded> </Calendar>
              </div>
            </div>
          </div>
        </div>
        <!-- Right side -->
      </div>
    </div>
    <!-- Full dashboard -->
  </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Calendar, DatePicker } from "v-calendar";
import JetPagination from "@/Components/Pagination";
import NoData from "@/Components/Fillers/NoData.vue";

export default {
  components: {
    AdminLayout,
    Link,
    Calendar,
    DatePicker,
    JetPagination,
    NoData,
  },

  props: {
    noOfExams: Number,
    noOfApplicants: Number,
    noOfSched: Number,
    schedules: Object,
  },

  data() {
    return {
      attrs: [
        {
          key: "today",
          highlight: true,
          dates: new Date(),
        },
      ],
    };
  },
};
</script>
