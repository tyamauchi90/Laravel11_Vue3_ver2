<script setup>
import { Button } from "@/Components/ui/button";
import { router } from "@inertiajs/vue3";
import { reactive } from "vue";

const form = reactive({
    title: "",
    email: "",
    body: "",
});

const onSubmit = () => {
    try {
        router.post("/contact", form);
        form.title = "";
        form.email = "";
        form.body = "";
    } catch (e) {
        console.error(e);
        alert("送信に失敗しました。");
    }
};
</script>

<template>
    <div class="p-12">
        <h1 class="text-lg font-semibold mb-4">お問い合わせ</h1>
        <form @submit.prevent="onSubmit" class="space-y-4">
            <div class="form-group">
                <label for="title">タイトル</label><br />
                <input
                    class="min-w-[400px] bg-slate-100"
                    v-model="form.title"
                    type="text"
                    placeholder="タイトル"
                    required
                    maxlength="255"
                />
            </div>

            <div class="form-group">
                <label for="email">メールアドレス</label><br />
                <input
                    class="min-w-[400px] bg-slate-100"
                    v-model="form.email"
                    type="email"
                    placeholder="メールアドレス"
                    required
                />
            </div>

            <div class="form-group">
                <label for="body">本文</label><br />
                <textarea
                    class="min-w-[400px] min-h-[200px] bg-slate-100"
                    v-model="form.body"
                    placeholder="本文"
                    required
                ></textarea>
            </div>

            <Button
                class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                type="submit"
                >送信</Button
            >
        </form>
    </div>
</template>
