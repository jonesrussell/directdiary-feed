<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const props = defineProps({
    landingPage: Object,
});

const confirmingLandingPageDeletion = ref(false);
const domainInput = ref(null);

const form = useForm({
    domain: '',
});

const confirmLandingPageDeletion = () => {
    confirmingLandingPageDeletion.value = true;

    nextTick(() => domainInput.value.focus());
};

const deleteLandingPage = () => {
    form.delete(route('landing-pages.destroy', props.landingPage.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => domainInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingLandingPageDeletion.value = false;

    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Delete Landing Page</h2>

            <p class="mt-1 text-sm text-gray-600">
                Once your landing page is deleted, all of its resources and data will be permanently deleted. Before deleting
                your landing page, please ensure you want to proceed with this action.
            </p>
        </header>

        <DangerButton @click="confirmLandingPageDeletion">Delete Landing Page</DangerButton>

        <Modal :show="confirmingLandingPageDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete this landing page?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once your landing page is deleted, all of its resources and data will be permanently deleted. Please
                    enter the domain name to confirm you would like to permanently delete this landing page.
                </p>

                <div class="mt-6">
                    <InputLabel for="domain" value="Domain" class="sr-only" />

                    <TextInput
                        id="domain"
                        ref="domainInput"
                        v-model="form.domain"
                        type="text"
                        class="mt-1 block w-3/4"
                        placeholder="Enter domain name"
                        @keyup.enter="deleteLandingPage"
                    />

                    <InputError :message="form.errors.domain" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing || form.domain !== props.landingPage.domain"
                        @click="deleteLandingPage"
                    >
                        Delete Landing Page
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>

