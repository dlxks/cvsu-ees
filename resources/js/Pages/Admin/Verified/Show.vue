<template>
  <admin-layout title="Examinations">
    <template #header>
      <!-- Header -->
      <div class="grid grid-cols-2 px-5 py-3 shadow-md rounded-md">
        <div>
          <Link
            :href="route('admin.verified.index')"
            class="capitalize px-2 font-bold cursor-pointer inline-flex"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6 text-gray-500"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="text-gray-500 font-thin"> Back to Results </span>
          </Link>
        </div>
        <!-- Header -->
      </div>
    </template>

    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
      <div
        class="w-full sm:max-w-2xl mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
      >
        <div class="w-full bg-emerald-500 py-2 px-4">
          <span class="mr-2 text-xl text-white">
            Application Result: {{ verified.applicant_id }}
          </span>
        </div>

        <div class="w-full py-2 px-4">
          <table class="w-full">
            <tbody>
              <tr>
                <td class="text-right text-gray-500 px-2">Name:</td>
                <td class="px-4 py-2">
                  <jet-input
                    v-model="form.name"
                    disabled
                    readonly
                    class="w-full px-4 py-2 bg-transparent text-md"
                  ></jet-input>
                </td>
              </tr>
              <tr>
                <td class="text-right text-gray-500 px-2">Control Number:</td>
                <td class="px-4 py-2">
                  <jet-input
                    v-model="form.applicant_id"
                    disabled
                    readonly
                    class="w-full px-4 py-2 bg-transparent text-md"
                  ></jet-input>
                </td>
              </tr>
              <tr>
                <td class="text-right text-gray-500 px-2">Total Exam Rating:</td>
                <td class="px-4 py-2">
                  <jet-input
                    v-model="form.rating"
                    disabled
                    readonly
                    class="w-full px-4 py-2 bg-transparent text-md"
                  ></jet-input>
                </td>
              </tr>
              <tr>
                <td class="text-right text-gray-500 px-2">Course:</td>
                <td class="px-4 py-2">
                  <Multiselect
                    v-model="form.course_applied"
                    placeholder="Select course"
                    valueProp="course_name"
                    :searchable="true"
                    label="course_name"
                    :options="courses"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                  />
                </td>
              </tr>
              <tr>
                <td class="text-right text-gray-500 px-2">Email:</td>
                <td class="px-4 py-2">
                  <jet-input v-model="form.email" class="w-full px-4 py-2 bg-gray-50" />
                </td>
              </tr>
              <tr>
                <td class="text-right text-gray-500 px-2">Phone Number:</td>
                <td class="px-4 py-2">
                  <jet-input
                    v-model="form.phone_number"
                    class="w-full px-4 py-2 bg-gray-50"
                  />
                </td>
              </tr>
              <tr>
                <td class="text-right text-gray-500 px-2">Status:</td>
                <td class="px-4 py-2">
                  <select
                    ref="role"
                    id="role"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    v-model="form.status"
                  >
                    <option
                      v-for="qualification in qualifications"
                      :key="qualification"
                      :value="qualification"
                      class="capitalize"
                    >
                      <span>{{ qualification }}</span>
                    </option>
                  </select>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="px-4 py-6">
                  <div class="float-right">
                    <jet-secondary-button
                      @click="back()"
                      class="inline-flex items-center mx-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-md"
                    >
                      Back to Results
                    </jet-secondary-button>
                    <jet-button
                      @click="verify(form)"
                      class="inline-flex items-center mx-2 bg-emerald-200 hover:bg-emerald-300 text-emerald-800 font-medium rounded-md"
                    >
                      Verify
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 ml-2"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"
                        />
                      </svg>
                    </jet-button>
                    <jet-button
                      @click="send(form)"
                      class="inline-flex items-center mx-2 bg-blue-200 hover:bg-blue-300 text-blue-800 font-medium rounded-md"
                    >
                      Send
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 ml-2 rotate-90"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
                        />
                      </svg>
                    </jet-button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

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
                      <span class="text-red-500 uppercase text-xl">No Results Found</span>
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
  </admin-layout>
</template>

<script>
import { reactive, watchEffect } from "vue";
import { pickBy, throttle } from "lodash";
import { Inertia } from "@inertiajs/inertia";
import AdminLayout from "@/Layouts/AdminLayout";
import JetButton from "@/Jetstream/Button";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import JetLabel from "@/Jetstream/Label";
import JetInput from "@/Jetstream/Input";
import DialogModal from "@/Jetstream/DialogModal";
import JetPagination from "@/Components/Pagination";
import { Link } from "@inertiajs/inertia-vue3";
import shared from "@/Scripts/shared";
import Multiselect from "@vueform/multiselect";
import NoData from "@/Components/Fillers/NoData.vue";

export default {
  components: {
    AdminLayout,
    JetButton,
    JetSecondaryButton,
    JetLabel,
    JetInput,
    JetPagination,
    DialogModal,
    Link,
    Multiselect,
    NoData,
  },

  extends: shared,

  props: {
    verified: Object,
    applicant: Object,
    courses: Object,
    results: Object,
  },

  data() {
    return {
      isOpen: false,
      disabled: null,
      editMode: false,

      form: this.$inertia.form({
        applicant_id: this.verified.applicant_id,
        name: this.verified.name,
        rating: this.verified.rating,
        course_applied: this.verified.course_applied,
        status: this.verified.status,
        phone_number: this.applicant.phone_number,
        email: this.applicant.email,
      }),
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
        this.form = {};
        this.isOpen = false;
        this.editMode = false;
      }

      return this.isOpen;
    },

    // Update
    verify: function (verified) {
      this.$inertia.put(
        this.route("admin.verified.update", this.verified.id),
        this.form,
        {}
      );
    },

    // Send notif
    send: function (result) {
      this.$inertia.visit(route("admin.send.verified"), {
        method: "get",
        data: result,
      });
    },

    // Return
    back: function () {
      this.$inertia.visit(route("admin.verified.index"));
    },
  },
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
