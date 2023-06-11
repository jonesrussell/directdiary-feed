<script setup>
import { onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import HeartOutline from 'vue-material-design-icons/HeartOutline.vue'
import MessageOutline from 'vue-material-design-icons/MessageOutline.vue'
import Sync from 'vue-material-design-icons/Sync.vue'
import DotsHorizontal from 'vue-material-design-icons/DotsHorizontal.vue'
import TrashCanOutline from 'vue-material-design-icons/TrashCanOutline.vue'

let props = defineProps({ conversation: Object });

let openOptions = ref(false);

console.log(props.conversation);

let c = props.conversation.conversation;
let participants = c.participants;
console.log(c);
</script>

<template>
    <div class="min-w-[60px]">
        <img class="rounded-full m-2 mt-3" width="50" :src="conversation?.image">
    </div>
    <div class="p-2 w-full">
        <div class="font-extrabold flex items-center justify-between mt-0.5 mb-1.5">
            <div class="flex items-center">
                <div>
                    {{ conversation?.user?.firstname }}
                    {{ conversation?.user?.lastname }}
                </div>
                <span class="font-[300] text-[15px] text-gray-500 pl-2">
                    @{{ conversation?.user?.username }}
                </span>
            </div>
            <div class="hover:bg-gray-800 rounded-full cursor-pointer relative">
                <button type="button" class="block p-2">
                    <DotsHorizontal @click="openOptions = !openOptions" />
                </button>
                <div v-if="openOptions"
                    class="absolute mt-1 right-0 w-[300px] bg-black border border-gray-700 rounded-lg shadow-lg">
                    <ul class="p-3">
                        <Link as="button" method="delete" :href="route('conversations.destroy', { id: conversation.id })"
                            class="flex items-center cursor-pointer">
                        <TrashCanOutline class="pr-3" fillColor="#DC2626" :size="18" />
                        <span class="text-red-600 font-extrabold">Delete</span>
                        </Link>
                    </ul>
                </div>
            </div>
        </div>

        <div class="pb-3">{{ conversation?.conversation }}</div>

    </div>
</template>
