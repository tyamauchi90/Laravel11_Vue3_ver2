<script setup>
import Button from "@/Components/ui/button/Button.vue";
import { router, usePage } from "@inertiajs/vue3";
import { reactive } from "vue";
const user = usePage().props.auth.user;

const form = reactive({
    kana: user.kana,
    role: user.role,
    birthday: user.birthday,
});

const editProfile = () => {
    router.visit(`/user/${user.id}`, {
        method: "put",
        data: form,
    });
};
</script>

<template>
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <form @submit.prevent="editProfile" class="space-y-4">
            <div>
                <label for="kana"
                    >カナ：
                    <input id="kana" v-model="form.kana" type="text" />
                </label>
            </div>
            <div>
                <label for="role"
                    >ステータス：
                    <select id="role" v-model="form.role">
                        <option value="member">メンバー</option>
                        <option value="admin">アドミン</option>
                        <option value="master">マスター</option>
                    </select>
                </label>
            </div>
            <div>
                <label for="birthday"
                    >誕生日：
                    <input id="birthday" v-model="form.birthday" type="date" />
                </label>
            </div>
            <Button
                class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
            >
                更新
            </Button>
        </form>
    </div>
</template>
