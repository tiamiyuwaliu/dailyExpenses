<template>
    <AdminLayout :title="__('Admin > Payments')">
        <v-card>
            <template class="clearfix" v-slot:title>
                {{ __('Payment Details') }}
                <div class="float-right">
                    <Link :href="payment.invoiceUrl">
                        <v-btn
                            color="primary">
                            {{ __('Invoice') }}
                        </v-btn>
                    </Link>
                </div>
            </template>

            <v-row class="mt-4 mb-4">
                <v-col>
                    <v-list-item :title="__('Payment for')" :subtitle="payment.payment_for" class="mb-3"></v-list-item>
                    <v-list-item :title="__('Payment ID')" :subtitle="payment.payment_id" class="mb-3"></v-list-item>
                    <v-list-item :title="__('Processor')" :subtitle="payment.processor" class="mb-3"></v-list-item>
                </v-col>

                <v-col>
                    <v-list-item :title="__('Amount')" :subtitle="payment.amount" class="mb-3"></v-list-item>
                    <v-list-item :title="__('Invoice')"  class="mb-3">
                        <Link :href="payment.invoiceUrl">{{payment.invoiceTitle}}</Link>
                    </v-list-item>
                    <v-list-item :title="__('Date')" :subtitle="payment.created_at" class="mb-3"></v-list-item>
                </v-col>
            </v-row>


        </v-card>

        <v-card class="mt-4 pa-3">
            <v-row>
                <v-col>
                    <v-list-item :title="__('User name')" :subtitle="payment.userName" class="mb-3"></v-list-item>
                </v-col>

                <v-col>
                    <v-list-item :title="__('Email')" :subtitle="payment.userEmail" class="mb-3"></v-list-item>
                </v-col>
            </v-row>
        </v-card>

    </AdminLayout>
</template>

<script>
import AdminLayout from '@/Pages/Admin/Layout/Base.vue';
import {usePage, Link} from '@inertiajs/inertia-vue3';
import {useToast} from "vue-toastification";
import ConfirmDialog from "@/Components/ConfirmDialog.vue";

export default {

    components: {AdminLayout, Link, ConfirmDialog},
    mounted() {
        if (usePage().props.value.flash.message) {
            let toast = useToast();
            toast.success(usePage().props.value.flash.message)
        }


    },
    data() {
        return {
            payment: usePage().props.value.payment,
        }
    },
    methods: {

    }
}
</script>
