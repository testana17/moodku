<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
   
        <Head title="Forgot Password" />

        <div class="flex items-center justify-center min-h-screen">
            <div class="w-full max-w-md bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4 text-center">Forgot Your Password?</h1>

                    <p class="text-gray-700 mb-6 text-center">
                        Enter your email address below and we'll send you a link to reset your password.
                    </p>

                    <div v-if="status" class="mb-4 text-center text-green-600">
                        {{ status }}
                    </div>

                    <form @submit.prevent="submit">
                        <div class="mb-6">
                            <InputLabel for="email" value="Email Address" />
                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full border border-gray-300 rounded-lg p-3 transition-colors duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                v-model="form.email"
                                required
                                autofocus
                                autocomplete="username"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="flex items-center justify-center mt-6">
                            <PrimaryButton class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors duration-200" :class="{ 'opacity-50': form.processing }" :disabled="form.processing">
                                Send Password Reset Link
                            </PrimaryButton>
                        </div>
                    </form>

                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600">Remembered your password?</p>
                        <Link
                            :href="route('login')"
                            class="text-blue-500 hover:text-blue-600 text-sm font-semibold"
                        >
                            Back to Login
                        </Link>
                    </div>
                </div>
            </div>
        </div>
   
</template>

<style scoped>
/* Custom styling for the forgot password form */
input:focus {
    border-color: #4a90e2;
    box-shadow: 0 0 0 1px #4a90e2;
}

button:disabled {
    background-color: #d1d5db;
    cursor: not-allowed;
}

button {
    transition: background-color 0.2s ease;
}
</style>
