<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import Conversation from '@/Components/Conversation.vue'
import DiaryLayout from '@/Layouts/DiaryLayout.vue';

defineProps({ conversations: Array })
</script>

<template>
    <Head title="Messages" />

    <DiaryLayout title="Messages">
        <div class="text-white">

            <div class="flex" v-for="conversation in conversations.data" :key="conversation">
                <Conversation :conversation="conversation" />
            </div>
            <div class="border-b border-b-gray-800 mt-2"></div>
        </div>

    </DiaryLayout>
</template>

<style>
body {
    background-color: black;
}
</style>
