<script setup>
import DiaryLayout from '@/Layouts/DiaryLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';

const props = defineProps({
    domains: {
        type: Array,
        required: true
    },
    userId: {
        type: Number,
        required: true
    },
});

const form = useForm({
    name: '',
    user_id: props.userId,
});

const errorMessage = ref('');
const successMessage = ref('');

const submit = () => {
    form.post(route('domains.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('name');
            successMessage.value = 'Domain added successfully';
            setTimeout(() => successMessage.value = '', 3000);
        },
        onError: (errors) => {
            errorMessage.value = Object.values(errors).join(', ');
            setTimeout(() => errorMessage.value = '', 5000);
        },
    });
};

const deleteDomain = (domainId) => {
    if (confirm('Are you sure you want to delete this domain?')) {
        form.delete(route('domains.destroy', { domain: domainId }), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Domains" />

    <DiaryLayout title="Domains">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Domains</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- Success and Error Messages -->
                        <div v-if="successMessage" class="mb-4 text-sm text-green-600">{{ successMessage }}</div>
                        <div v-if="errorMessage" class="mb-4 text-sm text-red-600">{{ errorMessage }}</div>

                        <!-- Add Domain Form -->
                        <form @submit.prevent="submit" class="mb-6">
                            <div class="flex items-center">
                                <div class="flex-grow mr-4">
                                    <InputLabel for="name" value="Domain Name" class="sr-only" />
                                    <TextInput
                                        id="name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.name"
                                        required
                                        placeholder="Enter domain name"
                                    />
                                    <InputError :message="form.errors.name" class="mt-2" />
                                </div>
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Add Domain
                                </PrimaryButton>
                            </div>
                        </form>

                        <!-- Domains Table -->
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Domain Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Extension
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Created At
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="domain in domains" :key="domain.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ domain.name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ domain.extension }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ new Date(domain.created_at).toLocaleDateString() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button @click="deleteDomain(domain.id)">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </DiaryLayout>
</template>
