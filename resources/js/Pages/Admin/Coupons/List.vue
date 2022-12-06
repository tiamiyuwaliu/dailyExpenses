<template>
    <AdminLayout :title="__('Admin > Coupons')">
        <v-card>
            <template class="clearfix" v-slot:title>
                {{ __('Coupons') }}
                <div class="float-right">
                    <Link :href="route('coupons.create')">
                        <v-btn
                            color="primary">
                            {{ __('New Coupon') }}
                        </v-btn>
                    </Link>
                </div>
            </template>
            <v-table>
                <thead>
                <tr>
                    <th class="text-left" style="width:40%">
                        {{ __('Name') }}
                    </th>
                    <th class="text-left" style="width:20%">
                        {{ __('Code') }}
                    </th>
                    <th class="text-left" style="width:20%">
                        {{ __('Value') }}
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
                <tr v-for="coupon in coupons.data" :key="coupon.id">
                    <td class="pt-4 pb-4">
                        <h4 class="font-weight-regular ">{{ coupon.name }}</h4>
                    </td>

                    <td>
                        <v-chip color="info">
                            {{coupon.code}}
                        </v-chip>
                    </td>
                    <td>
                        <span>{{coupon.deduction}}% {{__('Discount')}}</span>
                    </td>
                    <td>
                        <v-avatar v-if="coupon.status === 1" size="20" color="success">
                            <v-icon icon="mdi-check"></v-icon>
                        </v-avatar>
                        <v-avatar v-else size="20" color="red">
                            <v-icon icon="mdi-close"></v-icon>
                        </v-avatar>
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
                                    <Link :href="coupon.editUrl">
                                        <v-list-item-title>{{ __('Edit') }}</v-list-item-title>
                                    </Link>
                                </v-list-item>

                                <v-list-item @click="deleteUser(coupon.deleteUrl)">
                                    <v-list-item-title>{{ __('Delete') }}</v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </td>
                </tr>
                </tbody>
            </v-table>

            <div class="d-flex flex-row pa-4  pagination-container">
                <Link :disabled="link.url === null" v-for="link in coupons.links" :href="link.url"
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

        <ConfirmDialog ref="confirm"/>
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
            coupons: usePage().props.value.coupons,
        }
    },
    methods: {
        async deleteUser(url) {
            if (await this.$refs.confirm.open(this.__("Delete"), "Do you really want to delete this coupon?")) {
                this.$inertia.visit(url);
            }

        }
    }
}
</script>
