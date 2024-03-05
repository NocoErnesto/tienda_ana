<template >
    <section id="dashboard-analytics">
        <div style="max-width: 1024dp">
            <b-row class="match-height">
                <b-col xl="12">
                    <!-- Posicion 1 -->
                    <analisis-ganancia></analisis-ganancia>
                </b-col>

            </b-row>

        </div>
    </section>
</template>
<script>
import {
    BCard,
    BCardText,
    BCardBody,
    BCardTitle,
    BCardHeader,
} from "bootstrap-vue";
import { BCol, BRow } from "bootstrap-vue";

import AnalisisGanancia from './AnalisisGanancia/AnalisisGanancia.vue';


export default {
    components: {
        BCol,
        BRow,
        BCardBody,
        BCardTitle,
        BCardHeader,
        BCard,
        BCardText,
        BCard,
        ApexCharts,
        AnalisisGanancia
    },
    data() {

        return {

        };
    },

};
</script>
<style></style>
  