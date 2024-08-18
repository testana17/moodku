<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex flex-col items-center justify-start min-h-screen px-4 sm:px-6 lg:px-8">
                            <Link
                                href="/mood"
                                class="mb-6 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <i class="fas fa-plus-circle mr-2"></i>
                                Add Mood
                            </Link>

                            <h1 class="text-2xl sm:text-3xl font-bold text-center mb-6 text-blue-500">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                Mood Calendar
                            </h1>

                            <!-- Selector for Month and Year -->
                            <div class="mb-6 flex flex-row justify-between items-center w-full flex-wrap">
                                <button @click="previousMonth" class="text-indigo-600 hover:text-indigo-800 p-2 rounded-full transition-colors mb-2 sm:mb-0">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <div class="text-lg font-semibold text-gray-700 mb-2 sm:mb-0 text-yellow-500">
                                    {{ monthYear }}
                                </div>
                                <button @click="nextMonth" class="text-indigo-600 hover:text-indigo-800 p-2 rounded-full transition-colors">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>

                            <div class="grid grid-cols-7 gap-1 sm:gap-2 w-full">
                                <!-- Header Hari dalam Seminggu -->
                                <div v-for="day in daysOfWeek" :key="day" class="text-center font-semibold text-gray-600 text-xs sm:text-sm">
                                    {{ day }}
                                </div>

                                <!-- Empty Days for Padding -->
                                <div v-for="n in firstDayOfMonth" :key="'empty-' + n" class="hidden sm:block"></div>

                                <!-- Hari dalam Bulan -->
                                <div
                                    v-for="(day, index) in daysInMonth"
                                    :key="index"
                                    class="relative text-center p-2 sm:p-4 border rounded-lg shadow-sm bg-white mood-day text-xs sm:text-base"
                                    :class="getMoodClass(day)"
                                    @mouseenter="showTooltip(day)"
                                    @mouseleave="hideTooltip"
                                >
                                    {{ day }}
                                    <!-- Icon for Mood -->
                                    <i :class="getMoodIcon(day)" class="text-lg"></i>

                                    <!-- Tooltip for Mood -->
                                    <transition name="fade">
                                        <div
                                            v-if="day === hoveredDay && getMoodForDay(day)"
                                            class="absolute bottom-0 left-0 right-0 bg-white text-xs sm:text-sm p-2 shadow-lg rounded-md"
                                            style="transform: translateY(100%);"
                                        >
                                            <i :class="getMoodIcon(day)" class="mr-1"></i>
                                            Mood: {{ getMoodForDay(day).mood }}
                                        </div>
                                    </transition>
                                </div>
                            </div>

                            <div class="mt-8 w-full max-w-lg p-6 bg-gradient-to-r from-blue-100 to-green-100 rounded-lg shadow-xl transition-transform transform hover:scale-105">
    <h2 class="text-2xl font-bold mb-4 text-center text-gray-800">
        <i class="fas fa-heartbeat mr-2 text-red-500"></i> Average Mood and Solutions
    </h2>
    <div class="text-center">
        <p class="text-xl font-semibold mb-2 text-gray-900">
            Average Mood: 
            <span :class="averageMoodClass" class="font-bold text-2xl">
                <i :class="getMoodIconForAverage" class="mr-1 text-xl"></i> {{ averageMood }}
            </span>
        </p>
        <p class="text-sm text-gray-700">
            <i class="fas fa-tachometer-alt mr-1 text-yellow-400"></i> Recommended actions: {{ recommendedActions }}
        </p>
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
import { usePage, Link } from '@inertiajs/vue3'
import dayjs from 'dayjs'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const { props } = usePage()
const moods = ref(props.moods)
const hoveredDay = ref(null)

// State for selected month and year
const selectedMonth = ref(dayjs().month())
const selectedYear = ref(dayjs().year())

const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']

// Calculate the number of days in the selected month
const daysInMonth = computed(() => {
    return Array.from({ length: dayjs().year(selectedYear.value).month(selectedMonth.value).daysInMonth() }, (_, i) => i + 1)
})

// Calculate the first day of the month (for grid offset)
const firstDayOfMonth = computed(() => {
    return dayjs().year(selectedYear.value).month(selectedMonth.value).date(1).day()
})

const getMoodForDay = (day) => {
    const date = dayjs().year(selectedYear.value).month(selectedMonth.value).date(day).format('YYYY-MM-DD')
    return moods.value.find(mood => mood.date === date)
}

const getMoodClass = (day) => {
    const mood = getMoodForDay(day)
    if (!mood) return ''
    return `mood-${mood.mood}`
}

const getMoodIcon = (day) => {
    const mood = getMoodForDay(day)?.mood;
    switch (mood) {
        case 'happy':
            return 'fas fa-smile text-yellow-500';
        case 'sad':
            return 'fas fa-frown text-gray-700';
        case 'angry':
            return 'fas fa-angry text-red-700';
        case 'calm':
            return 'fas fa-peace text-blue-400';
        case 'anxious':
            return 'fas fa-meh text-orange-600';
        case 'excited':
            return 'fas fa-grin-stars text-green-600';
        case 'tired':
            return 'fas fa-tired text-gray-600';
        case 'neutral':
            return 'fas fa-meh-blank text-gray-600';
        default:
            return '';
    }
};

const showTooltip = (day) => {
    hoveredDay.value = day
}

const hideTooltip = () => {
    hoveredDay.value = null
}

const monthYear = computed(() => {
    return dayjs().year(selectedYear.value).month(selectedMonth.value).format('MMMM YYYY')
})

const previousMonth = () => {
    selectedMonth.value -= 1
    if (selectedMonth.value < 0) {
        selectedMonth.value = 11
        selectedYear.value -= 1
    }
}

const nextMonth = () => {
    selectedMonth.value += 1
    if (selectedMonth.value > 11) {
        selectedMonth.value = 0
        selectedYear.value += 1
    }
}
const averageMood = computed(() => {
    const moodCounts = moods.value.reduce((counts, mood) => {
        counts[mood.mood] = (counts[mood.mood] || 0) + 1
        return counts
    }, {})

    const totalMoods = Object.values(moodCounts).reduce((total, count) => total + count, 0)
    if (totalMoods === 0) return 'No mood data available'

    const averageMood = Object.keys(moodCounts).reduce((highestMood, mood) => {
        if (!highestMood || moodCounts[mood] > moodCounts[highestMood]) {
            return mood
        }
        return highestMood
    }, null)

    return averageMood ? averageMood.charAt(0).toUpperCase() + averageMood.slice(1) : 'No mood data available'
})

const averageMoodClass = computed(() => {
    const mood = averageMood.value.toLowerCase()
    switch (mood) {
        case 'happy':
            return 'text-yellow-500'
        case 'sad':
            return 'text-gray-700'
        case 'angry':
            return 'text-red-700'
        case 'calm':
            return 'text-blue-400'
        case 'anxious':
            return 'text-orange-600'
        case 'excited':
            return 'text-green-600'
        case 'tired':
            return 'text-gray-600'
        case 'neutral':
            return 'text-gray-600'
        default:
            return 'text-gray-500'
    }
})

const recommendedActions = computed(() => {
    const actions = {
        happy: 'Keep up the good work!',
        sad: 'Consider talking to someone about your feelings.',
        angry: 'Try some relaxation techniques or exercise.',
        calm: 'Maintain your current routines.',
        anxious: 'Practice mindfulness or meditation.',
        excited: 'Channel your energy into productive activities.',
        tired: 'Ensure you are getting enough rest and sleep.',
        neutral: 'Nothing specific, just keep an eye on your mood.'
    }
    return actions[averageMood.value.toLowerCase()] || 'No specific recommendations.'
})
</script>

<style scoped>
.grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
}

.mood-day {
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.mood-day:hover {
    transform: scale(1.1);
    cursor: pointer;
    z-index: 10;
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
}

/* Custom styles for each mood */
.mood-happy {
    background-color: #ecfa28;
}

.mood-sad {
    background-color: #939699;
}

.mood-angry {
    background-color: #ff7675;
}

.mood-calm {
    background-color: #9beafe;
}

.mood-anxious {
    background-color: #e9785f;
}

.mood-excited {
    background-color: #77e755;
}

.mood-tired {
    background-color: #dfe6e9;
}

.mood-neutral {
    background-color: #fafafa;
}
.avg-mood-container {
    margin-top: 2rem;
    padding: 1.5rem;
    background-color: #ffffff;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.avg-mood-container h2 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #2d3748;
}

.avg-mood-container p {
    font-size: 1rem;
    color: #4a5568;
}

.avg-mood-container .text-lg {
    font-size: 1.125rem;
}

.avg-mood-container .text-sm {
    font-size: 0.875rem;
}
.bg-gradient-to-r {
    background: linear-gradient(to right, #eaf5ea, #cfffd0);
}

.shadow-xl {
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

/* Font and icon styling */
.text-gray-800 {
    color: #4a5568;
}

.text-gray-900 {
    color: #1a202c;
}

.text-gray-700 {
    color: #4a5568;
}

.text-red-500 {
    color: #f56565;
}

.text-yellow-400 {
    color: #f6e05e;
}

/* Icon styling */
.fas {
    font-family: 'Font Awesome 5 Free', sans-serif;
    font-weight: 900;
}

/* Responsive and hover effect */
@media (min-width: 640px) {
    .text-xl {
        font-size: 1.25rem;
    }
}
</style>
