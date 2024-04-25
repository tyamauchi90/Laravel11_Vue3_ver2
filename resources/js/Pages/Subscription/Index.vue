<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { loadStripe } from "@stripe/stripe-js";
import { onMounted } from "vue";

const { intent } = defineProps({
    intent: Object,
});

const stripePromise = loadStripe(import.meta.env.VITE_STRIPE_KEY);
let stripe, elements, cardElement;

const form = useForm({
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
    const clientSecret = intent.client_secret;
    const { setupIntent, error } = await stripe.confirmCardSetup(clientSecret, {
        payment_method: {
            card: cardElement,
            billing_details: { name: form.cardHolderName },
        },
    });
    if (error) {
        console.log(error);
    } else {
        form.paymentMethodId = setupIntent.payment_method;
        form.post("/user/subscribe");
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto">
            <div class="py-12">
                <div class="sm:px-6 lg:px-8">
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6 bg-white border-b border-gray-200">
                            サブスクリプション
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="sm:px-6 lg:px-8">
                    <h2>サブスクリプション</h2>
                    <form id="setup-form" @submit.prevent="stripeSubmit()">
                        <input
                            v-model="form.cardHolderName"
                            id="card-holder-name"
                            type="text"
                            placeholder="カード名義人"
                        />
                        <div id="card-element"></div>
                        <button id="card-button">サブスクリプション</button>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
#card-element,
#card-holder-name {
    border-radius: 4px 4px 0 0;
    padding: 12px;
    border: 1px solid rgba(50, 50, 93, 0.1);
    height: 44px;
    width: 100%;
    background: white;
}

button#card-button {
    background: #5469d4;
    color: #ffffff;
    font-family: Arial, sans-serif;
    border-radius: 0 0 4px 4px;
    border: 0;
    padding: 12px 16px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    display: block;
    box-shadow: 0px 4px 5.5px 0px rgba(0, 0, 0, 0.07);
    width: 100%;
}
</style>
