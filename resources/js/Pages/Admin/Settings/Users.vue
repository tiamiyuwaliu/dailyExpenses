<template>
    <AdminLayout :title="__('Settings > Users')">
        <v-card>
            <template v-slot:title>
                {{__('Users')}}
            </template>

            <div class="pa-4">
                <v-select
                    :label="__('Enable new users registration')"
                    :items="options"
                    v-model="formData.register"
                    variant="underlined"
                ></v-select>

                <v-select
                    :label="__('Enable email confirmation')"
                    :items="options"
                    v-model="formData.verify"
                    variant="underlined"
                ></v-select>

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
                register: usePage().props.value.register,
                verify: usePage().props.value.verify,
            }),
            options: usePage().props.value.options
        }
    },

    methods: {
        submit() {
            this.isLoading = true;
            this.formData.post('/admin/settings/users')
        }
    }
}
</script>
