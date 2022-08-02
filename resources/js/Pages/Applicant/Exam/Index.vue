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
            <!-- v-if="this.attempt.end_time < this.dateNow" -->
            <div class="float-right my-2">
              <jet-button @click="openModal(true)" v-if="this.attempt == null"
                >Take Exam</jet-button
              >
              <jet-button @click="openModal(true)" v-if="this.attempt != null"
                >Continue Exam</jet-button
              >
            </div>

            <!-- Notice modal -->
            <dialog-modal :show="isOpen" @close="openModal(false)">
              <template #title>
                <span v-if="this.attempt == null"> Take Exam </span>
                <span v-if="this.attempt != null"> Take Exam </span>
              </template>

              <template #content>
                <span v-if="this.attempt == null"
                  >Once you start the examination, you will not be able to return. Timer
                  will continue even if you close the page. When the timer expires, the
                  exam will be automatically submitted.
                </span>
                <span v-if="this.attempt != null"
                  >You are currently taking the exam, do you wish to continue?</span
                >
              </template>

              <template #footer>
                <jet-secondary-button @click="openModal(false)">
                  Cancel
                </jet-secondary-button>

                <jet-button
                  class="ml-2"
                  @click="openExam(exam)"
                  v-if="this.attempt == null"
                >
                  Take
                </jet-button>
                <jet-button
                  class="ml-2"
                  @click="openExam(exam)"
                  v-if="this.attempt != null"
                >
                  Continue
                </jet-button>
              </template>
            </dialog-modal>
            <!-- Notice modal -->
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
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import DialogModal from "@/Jetstream/DialogModal";
import NoData from "@/Components/Fillers/NoData.vue";

export default {
  components: {
    ApplicantLayout,
    Link,
    JetSectionBorder,
    JetButton,
    JetSecondaryButton,
    DialogModal,
    NoData,
  },

  props: {
    exams: Object,
    schedule: Object,
    attempt: Object,
  },

  data() {
    return {
      isOpen: false,
      isSubmitted: false,
      disabled: null,
      dateNow: new Date(),
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
        this.isOpen = false;
      }
      return this.isOpen;
    },

    // Take exam
    openExam: function (exam) {
      this.$inertia.visit(route("applicant.exams.show", exam));
    },
  },
};
</script>
