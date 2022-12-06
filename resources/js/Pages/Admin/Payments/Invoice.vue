<template>
    <v-container>
        <div class="clearfix">
            <div class="float-left">
                <Link :href="route('payments')"><v-icon icon="mdi-arrow-left-thin"></v-icon></Link>
            </div>
            <div class="float-right">
                <v-btn color="primary">{{__('Print')}}</v-btn>
            </div>
        </div>
        <v-card  class="mt-4 pa-9">
            <template class="clearfix" v-slot:title>
                {{ billing.vendor }}
                <div class="float-right">
                    <h3 class="mb-3">{{__('INVOICE')}}</h3>
                    <p>{{__('Date')}}: {{payment.created_at}}</p>
                    <p>{{__('Invoice ID')}}: {{payment.invoiceTitle}}</p>
                </div>
            </template>

            <v-row class="mt-2 pa-4">
                <v-col>
                    <h5>{{__('Vendor')}}</h5>

                    <p class="mt-2">{{__('Name')}}: <span class="text-grey">{{billing.vendor}}</span></p>
                    <p class="mt-2">{{__('Address')}}: <span class="text-grey">{{billing.address}}</span></p>
                    <p class="mt-2">{{__('City')}}: <span class="text-grey">{{billing.city}}</span></p>
                    <p class="mt-2">{{__('State')}}: <span class="text-grey">{{billing.state}}</span></p>
                    <p class="mt-2">{{__('Postal code')}}: <span class="text-grey">{{billing.postcode}}</span></p>
                    <p class="mt-2">{{__('Country')}}: <span class="text-grey">{{billing.country}}</span></p>
                    <p class="mt-2">{{__('Phone')}}: <span class="text-grey">{{billing.phone}}</span></p>
                    <p class="mt-2">{{__('VAT Number')}}: <span class="text-grey">{{billing.vat}}</span></p>
                </v-col>

                <v-col>
                    <h5>{{__('Client')}}</h5>
                    <p class="mt-2">{{__('Name')}}: <span class="text-grey">{{payment.userName}}</span></p>
                    <p class="mt-2">{{__('Email')}}: <span class="text-grey">{{payment.userEmail}}</span></p>
                </v-col>
            </v-row>

            <v-table>
                <thead>
                <tr>
                    <th class="text-left" style="width:60%">
                        {{ __('Description') }}
                    </th>
                    <th class="text-left" style="width:20%">
                        {{ __('Date') }}
                    </th>
                    <th class="text-left" style="width:20%">
                        {{ __('Amount') }}
                    </th>

                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{payment.payment_for}}</td>
                        <td>{{payment.created_at}}</td>
                        <td>{{payment.amount}}</td>
                    </tr>
                    <tr class="mt-3">
                        <td></td>
                        <td class="text-right"><span class="font-weight-bold">{{__('Total')}}</span></td>
                        <td>{{payment.amount}}</td>
                    </tr>
                </tbody>
            </v-table>

        </v-card>
    </v-container>
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
            billing: usePage().props.value.billing
        }
    },
    methods: {

    }
}
</script>
