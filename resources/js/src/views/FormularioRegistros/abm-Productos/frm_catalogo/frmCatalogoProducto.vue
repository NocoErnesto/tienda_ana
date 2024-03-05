
<template>
    <section >

        <b-row >
            <!-- v-for="(item, index) in metadataListado" :key="index" -->
            <!-- xl="3" v-for="item in metadataListado" :key="item.artId" -->
            <b-col xl="3" v-for="(item, index) in metadataListado" :key="index">

                <b-card class="ecommerce-card">

                    <b-card-body >

                        <b-row>
                            <b-col>
                                <div class="item-img  card-img-top bg-transparent text-center">

                                    <b-img fluid class="card-img-top product-img" :src="item.artFoto" v-if="item.artFoto"
                                        style="width: 250px; height: 310px; margin: auto;" />
                                </div>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col class="text-center ">

                                <h6>
                                    Bs.{{ item.artPrecioVenta }}
                                </h6>

                            </b-col>

                        </b-row>
                        <b-row class="align-items-center">
                            <b-col>
                                <h6>
                                    {{ item.artNombre }}
                                </h6>
                            </b-col>
                        </b-row>
                    </b-card-body>
                </b-card>
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <b-pagination v-model="currentPage" :per-page="perPage" :total-rows="totalRows" size="lg" class="mt-2"
                    align="center" @input="handlePageChange">
                    <template #first-text>
                        <span class="text-success">Primero</span>
                    </template>
                    <template #prev-text>
                        <span class="text-warning">Anterior</span>
                    </template>
                    <template #next-text>
                        <span class="text-info">Próximo</span>
                    </template>
                    <template #last-text>
                        <span class="text-danger">Ultimo</span>
                    </template>
                    <template #ellipsis-text>
                        <div>
                            <b-spinner small type="grow" />
                            <b-spinner small type="grow" />
                        </div>
                    </template>
                    <template #page="{ page, active }">
                        <b v-if="active">{{ page }}</b>
                        <i v-else>{{ page }}</i>
                    </template>
                </b-pagination>
            </b-col>
        </b-row>

    </section>
</template>
<script>
import {
    BPagination,
    BCardText,
    BImg,
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
import Ripple from "vue-ripple-directive";
import vSelect from 'vue-select'


export default {
    components: {
        BPagination,
        BCardText,
        BImg,
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

    },
    directives: {
        "b-tooltip": VBTooltip,
        Ripple,
    },
    data() {
        return {
            currentPage: 1,
            perPage: 100,  // Número de elementos por página
            totalRows: 1,
            metadataListado: [],
            TipoAccion: null,
            stickyHeader: true,
            transProps: {
                // Transition name
                name: "flip-list",
            },

            mesReporte: "",

            show: false,
            isBusy: false,
            loaded: false,
            filter: "",
            filterOn: [],
            idGenera: 0,
            id: 0,
            fecha: 0,

            Loading: "",
            estado: "",
            items: [],
            fields: [
                { key: "codigo", label: "codigo", sortable: true },
                { key: "artNombre", label: "NOMBRE", sortable: true },
                { key: "catNombre", label: "CATEGORIA", sortable: true },
                { key: "marNombre", label: "MARCA", sortable: true },
                { key: "uniNombre", label: "UNIDAD", sortable: true },
                { key: "artCosto", label: "COSTO", sortable: true },
                { key: "artPrecioVenta", label: "PRECIO VENTA", sortable: true },
                { key: "artCantidad", label: "CANTIDAD", sortable: true },
                { key: "Acción", sortable: false },
            ],
            variant: "dark",
            opacity: 0.85,
            blur: "2px",
            // selected: [],
        };
    },
    watch: {

    },
    computed: {
        // totalRows() {
        //     this.totalRows = this.items.length
        // },
    },

    mounted() {
        this.listArticulo(this.currentPage);
    },
    methods: {
        clickAccion(item, accion) {


            if (accion === "guardar") {
                this.$store.dispatch('app/cambiarTipoAccion', { tipo: accion, variant: 'success', icono: 'SaveIcon', texto: 'Guardar', Bclass: '' })
            }
            if (accion === "editar") {

                this.$store.dispatch('app/cambiaId', item["artId"])
                this.$store.dispatch('app/cambiarTipoAccion', { tipo: accion, variant: 'primary', icono: 'SaveIcon', texto: 'Modificar', Bclass: '' })

                this.$refs["frm-articulo"].show();
            }
            if (accion === "ver") {
                this.$store.dispatch('app/cambiaId', item["artId"])
                this.$store.dispatch('app/cambiarTipoAccion', { tipo: accion, variant: 'success', icono: 'SaveIcon', texto: 'Guardar', Bclass: 'd-none' })

                this.$refs["frm-articulo"].show();
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
                    "El Articulo  " + " : " + item["artId"] + " Serán Eliminados",
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
            params.append('artId', item["artId"]);
            var url = "api/auth/eliminarArticulo";
            me.isBusy = true;
            axios
                .post(url, params)
                .then(function (response) {

                    if (response.status == 201) {
                        me.UsuarioAlerta("success");
                        me.listArticulo()
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
            me.listArticulo();
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

   
        handlePageChange(newPage) {
            console.log("Página seleccionada:", newPage);
            // Aquí puedes realizar acciones adicionales con el nuevo número de página
            this.listArticulo(newPage);
        },
        async listArticulo(newPage) {
            let me = this;
            const axios = require("axios").default;
            me.metadataListado = [];
            me.loaded = true;

            var url = "api/auth/listArticuloCatalogo";
            me.currentPage = newPage
            var lista = [];
            const formData = new FormData();
            formData.append("page", me.currentPage);
            formData.append("perPage", me.perPage);

            await axios
                .post(url, formData)
                .then(function (response) {
                    var resp = response.data.data;
                    me.totalRows = response.data.total;
                    me.currentPage = response.data.current_page;

                    for (let i = 0; i < resp.length; i++) {
                        me.metadataListado.push({
                            artId: resp[i].artId,
                            artNombre: resp[i].artNombre,
                            artPrecioVenta: resp[i].artPrecioVenta,
                            artFoto: 'data:image/png;base64,' + resp[i].artFoto
                        });
                    }
                    me.loaded = false
                })
                .catch((e) => {
                    alert("error al obtener los datos Lista Articulo " + e);
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
<style scoped></style>
<style lang="scss" >
@import '~@resources/scss/vue/libs/vue-select.scss';
@import "~@resources/scss/base/pages/app-ecommerce.scss";

.custom-badge {
    width: 30px;
    height: 15px;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ecommerce-card {
    &:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 25px 0 rgba($black, 0.25);
    }


}
</style>
