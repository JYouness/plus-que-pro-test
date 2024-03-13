<script setup lang="ts">
import { toRefs } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Movie } from '@/types/movie'
import { useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const props = defineProps<{
    movie: Movie
    languages: Record<string, string>
}>()

const { movie } = toRefs(props)

const formatDate = (value: string): string => {
    return new Date(value)
        .toLocaleDateString('en-GB', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit'
        })
        .split('/')
        .reverse()
        .join('-')
}

const form = useForm({
    title: movie?.value?.title,
    original_title: movie?.value?.original_title,
    overview: movie?.value?.overview,
    original_language: movie?.value?.original_language,
    release_date: formatDate(movie?.value?.release_date || '')
})

const submit = (): void => {
    if (form.processing) return

    form.clearErrors()

    form.put(route('dashboard.movies.update', { movie: movie?.value?.id }))
}
</script>

<template>
    <AppLayout :title="movie.title">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Edit Movie: {{ movie.title }}
            </h2>
        </template>

        <section class="body-font text-gray-800 dark:text-gray-200">
            <div
                class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex flex-wrap"
            >
                <div
                    class="w-full bg-white dark:bg-gray-800 rounded shadow-lg p-4 px-4 md:p-8 mb-6"
                >
                    <div
                        class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3"
                    >
                        <div class="text-gray-600 dark:text-gray-400">
                            <p class="font-medium text-lg">Movie Details</p>
                            <p>Please fill out the fields.</p>
                        </div>

                        <div class="lg:col-span-2">
                            <form @submit.prevent="submit">
                                <div
                                    class="grid gap-4 text-sm grid-cols-1 md:grid-cols-5"
                                >
                                    <div class="md:col-span-5">
                                        <label
                                            for="title"
                                            class="inline-block font-semibold text-sm mb-1"
                                            >Title</label
                                        >
                                        <input
                                            id="title"
                                            v-model="form.title"
                                            type="text"
                                            name="title"
                                            placeholder="Title"
                                            class="h-10 border dark:border-gray-700 rounded p-2.5 w-full bg-gray-50 dark:bg-gray-900"
                                        />
                                        <span
                                            v-if="form.errors.title"
                                            class="text-sm text-red-500"
                                            v-text="form.errors.title"
                                        ></span>
                                    </div>

                                    <div class="md:col-span-5">
                                        <label
                                            for="original_title"
                                            class="inline-block font-semibold text-sm mb-1"
                                            >Original Title</label
                                        >
                                        <input
                                            id="original_title"
                                            v-model="form.original_title"
                                            type="text"
                                            name="original_title"
                                            placeholder="Original Title"
                                            class="h-10 border dark:border-gray-700 rounded p-2.5 w-full bg-gray-50 dark:bg-gray-900"
                                        />
                                        <span
                                            v-if="form.errors.original_title"
                                            class="text-sm text-red-500"
                                            v-text="form.errors.original_title"
                                        ></span>
                                    </div>

                                    <div class="md:col-span-5">
                                        <label
                                            for="overview"
                                            class="inline-block font-semibold text-sm mb-1"
                                            >Overview</label
                                        >
                                        <textarea
                                            id="overview"
                                            v-model="form.overview"
                                            name="overview"
                                            class="h-30 border dark:border-gray-700 rounded p-2.5 w-full bg-gray-50 dark:bg-gray-900"
                                        ></textarea>
                                        <span
                                            v-if="form.errors.overview"
                                            class="text-sm text-red-500"
                                            v-text="form.errors.overview"
                                        ></span>
                                    </div>

                                    <div class="md:col-span-5">
                                        <label
                                            for="original_language"
                                            class="inline-block font-semibold text-sm mb-1"
                                            >Original Language</label
                                        >
                                        <select
                                            id="original_language"
                                            v-model="form.original_language"
                                            name="original_language"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-900 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        >
                                            <option value="">
                                                Select Original Language
                                            </option>
                                            <option
                                                v-for="(
                                                    language, key
                                                ) in languages"
                                                :key="key"
                                                :value="key"
                                                :selected="
                                                    form.original_language ===
                                                    language
                                                "
                                                v-text="language"
                                            />
                                        </select>

                                        <span
                                            v-if="form.errors.original_language"
                                            class="text-sm text-red-500"
                                            v-text="
                                                form.errors.original_language
                                            "
                                        ></span>
                                    </div>

                                    <div class="md:col-span-5">
                                        <label
                                            for="release_date"
                                            class="inline-block font-semibold text-sm mb-1"
                                            >Release Date</label
                                        >
                                        <input
                                            id="release_date"
                                            v-model="form.release_date"
                                            type="date"
                                            name="release_date"
                                            placeholder="Original Title"
                                            class="h-10 border dark:border-gray-700 rounded p-2.5 w-full bg-gray-50 dark:bg-gray-900"
                                        />
                                        <span
                                            v-if="form.errors.release_date"
                                            class="text-sm text-red-500"
                                            v-text="form.errors.release_date"
                                        ></span>
                                    </div>

                                    <div class="md:col-span-5 text-right">
                                        <div class="inline-flex items-end">
                                            <button
                                                type="submit"
                                                :disabled="form.processing"
                                                class="uppercase bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-5 rounded disabled:opacity-25"
                                                v-text="
                                                    form.processing
                                                        ? 'Processing...'
                                                        : 'Submit'
                                                "
                                            />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
