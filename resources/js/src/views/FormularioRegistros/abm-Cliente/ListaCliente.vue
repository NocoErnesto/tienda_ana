   
<template>
    <section>
        <div>
            <b-modal ref="frmCliente" id="frmCliente" ok-title="Cerrar" ok-variant="danger" ok-only size="lg" centered
                title="Registro de Proveedores" @ok="ListaCliente">
                <!-- Diseño del Formulario -->
                <frm-cliente></frm-cliente>
            </b-modal>
        </div>
        <div>
            <b-overlay id="overlay-background" :variant="variant" :opacity="opacity" :blur="blur">
                <b-card border-variant="info">
                    <!-- <b-card-title style="text-align: center">Listado de Cajas</b-card-title> -->
                    <!-- <b-card-body> -->
                    <b-row>
                        <b-col sm="4" md="5" xl="6" lg="6" class="mb-1">
                            <!-- Boton Modal -->
                            <b-button v-ripple.400="'rgba(113, 102, 240, 0.15)'" v-b-modal.frmCliente variant="success"
                                @click="clickAccion('', 'guardar')" :class="{ 'd-none': $store.state.app.isCrea }">
                                Nuevo Registro
                            </b-button>
                        </b-col>
                        <b-col sm="8" md="7" xl="6" lg="6">
                            <b-form-group label-for="filter-input">
                                <b-input-group>
                                    <b-form-input id="filter-input" v-model="filter" debounce="200" type="search"
                                        placeholder="Esccribe Para Buscar"></b-form-input>
                                    <b-input-group-append>
                                        <b-button :disabled="!filter" variant="danger"
                                            @click="filter = ''">Limpiar</b-button>
                                    </b-input-group-append>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col>
                            <!-- Tabla --> <!-- Listado -->
                            <b-table id="tabla-lista-marcas" :items="items" :fields="fields" :filter="filter"
                                @filtered="onFiltered" hover responsive="sm" :busy="isBusy" outlined
                                :sticky-header="stickyHeader">

                                <template #cell(Acción)="row">
                                    <b-row>
                                        <b-col>
                                            <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'" variant="flat-warning"
                                                v-b-tooltip.hover.v-dark title="Seguir Editando" class="btn-icon"
                                                :class="{ 'd-none': $store.state.app.isEdita }"
                                                @click="clickAccion(row.item, ('editar'))">
                                                <feather-icon icon="EditIcon" />
                                            </b-button>
                                        </b-col>
                                        <b-col>
                                            <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'" variant="flat-success"
                                                v-b-tooltip.hover.v-dark title="Ver Detalle" class="btn-icon"
                                                :class="{ 'd-none': $store.state.app.isVer }"
                                                @click="clickAccion(row.item, ('ver'))">
                                                <feather-icon icon="EyeIcon" />
                                            </b-button>
                                        </b-col>
                                        <b-col>
                                            <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'" variant="flat-danger"
                                                class="btn-icon rounded-circle"
                                                :class="{ 'd-none': $store.state.app.isElimina }"
                                                @click="clickAccion(row.item, ('eliminar'))">
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
                        </b-col>
                    </b-row>
                    <!-- </b-card-body> -->
                </b-card>
            </b-overlay>
        </div>
    </section>
</template>
<script>
import {
    VBTooltip,
    BFormFile,
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
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import vSelect from 'vue-select'
import FrmCliente from './frmCliente.vue';



export default {
    components: {
        VBTooltip,
        vSelect,
        BFormFile,
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
        FrmCliente
    },
    directives: {
        "b-tooltip": VBTooltip,
        Ripple,
    },
    data() {
        return {

            TipoAccion: null,
            stickyHeader: true,
            transProps: {
                // Transition name
                name: "flip-list",
            },

            mesReporte: "",
            shows: true,
            isBusy: false,
            totalRows: 1,
            loaded: false,
            filter: "",
            filterOn: [],
            idGenera: 0,
            id: 0,
            fecha: 0,
            fechaRegistro: "",
            Loading: "",
            estado: "",
            items: [],
            fields: [


                { key: "cliNombre", label: "Cliente", sortable: true },
                { key: "cliApp", label: "App", sortable: true },
                { key: "cliApm", label: "Apm", sortable: true },
                { key: "cliCedula", label: "CEDULA", sortable: true },
                { key: "cliDireccion", label: "DIRECCION", sortable: true },
                { key: "cliRazonSocial", label: "Razon Social", sortable: true },
                { key: "cliTelefono", label: "TELEFONO", sortable: true },
                { key: "Acción", sortable: false },
            ],

            show: false,
            variant: "dark",
            opacity: 0.85,
            blur: "2px",
            // selected: [],
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
        this.ListaCliente();
    },
    methods: {
        clickAccion(item, accion) {


            if (accion === "guardar") {
                this.$store.dispatch('app/cambiarTipoAccion', { tipo: accion, variant: 'success', icono: 'SaveIcon', texto: 'Guardar', Bclass: '' })
            }
            if (accion === "editar") {

                this.$store.dispatch('app/cambiaId', item["id"])
                this.$store.dispatch('app/cambiarTipoAccion', { tipo: accion, variant: 'primary', icono: 'SaveIcon', texto: 'Modificar', Bclass: '' })

                this.$refs["frmCliente"].show();
            }
            if (accion === "ver") {
                this.$store.dispatch('app/cambiaId', item["id"])
                this.$store.dispatch('app/cambiarTipoAccion', { tipo: accion, variant: 'warning', icono: 'FileIcon', texto: 'Ver compras en nota PDF', Bclass: '' })

                this.$refs["frmCliente"].show();
            }
            if (accion === "eliminar") {
                this.ControlaEliminar(item)
            }
        },
        UsuarioAlerta(variant) {

            if (variant === "success") {
                this.$swal({
                    title: "Buen Trabajo",
                    text: "Operacion Exitosa",
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
                    title: "¡Error!",
                    text: "No se Logro Realizar la Operacíon",
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
        ControlaEliminar(item) {
            this.boxTwo = "";
            this.$bvModal
                .msgBoxConfirm(
                    "El Articulo  " + " : " + item["id"] + " Serán Eliminados",
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
            let me = this;
            const axios = require("axios").default;
            const params = new URLSearchParams();
            params.append('provId', item["cliId"]);
            var url = "api/auth/eliminarProveedor";
            me.isBusy = true;
            axios
                .post(url, params)
                .then(function (response) {

                    if (response.status == 201) {
                        me.UsuarioAlerta("success");
                        me.listaProveedor()
                        me.isBusy = false;
                    } else {
                        me.UsuarioAlerta("danger");
                    }

                })
                .catch((e) => {
                    me.UsuarioAlerta("danger");
                    console.log("danger", "No se Realizó la Operación: " + e);
                });
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
        },
        limpiarVariables() {
            let me = this;
            me.listaProveedor();
            me.shows = false;
            me.loaded = false;
            me.Loading = "";
            me.filter = null;
            me.filterOn = [];
            me.gestion = 0;
            me.mes = 0;
            me.iExiste = 0;
            me.estado = "";

            me.provDireccion = "",
                me.provNombre = "",
                me.provTelefono = ""
        },


        async ListaCliente() {
            try {
                let me = this;
                const lista = [];
                me.items = []
                const response = await this.$http.get("ListaCliente")
                const resp = response.data;
                for (let i = 0; i < resp.length; i++) {

                    lista.push({
                        cliId: resp[i].cliId,
                        cliNombre: resp[i].cliNombre,
                        cliApp: resp[i].cliApp,
                        cliApm: resp[i].cliApm,
                        cliCedula: resp[i].cliCedula,
                        cliDireccion: resp[i].cliDireccion,
                        cliRazonSocial: resp[i].cliRazonSocial,
                        cliTelefono: resp[i].cliTelefono,
                        cliActivo: resp[i].cliActivo,
                        cliFechaCreacion: resp[i].cliFechaCreacion
                    });
                }
                me.items = lista;
            } catch (error) {
                console.log(error.message);
                this.UsuarioAlerta("error", error.response);
                this.showOverlay = false;

            }

        },
        onContext(ctx) {
            // The date formatted in the locale, or the `label-no - date - selected` string
            this.formatted = ctx.selectedFormatted;
            // The following will be an empty string until a valid date is entered
            this.mesReporte = ctx.selectedYMD;
        },
    },
};

</script>
<style lang="scss" >
@import '~@resources/scss/vue/libs/vue-select.scss';

.custom-badge {
    width: 30px;
    height: 15px;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
      