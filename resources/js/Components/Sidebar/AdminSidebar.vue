<template>
  <nav
    class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-64 z-10 py-4 px-6"
  >
    <div
      class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 flex flex-wrap items-center justify-between w-full mx-auto"
    >
      <!-- Toggler -->
      <button
        class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
        type="button"
        v-on:click="toggleCollapseShow('bg-white m-2 py-3 px-6')"
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
            d="M4 6h16M4 12h16M4 18h16"
          />
        </svg>
      </button>
      <!-- Toggler -->

      <!-- Brand -->
      <jet-nav-link
        :href="route('admin.dashboard.index')"
        class="md:block text-left md:pb-2 text-gray-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0"
        to="/"
      >
        <span>Cavite State University</span>
      </jet-nav-link>

      <!-- Profile Dropdown -->
      <div class="ml-3 md:hidden">
        <jet-dropdown>
          <template #trigger>
            <button
              v-if="$page.props.jetstream.managesProfilePhotos"
              class="text-sm border-transparent focus:outline-none focus:border-gray-300 transition"
            >
              <img
                class="rounded-full h-10 w-10 object-cover"
                :src="$page.props.user.profile_photo_url"
                :alt="$page.props.user.name"
              />
            </button>

            <span v-else class="inline-flex rounded-md">
              <button
                type="button"
                class="inline-flex items-center border border-transparent text-md leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition"
              >
                {{ $page.props.user.name }}

                <svg
                  class="ml-2 -mr-0.5 h-4 w-4"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path
                    fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd"
                  />
                </svg>
              </button>
            </span>
          </template>

          <template #content>
            <!-- Account Management -->
            <div class="block px-4 py-2 text-xs text-gray-400">Manage Account</div>

            <jet-dropdown-link :href="route('profile.show')"> Profile </jet-dropdown-link>

            <div class="border-t border-gray-100"></div>

            <!-- Authentication -->
            <form @submit.prevent="logout">
              <jet-dropdown-link as="button"> Log Out </jet-dropdown-link>
            </form>
          </template>
        </jet-dropdown>
      </div>

      <!-- Collapse -->
      <div
        class="fixed md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:mt-4 md:shadow-none shadow top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded"
        v-bind:class="collapseShow"
      >
        <!-- Collapse header -->
        <div
          class="md:min-w-full md:hidden block pb-4 mb-4 border-b border-solid border-gray-200"
        >
          <div class="flex flex-wrap">
            <div class="w-6/12">
              <jet-nav-link
                :href="route('admin.dashboard.index')"
                class="uppercase py-2 font-bold block"
              >
                <span>Cavite State University</span>
              </jet-nav-link>
            </div>

            <!-- Collapse button -->
            <div class="w-6/12 flex justify-end">
              <button
                type="button"
                class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
                v-on:click="toggleCollapseShow('hidden')"
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
                    d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </button>
            </div>
            <!-- Collapse button -->
          </div>
        </div>

        <!-- User Profile Divider Start -->
        <hr class="my-3 md:min-w-full hidden md:block" />
        <!-- User Profile -->
        <ul class="md:flex-col md:min-w-full flex flex-col list-none hidden md:block">
          <li>
            <!-- Settings Dropdown -->
            <div>
              <jet-dropdown>
                <template #trigger>
                  <button
                    v-if="$page.props.jetstream.managesProfilePhotos"
                    class="text-sm border-transparent rounded-full focus:outline-none focus:border-gray-300 transition"
                  >
                    <div class="flex" align="left">
                      <div class="flex-shrink-0 h-10 w-10">
                        <img
                          class="rounded-full h-10 w-10 object-cover"
                          :src="$page.props.user.profile_photo_url"
                          :alt="$page.props.user.name"
                        />
                      </div>
                      <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">
                          {{ $page.props.user.name }}
                        </div>
                        <div class="text-sm text-gray-500">
                          {{ $page.props.user.email }}
                        </div>
                      </div>
                    </div>
                  </button>

                  <span v-else class="inline-flex rounded-md">
                    <button
                      type="button"
                      class="inline-flex items-center border border-transparent text-md leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition"
                    >
                      {{ $page.props.user.name }}

                      <svg
                        class="ml-2 -mr-0.5 h-4 w-4"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                          clip-rule="evenodd"
                        />
                      </svg>
                    </button>
                  </span>
                </template>

                <template #content>
                  <!-- Account Management -->
                  <div class="block px-4 py-2 text-xs text-gray-400">Manage Account</div>

                  <jet-dropdown-link :href="route('profile.show')">
                    Profile
                  </jet-dropdown-link>

                  <div class="border-t border-gray-100"></div>

                  <!-- Authentication -->
                  <form @submit.prevent="logout">
                    <jet-dropdown-link as="button"> Log Out </jet-dropdown-link>
                  </form>
                </template>
              </jet-dropdown>
            </div>
          </li>
        </ul>

        <!-- Divider Start -->
        <hr class="my-3 md:min-w-full" />
        <!-- Navigation -->
        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <li class="items-center">
            <jet-nav-link
              :href="route('admin.dashboard.index')"
              class="text-xs uppercase py-2 font-bold block"
              :class="
                route().current('admin.dashboard.index')
                  ? 'text-emerald-500 hover:text-emerald-600'
                  : 'text-gray-700 hover:text-gray-500'
              "
            >
              <i>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5 mr-3"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  stroke-width="2"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                  /></svg
              ></i>
              <span>Dashboard</span>
            </jet-nav-link>
          </li>
        </ul>

        <!-- Divider Start-->
        <hr class="my-3 md:min-w-full" />
        <!-- Heading -->
        <h6
          class="md:min-w-full text-gray-500 text-xs uppercase font-bold block pt-1 pb-2 no-underline"
        >
          Examinations
        </h6>
        <!-- Navigation Start -->
        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <!-- Link Start-->
          <li class="items-center">
            <jet-nav-link
              v-if="$page.props.permission.exams.viewAny"
              :href="route('admin.exams.index')"
              class="text-xs uppercase py-2 font-bold block"
              :class="
                route().current('admin.exams.index') ||
                route().current('admin.exams.show') ||
                route().current('admin.questions.edit')
                  ? 'text-emerald-500 hover:text-emerald-600'
                  : 'text-gray-700 hover:text-gray-500'
              "
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 mr-3"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                />
              </svg>
              <span>Exams</span>
            </jet-nav-link>
          </li>
          <!-- Link End -->

          <!-- Link Start-->
          <li class="items-center">
            <jet-nav-link
              v-if="$page.props.permission.schedules.viewAny"
              :href="route('admin.schedules.index')"
              class="text-xs uppercase py-2 font-bold block"
              :class="
                route().current('admin.schedules.index')
                  ? 'text-emerald-500 hover:text-emerald-600'
                  : 'text-gray-700 hover:text-gray-500'
              "
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 mr-3"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                />
              </svg>
              <span>Exam Schedules</span>
            </jet-nav-link>
          </li>
          <!-- Link End -->
        </ul>
        <!-- Navigation End -->
        <!-- Divider End-->

        <!-- Divider Start-->
        <hr class="my-3 md:min-w-full" />
        <!-- Heading -->
        <h6
          class="md:min-w-full text-gray-500 text-xs uppercase font-bold block pt-1 pb-2 no-underline"
        >
          Courses
        </h6>
        <!-- Navigation Start -->
        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <!-- Link Start-->
          <li class="items-center">
            <jet-nav-link
              v-if="$page.props.permission.colleges.viewAny"
              :href="route('admin.colleges.index')"
              class="text-xs uppercase py-2 font-bold block"
              :class="
                route().current('admin.colleges.index')
                  ? 'text-emerald-500 hover:text-emerald-600'
                  : 'text-gray-700 hover:text-gray-500'
              "
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 mr-3"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"
                />
              </svg>
              <span>Colleges</span>
            </jet-nav-link>
          </li>
          <!-- Link End -->

          <!-- Link Start-->
          <li class="items-center">
            <jet-nav-link
              v-if="$page.props.permission.courses.viewAny"
              :href="route('admin.courses.index')"
              class="text-xs uppercase py-2 font-bold block"
              :class="
                route().current('admin.courses.index')
                  ? 'text-emerald-500 hover:text-emerald-600'
                  : 'text-gray-700 hover:text-gray-500'
              "
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 mr-3"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                />
              </svg>
              <span>Courses</span>
            </jet-nav-link>
          </li>
          <!-- Link End -->
        </ul>
        <!-- Navigation End -->
        <!-- Divider End-->

        <!-- Divider Start-->
        <hr class="my-3 md:min-w-full" />
        <!-- Heading -->
        <h6
          class="md:min-w-full text-gray-500 text-xs uppercase font-bold block pt-1 pb-2 no-underline"
        >
          Results
        </h6>
        <!-- Navigation Start -->
        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <!-- Link Start-->
          <!-- <li class="items-center">
            <jet-nav-link
              v-if="$page.props.permission.results.viewAny"
              :href="route('admin.results.index')"
              class="text-xs uppercase py-2 font-bold block"
              :class="
                route().current('admin.results.index') ||
                route().current('admin.results.show')
                  ? 'text-emerald-500 hover:text-emerald-600'
                  : 'text-gray-700 hover:text-gray-500'
              "
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 mr-3"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"
                />
              </svg>
              <span>Exam Results</span>
            </jet-nav-link>
          </li> -->
          <!-- Link End -->
          <!-- Link Start-->
          <li class="items-center">
            <jet-nav-link
              v-if="$page.props.permission.verifieds.viewAny"
              :href="route('admin.verified.index')"
              class="text-xs uppercase py-2 font-bold block"
              :class="
                route().current('admin.verified.index') ||
                route().current('admin.verified.show')
                  ? 'text-emerald-500 hover:text-emerald-600'
                  : 'text-gray-700 hover:text-gray-500'
              "
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 mr-3"
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
              <span>Results Verification</span>
            </jet-nav-link>
          </li>
          <!-- Link End -->
        </ul>
        <!-- Navigation End -->
        <!-- Divider End-->

        <!-- Divider Start-->
        <hr class="my-3 md:min-w-full" />
        <!-- Heading -->
        <h6
          class="md:min-w-full text-gray-500 text-xs uppercase font-bold block pt-1 pb-2 no-underline"
        >
          Chatbot
        </h6>
        <!-- Navigation Start -->
        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <!-- Link Start-->
          <li class="items-center">
            <jet-nav-link
              v-if="$page.props.permission.chatbot.viewAny"
              :href="route('admin.chatbot.index')"
              class="text-xs uppercase py-2 font-bold block"
              :class="
                route().current('admin.chatbot.index')
                  ? 'text-emerald-500 hover:text-emerald-600'
                  : 'text-gray-700 hover:text-gray-500'
              "
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 mr-3"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                />
              </svg>
              <span>Chatbot Questions</span>
            </jet-nav-link>
          </li>
          <!-- Link End -->
          <!-- Link Start-->
          <li class="items-center">
            <jet-nav-link
              :href="route('admin.messages.index')"
              class="text-xs uppercase py-2 font-bold block"
              :class="
                route().current('admin.messages.index')
                  ? 'text-emerald-500 hover:text-emerald-600'
                  : 'text-gray-700 hover:text-gray-500'
              "
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 mr-3"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"
                />
              </svg>
              <span>Applicant Messages</span>
            </jet-nav-link>
          </li>
          <!-- Link End -->
        </ul>
        <!-- Navigation End -->
        <!-- Divider End-->

        <!-- Divider Start-->
        <hr class="my-3 md:min-w-full" />
        <!-- Heading -->
        <h6
          class="md:min-w-full text-gray-500 text-xs uppercase font-bold block pt-1 pb-2 no-underline"
        >
          Access Rights
        </h6>
        <!-- Navigation Start -->
        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <!-- Link Start-->
          <li class="items-center">
            <jet-nav-link
              :href="route('admin.applicants.index')"
              class="text-xs uppercase py-2 font-bold block"
              :class="
                route().current('admin.applicants.index')
                  ? 'text-emerald-500 hover:text-emerald-600'
                  : 'text-gray-700 hover:text-gray-500'
              "
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 mr-3"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                />
              </svg>
              <span>Applicants</span>
            </jet-nav-link>
          </li>
          <!-- Link End -->

          <!-- Link Start-->
          <li class="items-center">
            <jet-nav-link
              v-if="$page.props.permission.users.viewAny"
              :href="route('admin.users.index')"
              class="text-xs uppercase py-2 font-bold block"
              :class="
                route().current('admin.users.index')
                  ? 'text-emerald-500 hover:text-emerald-600'
                  : 'text-gray-700 hover:text-gray-500'
              "
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 mr-3"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                />
              </svg>
              <span>Users</span>
            </jet-nav-link>
          </li>
          <!-- Link End -->
        </ul>
        <!-- Navigation End -->
        <!-- Divider End-->
      </div>
    </div>
  </nav>
</template>

<script>
import JetNavLink from "@/Jetstream/NavLink.vue";
import JetDropdown from "@/Jetstream/Dropdown";
import JetDropdownLink from "@/Jetstream/DropdownLink";

export default {
  components: {
    JetNavLink,
    JetDropdown,
    JetDropdownLink,
  },

  data() {
    return {
      collapseShow: "hidden",
    };
  },
  methods: {
    toggleCollapseShow: function (classes) {
      this.collapseShow = classes;
    },

    logout() {
      this.$inertia.post(route("logout"));
    },
  },
};
</script>
