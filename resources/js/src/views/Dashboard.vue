<template >
  <section id="dashboard-analytics">
    <div style="max-width: 1024dp">
      <b-row class="match-height">
        <b-col xl="4">
          <!-- Posicion 1 -->
          <analytics-support-tracker :data="dataHeadcount.supportTracker"></analytics-support-tracker>
        </b-col>
        <b-col xl="4">
          <!-- Posicion 2 -->
          <headcount-division></headcount-division>
          <!-- <head-count-genero></head-count-genero> -->
        </b-col>
        <b-col xl="4">
          <!-- Posicion 3 -->
          <head-count-promedio-anual></head-count-promedio-anual>
        </b-col>
        <b-col xl="6">
          <!-- Posicion 4 -->
          <!-- <head-count-presupuesto></head-count-presupuesto> -->
          <HPresupuestoGeneral></HPresupuestoGeneral>
        </b-col>
        <b-col xl="6">
          <!-- Posicion 5 -->
          <head-count-promedio-tipo-contrato></head-count-promedio-tipo-contrato>
        </b-col>
        <b-col xl="6">
          <!-- Posicion 6 -->
          <head-count-tipo-contrato></head-count-tipo-contrato>
        </b-col>
        <b-col xl="6">
          <!-- Posicion 7 -->
          <presupuesto-tipo-contrato></presupuesto-tipo-contrato>
        </b-col>
        <!-- <b-col xl="6" >
          <ecommerce-browser-states></ecommerce-browser-states>
        </b-col>
        <b-col xl="6" >
          <echart-bar></echart-bar>
        </b-col> -->
        <b-col xl="12">
          <!-- Posicion 8 -->
          <head-count-area></head-count-area>
        </b-col>
        <b-col xl="4">
          <!-- Posicion 9 -->
          <!-- <chartjs-polar-area-chart></chartjs-polar-area-chart> -->
          <head-count-genero></head-count-genero>
        </b-col>
        <b-col xl="4">
          <!-- Posicion 10 -->
          <HeadCountAntiguedad style="background-position: #cccccc"></HeadCountAntiguedad>
        </b-col>

        <b-col xl="4">
          <!-- Posicion 11 -->
          <!-- <HeadCountAntiguedad></HeadCountAntiguedad> -->
          <head-count-edad></head-count-edad>
        </b-col>

        <b-col xl="6">
          <HeadcountJerarquico></HeadcountJerarquico>
        </b-col>
        <b-col xl="6">
          <HeadcountDiversidadOrigen></HeadcountDiversidadOrigen>
        </b-col>

        <b-col xl="12">
          <DistribucionPermanencia></DistribucionPermanencia>
        </b-col>


        <b-col xl="12">
          <!-- Posicion 12 -->
          <ecommerce-revenue-report :data="dataAltasBajas.revenue"></ecommerce-revenue-report>
        </b-col>
        <b-col xl="4">
          <!-- Posicion 13 -->
          <head-count-altas-acumuladas :data="dataAltasBajas.revenue"></head-count-altas-acumuladas>
        </b-col>

        <b-col xl="4">
          <!-- Posicion 14 -->
          <head-count-bajas-acumuladas :data="dataAltasBajas.revenue">
          </head-count-bajas-acumuladas>
        </b-col>
        <b-col xl="4">
          <!-- Posicion 15 -->
          <HeadGeneracion></HeadGeneracion>
        </b-col>
        <!-- ingresar nuevo grafico -->

        <b-col xl="4">
          <!-- Posicion 16 -->
          <IndiceRotacion :data="dataAltasBajas.revenue"></IndiceRotacion>
        </b-col>
        <b-col xl="4">
          <!-- Posicion 17 -->
          <!-- <IndiceRotacion :data="dataAltasBajas.revenue"></IndiceRotacion> -->
          <IndiceRetencion :data="dataAltasBajas.revenue"></IndiceRetencion>
        </b-col>
        <b-col xl="4">
          <!-- Posicion 18 -->
          <head-count-rotacion :data="dataAltasBajas.revenue"></head-count-rotacion>
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
import ApexCharts from "apexcharts";
import { kFormatter } from "@core/utils/filter";
import AnalyticsSupportTracker from "./DashboardAll/HeadCount/AnalyticsSupportTracker.vue";
import EchartBar from "./DashboardAll/HeadCountPorClasificacion/EchartBar.vue";
import ChartjsHorizontalBarChart from "./DashboardAll/HeadCountPorArea/ChartjsHorizontalBarChart.vue";
import EchartBarHorizontal from "./DashboardAll/HeadCountPorAntiguedad/EchartBarHorizontal.vue";
import EcommerceRevenueReport from "./DashboardAll/HeadCountAltaBaja/EcommerceRevenueReport.vue";
import ChartjsPolarAreaChart from "./DashboardAll/HeadCountGenero/ChartjsPolarAreaChart.vue";
import HeadCountPresupuesto from "./DashboardAll/HeadCountPresupuestoComparativo/HeadCountPresupuesto.vue";
import HeadCountAltasAcumuladas from "./DashboardAll/HeadCountAltasAcumuldas/HeadCountAltasAcumuladas.vue";
import HeadCountBajasAcumuladas from "./DashboardAll/HeadCountBajasAcumuladas/HeadCountBajasAcumuladas.vue";
import HeadCountTipoContrato from "./DashboardAll/HeadCountTipoContrato/HeadCountTipoContrato.vue";
import PresupuestoTipoContrato from "./DashboardAll/PresupuestoTipoContrato/PresupuestoTipoContrato.vue";
import HeadCountAntiguedad from "./DashboardAll/HeadCountAntiguedad/HeadCountAntiguedad.vue";
import HeadCountArea from "./DashboardAll/HeadCountPorArea/HeadCountArea.vue";
import HeadcountDivision from "./DashboardAll/HeadCountPorDivision/HeadountPorDivision.vue";
import HeadCountEdad from "./DashboardAll/HeadCountEdad/HeadCountEdad.vue";
import HeadCountRotacion from "./DashboardAll/HeadCountRotacion/HeadCountRotacion.vue";
import HeadCountAntiguedadVue from "./DashboardAll/HeadCountAntiguedad/HeadCountAntiguedad.vue";
import HeadCountPromedioAnual from "./DashboardAll/HeadCountPromedioAnual/HeadCountPromedioAnual.vue";
import HeadCountPromedioTipoContrato from "./DashboardAll/HeadCountPromedioTipoContrato/HeadCountPromedioTipoContrato.vue";
import HPresupuestoGeneral from "./DashboardAll/HeadCountPresupuestoComparativo/HPresupuestoGeneral.vue";
import IndiceRotacion from "./DashboardAll/IndiceRotacion/IndiceRotacion.vue";
import IndiceRetencion from "./DashboardAll/IndiceRetencion/IndiceRetencion.vue";
import DistribucionPermanencia from "./DashboardAll/Distribucion/DistribucionPermanencia.vue";
import HeadCountGenero from "./DashboardAll/HeadCountGenero/HeadCountGenero.vue";
import HeadGeneracion from "./DashboardAll/HeadcountGeneracion/HeadGeneracion.vue";
import HorasExtrasDetalle from "./HorasExtras/HorasExtrasDetalle/HorasExtrasDetalle.vue";
import HeadcountJerarquico from "./DashboardAll/HeadcountJerarquico/HeadcountJerarquico.vue";
import HeadcountDiversidadOrigen from "./DashboardAll/HeadcountDiversidadOrigen/HeadcountDiversidadOrigen.vue";
import Nps from "./Nps/Nps.vue";

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
    AnalyticsSupportTracker,
    EchartBar,
    ChartjsHorizontalBarChart,
    EchartBarHorizontal,
    EcommerceRevenueReport,
    ChartjsPolarAreaChart,
    HeadCountPresupuesto,
    HeadCountAltasAcumuladas,
    HeadCountBajasAcumuladas,
    HeadCountTipoContrato,
    PresupuestoTipoContrato,
    HeadCountAntiguedad,
    HeadCountArea,
    HeadcountDivision,
    HeadCountEdad,
    HeadCountRotacion,
    HeadCountAntiguedadVue,
    HeadCountPromedioAnual,
    HeadCountPromedioTipoContrato,
    HPresupuestoGeneral,
    IndiceRotacion,
    IndiceRetencion,
    DistribucionPermanencia,
    HeadCountGenero,
    HeadGeneracion,
    HorasExtrasDetalle,
    HeadcountJerarquico,
    HeadcountDiversidadOrigen,
    Nps,
  },
  data() {
    return {
      data: {},
      loaded: false,
      dataHeadcount: {
        supportTracker: {
          title: "",
          lastDays: [],
          totalTicket: 332,
          newTicket: 279,
          openTicket: 31,
          responseTime: 0,
          supportTrackerRadialBar: {
            series: [85],
          },
        },
      },
      dataBajasAcumuldas: {
        ordersRecevied: {
          series: [
            {
              //concatenar el mes
              name: "Cantidad",
              data: [],
            },
          ],
          analyticsData: {
            // total acumukado del mes consultado
            orders: 38,
          },
        },
      },
      aDataAltas: {
        ordersRecevied: {
          series: [
            {
              //concatenar el mes
              name: "Cantidad",
              data: [],
            },
          ],
          analyticsData: {
            // total acumukado del mes consultado
            orders: "",
          },
        },
      },
      dataAltasBajas: {
        revenue: {
          years: ["2020", "3019", "2018"],
          price: "25,852",
          budget: "56,800",
          revenueReport: {
            series: [
              {
                name: "Altas",
                data: [],
              },
              {
                name: "Bajas",
                data: [],
              },
            ],
          },
          budgetChart: {
            series: [
              {
                name: "Altas",
                data: [],
              },
              {
                name: "Baja",
                data: [],
              },
            ],
          },
        },
      },
    };
  },
  created() {
    // data  para rellena datos de altas y bajas
    this.$http.get("/analytics/data").then((response) => {
      //  this.data = response.data;
    });
  },
  methods: {
    kFormatter,
  },
};
</script>
<style>

</style>
