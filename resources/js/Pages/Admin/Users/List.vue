<template>
    <AdminLayout :title="__('Admin > Users')">
        <v-row
            align="start"
            class="dashboard-statistics mb-4"
        >
            <v-col v-for="stat in stats" :key="stat.title" cols="12" md="4"  class="each pa-0 ">
                <v-hover v-slot="{ isHovering, props }">
                    <v-card
                        v-bind="props"
                        :class="isHovering ? 'elevation-lg' : 'elevation-sm'"
                        class="ma-2 pa-4 rounded-lg" >
                        <div class="clearfix">
                            <div class="float-left">
                                <v-btn
                                    variant="tonal"
                                    :icon="stat.icon"
                                    :color="isHovering? 'primary' : 'grey'"
                                ></v-btn>
                            </div>
                            <div class="float-right">
                                <h3 class="text-h3 font-weight-thin " :class="isHovering ? 'text-dark' : 'text-grey'">{{stat.count}}</h3>
                            </div>
                        </div>

                        <div class="mt-2">
                            <h4 class="font-weight-light title pb-3 ">{{stat.title}}</h4>
                        </div>
                    </v-card>
                </v-hover>
            </v-col>

        </v-row>

        <v-card>
            <template class="clearfix" v-slot:title>
                {{ __('Users') }}
                <div class="float-right">
                    <Link :href="route('users.create')">
                        <v-btn
                            color="primary">
                            {{ __('New user') }}
                        </v-btn>
                    </Link>
                </div>
            </template>
            <v-table>
                <thead>
                <tr>
                    <th class="text-left" style="width:40%">
                        {{ __('User') }}
                    </th>
                    <th class="text-left" style="width:20%">
                        {{ __('Details') }}
                    </th>
                    <th class="text-left" style="width:20%">
                        {{ __('Status') }}
                    </th>
                    <th class="text-right" style="width:20%">
                        {{ __('Actions') }}
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users.data" :key="user.id">
                    <td>
                        <div class="d-flex flex-no-wrap pt-2 pb-2 ">
                            <v-avatar>
                                <v-img
                                    :src="user.avatar"
                                    alt="John"
                                ></v-img>
                            </v-avatar>
                            <div class="ml-2 ">
                                <h4 class="font-weight-black ">{{user.name}}</h4>
                                <h4 class="font-weight-regular text-grey-darken-2">{{user.email}}</h4>

                            </div>
                        </div>

                    </td>
                    <td>
                        <v-btn icon="mdi-flag" variant="plain"></v-btn>
                        <v-btn icon="mdi-calendar-account-outline" color="secondary" variant="plain"></v-btn>
                    </td>
                    <td>
                        <v-chip v-if="user.status" color="success">{{__('Active')}}</v-chip>
                        <v-chip v-if="!user.status" color="danger">{{__('Not active')}}</v-chip>
                    </td>
                    <td class="text-right">
                        <v-menu
                            open-on-hover
                        >
                            <template v-slot:activator="{ props }">
                                <v-btn
                                    icon="mdi-dots-vertical"
                                    v-bind="props"
                                ></v-btn>
                            </template>

                            <v-list>
                                <v-list-item>
                                    <Link :href="user.editUrl" >
                                        <v-list-item-title>{{ __('Edit') }}</v-list-item-title>
                                    </Link>
                                </v-list-item>
                                <v-list-item @click="deleteUser(user.deleteUrl)">
                                    <v-list-item-title>{{ __('Delete') }}</v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </td>
                </tr>
                </tbody>
            </v-table>

            <div class="d-flex flex-row pa-4  pagination-container">
                <Link :disabled="link.url === null" v-for="link in users.links" :href="link.url" class="ma-1 pa-0 ps-0 pe-0">
                    <v-btn
                        class="rounded-circle ma-0 pa-0"
                        variant="flat"
                        size="large"
                        :color="link.active === true ? 'grey' : ''"

                        v-html="link.label"
                    >
                    </v-btn>
                </Link>
            </div>
        </v-card>

        <ConfirmDialog ref="confirm"/>
    </AdminLayout>
</template>

<script>
import AdminLayout from '@/Pages/Admin/Layout/Base.vue';
import {usePage, Link} from '@inertiajs/inertia-vue3';
import {useToast} from "vue-toastification";
import ConfirmDialog from "@/Components/ConfirmDialog.vue";

export default {

    components: {AdminLayout, Link, ConfirmDialog},
    mounted() {
        if (usePage().props.value.flash.message) {
            let toast = useToast();
            toast.success(usePage().props.value.flash.message)
        }


    },
    data() {
        return {
            stats: this.$page.props.stats,
            users: usePage().props.value.users,
        }
    },
    methods: {
        async deleteUser(url) {
            if (await this.$refs.confirm.open(this.__("Confirm Delete"), "Do you really want to delete this user?")) {
                this.$inertia.visit(url);
            }

        }
    }
}
</script>
