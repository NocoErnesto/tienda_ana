<template>
  <div>
    <b-row class="auth-inner m-0">
      <!-- Brand logo-->
      <b-link class="brand-logo">
        <!-- <vuexy-logo /> -->
        <!-- <b-img :src="require('@/assets/images/logo/LogoP.png')" /> -->
        <h1 class="brand-text text-primary ml-1">Mi Gerente Digital</h1>
      </b-link>
      <!-- /Brand logo-->

      <!-- Left Text-->
      <b-col lg="7" class="d-none d-lg-flex align-items-center p-50">
        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
          <b-img fluid :src="imgUrl" alt="Login V2" />
        </div>
      </b-col>
      <!-- /Left Text-->

      <!-- Login-->

      <!-- /Login-->
    </b-row>
  </div>
</template>
  
<script>
/* eslint-disable global-require */
import { ValidationProvider, ValidationObserver } from "vee-validate";
import VuexyLogo from "@core/layouts/components/Logo.vue";

// import useJwt from '@/auth/jwt/useJwt'
// import { getHomeRouteForLoggedInUser } from '@/auth/utils'
import {
  BRow,
  BCol,
  BLink,
  BFormGroup,
  BFormInput,
  BInputGroupAppend,
  BInputGroup,
  BFormCheckbox,
  BCardText,
  BCardTitle,
  BImg,
  BForm,
  BButton,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import { required, email } from "@validations";
import { togglePasswordVisibility } from "@core/mixins/ui/forms";
import store from "@/store/index";
import navMenuItems from "@/navigation/vertical";
// import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default {
  components: {
    BRow,

    BCol,

    BLink,
    BFormGroup,
    BFormInput,
    BInputGroupAppend,
    BInputGroup,
    BFormCheckbox,
    BCardText,
    BCardTitle,
    BImg,
    BForm,
    BButton,
    VuexyLogo,
    ValidationProvider,
    ValidationObserver,
  },
  directives: {
    Ripple,
  },
  mixins: [togglePasswordVisibility],
  data() {
    return {
      aHabilatado: true,
      bHabilatado: true,
      cHabilatado: true,
      dHabilatado: true,
      eHabilatado: true,
      fHabilatado: true,
      gHabilatado: true,
      hHabilatado: true,
      iHabilatado: true,
      jHabilitado: true,
      kHabilitado: true,
      lHabilitado: true,
      // aHabilatado: false,
      // bHabilatado: false
      // cHabilatado: false,
      // dHabilatado: false,
      variant: "outline-success",
      status: "",
      usuario: "",
      email: "",
      password: "",
      sideImg: require("@/assets/images/pages/login-v2.svg"),
      required,
      email,
      token: "",
      acceso: "",
      idUsuario: "",
      perfilUsuario: "",
    };
  },
  computed: {

    imgUrl() {
      if (store.state.appConfig.layout.skin === "dark") {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        this.sideImg = require("@/assets/images/pages/login-v2-dark.svg");
        return this.sideImg;
      }
      return this.sideImg;
    },


  },
  mounted() {
    let me = this;

  },

  methods: {
    
  }
};
</script>
  
<style lang="scss">
@import "@resources/scss/vue/pages/page-auth.scss";
@import "~@resources/scss/vue/libs/vue-sweetalert.scss";
</style>
  