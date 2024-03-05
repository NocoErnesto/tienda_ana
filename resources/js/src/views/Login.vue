<template>
  <div class="auth-wrapper auth-v2">
    <b-row class="auth-inner m-0">
      <!-- Brand logo-->
      <b-link class="brand-logo">
        <!-- <vuexy-logo /> -->
        <!-- <b-img :src="require('@/assets/images/logo/LogoP.png')" /> -->
        <h1 class="brand-text text-primary ml-1">Mi Gerente Digital</h1>
      </b-link>
      <!-- /Brand logo-->

      <!-- Left Text-->
      <b-col lg="8" class="d-none d-lg-flex align-items-center p-5">
        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
          <b-img fluid :src="imgUrl" alt="Login V2" />
        </div>
      </b-col>
      <!-- /Left Text-->

      <!-- Login-->
      <b-col lg="4" class="d-flex align-items-center auth-bg px-2 p-lg-5">
        <b-col sm="8" md="6" lg="12" class="px-xl-2 mx-auto">
          <b-img :src="require('@/assets/images/logo/logo2.png')" class="responsive-image" />
          <div style="height: 10px"></div>
          <b-card-title title-tag="h2" class="font-weight-bold mb-1">
            Bienvenido!!
          </b-card-title>
          <b-card-text class="mb-2">
            Por favor inicia sesión en tu cuenta
          </b-card-text>

          <!-- form -->
          <validation-observer>
            <b-form class="auth-login-form mt-2" @submit.prevent="login">
              <!-- email -->
              <b-form-group label="Usuario" label-for="login-email">
                <validation-provider #default="{ errors }" name="Email">
                  <b-form-input id="login-email" v-model="email" :state="errors.length > 0 ? false : null"
                    name="login-email" />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <!-- forgot password -->
              <b-form-group>
                <div class="d-flex justify-content-between">
                  <label for="login-password">Password</label>
                  <b-link :to="{ name: 'auth-forgot-password-v2' }">
                    <small>Olvidaste tu Password?</small>
                  </b-link>
                </div>
                <validation-provider #default="{ errors }" name="Password" rules="required">
                  <b-input-group class="input-group-merge" :class="errors.length > 0 ? 'is-invalid' : null">
                    <b-form-input id="login-password" v-model="password" :state="errors.length > 0 ? false : null"
                      class="form-control-merge" :type="passwordFieldType" name="login-password"
                      placeholder="············" />
                    <b-input-group-append is-text>
                      <feather-icon class="cursor-pointer" :icon="passwordToggleIcon" @click="togglePasswordVisibility" />
                    </b-input-group-append>
                  </b-input-group>
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <!-- checkbox -->
              <b-form-group>
                <b-form-checkbox id="remember-me" v-model="status" name="checkbox-1">
                  Recordar mi Constraseña
                </b-form-checkbox>
              </b-form-group>

              <!-- submit buttons -->
              <!-- v-on:click="agregar" -->
              <!-- :to="{ name: 'Remuneraciones' }"  -->
              <b-button type="submit" variant="primary" block>
                Ingresar
              </b-button>
            </b-form>
          </validation-observer>

          <!-- <b-card-text class="text-center mt-2">
            <span>No Tienes una Cuenta? </span>
            <b-link :to="{ name: 'Register-v1' }">
              <span>&nbsp;Crear Nueva Cuenta</span>
            </b-link>
          </b-card-text> -->

          <!-- divider -->
          <div class="divider my-2">
            <div class="divider-text">or</div>
          </div>

          <!-- social buttons -->
          <div class="auth-footer-btn d-flex justify-content-center">
            <b-button variant="facebook" href="https://www.facebook.com/MadepaBolivia/">
              <feather-icon icon="FacebookIcon" />
            </b-button>
            <!-- <b-button variant="twitter" href="javascript:void(0)">
              <feather-icon icon="TwitterIcon" />
            </b-button> -->
            <b-button variant="google" href="https://www.madepa.com.bo/">
              <feather-icon icon="GlobeIcon" />
            </b-button>
            <b-button variant="linkedin" href="https://www.linkedin.com/company/madepa/">
              <feather-icon icon="LinkedinIcon" />
            </b-button>
          </div>
        </b-col>
      </b-col>
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
import searchAndBookmarkData from "../@core/layouts/components/app-navbar/search-and-bookmark-data";

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
      nombrePerfil: "",
      emailUsuario: "",
    };
  },

  computed: {
    passwordToggleIcon() {
      return this.passwordFieldType === "password" ? "EyeIcon" : "EyeOffIcon";
    },
    imgUrl() {
      if (store.state.appConfig.layout.skin === "dark") {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        this.sideImg = require("@/assets/images/pages/login-v2-dark.svg");
        return this.sideImg;
      }
      return this.sideImg;
    },
  },

  setup() {
    localStorage.removeItem("idPerfil");
  },
  mounted() {

  },
  beforeDestroy() {

  },
  methods: {
    PermisoOperacion() {

      let me = this;
      const axios = require("axios").default;
      const params = new URLSearchParams();
      params.append("idrol", localStorage.getItem("idrol"));
      var url = "api/auth/PermisoOperacion";
      me.loaded = false;
      var a = "";

      axios
        .post(url, params)
        .then(function (response) {
          var resp = response.data;

          if (resp.length === 0) {
            me.$store.commit('app/setbotonCrear', true)
            me.$store.commit('app/setbotonEditar', true)
            me.$store.commit('app/setbotonEliminar', true)
            me.$store.commit('app/setbotonVer', true)
          } else {
            for (let i = 0; i < resp.length; i++) {

              var operacion = resp[i].idoperacion
              if (parseInt(operacion) === 1) {
                me.$store.commit('app/setbotonCrear', false)
              }

              if (parseInt(operacion) === 2) {
                me.$store.commit('app/setbotonEditar', false)
              }

              if (parseInt(operacion) === 3) {
                me.$store.commit('app/setbotonEliminar', false)
              }
              if (parseInt(operacion) === 4) {
                me.$store.commit('app/setbotonVer', false)

              }
            }
          }
        })
        .catch((e) => {
          alert(e)
        });
    },
 

    habilitaMenu() {
      let me = this;
      const axios = require("axios").default;
      const params = new URLSearchParams();
      params.append("idperfil", me.perfilUsuario);
      var url = "api/auth/AccesoMenu";
      me.loaded = false;
      axios
        .post(url, params)
        .then(function (response) {
          var resp = response.data;

          for (let i = 0; i < resp.length; i++) {
            const index = navMenuItems.findIndex(
              (x) => x.title === resp[i].nombre_menu
            );
            if (index === -1) {

              navMenuItems.push({
                title: resp[i].nombre_menu,
                icon: resp[i].m_icono,
                children: [
                  {
                    title: resp[i].nombre_submenu,
                    route: resp[i].ruta,
                    icon: resp[i].sm_icono,
                  },
                ],
              });
          
              searchAndBookmarkData.pages.data.push({
                title:
                  navMenuItems[navMenuItems.length - 1].children[
                    navMenuItems[navMenuItems.length - 1].children.length - 1
                  ].title,
                route: {
                  name: navMenuItems[navMenuItems.length - 1].children[
                    navMenuItems[navMenuItems.length - 1].children.length - 1
                  ].route,
                },

                icon: navMenuItems[navMenuItems.length - 1].children[
                  navMenuItems[navMenuItems.length - 1].children.length - 1
                ].icon,
                isBookmarked: false,
              });
            }
            else {
              navMenuItems[navMenuItems.length - 1].children.push({
                title: resp[i].nombre_submenu,
                route: resp[i].ruta,
                icon: resp[i].sm_icono,
              });

              searchAndBookmarkData.pages.data.push(
                {
                  title: navMenuItems[navMenuItems.length - 1].children[navMenuItems[navMenuItems.length - 1].children.length - 1].title,
                  route: { name: navMenuItems[navMenuItems.length - 1].children[navMenuItems[navMenuItems.length - 1].children.length - 1].route, },
                  icon: navMenuItems[navMenuItems.length - 1].children[navMenuItems[navMenuItems.length - 1].children.length - 1].icon,
                  isBookmarked: false,
                });
            }
          }
          me.success("success", me.usuario);
          me.PermisoOperacion()
          me.$router.push("bienvenido");
        })
        .catch((e) => {
          alert("falla al obtener datos menu" + e);
          me.$router.push("bienvenido");
        });
    },

    success(variant, users) {
      // window.swal = require('sweetalert2')
      if (variant === "success") {
        this.$swal({
          title: "Mi Gerente Digital",
          text: "BIENVENIDO " + users,
          icon: variant,
          customClass: {
            confirmButton: "btn btn-success",
          },
          showClass: {
            popup: "animate__animated animate__bounceIn",
          },
          buttonsStyling: true,
        });
      } else {
        this.$swal({
          title: "HR Analytics",
          text: "Sin Autorizaciòn",
          icon: variant,
          customClass: {
            confirmButton: "btn btn-danger",
          },
          showClass: {
            popup: "animate__animated animate__tada",
          },
          buttonsStyling: true,
        });
      }
    },
    UsuarioAlerta(variant, msj) {
      let title, confirmButtonClass, showClass;

      if (variant === "success") {
        title = "Buen Trabajo";
        confirmButtonClass = "btn btn-success";
        showClass = "animate__animated animate__bounceIn";
      } else if (variant === "error") {
        title = "¡Error!";
        confirmButtonClass = "btn btn-danger";
        showClass = "btn btn-danger animate__animated animate__rubberBand";
      } else if (variant === "warning") {
        title = "Precaución";
        confirmButtonClass = "btn btn-warning";
        showClass = "animate__animated animate__wobble";
      } else {
        // Puedes agregar más casos según tus necesidades.
      }

      this.$swal({
        title: title,
        text: msj,
        icon: variant,
        customClass: {
          confirmButton: confirmButtonClass,
        },
        showClass: {
          confirmButton: showClass,
        },
        buttonsStyling: true,
      });
    },
    login() {
      var msg = "";
      let me = this;
      const axios = require("axios").default;
      const params = new URLSearchParams();
      params.append("email", me.email);
      params.append("password", me.password);
      var url = "api/auth/login";
      me.loaded = false;
      var a = "";
      axios
        .post(url, params)
        .then(function (response) {
          console.log(response.data);
          var resp = response.data;
          a = resp.access_token;
          localStorage.setItem("token", resp.access_token);
          me.acceso = resp.message;
          me.token = a;
          if (response.status === 200) {
            me.users();


          }
        })
        .catch((e) => {
          me.accesos() + e;
        });
      //forma de optener los datos deñ menu
    },

    users() {
      let me = this;
      const axios = require("axios").default;
      const params = new URLSearchParams();
      // params.append('email', me.email);

      var url = "api/auth/user";
      me.loaded = false;
      var a = "";

      axios
        .get(url, {
          headers: {
            Authorization: `Bearer ${me.token}`,
          },
        })
        .then(function (response) {
          var resp = response.data;
          if (response.status === 200) {
            me.usuario = resp.name;
            me.idUsuario = resp.id;
            me.perfilUsuario = resp.idrol;
            me.nombrePerfil = resp.nombre_rol;
            me.emailUsuario = resp.email;

            localStorage.setItem("idrol", me.perfilUsuario);
            localStorage.setItem("nombre_rol", me.nombrePerfil)
            me.accesos();
            me.PermisoOperacion()
            me.DatosEmpresa()
          }
        })
        .catch((e) => {
          // me.accesos() + e;
          console.log(e.message());
        });
    },
    accesos() {
      let me = this;

      if (me.acceso == "Exito" && me.token != "") {

        this.$store.state.app.UsuarioId = me.idUsuario
        this.$store.state.app.emailUsuario = me.emailUsuario
        this.$store.state.app.perfilUsuario = localStorage.getItem("idrol")
        this.$store.state.app.NombrePerfil = me.nombrePerfil
        this.$store.state.app.NombreUsuario = me.usuario
        this.$store.state.app.token = me.token
        this.$store.state.app.NombreEmpresa = me.NombreEmpresa
        me.habilitaMenu();
      } else {
        me.success("danger", me.usuario);
      }
    },


    DatosEmpresa() {
      var msg = "";
      let me = this;
      const axios = require("axios").default;
      const params = new URLSearchParams();
      var url = "api/auth/DatosEmpresa";
      me.loaded = false;
      var a = "";
      axios
        .get(url)
        .then(function (response) {
          var resp = response.data;
          
          me.$store.dispatch('app/cambiaNombreEmpresa', resp[0].emNombre)
          me.$store.dispatch('app/cambiaDireccionEmpresa', resp[0].emDireccion)
          me.$store.dispatch('app/cambiaTelefonoEmpresa', resp[0].emTelefono)
          me.$store.dispatch('app/cambiaLogoEmpresa', resp[0].emLogo)
          me.$store.dispatch('app/cambiaNitEmpresa', resp[0].emNit)


        })
        .catch((e) => {
          if (e.response) {
            // Si la respuesta del servidor contiene información de error
            console.error('Error del servidor: ' + e.response.data.error);
          } else {
            // Si la respuesta es undefined o no contiene información de error
            console.error('Error en la solicitud: ' + e.message);
          }
        });
      //forma de optener los datos deñ menu

    },

  },
};
</script>
<style lang="scss">
.responsive-image {
  width: 100%;
  height: auto;
  max-width: 100%;
}

@import "@resources/scss/vue/pages/page-auth.scss";
@import "~@resources/scss/vue/libs/vue-sweetalert.scss";
</style>
