<script setup>
import { Head, Link } from '@inertiajs/vue3';
import DiaryLayout from '@/Layouts/DiaryLayout.vue';
import Post from '@/Components/Post.vue';

const props = defineProps({ profile: Array });

let username = props.profile?.username;
let fullname = `${props.profile?.firstname} ${props.profile?.lastname}`
let posts = props.profile?.posts;
let profileUrl = `/${username}`
let profileDomainsUrl = `/${username}/domains`
</script>

<template>
    <Head :title="fullname" />

    <DiaryLayout :title="fullname" showProfileTabs>
        <div class="m-4 text-white">
            <img :src="profile?.avatar" class="rounded-full mb-4" />
            <div>{{ fullname }}</div>
            <div>@{{ username }}</div>
        </div>

        <div class="flex">
            <div
                class="flex items-center justify-center w-full h-[60px] text-white text-[17px] font-extrabold p-4 hover:bg-gray-500 hover:bg-opacity-30 cursor-pointer transition duration-200 ease-in-out">
                <div class="inline-block text-center border-b-4 border-b-[#1C9CEF] h-[60px]">
                    <Link :href="profileUrl">
                    <div class="my-auto mt-4">Posts</div>
                    </Link>
                </div>
            </div>
            <div
                class="w-full h-[60px] text-gray-500 text-[17px] font-extrabold p-4 hover:bg-gray-500 hover:bg-opacity-30 cursor-pointer transition duration-200 ease-in-out">
                <Link :href="profileDomainsUrl">
                <div class="text-center">Domains</div>
                </Link>
            </div>
        </div>

        <div class="flex" v-for="post in posts" :key="post">
            <Post :post="post" />
        </div>

    </DiaryLayout>
</template>

<style>
body {
    background-color: black;
}
</style>
