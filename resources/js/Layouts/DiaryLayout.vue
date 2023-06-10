<script setup>
import { ref } from 'vue';
import { router, usePage, Link } from '@inertiajs/vue3';
import Magnify from 'vue-material-design-icons/Magnify.vue';
import DotsHorizontal from 'vue-material-design-icons/DotsHorizontal.vue';
import Feather from 'vue-material-design-icons/Feather.vue';
import Close from 'vue-material-design-icons/Close.vue';
import Earth from 'vue-material-design-icons/Earth.vue';
import ArrowLeft from 'vue-material-design-icons/ArrowLeft.vue';
import MenuItem from '@/Components/MenuItem.vue'

const props = defineProps({
    title: String,
    showForYouFollowing: Boolean,
    showProfileTabs: Boolean,
});

const page = usePage();
let authUser = page.props.auth.user;

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

</script>

<template>
    <div class="fixed w-full">
        <div class="max-w-[1400px] flex mx-auto">
            <section class="lg:w-3/12 w-[60px] h-[100vh] max-w-[350px] lg:px-4 lg:mx-auto">
                <div class="p-2 mb-4">
                    <img class="rounded-full mt-3 w-full" width="50" src="/img/leo-logo.png" />
                </div>

                <Link href="/" v-if="authUser">
                <MenuItem iconString="Home" />
                </Link>
                <Link href="/explore">
                <MenuItem iconString="Explore" />
                </Link>

                <MenuItem iconString="Notifications" v-if="authUser" />
                <Link href="/messages">
                <MenuItem iconString="Messages" v-if="authUser" />
                </Link>

                <Link href="/profile">
                <MenuItem iconString="Profile" v-if="authUser" />
                </Link>

                <button v-if="authUser" @click="createPost = true"
                    class="lg:w-full mt-8 ml-2 text-white font-extrabold text-[22px] bg-[#1C9CEF] p-3 px-3 rounded-full cursor-pointer">
                    <span class="lg:block hidden">Post</span>
                    <span class="block lg:hidden">
                        <Feather />
                    </span>
                </button>
            </section>

            <section class="lg:w-7/12 w-11/12 border-x border-gray-800 relative">
                <div class="bg-black bg-opacity-50 backdrop-blur-md z-10 absolute w-full">
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

            <section class="lg:block hidden lg:w-4/12 h-screen border-l border-gray-800 pl-4">
                <div class="w-full p-1 mt-2 px-4 lg:flex items-center rounded-full hidden bg-[#212327]">
                    <Magnify fillColor="#5e5c5c" :size="25" />
                    <input class="
                            appearance-none
                            w-full
                            border-0
                            py-2
                            bg-[#212327]
                            text-gray-100
                            placeholder-gray-500
                            leading-tight
                            focus:ring-0
                        " type="text" placeholder="Search Diary">
                </div>

                <div class="w-full mt-4 rounded-lg lg:block hidden bg-[#212327]">
                    <div class="w-full p-4 text-white font-extrabold mb-6 text-[20px]">What's happening</div>

                    <div class="h-[80px] hover:bg-gray-800 cursor-pointer transition duration-200 ease-in-out">
                        <div class="flex p-3 justify-between h-[80px] py-3">
                            <div>
                                <div class="text-[14px] text-gray-400">Tennis Tournament LIVE</div>
                                <div class="w-full text-white font-extrabold mb-6 text-[17px]">Australian Open 2023</div>
                            </div>
                            <img class="rounded-xl" :src="randImg2" alt="" />
                        </div>
                    </div>

                    <div class="hover:bg-gray-800 cursor-pointer transition duration-200 ease-in-out">
                        <div class="flex p-3 justify-between">
                            <div>
                                <div class="text-[14px] text-gray-400">Trending in United Kingdom</div>
                                <div class="w-full text-white font-extrabold text-[17px]">Doomsday Clock</div>
                                <div class="text-[14px] text-gray-400">5,923 Posts</div>
                            </div>
                            <DotsHorizontal fillColor="#5e5c5c" />
                        </div>
                    </div>

                    <div class="hover:bg-gray-800 cursor-pointer transition duration-200 ease-in-out">
                        <div class="flex p-3 justify-between">
                            <div>
                                <div class="text-[14px] text-gray-400">Sports · Trending</div>
                                <div class="w-full text-white font-extrabold text-[17px]">Poro</div>
                                <div class="text-[14px] text-gray-400">12,432 Posts</div>
                            </div>
                            <DotsHorizontal fillColor="#5e5c5c" />
                        </div>
                    </div>

                    <div class="hover:bg-gray-800 cursor-pointer transition duration-200 ease-in-out">
                        <div class="flex p-3 justify-between">
                            <div>
                                <div class="text-[14px] text-gray-400">Politics · Trending</div>
                                <div class="w-full text-white font-extrabold text-[17px]">Sunak</div>
                                <div class="text-[14px] text-gray-400">98,745 Posts</div>
                            </div>
                            <DotsHorizontal fillColor="#5e5c5c" />
                        </div>
                    </div>

                    <div class="hover:bg-gray-800 rounded-b-xl cursor-pointer transition duration-200 ease-in-out">
                        <div class="text-blue-500 p-4">Show more</div>
                    </div>
                </div>
            </section>
        </div>
        <footer v-if="!authUser"
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
        class="fixed top-0 left-0 w-full h-screen bg-black md:bg-gray-400 md:bg-opacity-30 md:p-3">
        <div class="md:max-w-2xl md:mx-auto md:mt-10 md:rounded-xl bg-black">

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
                                bg-black
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
</template>
