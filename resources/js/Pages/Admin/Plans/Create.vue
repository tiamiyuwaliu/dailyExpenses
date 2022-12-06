<template>
    <AdminLayout :title="__('Admin > Plan > Create')">
        <v-card>
            <template v-slot:title>
                {{ __('Create Plan') }}
            </template>

            <div class="pa-4">
                <v-text-field :error="!!formData.errors.name" :error-messages="formData.errors.name"
                              :label="__('Name')" v-model="formData.name" variant="underlined"></v-text-field>
                <v-text-field
                              :label="__('Description')" v-model="formData.description" variant="underlined"></v-text-field>

                <v-text-field
                    :label="__('Trial days')" v-model="formData.trials" variant="underlined"></v-text-field>

                <v-row>
                    <v-col>
                        <v-text-field
                            :label="__('Monthly amount')" v-model="formData.monthly" variant="underlined"></v-text-field>
                    </v-col>

                    <v-col>
                        <v-text-field
                            :label="__('Yearly amount')" v-model="formData.yearly" variant="underlined"></v-text-field>
                    </v-col>
                </v-row>

                <v-text-field
                    :label="__('Position')" v-model="formData.position" variant="underlined"></v-text-field>

                <v-select
                    :label="__('Tax rates')"
                    multiple
                    :items="taxes"
                    v-model="formData.taxes"
                    variant="underlined"
                ></v-select>
                <v-select
                    multiple
                    :label="__('Coupons')"
                    :items="coupons"
                    v-model="formData.coupons"
                    variant="underlined"
                ></v-select>
                <v-select
                    :label="__('Visibility')"
                    :items="visibilities"
                    v-model="formData.visibility"
                    variant="underlined"
                ></v-select>


                <h3>{{__('Features')}}</h3>
                <v-divider class="mb-4"></v-divider>


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
            visibilities: [{title: this.__('Public'), value: 1}, {title: this.__('Unlisted'), value: 0}],
            taxes: usePage().props.value.taxes,
            coupons: usePage().props.value.coupons,
            formData: useForm({
                name: '',
                description: '',
                trials: 0,
                monthly: 0,
                yearly: 0,
                visibility: 1,
                position: 0,
                features: [],
                taxes: [],
                coupons: [],

            }),
        }
    },

    methods: {
        submit() {
            this.loading = true;
            this.formData.post('/admin/plans/create');
        }
    }
}
</script>
