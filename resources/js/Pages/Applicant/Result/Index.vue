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
      <div class="flex flex-col sm:justify-center items-center">
        <div class="w-full sm:max-w-2xl mt-6 px-6 py-4">
          <div class="flex flex-wrap">
            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
              <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
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
                  <tbody class="bg-white text-xl" v-if="verified == null">
                    <tr>
                      <td class="p-4 text-center text-xs text-gray-900" colspan="2">
                        <span class="text-red-500 uppercase text-xl">No data found!</span>
                        <NoData />
                      </td>
                    </tr>
                  </tbody>
                  <tbody v-if="verified != null">
                    <tr>
                      <th
                        scope="row"
                        class="py-4 px-6 font-medium text-gray-700 bg-gray-50 text-right pr-5 uppercase"
                      >
                        Control Number:
                      </th>
                      <td class="py-4 px-6 text-emerald-700 font-bold text-xl">
                        {{ verified.applicant_id }}
                      </td>
                    </tr>
                    <tr>
                      <th
                        scope="row"
                        class="py-4 px-6 font-medium text-gray-700 bg-gray-50 text-right pr-5 uppercase"
                      >
                        Name:
                      </th>
                      <td class="py-4 px-6 font-bold text-gray-700 text-xl">
                        {{ verified.name }}
                      </td>
                    </tr>
                    <tr>
                      <th
                        scope="row"
                        class="py-4 px-6 font-medium text-gray-700 bg-gray-50 text-right pr-5 uppercase"
                      >
                        Total Score:
                      </th>
                      <td class="py-4 px-6 text-lg text-gray-900">
                        {{ verified.rating }}
                      </td>
                    </tr>
                    <tr>
                      <th
                        scope="row"
                        class="py-4 px-6 font-medium text-gray-700 bg-gray-50 text-right pr-5 uppercase"
                      >
                        Course Applied:
                      </th>
                      <td class="py-4 px-6 text-lg text-gray-700">
                        <span v-if="verified.course_applied != null" class="text-lg">
                          {{ applicant.course_applied }} -
                          {{ applicant.course.course_desc }}
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <th
                        scope="row"
                        class="py-4 px-6 font-medium text-gray-700 bg-gray-50 text-right pr-5 uppercase"
                      >
                        Qualified Course:
                      </th>
                      <td class="py-4 px-6 text-md text-gray-900">
                        <span v-if="verified.course_applied == null">No course yet</span>
                        <span v-if="verified.status == 'qualified'" class="text-lg">
                          {{ verified.course_applied }} -
                          {{ verified.course.course_desc }}
                        </span>
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
                          v-if="verified.status == 'pending'"
                          >For verification</span
                        >
                        <span
                          class="text-emerald-800 bg-emerald-200 px-4 py-1 rounded-full uppercase"
                          v-if="verified.status == 'qualified'"
                          >Qualified</span
                        >
                        <span
                          class="px-4 py-1 rounded-full uppercase"
                          v-if="verified.status == 'not qualified'"
                          >Not Qualified</span
                        >
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Card -->

      <!-- Exam results -->
      <div class="grid grid-cols-2 px-5 py-3 shadow-lg bg-emerald-500 mt-4">
        <div>
          <h2 class="font-semibold text-xl text-white leading-tight">
            <span>Exam Results</span>
          </h2>
        </div>
      </div>
      <!-- Exam results -->

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
                        Exam Code
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        Subject
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        Score
                      </th>
                      <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Edit</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-if="!results.length">
                      <td class="p-4 text-center text-sm text-gray-800" colspan="7">
                        <span class="text-red-500 uppercase text-xl"
                          >No Results Found</span
                        >
                        <NoData />
                      </td>
                    </tr>
                    <tr v-for="result in results" :key="result.id">
                      <td class="px-6 py-4 whitespace-nowrap">
                        {{ result.exam.exam_code }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        {{ result.exam.subject }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        {{ result.score }}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Main Table -->
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
    verified: Object,
    applicant: Object,
    results: Object,
  },

  data() {
    return {
      form: this.$inertia.form({
        applicant_id: this.app_id,
      }),
    };
  },

  methods: {
    // Export function
    exportPDF: function (applicant) {
      const url = "/applicant/pdf/result";
      window.location.href = url + "?applicant_id=" + this.form.applicant_id;
    },
  },
};
</script>
