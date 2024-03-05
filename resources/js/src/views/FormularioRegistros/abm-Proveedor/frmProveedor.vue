<template>
    <section>
        <b-card border-variant="info">
            <b-row>
                <b-col md="6">
                    <b-form-group>
                        <label class="d-inline d-lg-flex">Nombre del Proveedor</label>
                        <b-form-input id="txt_provNombre" v-model="provNombre" :state="provNombre.length ? true : false" required />
                    </b-form-group>
                    <b-form-group>
                        <label class="d-inline d-lg-flex">Dirección</label>
                        <b-form-input id="txt_provDireccion" v-model="provDireccion" :state="provDireccion.length ? true : false" required />
                    </b-form-group>
                    <b-form-group>
                        <label class="d-inline d-lg-flex">Telefono</label>
                        <b-form-input v-model="provTelefono" id="txt_provTelefono" :state="provTelefono.length ? true : false" required />
                    </b-form-group>
                </b-col>
                <!-- Agrega otros campos del formulario aquí -->
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

        </b-card>

    </section>
</template>

<script>
import {
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

export default {
    components: {
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
        BFormSpinbutton
    },
    data() {
        return {

            isBusy: false,
            filter: "",
            stickyHeader: true,
            provNombre: "",
            provDireccion: "",
            provTelefono: "",
            items:[],
            productos:[]
        }
    },
    directives: {
        Ripple,
    },
    mounted() {
        if (this.$store.state.app.TipoAccion === "editar" || this.$store.state.app.TipoAccion === "ver") {
            this.GetShoppingByProveedor();
            this.TraeProveedor();
        }
    },
    methods: {
        GetShoppingByProveedor(){
            let me = this;
            const axios = require("axios").default;
            me.items = [];
            var url = "api/auth/GetShoppingByProveedorId?proveedorId="+this.$store.state.app.idUtilitario;
            me.loaded = false;
            var lista = [];
            axios.get(url).then(function (response) {
                var resp = response.data;
                for (let i = 0; i < resp.length; i++) {
                    lista.push({
                        NroCompra: resp[i].cmtNumero,
                        NombreArticulo: resp[i].artNombre,
                        Cantidad : resp[i].cmdCantidad,
                        Costo : resp[i].cmdCosto
                    });
                }
                me.items = lista;
                me.loaded = true;
            }).catch((e) => {
                alert("error al obtener los datos Lista Articulo " + e);
            });
        },
        //acciones 
        TraeProveedor() {
            let me = this;
            const axios = require("axios").default;
            const params = new URLSearchParams();
            params.append('provId', this.$store.state.app.idUtilitario);
            var url = "api/auth/traerProveedor";
            me.loaded = false;
            axios.post(url, params).then(function (response) {
                var resp = response.data;
                for (let i = 0; i < resp.length; i++) {
                    me.provNombre = resp[i].provNombre
                    me.provDireccion = resp[i].provDireccion
                    me.provTelefono = resp[i].provTelefono
                }
                me.loaded = true;
            }).catch((e) => {
                alert("error al obtener los datos Lista Articulo " + e);
            });
        },
        Guardar() {
            let me = this;
            debugger
            me.showOverlay = true;
            const hoy = new Date();

            const axios = require("axios").default;
            const formData = new FormData();

            me.items = [];
            var urlm = "api/auth/agregarProveedor";
            me.loaded = false;
            me.isBusy = true;
            formData.append("provNombre", me.provNombre);
            formData.append("provDireccion", me.provDireccion);
            formData.append("provTelefono", me.provTelefono);
            // formData.append("UsuarioId", this.$store.state.app.UsuarioId);
            axios
                .post(urlm, formData)
                .then(function (response) {
                    if (response.status == 201) {
                        me.showOverlay = false;
                        me.UsuarioAlerta("success");
                        me.isBusy = false;

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
        modificar() {
            let me = this;
            debugger
            me.showOverlay = true;
            const hoy = new Date();

            const axios = require("axios").default;
            const formData = new FormData();

            me.items = [];
            var urlm = "api/auth/modificarProveedor";
            me.loaded = false;
            me.isBusy = true;
            formData.append('provId', this.$store.state.app.idUtilitario);
            formData.append("provNombre", me.provNombre);
            formData.append("provDireccion", me.provDireccion);
            formData.append("provTelefono", me.provTelefono);
            axios
                .post(urlm, formData)
                .then(function (response) {
                    if (response.status == 200) {
                        me.showOverlay = false;
                        me.UsuarioAlerta("success");
                        me.isBusy = false;

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

        //eventos 
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

        validaOperacion(accion) {
            if (accion === "guardar") { this.Guardar() }
            if (accion === "editar") { this.modificar() }
            if (accion === "ver") { this.generatePDF() }
        },
        generatePDF() {
            try {
                // Crear un nuevo documento PDF
                const doc = new jsPDF();
                let me = this;

                // Agregar el logo de la empresa (reemplaza 'ruta_al_logo' con la ruta de tu imagen)
                const image = new Image();
                var imgData = 'data:image/png;base64,' + me.$store.state.app.LogoEmpresa;
                doc.addImage(imgData, 'PNG', 15, 5, 25, 25);
                doc.setFont('helvetica', 'neue')
                doc.setFontSize(10);
                // doc.text(me.$store.state.app.NombreEmpresa, 40, 20);
                doc.text(' DIRECCION : ' + me.$store.state.app.DireccionEmpresa, 40, 20);
                doc.text(' TELEFONO  : ' + me.$store.state.app.TelefonoEmpresa, 40, 25);
                doc.text(' Nit  : ' + me.$store.state.app.NitEmpresa, 40, 30);
                const currentDate = new Date(); // Obtiene la fecha actual
                const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
                const formattedDate = currentDate.toLocaleDateString('es-ES', options); // Formatea la fecha como "10/11/2023"

                // Configuración de la nota Proveedor
                const notaProveedor = {
                    Fecha: formattedDate,
                    Proveedor: me.provNombre,
                    Direccion: me.provDireccion,
                    Telefono: me.provTelefono,
                };


                // Datos de las Compras
                const columns = ['Nro Compra','Articulo', 'Cantidad','Precio Compra', 'SubTotal'];
                const rows = me.items.map((detalle) => {
                    const PrecioCompra = parseFloat(detalle.Costo);
                    const subtotal = PrecioCompra * parseInt(detalle.Cantidad);
                    return [
                        detalle.NroCompra,
                        detalle.NombreArticulo || '',
                        detalle.Cantidad || 0,
                        PrecioCompra.toFixed(2), // Mostrar el precio original en la columna 'Precio'
                        subtotal.toFixed(2),
                    ];
                });

                // Agregar el encabezado de la nota de venta
                doc.setFontSize(18);
                doc.setFont('helvetica', 'neue');
                doc.text(' Nota de Compras por Proveedor', 40, 10);
                doc.setFontSize(10);
                doc.setFont('helvetica', 'neue');

                doc.setTextColor(0);
                doc.setFont('helvetica', 'neue');
                doc.text(` Fecha: ${notaProveedor.Fecha}`, 40, 15);
                doc.setFont('helvetica', 'neue');

                doc.text("Proveedor: ", 15, 40);
                doc.setFont('helvetica', 'neue');
                doc.text(`${notaProveedor.Proveedor} - ${notaProveedor.Telefono}`, 35, 40);
                const columnStyles = {
                    0: { halign: 'text-left' }, // Alineación centrada para la primera columna
                    1: { halign: 'text-left' }, // Alineación centrada para la segunda columna
                    2: { halign: 'center' }, // Alineación centrada para la tercera columna
                    3: { halign: 'right' }, // Alineación centrada para la cuarta columna
                    4: { halign: 'right' }, // Alineación centrada para la cuarta columna
                };
                // Agregar la tabla de detalle
                doc.autoTable({
                    startY: 50,
                    head: [columns],
                    body: rows,
                    columnStyles: columnStyles,
                });
                const total = me.items.reduce((acc, detalle) => {
                    const subtotal = parseFloat(detalle.Costo) * parseInt(detalle.Cantidad);
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
                me.UsuarioAlerta("error", "Error al generar el PDF: " + error.message);
            }
        },
    },
}

</script>

<style></style>