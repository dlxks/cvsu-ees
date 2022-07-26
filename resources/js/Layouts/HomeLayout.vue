<template>
  <div>
    <Head :title="title" />
    <div class="min-h-screen bg-gray-100">
      <nav class="bg-white border-b border-gray-100">
        <nav class="bg-white border-b border-gray-100">
          <!-- Primary Navigation Menu -->
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
              <div class="flex">
                <!-- Navigation Links -->
                <div class="sm:items-center sm:-my-px sm:flex">
                  <Link :href="'/'" class="inline-flex align-middle mr-2">
                    <div class="flex items-center">
                      <div class="flex-shrink-0 h-10 w-10">
                        <img
                          src="https://drive.google.com/uc?id=1NQL8McpMmgaK0WgqpihPWsUzArvFHzRo"
                          class="w-10"
                          alt="CvSU Logo"
                          title="CvSU"
                        />
                      </div>
                      <div class="ml-4">
                        <div class="text-md font-medium text-gray-900">
                          Cavite State University
                        </div>
                      </div>
                    </div>
                  </Link>
                </div>
              </div>
              <div class="sm:flex sm:items-center sm:ml-6">
                <div class="ml-3 relative">
                  <jet-button
                    class="inline-flex items-center px-4 py-2 mr-2 bg-emerald-200 hover:bg-emerald-300 text-emerald-800 text-sm font-medium rounded-md"
                    @click="login"
                    >Login</jet-button
                  >
                </div>
              </div>
            </div>
          </div>
        </nav>
      </nav>

      <!-- Page Heading -->
      <header class="bg-white shadow" v-if="$slots.header">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header"></slot>
        </div>
      </header>

      <!-- Page Content -->
      <main>
        <slot></slot>
      </main>
    </div>
  </div>
</template>
<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import AdminSideBar from "@/Components/SideBar/AdminSidebar.vue";
import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetBanner from "@/Jetstream/Banner.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";
import JetButton from "@/Jetstream/Button.vue";

export default {
  props: {
    title: String,
  },
  components: {
    AdminSideBar,
    Head,
    Link,
    JetDropdown,
    JetDropdownLink,
    JetBanner,
    JetButton,
  },

  methods: {
    login: function () {
      this.$inertia.visit(route("applicant.login"));
    },
  },
};
</script>
