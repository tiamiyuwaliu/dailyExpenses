<template >
    <v-card id="admin-container">

        <v-layout>
            <v-navigation-drawer
                v-model="drawer"
                :rail="rail"
                expand-on-hover
                rail-width="70"
                location="start"

                class=""
            >
                <v-btn
                    class="navigation-toggle d-none d-md-block"
                    color="primary"
                    size="x-small"
                    icon="mdi-chevron-left"
                    @click="toggleDrawer"
                ></v-btn>
                <v-list-item
                    :prepend-avatar="avatar"
                    :title="user.name"
                    nav
                    class="ps-5 pe-3 pt-4 pb-4"
                >
                </v-list-item>
                <custom-scrollbar direction="vertical" class="side-menu">


                    <v-list v-model:opened="open" class=" pl-0 pr-0" density="compact" nav>
                        <div v-for="menu in menus" :key="menu.title">


                            <div v-for="item in menu.menus" :key="item.title">
                                <div v-if="item.sub !== undefined">
                                    <v-list-group :value="item.title" >
                                        <template v-slot:activator="{ props }">
                                            <v-list-item
                                                v-bind="props"
                                                :prepend-icon="item.icon"
                                                :title="item.title"
                                            ></v-list-item>
                                        </template>
                                        <div class="bg-grey-lighten-5">
                                            <Link v-for="itemSub in item.sub" :key="itemSub.title" :href="itemSub.link">
                                                <v-list-item class="rounded-0" :class="($page.url === itemSub.link) ? 'active': null"   :prepend-icon="itemSub.icon" :title="itemSub.title"></v-list-item>
                                            </Link>
                                        </div>
                                    </v-list-group>
                                </div>
                                <div v-else>
                                    <Link :href="item.link" class="grey">
                                        <v-list-item  class="rounded-0" :class="($page.url.search(item.link) === 0) ? 'active': null"  :prepend-icon="item.icon" :title="item.title"></v-list-item>
                                    </Link>
                                </div>
                            </div>


                            <v-divider class="mt-3 mb-3 " v-if="menu.divider"></v-divider>
                        </div>
                    </v-list>
                </custom-scrollbar>

               <div class="ps-5 pe-5">
                   <v-btn
                       size="x-small"
                       class="drawer-on-rail"
                       variant="outlined"
                       icon="mdi-help"
                       color="primary"
                   ></v-btn>
                   <v-btn class="d-block w-100 drawer-on-hovering" variant="outlined" color="primary" >
                       {{__('Do you need help?')}}
                   </v-btn>
               </div>
            </v-navigation-drawer>
            <v-main style="height: 100vh;" class="bg-grey-lighten-5">
                <div class="header clearfix pt-0 pb-0 pt-lg-3">
                    <v-container class=" clearfix">
                        <div class="float-left">
                            <v-btn
                                class="d-inline d-lg-none"
                                variant="normal"
                                icon="mdi-menu"
                                color="grey"
                                @click="openMenu"
                            ></v-btn>
                            <h3 class="d-none d-sm-inline">{{title}}</h3>
                        </div>
                        <div class="float-right">
                            <div class="d-flex flex-row">
                                <a target="_blank" :href="route('home')">
                                    <v-btn
                                        variant="normal"
                                        icon="mdi-earth-arrow-right"
                                        color="grey"
                                    ></v-btn>
                                </a>

                                <v-btn
                                    variant="normal"
                                    class="ml-2"
                                    @click="toggleTheme"
                                    icon="mdi-invert-colors"
                                    :color="theme === 'dark' ? 'primary' : 'grey'"
                                ></v-btn>

                                <a :href="route('logout')">
                                    <v-btn
                                        variant="normal"
                                        class="ml-2"
                                        icon="mdi-location-exit"
                                        color="grey"
                                    ></v-btn>
                                </a>
                            </div>
                        </div>
                    </v-container>


                </div>

                <custom-scrollbar direction="vertical" class="main-content ">
                    <div class="d-flex flex-column" style="min-height: calc(100vh - 100px)">
                        <v-container class="flex-grow-1">
                            <slot />
                        </v-container>

                        <div class="footer">
                            <v-container  >
                                <div class="d-flex flex-row">
                                    <div class="flex-grow-1">
                                        <p class="text-body-2">{{__('Copyright')}} © {{year}} {{site_title}}.</p>
                                        <p class="text-body-2">{{__('Powered by')}} {{site_title}}</p>
                                    </div>
                                    <div class="">
                                        <v-menu>
                                            <template v-slot:activator="{ props }">
                                                <v-btn
                                                    variant="flat"
                                                    prepend-icon="mdi-web"
                                                    v-bind="props"
                                                >
                                                    {{locale}}
                                                </v-btn>
                                            </template>
                                            <v-list>
                                                <v-list-item
                                                    v-for="language in languages"
                                                    :key="language.value"

                                                >
                                                    <a :href="route('set-locale', {locale: language.value})">
                                                        <v-list-item-title>{{ language.title }}</v-list-item-title>
                                                    </a>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>
                                    </div>
                                </div>
                            </v-container>
                        </div>

                    </div>

                </custom-scrollbar>

            </v-main>
        </v-layout>
    </v-card>

</template>

<script>
import { Link, usePage } from '@inertiajs/inertia-vue3';
import { useTheme } from 'vuetify'
export default {
    components: {Link},
    props: {
        title: String
    },
    setup() {
        const themeObj = useTheme()
        var theme = usePage().props.value.config.theme;
        if (localStorage.getItem('theme')) theme = localStorage.getItem('theme')
        themeObj.global.name.value = theme;
        return {
            themeObj,
        }
    },
    data() {
        let data = {
            drawer: (window.innerWidth > 600) ,
            open: [],
            year: new Date().getFullYear(),
            theme: this.themeObj.global.name.value,
            menus: usePage().props.value.admin_menu,
            site_title: usePage().props.value.config.site_title,
            rail: (localStorage.getItem('drawer') ? Boolean(Number(localStorage.getItem('drawer'))) : false),
            languages: usePage().props.value.languages,
            locale: usePage().props.value.locale,
            user: usePage().props.value.auth.user,
            avatar: usePage().props.value.auth.avatar
        };
        console.log(data)
        for (let i=0;i<data.menus.length;i++) {
            let items = data.menus[i];
            for(let u=0;u<items.menus.length;u++) {
                let menu = items.menus[u];
                if (this.$page.url.search(''+menu.link+'') === 0) {
                    data.open.push(menu.title);
                }
            }
        }
        return data;
    },

    methods: {
        toggleTheme: function() {
            this.themeObj.global.name.value = this.themeObj.global.current.value.dark ? 'light' : 'dark'
            this.theme = this.themeObj.global.name.value;
            localStorage.setItem('theme', this.theme);
        },
        toggleDrawer: function() {
            localStorage.setItem('drawer', this.rail ? '0' : '1');
            this.rail = !this.rail;
        },
        openMenu: function() {
            this.drawer = true;
        }
    }
}
</script>
