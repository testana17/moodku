<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>

        <Head title="Log In" />

        <div class="flex items-center justify-center min-h-screen">
            <div class="w-full max-w-md bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-8">
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-6 text-center">Login to Your Account</h1>

                    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                        {{ status }}
                    </div>

                    <form @submit.prevent="submit">
                        <div class="mb-6">
                            <InputLabel for="email" value="Email Address" />
                            <TextInput
                                id="email"
                                type="email"
                                    class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
                                v-model="form.email"
                                required
                                autofocus
                                autocomplete="username"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="mb-6">
                            <InputLabel for="password" value="Password" />
                            <TextInput
                                id="password"
                                type="password"
                                     class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                            />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="flex items-center mb-6">
                            <Checkbox name="remember" v-model:checked="form.remember" />
                            <span class="ms-2 text-sm text-gray-600">Remember me</span>
                        </div>

                        <div class="flex items-center justify-between mb-6">
                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="text-sm text-blue-500 hover:text-blue-600"
                            >
                                Forgot your password?
                            </Link>

                            <PrimaryButton class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors duration-200" :class="{ 'opacity-50': form.processing }" :disabled="form.processing">
                                Log In
                            </PrimaryButton>
                        </div>
                    </form>

                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600">Don't have an account?</p>
                        <Link
                            :href="route('register')"
                            class="text-blue-500 hover:text-blue-600 text-sm font-semibold"
                        >
                            Register here
                        </Link>
                    </div>
                </div>
            </div>
        </div>
 
</template>

<style scoped>
/* Custom styling for the login form */
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
