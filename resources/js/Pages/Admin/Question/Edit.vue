<template>
  <admin-layout title="Edit Question">
    <template #header>
      <!-- Header -->
      <div class="grid grid-cols-2 px-5 py-3 shadow-md rounded-md">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <button
              @click="redirect(question.exam_id)"
              class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md"
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
              <span class="text-gray-500">Return</span>
            </button>
          </h2>
        </div>
        <!-- Header -->

        <!-- Page Buttons -->
        <div align="right">
          <!-- Line buttons and show dropdown -->
          <div class="block" align="right">
            <button
              @click="updateQuestion"
              class="inline-flex items-center px-4 py-2 mr-2 bg-emerald-200 hover:bg-emerald-300 text-emerald-800 text-sm font-medium rounded-md"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 inline-block"
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
              Update
            </button>

            <button
              @click="deleteQuestion(question.id)"
              class="inline-flex items-center px-4 py-2 bg-red-200 hover:bg-red-300 text-red-800 text-sm font-medium rounded-md"
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
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                />
              </svg>
              Delete
            </button>
          </div>
          <!-- Hide in line buttons and show dropdown -->
        </div>
        <!-- End Page Buttons -->
      </div>
    </template>

    <div class="mx-auto sm:px-6 lg:px-8">
      <div class="px-5 py-3">
        <div class="inline-flex">
          <span class="text-xs mr-2 text-red-500">
            *Note: You can't update images in questions and choice. If you want to change
            them, delete and add them again.
          </span>
        </div>
      </div>
      <!-- Question -->
      <div class="p-4 align-middle sm:px-8 lg:px-10">
        <div class="flex flex-wrap">
          <span class="uppercase text-sm mr-2 text-gray-500"> Question: </span>
          <div class="text-lg capitalize w-full">
            <textarea
              id="question"
              type="text"
              v-model="questionform.question"
              placeholder="Enter Question"
              required
              class="px-2 py-1 relative bg-white rounded mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm block w-full"
            />
            <div v-if="question.img_path">
              <img
                :src="question.img_url.img_url"
                class="object-contain h-80"
                alt="Image"
              />
            </div>
          </div>
        </div>
      </div>

      <div class="p-4 align-middle sm:px-8 lg:px-10">
        <span class="uppercase text-sm mr-2 text-gray-500"> Choices: </span>
        <!-- One row / data / card -->
        <div class="flex flex-wrap">
          <div
            v-for="(choice, id) in questionform.choices"
            :key="choice.id"
            class="w-full md:w-6/12 lg:w-4/12"
          >
            <div
              class="shadow overflow-hidden border-b bg-gray-100 border-gray-200 rounded-lg m-2 md:m-2 lg:m-4"
            >
              <div class="w-full py-2 px-4">
                <span class="text-gray-500 float-right">
                  Correct Answer:
                  <Toggle
                    v-model="choice.is_correct"
                    :id="id"
                    @change="toggleChange(id)"
                  />
                </span>
              </div>
              <div class="text-lg">
                <div class="px-4 py-4">
                  <jet-input
                    id="question"
                    type="text"
                    v-model="choice.option"
                    placeholder="Enter Question"
                    class="inline-block w-full my-2"
                    required
                  >
                  </jet-input>

                  <div class="object-center">
                    <div v-if="choice.img_path">
                      <img :src="choice.img_url" class="object-contain h-80" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- One row / data / card -->
      </div>
    </div>
  </admin-layout>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout";
import JetButton from "@/Jetstream/Button";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetLabel from "@/Jetstream/Label";
import DialogModal from "@/Jetstream/DialogModal";
import Toggle from "@vueform/toggle";

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
  },

  props: {
    question: Object,
  },

  data() {
    return {
      questionform: this.$inertia.form({
        exam_id: this.question.exam_id,
        question: this.question.question,
        img_path: this.question.img_path,
        choices: this.question.choices,
      }),
    };
  },

  methods: {
    // Delete question
    deleteQuestion: function (id) {
      this.$inertia.visit(route("admin.questions.destroy", id), {
        method: "delete",
      });
    },

    // Update
    updateQuestion: function () {
      this.$inertia.put(
        this.route("admin.questions.update", this.question.id),
        this.questionform,
        {}
      );
    },

    // Toggle change
    toggleChange: function (id) {
      this.questionform.choices.forEach((item, index) => {
        if (id != index) {
          item.is_correct = false;
        }
      });
    },

    redirect: function (id) {
      this.$inertia.visit(route("admin.exams.show", id));
    },
  },
};
</script>

<style src="@vueform/toggle/themes/default.css"></style>
