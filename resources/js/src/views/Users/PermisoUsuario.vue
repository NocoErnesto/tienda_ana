   
<template>
  <div>
    <b-overlay id="overlay-background" style="height: max-content" :variant="variant" :opacity="opacity" :blur="blur">
      <b-card>
        <b-card-title style="text-align: center">Asignación de Permisos</b-card-title>
        <b-card-body>
          <div>
            <b-modal id="frm-perfil" ref="frm-perfil" ok-title="Guardar" ok-variant="success" :ok-disabled="ok"
              cancel-variant="danger" cancel-title="Cancelar" centered title="Asiganción de Permiso" @ok="guardarPerfil"
              @cancel="limpiarVariables">
              <!-- Diseño del Formulario -->
              <b-row>

                <b-col>
                  <b-alert style="height: 30px" v-height-fade.appear :show="dismissCountDown" dismissible class="mb-0"
                    variant="success" @dismissed="dismissCountDown = 0" @dismiss-count-down="countDownChanged">
                    <div class="alert-body">
                      <span>Modificación Exitosa {{ dismissCountDown }}...</span>
                    </div>
                  </b-alert>
                </b-col>
              </b-row>
              <b-form>
                <b-row>
                  <b-col>
                    <!-- AQUI TABLA PAGINAS -->
                    <b-table id="tabla-lista-retrasos" :items="itemMenu" :fields="fieldsMenus" :filter="filter"
                      @filtered="onFiltered" striped hover responsive="sm" :busy="isBusy" outlined
                      :sticky-header="stickyHeader" ref="selectableTable">
                      <template #cell(cheked)="data">
                        <b-form-checkbox :checked="data.item.checked" v-model="data.item.checked"
                          @change="ModifiarPerfil(data.item)"
                     >
                        </b-form-checkbox>

                      </template>
                      <template #cell(Accion)="row">

                        <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'" variant="danger"
                          class="btn-icon rounded-circle" @click="ControlaEliminar(row.item)">
                          <feather-icon icon="TrashIcon" />
                        </b-button>
                      </template>
                      <template #table-busy>
                        <div class="text-center text-danger my-2">
                          <b-spinner class="align-middle"></b-spinner>
                          <strong>Cargando...</strong>
                        </div>
                      </template>
                    </b-table>
                  </b-col>
                </b-row>
              </b-form>
              <b-spinner v-if="shows" small type="grow" v-model="estado" :variant="estado" class="mr-1" />
              {{ Loading }}
            </b-modal>
          </div>




          <b-row>
            <b-col sm="4" md="8" xl="6" class="mb-1">
              <b-button v-ripple.400="'rgba(113, 102, 240, 0.15)'" v-b-modal.frm-perfil variant="success">
                Nuevo Registro
              </b-button>
            </b-col>
            <b-col sm="8" md="4" xl="6" class="mb-1">

              <b-form-group label-for="filter-input" label-align-sm="left" label-size="sm" class="mb-0">
                <b-input-group size="sm">
                  <b-form-input id="filter-input" v-model="filter" type="search"
                    placeholder="Texto Para Buscar"></b-form-input>

                  <b-input-group-append>
                    <b-button :disabled="!filter" variant="danger" @click="filter = ''">Clear</b-button>
                  </b-input-group-append>
                </b-input-group>
              </b-form-group>

            </b-col>
          </b-row>

          
          <b-row>
            <b-col>
              <!-- Listado --> 

              <b-row>
                <b-col xs="12" sm="12" md="12" xl="12" lg="12">
                  <b-table 
                  id="tabla-lista-roles" 
                  :items="itemRol" 
                  :fields="fieldsRol" 
                  :filter="filter"
                    @filtered="onFiltered" hover 
                    :bordered="true" 
                    :busy="isBusy" 
                    outlined 
                    stacked="sm" 
                    small
                    :style="{ fontSize: fontSize }">
                    <template #cell(accion)="row">
                      <b-button v-ripple.400="'rgba(234, 84, 85, 0.15)'" variant="flat-danger"
                        class="btn-icon rounded-circle" @click="ControlaEliminar(row.item)">
                        <feather-icon icon="LockIcon" />
                      </b-button>
                      <b-button v-ripple.400="'rgba(234, 84, 85, 0.15)'" variant="flat-info"
                        class="btn-icon rounded-circle" @click="validarClick2(row.item, ('2'))">
                        <feather-icon icon="EditIcon" />
                      </b-button>
                    </template>
                    <template #table-busy>
                      <div class="text-center text-danger my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Cargando...</strong>
                      </div>
                    </template>
                  </b-table>
                </b-col>
              </b-row>
            </b-col>
          </b-row>
        </b-card-body>
      </b-card>
    </b-overlay>
  </div>
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
  BFormCheckboxGroup,
  BCardText,
  BAlert,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import { heightFade } from "@core/directives/animations";

export default {
  components: {
    BAlert,
    BCardText,
    BFormCheckboxGroup,
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
  },
  props: {
    idperfil: String,
  },

  directives: {
    "height-fade": heightFade,
    Ripple,
  },
  data() {
    return {
      dismissSecs: 2,
      dismissCountDown: 0,

      stickyHeader: true,
      transProps: {
        // Transition name
        name: "flip-list",
      },
      fontSize: "",
      sele: [],
      perfil: "",
      promotores: "",
      pasivos: "",
      detractores: "",
      mesReporte: "",
      ok: false,
      shows: false,
      isBusy: false,
      totalRows: 1,
      loaded: false,
      filter: null,
      idGenera: 0,
      id: 0,
      fecha: 0,
      fechaRegistro: "",
      Loading: "",
      estado: "",
      items: [],
      itemMenu: [],
      itemRol: [],
      selelectedRol: [],
      selectedMenus: [],

      selectedPerfil: 1,
      aDataPerfil: [{ value: null, text: "Seleccione un Valor" }],

      fieldsMenus: [
        { key: "Menu", label: "MENÚ" },
        { key: "submenu", label: "SUB-MENÚ" },
        { key: "cheked", label: "PERMITIR" },
      ],
      fieldsRol: [
        { key: "id", label: "#" },
        { key: "nombre", label: "NOMBRE" },
        { key: "descripcion", label: "DESCRIPCIÓN" },
        { key: "accion", label: "ACCIÓN" },
      ],

      show: false,
      variant: "dark",
      opacity: 0.85,
      blur: "2px",
      selected: [],
      pidperfil: "",
      idmenu: "",
      menu: [],
      axiosP: false,
    };
  },

  computed: {
    sortOptions() {
      // Create an options list from our fields
      return this.fieldsMenus
        .filter((f) => f.sortable)
        .map((f) => {
          return { text: f.label, value: f.key };
        });
    },
  },
  mounted() {

    this.ListaRoles();
    const movil = window.innerWidth;
    if (movil <= 576) {
      // Dispositivo móvil pequeño
      this.fontSize = 'xx-small'; // Tamaño de fuente pequeño
    }

    // this.GenerarId();
    // alert(this.$store.state.app.msg)
  },
  methods: {
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    ModifiarPerfil(item) {
      let me = this;
      me.show = true;
      const hoy = new Date();
      var fechaRegistro = MesActual(hoy, "yy-mm-dd HH:MM:SS.000000");
      me.fechaRegistro = fechaRegistro;
      const axios = require("axios").default;
      me.pidperfil = me.selectedPerfil;
      // me.idmenu = item[0]["id"];
      const params = new URLSearchParams();
      var chek = 0

      me.items = [];
      var urlm = "api/auth/ModificaAcceso";
      me.loaded = false;
      // me.isBusy = true;
      params.append("idacceso", item["id"]);

      if (item["checked"] === true) {
        chek = 1
      } else {
        chek = 0
      }
      params.append("checked", chek);

      axios
        .post(urlm, params)
        .then(function (response) {
          var resp = response.data;
          if (response.status === 201) {
            me.show = false;
            me.showAlert();
            // me.success("success");
            // me.UsuarioAlerta("success", response.data.mensaje)
            me.isBusy = false;
            // me.ListaPaginas();

          }
        })
        .catch((e) => {
          // alert("No se Modifico el acceso " + e);
          me.UsuarioAlerta("error" + e.response.data.error)
        });
      me.limpiarVariables();
    },
    ControlaEliminar(item) {
      this.boxTwo = "";
      this.$bvModal
        .msgBoxConfirm(
          "El Registro  " + " : " + item["fecha"] + " Serán Eliminados",
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
      alert(item["idnps"]);

      let me = this;
      const axios = require("axios").default;
      const params = new URLSearchParams();
      var url = "api/auth/EliminarNps";

      params.append("idnps", parseInt(item["idnps"]));
      axios
        .post(url, params)
        .then(function (response) {
          if (response.status === 200) {

            me.UsuarioAlerta("success", "Eliminación Exitosa")
            me.isBusy = false;
            me.ListaNps();
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
      // me.ListaPaginas();
      me.shows = false;
      me.loaded = false;
      me.Loading = "";
      me.filter = null;
      me.gestion = 0;
      me.mes = 0;
      me.iExiste = 0;
      me.estado = "";
    },

    //Listas
    ListaPaginas() {
      let me = this;
      const axios = require("axios").default;
      const params = new URLSearchParams();
      // params.append('email', me.email);
      me.itemMenu = [];
      me.isBusy = true;
      var url = "api/auth/menu?idperfil=" + this.$store.state.app.idRolSelecionado;
      me.loaded = false;
      var lista = [];
      axios
        .get(url)
        .then(function (response) {
          var resp = response.data;
          var estado = false
          for (let i = 0; i < resp.length; i++) {
            if (resp[i].checked === 1) {
              estado = true
            } else {
              estado = false
            }
            lista.push({
              id: resp[i].idacceso,
              Menu: resp[i].nombre_menu,
              submenu: resp[i].nombre_submenu,
              checked: estado,
            });
          }
          me.itemMenu = lista;
          me.isBusy = false;
          me.loaded = true;
        })
        .catch((e) => {
          // alert("error al obtener los datos Lista Menu" + e);
          this.UsuarioAlerta("error", e.response.data.error);
        });
    },
    validarClick2(item, click) {
      if (click === "2") {

        this.$store.dispatch('app/cambia_idRolSelecionado', item["id"])
        this.ListaPaginas()
        this.$refs["frm-perfil"].show();
      }
    },

    ListaRoles() {
      let me = this;
      const axios = require("axios").default;
      const params = new URLSearchParams();
      // params.append('email', me.email);
      me.itemRol = [];
      me.isBusy = true;
      var url = "api/auth/ListaRol";
      me.loaded = false;
      var lista = [];
      axios
        .get(url)
        .then(function (response) {
          var resp = response.data;
          for (let i = 0; i < resp.length; i++) {
            lista.push({
              id: resp[i].idrol,
              nombre: resp[i].nombre,
              descripcion: resp[i].descripcion,
            });
          }
          me.itemRol = lista;
          me.isBusy = false;
          me.loaded = true;
        })
        .catch((e) => {
          alert("error al obtener los datos Lista Menu" + e);
        });
    },

    TraeMenuPerfil() {
      let me = this;
      const axios = require("axios").default;
      const params = new URLSearchParams();
      // params.append('email', me.email);
      me.items = [];
      me.isBusy = true;
      var url = "api/auth/MenuPefil?idperfil=" + me.selectedPerfil;
      me.loaded = false;
      var lista = [];
      axios
        .get(url)
        .then(function (response) {
          var resp = response.data;
          for (let i = 0; i < resp.length; i++) {
            lista.push({
              id: resp[i].id_detalle_perfil,
              idperfil: resp[i].idperfil,
              nombre_perfil: resp[i].nombre_perfil,
              idmenu: resp[i].idmenu,
              name: resp[i].name,
              parent: resp[i].parent,
              estado: true,
            });
          }
          me.items = lista;
          me.isBusy = false;
          me.loaded = true;
          me.menu = lista;
          prueba();
        })
        .catch((e) => {
          alert("error al obtener los datos Lista Menu Pefil" + e);
        });
    },
    dataGestion() {
      let me = this;
      var url = "api/auth/ListaMenu";
      me.aDataPerfil = [{ value: null, text: "Seleccione un Valor" }];
      const axios = require("axios");
      axios.get(url).then(function (response) {
        var resp = response.data;
        for (let i = 0; i < resp.length; i++) {
          me.aDataPerfil.push({
            value: resp[i].idperfil,
            text: resp[i].nombre_perfil,
          });
        }
      });
    },
    guardarPerfil() {
      let me = this;
      me.show = true;
      const hoy = new Date();
      var fechaRegistro = MesActual(hoy, "yy-mm-dd HH:MM:SS.000000");
      me.fechaRegistro = fechaRegistro;
      const axios = require("axios").default;
      me.pidperfil = me.selectedPerfil;
      // me.idmenu = item[0]["id"];
      const params = new URLSearchParams();

      me.items = [];
      var urlm = "api/auth/GuardarPerfil";
      me.loaded = false;
      me.isBusy = true;
      params.append("perfil", me.perfil);
      // params.append("idmenu", me.idmenu);
      // params.append("idusuario", this.$store.state.app.msg)
      axios
        .post(urlm, params)
        .then(function (response) {
          var resp = response.data;
          if (response.status === 200) {
            me.show = false;

            me.success("success");
            me.isBusy = false;
            me.ListaPaginas();

            // me.dataGestion();
          } else {
            me.success("danger");
          }
        })
        .catch((e) => {
          alert("No se guardo el Permiso " + e);
        });
      me.limpiarVariables();
    },

    Guardar(item) {
      let me = this;
      me.show = true;
      const hoy = new Date();
      var fechaRegistro = MesActual(hoy, "yy-mm-dd HH:MM:SS.000000");
      me.fechaRegistro = fechaRegistro;
      const axios = require("axios").default;
      me.pidperfil = me.selectedPerfil;
      for (let i = 0; i < me.menu.length; i++) {
        me.idmenu = me.menu[i]["id"];
        const params = new URLSearchParams();

        me.items = [];
        var urlm = "api/auth/ModificaAcceso";
        me.loaded = false;
        me.isBusy = true;
        params.append("idacceso", item["id"]);
        axios
          .post(urlm, params)
          .then(function (response) {
            var resp = response.data;
            if (response.status === 201 && me.menu.length) {
              me.show = false;
              me.TraeMenuPerfil();
              me.success("success");
              me.isBusy = false;
            } else {
              me.success("danger");
            }
          })
          .catch((e) => {
            alert("No se guardo el Permiso " + e);
          });

        // me.limpiarVariables();
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
    onContext(ctx) {
      // The date formatted in the locale, or the `label-no - date - selected` string
      this.formatted = ctx.selectedFormatted;
      // The following will be an empty string until a valid date is entered
      this.mesReporte = ctx.selectedYMD;
    },
    selecionar(item) {
      let me = this;
      me.selected = item;
    },
    unselectThirdRow() {
      // Rows are indexed from 0, so the third row is index 2
      this.$refs.selectableTable.unselectRow(2);
    },
    selectThirdRow() {
      // Rows are indexed from 0, so the third row is index 2
      this.$refs.selectableTable.selectRow(2);
    },
  },
};
function prueba() {
  this.$refs.selectableTable.selectRow(2);
}
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
