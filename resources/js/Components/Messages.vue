<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

let pageProps = usePage().props;

const props = defineProps({
    conversationId: Number,
    messages: Array
});

let form = useForm({
    participant_id: pageProps.auth.user.id,
    participant_type: 'App\\Models\\User',  // Replace with your user model namespace
    message: {
        body: '',
    },
});

const sendMessage = () => {
    form.post(route('messages.store', props.conversationId), {
        onFinish: () => form.reset('message.body'),
    });
};
</script>

<template>
    <div class="m-4 text-white">
        <h1 class="text-xl font-bold mb-4">Conversation</h1>
        <div v-for="message in messages" :key="message.id">
            {{ message.body }}
        </div>

        <div class="mt-4">
            <textarea class="w-full px-2 py-1 border rounded text-black message-input"
                v-model="form.message.body"></textarea>
        </div>
        <div class="mt-2">
            <button class="px-4 py-2 bg-blue-500 text-white rounded" @click="sendMessage" :disabled="form.processing">
                {{ form.processing ? 'Sending...' : 'Send Message' }}
            </button>
        </div>
    </div>
</template>
