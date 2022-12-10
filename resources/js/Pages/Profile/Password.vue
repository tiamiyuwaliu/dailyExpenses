<template>
  <AuthenticatedLayout>

  </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,usePage, Link } from '@inertiajs/inertia-vue3';
import {useToast} from "vue-toastification";
import ConfirmDialog from "@/Components/ConfirmDialog.vue";

export default {
  components: {AuthenticatedLayout},
  mounted() {
    if (usePage().props.value.flash.message) {
      let toast = useToast();
      toast.success(usePage().props.value.flash.message)
    }


  },
  data() {
    return {

    }
  },
}
</script>