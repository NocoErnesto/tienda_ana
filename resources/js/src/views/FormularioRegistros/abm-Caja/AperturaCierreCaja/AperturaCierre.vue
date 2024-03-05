<template>
    <section>
        <b-card border-variant="info">
            <b-row>
                <b-col md="6">
                    <b-form-group>
                        <label class="d-inline d-lg-flex">Caja</label>
                        <v-select v-model="selectedCaja" :options="booksCaja" label="title" placeholder="Seleccionar"
                            style="color:brown ;">
                            <template #option="{ title, icon }">
                                <feather-icon :icon="icon" size="16" class="align-middle mr-50" />
                                <span> {{ title }}</span>
                            </template>
                        </v-select>
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group>
                        <label class="d-inline d-lg-flex">Monto de Apertura</label>
                        <b-form-input v-model="txt_acMontoApertura" :state="txt_acMontoApertura.length ? true : false"
                            required />
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
import { service } from '../../../../libs/axios'
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
            txt_acMontoApertura: 0,
            selectedCaja: {
                id: "0",
                title: "",
                icon: 'ListIcon',
            },
            booksCaja: [
                {
                    id: "",
                    title: "",
                    icon: 'ListIcon',
                },
            ],
        }
    },
    directives: {
        Ripple,
    },

    mounted() {
        let me = this;
        me.cbxCaja();
    },
    methods: {
        //acciones 
      
        async Guardar() {
            try {
                let me = this
                me.showOverlay = true;
                me.isBusy = true;
                const formData = new FormData();
                formData.append("cajId", me.selectedCaja.id);
                formData.append("userId", this.$store.state.app.UsuarioId);
                formData.append("acMontoApertura", me.txt_acMontoApertura);
                formData.append("acActivo", 1);
                const response = await this.$http.post("AperturaCaja", formData)
                
                if (response.status === 201) {
                    this.showOverlay = false;
                    me.UsuarioAlerta("success", response.data.mensaje);
                    me.isBusy = false;
                }
                if (response.status ===200)
                {
                    this.showOverlay = false;
                    me.UsuarioAlerta("error", response.data.error);
                    me.isBusy = false;  
                }
            } catch (error) {
            
                this.UsuarioAlerta("error",  error.response.data.error);
                this.showOverlay = false;
            }
        }, 

        async cbxCaja() {
            try {
                let me = this;
                const lista = [] ;
                me.booksCaja =[]
                const response = await this.$http.get("ListadoCaja")
                const resp = response.data;      
                for (let i = 0; i < resp.length; i++) {

                    lista.push({
                        id: resp[i].cajId,
                        title: resp[i].cajNombre,
                        icon: 'DollarSignIcon',
                    });
                }
                me.booksCaja = lista;
            } catch (error) {
                console.log(error.message);
                this.UsuarioAlerta("error", error.response );
                this.showOverlay = false;
             
            }

        },

        //eventos 
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
        validaOperacion(accion) {
            if (accion === "guardar") { this.Guardar() }
            if (accion === "editar") { this.mofificar() }
            if (accion === "ver") { alert("ajecutara el ver") }

        },

        ControlaEliminar(item, index) {
            this.boxTwo = "";
            this.$bvModal
                .msgBoxConfirm(
                    "El Registro  " + " : " + item["title"] + " Serán Eliminados",
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

<style></style>