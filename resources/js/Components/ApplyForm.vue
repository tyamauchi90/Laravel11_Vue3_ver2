<script setup>
import { router } from "@inertiajs/vue3";
import { loadStripe } from "@stripe/stripe-js";
import { onMounted, reactive } from "vue";
import Button from "./ui/button/Button.vue";

const { auth, event } = defineProps({
    auth: Object,
    event: Object,
});

const stripePromise = loadStripe(import.meta.env.VITE_STRIPE_KEY);
let stripe, elements, cardElement;

const form = reactive({
    name: auth.user.name,
    email: auth.user.email,
    cardHolderName: "",
    paymentMethodId: "",
    is_paid: "default",
    event_id: event.id,
    user_id: auth.user.id,
    apply_date: "",
});

onMounted(async () => {
    stripe = await stripePromise;
    elements = stripe.elements();
    cardElement = elements.create("card");
    cardElement.mount("#card-element");
});

const stripeSubmit = async () => {
    const { paymentMethod, error } = await stripe.createPaymentMethod(
        "card",
        cardElement,
        {
            billing_details: { name: form.cardHolderName },
        }
    );
    if (error) {
        console.log(error);
    } else {
        form.paymentMethodId = paymentMethod.id;
        form.is_paid = 1;
        form.apply_date = new Date().toISOString().split("T")[0];
        router.post("/process-payment", form);
    }
};
</script>

<template>
    <form @submit.prevent="stripeSubmit()" class="space-y-4">
        <div class="form-group">
            <label for="name" class="block text-sm font-medium text-gray-700"
                >お名前</label
            >
            <input
                class="mt-1 p-2 block w-full h-11 text-md rounded-sm border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
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
                class="mt-1 p-2 block w-full h-11 text-md rounded-sm border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                v-model="form.email"
                type="email"
                placeholder="メールアドレス"
                required
            />
        </div>
        <div class="transition duration-1000 ease-in-out">
            <div>
                <label
                    for="card-holder-name"
                    class="block text-sm font-medium text-gray-700"
                    >カード情報</label
                >
                <input
                    v-model="form.cardHolderName"
                    id="card-holder-name"
                    type="text"
                    placeholder="カード名義人"
                    class="mt-1 p-2 block w-full h-11 text-md rounded-sm border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                />
                <div
                    id="card-element"
                    class="mt-1 p-2 flex flex-col justify-center h-11 text-md rounded-sm border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                ></div>
                <Button
                    class="mt-4 inline-flex justify-center rounded-md border border-transparent bg-green-500 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                    >予約する（事前決済）</Button
                >
            </div>
        </div>
    </form>
</template>
