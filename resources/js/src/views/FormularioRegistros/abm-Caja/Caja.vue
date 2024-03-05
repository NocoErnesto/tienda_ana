<template>
    <section>
        <b-card border-variant="info">
            <app-collapse accordion :type="collapseType" >
                <app-collapse-item title="Listado de Cajas">
                    <lista-caja></lista-caja>
                </app-collapse-item>
                <app-collapse-item title="Apertura/Cierre Caja">
                    <lista-apertura-cierre></lista-apertura-cierre>
                </app-collapse-item>
            </app-collapse>
        </b-card>
    </section>
</template>
<script>
import {
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
import AppCollapseItem from '@core/components/app-collapse/AppCollapseItem.vue'
import AppCollapse from '@core/components/app-collapse/AppCollapse.vue'
import ListaCaja from './FormularioCaja/ListaCaja.vue';
import ListaAperturaCierre from './AperturaCierreCaja/ListaAperturaCierre.vue';

export default {
    components: {
        AppCollapse,
        AppCollapseItem,
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
        ListaCaja,
        ListaAperturaCierre,
      
    },
    directives: {
        "b-tooltip": VBTooltip,
        Ripple,
    },
    data() {
        return {
            collapseType: 'margin',
        };
    },
}
</script>

<style></style>