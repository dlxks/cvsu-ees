<template>
  <home-layout title="Home">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Full dashboard -->
        <div>
          <div class="flex flex-wrap mt-8">
            <!-- Left side -->
            <div class="w-full lg:w-8/12">
              <!-- Table div -->
              <div class="px-4 py-2 w-full bg-gray-700">
                <span class="uppercase tracking-wider text-white">Schedules</span>
              </div>

              <div class="relative md:pt-6 pb-6 pt-12">
                <div class="flex flex-col">
                  <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div
                      class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
                    >
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
                              <td
                                class="p-4 text-center text-sm text-gray-800"
                                colspan="7"
                              >
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
                    <Calendar :attributes="attrs" disable-page-swipe is-expanded>
                    </Calendar>
                  </div>
                </div>
              </div>

              <!--  -->

              <div class="px-4 py-2 w-full bg-emerald-600">
                <span class="uppercase tracking-wider text-white"
                  >Contact Information</span
                >
              </div>
              <div class="relative md:pt-6 pb-6 pt-12">
                <div class="mx-auto w-full">
                  <div class="px-4">
                    <!--  -->
                    <div v-for="contact in contacts" :key="contact">
                      <div class="my-1 px-4 py-2 bg-slate-200 rounded-md text-sm">
                        <span class="block font-bold">{{ contact.question }}</span>
                        <span class="block ml-2">{{ contact.answer }}</span>
                      </div>
                    </div>
                    <!--  -->
                  </div>
                </div>
              </div>
            </div>
            <!-- Right side -->
          </div>
        </div>
        <!-- Full dashboard -->
      </div>
    </div>
  </home-layout>
</template>

<script>
import { defineComponent } from "vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import HomeLayout from "@/Layouts/HomeLayout";
import { Calendar, DatePicker } from "v-calendar";
import JetPagination from "@/Components/Pagination";
import NoData from "@/Components/Fillers/NoData.vue";

export default defineComponent({
  components: {
    Head,
    Link,
    Calendar,
    DatePicker,
    HomeLayout,
    JetPagination,
    NoData,
  },

  props: {
    noOfExams: Number,
    noOfApplicants: Number,
    noOfSched: Number,
    schedules: Object,
    contacts: Object,
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
});
</script>
