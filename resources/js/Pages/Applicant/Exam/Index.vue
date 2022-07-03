<template>
  <applicant-layout title="Applicant">
    <template #header>
      <!-- Header -->
      <div class="grid grid-cols-2 px-5 py-3 shadow-lg rounded-md bg-emerald-600">
        <div>
          <h2 class="font-semibold text-xl text-white leading-tight">
            <span>Examinations</span>
          </h2>
        </div>
      </div>
    </template>

    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
      <div class="w-full sm:max-w-2xl mt-6 px-6 py-4">
        <div
          class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg"
        >
          <!-- No data -->
          <div v-if="!exams.length">
            <div class="w-full py-8">
              <div class="p-4 text-center text-sm text-gray-800">
                <span class="text-red-500 uppercase text-xl">No exam found!</span>
                <NoData />
              </div>
            </div>
          </div>
          <!-- No data -->

          <!-- Header card -->
          <div class="flex-auto p-8" v-for="exam in exams" :key="exam.id">
            <div class="w-full">
              <div class="my-2">
                <span class="text-gray-500 mr-2">Subject:</span>
                <span class="text-gray-700 text-xl font-bold">{{ exam.subject }}</span>
              </div>
              <div class="my-2">
                <span class="text-gray-500 mr-2 text-sm">Description:</span>
                <span class="text-gray-700 text-md font-medium">
                  {{ exam.description }}
                </span>
              </div>
              <div class="my-2">
                <span class="text-gray-500 mr-2 text-sm">Duration (in minutes):</span>
                <span class="text-gray-700 text-md font-medium">{{ exam.duration }}</span>
              </div>
            </div>
            <div class="float-right my-2">
              <jet-button @click="take(exam)">Take Exam</jet-button>
            </div>
          </div>

        </div>
      </div>
      <!-- Header card -->
    </div>
  </applicant-layout>
</template>

<script>
import ApplicantLayout from "@/Layouts/ApplicantLayout";
import { Link } from "@inertiajs/inertia-vue3";
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";
import JetButton from "@/Jetstream/Button.vue";
import NoData from "@/Components/Fillers/NoData.vue";

export default {
  components: {
    ApplicantLayout,
    Link,
    JetSectionBorder,
    JetButton,
    NoData,
  },

  props: {
    exams: Object,
    schedule: Object,
  },

  data() {
    return {};
  },

  methods: {
    take: function (exam) {
      this.$inertia.visit(route("applicant.exams.show", exam));
    },
  },
};
</script>
