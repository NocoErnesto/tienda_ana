   
<template>
  <section>
    <div>
      <b-modal ref="frm-modifica-usuario" size="lg" ok-only centered title="Editar Usuario" scrollable
        @ok="modificaUsuario" ok-title="Guardar" ok-variant="success" cancel-variant="danger" cancel-title="Cancelar">
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
              <b-form-group label="Password" label-for="password">
                <b-form-input id="password" type="password" v-model="password" placeholder="Password" />
                <b-form-text>Enter a Valid Email</b-form-text>
              </b-form-group>
            </b-col>
          </b-row>
          <b-row>
            <!-- occupation  @change="obtenerDato"-->
            <b-col>
              <b-form-group label="Perfil" label-for="h-perfil">
                <b-form-select style="width: fit-content" v-model="selectedPerfil" :options="aDataPerfil" :state="selectedPerfil === null ? false : true
                  " />
              </b-form-group>
            </b-col>
            <!-- checkbox -->
            <b-col>
              <b-form-group>
                <b-form-checkbox id="checkbox-9" name="checkbox-9" value="Remember_me">
                  Remember me
                </b-form-checkbox>
              </b-form-group>
            </b-col>
          </b-row>
        </b-form>
      </b-modal>
    </div>
    <div>
      <b-overlay id="overlay-background" style="height: max-content" :variant="variant" :opacity="opacity" :blur="blur">
        <b-card>
          <b-card-title style="text-align: center">
            Listado de Usuarios
          </b-card-title>

          <b-card-body>
            <!-- Boton Modal  -->
            <div style="height: 50px">
              <b-row class="match-height">
                <b-col>
                  <div>
                    <div>
                      <div>
                        <!-- Boton Modal -->
                        <b-button v-ripple.400="'rgba(113, 102, 240, 0.15)'" v-b-modal.frm-nps variant="success">
                          Nuevo Registro
                        </b-button>
                      </div>
                      <!-- Formulario Modal -->
                      <b-modal id="frm-nps" ok-title="Guardar" ok-variant="success" :ok-disabled="ok"
                        cancel-variant="danger" cancel-title="Cancelar" centered title="Registro de Usuarios"
                        @ok="agregar" @cancel="limpiarVariables">
                        <!-- Diseño del Formulario -->
                        <b-form @submit.prevent="agregar">
                          <b-row>
                            <b-col>
                              <b-form-group label="Nombre" label-for="nombre">
                                <b-form-input id="nombre" v-model="nombre" placeholder="Nombre" />
                              </b-form-group>
                              <b-form-group label="Usuario" label-for="Usuario">
                                <b-form-input id="Usuario" v-model="email" placeholder="Usuario" />
                              </b-form-group>
                            </b-col>
                          </b-row>
                          <b-row>
                            <b-col>
                              <b-form-group label="Password" label-for="password">
                                <b-form-input id="password" type="password" v-model="password" placeholder="Password" />
                                <b-form-text>Enter a Valid Email</b-form-text>
                              </b-form-group>

                              <b-form-group label="Repetir password" label-for="Repetir password">
                                <b-form-input id="Repetir password" type="password" v-model="c_password"
                                  placeholder="Repetir password" />
                                <b-form-text>Su contraseña debe tener entre 8 y 20
                                  caracteres.</b-form-text>
                              </b-form-group>
                            </b-col>
                          </b-row>
                          <b-row>
                            <!-- occupation  @change="obtenerDato"-->
                            <b-col>
                              <b-form-group label="Perfil" label-for="h-perfil">
                                <b-form-select style="width: fit-content" v-model="selectedPerfil" :options="aDataPerfil"
                                  :state="selectedPerfil === null ? false : true
                                    " />
                              </b-form-group>
                            </b-col>
                            <!-- checkbox -->
                            <b-col>
                              <b-form-group>
                                <b-form-checkbox id="checkbox-9" name="checkbox-9" value="Remember_me">
                                  Remember me
                                </b-form-checkbox>
                              </b-form-group>
                            </b-col>
                          </b-row>
                        </b-form>
                        <b-spinner v-if="shows" small type="grow" v-model="estado" :variant="estado" class="mr-1" />
                        {{ Loading }}
                      </b-modal>
                    </div>
                  </div>
                </b-col>
                <b-col>
                  <div style="height: 5px">
                    <div>
                      <div style="width: 300px" class="float-right">
                        <b-form-group style="height: 40px" label-for="filter-input">
                          <b-input-group>
                            <b-form-input id="filter-input" v-model="filter" type="search" style="width: 10px"
                              placeholder="Texto Para Buscar"></b-form-input>

                            <b-input-group-append>
                              <b-button :disabled="!filter" variant="danger" @click="filter = ''">Clear</b-button>
                            </b-input-group-append>
                          </b-input-group>
                        </b-form-group>
                      </div>
                    </div>
                  </div>
                </b-col>
              </b-row>
            </div>
            <!-- Tabla -->
            <div>
              <!-- Listado -->
              <b-table 
              :items="items" 
              :fields="fields" 
              :filter="filter" 
              @filtered="onFiltered" 
              hover 
              :bordered="true" 
              :busy="isBusy" 
              outlined 
              stacked="sm"  
              small
              :style="{ fontSize: fontSize }"
              >
                <!-- AQUI SE CONTROLA ID DE USUARIOS -->
                <template #cell(Ver_detalle)="row">
                  <b-form-checkbox v-model="row.detailsShowing" plain class="vs-checkbox-con" @change="row.toggleDetails">
                    <span class="vs-checkbox">
                      <span class="vs-checkbox--check">
                        <i class="vs-icon feather icon-check" />
                      </span>
                    </span>
                    <span class="vs-label">{{
                      row.detailsShowing ? "Hide" : "Show"
                    }}</span>
                  </b-form-checkbox>
                </template>

                <template #row-details="row">
                  <!-- AQUI SE SE DISEÑA LAS COLUMNAS PARA MOSTRAR EN TABLA -->
                  <b-card>
                    <b-row class="mb-2">
                      <b-col md="4" class="mb-1">
                        <strong>Nombre Completo : </strong>{{ row.item.nombre }}
                      </b-col>

                      <b-col md="4" class="mb-1">
                        <strong>Email : </strong>{{ row.item.email }}
                      </b-col>
                      <b-col md="4" class="mb-1">
                        <strong>Perfil : </strong>{{ row.item.perfil }}
                      </b-col>
                    </b-row>
                    <b-button size="sm" variant="outline-secondary" @click="row.toggleDetails">
                      Hide Details
                    </b-button>
                  </b-card>
                </template>

                <template #cell(avatar)="data">
                  <b-avatar :src="data.value" />
                </template>

                <template #cell(status)="data">
                  <b-badge :variant="status[1][data.value]">
                    {{ status[0][data.value] }}
                  </b-badge>
                </template>
                <template #cell(Permisos)="row">
                  <b-row>
                    <b-col>
                      <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'" variant="flat-success" v-b-tooltip.hover.v-dark
                        title="Cambiar Password" class="btn-icon" @click="asignarPermisos(row.item)">
                        <feather-icon icon="EditIcon" />
                      </b-button>
                      <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'" variant="danger"
                        class="btn-icon rounded-circle" @click="ControlaEliminar(row.item)">
                        <feather-icon icon="TrashIcon" />
                      </b-button>
                    </b-col>


                  </b-row>
                </template>
                <template #table-busy>
                  <div class="text-center text-danger my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Cargando...</strong>
                  </div>
                </template>
              </b-table>
            </div>
          </b-card-body>
        </b-card>
      </b-overlay>
    </div>
  </section>
</template>
<script>
import {
  BFormDatepicker,
  BRow,
  BModal,
  VBModal,
  BAvatar,
  BCardTitle,
  BCardBody,
  BCardHeader,
  BCard,
  BDropdown,
  BDropdownItem,
  BButton,
  BFormSelect,
  BCol,
  BFormGroup,
  BFormInput,
  BFormCheckbox,
  BForm,
  BFormText,
  BFormDatalist,
  BBadge,
  BTable,
  BMedia,
  BFormTextarea,
  BInputGroupAppend,
  BInputGroup,
  BOverlay,
  BSpinner,
  BFormValidFeedback,
  BFormInvalidFeedback,
  VBTooltip,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import PermisoUsuario from "./PermisoUsuario.vue";

export default {
  components: {
    BFormValidFeedback,
    BFormInvalidFeedback,
    BOverlay,
    BFormDatepicker,
    BInputGroupAppend,
    BInputGroup,
    BRow,
    BModal,
    VBModal,
    BTable,
    BAvatar,
    BCardTitle,
    BCardBody,
    BCardHeader,
    BCard,
    BDropdown,
    BDropdownItem,
    BButton,
    BFormSelect,
    BFormTextarea,
    BCol,
    BFormGroup,
    BFormInput,
    BFormCheckbox,
    BForm,
    BMedia,
    BFormText,
    BFormDatalist,
    BBadge,
    BSpinner,
    PermisoUsuario,
    VBTooltip,
  },
  directives: {
    Ripple,
  },
  data() {
    return {
      fontSize: "",
      pIdperfil: "",
      idUsuario: 0,
      nombre: "",
      email: "",
      password: "",
      c_password: "",
      idperfil: "",
      mesReporte: "",
      ok: false,
      shows: false,
      isBusy: false,
      totalRows: 1,
      loaded: false,
      filter: null,
      filterOn: [],
      idGenera: 0,
      id: 0,
      fecha: 0,
      fechaRegistro: "",
      Loading: "",
      estado: "",
      loaded: false,
      selectedPerfil: null,
      aDataPerfil: [
        { value: null, text: "Seleccine un Valor" }
      ],
      fields: [
        "Ver_detalle",
        { key: "nombre", label: "Nombre" },
        { key: "status", label: "Status" },
        { key: "Permisos", sortable: false },
      ],
      items: [
        {
          id: 1,
          nombre: "Korrie O'Crevy",
          email: "kocrevy0@thetimes.co.uk",
          perfil: "ADMINISTRADOR",
          status: 2,
        },
      ],
      status: [
        {
          1: "Activo",
          0: "Inactivo",
          // 3: "Rejected",
          // 4: "Resigned",
          // 5: "Applied",
        },
        {
          1: "light-success",
          0: "light-danger",
          // 3: "light-danger",
          // 4: "light-warning",
          // 5: "light-info",
        },
      ],
      show: false,
      variant: "dark",
      opacity: 0.85,
      blur: "2px",
      selected: [],
    };
  },

  computed: {
    sortOptions() {
      // Create an options list from our fields
      return this.fields
        .filter((f) => f.sortable)
        .map((f) => {
          return { text: f.label, value: f.key };
        });
    },
  },
  mounted() {
    this.listaUsuario();
    this.cbxPerfil()
    const movil = window.innerWidth;
    if (movil <= 576) {
      // Dispositivo móvil pequeño
      this.fontSize = 'xx-small'; // Tamaño de fuente pequeño
    }

  },
  methods: {
    asignarPermisos(item) {
      let me = this;
      me.idUsuario = item["id"];
      me.email = item["email"];
      me.selectedPerfil = item["idperfil"];
      this.$refs["frm-modifica-usuario"].show();
    },

    cbxPerfil() {
      let me = this;
      var url = "api/auth/ListaRol";
      me.aDataPerfil = []
      const axios = require("axios");
      axios.get(url).then(function (response) {
        var resp = response.data;
        for (let i = 0; i < resp.length; i++) {
          me.aDataPerfil.push({
            value: resp[i].idrol,
            text: resp[i].nombre,
          });
        }
      });

    },
    ControlaEliminar(item) {
      this.boxTwo = "";
      this.$bvModal
        .msgBoxConfirm(
          "El Registro  " + " : " + item["nombre"] + " Serán Eliminados",
          {
            title: "Advertencia",
            size: "sm",
            okVariant: "success",
            okTitle: "Continuar",
            cancelTitle: "Cancelar",
            cancelVariant: "danger",
            hideHeaderClose: true,
            centered: true,
          }
        )
        .then((value) => {
          this.boxTwo = value;
          if (value === true) {
            this.eliminar(item);
          }
        });
    },
    eliminar(item) {
      this.isBusy = true;
      alert(item["id"]);

      let me = this;
      const axios = require("axios").default;
      const params = new URLSearchParams();
      var url = "api/auth/elminarUsuario";

      params.append("idusuario", parseInt(item["id"]));
      axios
        .post(url, params)
        .then(function (response) {
          if (response.status === 201) {
            me.success("success");

            me.isBusy = false;
            me.listaUsuario();
          }
        })
        .catch((e) => {
          alert("Error en la Eliminacion" + e);
        });
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
    },
    limpiarVariables() {
      let me = this;
      me.listaUsuario();
      me.shows = false;
      me.loaded = false;
      me.Loading = "";
      me.filter = null;
      me.filterOn = [];
      me.gestion = 0;
      me.mes = 0;
      me.iExiste = 0;
      me.estado = "";
    },
    makeToast(variant) {
      let me = this;
      if (variant === "success") {
        this.$bvToast.toast("Registro Exitoso ", {
          title: `HR Analytics`,
          variant,
          solid: true,
          appendToast: true,
        });
      } else {
        this.$bvToast.toast("Error en el Registro ", {
          title: `HR Analytics`,
          variant,
          solid: true,
          appendToast: true,
        });
      }
    },
    success(variant) {
      // window.swal = require('sweetalert2')
      if (variant === "success") {
        this.$swal({
          title: "HR Analytics",
          text: "Operación Exitosa",
          icon: variant,
          customClass: {
            confirmButton: "btn btn-success",
          },
          buttonsStyling: true,
        });
      } else {
        this.$swal({
          title: "HR Analytics",
          text: "Operación sin Exito",
          icon: variant,
          customClass: {
            confirmButton: "btn btn-danger",
          },
          buttonsStyling: true,
        });
      }
    },
    listaUsuario() {
      let me = this;
      const axios = require("axios").default;
      const params = new URLSearchParams();
      // params.append('email', me.email);
      me.items = [];
      var url = "api/auth/lista";
      me.isBusy = true;
      //   me.loaded = false;
      var lista = [];
      axios
        .get(url)
        .then(function (response) {
          var resp = response.data;
          for (let i = 0; i < resp.length; i++) {
            lista.push({
              id: resp[i].ID,
              nombre: resp[i].NOMBRE,
              email: resp[i].EMAIL,
              perfil: resp[i].PERFIL,
              idperfil: resp[i].idperfil,
              status: resp[i].activo,
            });
          }
          me.items = lista;
          //   me.loaded = true;
          me.isBusy = false;
        })
        .catch((e) => {
          alert("error al obtener los datos" + e);
        });
    },
    agregar() {
      let me = this;
      const axios = require("axios").default;
      const params = new URLSearchParams();
      params.append("name", me.nombre);
      params.append("email", me.email);
      params.append("password", me.password);
      params.append("c_password", me.c_password);
      params.append("idrol", me.selectedPerfil);
      params.append("activo", 1);

      var url = "api/auth/register";
      var a = "";
      if (me.password === me.c_password) {
        axios
          .post(url, params)
          .then(function (response) {
            var resp = response.data;
            if (response.status === 201) {
              me.success("success");
              me.listaUsuario();
            }
          })
          .catch((e) => {
            alert(e);
          });
      }
      else {
        me.success("danger")
      }

    },

    modificaUsuario() {
      let me = this;
      const axios = require("axios").default;
      const params = new URLSearchParams();
      params.append("idusuario", me.idUsuario);
      params.append("email", me.email);
      params.append("password", me.password);
      params.append("idperfil", me.selectedPerfil);
      if (me.password === "") {
        var url = "api/auth/ModificaUsuarioPerfil";
      }
      else {
        var url = "api/auth/ModificaUsuario";
      }

      var a = "";
      axios
        .post(url, params)
        .then(function (response) {
          var resp = response.data;
          if (response.status === 201) {
            me.success("success");
            me.listaUsuario();
          }
        })
        .catch((e) => {
          alert(e);
        });
    },
    onContext(ctx) {
      // The date formatted in the locale, or the `label-no - date - selected` string
      this.formatted = ctx.selectedFormatted;
      // The following will be an empty string until a valid date is entered
      this.mesReporte = ctx.selectedYMD;
    },
  },
};
function MesActual(fecha, formato) {
  // 2022-09-02 21:51:48.000000"
  const map = {
    dd: fecha.getDate(),
    mm: fecha.getMonth() + 1,
    yy: fecha.getFullYear().toString(),
    yyyy: fecha.getFullYear(),
    HH: fecha.getHours(),
    MM: fecha.getMinutes(),
    SS: fecha.getSeconds(),
  };
  // HH:MM:SS
  return formato.replace(/yy|mm|dd|HH|MM|SS/gi, (matched) => map[matched]);
}
</script>
  