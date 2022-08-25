<template>
  <admin-layout title="Exam">
    <template #header>
      <!-- Header -->
      <div class="grid grid-cols-2 px-5 py-3 shadow-md rounded-md">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight inline-flex">
            <Link
              :href="route('admin.exams.index')"
              class="uppercase px-2 font-bold cursor-pointer inline-flex"
            >
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
                  d="M15 19l-7-7 7-7"
                />
              </svg>
              <span class="text-gray-500 font-thin">
                {{ exam.exam_code }}
              </span>
            </Link>

            <!-- Active/Inactive -->
            <div>
              <!-- Active -->
              <span
                v-if="exam.status == 'active'"
                class="inline-flex items-center text-emerald-800 bg-emerald-200 px-2 text-sm font-medium rounded-md"
              >
                Active
              </span>
              <!-- Inactive -->
              <span
                v-if="exam.status == 'inactive'"
                class="inline-flex items-center text-red-800 bg-red-200 px-2 text-sm font-medium rounded-md"
              >
                Inactive
              </span>
            </div>
            <!-- Active/Inactive -->
          </h2>
        </div>
        <!-- Header -->

        <!-- Page Buttons -->
        <div align="right">
          <!-- Line buttons and show dropdown -->
          <div class="inline-flex" align="right">
            <div class="inline-block px-1">
              <jet-button
                @click="addQuestionModal(true)"
                class="inline-flex items-center mr-2 bg-green-200 hover:bg-green-300 text-green-800 text-xs rounded-md"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5 mr-2"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  stroke-width="2"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                  />
                </svg>
                Add Question
              </jet-button>

              <jet-button
                @click="deleteModal(true)"
                class="inline-flex items-center mr-2 bg-red-200 hover:bg-red-300 text-red-800 text-xs rounded-md"
                ><svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5 mr-2"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  stroke-width="2"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                  />
                </svg>
                Remove
              </jet-button>
            </div>
          </div>
          <!-- Hide in line buttons and show dropdown -->
        </div>
        <!-- End Page Buttons -->
      </div>
    </template>

    <div class="mx-auto sm:px-6 lg:px-8">
      <div class="px-5 py-3">
        <div class="text-2xl py-1">
          <span class="text-gray-800 font-bold uppercase">
            <span>{{ exam.subject }}</span>
          </span>
          <button
            class="px-1 text-gray-500 rounded text-sm font-semibold"
            @click="editExam(exam, true)"
          >
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
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
              />
            </svg>
          </button>
        </div>
        <div class="text-md py-1">
          <span class="text-gray-500"> Description: </span>
          <span class="text-lg">{{ exam.description }}</span>
        </div>
        <div class="text-md py-1">
          <span class="text-gray-500"> Duration: </span>
          <span class="text-lg">{{ exam.duration }}</span>
        </div>
      </div>
    </div>

    <div class="mx-auto sm:px-6 lg:px-12">
      <!-- List of exams -->
      <div>
        <div class="px-4 py-2 my-4 w-full bg-gray-700">
          <span class="uppercase tracking-wider text-white">List of Questions</span>
        </div>
        <div class="flex flex-col">
          <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <!-- NO data -->
            <div v-if="!exam.questions.length">
              <div class="w-full py-8">
                <div class="p-4 text-center text-sm text-gray-800">
                  <span class="text-red-500 uppercase text-xl">No questions found!</span>
                  <NoData />
                </div>
              </div>
            </div>
            <!-- NO data -->

            <div class="p-4 align-middle sm:px-8 lg:px-10">
              <!-- One row / data / card -->
              <div class="flex flex-wrap">
                <div
                  v-for="(question, id) in exam.questions"
                  :key="question.id"
                  class="w-full md:w-6/12 lg:w-4/12"
                >
                  <div
                    class="shadow overflow-hidden border-b border-gray-200 rounded-lg m-2 md:m-2 lg:m-4"
                  >
                    <div class="w-full bg-emerald-500 py-2 px-4">
                      <span class="text-white px-2">Question:</span>
                    </div>
                    <div class="text-md">
                      <div class="px-2 pt-4">
                        <span> {{ question.question }}</span>
                      </div>
                    </div>
                    <div
                      class="px-6 py-4 space-x-1 whitespace-nowrap text-right text-sm font-medium"
                    >
                      <button
                        @click="editQuestion(question.id)"
                        class="inline-flex items-center px-2 py-2 mr-2 bg-blue-200 hover:bg-blue-300 text-blue-800 text-sm font-medium rounded-md"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-5 w-5"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                          stroke-width="2"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                          />
                        </svg>
                      </button>

                      <button
                        @click="deleteQuestion(question.id)"
                        class="inline-flex items-center px-2 py-2 mr-2 bg-red-200 hover:bg-red-300 text-red-800 text-sm font-medium rounded-md"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-5 w-5"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                          stroke-width="2"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                          />
                        </svg>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- One row / data / card -->
            </div>
          </div>
        </div>
      </div>
      <!-- List of exams -->
    </div>
  </admin-layout>

  <!-- Edit Exam Modal -->
  <dialog-modal :show="isOpen" @close="editModal(false)">
    <template #title>
      <span> Update Exam </span>
    </template>

    <template #content>
      <!-- Subject -->
      <div class="mb-4">
        <jet-label for="subject" value="Subject" />
        <jet-input
          id="subject"
          type="text"
          class="mt-1 block w-full"
          v-model="examform.subject"
          @keyup.enter="updateExam(exam)"
        />
      </div>

      <!-- Description -->
      <div class="mb-4">
        <jet-label for="description" value="Description" />
        <textarea
          id="description"
          type="text"
          class="px-2 py-1 relative bg-white rounded mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm block w-full"
          v-model="form.description"
          @keyup.enter="updateExam(form)"
        />
      </div>

      <!-- Duration -->
      <div class="mb-4">
        <jet-label for="duration" value="Duration" />
        <jet-input
          id="duration"
          type="text"
          class="mt-1 block w-full"
          v-model="examform.duration"
          @keyup.enter="updateExam(exam)"
        />
      </div>

      <!-- Status -->
      <div class="mb-4">
        <jet-label for="status" value="Status" />
        <select
          ref="status"
          id="status"
          class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
          v-model="examform.status"
          @keyup.enter="updateExam(form)"
        >
          <option
            v-for="status in status"
            :key="status"
            :value="status"
            class="capitalize"
          >
            <span>{{ status }}</span>
          </option>
        </select>
      </div>
    </template>

    <template #footer>
      <jet-secondary-button @click="editModal(false)"> Cancel </jet-secondary-button>
      <jet-button
        class="ml-2"
        :class="{ 'opacity-25': disabled }"
        :disabled="disabled"
        @click="updateExam(exam)"
        @keyup.enter="updateExam(exam)"
      >
        Update
      </jet-button>
    </template>
  </dialog-modal>
  <!-- Edit Exam Modal -->

  <!-- Delete Confirm Dialog -->
  <dialog-modal :show="deleteModalisOpen" @close="deleteModal(false)">
    <template #title>
      <span> Do you want to remove {{ exam.exam_code }}? </span>
    </template>

    <template #content> </template>

    <template #footer>
      <jet-secondary-button @click="deleteModal(false)"> Cancel </jet-secondary-button>
      <jet-button
        class="ml-2 bg-red-500 hover:bg-red-700 text-white"
        :class="{ 'opacity-25': disabled }"
        :disabled="disabled"
        @click="destroyExam(exam.id)"
        @keyup.enter="destroyExam(exam.id)"
      >
        Delete
      </jet-button>
    </template>
  </dialog-modal>
  <!-- Delete Confirm Dialog -->

  <!-- Add Question Dialog -->
  <dialog-modal :show="addQuestionisOpen" @close="addQuestionModal(false)">
    <template #title>
      <span> Add Question </span>
    </template>

    <template #content>
      <!-- Question -->
      <div class="mb-4">
        <jet-label for="question" value="Question" />
        <div class="text-left">
          <textarea
            id="question"
            type="text"
            v-model="questionform.question"
            placeholder="Enter Question"
            required
            class="px-2 py-1 relative bg-white rounded mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm block w-full"
          />

          <span class="block text-gray-800 mx-4 my-2">
            You can add image/illustration to your question.
          </span>

          <jet-input
            id="imgphoto"
            type="file"
            placeholder=""
            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 my-2"
            @input="questionform.img_path = $event.target.files[0]"
            accept="image/png, image/jpeg"
          >
          </jet-input>
        </div>
      </div>
      <div class="mb-4">
        <jet-label for="choices" value="Choices" class="mx-2 text-lg" />
        <div
          v-for="(value, id) in questionform.choices"
          :key="id"
          class="w-full my-4 p-4 rounded bg-gray-200"
        >
          <div class="inline-block mr-2 mb-1 w-full">
            <span class="text-gray-800">
              Correct Answer:
              <Toggle v-model="value.is_correct" :id="id" @change="toggleChange(id)" />
              <button
                v-show="questionform.choices.length > 1"
                @click="removeOption(id)"
                class="inline-flex items-center py-1 px-4 mx-2 bg-red-200 hover:bg-red-300 text-red-900 text-xs rounded-md"
              >
                Remove
              </button>
            </span>
            <div class="inline-block w-full">
              <jet-input
                type="text"
                v-model="value.option"
                placeholder="Enter option"
                class="block w-full text-sm mr-4 py-2 px-4 border-0 font-semibold hover:bg-blue-100 my-2"
              >
              </jet-input>

              <span class="block text-gray-800 mx-4 my-2">
                You can add image/illustration to your option.
              </span>

              <jet-input
                :id="id"
                type="file"
                class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 my-2"
                @input="value.img_path = $event.target.files[0]"
                accept="image/png, image/jpeg"
              >
              </jet-input>
            </div>
          </div>
        </div>
      </div>
    </template>

    <template #footer>
      <jet-secondary-button @click="addQuestionModal(false)">
        Cancel
      </jet-secondary-button>
      <jet-button
        class="inline-flex items-center mx-2 bg-blue-200 hover:bg-blue-300 text-blue-800 text-xs rounded-md"
        :class="{ 'opacity-25': disabled }"
        :disabled="disabled"
        @click="addOption()"
      >
        Add Option
      </jet-button>
      <jet-button
        class=""
        :class="{ 'opacity-25': disabled }"
        :disabled="disabled"
        @click="saveQuestion(questionform)"
        @keyup.enter="saveQuestion(questionform)"
      >
        Save
      </jet-button>
    </template>
  </dialog-modal>
  <!-- Add Question Dialog -->
</template>

<script>
import { reactive, watchEffect } from "vue";
import { pickBy, throttle } from "lodash";
import { Inertia } from "@inertiajs/inertia";
import { Link } from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout";
import JetButton from "@/Jetstream/Button";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetLabel from "@/Jetstream/Label";
import DialogModal from "@/Jetstream/DialogModal";
import shared from "@/Scripts/shared";
import Toggle from "@vueform/toggle";
import NoData from "@/Components/Fillers/NoData.vue";
export default {
  components: {
    AdminLayout,
    JetButton,
    JetSecondaryButton,
    JetFormSection,
    JetInput,
    JetLabel,
    DialogModal,
    Link,
    Toggle,
    NoData,
  },
  props: {
    exam: Object,
  },

  extends: shared,

  remember: "form",

  data() {
    return {
      isOpen: false,
      deleteModalisOpen: false,
      addQuestionisOpen: false,
      disabled: null,
      editMode: false,

      examform: this.$inertia.form({
        subject: this.exam.subject,
        description: this.exam.description,
        duration: this.exam.duration,
        status: this.exam.status,
      }),

      valid: true,

      questionform: this.$inertia.form({
        exam_id: this.exam.id,
        question: "",
        img_path: null,
        choices: [
          {
            option: "",
            is_correct: false,
            img_path: "",
          },
          {
            option: "",
            is_correct: false,
            img_path: "",
          },
          {
            option: "",
            is_correct: false,
            img_path: "",
          },
          {
            option: "",
            is_correct: false,
            img_path: "",
          },
        ],
      }),
    };
  },
  methods: {
    toggleChange: function (id) {
      this.questionform.choices.forEach((item, index) => {
        if (id != index) {
          item.is_correct = false;
        }
      });
    },
    removeOption(counter) {
      this.questionform.choices.splice(counter, 1);
    },
    addOption() {
      this.questionform.choices.push({
        option: "",
        is_correct: false,
        img_path: "",
      });
    },
    saveQuestion: function (questions) {
      this.$inertia.visit("/admin/questions", {
        method: "post",
        data: questions,
        // onSuccess: () => {
        //   (this.questionform = {});
        // },
        preserveScroll: true,
        preserveState: true,
      });
    },
    // Disable function
    disabledClick: function (s) {
      this.disabled = s;
    },
    // Exam edit modal function
    editModal: function (status) {
      if (status == true) {
        this.isOpen = true;
      } else if (status == false) {
        this.isOpen = false;
      }
      return this.isOpen;
    },
    // Exam assign data
    editExam: function (exam, status) {
      this.form = Object.assign({}, exam);
      this.editModal(status);
    },
    // Exam update function
    updateExam: function (exam) {
      this.$inertia.put(this.route("admin.exams.update", this.exam.id), this.examform, {
        onBefore: () => {
          this.disabledClick(true);
        },
        onSuccess: () => {
          this.disabledClick(false), this.editModal(false);
        },
      });
    },
    // Delete modal
    deleteModal: function (status) {
      if (status == true) {
        this.deleteModalisOpen = true;
      } else if (status == false) {
        this.deleteModalisOpen = false;
      }
      return this.deleteModalisOpen;
    },
    // Destroy exam
    destroyExam: function (id) {
      this.$inertia.visit("/admin/exams/" + id, {
        method: "delete",
        preserveScroll: true,
        onBefore: () => {
          this.disabledClick(true);
        },
        onSuccess: () => {
          this.disabledClick(false);
        },
      });
    },
    // Add question modal
    addQuestionModal: function (status) {
      this.addQuestionisOpen = status;
      this.questionform.reset();
      return this.addQuestionisOpen;
    },

    // Edit question
    editQuestion: function (question) {
      this.$inertia.visit(route("admin.questions.edit", question));
      this.questionform = Object.assign({}, question);
    },

    // Delete question
    deleteQuestion: function (id) {
      this.$inertia.visit("/admin/questions/" + id, {
        method: "delete",
      });
    },
  },
};
</script>

<style src="@vueform/toggle/themes/default.css"></style>
