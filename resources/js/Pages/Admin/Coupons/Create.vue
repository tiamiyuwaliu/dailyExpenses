<template>
    <AdminLayout :title="__('Admin > Coupons > Create')">
        <v-card>
            <template v-slot:title>
                {{ __('Create Coupon') }}
            </template>

            <div class="pa-4">
                <v-text-field :error="!!formData.errors.name" :error-messages="formData.errors.name"
                              :label="__('Name')" v-model="formData.name" variant="underlined"></v-text-field>
                <v-text-field :error="!!formData.errors.code" :error-messages="formData.errors.code"
                              :label="__('Code')" v-model="formData.code" variant="underlined"></v-text-field>

                <v-text-field :error="!!formData.errors.deduction" :error-messages="formData.errors.deduction"
                              :label="__('Percentage off')" v-model="formData.deduction" variant="underlined"></v-text-field>

                <v-text-field :error="!!formData.errors.quantity" :error-messages="formData.errors.quantity"
                              :label="__('Quantity')" v-model="formData.quantity" variant="underlined"></v-text-field>


                <v-btn
                    :loading="loading"
                    @click="submit"
                    color="primary">
                    {{__('Submit')}}
                </v-btn>

            </div>

        </v-card>
    </AdminLayout>
</template>

<script>
import AdminLayout from '@/Pages/Admin/Layout/Base.vue';
import {Link, usePage, useForm} from "@inertiajs/inertia-vue3";
import {useToast} from "vue-toastification";

export default {
    components: {Link, AdminLayout},
    updated() {
        this.loading = false;
        if (usePage().props.value.flash.message) {
            let toast = useToast();
            toast.success(usePage().props.value.flash.message)
        }
    },
    data() {
        return {
            loading: false,
            formData: useForm({
                name: '',
                code: '',
                deduction: '',
                quantity: 0
            }),
        }
    },

    methods: {
        submit() {
            this.loading = true;
            this.formData.post('/admin/coupons/create');
        }
    }
}
</script>
