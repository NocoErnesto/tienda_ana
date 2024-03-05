   
<template>
    <section>
        <div>
            <!-- Formulario Modal -->
            <b-modal ref="frm-compra" id="frm-compra" ok-title="Cerrar" ok-variant="danger" ok-only size="xl" centered
                title="Registro de Compra" @ok="GetAllShopping">
                <FrmCompra></FrmCompra>
            </b-modal>
        </div>
        <b-row>
            <b-col md="9">
                <b-overlay id="overlay-background" :variant="variant" :opacity="opacity" :blur="blur">
                    <b-card border-variant="info">
                        <b-card-title style="text-align: center">Listado de Compras</b-card-title>

                        <b-card-body>
                            <b-row>
                                <b-col>
                                    <b-button-toolbar>
                                        <b-button-group class="mr-2 mb-1">
                                            <b-button variant="flat-success"
                                                href="https://pweb.impuestos.gob.bo/Autenticacion/index.xhtml"
                                                target="_blank" v-ripple.400="'rgba(113, 102, 240, 0.15)'">
                                                <feather-icon icon="GlobeIcon" />
                                                <span class="align-middle">Facturación</span>
                                            </b-button>
                                        </b-button-group>

                                    </b-button-toolbar>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col sm="4" md="5" xl="6" lg="6" class="mb-1">
                                    <!-- Boton Modal -->
                                    <b-button v-ripple.400="'rgba(113, 102, 240, 0.15)'" v-b-modal.frm-compra
                                        variant="success" @click="clickAccion('', 'guardar')"
                                        :class="{ 'd-none': $store.state.app.isCrea }">
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
                                    <b-table id="tabla-lista-compras" :items="items" :fields="fields" :filter="filter"
                                        @filtered="onFiltered" hover :bordered="true" :busy="isBusy" outlined stacked="sm"
                                        small :style="{ fontSize: fontSize }">
                                        <template #cell(artCantidad)="data">
                                            <div class="d-flex align-items-center">
                                                <b-form-input id="txtCantidad" placeholder="Cantidad" class="small-input"
                                                    :state="data.item.artCantidad > 0 ? true : false"
                                                    v-model="data.item.artCantidad" type="number" :min="1" />
                                            </div>
                                        </template>
                                        <template #cell(Acción)="row">
                                            <b-row>
                                                <b-col>
                                                    <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                                        variant="flat-warning" v-b-tooltip.hover.v-dark
                                                        title="Seguir Editando" class="btn-icon"
                                                        :class="{ 'd-none': $store.state.app.isEdita }"
                                                        @click="clickAccion(row.item, ('editar'))">
                                                        <feather-icon icon="EditIcon" />
                                                    </b-button>
                                                </b-col>
                                                <b-col>
                                                    <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                                        variant="flat-success" v-b-tooltip.hover.v-dark title="Ver Detalle"
                                                        class="btn-icon" :class="{ 'd-none': $store.state.app.isVer }"
                                                        @click="clickAccion(row.item, ('ver'))">
                                                        <feather-icon icon="EyeIcon" />
                                                    </b-button>
                                                </b-col>
                                                <b-col>
                                                    <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                                        variant="flat-danger" class="btn-icon rounded-circle"
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
                        </b-card-body>
                    </b-card>
                </b-overlay>
            </b-col>
            <b-col md="3">
                <b-card border-variant="info">

                    <b-card-body>
                        compras Contado :{{ totalComprasSum }}
                    </b-card-body>
                </b-card></b-col>

        </b-row>

    </section>
</template>
<script>
import {
    BButtonToolbar,
    BButtonGroup,
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
import vSelect from 'vue-select'
import Ripple from "vue-ripple-directive";
import FrmCompra from "./FrmCompra.vue";


//   import Frm_Producto from "./frm_Producto/frm_Producto.vue";

export default {
    components: {
        BButtonToolbar,
        BButtonGroup,
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

        FrmCompra
    },
    directives: {
        "b-tooltip": VBTooltip,
        Ripple,
    },
    data() {
        return {
            txtCantidad: 0,
            TipoAccion: null,
            stickyHeader: true,
            fontSize: "",
            transProps: {
                // Transition name
                name: "flip-list",
            },
            txtCodigoInterno: 0,
            totalComprass: 0,
            shows: true,
            isBusy: false,
            totalRows: 1,
            loaded: false,
            filter: "",
            filterOn: [],
            fecha: 0,
            fechaRegistro: "",
            Loading: "",
            estado: "",
            items: [],
            fields: [

                { key: "cmtNumero", label: "Nª Compra", sortable: true },
                { key: "provNombre", label: "Proveedor", sortable: true },
                { key: "cmtFechaCreacion", label: "Fecha Realizado", sortable: true },
                { key: "totalCompras", label: "Total Compras", sortable: true },
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
        totalComprasSum() {
            return this.items.reduce((total, Compra) => total + parseFloat(Compra.totalCompras), 0).toFixed(2);
        },
    },
    mounted() {
        this.VerificarAperturaCaja()
        this.GetAllShopping()
        this.clickAccion('', "apertura")

        const movil = window.innerWidth;
        if (movil <= 576) {
            // Dispositivo móvil pequeño
            this.fontSize = 'xx-small'; // Tamaño de fuente pequeño
        }
    },
    methods: {
        clickAccion(item, accion) {


            if (accion === "guardar") {
                this.$store.dispatch('app/cambiarTipoAccion', { tipo: accion, variant: 'success', icono: 'SaveIcon', texto: 'Guardar', Bclass: '' })
            }
            if (accion === "editar") {

                this.$store.dispatch('app/cambiaId', item["cmtId"])
                this.$store.dispatch('app/cambiarTipoAccion', { tipo: accion, variant: 'primary', icono: 'SaveIcon', texto: 'Modificar', Bclass: '' })

                this.$refs["frm-compra"].show();
            }
            if (accion === "ver") {
                this.$store.dispatch('app/cambiaId', item["cmtId"])
                this.$store.dispatch('app/cambiarTipoAccion', { tipo: accion, variant: 'warning', icono: 'SaveIcon', texto: 'Generar Nota PDF', Bclass: '' })

                this.$refs["frm-compra"].show();
            }
            if (accion === "eliminar") {
                this.ControlaEliminar(item)
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
        ControlaEliminar(item) {
            this.boxTwo = "";
            this.$bvModal
                .msgBoxConfirm(
                    "El Registro seleccionado  " + " : " + item["cmtId"] + " Serán Eliminados",
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
            params.append('cmtId', item["cmtId"]);
            params.append('usrId', this.$store.state.app.UsuarioId);
            var url = "api/auth/InactiveShopping";
            me.isBusy = true;
            axios.post(url, params).then(function (response) {
                if (response.status == 201) {
                    me.UsuarioAlerta("success");
                    me.GetAllShopping();
                    me.isBusy = false;
                } else {
                    me.UsuarioAlerta("danger");
                }
            }).catch((e) => {
                me.UsuarioAlerta("danger");
                console.log("danger", "No se Realizó la Operación: " + e);
            });
        },
        VerificarAperturaCaja() {
            let me = this;
            const axios = require("axios").default;
            me.items = [];
            var url = "api/auth/VerifyCajaOpeningShoppings";
            me.loaded = false;
            var lista = [];
            axios.get(url).then(function (response) {
                var resp = response.data;
                if (response.status === 201) {
                    me.UsuarioAlerta("warning", response.data.mensaje)
                }
                me.loaded = true;
            }).catch((e) => {
                me.UsuarioAlerta("error", e.response.data.error);
            });
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
        },
        limpiarVariables() {
            let me = this;
            // me.listArticulo();
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
        BuscarArticulo() {
            let me = this;
            const axios = require("axios").default;
            const params = new URLSearchParams();

            params.append('artCodigo', me.txtCodigoInterno);
            me.items = [];

            var url = "api/auth/TraeArticulo";
            me.loaded = false;
            var lista = [];
            axios
                .post(url, params)
                .then(function (response) {
                    var resp = response.data;
                    lista.push({
                        artId: resp[i].artId,
                        codigo: resp[i].codigo,
                        artNombre: resp[i].artNombre,
                        catNombre: resp[i].catNombre,
                        marNombre: resp[i].marNombre,
                        uniNombre: resp[i].uniNombre,
                        artCosto: resp[i].artCosto,
                        artPrecioCompra: resp[i].artPrecioCompra,
                        artCantidad: resp[i].artCantidad,
                        artCantMin: resp[i].badgeColor
                    });
                    me.items = lista;
                    me.loaded = true;
                })
                .catch((e) => {
                    alert("error al obtener los datos Lista Articulo " + e);
                });
        },


        GetAllShopping() {
            let me = this;
            const axios = require("axios").default;
            me.items = [];
            me.isBusy = true;
            var url = "api/auth/GetAllShopping";
            me.loaded = false;
            var lista = [];
            axios
                .get(url)
                .then(function (response) {
                    var resp = response.data;
                    for (let i = 0; i < resp.length; i++) {
                        lista.push({
                            cmtId: resp[i].cmtId,
                            cmtNumero: resp[i].cmtNumero,
                            provNombre: resp[i].nombreProveedor,
                            cmtFechaCreacion: resp[i].cmtFechaCreacion,
                            totalCompras: resp[i].totalCompras
                        });
                    }
                    me.items = lista;
                    me.isBusy = false;
                    me.loaded = true;
                })
                .catch((e) => {
                    alert("Error al obtener los datos de compras realizadas: " + e);
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
</script>
<style lang="scss" >
@import '~@resources/scss/vue/libs/vue-select.scss';

.small-input {
    font-size: 12px; // Ajusta el tamaño de la fuente según tus preferencias
    padding: 0.25rem 0.5rem; // Ajusta el relleno (padding) según tus preferencias
    height: 30px; // Ajusta la altura según tus preferencias
    width: 80px;
}
</style>
        