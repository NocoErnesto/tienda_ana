<template>
    <section>
        <b-modal ref="frmProveedor" id="frmProveedor" ok-title="Cerrar" ok-variant="danger" ok-only size="md" centered
            title="Registro de Cliente" no-close-on-backdrop @ok="cbxProveedor" @hidden="cerrarVentana">
            <!-- Diseño del Formulario -->
            <frm-proveedor></frm-proveedor>
        </b-modal>

        <b-row v-show="txtNumero != ''">
            <b-col sm="12" md="12" xl="12">
                <b-card border-variant="info">
                    <h5>Nro. de Compra: <b style="font-size: x-large;">{{ txtNumero }}</b>, Monto disponible caja Gastos: <b
                            style="font-size: x-large;">{{ cjtSaldoAperturaDia.toFixed(2) }}</b></h5>
                </b-card>
            </b-col>
        </b-row>
        <b-row v-show="txtNumero == ''">
            <b-col sm="12" md="12" xl="12">
                <b-card border-variant="info">
                    <h5>Monto disponible caja Gastos: <b style="font-size: x-large;">{{ cjtSaldoAperturaDia.toFixed(2)
                    }}</b>
                    </h5>
                </b-card>
            </b-col>
        </b-row>
        <b-row>
            <b-col sm="12" md="3" xl="3">
                <b-row>
                    <b-col>
                        <b-card border-variant="info">
                            <b-row>
                                <b-col sm="10" md="10" xl="10">

                                    <b-form-group>
                                        <label for="tipoPago">Proveedor</label>
                                        <v-select label="title" placeholder="Seleccionar Proveedor" class="select-size-lg"
                                            v-model="selectedProveedor" :options="gntProveedor" :max-options="3">
                                        </v-select>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="2" md="2" xl="2" lg="2">
                                    <b-form-group>
                                        <b-button v-ripple.400="'rgba(40, 199, 111, 0.15)'" variant="flat-success"
                                            v-b-modal.frmProveedor class="btn-icon">
                                            <feather-icon icon="PackageIcon" />
                                        </b-button>
                                    </b-form-group>

                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col sm="12" md="12" xl="12">
                                    <b-form-group>
                                        <label for="tipoPago">Fecha de Compra:</label>
                                        <b-form-datepicker v-model="txtFechaCompra"></b-form-datepicker>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group>
                                        <label>Total a Pagar</label>
                                        <b-form-input disabled class="montos" v-model="totalPagarCalculado"></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                        </b-card>
                    </b-col>
                </b-row>
            </b-col>
            <b-col sm="12" md="9" xl="9" class="mb-1">
                <b-row>
                    <b-col>
                        <b-card border-variant="info">
                            <b-row>
                                <b-col>
                                    <b-form-group>
                                        <label class="d-inline d-lg-flex">Buscar Producto</label>
                                        <v-select ref="selectedProductos" v-model="selectedProductos"
                                            :options="booksProductos" label="title" placeholder="Seleccionar"
                                            class="select-size-lg" :max-options="3" @input="AgregarProductoDetalle()">
                                            <template #option="{ title, icon, cantidad, marca }">

                                                <div class="d-flex align-items-center">
                                                    <div class="product-image-container">
                                                        <img v-if="icon" :src="'data:image/jpeg;base64,' + icon"
                                                            alt="Sin Foto" />
                                                    </div>
                                                    <div class="product-details">
                                                        <strong>{{ title }}</strong>
                                                        <div class="text-secondary ">Stock: {{ cantidad }}</div>
                                                        <div class="text-secondary">Marca:{{ marca }}</div>
                                                    </div>
                                                </div>
                                            </template>
                                        </v-select>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <!-- Tabla --> <!-- Listado -->
                                    <b-table id="tabla-lista-detalle" :items="itemsAgregado" :fields="fieldsAgregado"
                                        :filter="filter" @filtered="onFiltered" hover :busy="isBusy" :bordered="true"
                                        outlined stacked="sm" small :style="{ fontSize: fontSize }">
                                        <template #cell(precioC)="row">
                                            <b-form-input v-model="row.value" type="number" min="1"
                                                @input="actualizarSubtotal(row.item, row.value)" ref="PrecioInput"
                                                :state="row.value > 0 ? true : false"
                                                v-b-tooltip.hover.top.right="row.value > 0 ? '' : 'Precio debe ser mayor a cero'"
                                                :show="row.value === 0" :trigger="'hover focus'"
                                                class="v-b-tooltip-dark text-center" />
                                        </template>
                                        <template #cell(cantidad)="row">
                                            <b-form-input v-model="row.value" type="number" min="1"
                                                @input="actualizarCantidad(row.item, row.value)" ref="cantidadInput"
                                                :state="row.value > 0 ? true : false"
                                                v-b-tooltip.hover.top.right="row.value > 0 ? '' : 'Cantidad debe ser mayor que cero'"
                                                :show="row.value === 0" :trigger="'hover focus'"
                                                class="v-b-tooltip-dark text-center" />
                                        </template>

                                        <template #cell(Acción)="row">
                                            <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'" variant="flat-danger"
                                                class="btn-icon rounded-circle"
                                                :class="{ 'd-none': $store.state.app.isElimina }"
                                                @click="clickAccion(row.item, row.index, ('eliminar'))">
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
                        </b-card>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col>
                        <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'" :variant="$store.state.app.variant"
                            :class="$store.state.app.classButton" @click="validaOperacion($store.state.app.TipoAccion)">
                            <feather-icon :icon="$store.state.app.botonIcono" class="mr-50" />
                            <span class="align-middle">{{ $store.state.app.botonTexto }} </span>
                        </b-button>
                    </b-col>

                </b-row>
            </b-col>
        </b-row>


    </section>
</template>
<script>
import {
    VBTooltip,
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
import jsPDF from 'jspdf';
import 'jspdf-autotable';
import FrmProveedor from '../abm-Proveedor/frmProveedor.vue';
export default {
    components: {
        VBTooltip,
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
        FrmProveedor
    },
    data() {
        return {
            tiposPago: [],
            SelectedtipoPago: null, // Tipo de pago seleccionado
            gntProveedor: [],
            selectedProveedor: null,
            tipoCompra: [{ id: "0", title: "CONTADO" }, { id: "1", title: "CREDITO" }],
            selectedTipoCompra: null,
            totalPagar: 0, // Total a pagar
            montoRecibido: 0,
            txtId: null,
            txtNumero: "",
            txtUserId: "",
            txtFechaCompra: null,
            cjtReferencia: 0, // Monto recibido,
            cjtSaldoAperturaDia: 0,
            cambio: 0, // Cambio a entregar
            isBusy: false,
            filter: "",
            stickyHeader: true,
            headVariant: "dark",
            fontSize: "",
            booksProductos: [
            ],
            selectedProductos: {
                id: "0",
                title: "",
                icon: 'ListIcon',
                precioC: 0,
                cantidad: 0,
                subtotal: 0
            },

            itemsAgregado: [],
            fieldsAgregado: [
                { key: "id", label: "codigo", sortable: true, tdClass: "text-center text-bold" },
                { key: "title", label: "PRODUCTO", sortable: true, tdClass: "text-left" },
                { key: "precioC", label: "PRECIO", sortable: true, tdClass: "text-center text-bold" },
                { key: "cantidad", label: "CANTIDAD", sortable: false, tdClass: "text-center text-bold" },
                { key: "subtotal", label: "SUBTOTAL", sortable: false, tdClass: "text-center text-bold" },
                { key: "Acción", sortable: false, tdClass: "text-center" },
            ],
        }
    },
    watch: {
        // montoRecibido: function (nuevoMonto) {
        //     // Calcular el cambio
        //     this.cambio = nuevoMonto - this.totalPagar

        // }
    },
    directives: {
        "b-tooltip": VBTooltip,
        Ripple,
    },

    created() {
        this.sizeTablas()


    },


    mounted() {
        let me = this
        me.cbxArticulo()
        me.cbxFormaPago()
        me.cbxProveedor()


        if (this.$store.state.app.TipoAccion === "editar" || this.$store.state.app.TipoAccion === "ver") {
            this.GetShoppingById()
        }
        me.GetSaldoCajaActual()

    },
    computed: {



        totalPagarCalculado() {
            return this.itemsAgregado.reduce((total, item) => {

                this.totalPagar = total + item.precioC * item.cantidad
                this.montoRecibido = 0;
                this.cambio = 0;

                var parteDecimal = this.totalPagar % 1;
                if (parteDecimal > 0.5) {
                    return Math.ceil(this.totalPagar)
                } else {
                    return this.totalPagar
                }


            }, 0);
        },
    },
    methods: {
        /**
         * Funcion para notificar alertas de las eventualidades (Success, Warning, Error, etc)
         *  */
        AlertaMensaje(variant, msj) {
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

        //eventos 

        cbxFormaPago() {
            let me = this;
            const axios = require("axios").default;
            me.isBusy = true;
            var url = "api/auth/ListaFormaPago";
            me.loaded = false;
            var lista = [];
            axios.get(url).then(function (response) {
                var resp = response.data;
                for (let i = 0; i < resp.length; i++) {
                    lista.push({
                        id: resp[i].fpId,
                        title: resp[i].fpnombre,
                    });
                }
                me.tiposPago = lista;
                me.isBusy = false;
                me.loaded = true;
            }).catch((e) => {
                AlertaMensaje("error", "Obtener Datos Forma de Pago, Detalles: ", e.response.data.error);
            });
        },
        cbxArticulo() {
            let me = this;
            const axios = require("axios").default;
            me.items = [];
            me.isBusy = true;
            var url = "api/auth/listArticulo";
            me.loaded = false;
            var lista = [];
            axios.get(url).then(function (response) {
                var resp = response.data;
                for (let i = 0; i < resp.length; i++) {
                    lista.push({
                        id: resp[i].artId,
                        title: resp[i].artNombre,
                        icon: resp[i].artFoto,
                        precioC: resp[i].artCosto,
                        cantidad: resp[i].artCantidad,
                        marca: resp[i].marNombre
                    });
                }
                me.booksProductos = lista;
                me.isBusy = false;
                me.loaded = true;
            }).catch((e) => {
                AlertaMensaje("error", "Obtener Datos de Articulos, Detalles: " + e.response.data.error);
            });
        },

        cerrarVentana() {
            this.cbxProveedor()
        },
        cbxProveedor() {
            let me = this;
            const axios = require("axios").default;
            me.items = [];
            me.isBusy = true;
            var url = "api/auth/listarProveedores";
            me.loaded = false;
            var lista = [];
            axios.get(url).then(function (response) {
                var resp = response.data;
                for (let i = 0; i < resp.length; i++) {
                    lista.push({
                        id: resp[i].provID,
                        title: resp[i].provNombre + " - " + resp[i].provTelefono,
                    });
                }
                me.gntProveedor = lista;
                me.isBusy = false;
                me.loaded = true;
            }).catch((e) => {
                AlertaMensaje("error", "Obtener Datos de Proveedores, Detalles: " + e.response.data.error);
            });
        },
        AgregarProductoDetalle() {
            if (this.selectedProductos) {
                // Verificar si el producto ya está en la lista itemsAgregado
                const productoExistente = this.itemsAgregado.find(item => item.id === this.selectedProductos.id);

                if (!productoExistente) {
                    // Si el producto no existe en la lista, lo agregamos
                    this.itemsAgregado.push({ ...this.selectedProductos, cantidad: 1, subtotal: this.selectedProductos.precioC });
                } else {
                    // Si el producto ya existe, puedes mostrar un mensaje de alerta o realizar otra acción
                    this.AlertaMensaje("warning", 'El articulo seleccionado ya está en la lista');
                }
                // Resetea el valor de selectedProductos para deseleccionar la opción
                this.selectedProductos = null;
                this.$nextTick(() => {
                    this.$refs.cantidadInput.focus();
                });
            }
        },
        //Metodos Con logica de Negocios
        vaciarControles() {
            const me = this
            me.selectedProveedor = null
            me.itemsAgregado = []
            me.montoRecibido = 0
            me.cambio = 0
        },
        GetShoppingById() {
            let me = this;
            const axios = require("axios").default;
            // alert(this.$store.state.app.idUtilitario)
            let parametros = '?cmtId=' + this.$store.state.app.idUtilitario
            me.items = [];

            var url = "api/auth/GetShoppingById";
            me.loaded = false;
            me.itemsAgregado = [];
            axios.get(url + parametros).then(function (response) {
                var resp = response.data.data;
                me.txtId = resp.cmtId;
                me.txtUserId = resp.userId;
                me.selectedProveedor = { id: resp.provId, title: resp.provNombre, };
                me.txtNumero = resp.cmtNumero;
                me.txtFechaCompra = resp.cmtFechaCompra;
                var detalle = response.data.detalle;

                for (let i = 0; i < detalle.length; i++) {
                    me.itemsAgregado.push({
                        id: detalle[i].artid,
                        title: detalle[i].artNombre,
                        cantidad: detalle[i].cmdCantidad,
                        precioC: detalle[i].cmdCosto,
                        subtotal: (detalle[i].cmdCantidad * detalle[i].cmdCosto)
                    });
                }
                me.loaded = true;
            })
                .catch((e) => {
                    alert("error al obtener los datos de Compra " + e);
                });
        },
        GurdarMovimientoCaja() {
            const me = this;
            const axios = require("axios").default;
            const formData = new FormData();
            formData.append("cajId", 2); // 2=Gastos de Compra
            formData.append("userId", this.$store.state.app.UsuarioId); // ID del usuario actual
            formData.append("cjtReferencia", me.cjtReferencia);
            formData.append("cjtModulo", "COMPRAS");
            formData.append("cjtMonto", me.totalPagar)
            formData.append("cjtDescripcion", "Egresos Por Compra");
            formData.append("ttxnId", 2); // 2=Egresos
            axios.post("api/auth/guardarMovimientoCaja", formData, {
                headers: { "Content-Type": "multipart/form-data" }
            }).then(function (response) {
                if (response.status === 201) {
                    console.log(response.data.mensaje)
                }
            }).catch((e) => {
                me.showOverlay = false;
                me.AlertaMensaje("error", "Guardar Movimiento en Caja, Detalles: ", e.response.data.error);
            });
        },
        AddShopping() {
            const me = this;
            me.showOverlay = true;
            const hoy = new Date();
            const axios = require("axios").default;
            const formData = new FormData();
            // if (me.selectedProveedor === null || me.selectedTipoCompra === null || me.SelectedtipoPago === null) {
            //     return me.AlertaMensaje("error", "Faltan Datos Para Ingresar")
            // }
            if (me.selectedProveedor === null) {
                return me.AlertaMensaje("warning", "Faltan completar campos requeridos para el registro..")
            }
            if (me.txtFechaCompra === null) {
                return me.AlertaMensaje("warning", "Faltan completar campos requeridos para el registro..")
            }
            if (me.totalPagar > me.cjtSaldoAperturaDia) {
                return me.AlertaMensaje("warning", "No puede realizar la compra, esta excediendo el monto total al saldo de caja apertura para Gastos..")
            }
            formData.append("provId", me.selectedProveedor.id); //  ID del Proveedor
            formData.append("userId", this.$store.state.app.UsuarioId); // ID del usuario actual
            formData.append("txnId", 2); //ID del tipo de transacción 1=Ingreso, 2=Egreso
            formData.append("cmtFechaCompra", me.txtFechaCompra)
            formData.append("cmtActivo", 1); // Esto puede ser 1 o 0 según corresponda (activo o no)
            // Construye un array de detalles de Compra
            const detallesCompra = this.itemsAgregado.map(item => ({
                artId: item.id, // ID del artículo
                cmdCantidad: item.cantidad, // Cantidad vendida
                cmdCosto: parseFloat(item.precioC), // Precio de Compra
                vndActivo: 1 // Activo (ajusta según necesites)
            }));
            if (detallesCompra.length <= 0) {
                return me.AlertaMensaje("warning", "Debe agregar al menos un producto para realizar el registro de compra.")
            }
            formData.append("detallesCompra", JSON.stringify(detallesCompra));
            axios.post("api/auth/AddShopping", formData, {
                headers: { "Content-Type": "multipart/form-data" }
            }).then(function (response) {
                if (response.status === 201) {
                    me.showOverlay = false;
                    me.cjtReferencia = response.data.cjtReferencia;
                    debugger
                    me.GurdarMovimientoCaja()
                    me.generatePDF(me.itemsAgregado)
                    me.isBusy = false;
                    me.vaciarControles()
                    me.GetSaldoCajaActual()
                    me.AlertaMensaje("success", response.data.mensaje); s
                }
            }).catch((e) => {
                me.showOverlay = false;
                me.AlertaMensaje("error", "Guardar Registro Compra, Detalles: ", e.response.data.error);
            });
        },
        UpdateShopping() {
            const me = this;
            me.showOverlay = true;
            const hoy = new Date();
            const axios = require("axios").default;
            const formData = new FormData();
            // if (me.selectedProveedor === null || me.selectedTipoCompra === null || me.SelectedtipoPago === null) {
            //     return me.AlertaMensaje("error", "Faltan Datos Para Ingresar")
            // }
            if (me.selectedProveedor === null) {
                return me.AlertaMensaje("warning", "Faltan completar campos requeridos para el registro..")
            }
            if (me.txtFechaCompra === null) {
                return me.AlertaMensaje("warning", "Faltan completar campos requeridos para el registro..")
            }
            if (me.totalPagar > me.cjtSaldoAperturaDia) {
                return me.AlertaMensaje("warning", "Está excediendo el monto total al saldo de caja aperturada para Gastos..")
            }
            formData.append("cmtId", this.$store.state.app.idUtilitario);
            formData.append("provId", me.selectedProveedor.id); //  ID del Proveedor
            formData.append("userId", this.$store.state.app.UsuarioId); // ID del usuario actual
            formData.append("cmtFechaCompra", me.txtFechaCompra)
            /**
             * Se construye un array para el detalle de compras
             */
            const detallesCompra = this.itemsAgregado.map(item => ({
                artId: item.id,
                cmdCantidad: item.cantidad,
                cmdCosto: parseFloat(item.precioC),
                vndActivo: 1
            }));
            if (detallesCompra.length <= 0) {
                return me.AlertaMensaje("warning", "Debe agregar al menos un producto para realizar el registro de compra.")
            }
            formData.append("detallesCompra", JSON.stringify(detallesCompra));
            axios.post("api/auth/UpdateShopping", formData, {
                headers: { "Content-Type": "multipart/form-data" }
            }).then(function (response) {
                if (response.status === 200) {
                    me.showOverlay = false;
                    me.cjtReferencia = response.data.cjtReferencia;

                    me.GurdarMovimientoCaja()
                    debugger
                    me.generatePDF(me.itemsAgregado)
                    me.isBusy = false;
                    me.vaciarControles()
                    me.GetSaldoCajaActual()
                    me.AlertaMensaje("success", response.data.mensaje);
                }
            }).catch((e) => {
                me.showOverlay = false;
                me.AlertaMensaje("error", "Actualizar Registro Compra, Detalles: ", e.response.data.error);
            });
        },
        GetSaldoCajaActual() {
            let me = this;
            const axios = require("axios").default;
            me.items = [];
            me.isBusy = true;
            var url = "api/auth/GetBalanceShopping";
            me.loaded = false;
            var lista = [];
            axios.get(url).then(function (response) {
                var resp = response.data;
                me.cjtSaldoAperturaDia = resp.dataSaldoCompras;
                me.isBusy = false;
                me.loaded = true;
            }).catch((e) => {
                me.AlertaMensaje("error", "Calcular Saldo Compras, Detalles: " + e.response);
            });
        },
        actualizarCantidad(item, nuevaCantidad) {
            item.cantidad = nuevaCantidad;
            const resultadoMultiplicacion = item.precioC * item.cantidad;
            var parteDecimal = resultadoMultiplicacion % 1;
            if (parteDecimal > 0.5) {
                item.subtotal = Math.ceil(resultadoMultiplicacion)
                console.log("0.5->" + resultadoMultiplicacion)

                return item.subtotal
            } else {
                item.subtotal = resultadoMultiplicacion
                console.log(" menor a 0.5->" + resultadoMultiplicacion)
                return item.subtotal;
            }


        },
        actualizarSubtotal(item, precio) {

            item.precioC = precio;
            const resultadoMultiplicacion = item.precioC * item.cantidad;
            var parteDecimal = resultadoMultiplicacion % 1

            if (parteDecimal > 0.5) {
                item.subtotal = Math.ceil(resultadoMultiplicacion)
                return item.subtotal
            } else {
                item.subtotal = resultadoMultiplicacion
                return item.subtotal;
            }









        },

        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
        },
        eliminarProducto(index) {
            if (index >= 0 && index < this.itemsAgregado.length) {
                this.itemsAgregado.splice(index, 1);
                this.montoRecibido = 0
                this.cambio = 0
            }
        },
        ControlaEliminar(item, index) {
            this.boxTwo = "";
            this.$bvModal.msgBoxConfirm(
                "El Registro  " + " : " + item["title"] + " Serán Eliminados",
                {
                    title: "Advertencia",
                    size: "sm",
                    okVariant: "outline-success",
                    okTitle: "Continuar",
                    cancelTitle: "Cancelar",
                    cancelVariant: "outline-danger",
                    hideHeaderClose: true,
                    centered: true
                }
            ).then((value) => {
                this.boxTwo = value;
                if (value === true) {
                    this.eliminarProducto(index);
                }
            });
        },
        generatePDF(Articulos) {
            try {
                // Crear un nuevo documento PDF
                const doc = new jsPDF();
                let me = this;

                // Agregar el logo de la empresa (reemplaza 'ruta_al_logo' con la ruta de tu imagen)
                const image = new Image();
                var imgData = 'data:image/png;base64,' + me.$store.state.app.LogoEmpresa;
                doc.addImage(imgData, 'PNG', 15, 5, 25, 25);
                doc.setFont('helvetica', 'neue')
                doc.setFontSize(8);
                // doc.text(me.$store.state.app.NombreEmpresa, 40, 20);
                doc.text(' DIRECCION : ' + me.$store.state.app.DireccionEmpresa, 40, 20);
                doc.text(' TELEFONO  : ' + me.$store.state.app.TelefonoEmpresa, 40, 25);
                doc.text(' Nit  : ' + me.$store.state.app.NitEmpresa, 40, 30);
                const currentDate = new Date(); // Obtiene la fecha actual
                const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
                const formattedDate = me.txtFechaCompra  //currentDate.toLocaleDateString('es-ES', options); // Formatea la fecha como "10/11/2023"

                // Configuración de la nota de venta
                const notaDeCompra = {
                    numero: (me.cjtReferencia == 0) ? me.txtNumero : me.cjtReferencia,
                    fecha: formattedDate,
                    cliente: me.selectedProveedor.title,
                    direccion: '123 Calle Principal',
                    ciudad: 'Ciudad Ejemplo',
                };


                // Datos de los productos
                const columns = ['Articulo', 'Cantidad', 'PrecioUnitario', 'SubTotal'];
                const rows = Articulos.map((producto) => {
                    const PrecioCompra = parseFloat(producto.precioC);
                    const subtotal = PrecioCompra * producto.cantidad;
                    const parteDecimal = subtotal % 1;
                    var decimaSuperior = 0.0
                    if (parteDecimal > 0.5) {

                        decimaSuperior = Math.ceil(subtotal)
                    } else {
                        decimaSuperior = subtotal
                    }
                    debugger
                    return [
                        producto.title || '',
                        producto.cantidad || 0,
                        PrecioCompra.toFixed(2), // Mostrar el precio original en la columna 'Precio'
                        decimaSuperior,
                    ];
                });

                doc.setFontSize(22);
                doc.setFont('helvetica', 'neue');
                doc.text('Nota de Compra', 135, 10);
                doc.setFontSize(14);
                doc.setFont('helvetica', 'neue');

                doc.text('N°:', 135, 20);
                // doc.setTextColor(110, 107, 123);
                doc.text(`${notaDeCompra.numero}`, 145, 20);
                doc.setTextColor(0);
                doc.setFont('helvetica', 'neue');
                doc.text(`Fecha: ${notaDeCompra.fecha}`, 135, 28);
                doc.setFont('helvetica', 'neue');
                // doc.setTextColor(0);
                doc.text("Proveedor:", 15, 52);
                // doc.setTextColor(100);
                doc.setFont('helvetica', 'neue');
                doc.text(`${notaDeCompra.cliente}`, 40, 52);
                const columnStyles = {
                    0: { halign: 'text-left' }, // Alineación centrada para la primera columna
                    1: { halign: 'center' }, // Alineación centrada para la segunda columna
                    2: { halign: 'center' }, // Alineación centrada para la tercera columna
                    3: { halign: 'center' }, // Alineación centrada para la cuarta columna
                };
                // Agregar la tabla de productos
                doc.autoTable({
                    startY: 60,
                    head: [columns],
                    body: rows,
                    columnStyles: columnStyles,
                });


                // Calcular el total
                // const total = Articulo.reduce((acc, producto) => acc + parseFloat(producto.precioV) * parseInt(producto.cantidad), 0);
                const total = Articulos.reduce((acc, producto) => {
                    const subtotal = parseFloat(producto.precioC) * parseInt(producto.cantidad);
                    return Math.round(acc + subtotal);
                }, 0);
                doc.setFont('helvetica', 'neue');
                doc.text(`Total Bs.:`, 145, doc.autoTable.previous.finalY + 10);
                doc.text(`${total.toFixed(2)}`, 175, doc.autoTable.previous.finalY + 10);

                doc.setFont('times', 'normal');
                doc.setFontSize(12);

                // Guardar el documento PDF como un Data URI
                const dataUri = doc.output('datauristring');

                // Abrir el PDF en una nueva ventana o pestaña
                const newWindow = window.open();
                newWindow.document.write('<iframe width="100%" height="100%" src="' + dataUri + '"></iframe');
            } catch (error) {
                me.UsuarioAlerta("error", "Error al generar el PDF: " + error.message);
            }
        },

        /** Realiza la Operacion Correspondiente */
        validaOperacion(accion) {
            if (accion === "guardar") { this.AddShopping() }
            if (accion === "editar") { this.UpdateShopping() }
            if (accion === "ver") { this.generatePDF(this.itemsAgregado) }
        },

        /** Este evento elimina Articulo del Carrito */
        clickAccion(item, index, accion) {
            if (accion === "eliminar") {
                this.ControlaEliminar(item, index)
            }
        },

        /**par validar el tamaño de las tablas en cada dispositivi */
        sizeTablas() {
            const anchoVentana = window.innerWidth;

            if (anchoVentana <= 576) {
                // Dispositivo móvil pequeño
                this.fontSize = 'x-small';
            } else if (anchoVentana <= 768) {
                // Dispositivo móvil o tableta
                this.fontSize = 'small';
            } else if (anchoVentana <= 992) {
                // Tableta o dispositivo de tamaño medio
                this.fontSize = 'medium';
            } else {
                // Pantalla de escritorio
                this.fontSize = 'large';
            }
        },

    }
}
</script>

<style lang="scss">
@import '~@resources/scss/vue/libs/vue-select.scss';
@import "~@resources/scss/base/pages/app-ecommerce-details.scss";
@import '~@resources/scss/vue/libs/vue-sweetalert.scss';

.product-image-container {
    width: 60px;
    height: 60px;
    margin-right: 10px;
    overflow: hidden;
    border-radius: 4px;
}

.product-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-details {
    flex-grow: 1;
    margin-left: 10px;
    /* Agrega un margen a la izquierda */
}

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


//para los totales ,recibido, cambios
.montos {
    font-size: 24px;
    /* Ajusta el tamaño de fuente según tus preferencias */
    font-weight: bold;
    /* Hace que el texto sea negrita */
    color: #007bff;
    /* Cambia el color del texto, si lo deseas */
    /* Agrega otros estilos según tus preferencias */
}
</style>