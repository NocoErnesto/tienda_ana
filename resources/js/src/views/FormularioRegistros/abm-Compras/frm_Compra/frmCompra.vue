<template>
    <section>
        <b-row>
            <b-col sm="12" md="8" xl="8" class="mb-1">
                <b-card border-variant="info">

                    <b-row>
                        <b-col sm="12" md="12" xl="12">
                            <b-form-group>
                                <label class="d-inline d-lg-flex">Buscar Producto</label>
                                <v-select ref="selectedProductos" v-model="selectedProductos" :options="booksProductos"
                                    label="title" placeholder="Seleccionar" class="select-size-lg" :max-options="3"
                                    @input="cargarProducto()">
                                    <template #option="{ title, icon, precioV, cantidad }">

                                        <div class="d-flex align-items-center">
                                            <div class="product-image-container">
                                                <img v-if="icon" :src="'data:image/jpeg;base64,' + icon" alt="Sin Foto" />
                                            </div>
                                            <div class="product-details">
                                                <strong>{{ title }}</strong>
                                                <div class="text-light">Precio: {{ precioV }}</div>
                                                <div class="text-light">Stock: {{ cantidad }}</div>
                                            </div>
                                        </div>
                                    </template>
                                </v-select>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="12">
                            <!-- Tabla --> <!-- Listado -->
                            <b-table id="tabla-lista-retrasos" :items="itemsAgregado" :fields="fieldsAgregado"
                                :filter="filter" @filtered="onFiltered" hover  :busy="isBusy" :bordered="true" :fixed="true"
                                :sticky-header="stickyHeader" :head-variant="headVariant">

                                <template #cell(cantidad)="row">
                                    <b-form-input v-model="row.value" type="number" min="1" 
                                        @input="actualizarCantidad(row.item, row.value)" ref="cantidadInput"
                                        :state="row.value > 0 ? true : false"
                                        v-b-tooltip.hover.top.right="row.value > 0 ? '' : 'Cantidad debe ser mayor que cero'"
                                        :show="row.value === 0" :trigger="'hover focus'" class="v-b-tooltip-dark text-center" />
                                </template>
                                <template #cell(subtotal)="row">
                                    {{ row.item.precioV * row.item.cantidad }}
                                </template>
                                <template #cell(Acción)="row">

                                    <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'" variant="flat-danger"
                                        class="btn-icon rounded-circle" :class="{ 'd-none': $store.state.app.isElimina }"
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
            <b-col sm="12" md="4" xl="4" class="mb-1">
                <b-card border-variant="info">
                    <b-card-title>Detalle Venta</b-card-title>
                    <b-row>
                        <b-col>
                            <b-form-group>
                                <label for="tipoPago">Tipo de Pago</label>
                                <b-form-select id="tipoPago" v-model="tipoPago" :options="tiposPago"></b-form-select>
                            </b-form-group>
                        </b-col>
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
                                <b-form-input id="montoRecibido" v-model="montoRecibido" class="montos"></b-form-input>
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
        BFormSpinbutton
    },
    data() {
        return {
            tiposPago: ["Efectivo", "Tarjeta", "Transferencia"],
            tipoPago: "", // Tipo de pago seleccionado
            totalPagar: 0, // Total a pagar
            montoRecibido: 0, // Monto recibido
            cambio: 0, // Cambio a entregar

            isBusy: false,
            filter: "",
            stickyHeader: true,
            headVariant: "light",
            booksProductos: [

            ],
            selectedProductos: {
                id: "0",
                title: "",
                icon: 'ListIcon',
                precioV: 0,
                cantidad: 0,
                subtotal: 0
            },

            itemsAgregado: [],
            fieldsAgregado: [
                { key: "id", label: "codigo", sortable: true, tdClass: "text-center" },
                { key: "title", label: "PRODUCTO", sortable: true },
                { key: "precioV", label: "PRECIO", sortable: true, tdClass: "text-center" },
                { key: "cantidad", label: "CANTIDAD", sortable: false, tdClass: "text-center" },
                { key: "subtotal", label: "SUBTOTAL", sortable: false, tdClass: "text-center" },
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
    },
    computed: {
        totalPagarCalculado() {
            return this.itemsAgregado.reduce((total, item) => {
                this.totalPagar = total + item.precioV * item.cantidad
                this.montoRecibido = 0;
                this.cambio = 0;
                return this.totalPagar;
            }, 0);

        },
    },
    methods: {
        // Alertas 
        UsuarioAlerta(variant, mensaje) {

            if (variant === "success") {
                this.$swal({
                    title: "Buen Trabajo",
                    text: mensaje,
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
                    text: mensaje,
                    icon: variant,
                    customClass: {
                        confirmButton: "btn btn-danger",
                    },
                    showClass: {
                        popup: "animate__animated animate__tada",
                        // popup: "animate__animated animate__heartBeat",


                    },
                    buttonsStyling: true,
                });
            }
        },

        //eventos 
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
                            cantidad: resp[i].artCantidad
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
        cargarProducto() {
            if (this.selectedProductos) {
                // Verificar si el producto ya está en la lista itemsAgregado
                const productoExistente = this.itemsAgregado.find(item => item.id === this.selectedProductos.id);

                if (!productoExistente) {
                    // Si el producto no existe en la lista, lo agregamos
                    this.itemsAgregado.push({ ...this.selectedProductos, cantidad: 1, subtotal: this.selectedProductos.precioV });
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


     
        actualizarCantidad(item, nuevaCantidad) {
            item.cantidad = nuevaCantidad;
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
        },
        eliminarProducto(index) {
            if (index >= 0 && index < this.itemsAgregado.length) {
                this.itemsAgregado.splice(index, 1);
                this.montoRecibido = 0

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