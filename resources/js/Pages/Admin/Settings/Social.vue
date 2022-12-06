<template>
    <AdminLayout :title="__('Settings > Social')">
        <v-card>
            <template v-slot:title>
                {{__('Social Profiles')}}
            </template>

            <div class="pa-4">

                <v-text-field
                    :label="__('Facebook')"
                    variant="underlined"
                    v-model="formData.facebook"
                    prepend-icon="mdi-facebook"
                ></v-text-field>

                <v-text-field
                    :label="__('Instagram')"
                    variant="underlined"
                    v-model="formData.instagram"
                    prepend-icon="mdi-instagram"
                ></v-text-field>

                <v-text-field
                    :label="__('LinkedIn')"
                    variant="underlined"
                    v-model="formData.linkedin"
                    prepend-icon="mdi-linkedin"
                ></v-text-field>
                <v-text-field
                    :label="__('Twitter')"
                    variant="underlined"
                    v-model="formData.twitter"
                    prepend-icon="mdi-twitter"
                ></v-text-field>
                <v-text-field
                    :label="__('Youtube')"
                    variant="underlined"
                    v-model="formData.youtube"
                    prepend-icon="mdi-youtube"
                ></v-text-field>

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
                facebook: usePage().props.value.facebook,
                twitter: usePage().props.value.twitter,
                linkedin: usePage().props.value.linkedin,
                instagram: usePage().props.value.instagram,
                youtube: usePage().props.value.youtube,
            }),
        }
    },

    methods: {
        submit() {
            this.isLoading = true;
            this.formData.post('/admin/settings/social')
        }
    }
}
</script>
