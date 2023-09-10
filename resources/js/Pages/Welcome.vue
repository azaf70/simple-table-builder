<template>
    <Head title="Table Builder" />
    <main class="grow flex h-screen bg-gradient-to-bl from-gray-700/50 to-blue-500">
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
                    >
                        <Button
                            label="Login"
                            icon="pi pi-sign-in"
                            class="mr-5 mb-3 md:mb-0"
                            @click="route('login')"
                        />
                    </Link>
                    <Link
                        href="/register"
                    >
                        <Button
                            label="Register"
                            icon="pi pi-user-plus"
                            class="mr-5 mb-3 md:mb-0"
                            severity="secondary"
                        />
                    </Link>
                </div>
            </div>
        </section>
    </main>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import Button from 'primevue/button';

</script>
