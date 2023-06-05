<script setup>
    import { ref } from 'vue';
    import { Head, Link } from '@inertiajs/vue3';
    import Food from '@/Components/Food.vue'
    import TwitterLayout from '@/Layouts/TwitterLayout.vue';

    defineProps({ tweets: Array })

</script>

<template>

    <Head title="Twitter" />

    <TwitterLayout>
        <div class="text-white">

            <div class="flex" v-for="tweet in tweets" :key="tweet">
                <Food :tweet="tweet"/>
            </div>
            <div class="border-b border-b-gray-800 mt-2"></div>
        </div>

    </TwitterLayout>
</template>

<style>
body {
    background-color: black;
}
</style>
