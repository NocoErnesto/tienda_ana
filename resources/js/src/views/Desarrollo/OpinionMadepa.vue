<template>
  <b-card no-body>
    <b-card-header>
      <b-card-title> ENCUESTA DE OPINION MADEPA </b-card-title>
    </b-card-header>
    <!-- chart -->
    <div id="wrap" style="width: auto">
      <div id="chart-year" style="width: fit-content">
        <apexchart
          type="bar"
          height="400"
          ref="chart"
          :options="chartOptions"
          :series="series"
        ></apexchart>
      </div>
      <div id="chart-quarter" style="width: 800px">
        <apexchart
          type="bar"
          height="400"
          ref="chartQuarter"
          :options="chartOptionsQuarter"
          :series="seriesQuarter"
        ></apexchart>
      </div>
    </div>
    <b-card-body> </b-card-body>
  </b-card>
</template>
<script>
import {
  BAvatar,
  BCardTitle,
  BCardBody,
  BCardHeader,
  BCard,
  BRow,
  BCol,
  BDropdown,
  BDropdownItem,
  BButton,
  BFormSelect,
} from "bootstrap-vue";
import apexchart from "vue-apexcharts";
import { $themeColors } from "@themeConfig";
import Ripple from "vue-ripple-directive";
import axios from "axios";
//Dimenciones
const arrayData = [
  //Dimenciones
  {
    y: 72 + "%",
    quarters: [
      {
        x: "Liderazgo",
        y: 69,
      },
      {
        x: "Organización",
        y: 71,
      },
      {
        x: "Sentido de Pertenencia",
        y: 81 + "%",
      },
      {
        x: "Condiciones de Trabajo",
        y: 71,
      },
      //   ------

      {
        x: "Motivación",
        y: 76,
      },
      {
        x: "Comunicación",
        y: 65,
      },
      {
        x: "Orientacion a Resultados",
        y: 70,
      },
      {
        x: "Reconocimiento",
        y: 70,
      },
      //   ----
      {
        x: "Actitud de Servicio",
        y: 75,
      },
      {
        x: "Trabajo en Equipo",
        y: 73,
      },
      {
        x: "Productividad",
        y: 70,
      },
      {
        x: "Ética",
        y: 72,
      },
    ],
  },

  {
    y: 79 + "%",
    quarters: [
      {
        x: "Liderazgo",
        y: 75,
      },
      {
        x: "Organización",
        y: 85,
      },
      {
        x: "Sentido de pertenencia",
        y: 78,
      },
      {
        x: "Condiciones de trabajo",
        y: 79,
      },
      //   ------

      {
        x: "Motivación",
        y: 81,
      },
      {
        x: "Comunicación",
        y: 77,
      },
      {
        x: "Orientacion a Resultados",
        y: 84,
      },
      {
        x: "Reconocimiento",
        y: 66,
      },
      //   ----
      {
        x: "Actitud de servicio",
        y: 81,
      },
      {
        x: "Trabajo en equipo",
        y: 78,
      },
      {
        x: "Productividad",
        y: 80,
      },
      {
        x: "Ética",
        y: 80,
      },
    ],
  },
  {
    y: 87 + "%",
    quarters: [
      {
        x: "Liderazgo",
        y: 89,
      },
      {
        x: "Organización",
        y: 86,
      },
      {
        x: "Sentido de pertenencia",
        y: 90,
      },
      {
        x: "Condiciones de trabajo",
        y: 87,
      },
      //   ------

      {
        x: "Motivación",
        y: 86,
      },
      {
        x: "Comunicación",
        y: 88,
      },
      {
        x: "Orientacion a Resultados",
        y: 90,
      },
      {
        x: "Reconocimiento",
        y: 75,
      },
      //   ----
      {
        x: "Actitud de servicio",
        y: 88,
      },
      {
        x: "Trabajo en equipo",
        y: 92,
      },
      {
        x: "Productividad",
        y: 89,
      },
      {
        x: "Ética",
        y: 87,
      },
    ],
  },
];

var colors = [
  "#008FFB",
  "#00E396",
  "#FEB019",
  "#FF4560",
  "#775DD0",
  "#00D9E9",
  "#FF66C3",
];
export default {
  components: {
    BAvatar,
    BCardTitle,
    BCardBody,
    BCardHeader,
    apexchart,
    BDropdown,
    BDropdownItem,
    BCard,
    BButton,
    BRow,
    BCol,
    BFormSelect,
  },
  directives: {
    Ripple,
  },

  data() {
    return {
      loaded: false,
      selectedGestion: 2022,
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
      selectedMes: "7",
      aDataMes: [
        { value: "1", text: "Ene" },
        { value: "2", text: "Feb" },
        { value: "3", text: "Mar" },
        { value: "4", text: "Abr" },
        { value: "5", text: "May" },
        { value: "6", text: "Jun" },
        { value: "7", text: "Jul" },
        { value: "8", text: "Ago" },
        { value: "9", text: "Sep" },
        { value: "10", text: "Oct" },
        { value: "11", text: "Nov" },
        { value: "12", text: "Dic" },
      ],

      series: [
        {
          data: makeData(),
        },
      ],
      chartOptions: {
        chart: {
          id: "barYear",
          height: 400,
          width: "100%",
          type: "bar",
          events: {
            dataPointSelection: function (e, chart, opts) {
              var quarterChartEl = document.querySelector("#chart-quarter");
              var yearChartEl = document.querySelector("#chart-year");

              if (opts.selectedDataPoints[0].length === 1) {
                if (quarterChartEl.classList.contains("active")) {
                  updateQuarterChart(chart, "barQuarter");
                } else {
                  yearChartEl.classList.add("chart-quarter-activated");
                  quarterChartEl.classList.add("active");
                  updateQuarterChart(chart, "barQuarter");
                }
              } else {
                updateQuarterChart(chart, "barQuarter");
              }

              if (opts.selectedDataPoints[0].length === 0) {
                yearChartEl.classList.remove("chart-quarter-activated");
                quarterChartEl.classList.remove("active");
              }
            },
            updated: function (chart) {
              updateQuarterChart(chart, "barQuarter");
            },
          },
        },
        plotOptions: {
          bar: {
            distributed: true,
            horizontal: true,
            barHeight: "75%",
            dataLabels: {
              position: "bottom",
            },
          },
        },
        dataLabels: {
          enabled: true,
          textAnchor: "start",
          style: {
            colors: ["#fff"],
          },
          formatter: function (val, opt) {
            return opt.w.globals.labels[opt.dataPointIndex];
          },
          offsetX: 0,
          dropShadow: {
            enabled: true,
          },
        },

        legend: {
          show: true,
          labels: {
            colors: "#CCCCCC",
            useSeriesColors: false,
          },

          position: "bottom",
          fontSize: "14px",
          fontFamily: "Helvetica, Arial",
          formatter: function (val, opts) {
            return val;
          },
        },
        colors: colors,

        states: {
          normal: {
            filter: {
              type: "lighten",
            },
          },
          active: {
            allowMultipleDataPointsSelection: true,
            filter: {
              type: "darken",
              value: 1,
            },
          },
        },
        tooltip: {
          enabled: true,
          theme: "dark",
          y: {
            title: {
              formatter: function (val, opts) {
                return opts.w.globals.labels[opts.dataPointIndex];
              },
            },
          },
        },

        // tooltip: {
        //   x: {
        //     show: true,
        //   },
        //   y: {
        //     title: {
        //       formatter: function (val, opts) {
        //         return opts.w.globals.labels[opts.dataPointIndex];
        //       },
        //     },
        //   },
        // },
        title: {
          style: {
            fontSize: "14px",
            fontWeight: "bold",
            fontFamily: undefined,
            color: "#CCCCCC",
          },
          text: "Indice de Satisfacción General ",
          offsetX: 15,
        },
        // subtitle: {
        //   text: "(Click on bar to see details)",
        //   offsetX: 15,
        // },
        yaxis: {
          labels: {
            show: false,
          },
        },
        xaxis: {
          show: true,
          labels: {
            show: true,
            style: {
              colors: ["#CCCCCC"],
              fontSize: "12px",
              fontFamily: "Helvetica, Arial, sans-serif",
              fontWeight: 400,
              cssClass: "apexcharts-xaxis-label",
            },
          },
        },
      },
      seriesQuarter: [
        {
          data: [],
        },
      ],
      chartOptionsQuarter: {
        chart: {
          id: "barQuarter",
          height: 400,
          width: "100%",
          type: "bar",
          stacked: true,
        },
        plotOptions: {
          bar: {
            columnWidth: "50%",
            horizontal: false,
          },
        },
        legend: {
          show: false,
        },
        grid: {
          yaxis: {
            lines: {
              show: false,
            },
          },
          xaxis: {
            lines: {
              show: true,
            },
          },
        },
        yaxis: {
          labels: {
            show: false,
          },
        },
        xaxis: {
          show: true,
          labels: {
            show: true,
            style: {
              colors: [
                "#CCCCCC",
                "#CCCCCC",
                "#CCCCCC",
                "#CCCCCC",
                "#CCCCCC",
                "#CCCCCC",
                "#CCCCCC",
                "#CCCCCC",
                "#CCCCCC",
                "#CCCCCC",
                "#CCCCCC",
                "#CCCCCC",
              ],
              fontSize: "12px",
              fontFamily: "Helvetica, Arial, sans-serif",
              fontWeight: 400,
              cssClass: "apexcharts-xaxis-label",
            },
          },
        },
        title: {
          style: {
            fontSize: "14px",
            fontWeight: "bold",
            fontFamily: undefined,
            color: "#CCCCCC",
          },
          text: "Dimensiones Generales",
          offsetX: 10,
        },
        tooltip: {
          enabled: true,
          theme: "dark",
          x: {
            formatter: function (val, opts) {
              return opts.w.globals.seriesNames[opts.seriesIndex];
            },
          },
          y: {
            title: {
              formatter: function (val, opts) {
                return opts.w.globals.labels[opts.dataPointIndex] + "(%)";
              },
            },
          },
        },
      },
    };
  },
  async mounted() {},
  methods: {
    changeData: function () {
      this.$refs.chart.updateSeries([
        {
          data: makeData(),
        },
      ]);
    },
  },
};

function shuffleArray(array) {
  for (var i = array.length - 1; i > 0; i--) {
    var j = Math.floor(Math.random() * (i + 1));
    var temp = array[i];
    array[i] = array[j];
    array[j] = temp;
  }
  return array;
}

//Años De Gestión
function makeData() {
  var dataSet = arrayData;

  var dataYearSeries = [
    {
      x: "EOM Gestión 2013 : 72%",

      y: dataSet[0].y,

      color: colors[0],
      quarters: dataSet[0].quarters,
    },
    {
      x: "EOM Gestión 2016 : 79%",
      y: dataSet[1].y,
      color: colors[1],
      quarters: dataSet[1].quarters,
    },
    {
      x: "EOM Gestión 2021 : 87%",
      y: dataSet[2].y,
      color: colors[2],
      quarters: dataSet[2].quarters,
    },
    // {
    //   x: "2014",
    //   y: dataSet[3].y,
    //   color: colors[3],
    //   quarters: dataSet[3].quarters,
    // },
    // {
    //   x: "2015",
    //   y: dataSet[4].y,
    //   color: colors[4],
    //   quarters: dataSet[4].quarters,
    // },
    // {
    //   x: "2016",
    //   y: dataSet[5].y,
    //   color: colors[5],
    //   quarters: dataSet[5].quarters,
    // },
  ];

  return dataYearSeries;
}

function updateQuarterChart(sourceChart, destChartIDToUpdate) {
  var series = [];
  var seriesIndex = 0;
  var colors = [];

  if (sourceChart.w.globals.selectedDataPoints[0]) {
    var selectedPoints = sourceChart.w.globals.selectedDataPoints;
    for (var i = 0; i < selectedPoints[seriesIndex].length; i++) {
      var selectedIndex = selectedPoints[seriesIndex][i];
      var yearSeries = sourceChart.w.config.series[seriesIndex];
      series.push({
        name: yearSeries.data[selectedIndex].x,
        data: yearSeries.data[selectedIndex].quarters,
      });
      colors.push(yearSeries.data[selectedIndex].color);
    }

    if (series.length === 0)
      series = [
        {
          data: [],
        },
      ];

    return window.ApexCharts.exec(destChartIDToUpdate, "updateOptions", {
      series: series,
      colors: colors,
      fill: {
        colors: colors,
      },
    });
  }
}
///////////////////////////////////////////7/////
</script>

<style >
/* body {
  background: #fff;
} */

/* #wrap {
  margin: 45px auto;
  max-width: 800px;
  position: relative;
} */

.chart-box {
  padding-left: 0;
}

#chart-year,
#chart-quarter {
  width: 50%;
  max-width: 100%;
  box-shadow: none;
  padding-left: 0;
  padding-top: 50px;
  /* background: #fff;
  border: 1px solid #ddd; */
}

#chart-year {
  float: left;
  position: relative;
  transition: 1s ease transform;
  z-index: 3;
}

#chart-year.chart-quarter-activated {
  transform: translateX(0);
  transition: 1s ease transform;
}

#chart-quarter {
  float: left;
  position: relative;
  z-index: -2;
  transition: 1s ease transform;
}

#chart-quarter.active {
  transition: 1.1s ease-in-out transform;
  transform: translateX(0);
  z-index: 1;
}

@media screen and (min-width: 40px) {
  #chart-year {
    transform: translateX(50%);
  }
  #chart-quarter {
    transform: translateX(-10%);
  }
}
</style>