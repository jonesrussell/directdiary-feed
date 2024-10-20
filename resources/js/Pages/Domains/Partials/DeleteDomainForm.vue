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
    domain: Object,
});

const confirmingDomainDeletion = ref(false);
const nameInput = ref(null);

const form = useForm({
    name: '',
});

const confirmDomainDeletion = () => {
    confirmingDomainDeletion.value = true;

    nextTick(() => nameInput.value.focus());
};

const deleteDomain = () => {
    form.delete(route('domains.destroy', props.domain.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => nameInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingDomainDeletion.value = false;

    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Delete Domain</h2>

            <p class="mt-1 text-sm text-gray-600">
                Once your domain is deleted, all of its resources and data will be permanently deleted. Before deleting
                your domain, please ensure you want to proceed with this action.
            </p>
        </header>

        <DangerButton @click="confirmDomainDeletion">Delete Domain</DangerButton>

        <Modal :show="confirmingDomainDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete this domain?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once your domain is deleted, all of its resources and data will be permanently deleted. Please
                    enter the domain name to confirm you would like to permanently delete this domain.
                </p>

                <div class="mt-6">
                    <InputLabel for="name" value="Domain Name" class="sr-only" />

                    <TextInput
                        id="name"
                        ref="nameInput"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-3/4"
                        placeholder="Enter domain name"
                        @keyup.enter="deleteDomain"
                    />

                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing || form.name !== props.domain.name"
                        @click="deleteDomain"
                    >
                        Delete Domain
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>

