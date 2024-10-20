<script setup>
import DiaryLayout from '@/Layouts/DiaryLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    landingPage: Object,
});
</script>

<template>
    <Head :title="`Landing Page - ${landingPage.domain}`" />

    <DiaryLayout :title="`Landing Page - ${landingPage.domain}`">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Landing Page Details</h2>
                <Link :href="route('landing-pages.edit', landingPage.id)">
                    <PrimaryButton>Edit Landing Page</PrimaryButton>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Domain</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ landingPage.domain }}</p>
                        </div>

                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Created At</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ new Date(landingPage.created_at).toLocaleString() }}</p>
                        </div>

                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Updated At</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ new Date(landingPage.updated_at).toLocaleString() }}</p>
                        </div>

                        <!-- Add more fields as needed -->

                        <div class="mt-6">
                            <Link :href="route('landing-pages.index')" class="text-indigo-600 hover:text-indigo-900">
                                Back to Landing Pages
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DiaryLayout>
</template>

