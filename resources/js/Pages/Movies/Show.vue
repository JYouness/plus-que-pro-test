<script setup lang="ts">
import { type PropType } from 'vue'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import { Movie } from '@/types/movie'

defineProps({
    movie: Object as PropType<Movie>,
})
</script>

<template>
    <PublicLayout :title="movie.title">
        <section class="body-font text-gray-800 dark:text-gray-200">
            <div
                class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex flex-wrap"
            >
                <img
                    :src="movie.poster_url"
                    :alt="movie.title"
                    class="lg:w-1/2 w-full object-cover object-center rounded"
                />

                <div
                    class="space-y-4 lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0"
                >
                    <h1
                        class="text-gray-800 dark:text-gray-200 text-3xl title-font font-medium"
                    >
                        {{ movie.title }}
                    </h1>
                    <h2
                        v-if="movie.title == movie.original_title"
                        class="text-sm title-font dark:text-gray-200 tracking-widest"
                    >
                        <b class="font-semibold text-gray-500 uppercase"
                            >Original Name:</b
                        ><br />
                        {{ movie.original_title }}
                    </h2>
                    <p class="text-sm">
                        <b class="font-semibold text-gray-500 uppercase"
                            >Released date:</b
                        ><br />
                        {{ new Date(movie.release_date).toLocaleDateString() }}
                    </p>
                    <p class="text-sm">
                        <b class="font-semibold text-gray-500 uppercase"
                            >Rating:</b
                        ><br />
                        {{ movie.vote_average }} ({{ movie.vote_count }} votes)
                    </p>
                    <div>
                        <h4
                            class="text-xl font-semibold text-gray-500 uppercase mb-2"
                        >
                            Overview
                        </h4>
                        <p class="leading-relaxed">{{ movie.overview }}</p>
                    </div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
