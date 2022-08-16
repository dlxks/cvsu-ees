<template>
  <exam-layout title="Applicant">
    <template #header>
      <!-- Header -->
      <div
        class="container mx-auto grid grid-cols-2 px-5 py-3 shadow-lg rounded-md bg-emerald-500"
      >
        <div>
          <h2 class="font-semibold text-xl leading-tight text-white">
            <span>{{ exam.exam_code }}</span>
          </h2>
        </div>
        <!-- Page Buttons -->
        <div align="right">
          <!-- Line buttons and show dropdown -->
          <div class="inline-flex" align="right">
            <div class="text-lg font-medium leading-tight">
              <span class="text-xs text-white">Remaining Time : </span>
              <span
                class="inline-block text-center"
                :class="
                  this.seconds < 60 && this.minutes == 0 ? 'text-red-500' : 'text-white'
                "
                v-if="this.days != 0"
              >
                {{ days }}:
              </span>
              <span
                class="inline-block text-center"
                :class="
                  this.seconds < 60 && this.minutes == 0 ? 'text-red-500' : 'text-white'
                "
                v-if="this.hours != 0"
              >
                {{ hours }}:
              </span>
              <span
                class="inline-block text-center"
                :class="
                  this.seconds < 60 && this.minutes == 0 ? 'text-red-500' : 'text-white'
                "
              >
                {{ minutes }}:
              </span>
              <span
                class="inline-block text-center"
                :class="
                  this.seconds < 60 && this.minutes == 0 ? 'text-red-500' : 'text-white'
                "
              >
                {{ seconds }}
              </span>
            </div>
          </div>
          <!-- Hide in line buttons and show dropdown -->
        </div>
        <!-- End Page Buttons -->
      </div>
    </template>

    <div class="flex flex-col container mx-auto">
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
            <div class="mt-5">
              <span class="text-red-700 text-md"
                >*Note: If you close or refresh the page, all your selected answer will be
                cleared. It will be saved but the selection will be cleared. If you choose
                new answer, it will just update your current answer. You also need to
                submit the exam before the timer ends or the exam will end and the results
                will not be recorded.</span
              >
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
                              
                                  <!-- :selected="
                                    answers.exam_id === exam.id &&
                                    answers.question_id === questions.id &&
                                    answers.answers === choice.id
                                  " -->
                                  <!-- v-model="applicantResponses[id]" -->
                                <input
                                  type="radio"
                                  name="options"
                                  :id="choice.id"
                                  selected
                                  v-model="applicantResponses[id]"
                                  :value="
                                    choice.option
                                  "
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
              <span>You have finished the exam.</span>
              <jet-button @click="gotoResults()">See Results</jet-button>
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

                    <!-- nexy button -->
                    <button
                      text
                      color="primary"
                      class="white--text float-right inline-flex"
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
                      class="white--text float-right inline-flex"
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
                </div>
              </div>
            </div>
          </div>
          <!-- Right side -->
        </div>
      </div>
      <!-- Full dashboard -->
    </div>
  </exam-layout>

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
import ExamLayout from "@/Layouts/ExamLayout";
import moment from "moment";
import { Link } from "@inertiajs/inertia-vue3";
import JetPagination from "@/Components/Pagination";
import JetInput from "@/Jetstream/Input";
import DialogModal from "@/Jetstream/DialogModal";
import JetButton from "@/Jetstream/Button";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import route from "../../../../../vendor/tightenco/ziggy/src/js";
import { floor } from "lodash";
import M from "minimatch";

export default {
  components: {
    ExamLayout,
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
    answers: Object,
    start_time: String,
    end_time: String,
    result: Object,
    applicant: Object,
  },

  data() {
    return {
      questionIndex: 0,
      applicantResponses: Array(this.questions.length).fill(false),
      // answers: Array(this.questions.length).fill(false),
      question_id: this.answers.question_id,
      answer_id:  this.answers.answer_id,

      isOpen: false,
      isSubmitted: false,
      disabled: null,

      days: 0,
      hours: 0,
      minutes: 0,
      seconds: 0,
    };
  },

  mounted() {
    this.showRemaining();
  },

  computed: {
    _seconds: () => 1000,
    _minutes() {
      return this._seconds * 60;
    },
    _hours() {
      return this._minutes * 60;
    },
    _days() {
      return this._hours * 24;
    },
  },

  methods: {
    // timer
    showRemaining() {
      const timer = setInterval(() => {
        const start = new Date();
        const end = new Date(this.end_time);
        const distance = end.getTime() - start.getTime();

        if (distance < 0) {
          clearInterval(timer);
          return this.submitOnTimerEnd();
        }

        if (this.result != null) {
          clearInterval(timer);
        }

        const ddays = Math.floor(distance / this._days);
        const dhours = Math.floor((distance % this._days) / this._hours);
        const dminutes = Math.floor((distance % this._hours) / this._minutes);
        const dseconds = Math.floor((distance % this._minutes) / this._seconds);

        this.days = ddays < 10 ? "0" + ddays : ddays;
        this.hours = dhours < 10 ? "0" + dhours : dhours;
        this.minutes = dminutes < 10 ? "0" + dminutes : dminutes;
        this.seconds = dseconds < 10 ? "0" + dseconds : dseconds;
      }, 1000);
    },

    prev() {
      this.questionIndex--;
        axios.post("/applicant/test", {
          answerId: this.answer_id,
          questionId: this.question_id,
          examId: this.exam.id,
        });
    },

    choices(question, answer) {
      (this.answer_id = answer), (this.question_id = question);
    },

    goto(question) {
      this.questionIndex = question;
      axios.post("/applicant/test", {
        answerId: this.answer_id,
        questionId: this.question_id,
        examId: this.exam.id,
      });
    },

    postApplicantAnswers(status) {
      this.questionIndex++;
      if (status == "next") {
        axios.post("/applicant/test", {
          answerId: this.answer_id,
          questionId: this.question_id,
          examId: this.exam.id,
        });
      } else if (status == "submit") {
        this.isOpen = true;
      }
    },

    // submit button function
    submitApplicantAnswers() {
      axios.post("/applicant/test", {
        answerId: this.answer_id,
        questionId: this.question_id,
        examId: this.exam.id,
      });
      this.questionIndex++;
      this.isSubmitted = true;
      this.disabledClick(true);
      this.isOpen = false;

      this.$inertia.post("/applicant/results", {
        answerId: this.answer_id,
        questionId: this.question_id,
        examId: this.exam.id,
      });
    },

    // submit button function
    submitOnTimerEnd() {
      axios.post("/applicant/test", {
        answerId: this.answer_id,
        questionId: this.question_id,
        examId: this.exam.id,
      });
      this.questionIndex++;
      this.isSubmitted = true;
      this.disabledClick(true);

      this.$inertia.post("/applicant/results", {
        answerId: this.answer_id,
        questionId: this.question_id,
        examId: this.exam.id,
      });
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

    // Go to results
    gotoResults() {
      this.$inertia.visit(route("applicant.results.index"));
    },
  },
};
</script>
