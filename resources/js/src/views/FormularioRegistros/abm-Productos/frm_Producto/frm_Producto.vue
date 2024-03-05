<template>
    <section>
        <!-- formularios modal UNIDAD ,MARCA,CATEGORIA -->
        <div>
            <b-modal ref="frm-unidad" id="frm-unidad" ok-title="Cerrar" ok-variant="danger" ok-only size="lg" centered
                title="Registro de Articulos" @ok="cbxUnidad" @hidden="cerrarVentana">
                <!-- Diseño del Formulario -->
                <!-- <frmUnidades></frmUnidades> -->

                <frmUnidades></frmUnidades>

            </b-modal>
        </div>
        <div>
            <b-modal ref="frm-marca" id="frm-marca" ok-title="Cerrar" ok-variant="danger" ok-only size="lg" centered
                title="Registro de Marcas" @ok="cbxMarca" @hidden="cerrarVentana">
                <!-- Diseño del Formulario -->

                <frm-marca></frm-marca>
            </b-modal>
        </div>
        <div>
            <b-modal ref="frm-categoria" id="frm-categoria" ok-title="Cerrar" ok-variant="danger" ok-only size="lg" centered
                title="Registro de categoria" @ok="cbxCategoria" @hidden="cerrarVentana">
                <!-- Diseño del Formulario -->
                <frm-categoria></frm-categoria>
            </b-modal>
        </div>

        <b-overlay :show="showOverlay" rounded="sm" variant="transparent" :opacity="opacity" :blur="blur">
            <b-row class="my-2">
                <b-col md="7" cols="12" class="d-flex align-items-center justify-content-center mb-2 mb-md-0">
                    <b-icon-printer></b-icon-printer>
                    <b-form @submit.prevent enctype="multipart/form-data" id="frm-articulo" ref="frm-articulo">

                        <b-row>
                            <b-col>
                                <b-button-toolbar>
                                    <b-button-group class="mr-2 mb-1" size="sm">
                                        <b-button variant="outline-success" class="btn-icon" v-b-modal.frm-unidad
                                            v-ripple.400="'rgba(113, 102, 240, 0.15)'">
                                            <!-- <feather-icon icon="GlobeIcon" /> -->
                                            <span> Unidad</span>
                                        </b-button>
                                        <b-button variant="outline-success" v-b-modal.frm-marca
                                            v-ripple.400="'rgba(113, 102, 240, 0.15)'">
                                            <span>Marca</span>
                                        </b-button>
                                        <b-button variant="outline-success" v-b-modal.frm-categoria
                                            v-ripple.400="'rgba(113, 102, 240, 0.15)'">
                                            <span>Categoria</span>
                                        </b-button>

                                    </b-button-group>

                                </b-button-toolbar>
                            </b-col>
                            <b-col>
                                <b-avatar variant="light-info" size="35px" :badge="cantidad_productos"
                                    badge-variant="warning" :text="catNombre" />
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <b-row>
                                    <b-col>
                                        <b-form-group label="Codigo Interno" label-for="codigo-interno">
                                            <b-form-input id="txtCodigoInterno" placeholder="Codigo Interno"
                                                :state="txtCodigoInterno.length ? true : false" v-model="txtCodigoInterno"
                                                disabled />
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col>
                                        <b-form-group label="Codigo Barra" label-for="lbCodigoBarras">
                                            <b-form-input id="txtCodigoBarras" placeholder="Codigo Barra"
                                                v-model="txtCodigoBarra" />
                                        </b-form-group>
                                    </b-col>

                                </b-row>
                            </b-col>
                            <b-col md="6">
                                <b-row>
                                    <b-col>
                                        <b-form-group>
                                            <label class="d-inline d-lg-flex">Categoria</label>
                                            <v-select v-model="selectedCategoria" :options="booksCategoria" label="title"
                                                placeholder="Seleccionar" style="color:brown ;">
                                                <template #option="{ title, icon }">
                                                    <feather-icon :icon="icon" size="16" class="align-middle mr-50" />
                                                    <span> {{ title }}</span>
                                                </template>
                                            </v-select>
                                        </b-form-group>
                                    </b-col>

                                </b-row>
                                <b-row>
                                    <b-col>
                                        <b-form-group>
                                            <label class="d-inline d-lg-flex">Imagen</label>
                                            <b-form-file id="file-small" size="sm" @change="handleImageChange"
                                                accept="image/*" browse-text="Cargar" placeholder="Direccion"
                                                name="artFoto" />
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </b-col>

                        </b-row>
                        <b-row>
                            <b-col md="12">
                                <label style="font-size: 1em" class="mb-25">Nombre Articulo</label>
                                <b-form-textarea :state="txtNomArticulo.length ? true : false" v-model="txtNomArticulo"
                                    rows="1" class="form-textarea" @keyup.enter="hola" />
                                <b-badge :variant="txtNomArticulo.length ? 'success' : 'danger'">
                                    {{ txtNomArticulo.length + "/" + 200 }}
                                </b-badge>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col>
                                <b-row>
                                    <b-col>
                                        <b-form-group>
                                            <label class="d-inline d-lg-flex">Marca</label>
                                            <v-select v-model="selectedMarca" :options="booksMarca" label="title"
                                                placeholder="Seleccionar" style="color:brown ;">
                                                <template #option="{ title, icon }">
                                                    <feather-icon :icon="icon" size="16" class="align-middle mr-50" />
                                                    <span> {{ title }}</span>
                                                </template>
                                            </v-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col>
                                        <b-form-group>
                                            <label class="d-inline d-lg-flex">Unidad</label>
                                            <v-select v-model="selectedUnidad" :options="booksUnidad" label="title"
                                                placeholder="Seleccionar">
                                                <template #option="{ title, icon }">
                                                    <feather-icon :icon="icon" size="16" class="align-middle mr-50" />
                                                    <span> {{ title }}</span>

                                                </template>
                                                <b-button variant="flat-success" class="btn-icon "
                                                    v-ripple.400="'rgba(113, 102, 240, 0.15)'">
                                                    <feather-icon icon="FileIcon" ize />
                                                </b-button>
                                            </v-select>

                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-row>

                                    <b-col cols="12" md="4">
                                        <b-form-group label="Costo" label-for="Costo">
                                            <b-form-input id="txtCosto" placeholder="Costo"
                                                :state="txtCosto.length ? true : false" v-model="txtCosto" type="number" />
                                        </b-form-group>
                                    </b-col>
                                    <b-col>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <b-form-group>
                                                <label class="d-inline d-lg-flex" for="sb-maxmin">% Utilidad</label>
                                                <b-form-input id="txtUtilidad" placeholder="% Utilidad"
                                                    :state="txtUtilidad.length > 0 ? true : false" v-model="txtUtilidad"
                                                    type="number" min="1" max="100" pattern="[1-9][0-9]?|100" />
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col cols="12" md="4">
                                        <b-form-group label="Precio Venta" label-for="lbPrecioVenta">
                                            <b-form-input id="txtPrecioVenta" placeholder="Precio Venta"
                                                :state="txtVenta.length ? true : false" v-model="txtVenta" type="number" />
                                        </b-form-group>
                                    </b-col>

                                </b-row>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col>
                                <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'" :variant="$store.state.app.variant"
                                    :class="$store.state.app.classButton"
                                    @click="validaOperacion($store.state.app.TipoAccion)">
                                    <feather-icon :icon="$store.state.app.botonIcono" class="mr-50" />
                                    <span class="align-middle">{{ $store.state.app.botonTexto }} </span>
                                </b-button>

                            </b-col>
                        </b-row>
                    </b-form>
                </b-col>
                <b-col cols="12" md="5" class="d-flex align-items-center justify-content-center mb-2 mb-md-0">
                    <b-row>
                        <b-col>
                            <b-row>
                                <b-col>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <b-form-group>
                                            <label class="d-inline d-lg-flex">Vista Imagen</label>
                                            <b-img :src="selectedImage" alt="Imagen" v-if="selectedImage"
                                                class="product-img" fluid width="250px" height="300px" />
                                        </b-form-group>
                                    </div>
                                </b-col>

                            </b-row>
                            <b-row>
                                <b-col>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <b-form-group>
                                            <label class="d-inline d-lg-flex" for="sb-maxmin">Cantidad Minima</label>
                                            <b-form-spinbutton id="sb-maxmin" v-model="txtCantMin" min="0" max="10000" />
                                        </b-form-group>
                                    </div>
                                </b-col>
                                <b-col>
                                    <b-form-group label="Cantidad" label-for="lbCantidad">
                                        <b-form-input id="txtCantidad" placeholder="Cantidad"
                                            :state="txtCantidad.length > 0 ? true : false" v-model="txtCantidad"
                                            type="number" />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
        </b-overlay>
    </section>
</template>

<script>

import {

    BButtonToolbar,
    BButtonGroup,
    BFormSpinbutton,
    BImg,
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
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import frmUnidades from '../../abm-Unidad/frmUnidades.vue';
import FrmMarca from '../../abm-Marca/frmMarca.vue';
import FrmCategoria from '../../abm-Categoria/frmCategoria.vue';
import printJS from 'print-js';
export default {
    components: {

        BButtonToolbar,
        BButtonGroup,
        ToastificationContent,
        BImg,
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
        BFormSpinbutton,
        frmUnidades,
        FrmMarca,
        FrmCategoria
    },
    directives: {
        Ripple,
    },
    data() {

        return {
            catNombre: "",
            cantidad_productos: "0",
            txtUtilidad: 0,
            txtCantMin: 5,
            opacity: "0.85",
            blur: "0.5rem",
            txtCodigoInterno: "",
            txtCodigoBarra: "0000000",
            cbx_Categoria: "",
            cbx_Marca: "",
            cbx_Unidad: "",
            txtNomArticulo: "",
            txtCosto: "",
            txtVenta: "",
            txtCantidad: "",

            selectedImage: null,
            showOverlay: false,
            booksCategoria: [
                {
                    id: "",
                    title: "",
                    icon: 'ListIcon',
                },
            ],
            selectedCategoria: {
                id: "0",
                title: "",
                icon: 'ListIcon',
            },
            booksMarca: [
                {
                    id: "",
                    title: "",
                    icon: 'ListIcon',
                },
            ],
            selectedMarca: {
                id: "0",
                title: "",
                icon: 'ListIcon',
            },

            booksUnidad: [
                {
                    id: "",
                    title: "",
                    icon: 'ListIcon',
                },
            ],

            selectedUnidad: {
                id: "0",
                title: "",
                icon: 'ListIcon',
            },
        };
    },
    watch: {
        txtUtilidad: function (newUtilidad) {
            // Convierte el valor de txtUtilidad a un número
            const utilidad = parseFloat(newUtilidad);

            // Verifica si el valor es un número válido
            if (!isNaN(utilidad)) {
                // Realiza el cálculo (3 / (1 - porcentaje de utilidad))
                const resultado = this.txtCosto / (1 - utilidad / 100);

                // Redondea el resultado a múltiplos de 10 centavos
                const roundedResult = Math.round(resultado * 10) / 10;

                // Actualiza el valor de txtVenta
                this.txtVenta = roundedResult.toFixed(2);
            } else {
                // Si el valor no es un número válido, establece txtVenta en vacío o en otro valor predeterminado
                this.txtVenta = "";
            }
        },
        selectedCategoria(newValue) {
            if (this.$store.state.app.TipoAccion != "editar" && this.$store.state.app.TipoAccion != "ver") {

                let me = this;

                var siguienteCodigo = 0
                var url = "api/auth/siguienteCodigo";
                const axios = require("axios");
                axios.get(url).then(function (response) {
                    var resp = response.data;

                    if (resp[0].siguiente == null) {
                        siguienteCodigo = 1
                        console.log(siguienteCodigo)
                        me.generarCodigoInterno(newValue.title, siguienteCodigo)
                    } else {

                        siguienteCodigo = resp[0].siguiente
                        console.log(siguienteCodigo)
                        me.generarCodigoInterno(newValue.title, siguienteCodigo)
                    }

                }).catch((e) => {
                    console.log("Evento Genera Codigo Interno " + e)
                    me.alertas("danger", "Seleccione un valor válido para generar el Código Interno.")
                });

                const formData = new FormData();
                formData.append("txt_catId", newValue.id);

                var url2 = "api/auth/CantidadCategoria";
                axios
                    .post(url2, formData)
                    .then(function (response) {
                        var resp = response.data;
                        debugger
                        if (resp.length === 0) {
                            me.catNombre = newValue.title.substring(0, 3);
                            me.cantidad_productos = "0";
                        }
                        else {
                            for (let i = 0; i < resp.length; i++) {
                                me.catNombre = resp[i].catNombre.substring(0, 3);
                                me.cantidad_productos = resp[i].cantidad_productos.toString();

                            }
                        }

                    })
                    .catch((e) => {
                        alert("Falla al Obenter los Datos 😭" + e);
                    });
            }
        }

    },
    mounted() {
        this.cbxCategoria()
        this.cbxMarca();
        this.cbxUnidad();
        if (this.$store.state.app.TipoAccion === "editar" || this.$store.state.app.TipoAccion === "ver") {

            this.TraeArticulo()
        }
    },
    computed: {

    },
    methods: {
        hola() {
            alert("hola")
        },


        cerrarVentana() {
            this.cbxCategoria(),
                this.cbxUnidad(),
                this.cbxMarca()

        },
        generarCodigoInterno(title, num) {

            const ultimoNumero = num; // Reemplazar con el último número obtenido de la consulta
            const codigoInterno = title.substr(0, 2) + ultimoNumero.toString();
            this.txtCodigoInterno = codigoInterno

        },
        handleImageChange(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.selectedImage = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                this.selectedImage = ''; // Limpiar la imagen si no se selecciona ninguna
            }
        },
        cbxCategoria() {
            let me = this;
            me.booksCategoria = [];
            var lista = [];
            var url = "api/auth/cbxCategoria";
            const axios = require("axios");
            axios.get(url).then(function (response) {
                var resp = response.data;
                for (let i = 0; i < resp.length; i++) {
                    lista.push({
                        id: resp[i].catId,
                        title: resp[i].catNombre,
                        icon: 'ListIcon',
                    });
                }
                me.booksCategoria = lista;
            }).catch((e) => {
                // alert("Error al Obtener Las Categorias " + e);
                console.log("cbxCategoria " + e)
                me.alertas("danger", "Categorias")
            });

        },

        cbxMarca() {
            let me = this;
            me.booksMarca = [];
            var lista = [];
            var url = "api/auth/cbxMarca";
            const axios = require("axios");
            axios.get(url).then(function (response) {
                var resp = response.data;
                for (let i = 0; i < resp.length; i++) {
                    // me.aDataCategoria.push({
                    //   value: resp[i].catId,
                    //   text: resp[i].catNombre,
                    // });
                    lista.push({
                        id: resp[i].marId,
                        title: resp[i].marNombre,
                        icon: 'ListIcon',
                    });
                }
                me.booksMarca = lista;
            }).catch((e) => {
                console.log("cbxMarca " + e)
                me.alertas("danger", "Marcas")
            });

        },
        cbxUnidad() {

            let me = this;
            me.booksUnidad = [];
            var lista = [];
            var url = "api/auth/cbxUnidad";
            const axios = require("axios");
            axios.get(url).then(function (response) {
                var resp = response.data;
                for (let i = 0; i < resp.length; i++) {

                    lista.push({
                        id: resp[i].uniId,
                        title: resp[i].uniNombre,
                        icon: 'ListIcon',
                    });
                }
                me.booksUnidad = lista;
            }).catch((e) => {
                console.log("cbxUnidad " + e)
                this.alertas("danger", "Unidad")
            });

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
            // alert(item["idnps"]);

            let me = this;
            const axios = require("axios").default;
            const params = new URLSearchParams();
            var url = "api/auth/EliminarNps";

            params.append("idnps", parseInt(item["idnps"]));
            axios
                .post(url, params)
                .then(function (response) {
                    if (response.status === 200) {
                        me.UsuarioAlerta("success");

                        me.isBusy = false;
                        // me.listArticulo();
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
            me.loaded = false;
            me.Loading = "";
            me.filter = null;
            me.filterOn = [];
            me.iExiste = 0;
            me.estado = "";
            me.txtCodigoInterno = "";
            me.txtCodigoBarra = "";
            me.txtNomArticulo = "";
            me.selectedCategoria.id = "";
            me.selectedCategoria.title = "";
            me.selectedMarca.id = "";
            me.selectedMarca.title = "";
            me.selectedUnidad.id = "";
            me.selectedUnidad.title = ""
            me.txtCosto = 0;
            me.txtVenta = 0;
            me.txtCantidad = 0;
            me.selectedImage = '';
        },
        makeToast(variant) {
            let me = this;
            if (variant === "success") {
                this.$bvToast.toast("Registro Exitoso ", {
                    title: `Gerente Digital`,
                    variant,
                    solid: true,
                    appendToast: true,
                });
            } else {
                this.$bvToast.toast("Error en el Registro ", {
                    title: `Gerente Digital`,
                    variant,
                    solid: true,
                    appendToast: true,
                });
            }
        },

        // mesajes para usuario
        alertas(variant, texto) {
            this.$toast({
                component: ToastificationContent,
                props: {
                    title: 'Notificación',
                    icon: 'XIcon',
                    text: '👋 Error al Obtener los datos  ' + texto,
                    variant,
                },

            },)
            this.txtCodigoInterno = ''

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
                    text: "Alugnos de los Campos estan Vacios",
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

        // operaciones
        Guardar() {
            let me = this;
            debugger
            me.showOverlay = true;
            const hoy = new Date();
            var fechaRegistro = MesActual(hoy, "yy-mm-dd HH:MM:SS.000000");
            me.fechaRegistro = fechaRegistro;
            const axios = require("axios").default;
            const formData = new FormData();

            me.items = [];
            var urlm = "api/auth/guardarArticulo";
            me.loaded = false;
            me.isBusy = true;

            formData.append("txt_artCodigo", me.txtCodigoInterno);
            formData.append("txt_artCodigoBarra", me.txtCodigoBarra);
            formData.append("txt_artNombre", me.txtNomArticulo);
            formData.append("cbx_catId", me.selectedCategoria.id);
            if (me.selectedMarca.id === "0") {
                this.alertas("danger", "Debe Seleccionar Una Marca")
                me.showOverlay = false
                return
            }
            if (me.selectedUnidad.id === "0") {
                this.alertas("danger", "Debe Seleccionar Una Unidad")
                me.showOverlay = false
                return
            }
            formData.append("cbx_marId", me.selectedMarca.id);
            formData.append("cbx_uniId", me.selectedUnidad.id);
            formData.append("txt_artCosto", me.txtCosto);
            formData.append("txt_artPrecioVenta", me.txtVenta);
            formData.append("txt_artCantidad", me.txtCantidad);
            formData.append("txtCantMin", me.txtCantMin);

            formData.append("UsuarioId", this.$store.state.app.UsuarioId);
            formData.append("artActivo", 1);
            formData.append("artFechaCreacion", me.fechaRegistro);

            const fileInput = document.getElementById("file-small");
            const file = fileInput.files[0];

            if (file) {
                // Agregar la foto al formulario de datos
                formData.append("artFoto", file);
            }

            axios
                .post(urlm, formData)
                .then(function (response) {
                    // alert(response.status)

                    if (response.status == 201) {
                        me.showOverlay = false;
                        me.UsuarioAlerta("success");
                        me.isBusy = false;
                        me.limpiarVariables();
                    } else {
                        me.UsuarioAlerta("danger");
                    }
                })
                .catch((e) => {
                    me.UsuarioAlerta("error");
                    me.showOverlay = false;
                    console.log("danger", "No se Realizó la Operación: " + e);
                });
        },
        mofificar() {
            let me = this;
            me.showOverlay = true;
            const hoy = new Date();
            var fechaRegistro = MesActual(hoy, "yy-mm-dd HH:MM:SS.000000");
            me.fechaRegistro = fechaRegistro;
            const axios = require("axios").default;
            const formData = new FormData();

            me.items = [];
            var urlm = "api/auth/modificarArticulo";
            me.loaded = false;
            me.isBusy = true;
            formData.append('artId', this.$store.state.app.idUtilitario);
            formData.append("txt_artCodigo", me.txtCodigoInterno);
            formData.append("txt_artCodigoBarra", me.txtCodigoBarra);
            formData.append("txt_artNombre", me.txtNomArticulo);
            formData.append("cbx_catId", me.selectedCategoria.id);
            formData.append("cbx_marId", me.selectedMarca.id);
            formData.append("cbx_uniId", me.selectedUnidad.id);
            formData.append("txt_artCosto", me.txtCosto);
            formData.append("txt_artPrecioVenta", me.txtVenta);
            formData.append("txt_artCantidad", me.txtCantidad);
            formData.append("txtCantMin", me.txtCantMin);
            formData.append("UsuarioId", this.$store.state.app.UsuarioId);
            formData.append("artActivo", 1);
            formData.append("artFechaCreacion", me.fechaRegistro);
            const fileInput = document.getElementById("file-small");
            const file = fileInput.files[0];

            if (file) {
                // Agregar la foto al formulario de datos
                formData.append("artFoto", file);
            }

            axios
                .post(urlm, formData)
                .then(function (response) {
                    // alert(response.status)

                    if (response.status == 201) {
                        me.showOverlay = false;
                        me.UsuarioAlerta("success");
                        me.isBusy = false;
                        me.limpiarVariables();
                    } else {
                        me.UsuarioAlerta("danger");
                    }
                })
                .catch((e) => {
                    me.UsuarioAlerta("error");
                    me.showOverlay = false;
                    console.log("danger", "No se Realizó la Operación: " + e);
                });
        },

        // eventos
        onContext(ctx) {
            // The date formatted in the locale, or the `label-no - date - selected` string
            this.formatted = ctx.selectedFormatted;
            // The following will be an empty string until a valid date is entered
            this.mesReporte = ctx.selectedYMD;
        },
        // valida Operación
        validaOperacion(accion) {
            if (accion === "guardar") { this.Guardar() }
            if (accion === "editar") { this.mofificar() }
            if (accion === "ver") { alert("ajecutara el ver") }

        },
        // Listados 
        TraeArticulo() {
            let me = this;
            const axios = require("axios").default;
            const params = new URLSearchParams();
            // alert(this.$store.state.app.idUtilitario)
            params.append('artId', this.$store.state.app.idUtilitario);
            me.items = [];

            var url = "api/auth/TraeArticulo";
            me.loaded = false;
            var lista = [];
            axios
                .post(url, params)
                .then(function (response) {
                    var resp = response.data;
                    for (let i = 0; i < resp.length; i++) {
                        me.txtCodigoInterno = resp[i].artCodigo
                        me.txtCodigoBarra = resp[i].artCodigoBarra
                        me.txtNomArticulo = resp[i].artNombre
                        me.selectedCategoria = { id: resp[i].catId, title: resp[i].catNombre, }
                        me.selectedMarca = { id: resp[i].marId, title: resp[i].marNombre }
                        me.selectedUnidad = { id: resp[i].uniId, title: resp[i].uniNombre }
                        me.txtCosto = resp[i].artCosto
                        me.txtVenta = resp[i].artPrecioVenta
                        me.txtCantidad = (resp[i].artCantidad).toString()
                        me.selectedImage = 'data:image/png;base64,' + resp[i].artFoto
                        me.txtCantMin = resp[i].artCantMin
                    }
                    me.items = lista;
                    me.loaded = true;
                })
                .catch((e) => {
                    alert("error al obtener los datos Lista Articulo " + e);
                });
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
<style lang="scss">
@import '~@resources/scss/vue/libs/vue-select.scss';
@import "~@resources/scss/base/pages/app-ecommerce-details.scss";

/* Estilos para dispositivos móviles */
@media screen and (max-width: 767px) {
    .form-textarea {
        font-size: 16px;
        /* Tamaño de letra para dispositivos móviles */
    }
}

/* Estilos para dispositivos no móviles */
@media screen and (min-width: 768px) {
    .form-textarea {
        font-size: 15px;
        /* Tamaño de letra para dispositivos no móviles */
    }
}

.form-textarea {
    text-transform: uppercase;
}

@media print {

    // Global Styles
    body {
        background-color: transparent !important;
    }

    nav.header-navbar {
        display: none;
    }

    .main-menu {
        display: none;
    }

    .header-navbar-shadow {
        display: none !important;
    }

    .content.app-content {
        margin-left: 0;
        padding-top: 2rem !important;
    }

    footer.footer {
        display: none;
    }

    .card {
        background-color: transparent;
        box-shadow: none;
    }

    .customizer-toggle {
        display: none !important;
    }

    // Invoice Specific Styles
    .invoice-preview-wrapper {
        .row.invoice-preview {
            .col-md-8 {
                max-width: 100%;
                flex-grow: 1;
            }

            .invoice-preview-card {
                .card-body:nth-of-type(2) {
                    .row {
                        >.col-12 {
                            max-width: 50% !important;
                        }

                        .col-12:nth-child(2) {
                            display: flex;
                            align-items: flex-start;
                            justify-content: flex-end;
                            margin-top: 0 !important;
                        }
                    }
                }
            }
        }

        // Action Right Col
        .invoice-actions {
            display: none;
        }
    }
}
</style>