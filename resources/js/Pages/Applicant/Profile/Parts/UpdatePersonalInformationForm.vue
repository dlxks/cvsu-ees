<template>
  <jet-form-section>
    <template #title> Personal Information </template>

    <template #description> Update your personal information. </template>

    <template #form>
      <!-- Name -->
      <div class="col-span-6 sm:col-span-4">
        <jet-label for="fname" value="First Name" />
        <jet-input
          id="fname"
          type="text"
          class="mt-1 block w-full"
          autocomplete="fname"
        />
        <jet-input-error class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <jet-label for="mname" value="Middle Name" />
        <jet-input
          id="mname"
          type="text"
          class="mt-1 block w-full"
          autocomplete="mname"
        />
        <jet-input-error class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <jet-label for="lname" value="Last Name" />
        <jet-input
          id="lname"
          type="text"
          class="mt-1 block w-full"
          autocomplete="lname"
        />
        <jet-input-error class="mt-2" />
      </div>
    </template>

    <template #actions>
      <jet-action-message class="mr-3"> Saved. </jet-action-message>

      <jet-button> Save </jet-button>
    </template>
  </jet-form-section>
</template>

<script>
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";

export default {
  components: {
    JetActionMessage,
    JetButton,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetSecondaryButton,
  },
};
</script>
