<template>
    <section>

        <b-modal ref="frmCliente" id="frmCliente" ok-title="Cerrar" ok-variant="danger" ok-only size="md" centered
            title="Registro de Cliente" no-close-on-backdrop @ok="cbxCliente" @hidden="cerrarVentana">
            <!-- Diseño del Formulario -->


            <frm-cliente></frm-cliente>


        </b-modal>

        <b-row>


            <b-col sm="12" md="3" xl="3">
                <b-row>
                    <b-col>
                        <b-card border-variant="info">

                            <b-row>
                                <b-col sm="10" md="10" xl="10" lg="10">

                                    <b-form-group>
                                        <label for="tipoPago">Cliente</label>
                                        <v-select v-model="selectedCliente" :options="gntCliente" label="title"
                                            placeholder="Seleccionar Cliente" class="select-size-lg" :max-options="3">

                                        </v-select>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="2" md="2" xl="2" lg="2">
                                    <b-form-group>
                                        <b-button v-ripple.400="'rgba(40, 199, 111, 0.15)'" variant="flat-success"
                                            v-b-modal.frmCliente class="btn-icon">
                                            <feather-icon icon="UserPlusIcon" />
                                        </b-button>
                                    </b-form-group>

                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col sm="12" md="12" xl="12">
                                    <b-form-group>
                                        <label for="tipoPago">Tipo Venta</label>

                                        <v-select v-model="selectedTipoVenta" :options="tipoVenta" label="title"
                                            placeholder="Seleccionar" class="select-size-lg" :max-options="3">

                                        </v-select>
                                    </b-form-group></b-col>

                            </b-row>
                            <b-row>

                                <b-col sm="12" md="12" xl="12">
                                    <b-form-group>
                                        <label for="tipoPago">Forma de Pago</label>
                                        <v-select v-model="SelectedtipoPago" :options="tiposPago" label="title"
                                            placeholder="Seleccionar" class="select-size-lg" :max-options="3">
                                        </v-select>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col sm="12" md="12" xl="12">
                                    <b-form-group>
                                        <label for="tipoPago">Fecha de Venta:</label>
                                        <!-- <b-form-datepicker v-model="txtFechaVenta"></b-form-datepicker> -->
                                        <flat-pickr v-model="txtFechaVenta" class="form-control" />
                                    </b-form-group>



                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col>
                                    <b-form-group>
                                        <label>Total a Pagar</label>
                                        <b-form-input v-model="totalPagarCalculado" disabled class="montos"></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-form-group>
                                        <label for="montoRecibido">Monto Recibido</label>
                                        <b-form-input id="montoRecibido" v-model="montoRecibido"
                                            class="montos"></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group>
                                        <label>Cambio</label>
                                        <b-form-input v-model="cambio" class="montos" disabled></b-form-input>
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
                                            class="select-size-lg" :max-options="3" @input="cargarProducto()">
                                            <template #option="{ title, icon, precioV, cantidad, marca }">

                                                <div class="d-flex align-items-center">
                                                    <div class="product-image-container">
                                                        <img v-if="icon" :src="'data:image/jpeg;base64,' + icon"
                                                            alt="Sin Foto" />
                                                    </div>
                                                    <div class="product-details">
                                                        <strong>{{ title }}</strong>
                                                        <div class="text-secondary ">Precio: {{ precioV }}</div>
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
                                    <b-table id="tabla-lista-retrasos" :items="itemsAgregado" :fields="fieldsAgregado"
                                        :filter="filter" @filtered="onFiltered" hover :busy="isBusy" :bordered="true"
                                        outlined stacked="sm" small :style="{ fontSize: fontSize }">

                                        <template #cell(cantidad)="row">
                                            <b-form-input v-model="row.value" type="number" min="1"
                                                @input="actualizarCantidad(row.item, row.value)" ref="cantidadInput"
                                                :state="row.value > 0 ? true : false"
                                                v-b-tooltip.hover.top.right="row.value > 0 ? '' : 'Cantidad debe ser mayor que cero'"
                                                :show="row.value === 0" :trigger="'hover focus'"
                                                class="v-b-tooltip-dark text-center" />
                                        </template>

                                        <template #cell(descuento)="row">
                                            <b-form-input v-model="row.value" type="number" min="1"
                                                @input="precioDescuento(row.item, row.value)" ref="descuentoInput"
                                                :state="row.value > 0 ? true : false"
                                                v-b-tooltip.hover.top.right="row.value > row.item.precioV ? 'Descuento No Valido' : 'Cantidad debe ser mayor que cero'"
                                                :show="row.value === 0" :trigger="'hover focus'"
                                                class="v-b-tooltip-dark text-center" />
                                        </template>
                                        <template #cell(subtotal)="row">
                                            {{ row.item.descuento > 0 ? row.item.descuento * row.item.cantidad
                                                : row.item.precioV * row.item.cantidad }}
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
    BIconNutFill,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import vSelect from 'vue-select'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import flatPickr from 'vue-flatpickr-component'

import jsPDF from 'jspdf';
import 'jspdf-autotable';
import FrmCliente from '../abm-Cliente/frmCliente.vue';
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
        flatPickr,
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
        FrmCliente
    },
    data() {
        return {
            tiposPago: [],
            SelectedtipoPago: null, // Tipo de pago seleccionado
            gntCliente: [],
            selectedCliente: null,
            tipoVenta: [{ id: "0", title: "CONTADO" }, { id: "1", title: "CREDITO" }],
            selectedTipoVenta: null,
            totalPagar: 0, // Total a pagar
            montoRecibido: 0,
            cjtReferencia: 0, // Monto recibido
            cambio: 0, // Cambio a entregar
            vntNumero: "",
            txtFechaVenta: null,
            isBusy: false,
            filter: "",
            stickyHeader: true,
            headVariant: "dark",
            booksProductos: [
            ],
            selectedProductos: {
                id: "0",
                title: "",
                icon: 'ListIcon',
                precioV: 0,
                descuento: 0,
                cantidad: 0,
                subtotal: 0
            },

            itemsAgregado: [],
            fieldsAgregado: [
                { key: "id", label: "codigo", sortable: true, tdClass: "text-center text-bold" },
                { key: "title", label: "PRODUCTO", sortable: true, tdClass: "text-left" },
                { key: "precioV", label: "PRECIO", sortable: true, tdClass: "text-center text-bold" },
                { key: "descuento", label: "DESCUENTO", sortable: true, tdClass: "text-center text-bold" },
                { key: "cantidad", label: "CANTIDAD", sortable: false, tdClass: "text-center text-bold" },
                { key: "subtotal", label: "SUBTOTAL", sortable: false, tdClass: "text-center text-bold" },
                { key: "Acción", sortable: false, tdClass: "text-center" },
            ],
        }
    },
    watch: {
        montoRecibido: function (nuevoMonto) {
            // Calcular el cambio
            this.cambio = nuevoMonto - this.totalPagar

        }



    },
    directives: {
        "b-tooltip": VBTooltip,
        Ripple,
    },

    mounted() {
        this.cbxArticulo()
        this.cbxFormaPago()
        this.cbxCliente()

        const movil = window.innerWidth;
        if (movil <= 576) {
            // Dispositivo móvil pequeño
            this.fontSize = 'xx-small'; // Tamaño de fuente pequeño
        }

    },
    computed: {

        totalPagarCalculado() {
            return this.itemsAgregado.reduce((total, item) => {

                this.totalPagar = total + item.descuento * item.cantidad;
                this.montoRecibido = 0;
                this.cambio = 0;
                var parteDecimal = this.totalPagar % 1;

                if (item.descuento !== 0) {

                    this.totalPagar = total + item.descuento * item.cantidad;
                    if (parteDecimal > 0.5) {
                        return Math.ceil(this.totalPagar)
                    } else {

                        return this.totalPagar;
                    }
                } else {

                    this.totalPagar = total + item.precioV * item.cantidad;
                    return this.totalPagar;
                }
            }, 0);
        },
    },
    methods:
    {


        generatePDF(Articulo) {
            try {
                // Crear un nuevo documento PDF
                const doc = new jsPDF();
                let me = this;
                debugger
                // Agregar el logo de la empresa (reemplaza 'ruta_al_logo' con la ruta de tu imagen)
                const image = new Image();
                var imgData = 'data:image/png;base64,' + me.$store.state.app.LogoEmpresa;
                doc.addImage(imgData, 'PNG', 15, 5, 25, 25);
                doc.setFont('helvetica', 'neue')
                doc.setFontSize(8);
                // doc.text(me.$store.state.app.NombreEmpresa, 40, 20);
                doc.text('DIRECCION : ' + me.$store.state.app.DireccionEmpresa, 40, 20);
                doc.text('TELEFONO  : ' + me.$store.state.app.TelefonoEmpresa, 40, 25);
                doc.text('Nit  : ' + me.$store.state.app.NitEmpresa, 40, 30);
                const currentDate = new Date(); // Obtiene la fecha actual



                const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
                const formattedDate = me.txtFechaVenta// currentDate.toLocaleDateString('es-ES', options); // Formatea la fecha como "10/11/2023"

                // Configuración de la nota de venta
                const notaDeVenta = {
                    numero: me.cjtReferencia,
                    fecha: formattedDate,
                    cliente: me.selectedCliente.title,
                    direccion: '123 Calle Principal',
                    ciudad: 'Ciudad Ejemplo',
                };


                // Datos de los productos
                const columns = ['Articulo', 'Cantidad', 'PrecioUnitario', 'Descuento', 'SubTotal'];
                const rows = Articulo.map((producto) => {
                    const precioOriginal = parseFloat(producto.precioV);
                    const precioUnitario = producto.descuento ? parseFloat(producto.descuento) : precioOriginal;
                    const subtotal = precioUnitario * parseFloat(producto.cantidad);

                    return [
                        producto.title || '',
                        producto.cantidad || 0,
                        precioOriginal.toFixed(2), // Mostrar el precio original en la columna 'Precio'
                        producto.descuento || 0,
                        subtotal.toFixed(2),
                    ];
                });

                // Agregar el encabezado de la nota de venta
                doc.setFontSize(22);
                doc.setFont('helvetica', 'neue');
                doc.text('Nota de Venta', 135, 10);
                doc.setFontSize(14);
                doc.setFont('helvetica', 'neue');

                doc.text('N°:', 135, 20);
                // doc.setTextColor(110, 107, 123);
                doc.text(`${notaDeVenta.numero}`, 145, 20);
                doc.setTextColor(0);
                doc.setFont('helvetica', 'neue');
                doc.text(`Fecha: ${notaDeVenta.fecha}`, 135, 28);
                doc.setFont('helvetica', 'neue');
                // doc.setTextColor(0);
                doc.text("Cliente:", 15, 52);
                // doc.setTextColor(100);
                doc.setFont('helvetica', 'neue');
                doc.text(`${notaDeVenta.cliente}`, 35, 52);
                const columnStyles = {
                    0: { halign: 'text-left' }, // Alineación centrada para la primera columna
                    1: { halign: 'center' }, // Alineación centrada para la segunda columna
                    2: { halign: 'center' }, // Alineación centrada para la tercera columna
                    3: { halign: 'center' }, // Alineación centrada para la cuarta columna
                    4: { halign: 'center' }, // Alineación centrada para la quinta columna
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
                const total = Articulo.reduce((acc, producto) => {
                    const precioUnitario = producto.descuento ? parseFloat(producto.descuento) : parseFloat(producto.precioV);
                    const subtotal = precioUnitario * parseFloat(producto.cantidad);
                    return acc + subtotal;
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
                this.UsuarioAlerta("error", "Error al generar el PDF: " + error.message);
            }
        }
        ,

        cerrarVentana() {
            this.cbxCliente()
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

        //eventos 
        cbxFormaPago() {
            let me = this;
            const axios = require("axios").default;
            const params = new URLSearchParams();
            // params.append('email', me.email);
            // me.tiposPago = [];
            me.isBusy = true;
            var url = "api/auth/ListaFormaPago";
            me.loaded = false;
            var lista = [];

            axios
                .get(url)
                .then(function (response) {
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
                })
                .catch((e) => {
                    UsuarioAlerta("error", e.response.data.error);
                });

        },


        cbxArticulo() {
            let me = this;
            const axios = require("axios").default;
            const params = new URLSearchParams();
            // params.append('email', me.email);
            me.items = [];
            me.isBusy = true;
            var url = "api/auth/listArticulo";
            me.loaded = false;
            var lista = [];
            axios
                .get(url)
                .then(function (response) {
                    var resp = response.data;
                    for (let i = 0; i < resp.length; i++) {
                        lista.push({
                            id: resp[i].artId,
                            title: resp[i].artNombre,
                            icon: resp[i].artFoto,
                            precioV: resp[i].artPrecioVenta,
                            cantidad: resp[i].artCantidad,
                            marca: resp[i].marNombre
                        });
                    }
                    me.booksProductos = lista;
                    me.isBusy = false;
                    me.loaded = true;
                })
                .catch((e) => {
                    alert("error al obtener los datos Lista Articulo " + e);
                });
        },


        cbxCliente() {

            let me = this;
            const axios = require("axios").default;
            const params = new URLSearchParams();
            // params.append('email', me.email);
            me.items = [];
            me.isBusy = true;
            var url = "api/auth/ListaCliente";
            me.loaded = false;
            var lista = [];
            axios
                .get(url)
                .then(function (response) {
                    var resp = response.data;
                    for (let i = 0; i < resp.length; i++) {
                        lista.push({
                            id: resp[i].cliId,
                            title: resp[i].cliNombre + " " + resp[i].cliApp + " " + resp[i].cliApm,
                        });
                    }
                    me.gntCliente = lista;
                    me.isBusy = false;
                    me.loaded = true;
                })
                .catch((e) => {
                    alert("error al obtener los datos Lista Articulo " + e);
                });

        },
        cargarProducto() {

            if (this.selectedProductos) {
                // Verificar si el producto ya está en la lista itemsAgregado
                const productoExistente = this.itemsAgregado.find(item => item.id === this.selectedProductos.id);

                if (!productoExistente) {
                    // Si el producto no existe en la lista, lo agregamos
                    this.itemsAgregado.push({ ...this.selectedProductos, descuento: 0, cantidad: 1, subtotal: this.selectedProductos.precioV });
                } else {
                    // Si el producto ya existe, puedes mostrar un mensaje de alerta o realizar otra acción
                    this.UsuarioAlerta("error", 'El producto ya está en la lista');

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
            me.selectedCliente = null
            me.selectedTipoVenta = null
            me.SelectedtipoPago = null
            me.itemsAgregado = []
            me.montoRecibido = 0
            me.cambio = 0
            me.txtFechaVenta = null
            me.cbxArticulo();
        },

        GurdarMovimientoCaja() {

            const me = this;
            const axios = require("axios").default;
            const formData = new FormData();

            formData.append("cajId", 1);
            formData.append("userId", this.$store.state.app.UsuarioId); // ID del usuario actual
            formData.append("cjtReferencia", me.cjtReferencia);
            formData.append("cjtModulo", "VENTAS");
            formData.append("cjtMonto", me.totalPagar)
            formData.append("cjtDescripcion", "Ingresos Por Venta");
            formData.append("ttxnId", 1);
            axios
                .post("api/auth/guardarMovimientoCaja", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(function (response) {
                    if (response.status === 201) {
                        console.log(response.data.mensaje)

                    }
                })
                .catch((e) => {
                    me.showOverlay = false;
                    me.UsuarioAlerta("error", e.response.data.error);
                });


        },

        DetalleVenta() {

        },


        Guardar() {
            const me = this;
            me.showOverlay = true;
            const hoy = new Date();
            const axios = require("axios").default;
            const formData = new FormData();
            if (me.selectedCliente === null || me.selectedTipoVenta === null || me.SelectedtipoPago === null || me.txtFechaVenta === null) {
                return me.UsuarioAlerta("error", "Faltan Datos Para Ingresar")
            }
            formData.append("cliId", me.selectedCliente.id); //  ID del cliente
            formData.append("userId", this.$store.state.app.UsuarioId); // ID del usuario actual
            formData.append("ttxId", 1); //ID del tipo de transacción 
            formData.append("vntCredito", me.selectedTipoVenta.id); // Esto puede ser 1 o 0 según corresponda (crédito o no)
            formData.append("fpId", me.SelectedtipoPago.id)  //Forma de pago 
            formData.append("vntActivo", 1); // Esto puede ser 1 o 0 según corresponda (activo o no)
            formData.append("vntFechaCreacion", me.txtFechaVenta);
            // Construye un array de detalles de venta
            const detallesVenta = this.itemsAgregado.map(item => ({
                artId: item.id, // ID del artículo
                vndCantidad: item.cantidad, // Cantidad vendida
                vndPrecioVenta: item.precioV, // Precio de venta
                vndDescuento: item.descuento, // Descuento (ajusta según necesites)
                vndActivo: 1 // Activo (ajusta según necesites)
            }));
            if (detallesVenta.length <= 0) {
                return me.UsuarioAlerta("error", "Debe Selecinar Ariculos")

            }
            formData.append("detallesVenta", JSON.stringify(detallesVenta));
            axios
                .post("api/auth/guardarVenta", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(function (response) {
                    if (response.status === 201) {
                        me.showOverlay = false;
                        me.UsuarioAlerta("success", response.data.mensaje);
                        me.cjtReferencia = response.data.cjtReferencia;
                        me.GurdarMovimientoCaja()

                        me.generatePDF(me.itemsAgregado)
                        me.isBusy = false;
                        me.vaciarControles()
                    }
                })
                .catch((e) => {
                    if (!e.response || !e.response.data || !e.response.data.error) {
                        // No hay error específico
                        me.showOverlay = false;
                        me.UsuarioAlerta("error", "Error al Generar PDF" + e.message);
                    } else {
                        // Hay un mensaje de error específico
                        me.showOverlay = false;

                        me.UsuarioAlerta("error", e.response.data.error);
                    }
                    // me.showOverlay = false;
                    // me.UsuarioAlerta("error", e.response ? e.response.data.error : "Error desconocido");
                });
        },
        actualizarCantidad(item, nuevaCantidad) {
            item.cantidad = nuevaCantidad;
            const res = item.precioC * item.cantidad
            var parteDecimal = res % 1
            if(parteDecimal >0.5){

                item.subtotal= Math.ceil(res);
            
            }else 
            
            {
                item.subtotal = res 
                return item.subtotal
            }
        },


        precioDescuento(item, precioDescuento) {
            item.descuento = precioDescuento

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
            this.$bvModal
                .msgBoxConfirm(
                    "El Registro  " + " : " + item["title"] + " Serán Eliminados",
                    {
                        title: "Advertencia",
                        size: "sm",
                        okVariant: "outline-success",
                        okTitle: "Continuar",
                        cancelTitle: "Cancelar",
                        cancelVariant: "outline-danger",
                        hideHeaderClose: true,
                        centered: true,


                    }
                )
                .then((value) => {
                    this.boxTwo = value;
                    if (value === true) {
                        this.eliminarProducto(index);
                    }
                });
        },

        //Realiza la Operacion Correspondiente
        validaOperacion(accion) {
            if (accion === "guardar") { this.Guardar() }
            if (accion === "editar") { this.mofificar() }
            if (accion === "ver") { alert("ajecutara el ver") }

        },
        //Este evento elimina Articulo del Carrito
        clickAccion(item, index, accion) {
            if (accion === "eliminar") {
                this.ControlaEliminar(item, index)
            }
        },
    }
}
</script>

<style lang="scss">
@import '~@resources/scss/vue/libs/vue-select.scss';
@import "~@resources/scss/base/pages/app-ecommerce-details.scss";
@import '~@resources/scss/vue/libs/vue-sweetalert.scss';
@import '~@resources/scss/vue/libs/vue-flatpicker.scss';

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