<template>

    <AdminLayout :title="__('Settings > General')">
        <v-card>
            <template v-slot:title>
                {{__('General')}}
            </template>

            <div class="pa-4">

                <v-text-field :error="!!formData.errors.title" :error-messages="formData.errors.title"   :label="__('Site Title')" v-model="formData.title"  variant="underlined"></v-text-field>
                <v-text-field :label="__('Site Keywords')" v-model="formData.keywords"  variant="underlined"></v-text-field>

                <v-textarea rows="3" :label="__('Site Description')" variant="underlined"></v-textarea>

                <v-text-field
                    :hint="__('Currency code for the payments (ex USD, EUR, CAD). Make sure the currency code is standard')"
                    persistent-hint
                    :label="__('Currency')" v-model="formData.currency" class="mb-2"  variant="underlined"></v-text-field>
                <v-select
                    :label="__('Default Language')"
                    :items="languages"
                    v-model="formData.language"
                    variant="underlined"
                ></v-select>

                <v-select
                    :label="__('Default Timezone')"
                    :items="timezones"
                    v-model="formData.timezone"
                    :hint="__('The default timezone for users when they are registering ')"
                    persistent-hint
                    variant="underlined"
                    class="mb-2"
                ></v-select>


                <v-select
                    :label="__('Default results per page')"
                    :items="results"
                    v-model="formData.results"
                    variant="underlined"
                ></v-select>

                <v-select
                    :label="__('Default results order')"
                    :items="orders"
                    v-model="formData.order"
                    variant="underlined"
                ></v-select>

                <v-textarea  v-model="formData.customJs" rows="2" :label="__('Custom JS')" variant="underlined"></v-textarea>

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
import { useToast } from "vue-toastification";
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
                title: usePage().props.value.title,
                keywords: usePage().props.value.keywords,
                descriptions: usePage().props.value.descriptions,
                language: usePage().props.value.language,
                timezone: usePage().props.value.timezone,
                customJs: usePage().props.value.customJs,
                results: usePage().props.value.results,
                order: usePage().props.value.order,
                currency: usePage().props.value.currency
            }),
            languages:usePage().props.value.languages,
            orders: usePage().props.value.ordersData,
            results: [2,10,15,20,30,50,100, 200],
            timezones: [

            ]
        }
    },

    methods: {
        submit() {
            this.isLoading = true;
            this.formData.post('/admin/settings')
        }
    }
}
</script>
