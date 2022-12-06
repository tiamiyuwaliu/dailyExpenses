<template>
    <AdminLayout :title="__('Admin > Taxes')">
        <v-card>
            <template class="clearfix" v-slot:title>
                {{ __('Taxes') }}
                <div class="float-right">
                    <Link :href="route('tax.create')">
                        <v-btn
                            color="primary">
                            {{ __('New Tax') }}
                        </v-btn>
                    </Link>
                </div>
            </template>
            <v-table>
                <thead>
                <tr>
                    <th class="text-left" style="width:60%">
                        {{ __('Name') }}
                    </th>
                    <th class="text-left" style="width:20%">
                        {{ __('Tax rate') }}
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
                <tr v-for="tax in taxes.data" :key="tax.id">
                    <td class="pt-4 pb-4">
                        <h4 class="font-weight-regular ">{{ tax.name }}</h4>
                    </td>

                    <td>
                        {{tax.tax_value}}%
                        <span v-if="tax.tax_type === 1">{{__('Inclusive')}}</span>
                        <span v-else>{{__('Exclusive')}}</span>
                    </td>
                    <td>
                        <v-avatar v-if="tax.status === 1" size="20" color="success">
                            <v-icon icon="mdi-check"></v-icon>
                        </v-avatar>
                        <v-avatar v-else size="20" color="danger">
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
                                    <Link :href="tax.editUrl">
                                        <v-list-item-title>{{ __('Edit') }}</v-list-item-title>
                                    </Link>
                                </v-list-item>
                                <v-list-item @click="deleteUser(tax.deleteUrl)">
                                    <v-list-item-title>{{ __('Delete') }}</v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </td>
                </tr>
                </tbody>
            </v-table>

            <div class="d-flex flex-row pa-4  pagination-container">
                <Link :disabled="link.url === null" v-for="link in taxes.links" :href="link.url"
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
            taxes: usePage().props.value.taxes,
        }
    },
    methods: {
        async deleteUser(url) {
            if (await this.$refs.confirm.open(this.__("Delete"), "Do you really want to delete this tax?")) {
                this.$inertia.visit(url);
            }

        }
    }
}
</script>
