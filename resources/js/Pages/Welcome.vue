<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const features = ref([
  { icon: '💼', title: 'Direct Deals', description: 'Connect and transact without commissions' },
  { icon: '🚀', title: 'Skill Growth', description: 'Learn and enhance your entrepreneurial skills' },
  { icon: '🌐', title: 'Networking', description: 'Build valuable connections in the business world' },
  { icon: '📈', title: 'Daily Content', description: 'Stay updated with relevant business insights' },
]);

const successStories = ref([
  {
    name: "Jane Doe",
    avatar: "/images/jane-doe.jpg",
    testimonial: "Direct Diary helped me connect with the perfect business partner.",
    achievement: "Closed a $1M deal"
  },
  {
    name: "John Smith",
    avatar: "/images/john-smith.jpg",
    testimonial: "The daily content keeps me motivated and informed.",
    achievement: "Grew network by 500%"
  },
  {
    name: "Alice Johnson",
    avatar: "/images/alice-johnson.jpg",
    testimonial: "I've learned more here than in my MBA program!",
    achievement: "Launched successful startup"
  }
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

            <div class="bg-gray-800 py-16 mb-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="lg:flex lg:items-center lg:justify-between">
                        <div class="lg:w-1/2">
                            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                                Empowering Entrepreneurs
                            </h2>
                            <p class="mt-3 max-w-md mx-auto text-lg text-gray-300 sm:text-xl md:mt-5 md:max-w-3xl">
                                Direct Diary is the ultimate platform for entrepreneurs to connect, learn, and grow their businesses.
                            </p>
                        </div>
                        <div class="mt-10 lg:mt-0 lg:w-1/2">
                            <img class="rounded-lg shadow-xl" src="/images/hero-image.jpg" alt="Entrepreneurs networking">
                        </div>
                    </div>
                </div>
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

            <!-- User Showcase -->
            <div class="bg-gray-900 py-16 mb-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-extrabold text-white mb-8">Success Stories</h2>
                    <div class="grid md:grid-cols-3 gap-8">
                        <div v-for="story in successStories" :key="story.name" class="bg-gray-800 p-6 rounded-lg shadow-lg">
                            <img :src="story.avatar" :alt="story.name" class="w-20 h-20 rounded-full mx-auto mb-4">
                            <h3 class="text-xl font-bold mb-2">{{ story.name }}</h3>
                            <p class="text-gray-300 mb-4">{{ story.testimonial }}</p>
                            <p class="text-blue-400">{{ story.achievement }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
