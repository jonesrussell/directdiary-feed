<script setup>
    import { ref } from 'vue';
    import { Head, Link } from '@inertiajs/vue3';
    import DiaryLayout from '@/Layouts/DiaryLayout.vue';

const props = defineProps({ profile: Array });

console.log(props.profile);
let username = props.profile.username;
let fullname = `${props.profile.firstname} ${props.profile.lastname}`
</script>

<template>

    <Head :title="fullname" />

    <DiaryLayout :title="username">
        <div class="text-white">
            {{ fullname }} @{{ username }}
            <div class="border-b border-b-gray-800 mt-2"></div>
        </div>

    </DiaryLayout>
</template>

<style>
body {
    background-color: black;
}
</style>
