<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.reset();
};
</script>

<template>
    <section class="space-y-6 bg-gray-50 p-6 rounded-lg shadow-lg">
        <header>
            <h2 class="text-xl font-semibold text-red-600">Delete Account</h2>
            <p class="mt-2 text-sm text-gray-700">
                Once your account is deleted, all of its resources and data will be permanently deleted. Please ensure you've saved any important information before proceeding.
            </p>
        </header>

        <DangerButton @click="confirmUserDeletion" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
            Delete Account
        </DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal" class="rounded-lg shadow-lg">
            <div class="p-6 bg-white rounded-lg">
                <h2 class="text-lg font-semibold text-gray-900">Confirm Deletion</h2>
                <p class="mt-1 text-sm text-gray-700">
                    Please enter your password to confirm the deletion of your account.
                </p>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" class="sr-only" />
                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500"
                        placeholder="Enter your password"
                        @keyup.enter="deleteUser"
                    />
                    <InputError :message="form.errors.password" class="mt-2 text-red-600" />
                </div>

                <div class="mt-6 flex justify-end space-x-2">
                    <SecondaryButton @click="closeModal" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded">
                        Cancel
                    </SecondaryButton>

                    <DangerButton
                        class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded"
                        :class="{ 'opacity-50': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Delete Account
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
