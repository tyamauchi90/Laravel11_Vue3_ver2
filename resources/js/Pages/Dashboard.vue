<script setup>
import FlashMessage from "@/Components/FlashMessage.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

// テキストをクリップボードにコピーする関数
const copyToClipboard = (text) => {
    navigator.clipboard.writeText(text);
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <FlashMessage />
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <ul class="space-y-4">
                            <li>
                                モデル作成：
                                <span
                                    class="text-indigo-900 font-semibold cursor-pointer"
                                    @click="
                                        copyToClipboard(
                                            'php artisan make:model Application -m'
                                        )
                                    "
                                    >php artisan make:model Application -m
                                </span>
                            </li>
                            <li>
                                コントローラー作成：
                                <span
                                    class="text-indigo-900 font-semibold cursor-pointer"
                                    @click="
                                        copyToClipboard(
                                            'php artisan make:controller ApplicationController --resource --model=Application'
                                        )
                                    "
                                    >php artisan make:controller
                                    ApplicationController --resource
                                    --model=Application</span
                                >
                            </li>
                            <li>
                                データベースに反映：
                                <span
                                    class="text-indigo-900 font-semibold cursor-pointer"
                                    @click="
                                        copyToClipboard('php artisan migrate')
                                    "
                                    >php artisan migrate</span
                                >
                            </li>
                            <li>
                                シーダー作成：
                                <span
                                    class="text-indigo-900 font-semibold cursor-pointer"
                                    @click="
                                        copyToClipboard(
                                            'php artisan make:seeder ApplicationSeeder'
                                        )
                                    "
                                    >php artisan make:seeder
                                    ApplicationSeeder</span
                                >
                            </li>
                            <li>
                                シーダー実行：
                                <span
                                    class="text-indigo-900 font-semibold cursor-pointer"
                                    @click="
                                        copyToClipboard(
                                            'php artisan db:seed --class=ApplicationSeeder'
                                        )
                                    "
                                    >php artisan db:seed
                                    --class=ApplicationSeeder</span
                                >
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
