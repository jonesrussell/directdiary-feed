<script setup>
import { ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
import TrashCanOutline from "vue-material-design-icons/TrashCanOutline.vue";

const page = usePage();
let authUserId = page.props.auth.user.id;
let props = defineProps({ conversation: Object });
let openOptions = ref(false);
let convo = props.conversation.conversation;
let participants = convo.participants;

// Filter out the authenticated user
let otherUser = participants.find(
    (participant) => participant.messageable.id !== authUserId
);

let lastMessage = "Last message goes here.";
</script>

<template>
    <div class="flex hover:bg-gray-500 hover:bg-opacity-50">
        <div>
            <img :src="otherUser?.messageable?.avatar" class="rounded-full mb-4 w-8 h-8 m-2 mt-3" />
        </div>
        <div class="p-2 w-full">

            <div class="font-extrabold flex items-center justify-between mt-0.5 mb-1.5">
                <div class="flex items-center">
                    <div>
                        {{ otherUser?.messageable?.firstname }}
                        {{ otherUser?.messageable?.lastname }}
                    </div>
                    <span class="font-[300] text-[15px] text-gray-500 pl-2">
                        @{{ otherUser?.messageable?.username }}
                    </span>
                </div>

                <div class="hover:bg-gray-800 rounded-full cursor-pointer relative">
                    <button type="button" class="block p-2">
                        <DotsHorizontal @click="openOptions = !openOptions" />
                    </button>
                    <div v-if="openOptions"
                        class="absolute mt-1 right-0 w-[300px] bg-[#051239] border border-gray-700 rounded-lg shadow-lg">
                        <ul class="p-3">
                            <Link as="button" method="delete" :href="route('conversations.destroy', {
                                id: conversation.id,
                            })
                                " class="flex items-center cursor-pointer">
                            <TrashCanOutline class="pr-3" fillColor="#DC2626" :size="18" />
                            <span class="text-red-600 font-extrabold">Delete</span>
                            </Link>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="pb-3">{{ lastMessage }}</div>
        </div>
    </div>
</template>
