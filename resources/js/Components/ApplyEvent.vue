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
            <label for="name">お名前</label><br />
            <input
                class="w-full"
                v-model="form.name"
                type="text"
                placeholder="タイトル"
                required
                maxlength="255"
            />
        </div>

        <div class="form-group">
            <label for="email">メールアドレス</label><br />
            <input
                class="w-full"
                v-model="form.email"
                type="email"
                placeholder="メールアドレス"
                required
            />
        </div>
        <Button
            class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
            type="submit"
            >予約する（当日支払い）</Button
        >
    </form>
</template>
