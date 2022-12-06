<template>
    <AdminLayout :title="__('Settings > Cron')">
        <v-card>
            <template v-slot:title>
                {{__('Cron Job')}}
            </template>

            <div class="pa-4">

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
                verify: usePage().props.value.verify
            }),
        }
    },

    methods: {

    }
}
</script>
