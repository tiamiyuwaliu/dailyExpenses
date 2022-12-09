<template>
    <div class="clearfix " :class="theme === 'dark' ? 'dark-theme' : null " id="auth-container">
        <div  class="auth-left float-left ">
          <custom-scrollbar direction="vertical" class="content hv-100 pa-12" >
            <div class="head clearfix mb-3">
              <div class="float-left">
                <img v-if="theme === 'light'" :src="logoLight"/>
              </div>
              <div class="float-right">
                <v-btn
                    variant="normal"
                    class="mt-2"
                    @click="toggleTheme"
                    icon="mdi-invert-colors"
                    :color="theme === 'dark' ? 'primary' : 'grey'"
                ></v-btn>

              </div>
            </div>
            <slot/>
          </custom-scrollbar>

        </div>
        <div class="auth-right float-right">
            <img  src="/images/auth.png"/>

          <div class="footer clearfix text-body-2">
            <div class="float-left">
              {{__('Copyright')}} © {{year}} {{__('All Rights Reserved')}}
            </div>
            <div class="float-right">
              <v-menu>
                <template v-slot:activator="{ props }">
                  <v-btn
                      variant="plain"
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
        </div>
    </div>
</template>

<script>

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
      year: new Date().getFullYear(),
      logoLight: usePage().props.value.config.lightLogo,
      darkLight: usePage().props.value.config.darkLogo,
      theme: this.themeObj.global.name.value,
      locale: usePage().props.value.locale,
      languages: usePage().props.value.languages,
    };
  },

  methods: {
    toggleTheme: function() {
      this.themeObj.global.name.value = this.themeObj.global.current.value.dark ? 'light' : 'dark'
      this.theme = this.themeObj.global.name.value;
      localStorage.setItem('theme', this.theme);
    },
  }
}
</script>
