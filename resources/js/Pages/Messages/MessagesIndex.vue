<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import Conversation from '@/Components/Conversation.vue'
import DiaryLayout from '@/Layouts/DiaryLayout.vue';
import Messages from '@/Components/Messages.vue';

let page = usePage();
const authUser = page.props.auth.user;

let props = defineProps({
    conversations: Array,
    conversation: Array | null,
    conversationId: Number | null,
    otherUser: Array,
    messages: Array,
});

console.log('otherUser', props.otherUser);
</script>

<template>
    <Head title="Messages" />

    <DiaryLayout :title="'Messages'">
        <div class="grid grid-cols-2 gap-4 text-white">
            <div>
                <div v-for="conversation in conversations.data" :key="conversation.id">
                    <Link
                        :href="`/messages/${conversation.id}?participant_id=${authUser.id}&participant_type=${encodeURIComponent('\\App\\Models\\User')}`">
                    <Conversation :conversation="conversation" />
                    </Link>
                </div>
                <div class="border-b border-b-gray-800 mt-2"></div>
            </div>
            <div v-if="conversationId">
                <Messages :conversationId="conversationId" :messages="messages.data" :otherUser="otherUser" />
            </div>
        </div>
    </DiaryLayout>
</template>
