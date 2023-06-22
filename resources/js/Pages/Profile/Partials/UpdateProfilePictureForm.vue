<script setup>
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, usePage } from '@inertiajs/vue3';

const user = usePage().props.auth.user;

const form = useForm({
    avatar: null,
});

let publicAvatar = user.avatar;

const renderAvatar = (e) => publicAvatar = URL.createObjectURL(e.target.files[0]);
</script>

<template>
    <section>
        <form @submit.prevent="form.post(route('profile.picture.store'))" class="mt-6 space-y-6">
            <div>
                <div>
                    <img :src="publicAvatar" class="border border-black-500 rounded-full w-24 h-24 mb-4" />
                    <input type="file" @input="form.avatar = $event.target.files[0]; renderAvatar($event);" />
                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                        {{ form.progress.percentage }}%
                    </progress>
                    <img v-if="url" :src="url" class="w-full mt-4 h-80" />
                    <div v-if="form.errors.image" class="font-bold text-red-600">
                        {{ form.errors.image }}
                    </div>
                </div>

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
