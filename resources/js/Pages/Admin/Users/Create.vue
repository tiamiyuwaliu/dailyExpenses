<template>
    <AdminLayout :title="__('Admin > Users > Create')">
        <v-card>
            <template v-slot:title>
                {{__('Create User')}}
            </template>

            <div class="pa-4">
                <v-text-field :error="!!formData.errors.name" :error-messages="formData.errors.name" :label="__('Name')" v-model="formData.name"  variant="underlined"></v-text-field>
                <v-text-field :error="!!formData.errors.email" :error-messages="formData.errors.email" :label="__('Email address')" v-model="formData.email"  variant="underlined"></v-text-field>
                <v-text-field :error="!!formData.errors.password" :error-messages="formData.errors.password" :label="__('Password')" v-model="formData.password"  variant="underlined"></v-text-field>
                <v-text-field  :label="__('Confirm Password')" v-model="formData.password_confirmation"  variant="underlined"></v-text-field>


                <v-select
                    :label="__('Country')"
                    :items="countries"
                    v-model="formData.country"
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
    data()  {
        return {
            loading: false,
            countries: usePage().props.value.countries,
            formData: useForm({
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                country: null
            })
        }
    },

    methods: {
        submit() {
            this.loading = true;
            this.formData.post('/admin/users/create');
        }
    }
}
</script>
