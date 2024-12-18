<script setup>
import { ref, computed, watch } from 'vue';
import { router, usePage, Link } from '@inertiajs/vue3';
import MenuItem from '@/Components/MenuItem.vue';
import ArrowLeft from 'vue-material-design-icons/ArrowLeft.vue';
import Close from 'vue-material-design-icons/Close.vue';
import Earth from 'vue-material-design-icons/Earth.vue';
import Feather from 'vue-material-design-icons/Feather.vue';
import Home from 'vue-material-design-icons/Home.vue';
import Compass from 'vue-material-design-icons/Compass.vue';
import MessageText from 'vue-material-design-icons/MessageText.vue';
import AccountOutline from 'vue-material-design-icons/AccountOutline.vue';
import Domain from 'vue-material-design-icons/Domain.vue';
import Web from 'vue-material-design-icons/Web.vue';

const props = defineProps({
    title: String,
    showForYouFollowing: Boolean,
    showProfileTabs: Boolean,
    thirdSectionComponent: Object,
    conversationId: Number | null,
});

const page = usePage();
const user = computed(() => page.props.auth.user);

let title = props.title;
let showForYouFollowing = props.showForYouFollowing;

let createPost = ref(false)
let post = ref('')
let file = ref('')
let showUpload = ref('')
let uploadType = ref('')
let randImg1 = ref(`https://picsum.photos/id/${(Math.random() * 200).toFixed(0)}/100`)
let randImg2 = ref(`https://picsum.photos/id/${(Math.random() * 200).toFixed(0)}/100`)

const getFile = (e) => {
    file.value = e.target.files[0]
    showUpload.value = URL.createObjectURL(e.target.files[0]);
    uploadType.value = file.value.name.split('.').pop();
}

const closeMessageBox = () => {
    createPost.value = false
    post.value = ''
    showUpload.value = ''
    uploadType.value = ''
}

const addPost = () => {
    if (!post.value) return

    let data = new FormData()

    data.append('post', post.value)
    data.append('file', file.value)

    router.post('/posts', data)

    createPost.value = false
    post.value = ''
    showUpload.value = ''
    uploadType.value = ''
}

const textarea = ref(null);

const textareaInput = (e) => {
    textarea.value.style.height = "auto";
    textarea.value.style.height = `${e.target.scrollHeight}px`;
};

const debugMode = true;

watch(() => user.value, (newValue) => {
    if (debugMode) {
        console.log('User state changed:', newValue);
    }
}, { immediate: true });

const visibleMenuItems = computed(() => {
    const items = menuItems.filter(item => 
        user.value || ['Explore', 'Domains', 'Landing Pages'].includes(item.name)
    );
    
    if (debugMode) {
        console.log('Visible menu items:', items);
    }
    
    return items;
});

const menuItems = [
    { id: 1, name: 'Home', icon: Home, route: '/' },
    { id: 2, name: 'Explore', icon: Compass, route: '/explore' },
    { id: 3, name: 'Messages', icon: MessageText, route: '/messages' },
    { id: 4, name: 'Profile', icon: AccountOutline, route: '/profile' },
    { id: 5, name: 'Domains', icon: Domain, route: '/domains' },
    { id: 6, name: 'Landing Pages', icon: Web, route: '/landing-pages' },
];
</script>

<template>
    <div class="fixed w-full">
        <div class="max-w-[1400px] flex mx-auto">
            <section class="lg:w-3/12 w-[60px] h-[100vh] max-w-[350px] lg:px-4 lg:mx-auto">
                <div class="p-2 mb-4">
                    <img class="rounded-full mt-3 w-full" width="50" src="/img/leo-logo.png" />
                </div>

                <Link 
                    v-for="menuItem in visibleMenuItems" 
                    :key="menuItem.id" 
                    :href="menuItem.route"
                >
                    <MenuItem 
                        :iconString="menuItem.name" 
                        :icon="menuItem.icon" 
                        @click="debugMode && console.log('Clicked:', menuItem.name)"
                    />
                </Link>

                <button v-if="user" @click="createPost = true"
                    class="lg:w-full mt-8 ml-2 text-white font-extrabold text-[22px] bg-[#1C9CEF] p-3 px-3 rounded-full cursor-pointer">
                    <span class="lg:block hidden">Post</span>
                    <span class="block lg:hidden">
                        <Feather />
                    </span>
                </button>
            </section>

            <section class="lg:w-9/12 w-11/12 border-x border-gray-800 relative">
                <div class="bg-[#051239] bg-opacity-50 backdrop-blur-md z-10 absolute w-full">
                    <div class="border-gray-800 border-b w-full">
                        <div class="w-full text-white text-[22px] font-extrabold p-4">
                            {{ title }}
                        </div>

                        <div class="flex" v-if="showForYouFollowing">
                            <div
                                class="flex items-center justify-center w-full h-[60px] text-white text-[17px] font-extrabold p-4 hover:bg-gray-500 hover:bg-opacity-30 cursor-pointer transition duration-200 ease-in-out">
                                <div class="inline-block text-center border-b-4 border-b-[#1C9CEF] h-[60px]">
                                    <div class="my-auto mt-4">For you</div>
                                </div>
                            </div>
                            <div
                                class="w-full h-[60px] text-gray-500 text-[17px] font-extrabold p-4 hover:bg-gray-500 hover:bg-opacity-30 cursor-pointer transition duration-200 ease-in-out">
                                <div class="text-center">Following</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="absolute top-0 z-0 h-full w-full overflow-auto scrollbar-hide">
                    <div class="mt-[80px]" v-if="!showForYouFollowing"></div>
                    <div class="mt-[126px]" v-if="showForYouFollowing"></div>
                    <slot />
                    <div class="pb-4"></div>
                </div>
            </section>
        </div>
        <footer v-if="!user"
            class="absolute text-white bottom-0 w-full bg-red-400 h-20 flex space-x-4 justify-center items-center">
            <Link href="/login"
                class="px-4 py-2 border text-white hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Log in
            </Link>
            <Link href="/register"
                class="px-4 py-2 border text-gray-800 bg-white hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Sign up
            </Link>
        </footer>
    </div>

    <div id="OverlaySection" v-if="createPost"
        class="fixed top-0 left-0 w-full h-screen bg-[#051239] md:bg-gray-400 md:bg-opacity-30 md:p-3">
        <div class="md:max-w-2xl md:mx-auto md:mt-10 md:rounded-xl bg-[#051239]">

            <div class=" flex items-center justify-between md:inline-block p-2 m-2 rounded-full cursor-pointer">
                <div @click="closeMessageBox()" class="hover:bg-gray-800 inline-block p-2 rounded-full cursor-pointer">
                    <Close fillColor="#FFFFFF" :size="28" class="md:block hidden" />
                    <ArrowLeft fillColor="#FFFFFF" :size="28" class="md:hidden block" />
                </div>

                <button :class="post ? 'bg-[#1C9CEF] text-white' : 'bg-[#124D77] text-gray-400'" :disabled="!post"
                    @click="addPost()" class="md:hidden font-extrabold text-[16px] p-1.5 px-4 rounded-full cursor-pointer">
                    Post
                </button>
            </div>
            <div class="w-full flex">
                <div class="ml-3.5 mr-2">
                    <img class="rounded-full" width="55" :src="randImg1" />
                </div>
                <div class="w-[calc(100%-100px)]">
                    <div>
                        <textarea ref="textarea" :oninput="textareaInput" v-model="post" placeholder="What's happening?"
                            cols="30" rows="4" class="
                                w-full
                                bg-[#051239]
                                border-0
                                mt-2
                                focus:ring-0
                                text-white
                                text-[19px]
                                font-extrabold
                                min-h-[120px]
                            "></textarea>
                    </div>
                    <div class="w-full">
                        <video controls v-if="uploadType === 'mp4'" :src="showUpload" class="rounded-xl overflow-auto" />
                        <img v-else :src="showUpload" class="rounded-xl min-w-full">
                    </div>
                    <div class="flex py-2 items-center text-[#1C9CEF] font-extrabold">
                        <Earth class="pr-2" fillColor="#1C9CEF" :size="20" /> Everyone can reply
                    </div>
                    <div class="border-b border-b-gray-700"></div>
                    <div class="flex items-center justify-between py-2">
                        <button :class="post ? 'bg-[#1C9CEF] text-white' : 'bg-[#124D77] text-gray-400'" :disabled="!post"
                            @click="addPost()"
                            class=" hidden md:block font-extrabold text-[16px] p-1.5 px-4 rounded-full cursor-pointer">
                            Post
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div v-if="debugMode" class="fixed bottom-0 right-0 bg-black bg-opacity-75 text-white p-4 m-4 rounded-lg z-50">
        <div>User authenticated: {{ !!user }}</div>
        <div>Visible menu items: {{ visibleMenuItems.length }}</div>
    </div>
</template>
