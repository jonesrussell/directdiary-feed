<script setup>
    import { ref } from 'vue';
    import { Head, Link } from '@inertiajs/vue3';
    import Post from '@/Components/Post.vue'
    import DiaryLayout from '@/Layouts/DiaryLayout.vue';

    defineProps({ posts: Array })
</script>

<template>

    <Head title="Explore" />

    <DiaryLayout title="Explore">
        <div class="text-white">

            <div class="flex" v-for="post in posts.data" :key="post">
                <Post :post="post"/>
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
