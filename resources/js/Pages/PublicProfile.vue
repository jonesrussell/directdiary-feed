<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import DiaryLayout from '@/Layouts/DiaryLayout.vue';
import Post from '@/Components/Post.vue';
import EmailOutline from 'vue-material-design-icons/EmailOutline.vue';
import Facebook from 'vue-material-design-icons/Facebook.vue';
import Twitter from 'vue-material-design-icons/Twitter.vue';
import Instagram from 'vue-material-design-icons/Instagram.vue';
import Linkedin from 'vue-material-design-icons/Linkedin.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ profile: Object, view: String });

const page = usePage();
const user = computed(() => page.props.auth.user);

const profileLoaded = computed(() => !!props.profile);

const username = computed(() => props.profile?.username ?? '');
const fullname = computed(() => props.profile ? `${props.profile.firstname} ${props.profile.lastname}` : '');
const posts = computed(() => props.profile?.posts ?? []);
const domains = computed(() => props.profile?.domains ?? []);
const profileUrl = computed(() => `/${username.value}`);
const profileDomainsUrl = computed(() => `/${username.value}/domains`);

// New computed properties for biography fields
const biography = computed(() => props.profile?.biography ?? '');
const facebookLink = computed(() => props.profile?.facebook_link ?? '');
const twitterLink = computed(() => props.profile?.twitter_link ?? '');
const instagramLink = computed(() => props.profile?.instagram_link ?? '');
const linkedinLink = computed(() => props.profile?.linkedin_link ?? '');

// Define the form data
const messageForm = useForm({
    participants: [
        { id: user.value?.id, type: '\\App\\Models\\User' },
        { id: props.profile?.id ?? null, type: '\\App\\Models\\User' },
    ].filter(participant => participant.id !== null),
});

// Define the click handler
const iconClickHandler = () => {
    console.log('clicked message icon');
    if (user.value?.id && props.profile?.id) {
        messageForm.post('/messages');
    } else {
        console.log('Cannot send message: User not authenticated or profile not loaded');
        // You might want to show an error message to the user here
    }
};
</script>

<template>
    <Head :title="fullname" />

    <DiaryLayout :title="fullname" showProfileTabs>
        <div v-if="profileLoaded" class="text-white">
            <div class="flex flex-col items-start p-3 bg-[#051239]">
                <div class="flex justify-between w-full">
                    <img :src="profile?.avatar" class="rounded-full mb-4 w-24 h-24" />
                    <div class="border rounded-full w-9 h-9 p-1 hover:cursor-pointer" @click="iconClickHandler">
                        <component :is="EmailOutline" fillColor="#FFFFFF" :size="25" />
                    </div>
                </div>
                <div class="text-2xl font-bold">{{ fullname }}</div>
                <div class="text-gray-400">@{{ username }}</div>
                
                <!-- Biography -->
                <div v-if="biography" class="mt-4">{{ biography }}</div>
                
                <!-- Social Links -->
                <div class="flex mt-2 gap-4">
                    <a v-if="facebookLink" :href="facebookLink" target="_blank" rel="noopener noreferrer" class="text-white hover:text-blue-400">
                        <Facebook :size="24" />
                    </a>
                    <a v-if="twitterLink" :href="twitterLink" target="_blank" rel="noopener noreferrer" class="text-white hover:text-blue-400">
                        <Twitter :size="24" />
                    </a>
                    <a v-if="instagramLink" :href="instagramLink" target="_blank" rel="noopener noreferrer" class="text-white hover:text-blue-400">
                        <Instagram :size="24" />
                    </a>
                    <a v-if="linkedinLink" :href="linkedinLink" target="_blank" rel="noopener noreferrer" class="text-white hover:text-blue-400">
                        <Linkedin :size="24" />
                    </a>
                </div>
            </div>

            <div class="flex">
                <div class="flex items-center justify-center w-full h-[60px] text-white text-[17px] font-extrabold p-4 hover:bg-gray-500 hover:bg-opacity-30 cursor-pointer transition duration-200 ease-in-out">
                    <div class="inline-block text-center border-b-4 border-b-[#1C9CEF] h-[60px]">
                        <Link :href="profileUrl">
                            <div class="my-auto mt-4">Posts</div>
                        </Link>
                    </div>
                </div>
                <div class="w-full h-[60px] text-gray-500 text-[17px] font-extrabold p-4 hover:bg-gray-500 hover:bg-opacity-30 cursor-pointer transition duration-200 ease-in-out">
                    <Link :href="profileDomainsUrl">
                        <div class="text-center">Domains</div>
                    </Link>
                </div>
            </div>

            <template v-if="view === 'posts'">
                <div class="flex" v-for="post in posts" :key="post.id">
                    <Post :post="post" />
                </div>
            </template>

            <template v-else-if="view === 'domains'">
                <div class="flex flex-col" v-for="domain in domains" :key="domain.name">
                    <div class="text-white">
                        <div class="m-4">
                            <a :href="domain.url" target="_blank">{{ domain.name }}.{{ domain.extension }}</a>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        <div v-else class="p-4 text-white">
            <p>Profile not found or still loading...</p>
        </div>
    </DiaryLayout>
</template>
