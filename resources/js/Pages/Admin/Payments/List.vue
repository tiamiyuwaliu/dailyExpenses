<template>
    <AdminLayout :title="__('Admin > Payments')">
        <v-card>
            <template class="clearfix" v-slot:title>
                {{ __('Payments') }}

            </template>
            <v-table>
                <thead>
                <tr>
                    <th class="text-left" style="width:40%">
                        {{ __('User') }}
                    </th>
                    <th class="text-left" style="width:10%">
                        {{ __('Processor') }}
                    </th>
                    <th class="text-left" style="width:30%">
                        {{ __('Amount') }}
                    </th>
                    <th class="text-left" style="width:10%">
                        {{ __('Status') }}
                    </th>
                    <th class="text-right" style="width:10%">
                        {{ __('Actions') }}
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="payment in payments.data" :key="payment.id">
                    <td class="pt-4 pb-4">
                        <div class="d-flex flex-no-wrap pt-2 pb-2 ">
                            <v-avatar size="25">
                                <v-img
                                    :src="payment.userAvatar"
                                    alt="John"
                                ></v-img>
                            </v-avatar>
                            <div class="ml-2 ">
                                <h4 class="font-weight-black ">{{payment.userName}}</h4>
                            </div>
                        </div>
                    </td>
                    <td>
                        <v-chip>{{payment.processor}}</v-chip>
                    </td>
                    <td>
                        <span class="text-primary">{{payment.amount}}</span>
                        <v-chip class="ml-1">{{payment.invoiceTitle}}</v-chip>
                    </td>
                    <td>
                        <v-chip v-if="payment.status === 0" color="red">{{__('Cancelled')}}</v-chip>
                        <v-chip v-if="payment.status === 1" color="green">{{__('Completed')}}</v-chip>
                        <v-chip v-if="payment.status === 2" >{{__('Pending')}}</v-chip>
                    </td>
                    <td class="text-right pb-2">
                        <v-menu
                            open-on-hover
                        >
                            <template v-slot:activator="{ props }">
                                <v-btn
                                    size="small"
                                    icon="mdi-dots-vertical"
                                    v-bind="props"
                                ></v-btn>
                            </template>

                            <v-list>
                                <v-list-item>
                                    <Link :href="payment.editUrl">
                                        <v-list-item-title>{{ __('Edit') }}</v-list-item-title>
                                    </Link>
                                </v-list-item>
                                <v-list-item >
                                    <Link :href="payment.invoiceUrl">
                                        <v-list-item-title>{{ __('Invoice') }}</v-list-item-title>
                                    </Link>
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </td>
                </tr>
                </tbody>
            </v-table>

            <div class="d-flex flex-row pa-4  pagination-container">
                <Link :disabled="link.url === null" v-for="link in payments.links" :href="link.url"
                      class="ma-1 pa-0 ps-0 pe-0">
                    <v-btn
                        class="rounded-circle ma-0 pa-0"
                        variant="flat"
                        size="large"
                        :color="link.active === true ? 'grey' : ''"

                        v-html="link.label"
                    >
                    </v-btn>
                </Link>
            </div>
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
            payments: usePage().props.value.payments,
        }
    },
    methods: {

    }
}
</script>
