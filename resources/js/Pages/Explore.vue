<script setup>
import { Head } from '@inertiajs/vue3';
import Post from '@/Components/Post.vue'
import DiaryLayout from '@/Layouts/DiaryLayout.vue';

const props = defineProps({
  posts: {
    type: Object,
    required: true
  }
});
</script>

<template>
    <Head title="Explore" />

    <DiaryLayout title="Explore">
        <div class="text-white">
            <div v-if="posts.data && posts.data.length > 0">
                <div class="flex" v-for="post in posts.data" :key="post.id">
                    <Post :post="post" />
                </div>
            </div>
            <div v-else>
                No posts available.
            </div>
            <div class="border-b border-b-gray-800 mt-2"></div>
        </div>
    </DiaryLayout>
</template>
