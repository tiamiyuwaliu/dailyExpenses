<template>
    <AdminLayout :title="__('Settings > Appearance')">

        <v-card>
            <template v-slot:title>
                {{__('Appearance')}}
            </template>

            <div class="pa-4">

                <v-row>
                    <v-col>
                        <v-row>
                            <v-col cols="10">
                                <v-file-input v-model="formData.uploadedLight" :label="__('Light logo')" variant="underlined"></v-file-input>
                            </v-col>
                            <v-col cols="2">
                                <v-img width="50" class="mt-4" :src="formData.logoLight"></v-img>
                            </v-col>
                        </v-row>
                    </v-col>

                    <v-col>
                        <v-row>
                            <v-col cols="10">
                                <v-file-input v-model="formData.uploadedDark" :label="__('Dark logo')" variant="underlined"></v-file-input>
                            </v-col>
                            <v-col cols="2">
                                <v-img  class="mt-4" width="50" :src="formData.logoDark"></v-img>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>


                <v-row>
                    <v-col cols="11">
                        <v-file-input v-model="formData.uploadedFavicon" :label="__('Favicon')" variant="underlined"></v-file-input>
                    </v-col>
                    <v-col cols="1">
                        <div class="float-right">
                            <v-img width="50" class="mt-3" :src="formData.favicon"></v-img>
                        </div>
                    </v-col>
                </v-row>

                <v-select
                    :label="__('Theme')"
                    :items="themes"
                    v-model="formData.theme"
                    variant="underlined"
                ></v-select>

                <v-textarea v-model="formData.customCss" :label="__('Custom CSS')" variant="underlined"></v-textarea>


                <v-btn :loading="isLoading" @click="submit" color="primary">
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
            themes: usePage().props.value.themes,
            formData: useForm({
                logoDark: usePage().props.value.logoDark,
                logoLight: usePage().props.value.logoLight,
                favicon: usePage().props.value.favicon,
                theme: usePage().props.value.theme,
                customCss: usePage().props.value.customCss,
                uploadedDark: [],
                uploadedLight: [],
                uploadedFavicon : []
            })
        }
    },
    methods: {
        submit() {
            this.isLoading = true;
            this.formData.post('/admin/settings/appearance')
        }
    }
}
</script>
