<script setup>
import DiaryLayout from '@/Layouts/DiaryLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    domain: '',
    // Add any other fields your landing page might have
});

const submit = () => {
    form.post(route('landing-pages.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset('domain'),
    });
};
</script>

<template>
    <Head title="Create Landing Page" />

    <DiaryLayout title="Create Landing Page">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Landing Page</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="domain" value="Domain" />
                                <TextInput
                                    id="domain"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.domain"
                                    required
                                    autofocus
                                    autocomplete="domain"
                                />
                                <InputError class="mt-2" :message="form.errors.domain" />
                            </div>

                            <!-- Add more fields as needed for your landing page -->

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Create Landing Page
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </DiaryLayout>
</template>

