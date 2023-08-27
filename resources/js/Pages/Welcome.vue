<template>
    <Head title="Table Builder" />
    <main class="grow flex h-screen">
        <section class="py-4 bg-white dark:bg-gray-900 lg:pt-12 lg:pb-16 m-auto">
            <div class="px-4 mx-auto max-w-8xl lg:px-4 lg:text-center">
                <font-awesome-icon
                    class="mx-auto mb-12 text-green-500 dark:text-blue-400"
                    icon="table"
                    fixed-width
                    size="6x"
                />
                <h1 class="mb-4 text-4xl font-bold tracking-tight text-gray-900 lg:font-extrabold lg:text-6xl lg:leading-none dark:text-white lg:text-center xl:px-36 lg:mb-7">
                    Save Time, Build Tables in Seconds!
                </h1><p class="mb-10 text-lg font-normal text-gray-500 dark:text-gray-400 lg:text-center lg:text-xl xl:px-60">
                    Tired of manual data entry and calculations? ⌛ Simplify your life with our revolutionary table-building tool that comes packed with custom logic! 🧮 Whether you're tracking expenses, planning events, or managing tasks, our tool will have you covered.
                </p>
                <div class="flex flex-col mb-8 md:flex-row lg:justify-center">
                    <Link
                        href="/login"
                        class="text-white bg-green-500 hover:bg-green-700 dark:bg-green-600 focus:ring-4 focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-base px-6 py-2.5 text-center md:mr-5 mb-3 md:mb-0 inline-flex items-center justify-center"
                    >
                        Login
                    </Link>
                    <Link
                        href="/register"
                        class="text-gray-600 bg-white-100 hover:bg-gray-100 hover:text-green-600 border border-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:border-gray-700 font-medium rounded-lg text-base px-6 py-2.5 text-center inline-flex justify-center items-center"
                    >
                        Register
                    </Link>
                </div>
            </div>
        </section>
    </main>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import PrimaryButton from '@/Components/PrimaryButton.vue';

</script>
