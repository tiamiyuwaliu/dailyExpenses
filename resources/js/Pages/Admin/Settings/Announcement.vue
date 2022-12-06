<template>
    <AdminLayout :title="__('Settings > Announcement')">
        <v-card>


            <div class="pa-4">
                <v-tabs
                    v-model="tabs"
                    grow
                >
                    <v-tab value="option-1">
                        {{__('Guest')}}
                    </v-tab>
                    <v-tab value="option-2">
                        {{ __('User') }}
                    </v-tab>
                </v-tabs>

                <v-window v-model="tabs">
                    <v-window-item value="option-1" class="mt-3">
                        <v-textarea rows="3" v-model="formData.guest" :label="__('Content')" variant="underlined"></v-textarea>

                        <v-select
                            :label="__('Display Type')"
                            :items="options"
                            v-model="formData.guestType"
                            variant="underlined"
                        ></v-select>


                    </v-window-item>

                    <v-window-item value="option-2" class="mt-3">
                        <v-textarea rows="3" v-model="formData.user" :label="__('Content')" variant="underlined"></v-textarea>

                        <v-select
                            :label="__('Display Type')"
                            :items="options"
                            v-model="formData.userType"
                            variant="underlined"
                        ></v-select>
                    </v-window-item>
                </v-window>

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
                guest: usePage().props.value.guest,
                guestType: usePage().props.value.guestType,
                userType: usePage().props.value.userType,
                user: usePage().props.value.user,
            }),
            tabs: null,
            options: usePage().props.value.options
        }
    },

    methods: {
        submit() {
            this.isLoading = true;
            this.formData.post('/admin/settings/announcement')
        }
    }
}
</script>
