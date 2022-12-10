<template>
    <AdminLayout :title="__('Admin > Pages > Create')">
        <v-card>
            <template v-slot:title>
                {{ __('Create Page') }}
            </template>

            <div class="pa-4">
                <v-text-field :error="!!formData.errors.title" :error-messages="formData.errors.title"
                              :label="__('Title')" v-model="formData.title" variant="underlined"></v-text-field>
                <v-text-field :error="!!formData.errors.slug" :error-messages="formData.errors.slug"
                              :label="__('Slug')" v-model="formData.slug" variant="underlined"></v-text-field>

                <v-select
                    :label="__('Position')"
                    :items="positions"
                    v-model="formData.position"
                    variant="underlined"
                ></v-select>

                <div class="pt-4 pb-4">
                    <label class="mb-3 d-block">{{__('Content')}}</label>
                    <QuillEditor v-model:content="formData.detail" rows="5" theme="snow" content-type="html"  />
                </div>



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
            countries: usePage().props.value.countries,
            formData: useForm({
                title: '',
                slug: '',
                detail: '',
                position: 0
            }),
            positions: [{title: this.__('Header'), value: 2},{title: this.__('Footer'), value: 1}, {title: this.__('Hidden'), value: 0}]
        }
    },

    methods: {
        submit() {
            this.loading = true;
            this.formData.post('/admin/pages/create');
        }
    }
}
</script>
