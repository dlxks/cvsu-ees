<template>
  <admin-layout title="Profile">
    <template #header>
      <!-- Header -->
      <div class="grid grid-cols-2 px-5 py-3 shadow-md rounded-md">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span>Manage Account</span>
          </h2>
        </div>
        <!-- Header -->
      </div>
    </template>

    <div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div v-if="$page.props.jetstream.canUpdateProfileInformation">
          <update-profile-information-form :user="$page.props.auth.user" />

          <jet-section-border />
        </div>

        <div v-if="$page.props.jetstream.canUpdatePassword">
          <update-password-form class="mt-10 sm:mt-0" />

          <jet-section-border />
        </div>

        <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
          <two-factor-authentication-form class="mt-10 sm:mt-0" />

          <jet-section-border />
        </div>

        <logout-other-browser-sessions-form :sessions="sessions" class="mt-10 sm:mt-0" />

        <template v-if="$page.props.jetstream.hasAccountDeletionFeatures">
          <jet-section-border />

          <delete-user-form class="mt-10 sm:mt-0" />
        </template>
      </div>
    </div>
  </admin-layout>
</template>

<script>
import { defineComponent } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import DeleteUserForm from "@/Pages/Profile/Partials/DeleteUserForm.vue";
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";
import LogoutOtherBrowserSessionsForm from "@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue";
import TwoFactorAuthenticationForm from "@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue";
import UpdatePasswordForm from "@/Pages/Profile/Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "@/Pages/Profile/Partials/UpdateProfileInformationForm.vue";

export default defineComponent({
  props: ["sessions"],

  components: {
    AdminLayout,
    DeleteUserForm,
    JetSectionBorder,
    LogoutOtherBrowserSessionsForm,
    TwoFactorAuthenticationForm,
    UpdatePasswordForm,
    UpdateProfileInformationForm,
  },
});
</script>
