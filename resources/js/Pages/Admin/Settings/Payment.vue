<template>
    <AdminLayout :title="__('Settings > Payments')">
        <v-card>
            <div class="pa-4">
                <v-tabs
                    v-model="tabs"
                    grow
                >
                    <v-tab value="option-1">
                        {{__('Paypal')}}
                    </v-tab>
                    <v-tab value="option-2">
                        {{ __('Stripe') }}
                    </v-tab>
                </v-tabs>
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

            }),
            tabs: null
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
