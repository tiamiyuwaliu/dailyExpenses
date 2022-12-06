<template>
    <AdminLayout :title="__('Settings > Legal')">
        <v-card>
            <template v-slot:title>
                {{__('Legal')}}
            </template>

            <div class="pa-4">
                <v-text-field :label="__('Terms of service URL')" v-model="formData.terms"  variant="underlined"></v-text-field>
                <v-text-field :label="__('Privacy policy URL')" v-model="formData.privacy"  variant="underlined"></v-text-field>
                <v-text-field :label="__('Cookie policy URL')" v-model="formData.cookie"  variant="underlined"></v-text-field>

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
                terms: usePage().props.value.terms,
                privacy: usePage().props.value.privacy,
                cookie: usePage().props.value.cookie,
            }),
        }
    },

    methods: {
        submit() {
            this.isLoading = true;
            this.formData.post('/admin/settings/legal')
        }
    }
}
</script>
