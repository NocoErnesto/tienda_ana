<template>
  <div>
    <!-- Formulario Modal -->
    <b-modal ref="frm-articulo" id="frm-articulo" ok-title="Cerrar" ok-variant="danger" ok-only size="lg" centered
      title="Registro de Articulos" @ok="listArticulo(1)">
      <!-- Diseño del Formulario -->
      <frm_-producto id="a"></frm_-producto>

    </b-modal>


    <b-overlay id="overlay-background" :variant="variant" :opacity="opacity" :blur="blur">
      <b-card>
        <b-card-title style="text-align: center">Listado de Productos</b-card-title>
        <b-card-body>
          <b-row>
            <b-col sm="4" md="5" xl="6" lg="6" class="mb-1">
              <!-- Boton Modal -->
              <b-button v-ripple.400="'rgba(113, 102, 240, 0.15)'" v-b-modal.frm-articulo variant="success"
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
                    <b-button :disabled="!filter" variant="danger" @click="filter = ''">Limpiar</b-button>
                  </b-input-group-append>
                </b-input-group>
              </b-form-group>
            </b-col>
          </b-row>
          <b-row>
            <b-col>
              <!-- Tabla --> <!-- Listado -->

              <b-table id="tabla_articulo" :items="items" :fields="fields" :filter="filter" @filtered="onFiltered" hover
                :bordered="true" :busy="isBusy" outlined stacked="sm" small :style="{ fontSize: fontSize }"
                :sticky-header="stickyHeader">

                <template #cell(artCantidad)="data">
                  <b-badge pill :variant="data.item.artCantMin">
                    <div class="custom-badge d-flex align-items-center">
                      <span>{{ data.item.artCantidad }}</span>
                    </div>
                  </b-badge>
                </template>

                <template #cell(Acción)="row">
                  <b-row>
                    <b-col>
                      <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'" variant="flat-warning"
                        v-b-tooltip.hover.v-dark title="Seguir Editando" class="btn-icon"
                        :class="{ 'd-none': $store.state.app.isEdita }" @click="clickAccion(row.item, ('editar'))">
                        <feather-icon icon="EditIcon" />
                      </b-button>
                    </b-col>
                    <b-col>
                      <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'" variant="flat-success"
                        v-b-tooltip.hover.v-dark title="Ver Detalle" class="btn-icon"
                        :class="{ 'd-none': $store.state.app.isVer }" @click="clickAccion(row.item, ('ver'))">
                        <feather-icon icon="EyeIcon" />
                      </b-button>
                    </b-col>
                    <b-col>
                      <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'" variant="flat-danger"
                        class="btn-icon rounded-circle" :class="{ 'd-none': $store.state.app.isElimina }"
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

        </b-card-body>
      </b-card>
    </b-overlay>
  </div>
</template>

<script>
import {
  BPagination,
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
import Frm_Producto from "./frm_Producto/frm_Producto.vue";
import jsPDF from 'jspdf';
import 'jspdf-autotable';
export default {
  components: {
    BPagination,
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
    Frm_Producto,

  },
  directives: {
    "b-tooltip": VBTooltip,
    Ripple,

  },
  data() {
    return {
      fontSize: "",
      TipoAccion: null,
      stickyHeader: true,
      transProps: {
        // Transition name
        name: "flip-list",
      },
      currentPage: 1,
      perPage: 20,  // Número de elementos por página
      totalRows: 1,

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
    this.listArticulo(this.currentPage);
    if (a <= 576) {
      // Dispositivo móvil pequeño
      this.fontSize = 'xx-small'; // Tamaño de fuente pequeño
    }

  },
  methods: {


    //modificar para reporte
    generatePDF(Articulo) {
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
        doc.text('DIRECCION : ' + me.$store.state.app.DireccionEmpresa, 40, 20);
        doc.text('TELEFONO  : ' + me.$store.state.app.TelefonoEmpresa, 40, 25);
        doc.text('Nit  : ' + me.$store.state.app.NitEmpresa, 40, 30);
        const currentDate = new Date(); // Obtiene la fecha actual
        const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
        const formattedDate = currentDate.toLocaleDateString('es-ES', options); // Formatea la fecha como "10/11/2023"

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
          const subtotal = precioUnitario * parseInt(producto.cantidad);

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
          const subtotal = precioUnitario * parseInt(producto.cantidad);
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
    }
    ,

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
      me.listArticulo(this.currentPage);
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
    me.currentPage = newPage || me.currentPage; // Si newPage es nulo, conserva la página actual
    const axios = require("axios").default;

    const formData = new FormData();
    formData.append("page", me.currentPage);
    formData.append("perPage", me.perPage);
    me.items = [];
    me.isBusy = true;
    var url = "api/auth/listArticuloPagianado";

    me.loaded = false;
    var lista = [];

    try {
        const response = await axios.post(url, formData);
        var resp = response.data.data;
        me.totalRows = response.data.total;
        me.currentPage = response.data.current_page;

        for (let i = 0; i < resp.length; i++) {
            lista.push({
                artId: resp[i].artId,
                codigo: resp[i].codigo,
                artNombre: resp[i].artNombre,
                catNombre: resp[i].catNombre,
                marNombre: resp[i].marNombre,
                uniNombre: resp[i].uniNombre,
                artCosto: resp[i].artCosto,
                artPrecioVenta: resp[i].artPrecioVenta,
                artCantidad: resp[i].artCantidad,
                artCantMin: resp[i].badgeColor,
            });
        }

        me.items = lista;
        me.isBusy = false;
        me.loaded = true;
    } catch (error) {
        alert("Error al obtener los datos Lista Articulo " + error);
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

.custom-badge {
  width: 30px;
  height: 15px;
  font-size: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* styles-for-print.css */
@media print {

  /* Aplicar estilos de impresión específicos aquí */
  .text-warning {
    color: orange !important;
    /* Cambiar el color de texto de advertencia para impresión */
    font-size: 15px !important;
    /* Cambiar el tamaño de fuente para impresión */
    font-family: Arial, sans-serif !important;
    /* Cambiar la fuente para impresión */
    text-align: center !important;
    /* Cambiar la alineación del texto para impresión */
  }
}
</style>
