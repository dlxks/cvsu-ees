<template>
  <applicant-layout title="Applicant">
    <template #header>
      <!-- Header -->
      <div class="grid grid-cols-2 px-5 py-3 shadow-md rounded-md">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span>Dashboard</span>
          </h2>
        </div>
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
                  <div class="w-full lg:w-6/12 xl:w-6/12 px-4">
                    <div
                      class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg"
                    >
                      <div class="flex-auto p-8">
                        <div class="flex flex-wrap">
                          <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                            <h5 class="text-gray-400 uppercase font-bold text-md">
                              Exam Schedule
                            </h5>
                            <div class="py-2" v-if="schedule && schedule.status !== 'ended'">
                              <div class="py-4">
                                <span
                                  class="font-semibold text-xl block"
                                  :class="
                                    schedule.status === 'ended'
                                      ? 'text-red-900'
                                      : 'text-blue-900'
                                  "
                                >
                                  <span class="text-sm text-gray-500">Code:</span>
                                  {{ schedule.sched_code }}
                                </span>
                                <span
                                  class="font-semibold text-xl block"
                                  :class="
                                    schedule.status === 'ended'
                                      ? 'text-red-900'
                                      : 'text-blue-900'
                                  "
                                >
                                  <span class="text-sm text-gray-500">Batch:</span>
                                  {{ schedule.sched_name }}
                                </span>
                                <span
                                  class="font-semibold text-xl block"
                                  :class="
                                    schedule.status === 'ended'
                                      ? 'text-red-900'
                                      : 'text-blue-900'
                                  "
                                >
                                  <span class="text-sm text-gray-500">Date:</span>
                                  {{ schedule.date }}
                                </span>
                              </div>
                              <div class="py-4">
                                <span class="text-gray-500">Status: </span>
                                <span
                                  v-show="schedule.status == 'pending'"
                                  class="font-semibold text-xl text-yellow-700 block uppercase"
                                >
                                  {{ schedule.status }}
                                </span>
                                <span
                                  v-show="schedule.status == 'active'"
                                  class="font-semibold text-xl text-emerald-700 block uppercase"
                                >
                                  {{ schedule.status }}
                                </span>
                                <span
                                  v-show="schedule.status == 'ended'"
                                  class="font-semibold text-xl text-red-700 block uppercase"
                                >
                                  {{ schedule.status }}
                                </span>
                              </div>
                            </div>

                            <!-- no sched -->
                            <div class="py-2" v-if="!schedule || schedule.status === 'ended'">
                              <span class="font-semibold text-md block text-gray-500">
                                You have no current schedule of exam.
                              </span>
                            </div>
                            <!-- no sched -->
                          </div>
                          <div class="relative w-auto pl-4 flex-initial hidden sm:block">
                            <div
                              class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-blue-500"
                            >
                              <Link :href="route('applicant.exams.index')">
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
                              </Link>
                            </div>
                          </div>
                        </div>
                        <p class="text-sm text-gray-400 mt-4">
                          <Link
                            class="cursor-pointer mr-2 text-emerald-500 hover:text-emerald-700 hover:animate-pulse"
                            :href="route('applicant.exams.index')"
                          >
                            <span class="inline-flex">
                              See exam
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
                  <div class="w-full lg:w-6/12 xl:w-6/12 px-4">
                    <div
                      class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg"
                    >
                      <div class="flex-auto p-8">
                        <div class="flex flex-wrap">
                          <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                            <h5 class="text-gray-400 uppercase font-bold text-md">
                              Results
                            </h5>
                            <div
                              class="py-2 uppercase font-semibold text-xl text-gray-700"
                              v-if="result"
                            >
                              <span class="block">
                                <span class="text-gray-500 text-sm">Score: </span>
                                {{ result.rating }}
                              </span>
                              <span class="block">
                                <span class="text-gray-500 text-sm">Status: </span>
                                {{ result.status }}
                              </span>
                            </div>
                          </div>
                          <div class="relative w-auto pl-4 flex-initial hidden sm:block"> 
                            <Link
                              class="cursor-pointer"
                              :href="route('applicant.results.index')"
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

                        <!-- no results -->
                        <div class="py-2" v-if="!result">
                          <span class="font-semibold text-md block text-gray-500">
                            No results found.
                          </span>
                        </div>
                        <!-- no results -->
                        <p class="text-sm text-gray-400 mt-4">
                          <Link
                            class="cursor-pointer mr-2 text-emerald-500 hover:text-emerald-700 hover:animate-pulse"
                            :href="route('applicant.results.index')"
                          >
                            <span class="inline-flex">
                              See results
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
  </applicant-layout>
</template>

<script>
import ApplicantLayout from "@/Layouts/ApplicantLayout";
import { reactive, watchEffect } from "vue";
import { pickBy, throttle } from "lodash";
import { Inertia } from "@inertiajs/inertia";
import { Link } from "@inertiajs/inertia-vue3";
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";
import { Calendar, DatePicker } from "v-calendar";

export default {
  components: {
    ApplicantLayout,
    Link,
    JetSectionBorder,
    Calendar,
    DatePicker,
  },

  props: {
    schedule: Object,
    result: Object,
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

  methods: {},
};
</script>
