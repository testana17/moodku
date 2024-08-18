<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        
                        <transition name="slide-fade" @after-enter="clearAlert">
                            <div v-if="showAlert" class="fixed top-5 right-5 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-lg z-50">
                                <div class="flex items-center">
                                    <FontAwesomeIcon icon="fas fa-smile" class="h-6 w-6 text-yellow-500 mr-3" />
                                    <p class="text-sm font-medium">Mood successfully added!</p>
                                </div>
                            </div>
                        </transition>
                        <!-- Form Section Below Profile -->
                        <div class="flex flex-col items-center justify-center">
                            <!-- Button to Open Calendar Modal -->
                            <Link
                                href="/mood-calendar"
                                class="mb-6 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                View Mood Calendar
                            </Link>

                            <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-lg">
                                <h1 class="text-2xl font-bold mb-6 text-center">Track Your Mood</h1>
                                <form @submit.prevent="submitForm" class="space-y-4">
                                    <div>
                                        <label for="mood" class="block text-sm font-medium text-gray-700">Mood</label>
                                        <select v-model="form.mood" id="mood" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="" disabled>Select your mood</option>
                                            <option v-for="option in moodOptions" :key="option" :value="option">{{ option }}</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="note" class="block text-sm font-medium text-gray-700">Note</label>
                                        <textarea v-model="form.note" id="note" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                    </div>

                                    <div>
                                        <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                                        <input type="date" v-model="form.date" id="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Save Mood
                                        </button>
                                    </div>
                                </form>

                                <div v-if="moods.length" class="mt-8">
                                    <h2 class="text-xl font-semibold mb-4 text-center">Your Moods</h2>
                                    <ul class="space-y-3">
                                        <li v-for="mood in moods" :key="mood.id" class="p-4 bg-gray-100 rounded-md shadow-sm flex justify-between items-center">
                                            <span :class="getMoodClass(mood.mood)" class="font-medium capitalize">{{ mood.mood }}</span>
                                            <span class="text-gray-600 text-sm">{{ mood.date }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm, usePage, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const { props } = usePage()
const user = props.auth.user; // Get authenticated user data
const moodOptions = ['happy', 'sad', 'angry', 'calm', 'anxious', 'excited', 'tired', 'neutral']

const form = useForm({
    mood: '',
    note: '',
    date: ''
})

const { data: moods } = useForm({ moods: props.moods })

const showAlert = ref(false)

const submitForm = () => {
    form.post('/mood', {
        onSuccess: () => {
            form.reset() // Resets form fields after successful submission
            showAlert.value = true; // Tampilkan notifikasi
            setTimeout(() => {
                showAlert.value = false;
            }, 3000)
                    }
                })
            }

const getMoodClass = (mood) => {
    const moodColors = {
        happy: 'text-yellow-500',
        sad: 'text-blue-700',
        angry: 'text-red-500',
        calm: 'text-purple-500',
        anxious: 'text-orange-500',
        excited: 'text-pink-500',
        tired: 'text-gray-500',
        neutral: 'text-green-500',
    }
    return moodColors[mood] || 'text-gray-500'
}
</script>

<style scoped>
/* Animation for the alert */
.slide-fade-enter-active {
    transition: all 0.3s ease;
    transform: translateY(-20px);
    opacity: 0;
}

.slide-fade-enter-to {
    transform: translateY(0);
    opacity: 1;
}

.slide-fade-leave-active {
    transition: all 0.3s ease;
    transform: translateY(20px);
    opacity: 0;
}

.slide-fade-leave-to {
    transform: translateY(0);
    opacity: 1;
}
</style>
