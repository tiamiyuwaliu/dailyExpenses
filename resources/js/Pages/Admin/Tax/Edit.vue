<template>
    <AdminLayout :title="__('Admin > Tax > Create')">
        <v-card>
            <template v-slot:title>
                {{ __('Create Tax') }}
            </template>

            <div class="pa-4">
                <v-text-field :error="!!formData.errors.name" :error-messages="formData.errors.name"
                              :label="__('Name')" v-model="formData.name" variant="underlined"></v-text-field>

                <v-select
                    :label="__('Tax Regions')"
                    :items="countries"
                    multiple
                    v-model="formData.regions"
                    variant="underlined"
                ></v-select>

                <v-text-field :error="!!formData.errors.value" :error-messages="formData.errors.value"
                              :label="__('Percentage')" v-model="formData.value" variant="underlined"></v-text-field>
                <v-select
                    :label="__('Tax Type')"
                    :items="types"
                    v-model="formData.type"
                    variant="underlined"
                ></v-select>

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
            countries: usePage().props.value.countries,
            formData: useForm({
                name: usePage().props.value.tax.name,
                regions: usePage().props.value.tax.regions,
                type: usePage().props.value.tax.tax_type,
                value: usePage().props.value.tax.tax_value
            }),
            types: [{title: this.__('Inclusive'), value: 1}, {title: this.__('Exclusive'), value: 0}]
        }
    },

    methods: {
        setContent(d, o, s) {
            console.log(d);
        },
        submit() {
            this.loading = true;
            this.formData.post('/admin/tax/edit/'+usePage().props.value.tax.id);
        }
    }
}
</script>
