<script setup>
import { useForm } from "@inertiajs/vue3";
import { loadStripe } from "@stripe/stripe-js";
import { onMounted } from "vue";
import Button from "./ui/button/Button.vue";

const stripePromise = loadStripe(import.meta.env.VITE_STRIPE_KEY);
let stripe, elements, cardElement;

const stripeForm = useForm({
    cardHolderName: "",
    paymentMethodId: "",
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
            billing_details: { name: stripeForm.cardHolderName },
        }
    );
    if (error) {
        console.log(error);
    } else {
        stripeForm.paymentMethodId = paymentMethod.id;
        stripeForm.post(`/process-payment`, {
            user_id: auth.user.id,
            event_id: event.id,
            apply_date: new Date().toISOString().split("T")[0],
            is_paid: form.is_paid,
        });
    }
};
</script>

<template>
    <div class="max-w-7xl mx-auto">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="sm:px-6 lg:px-8">
                <h2>決済</h2>
                <form id="setup-form" @submit.prevent="stripeSubmit()">
                    <input
                        v-model="stripeForm.cardHolderName"
                        id="card-holder-name"
                        type="text"
                        placeholder="カード名義人"
                    />
                    <div id="card-element"></div>
                    <Button
                        class="text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg"
                        >予約する（事前決済）</Button
                    >
                </form>
            </div>
        </div>
    </div>
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
