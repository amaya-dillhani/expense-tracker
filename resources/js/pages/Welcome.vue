<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { login, register } from '@/routes';

withDefaults(
    defineProps<{
        canRegister?: boolean;
    }>(),
    {
        canRegister: true,
    },
);
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
        <!-- Header/Navigation -->
        <header class="w-full px-6 py-4">
            <nav class="mx-auto flex max-w-7xl items-center justify-between">
                <div class="text-2xl font-bold text-gray-900 dark:text-white">
                    FinanceTracker
                </div>
                
                <div class="flex items-center gap-4">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="'/transactions'"
                        class="rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition"
                    >
                        Go to Dashboard
                    </Link>
                    <template v-else>
                        <Link
                            :href="login()"
                            class="rounded-lg px-6 py-2.5 text-sm font-semibold text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white transition"
                        >
                            Log in
                        </Link>
                        <Link
                            v-if="canRegister"
                            :href="register()"
                            class="rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition"
                        >
                            Get Started
                        </Link>
                    </template>
                </div>
            </nav>
        </header>

        <!-- Hero Section -->
        <main class="mx-auto max-w-7xl px-6 py-16 sm:py-24 lg:py-32">
            <div class="text-center">
                <h1 class="text-5xl font-extrabold tracking-tight text-gray-900 sm:text-6xl lg:text-7xl dark:text-white">
                    Take Control of Your
                    <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        Finances
                    </span>
                </h1>
                
                <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-gray-600 dark:text-gray-300">
                    Track your income and expenses effortlessly. Get real-time insights into your financial health 
                    and make smarter money decisions.
                </p>

                <div class="mt-10 flex items-center justify-center gap-6">
                    <Link
                        v-if="!$page.props.auth.user"
                        :href="register()"
                        class="rounded-lg bg-blue-600 px-8 py-4 text-base font-semibold text-white shadow-lg hover:bg-blue-700 transition transform hover:scale-105"
                    >
                        Start Free Today
                    </Link>
                    <Link
                        :href="$page.props.auth.user ? '/transactions' : login()"
                        class="rounded-lg border-2 border-gray-300 px-8 py-4 text-base font-semibold text-gray-700 hover:border-gray-400 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800 transition"
                    >
                        {{ $page.props.auth.user ? 'View Transactions' : 'Learn More' }}
                    </Link>
                </div>
            </div>
            <!-- CTA Section -->
            <div class="mt-24 text-center">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white sm:text-4xl">
                    Ready to get started?
                </h2>
                <p class="mx-auto mt-4 max-w-2xl text-lg text-gray-600 dark:text-gray-300">
                    Join thousands of users who are taking control of their financial future.
                </p>
                <div class="mt-8">
                    <Link
                        v-if="!$page.props.auth.user"
                        :href="register()"
                        class="inline-block rounded-lg bg-blue-600 px-10 py-4 text-lg font-semibold text-white shadow-lg hover:bg-blue-700 transition transform hover:scale-105"
                    >
                        Create Your Free Account
                    </Link>
                    <Link
                        v-else
                        :href="'/transactions'"
                        class="inline-block rounded-lg bg-blue-600 px-10 py-4 text-lg font-semibold text-white shadow-lg hover:bg-blue-700 transition transform hover:scale-105"
                    >
                        Go to Your Dashboard
                    </Link>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-24 border-t border-gray-200 dark:border-gray-700">
            <div class="mx-auto max-w-7xl px-6 py-8">
                <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                    © 2026 FinanceTracker. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</template>
