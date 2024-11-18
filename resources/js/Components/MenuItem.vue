<template>
    <div class="w-full lg:inline-block hover:bg-gray-900 p-2 px-4 lg:pr-6 rounded-full cursor-pointer transition duration-200 ease-in-out">
        <div class="flex items-center">
            <!-- Material Design Icons -->
            <component 
                v-if="materialIcon" 
                :is="materialIcon" 
                fillColor="#FFFFFF" 
                :size="30" 
            />
            <span class="lg:block hidden text-white font-extrabold text-[23px] pl-4 mt-0.5">
                {{ iconString }}
            </span>
        </div>
    </div>
</template>

<script setup>
import { toRefs, computed } from 'vue'
import Home from 'vue-material-design-icons/Home.vue';
import Compass from 'vue-material-design-icons/Compass.vue';
import MessageText from 'vue-material-design-icons/MessageText.vue';
import AccountOutline from 'vue-material-design-icons/AccountOutline.vue';
import Domain from 'vue-material-design-icons/Domain.vue';
import Web from 'vue-material-design-icons/Web.vue';

const props = defineProps({
    iconString: String,
})

const { iconString } = toRefs(props)

const materialIcon = computed(() => {
    switch (iconString.value) {
        case 'Home': return Home
        case 'Explore': return Compass
        case 'Messages': return MessageText
        case 'Profile': return AccountOutline
        case 'Domains': return Domain
        case 'Landing Pages': return Web
        default: return null
    }
})
</script>
