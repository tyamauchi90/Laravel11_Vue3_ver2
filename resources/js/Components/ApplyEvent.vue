<script setup>
import { router } from "@inertiajs/vue3";
import { reactive } from "vue";
import Button from "./ui/button/Button.vue";

const { auth, event } = defineProps({
    auth: Object,
    event: Object,
});

const form = reactive({
    name: auth.user.name,
    email: auth.user.email,
    is_paid: "default",
    event_id: event.id,
    user_id: auth.user.id,
    apply_date: "",
});

const applyEvent = () => {
    try {
        form.is_paid = 0;
        form.apply_date = new Date().toISOString().split("T")[0];
        router.post(`/application`, form);
    } catch (e) {
        console.error(e);
        alert("申込みに失敗しました。");
    }
};
</script>

<template>
    <form @submit.prevent="applyEvent()" class="space-y-4">
        <div class="form-group">
            <label for="name" class="block text-sm font-medium text-gray-700"
                >お名前</label
            >
            <input
                class="mt-1 p-2 block w-full h-11 text-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                v-model="form.name"
                type="text"
                placeholder="タイトル"
                required
                maxlength="255"
            />
        </div>

        <div class="form-group">
            <label for="email" class="block text-sm font-medium text-gray-700"
                >メールアドレス</label
            >
            <input
                class="mt-1 p-2 block w-full h-11 text-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                v-model="form.email"
                type="email"
                placeholder="メールアドレス"
                required
            />
        </div>
        <Button
            class="text-white bg-indigo-500 border-0 py-2 px-4 focus:outline-none hover:bg-indigo-600 rounded"
            type="submit"
            >予約する（当日支払い）</Button
        >
    </form>
</template>
