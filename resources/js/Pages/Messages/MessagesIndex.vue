<script setup>
import { ref } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import Conversation from '@/Components/Conversation.vue'
import DiaryLayout from '@/Layouts/DiaryLayout.vue';
import Messages from '@/Components/Messages.vue';

let page = usePage();
const authUser = page.props.auth.user;

let props = defineProps({ conversations: Array, firstConversationMessages: Array });

let selectedConversation = ref(props.conversations?.data[0]);
let selectedMessages = ref(props.firstConversationMessages);
</script>

<template>
    <Head title="Messages" />

    <DiaryLayout :title="'Messages'" :thirdSectionComponent="Messages" :messages="selectedMessages">
        <div class="text-white">
            <div v-for="conversation in conversations.data" :key="conversation.id">
                <Link
                    :href="`/messages/${conversation.id}?participant_id=${authUser.id}&participant_type=${encodeURIComponent('\\App\\Models\\User')}`">
                <Conversation :conversation="conversation" />
                </Link>
            </div>
            <div class="border-b border-b-gray-800 mt-2"></div>
        </div>
    </DiaryLayout>
</template>
