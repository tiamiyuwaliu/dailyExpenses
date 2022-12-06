<template>
    <AdminLayout :title="__('Admin > Plan > Create')">
        <v-card>
            <template v-slot:title>
                {{ __('Create Plan') }}
            </template>

            <div class="pa-4">

                <v-select
                    :label="__('Status')"
                    :items="statuses"
                    v-model="formData.status"
                    variant="underlined"
                ></v-select>

                <v-text-field :error="!!formData.errors.name" :error-messages="formData.errors.name"
                              :label="__('Name')" v-model="formData.name" variant="underlined"></v-text-field>
                <v-text-field
                    :label="__('Description')" v-model="formData.description" variant="underlined"></v-text-field>

                <v-text-field
                    v-if="plan.is_free !== 1"
                    :label="__('Trial days')" v-model="formData.trials" variant="underlined"></v-text-field>

                <v-row v-if="plan.is_free !== 1">
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
                    v-if="plan.is_free !== 1"
                    :label="__('Tax rates')"
                    multiple
                    :items="taxes"
                    v-model="formData.taxes"
                    variant="underlined"
                ></v-select>
                <v-select
                    multiple
                    v-if="plan.is_free !== 1"
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
    data() {
        return {
            loading: false,
            visibilities: [{title: this.__('Public'), value: 1}, {title: this.__('Unlisted'), value: 0}],
            statuses: [{title: this.__('Active'), value: 1}, {title: this.__('Disabled'), value: 0}],
            taxes: usePage().props.value.taxes,
            coupons: usePage().props.value.coupons,
            plan: usePage().props.value.plan,
            formData: useForm({
                name: usePage().props.value.plan.name,
                description: usePage().props.value.plan.description,
                trials: usePage().props.value.plan.trial_days,
                monthly: usePage().props.value.plan.monthly_price,
                yearly: usePage().props.value.plan.yearly_price,
                visibility: usePage().props.value.plan.visibility,
                position: usePage().props.value.plan.position,
                features: usePage().props.value.plan.features,
                taxes: usePage().props.value.plan.taxes,
                coupons: usePage().props.value.plan.coupons,
                status: usePage().props.value.plan.status,
            }),
        }
    },

    methods: {

        submit() {
            this.loading = true;
            this.formData.post('/admin/plans/edit/'+this.plan.id);
        }
    }
}
</script>
