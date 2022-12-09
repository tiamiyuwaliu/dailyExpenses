<script>
import { ref } from 'vue';
import {Link, usePage} from '@inertiajs/inertia-vue3';
import {useTheme} from "vuetify";
export default  {
  components: {Link},
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
    return {
      logoLight: usePage().props.value.config.lightLogo,
      darkLight: usePage().props.value.config.darkLogo,
      theme: this.themeObj.global.name.value,
      locale: usePage().props.value.locale,
      languages: usePage().props.value.languages,
      drawer: (window.innerWidth > 600) ,
      rail: (localStorage.getItem('drawer') ? Boolean(Number(localStorage.getItem('drawer'))) : false),
      user: usePage().props.value.auth.user,
      avatar: usePage().props.value.auth.avatar,
      open: [],
      menus: usePage().props.value.user_menu,
    }
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
    },
  }
}
</script>

<template>
  <div id="dashboard-container" :class="theme === 'dark' ? 'dark-theme' : null ">
      <div class="header clearfix">
        <div class="float-left">
          <v-btn prepend-icon="mdi-home" color="white" variant="flat">
              {{__('Home')}}
          </v-btn>

          <v-btn prepend-icon="mdi-home" color="white" variant="plain">
            {{__('Expenses')}}
          </v-btn>

          <v-btn prepend-icon="mdi-home" color="white" variant="plain">
            {{__('Reports')}}
          </v-btn>
        </div>
        <div class="float-right">
          <div class="d-flex flex-row">

            <v-btn
                variant="normal"
                class="ml-2"
                @click="toggleTheme"
                icon="mdi-invert-colors"
                :color="theme === 'dark' ? 'primary' : 'white'"
            ></v-btn>

            <a :href="route('logout')">
              <v-btn
                  variant="normal"
                  class="ml-2"
                  icon="mdi-location-exit"
                  color="white"
              ></v-btn>
            </a>
          </div>
        </div>

        <div class="add-button">
          <v-menu :offset="[10,80]" width="200" offset-x="40">
            <template v-slot:activator="{ props }">
              <v-btn icon="mdi-plus" variant="flat" color="warning" v-bind="props"></v-btn>
            </template>

            <v-list density="compact">
              <v-list-item @click="goTo(route('home'))" >
                <v-list-item-title>{{ __('Add Client') }}</v-list-item-title>
              </v-list-item>
              <v-list-item @click="goTo(route('home'))">
                <v-list-item-title>{{ __('Add Expense') }}</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </div>

      </div>

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

          <div class="d-flex flex-column" style="min-height: calc(100vh - 150px);">
            <v-list v-model:opened="open" class=" pl-0 pr-0 flex-grow-1" density="compact" nav>
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
            <div class="pa-6 text-center">
              <img src="/images/help.png" class="w-75"/>
              <h5 class="mb-2">{{__('Do you Need help?')}}</h5>
              <v-btn>
                {{__('Get help')}}
              </v-btn>
            </div>
          </div>

        </custom-scrollbar>
      </v-navigation-drawer>
      <v-main style="height: 100vh;" class="bg-grey-lighten-5">
        <slot/>
      </v-main>
    </v-layout>
      <slot/>
  </div>
</template>
