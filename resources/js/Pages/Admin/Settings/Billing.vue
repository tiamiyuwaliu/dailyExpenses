<template>
    <AdminLayout :title="__('Settings > Billing')">
        <v-card>
            <template v-slot:title>
                {{__('Billing Information')}}
            </template>

            <div class="pa-4">

                <v-text-field :label="__('Vendor')" v-model="formData.vendor"  variant="underlined"></v-text-field>
                <v-text-field :label="__('Invoice Prefix')" v-model="formData.invoice"  variant="underlined"></v-text-field>
                <v-text-field :label="__('Address')" v-model="formData.address"  variant="underlined"></v-text-field>

                <v-row>
                    <v-col>
                        <v-text-field :label="__('City')" v-model="formData.city"  variant="underlined"></v-text-field>
                    </v-col>
                    <v-col>
                        <v-text-field :label="__('state')" v-model="formData.state"  variant="underlined"></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-text-field :label="__('Postal code')" v-model="formData.postcode"  variant="underlined"></v-text-field>
                    </v-col>
                    <v-col>
                        <v-select
                            :label="__('Country')"
                            :items="countries"
                            v-model="formData.country"
                            variant="underlined"
                        ></v-select>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col>
                        <v-text-field :label="__('Phone number')" v-model="formData.phone"  variant="underlined"></v-text-field>
                    </v-col>
                    <v-col>
                        <v-text-field :label="__('VAT number')" v-model="formData.vat"  variant="underlined"></v-text-field>
                    </v-col>
                </v-row>

                <v-btn
                    class="mt-5"
                    :loading="isLoading"
                    @click="submit"
                    color="primary">
                    {{__('Save changes')}}
                </v-btn>
            </div>

        </v-card>
    </AdminLayout>
</template>

<script>
import AdminLayout from '@/Pages/Admin/Layout/Base.vue'
import { useForm, usePage } from '@inertiajs/inertia-vue3'
import {useToast} from "vue-toastification";
export default {
    components: {
        AdminLayout
    },
    updated() {
        this.isLoading = false;
        if (usePage().props.value.flash.message) {
            let toast = useToast();
            toast.success(usePage().props.value.flash.message)
        }
    },

    data() {

        return {
            isLoading : false,
            formData: useForm({
                vendor: usePage().props.value.vendor,
                invoice: usePage().props.value.invoice,
                address: usePage().props.value.address,
                city: usePage().props.value.city,
                state: usePage().props.value.state,
                postcode: usePage().props.value.postcode,
                country: usePage().props.value.country,
                phone: usePage().props.value.phone,
                vat: usePage().props.value.vat,
            }),
            countries: usePage().props.value.countries
        }
    },

    methods: {
        submit() {
            this.isLoading = true;
            this.formData.post('/admin/settings/billing')
        }
    }
}
</script>
