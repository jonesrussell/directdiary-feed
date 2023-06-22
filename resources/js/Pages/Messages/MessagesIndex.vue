<script setup>
import { ref } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import Conversation from '@/Components/Conversation.vue'
import DiaryLayout from '@/Layouts/DiaryLayout.vue';
import Messages from '@/Components/Messages.vue';

let page = usePage();
const authUser = page.props.auth.user;

let props = defineProps({
    conversations: Array,
    conversation: Array,
    conversationId: Number | null,
    messages: Array,
});

console.log('conversationId', props.conversationId);

let selectedConversation = ref(props.conversations.data[0]) ?? null;
console.log('selectedConversation', selectedConversation);

let foo = props.conversation.data;
console.log('foo', foo[0] ?? []);

console.log('messages', props.messages);

let selectedMessages = ref(props.conversation.data[0]) ?? null;
console.log('selectedMessages', selectedMessages);
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
                <Messages :conversationId="conversationId" :messages="messages.data" />
            </div>
        </div>
    </DiaryLayout>
</template>
