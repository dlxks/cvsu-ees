<template>
  <Head :title="title" />
  <div>
    <div class="relative">
      <!-- Header holder -->
      <header class="bg-white" v-if="$slots.header">
        <div class="max-w-full mx-auto py-4 px-8 sm:px-8 lg:px-10">
          <slot name="header"></slot>
        </div>
      </header>
      <!-- Header holder -->

      <!-- page content -->
      <div class="pb-40">
        <div class="max-w-full mx-auto px-14 sm:px-4 lg:px-12">
          <jet-banner />
          <main>
            <slot></slot>
          </main>
        </div>
      </div>
      <!-- page content -->
    </div>
  </div>
</template>
<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetBanner from "@/Jetstream/Banner.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";

export default {
  props: {
    title: String,
  },
  components: {
    Head,
    Link,
    JetDropdown,
    JetDropdownLink,
    JetBanner,
  },
};
</script>
