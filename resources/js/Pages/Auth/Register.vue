<template>
    <GuestLayout>
      <h2 class="mt-5 d-block font-weight-light">Create your account!</h2>
      <p class="text-caption font-weight-light text-grey">Provide your name, email address and choose a password</p>

      <div class="mt-13">
        <v-text-field :label="__('Your name')" :error="!!formData.errors.name" :error-messages="formData.errors.name" v-model="formData.name" variant="solo"></v-text-field>

        <v-text-field :label="__('Email address')" :error="!!formData.errors.email" :error-messages="formData.errors.email" v-model="formData.email" variant="solo"></v-text-field>

        <v-text-field type="password" class="mt-2" :error="!!formData.errors.password" :error-messages="formData.errors.password" v-model="formData.password" :label="__('Password')" variant="solo"></v-text-field>
        <v-text-field type="password" class="mt-2" :error="!!formData.errors.password_confirmation" :error-messages="formData.errors.password_confirmation" v-model="formData.password_confirmation" :label="__('Confirm password')" variant="solo"></v-text-field>


        <v-btn @click="login" :loading="loading" block color="primary" size="x-large" prepend-icon="mdi-lock" variant="flat">
          {{__('Register')}}
        </v-btn>

        <div class="mt-16 text-center text-body-2">
          {{__("Already have an account yet?")}} <Link :href="route('login')">{{__('Log in')}}</Link>
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
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      })
    };
  },

  methods: {
    login() {
      this.loading = true;
      this.formData.post('/register');
    }
  }
}
</script>

