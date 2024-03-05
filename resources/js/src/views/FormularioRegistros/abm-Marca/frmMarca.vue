<template>
    <section>
        <b-card border-variant="info">
            <b-row>
                <b-col md="6">
                    <b-form-group>
                        <label class="d-inline d-lg-flex">Nombre de la Marca</label>
                        <b-form-input v-model="marNombre" :state="marNombre.length ? true : false" required />
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
            marNombre: "",
        }
    },
    directives: {
        Ripple,
    },
    mounted() {
        if (this.$store.state.app.TipoAccion === "editar" || this.$store.state.app.TipoAccion === "ver") {

            this.TraerMarca()
        }
    },
    methods: {
        //acciones 
        TraerMarca() {
            let me = this;
            const axios = require("axios").default;
            const params = new URLSearchParams();
            params.append('Id', this.$store.state.app.idUtilitario);
            me.items = [];

            var url = "api/auth/TraerMarca";
            me.loaded = false;
            var lista = [];
            axios
                .post(url, params)
                .then(function (response) {
                    var resp = response.data;
                    for (let i = 0; i < resp.length; i++) {
                        me.marNombre = resp[i].marNombre

                    }
                    me.items = lista;
                    me.loaded = true;
                })
                .catch((e) => {
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
            var urlm = "api/auth/agregarMarca";
            me.loaded = false;
            me.isBusy = true;
            formData.append("txt_marNombre", me.marNombre);
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
            var urlm = "api/auth/modificarMarca";
            me.loaded = false;
            me.isBusy = true;
            formData.append('Id', this.$store.state.app.idUtilitario);
            formData.append("txt_marNombre", me.marNombre);
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

    },
}

</script>

<style></style>