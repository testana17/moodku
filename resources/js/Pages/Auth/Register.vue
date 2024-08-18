<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>

        <Head title="Register" />

        <div class="flex items-center justify-center min-h-screen">
            <div class="max-w-md w-full bg-white shadow-lg rounded-lg p-8">
                <h1 class="text-3xl font-bold mb-6 text-center text-gray-900">Create an Account</h1>

                <form @submit.prevent="submit">
                    <div class="mb-4">
                        <InputLabel for="name" value="Name" />
                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="name"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="email" value="Email" />
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
                            v-model="form.email"
                            required
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="password" value="Password" />
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
                            v-model="form.password"
                            required
                            autocomplete="new-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="password_confirmation" value="Confirm Password" />
                        <TextInput
                            id="password_confirmation"
                            type="password"
                            class="mt-1 block w-full border border-gray-300 rounded-lg p-2"
                            v-model="form.password_confirmation"
                            required
                            autocomplete="new-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <Link
                            :href="route('login')"
                            class="text-sm text-blue-600 hover:text-blue-700"
                        >
                            Already registered? Log in
                        </Link>

                        <PrimaryButton class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Register
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>

</template>

<style scoped>
/* Custom styles for the registration form */
input:focus {
    border-color: #3b82f6; /* Blue border on focus */
    box-shadow: 0 0 0 1px #3b82f6;
}

button:disabled {
    background-color: #9ca3af; /* Gray background for disabled button */
    cursor: not-allowed;
}
</style>
