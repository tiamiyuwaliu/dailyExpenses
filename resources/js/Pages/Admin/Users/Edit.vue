<template>
    <AdminLayout :title="__('Admin > Users > Edit')">
        <v-card>
            <template v-slot:title>
                {{__('Edit User')}}
            </template>

            <div class="pa-4">
                <v-text-field :error="!!formData.errors.name" :error-messages="formData.errors.name" :label="__('Name')" v-model="formData.name"  variant="underlined"></v-text-field>
                <v-text-field :error="!!formData.errors.email" :error-messages="formData.errors.email" :label="__('Email address')" v-model="formData.email"  variant="underlined"></v-text-field>

                <v-select
                    :label="__('Role')"
                    :items="roles"
                    v-model="formData.role"
                    variant="underlined"
                ></v-select>

                <v-select
                    :label="__('Status')"
                    :items="statuses"
                    v-model="formData.status"
                    variant="underlined"
                ></v-select>

                <v-select
                    :label="__('Two-factor authentication')"
                    :items="factorOptions"
                    v-model="formData.two_factor"
                    variant="underlined"
                ></v-select>

                <v-select
                    :label="__('Country')"
                    :items="countries"
                    v-model="formData.country"
                    variant="underlined"
                ></v-select>

                <v-divider class="mt-4 mb-4"></v-divider>

                <v-text-field :error="!!formData.errors.password" :error-messages="formData.errors.password" :label="__('New Password')" v-model="formData.password"  variant="underlined"></v-text-field>
                <v-text-field :error="!!formData.errors.password" :error-messages="formData.errors.password" :label="__('Confirm New Password')" v-model="formData.password_confirmation"  variant="underlined"></v-text-field>

                <v-btn
                    :loading="loading"
                    @click="submit"
                    color="primary">
                    {{__('Save')}}
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
        console.log(usePage().props.value.user.country)
        return {
            loading: false,
            countries: usePage().props.value.countries,
            roles: [{title: this.__('User'), value: 0}, {title: this.__('Admin'), value: 1}],
            statuses: [{title: this.__('Yes'), value: 1}, {title: this.__('No'), value: 0}],
            factorOptions: [{title: this.__('Enabled'), value: 1}, {title: this.__('Disabled'), value: 0}],
            timezones: usePage().props.value.timezones,
            formData: useForm({
                name: usePage().props.value.user.name,
                email: usePage().props.value.user.email,
                country: usePage().props.value.user.country,
                timezone: usePage().props.value.user.timezone,
                two_factor: usePage().props.value.user.two_factor,
                status: usePage().props.value.user.status,
                role: usePage().props.value.user.is_admin,
                password: null,
                password_confirmation: null,
            })
        }
    },

    methods: {
        submit() {
            this.loading = true;
            this.formData.post('/admin/users/edit/'+usePage().props.value.user.id);
        }
    }
}
</script>
