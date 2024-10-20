<script setup>
import DiaryLayout from '@/Layouts/DiaryLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    domain: Object,
});
</script>

<template>
    <Head :title="`Domain - ${domain.name}`" />

    <DiaryLayout :title="`Domain - ${domain.name}`">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Domain Details</h2>
                <Link :href="route('domains.edit', domain.id)">
                    <PrimaryButton>Edit Domain</PrimaryButton>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Domain Name</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ domain.name }}</p>
                        </div>

                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Created At</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ new Date(domain.created_at).toLocaleString() }}</p>
                        </div>

                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Updated At</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ new Date(domain.updated_at).toLocaleString() }}</p>
                        </div>

                        <div class="mt-6">
                            <Link :href="route('domains.index')" class="text-indigo-600 hover:text-indigo-900">
                                Back to Domains
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DiaryLayout>
</template>

