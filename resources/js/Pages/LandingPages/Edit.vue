<script setup>
import DiaryLayout from '@/Layouts/DiaryLayout.vue';
import UpdateLandingPageForm from './Partials/UpdateLandingPageForm.vue';
import DeleteLandingPageForm from './Partials/DeleteLandingPageForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    landingPage: Object,
    status: String,
});
</script>

<template>
    <Head title="Edit Landing Page" />

    <DiaryLayout title="Edit Landing Page">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Landing Page</h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdateLandingPageForm
                        :landing-page="landingPage"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <DeleteLandingPageForm
                        :landing-page="landingPage"
                        class="max-w-xl"
                    />
                </div>
            </div>
        </div>
    </DiaryLayout>
</template>

