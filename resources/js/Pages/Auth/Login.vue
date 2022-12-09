
<template>
    <GuestLayout>
      <h2 class="mt-5 d-block font-weight-light">Hi Welcome back!</h2>
      <p class="text-caption font-weight-light text-grey">Provide your email address and password to login</p>


     <div class="mt-13">
       <v-text-field :label="__('Email address')" :error="!!formData.errors.email" :error-messages="formData.errors.email" v-model="formData.email" variant="solo"></v-text-field>

       <v-text-field type="password" class="mt-2" :error="!!formData.errors.password" :error-messages="formData.errors.password" v-model="formData.password" :label="__('Password')" variant="solo"></v-text-field>

       <div class="mt-6 clearfix">
         <div class="float-left">
           <v-checkbox v-model="formData.remember" :label="__('Keep me signed in')"></v-checkbox>
         </div>
         <div class="float-right">
           <Link :href="route('home')" class="d-block mt-3">{{__('Forgot password?')}}</Link>
         </div>
       </div>

       <v-btn @click="login" :loading="loading" block color="primary" size="x-large" prepend-icon="mdi-lock" variant="flat">
         {{__('Log in')}}
       </v-btn>

       <div class="mt-16 text-center text-body-2">
            {{__("Don't have an account yet?")}} <Link :href="route('register')">{{__('Signup here')}}</Link>
       </div>
     </div>

    </GuestLayout>
</template>

<script >
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {Link, useForm, usePage} from '@inertiajs/inertia-vue3';
import {useToast} from "vue-toastification";

export default {
  components: {GuestLayout, Link},
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
       formData: useForm({
         email: '',
         password: '',
         remember: ''
       })
     };
  },

  methods: {
    login() {
      this.loading = true;
      this.formData.post('/login');
    }
  }
}
</script>

