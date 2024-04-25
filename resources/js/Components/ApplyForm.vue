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
        <div class="transition duration-1000 ease-in-out">
            <div>
                <input
                    v-model="form.cardHolderName"
                    id="card-holder-name"
                    type="text"
                    placeholder="カード名義人"
                />
                <div id="card-element"></div>
                <Button
                    class="text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg"
                    >予約する（事前決済）</Button
                >
            </div>
        </div>
    </form>
</template>

<style>
#card-element,
#card-holder-name {
    font-size: 14px;
    border-radius: 4px 4px 0 0;
    padding: 12px;
    border: 1px solid rgba(50, 50, 93, 0.1);
    height: 44px;
    width: 100%;
    background: white;
}
</style>
