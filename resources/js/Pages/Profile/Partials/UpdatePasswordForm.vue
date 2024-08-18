<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section class="bg-white p-6 rounded-lg shadow-md max-w-md mx-auto">
        <header>
            <h2 class="text-xl font-semibold text-gray-800">Update Password</h2>
            <p class="mt-2 text-sm text-gray-600">
                Ensure your account is using a strong password to stay secure.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
            <div>
                <InputLabel for="current_password" value="Current Password" class="text-gray-700" />
                <TextInput
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    class="mt-1 block w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    placeholder="Enter your current password"
                    autocomplete="current-password"
                />
                <InputError :message="form.errors.current_password" class="mt-2 text-red-600" />
            </div>

            <div>
                <InputLabel for="password" value="New Password" class="text-gray-700" />
                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    placeholder="Enter a new password"
                    autocomplete="new-password"
                />
                <InputError :message="form.errors.password" class="mt-2 text-red-600" />
            </div>

            <div>
                <InputLabel for="password_confirmation" value="Confirm New Password" class="text-gray-700" />
                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    placeholder="Confirm your new password"
                    autocomplete="new-password"
                />
                <InputError :message="form.errors.password_confirmation" class="mt-2 text-red-600" />
            </div>

            <div class="flex items-center justify-between mt-6">
                <PrimaryButton :disabled="form.processing" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                    Save
                </PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out duration-150"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out duration-150"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Changes saved successfully!</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
