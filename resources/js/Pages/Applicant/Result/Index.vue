<template>
  <applicant-layout title="Applicant">
    <template #header>
      <!-- Header -->
      <div class="grid grid-cols-2 px-5 py-3 shadow-lg rounded-md bg-emerald-600">
        <div>
          <h2 class="font-semibold text-xl text-white leading-tight">
            <span>Results</span>
          </h2>
        </div>
      </div>
    </template>

    <div class="flex flex-col my-12">
      <!-- Card -->
      <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-2xl mt-6 px-6 py-4">
          <div
            class="relative px-10 py-8 flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg"
          >
            <div class="flex flex-wrap">
              <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                  <table
                    class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                  >
                    <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                      <tr>
                        <th
                          scope="col"
                          colspan="2"
                          class="text-2xl py-3 px-6 uppercase tracking-wider text-white text-center bg-emerald-500"
                        >
                          Results
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white text-xl" v-if="this.result == null">
                      <tr>
                        <td class="p-4 text-center text-xs text-gray-900" colspan="2">
                          <span class="text-red-500 uppercase text-xl"
                            >No data found!</span
                          >
                          <NoData />
                        </td>
                      </tr>
                    </tbody>
                    <tbody v-if="this.result != null">
                      <tr>
                        <th
                          scope="row"
                          class="py-4 px-6 font-medium text-gray-700 bg-gray-50 text-right pr-5 uppercase"
                        >
                          Exam:
                        </th>
                        <td class="py-4 px-6 text-emerald-700 font-bold text-xl">
                          {{ this.result.exam }}
                        </td>
                      </tr>
                      <tr>
                        <th
                          scope="row"
                          class="py-4 px-6 font-medium text-gray-700 bg-gray-50 text-right pr-5 uppercase"
                        >
                          Score:
                        </th>
                        <td class="py-4 px-6 text-lg text-gray-900">
                          {{ this.result.score }}
                        </td>
                      </tr>
                      <tr>
                        <th
                          scope="row"
                          class="py-4 px-6 font-medium text-gray-700 bg-gray-50 text-right pr-5 uppercase"
                        >
                          Courses:
                        </th>
                        <td class="py-4 px-6 text-md text-gray-900">
                          <span v-if="this.result.courses.length == 0"
                            >No courses yet</span
                          >
                          <ul
                            v-for="course in this.result.courses"
                            v-bind:key="course.id"
                          >
                            <li v-if="this.result.courses.length >= 2">
                              {{ course.course_name }} - {{ course.course_desc }}
                            </li>
                          </ul>
                        </td>
                      </tr>
                      <tr>
                        <th
                          scope="row"
                          class="py-4 px-6 font-medium text-gray-700 bg-gray-50 text-right pr-5 uppercase"
                        >
                          Status:
                        </th>
                        <td class="py-4 px-6 text-md">
                          <span
                            class="text-orange-800 bg-orange-200 px-4 py-1 rounded-full uppercase"
                            v-if="this.result.status == 'pending'"
                            >For verification</span
                          >
                          <span
                            class="text-emerald-800 bg-emerald-200 px-4 py-1 rounded-full uppercase"
                            v-if="this.result.status == 'qualified'"
                            >Qualified</span
                          >
                          <span
                            class="text-red-800 bg-red-200 px-4 py-1 rounded-full uppercase"
                            v-if="this.result.status == 'not qualified'"
                            >Not Qualified</span
                          >
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="relative w-auto pl-4 flex-initial">
                <jet-input
                  v-model="form.applicant_id"
                  disabled
                  readonly
                  hidden
                ></jet-input>
                <jet-button
                  class="text-white p-3 text-center text-md inline-flex items-center justify-center w-auto h-15 shadow-lg rounded-full bg-emerald-500"
                  @click="exportPDF(form)"
                >
                  <span>Save Result</span>
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
                      d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"
                    />
                  </svg>
                </jet-button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Card -->
    </div>
  </applicant-layout>
</template>

<script>
import ApplicantLayout from "@/Layouts/ApplicantLayout";
import { reactive, watchEffect } from "vue";
import { pickBy, throttle } from "lodash";
import { Inertia } from "@inertiajs/inertia";
import { Link } from "@inertiajs/inertia-vue3";
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import NoData from "@/Components/Fillers/NoData.vue";

export default {
  components: {
    ApplicantLayout,
    Link,
    JetSectionBorder,
    JetButton,
    JetInput,
    NoData,
  },

  props: {
    result: Object,
    totalQuestions: Number,
  },

  data() {
    return {
      form: this.$inertia.form({
        applicant_id: this.result.applicant_id,
      }),
    };
  },

  methods: {
    // Export function
    exportPDF: function (applicant) {
      const url = "/applicant/pdf/result";
      window.location.href = url + "?applicant_id=" + this.form.applicant_id;

      // this.$inertia.visit(route("applicant.result.pdf"), {
      //   method: "get",
      //   data: applicant,
      // });

      // this.$inertia.visit(route("applicant.result.pdf", applicant));
    },
  },
};
</script>
