<template>
    <AdminLayout :title="__('Settings > Email')">
        <v-card>
            <template v-slot:title>
                {{__('Email')}}
            </template>

            <div class="pa-4">
                <v-text-field :label="__('Contact Name')" v-model="formData.name"  variant="underlined"></v-text-field>

                <v-text-field :label="__('Contact Email')" v-model="formData.email"  variant="underlined"></v-text-field>

                <v-divider class="mt-8"></v-divider>
                <h4 class="mt-3 font-weight-regular mb-3">{{__('Setup')}}</h4>
                <v-select
                    :label="__('Email Driver')"
                    :items="drivers"
                    v-model="formData.driver"
                    variant="underlined"
                ></v-select>

                <v-text-field :label="__('SMTP Host')" v-model="formData.host"  variant="underlined"></v-text-field>
                <v-text-field :label="__('SMTP Port')" v-model="formData.port"  variant="underlined"></v-text-field>
                <v-select
                    :label="__('Encryption')"
                    :items="encryptions"
                    v-model="formData.secure"
                    variant="underlined"
                ></v-select>
                <v-text-field :label="__('SMTP Username')" v-model="formData.username"  variant="underlined"></v-text-field>
                <v-text-field :label="__('SMTP Password')" v-model="formData.password"  variant="underlined"></v-text-field>

                <v-btn
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
                name: usePage().props.value.name,
                email: usePage().props.value.email,
                driver: usePage().props.value.driver,
                host: usePage().props.value.host,
                port: usePage().props.value.port,
                secure: usePage().props.value.secure,
                username: usePage().props.value.username,
                password: usePage().props.value.password,
            }),
            drivers: usePage().props.value.drivers,
            encryptions: ['TLS', 'SSL'],
        }
    },

    methods: {
        submit() {
            this.isLoading = true;
            this.formData.post('/admin/settings/email')
        }
    }
}
</script>
