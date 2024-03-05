<template>
  <b-card no-body>
    <b-card-body class="pb-0">
      <b-avatar class="mb-1" :variant="`light-${color}`" size="45">
        <feather-icon size="21" :icon="icon" />

      </b-avatar>

      <b-form-select v-model="selectedMes" :options="aDataMes" :state="selectedMes === null ? false : true"
        @change="obtenerDatos" />
      <b-form-select v-model="selectedGestion" :options="aDataGestion" :state="selectedGestion === null ? false : true"
        @change="obtenerDatos" />

      <div class="truncate">
        <h2 class="mb-25 font-weight-bolder">
          {{ statistic }}
        </h2>
        <span>{{ statisticTitle }}</span>

      </div>
    </b-card-body>

    <vue-apex-charts type="area" height="200" width="100%" :options="chartOptionsComputed" :series="chartData" />

  </b-card>
</template>

<script>
import { BCard, BCardBody, BAvatar, BFormSelect } from 'bootstrap-vue'
import VueApexCharts from 'vue-apexcharts'
import { $themeColors } from '@themeConfig'
import { areaChartOptions } from './chartOptions'


export default {
  components: {
    VueApexCharts,
    BCard,
    BCardBody,
    BAvatar,
    BFormSelect
  },
  props: {
    icon: {
      type: String,
      required: true,
    },
    statistic: {
      type: [Number, String],
      required: true,
    },
    statisticTitle: {
      type: String,
      default: '',
    },
    color: {
      type: String,
      default: 'primary',
    },
    chartData: {
      type: Array,
      default: () => [],
    },
    chartOptions: {
      type: Object,
      default: null,
    },
   
  },
   data() {
      return {
        
        selectedGestion: "2021",
        aDataGestion: [
          { value: "2014", text: "2014" },
          { value: "2015", text: "2015" },
          { value: "2016", text: "2016" },
          { value: "2017", text: "2017" },
          { value: "2018", text: "2018" },
          { value: "2019", text: "2019" },
          { value: "2020", text: "2020" },
          { value: "2021", text: "2021" },
          { value: "2022", text: "2022" },
          { value: "2023", text: "2023" },
        ],
        selectedMes: "Marzo",
        aDataMes: [
          { value: "01", text: "Enero" },
          { value: "02", text: "Febrero" },
          { value: "03", text: "Marzo" },
          { value: "04", text: "Abril" },
          { value: "05", text: "Mayo" },
          { value: "06", text: "Junio" },
          { value: "07", text: "Julio" },
          { value: "08", text: "Agosto" },
          { value: "09", text: "Septiembre" },
          { value: "10", text: "Octubre" },
          { value: "11", text: "Noviembre" },
          { value: "12", text: "Diciembre" },
        ],
      }
    },

  computed: {
    chartOptionsComputed() {
      if (this.chartOptions === null) {
        const options = JSON.parse(JSON.stringify(areaChartOptions))
        options.theme.monochrome.color = $themeColors[this.color]
        return options
      }
      return this.chartOptions
    },
  },

}
</script>
