<template>
  <admin-layout title="Applicants">
    <template #header>
      <!-- Header -->
      <div class="grid grid-cols-2 px-5 py-3 shadow-md rounded-md">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span>Applicants</span>
          </h2>
        </div>

        <!-- Page Buttons -->
        <div align="right">
          <!-- Line buttons and show dropdown -->
          <div class="block" align="right">
            <jet-dropdown>
              <template #trigger>
                <span class="inline-flex rounded-md">
                  <button
                    type="button"
                    class="inline-flex items-center px-4 py-2 mr-2 bg-gray-800 hover:bg-gray-600 text-gray-100 text-sm font-medium rounded-md"
                  >
                    <span>Data Export</span>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="ml-2 -mr-0.5 h-4 w-4"
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
                  </button>
                </span>
              </template>
              <template #content>
                <!-- Export buttons -->
                <div class="px-2 py-2">
                  <div class="py-1">
                    <jet-button
                      @click="exportData('xlsx')"
                      class="inline-flex items-center px-4 py-2 mr-2 bg-blue-200 hover:bg-blue-300 text-blue-800 text-sm font-medium rounded-md"
                    >
                      Export(.xlsx)
                    </jet-button>
                  </div>
                  <div class="py-1">
                    <jet-button
                      @click="exportData('csv')"
                      class="inline-flex items-center px-4 py-2 mr-2 bg-blue-200 hover:bg-blue-300 text-blue-800 text-sm font-medium rounded-md"
                    >
                      Export(.csv)
                    </jet-button>
                  </div>
                  <div class="py-1">
                    <jet-button
                      @click="exportPDF()"
                      class="inline-flex items-center px-4 py-2 mr-2 bg-blue-200 hover:bg-blue-300 text-blue-800 text-sm font-medium rounded-md"
                    >
                      Save PDF
                    </jet-button>
                  </div>
                </div>
              </template>
            </jet-dropdown>
          </div>
          <!-- Hide in line buttons and show dropdown -->
        </div>
        <!-- End Page Buttons -->
      </div>
      <!-- Header -->
    </template>

    <div class="py-12">
      <div class="mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 px-5 py-3">
          <div>
            <!-- Search -->
            <div class="block">
              <span class="text-sm text-gray-500">Search: </span>
              <jet-input
                type="text"
                placeholder="Search..."
                v-model="params.search"
                class="px-2 py-1 relative bg-white rounded text-sm border-0 mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow"
              />
            </div>
            <!-- Search -->

            <!-- View filter -->
            <div class="block">
              <span class="text-sm text-gray-500">No. per page: </span>
              <select
                ref="perpage"
                id="perpage"
                class="px-2 py-1 relative bg-white rounded text-sm border-0 mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow"
                v-model="params.perpage"
              >
                <option
                  v-for="perpage in perpages"
                  :key="perpage"
                  :value="perpage"
                  class="capitalize"
                >
                  <span>{{ perpage }}</span>
                </option>
              </select>
            </div>
            <!-- View filter -->
          </div>
          <div class="block" align="right">
            <jet-button
              class="inline-flex items-center px-4 py-2 mr-2 bg-emerald-200 hover:bg-emerald-300 text-emerald-800 text-sm font-medium rounded-md"
              @click="openModal(true)"
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
                  d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"
                />
              </svg>
              Add Applicant
            </jet-button>
          </div>
        </div>
      </div>

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
                        <span class="cursor-pointer" @click="sort('id')">
                          <div class="inline-block">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2"
                              v-if="params.field === 'id' && params.direction === 'asc'"
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"
                              />
                            </svg>
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2"
                              v-if="params.field === 'id' && params.direction === 'desc'"
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"
                              />
                            </svg>
                          </div>
                          <div class="inline-block">Control Number</div></span
                        >
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <span class="cursor-pointer" @click="sort('fname')">
                          <div class="inline-block">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2"
                              v-if="
                                params.field === 'fname' && params.direction === 'asc'
                              "
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"
                              />
                            </svg>
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2"
                              v-if="
                                params.field === 'fname' && params.direction === 'desc'
                              "
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"
                              />
                            </svg>
                          </div>
                          <div class="inline-block">First Name</div></span
                        >
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <span class="cursor-pointer" @click="sort('mname')">
                          <div class="inline-block">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2"
                              v-if="
                                params.field === 'mname' && params.direction === 'asc'
                              "
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"
                              />
                            </svg>
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2"
                              v-if="
                                params.field === 'mname' && params.direction === 'desc'
                              "
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"
                              />
                            </svg>
                          </div>
                          <div class="inline-block">Middle Name</div></span
                        >
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <span class="cursor-pointer" @click="sort('lname')">
                          <div class="inline-block">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2"
                              v-if="
                                params.field === 'lname' && params.direction === 'asc'
                              "
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"
                              />
                            </svg>
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2"
                              v-if="
                                params.field === 'lname' && params.direction === 'desc'
                              "
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"
                              />
                            </svg>
                          </div>
                          <div class="inline-block">Last Name</div></span
                        >
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <span><div class="inline-block">Course Applied</div></span>
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <span class="cursor-pointer" @click="sort('birthday')">
                          <div class="inline-block">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2"
                              v-if="
                                params.field === 'birthday' && params.direction === 'asc'
                              "
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"
                              />
                            </svg>
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2"
                              v-if="
                                params.field === 'birthday' && params.direction === 'desc'
                              "
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"
                              />
                            </svg>
                          </div>
                          <div class="inline-block">Birthday</div></span
                        >
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <span class="cursor-pointer" @click="sort('email')">
                          <div class="inline-block">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2"
                              v-if="
                                params.field === 'email' && params.direction === 'asc'
                              "
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"
                              />
                            </svg>
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2"
                              v-if="
                                params.field === 'email' && params.direction === 'desc'
                              "
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"
                              />
                            </svg>
                          </div>
                          <div class="inline-block">Email</div></span
                        >
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <span class="cursor-pointer" @click="sort('phone_number')">
                          <div class="inline-block">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2"
                              v-if="
                                params.field === 'phone_number' &&
                                params.direction === 'asc'
                              "
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"
                              />
                            </svg>
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              stroke-width="2"
                              v-if="
                                params.field === 'phone_number' &&
                                params.direction === 'desc'
                              "
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"
                              />
                            </svg>
                          </div>
                          <div class="inline-block">Phone Number</div></span
                        >
                      </th>
                      <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Edit</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-if="!applicants.data.length">
                      <td class="p-4 text-center text-xs text-gray-800" colspan="9">
                        <span class="text-red-500 uppercase text-xl">No data found!</span>
                        <NoData />
                      </td>
                    </tr>
                    <tr
                      v-for="applicant in applicants.data"
                      :key="applicant.id"
                      class="text-sm"
                    >
                      <td class="px-6 py-1 whitespace-nowrap">
                        {{ applicant.id }}
                      </td>
                      <td class="px-6 py-1 whitespace-nowrap">
                        {{ applicant.fname }}
                      </td>
                      <td class="px-6 py-1 whitespace-nowrap">
                        {{ applicant.mname }}
                      </td>
                      <td class="px-6 py-1 whitespace-nowrap">
                        {{ applicant.lname }}
                      </td>
                      <td class="px-6 py-1 whitespace-nowrap">
                        {{ applicant.course_applied }}
                      </td>
                      <td class="px-6 py-1 whitespace-nowrap">
                        {{ applicant.birthday }}
                      </td>
                      <td class="px-6 py-1 whitespace-nowrap">
                        {{ applicant.email }}
                      </td>
                      <td class="px-6 py-1 whitespace-nowrap">
                        {{ applicant.phone_number }}
                      </td>
                      <td
                        class="px-6 py-1 space-x-1 whitespace-nowrap text-right text-sm font-medium"
                      >
                        <button
                          @click="edit(applicant, true)"
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
                          @click="deleteRow(applicant.id)"
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
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="mx-auto sm:px-6 lg:px-8">
          <jet-pagination class="m-5" :links="applicants.links" />
        </div>
      </div>
    </div>
  </admin-layout>

  <dialog-modal :show="isOpen" @close="openModal(false)">
    <template #title>
      <span v-show="!editMode"> Add New Applicant </span>
      <span v-show="editMode"> Update Applicant </span>
    </template>

    <template #content>
      <!-- First Name -->
      <div class="mb-4">
        <jet-label for="fname" value="First Name" />
        <jet-input
          id="fname"
          ref="fname"
          type="text"
          class="mt-1 block w-full"
          autocomplete
          v-model="form.fname"
          v-show="editMode"
          @keyup.enter="update(form)"
        />
        <jet-input
          id="fname"
          ref="fname"
          type="text"
          class="mt-1 block w-full"
          autocomplete
          v-model="form.fname"
          v-show="!editMode"
          @keyup.enter="save(form)"
        />
      </div>

      <!-- Middle Name -->
      <div class="mb-4">
        <jet-label for="mname" value="Middle Name" />
        <jet-input
          id="mname"
          ref="mname"
          type="text"
          class="mt-1 block w-full"
          autocomplete
          v-model="form.mname"
          v-show="editMode"
          @keyup.enter="update(form)"
        />
        <jet-input
          id="mname"
          ref="mname"
          type="text"
          class="mt-1 block w-full"
          autocomplete
          v-model="form.mname"
          @keyup.enter="save(form)"
          v-show="!editMode"
        />
      </div>

      <!-- Last Name -->
      <div class="mb-4">
        <jet-label for="lname" value="Last Name" />
        <jet-input
          id="lname"
          ref="lname"
          type="text"
          class="mt-1 block w-full"
          autocomplete
          v-model="form.lname"
          v-show="editMode"
          @keyup.enter="update(form)"
        />
        <jet-input
          id="lname"
          ref="lname"
          type="text"
          class="mt-1 block w-full"
          autocomplete
          v-model="form.lname"
          v-show="!editMode"
          @keyup.enter="save(form)"
        />
      </div>

      <!-- Course -->
      <div class="mb-4">
        <jet-label for="course" value="Course Applied" />
        <Multiselect
          v-model="form.course_applied"
          v-show="editMode"
          @keyup.enter="update(form)"
          placeholder="Select course"
          valueProp="course_name"
          :searchable="true"
          label="course_desc"
          id="course"
          :options="courses"
          class="mt-1 block text-sm w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        />
        <Multiselect
          v-model="form.course_applied"
          v-show="!editMode"
          @keyup.enter="save(form)"
          placeholder="Select course"
          valueProp="course_name"
          :searchable="true"
          label="course_desc"
          id="course"
          :options="courses"
          class="mt-1 block text-sm w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        />
      </div>

      <!-- Email -->
      <div class="mb-4">
        <jet-label for="email" value="Email" />
        <jet-input
          id="email"
          ref="email"
          type="text"
          class="mt-1 block w-full"
          autocomplete
          v-model="form.email"
          v-show="editMode"
          @keyup.enter="update(form)"
        />
        <jet-input
          id="email"
          ref="email"
          type="text"
          class="mt-1 block w-full"
          autocomplete
          v-model="form.email"
          v-show="!editMode"
          @keyup.enter="save(form)"
        />
      </div>

      <!-- Phone -->
      <div class="mb-4">
        <jet-label for="phone_number" value="Phone Number (ex. 639123456789)" />
        <jet-input
          id="phone_number"
          ref="phone_number"
          type="number"
          class="mt-1 block w-full"
          autocomplete
          v-model="form.phone_number"
          v-show="editMode"
          @keyup.enter="update(form)"
        />
        <jet-input
          id="phone_number"
          ref="phone_number"
          type="number"
          class="mt-1 block w-full"
          autocomplete
          v-model="form.phone_number"
          v-show="!editMode"
          @keyup.enter="save(form)"
        />
      </div>

      <!-- Birthday -->
      <div class="mb-4">
        <jet-label for="birthday" value="Birthday" />
        <jet-input
          id="birthday"
          type="date"
          class="mt-1 block w-full"
          autocomplete
          v-model="form.birthday"
          v-show="!editMode"
          @keyup.enter="save(form)"
        />
        <jet-input
          id="birthday"
          type="date"
          class="mt-1 block w-full"
          autocomplete
          v-model="form.birthday"
          v-show="editMode"
          @keyup.enter="update(form)"
        />
      </div>
    </template>

    <template #footer>
      <jet-secondary-button @click="openModal(false)"> Cancel </jet-secondary-button>

      <jet-button
        class="ml-2"
        v-show="!editMode"
        @click="save(form)"
        :disabled="disabled"
      >
        Save
      </jet-button>

      <jet-button
        class="ml-2"
        :class="{ 'opacity-25': disabled }"
        :disabled="disabled"
        v-show="editMode"
        @click="update(form)"
      >
        Update
      </jet-button>
    </template>
  </dialog-modal>
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
import JetDropdown from "@/Jetstream/Dropdown";
import JetDropdownLink from "@/Jetstream/DropdownLink";
import JetFormSection from "@/Jetstream/FormSection";
import JetActionMessage from "@/Jetstream/ActionMessage";
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
    JetDropdown,
    JetDropdownLink,
    JetFormSection,
    JetActionMessage,
    DialogModal,
    Link,
    Multiselect,
    NoData,
  },

  props: {
    applicants: Object,
    filters: Object,
    courses: Object,
  },

  extends: shared,

  data() {
    return {
      params: {
        search: this.filters.search,
        field: this.filters.field,
        direction: this.filters.direction,
        perpage: this.filters.perpage,
      },

      form: this.$inertia.form({
        fname: "",
        mname: "",
        lname: "",
        email: "",
        phone_number: "",
        birthday: "",
        course_applied: "",
      }),
      isOpen: false,
      disabled: null,
      editMode: false,
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

    // Sort function
    sort(field) {
      this.params.field = field;
      this.params.direction = this.params.direction === "asc" ? "desc" : "asc";
    },

    // Save function
    save: function (applicants) {
      this.$inertia.visit("/admin/applicants", {
        method: "post",
        data: this.form,
        onSuccess: () => {
          this.form = {};
        },
        preserveScroll: true,
        preserveState: true,
      });
    },

    // Edit mode function
    edit: function (applicant, status) {
      this.form = Object.assign({}, applicant);
      this.editMode = true;
      this.openModal(status);
    },

    // Update function
    update: function (applicant) {
      this.$inertia.visit("/admin/applicants/" + applicant.id, {
        method: "put",
        data: applicant,
        onBefore: () => {
          this.disabledClick(true);
        },
        onSuccess: () => {
          this.disabledClick(false), this.openModal(false), (this.form = {});
        },
        onFinish: () => (this.form = {}),
      });
    },

    // Delete function
    deleteRow: function (id) {
      this.$inertia.visit("/admin/applicants/" + id, {
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

    // Export function
    exportData: function (type) {
      const url = "/admin/export/applicants?type=" + type;
      window.location.href = url;
    },

    // Export function
    exportPDF: function () {
      const url = "/admin/pdf/applicants";
      window.location.href = url;
    },
  },
  watch: {
    params: {
      handler: throttle(function () {
        let params = pickBy(this.params);

        this.$inertia.get(this.route("admin.applicants.index"), params, {
          replace: true,
          preserveState: true,
        });
      }, 150),
      deep: true,
    },
  },
};
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
