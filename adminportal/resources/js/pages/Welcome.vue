<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { dashboard, login } from '@/routes';
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div
        class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]"
    >
        <header
            class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl"
        >
            <nav class="flex items-center justify-center gap-4">
                <Link
                    v-if="$page.props.auth.user"
                    :href="dashboard()"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >
                    Dashboard
                </Link>
                <template v-else>
                    <Link
                        :href="login()"
                        class="inline-block rounded-sm border-2 px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                    >
                      Admin  Log in
                    </Link>
                </template>
            </nav>
        </header>
        <main class="max-auto max-w-6xl px-6 pt-4 pb-4 lg:px-8 lg:pt-4">
            <div class="max-w-2xl">
                <h1 class="mt-5 text-4xl leading-[1-1] font-semibold tracking-tight lg:text-5xl" style="font-family:'Space Grotesk', sans-serif;">
                    One Dashboard to Manage All Your PharmaTech Solutions.!
                </h1>
            </div>
        </main>
        <footer class="mx-auto max-w-6xl px-6 pb-10 lg:px-8">
            <p class="text-xs text-[#16231f4d] text-[#ffffff]">
                &copy;2026 PharmaTech Solutions. All Rights Reserved.
            </p>
        </footer>
    </div>
</template>
