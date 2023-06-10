<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import DotsHorizontal from 'vue-material-design-icons/DotsHorizontal.vue'
import TrashCanOutline from 'vue-material-design-icons/TrashCanOutline.vue'

const props = defineProps({ post: Object });

let openOptions = ref(false);

let user = props.post.user;
let avatar = props.post.user.avatar;
let username = user.username;
let fullname = `${user.firstname} ${user.lastname}`
let profileUrl = `/${username}`
</script>

<template>
    <div class="min-w-[60px]">
        <img class="rounded-full m-2 mt-3" width="50" :src="avatar" />
    </div>
    <div class="p-2 w-full text-white">
        <div class="font-extrabold flex items-center justify-between mt-0.5 mb-1.5">
            <div class="flex items-center">
                <Link :href="profileUrl">
                <div>{{ fullname }}</div>
                </Link>
                <Link :href="profileUrl">
                <span class="font-[300] text-[15px] text-gray-500 pl-2">
                    @{{ username }}
                </span>
                </Link>
            </div>
            <div class="hover:bg-gray-800 rounded-full cursor-pointer relative">
                <button type="button" class="block p-2">
                    <DotsHorizontal @click="openOptions = !openOptions" />
                </button>
                <div v-if="openOptions"
                    class="absolute mt-1 right-0 w-[300px] bg-black border border-gray-700 rounded-lg shadow-lg">
                    <ul class="p-3">
                        <Link as="button" method="delete" :href="route('posts.destroy', { id: post.id })"
                            class="flex items-center cursor-pointer">
                        <TrashCanOutline class="pr-3" fillColor="#DC2626" :size="18" />
                        <span class="text-red-600 font-extrabold">Delete</span>
                        </Link>
                    </ul>
                </div>
            </div>
        </div>
        <div class="pb-3">{{ post.post }}</div>
        <div v-if="post.file">
            <div v-if="!post.is_video" class="rounded-xl">
                <img :src="post.file" class="mt-2 object-fill rounded-xl w-full" />
            </div>
            <div v-else>
                <video class="rounded-xl" :src="post.file" controls></video>
            </div>
        </div>
    </div>
</template>
