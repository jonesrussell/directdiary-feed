<script setup>
import { ref } from 'vue';

const props = defineProps({
    conversationId: Number,
    messages: Array
});

let isLoading = ref(false);

</script>

<template>
    <div class="m-4 text-white">
        <h1 class="text-xl font-bold mb-4">Conversation</h1>
        <div v-for="message in messages" :key="message.id">
            Messages go here
        </div>
    </div>
</template>
