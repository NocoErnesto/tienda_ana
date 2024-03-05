<template>
  <div class="navbar-container d-flex content align-items-center">
    <div>
      <b-modal ref="frm-modifica" size="lg" centered title="Editar Usuario" scrollable @ok="modificaUsuario"
        ok-title="Guardar" ok-variant="success" cancel-variant="danger" cancel-title="Cancelar">
        <b-form @submit.prevent="modificaUsuario">
          <b-row>
            <b-col>
              <b-form-group label="Usuario" label-for="Usuario">
                <b-form-input id="Usuario" v-model="email" placeholder="Usuario" />
              </b-form-group>
            </b-col>
          </b-row>
          <b-row>
            <b-col>
              <b-form-group label="Cambio de Password" label-for="password">
                <b-form-input id="password" type="password" v-model="password" placeholder="Cambio Password" />

              </b-form-group>
            </b-col>
          </b-row>
          <b-row>
          </b-row>
        </b-form>
      </b-modal>
    </div>
    <!-- Nav Menu Toggler -->
    <ul class="nav navbar-nav d-xl-none">
      <li class="nav-item">
        <b-link class="nav-link" @click="toggleVerticalMenuActive">
          <feather-icon icon="MenuIcon" size="21" />
        </b-link>
      </li>
    </ul>

    <!-- Left Col -->
    <div class="bookmark-wrapper align-items-center flex-grow-1 d-none d-lg-flex">
      <bookmarks />
    </div>
    <dark-Toggler class="d-none d-lg-block" />
    <b-navbar-nav class="nav align-items-center ml-auto">
      <b-nav-item-dropdown right toggle-class="d-flex align-items-center dropdown-user-link" style="width: fit-content;"
        class="dropdown-user">
        <template #button-content>
          <div class="d-sm-flex d-none user-nav">
            <span class="user-status " style="font-size: 12px;">{{ $store.state.app.NombreUsuario }}</span>
            <p class="user-name font-weight-bolder mb-0" style="font-size: 15px;">{{ $store.state.app.NombrePerfil }}</p>
          </div>

          <b-avatar size="40" variant="light-primary" badge :src="require('@/assets/images/avatars/90.png')"
            class="badge-minimal" badge-variant="success" />
        </template>

        <b-dropdown-item link-class="d-flex align-items-center" @click="LlamarModal">
          <feather-icon size="16" icon="KeyIcon" class="mr-50" />
          <span>Password</span>
        </b-dropdown-item>

        <!-- <b-dropdown-item link-class="d-flex align-items-center">
          <feather-icon size="16" icon="MailIcon" class="mr-50" />
          <span>Bandeja</span>
        </b-dropdown-item>

        <b-dropdown-item link-class="d-flex align-items-center">
          <feather-icon size="16" icon="CheckSquareIcon" class="mr-50" />
          <span>Tarea</span>
        </b-dropdown-item>

        <b-dropdown-item link-class="d-flex align-items-center">
          <feather-icon size="16" icon="MessageSquareIcon" class="mr-50" />
          <span>Chat</span>
        </b-dropdown-item> -->

        <!-- :to="{ name: 'auth-login' }" -->
        <b-dropdown-divider />

        <b-dropdown-item link-class="d-flex align-items-center" :to="{ name: 'auth-login' }" @change="cerrarSession">
          <feather-icon size="16" icon="LogOutIcon" class="mr-50" />
          <span>Cerrar sesión</span>
        </b-dropdown-item>
      </b-nav-item-dropdown>
    </b-navbar-nav>
  </div>
</template>


<script>

import {
  BModal,
  BLink,
  BNavbarNav,
  BNavItemDropdown,
  BDropdownItem,
  BDropdownDivider,
  BAvatar,
  BCol,
  BRow,
  BForm,
  BFormGroup,
  BFormInput
} from "bootstrap-vue";
import DarkToggler from "@core/layouts/components/app-navbar/components/DarkToggler.vue";
import Bookmarks from "@core/layouts/components/app-navbar/components/Bookmarks.vue";
import navMenuItems from "@/navigation/vertical";


export default {
  components: {
    BModal,
    BCol,
    BRow,
    BForm,
    BFormGroup,
    BFormInput,
    BLink,
    Bookmarks,
    BNavbarNav,
    BNavItemDropdown,
    BDropdownItem,
    BDropdownDivider,
    BAvatar,

    // Navbar Components
    DarkToggler,
  },
  data() {
    return {
      email: "",
      password: ""
    }
  },
  props: {
    toggleVerticalMenuActive: {
      type: Function,
      default: () => { },
    },
  },
  beforeDestroy() {
    console.log("beforeDestroy nav var")
    // this.$router.go(0)
    // this.$router.reload()

    this.$router
      .push({ path: '/Login' })
      .then(() => {
        localStorage.clear();
        this.$router.go()
      })
  },
  mounted() {
    this.email = this.$store.state.app.emailUsuario
   
  },
  methods: {

    redire() {
      let me = this;
      // me.$router;
      // this.$router.push("/");


      // $router.push({ name: 'Home' })
    },
    LlamarModal() {
      this.$refs["frm-modifica"].show();

    },
    modificaUsuario() {
      let me = this;
      const axios = require("axios").default;
      const params = new URLSearchParams();
      params.append("idusuario", this.$store.state.app.UsuarioId);
      params.append("email", me.email);
      if (me.password === "") {
        this.$swal({
          title: "HR Analytics",
          text: "El Campo password no puede ser vacio",
          icon: "danger",
          customClass: {
            confirmButton: "btn btn-danger",
          },
          showClass: {
            popup: 'animate__animated animate__flipInX',
          },
          buttonsStyling: true,
        });
        return
      }
      params.append("password", me.password);
      params.append("idperfil", this.$store.state.app.perfilUsuario);
      var url = "api/auth/ModificaUsuario";
      var a = "";
      axios
        .post(url, params)
        .then(function (response) {
          var resp = response.data;
          if (response.status === 201) {
            me.success("success");

          }

        })
        .catch((e) => {
          alert(e);
        });
    },

    success(variant, users) {
      // window.swal = require('sweetalert2')
      if (variant === "success") {
        this.$swal({
          title: "HR Analytics",
          text: "Operacion Realizada con Exito ",
          icon: variant,
          customClass: {
            confirmButton: "btn btn-success",
          },
          showClass: {
            popup: 'animate__animated animate__flipInX',
          },
          buttonsStyling: true,
        });
      } else {
        this.$swal({
          title: "HR Analytics",
          text: "No se Logro Realizar la Operación",
          icon: variant,
          customClass: {
            confirmButton: "btn btn-danger",
          },
          showClass: {
            popup: 'animate__animated animate__flipInX',
          },
          buttonsStyling: true,
        });
      }
    },
    cerrarSession() {

      let me = this;
      const axios = require("axios").default;
      const params = new URLSearchParams();
      // params.append('email', me.email);

      var url = "api/auth/logout";
      me.loaded = false;
      var a = "";

      axios
        .get(url, {
          headers: {
            Authorization: `Bearer ${this.$store.state.app.token}`,
          },
        })
        .then(function (response) {
          // me.$router.go(0);
          // 

          if (response.status === 200) {
            let me = this;

            localStorage.removeItem("token")
            localStorage.removeItem("idPerfil")

          }

        })
        .catch((e) => {
          e;
        });

    },
  },
};
</script>
