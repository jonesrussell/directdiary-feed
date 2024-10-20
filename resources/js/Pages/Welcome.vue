<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const features = ref([
  { icon: '💼', title: 'Direct Deals', description: 'Connect and transact without commissions' },
  { icon: '🚀', title: 'Skill Growth', description: 'Learn and enhance your entrepreneurial skills' },
  { icon: '🌐', title: 'Networking', description: 'Build valuable connections in the business world' },
  { icon: '📈', title: 'Daily Content', description: 'Stay updated with relevant business insights' },
]);
</script>

<template>
    <Head title="Welcome to Direct Diary" />

    <div class="min-h-screen bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center">
                <h1 class="text-5xl font-extrabold mb-4">Welcome to Direct Diary</h1>
                <p class="text-xl mb-8">Your Entrepreneurial Hub for Growth and Networking</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 mb-12">
                <div v-for="feature in features" :key="feature.title" class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <div class="text-4xl mb-4">{{ feature.icon }}</div>
                    <h3 class="text-xl font-bold mb-2">{{ feature.title }}</h3>
                    <p>{{ feature.description }}</p>
                </div>
            </div>

            <div class="text-center mb-12">
                <p class="text-lg mb-4">
                    Join a community of driven entrepreneurs, access powerful tools, and unlock your business potential.
                </p>
                <p class="text-lg mb-8">
                    Direct Diary: Where deals happen, skills grow, and networks flourish.
                </p>
                <div class="space-x-4">
                    <Link
                        :href="route('register')"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full transition duration-300"
                    >
                        Get Started
                    </Link>
                    <Link
                        :href="route('login')"
                        class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-full transition duration-300"
                    >
                        Log In
                    </Link>
                </div>
            </div>

            <div class="text-center text-gray-400">
                <p>Join thousands of entrepreneurs already growing their businesses on Direct Diary</p>
            </div>
        </div>
    </div>
</template>
