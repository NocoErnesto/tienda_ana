<template >
  <section id="dashboard-desarrollo">
    <div style="max-width: 1024dp">
      <b-row class="match-height">
        <b-col xl="12">
          <OpinionMadepa></OpinionMadepa>
        </b-col>

        <b-col xl="12">
          <Capacitacion></Capacitacion>
        </b-col>
        <b-col xl="12">
          <Nps></Nps>
        </b-col>
      </b-row>
    </div>
  </section>
</template>
<script>
import { BCard, BCardText } from "bootstrap-vue";
import { BCol, BRow } from "bootstrap-vue";
import ApexCharts from "apexcharts";
import OpinionMadepa from "./OpinionMadepa.vue";
import Capacitacion from "../Capacitacion/Capacitacion.vue";
import Nps from "../Nps/Nps.vue";

export default {
  components: {
    BCol,
    BRow,
    BCard,
    BCardText,
    ApexCharts,
    OpinionMadepa,
    Capacitacion,
    Nps,
  },
  data() {
    return {
      data: {},
      loaded: false,
      // dataHeadcount: {
      //     supportTracker: {
      //         title: "",
      //         lastDays: [],
      //         totalTicket: 332,
      //         newTicket: 279,
      //         openTicket: 31,
      //         responseTime: 0,
      //         supportTrackerRadialBar: {
      //             series: [85],
      //         },
      //     },
      // },
      // dataBajasAcumuldas: {
      //     ordersRecevied: {
      //         series: [
      //             {
      //                 //concatenar el mes
      //                 name: "Cantidad",
      //                 data: [],
      //             },
      //         ],
      //         analyticsData: {
      //             // total acumukado del mes consultado
      //             orders: 38,
      //         },
      //     },
      // },
      // aDataAltas: {
      //     ordersRecevied: {
      //         series: [
      //             {
      //                 //concatenar el mes
      //                 name: "Cantidad",
      //                 data: [],
      //             },
      //         ],
      //         analyticsData: {
      //             // total acumukado del mes consultado
      //             orders: "",
      //         },
      //     },
      // },
      // dataAltasBajas: {
      //     revenue: {
      //         years: ['2020', '3019', '2018'],
      //         price: '25,852',
      //         budget: '56,800',
      //         revenueReport: {
      //             series: [
      //                 {
      //                     name: 'Altas',
      //                     data: [],
      //                 },
      //                 {
      //                     name: 'Bajas',
      //                     data: [],
      //                 },
      //             ],
      //         },
      //         budgetChart: {
      //             series: [
      //                 {
      //                     name: 'Altas',
      //                     data: [],
      //                 },
      //                 {
      //                     name: 'Baja',
      //                     data: [],
      //                 },
      //             ],
      //         },
      //     },
      // }
    };
  },
};
</script>

