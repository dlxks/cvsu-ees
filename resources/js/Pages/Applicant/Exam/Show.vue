<template>
  <applicant-layout title="Applicant">
    <template #header>
      <!-- Header -->
      <div class="grid grid-cols-2 px-5 py-3 shadow-lg rounded-md bg-emerald-600">
        <div>
          <h2 class="font-semibold text-xl text-white leading-tight">
            <span>{{ exam.exam_code }}</span>
          </h2>
        </div>
        <!-- Page Buttons -->
        <div align="right">
          <!-- Line buttons and show dropdown -->
          <div class="inline-flex" align="right">
            <div class="text-xl font-medium text-white leading-tight">
              <span class="text-sm">Time left:</span>
              <span class="text-red-200">{{ time }}</span>
            </div>
          </div>
          <!-- Hide in line buttons and show dropdown -->
        </div>
        <!-- End Page Buttons -->
      </div>
    </template>

    <div class="flex flex-col">
      <!-- Card -->
      <div class="w-full px-4">
        <div
          class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-sm"
        >
          <div class="flex-auto p-8">
            <div class="flex flex-wrap">
              <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                <h5 class="text-gray-400 uppercase font-bold text-xl">
                  {{ exam.subject }}
                </h5>
                <span class="font-semibold text-xl text-gray-700">
                  {{ exam.description }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Card -->

      <!-- Full dashboard -->
      <div>
        <div class="flex flex-wrap mt-8">
          <!-- Left side -->
          <div class="w-full lg:w-8/12">
            <!-- Table div -->
            <div class="relative md:pt-6 pb-6 pt-12">
              <div class="mx-auto w-full">
                <div>
                  <div class="flex flex-wrap">
                    <!-- Question card -->
                    <div class="w-full px-8 bg-gray-50 rounded shadow-md">
                      <span
                        v-for="(question, id) in questions"
                        v-if="questionIndex != questions.length"
                        :key="id"
                        class="w-full px-4"
                      >
                        <span v-if="id === questionIndex">
                          <p class="text-md mb-8 text--primary">
                            {{ id + 1 }}) {{ question.question }}
                          </p>
                          <div v-if="question.img_path">
                            <img
                              :src="question.img_url"
                              class="object-contain h-80"
                              alt="Image"
                            />
                          </div>
                          <div class="justify-center">
                            <div v-for="choice in question.choices" :key="choice.id">
                              <div
                                class="form-check w-full p-4 shadow overflow-hidden border-b border-gray-500 rounded-lg m-2 md:m-2 lg:m-4"
                              >
                                <input
                                  type="radio"
                                  name="options"
                                  :id="choice.id"
                                  v-model="applicantResponses[id]"
                                  :value="
                                    choice.is_correct == true ? true : choice.option
                                  "
                                  v-bind:value="choice"
                                  @click="choices(question.id, choice.id)"
                                  class="mr-3"
                                />
                                <label
                                  class="form-check-label inline-block text-gray-800"
                                  :for="choice.id"
                                >
                                  <span>{{ choice.option }}</span>
                                  <div v-if="choice.img_path">
                                    <img
                                      :src="choice.img_url"
                                      class="object-contain h-80"
                                    />
                                  </div>
                                </label>
                              </div>
                            </div>
                          </div>
                        </span>
                      </span>
                    </div>
                    <!-- Question card -->
                  </div>
                </div>
              </div>
            </div>

            <div class="mb-16 px-6" v-if="questionIndex != questions.length">
              <button
                v-if="questionIndex > 0"
                text
                color="secondary"
                class="ml-2 float-left inline-flex px-4 py-2 bg-emerald-200 hover:bg-emerald-300 text-emerald-800 rounded-md"
                @click="prev"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5 mr-2"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path
                    fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z"
                    clip-rule="evenodd"
                  />
                </svg>
                Previous
              </button>
              <!-- next button -->
              <button
                text
                color="primary"
                class="ml-2 white--text float-right inline-flex px-4 py-2 bg-emerald-200 hover:bg-emerald-300 text-emerald-800 rounded-md"
                @click="postApplicantAnswers('next')"
                v-if="questionIndex < questions.length - 1"
              >
                Next<svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5 ml-2"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path
                    fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z"
                    clip-rule="evenodd"
                  />
                </svg>
              </button>

              <!-- submit button -->
              <button
                text
                color="primary"
                class="ml-2 white--text float-right inline-flex px-4 py-2 bg-emerald-200 hover:bg-emerald-300 text-emerald-800 rounded-md"
                @click="openModal(true)"
                v-if="questionIndex === questions.length - 1"
              >
                Submit
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5 ml-2"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path
                    fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z"
                    clip-rule="evenodd"
                  />
                </svg>
              </button>
            </div>
            <!-- Table div -->

            <div class="text-center py-6" v-if="questionIndex === questions.length">
              te
            </div>
          </div>
          <!-- Left side -->

          <!-- Right side -->
          <div class="w-full lg:w-4/12">
            <div class="relative md:pt-6 pb-6 pt-12">
              <div class="mx-auto w-full">
                <div class="px-8">
                  <div>
                    <span class="w-full">
                      Question/s attempted: {{ questionIndex }}/{{ questions.length }}
                    </span>
                  </div>
                  <div class="py-4">
                    <span
                      v-for="(question, id) in questions"
                      :key="id"
                      class="px-1 inline-flex flex-wrap"
                    >
                      <button
                        @click="goto(id)"
                        class="text-md mb-6 p-3 bg-gray-100 rounded shadow-sm"
                        :class="
                          id === questionIndex
                            ? 'text-white hover:text-gray-200 bg-gray-500 hover:bg-gray-400'
                            : 'text-gray-700 hover:text-gray-500'
                        "
                        :disabled="disabled"
                      >
                        {{ id + 1 }}
                      </button>
                    </span>
                  </div>

                  <div class="relative px-6" v-if="questionIndex != questions.length">
                    <button
                      v-if="questionIndex > 0"
                      text
                      color="secondary"
                      class="float-left inline-flex"
                      @click="prev"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 mr-2"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z"
                          clip-rule="evenodd"
                        />
                      </svg>
                      Previous
                    </button>
                    <button
                      text
                      color="primary"
                      class="white--text float-right inline-flex"
                      @click="postApplicantAnswers"
                    >
                      Next<svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 ml-2"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z"
                          clip-rule="evenodd"
                        />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Right side -->
        </div>
      </div>
      <!-- Full dashboard -->
    </div>
  </applicant-layout>

  <dialog-modal :show="isOpen" @close="openModal(false)">
    <template #title>
      <span> Submit Exam </span>
    </template>

    <template #content>
      <span
        >Once you submit, you won't be able to return on your exam. Do you want to
        continue?</span
      >
    </template>

    <template #footer>
      <jet-secondary-button @click="openModal(false)"> Cancel </jet-secondary-button>

      <jet-button class="ml-2" @click="submitApplicantAnswers()"> Submit </jet-button>
    </template>
  </dialog-modal>
</template>

<script>
import ApplicantLayout from "@/Layouts/ApplicantLayout";
import moment from "moment";
import { Link } from "@inertiajs/inertia-vue3";
import JetPagination from "@/Components/Pagination";
import JetInput from "@/Jetstream/Input";
import DialogModal from "@/Jetstream/DialogModal";
import JetButton from "@/Jetstream/Button";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import route from "../../../../../vendor/tightenco/ziggy/src/js";

export default {
  components: {
    ApplicantLayout,
    moment,
    Link,
    JetPagination,
    JetInput,
    DialogModal,
    JetButton,
    JetSecondaryButton,
  },

  props: {
    exam: Object,
    questions: Object,
    examHasTaken: Object,
    duration: Number,
  },

  data() {
    return {
      radioGroup: 0,
      questionIndex: 0,
      applicantResponses: Array(this.questions.length).fill(false),
      currentQuestion: 0,
      currentAnswer: 0,
      clock: moment(this.duration * 60 * 1000),

      isOpen: false,
      isSubmitted: false,
      disabled: null,
    };
  },

  mounted() {
    setInterval(() => {
      this.clock = moment(this.clock.subtract(1, "seconds"));
    }, 1000);
  },

  computed: {
    time: function () {
      var time = this.clock.format("mm:ss");

      if (time == "00:00") {
        // alert("test");
        return submitApplicantAnswers();
      }
      return time;
    },
  },

  methods: {
    prev() {
      this.questionIndex--;
    },

    choices(question, answer) {
      (this.currentAnswer = answer), (this.currentQuestion = question);
    },

    goto(question) {
      this.questionIndex = question;
      axios.post("/applicant/test", {
        answerId: this.currentAnswer,
        questionId: this.currentQuestion,
        examId: this.exam.id,
      });
    },

    postApplicantAnswers(status) {
      this.questionIndex++;
      if (status == "next") {
        axios.post("/applicant/test", {
          answerId: this.currentAnswer,
          questionId: this.currentQuestion,
          examId: this.exam.id,
        });
      } else if (status == "submit") {
        this.isOpen = true;
      }
    },

    // submit button function
    submitApplicantAnswers() {
      axios.post("/applicant/test", {
        answerId: this.currentAnswer,
        questionId: this.currentQuestion,
        examId: this.exam.id,
      });
      this.questionIndex++;
      this.isSubmitted = true;
      this.disabledClick(true);
      this.isOpen = false;
    },

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
  },
};
</script>
