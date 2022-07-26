<template>
  <Head title="Log in" />

  <JetAuthenticationCard>
    <template #logo class="center">
      <JetAuthenticationCardLogo />
    </template>

    <JetValidationErrors class="mb-4" />
    <jet-banner class="mb-4" />
    <form @submit.prevent="submit">
      <!-- Control Number -->
      <div class="mt-4">
        <JetLabel for="control_number" value="Control Number" />
        <JetInput
          id="control_number"
          type="number"
          class="mt-1 block w-full"
          v-model="form.control_number"
          required
        />
      </div>
      <!-- Email -->
      <div class="mt-4">
        <JetLabel for="email" value="Email" />
        <JetInput
          id="email"
          type="email"
          class="mt-1 block w-full"
          v-model="form.email"
          required
        />
      </div>
      <!-- Birthday -->
      <div class="mt-4">
        <JetLabel for="birthday" value="Birthdate" />
        <JetInput
          id="birthday"
          type="date"
          class="mt-1 block w-full"
          v-model="form.birthday"
          @keyup.enter="login(form)"
          required
        />
      </div>

      <div class="flex items-center justify-end mt-4">
        <Link href="/"> Cancel </Link>

        <JetButton
          class="ml-4"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Log in
        </JetButton>
      </div>

      <div class="flex items-center justify-center mt-4">
        <Link
          :href="route('login')"
          class="underline text-md text-gray-500 hover:text-gray-700"
        >
          Personnel/Admin Login
        </Link>
      </div>
    </form>
  </JetAuthenticationCard>
</template>

<script setup>
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import JetAuthenticationCard from "@/Jetstream/AuthenticationCard.vue";
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import JetFormSection from "@/Jetstream/FormSection";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetBanner from "@/Jetstream/Banner.vue";

const form = useForm({
  control_number: "",
  email: "",
  birthday: "",
});

const submit = () => {
  form
    .transform((data) => ({
      ...data,
    }))
    .post(route("applicant.login"));
};
</script>
