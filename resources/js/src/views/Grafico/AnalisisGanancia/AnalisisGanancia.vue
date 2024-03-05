<template>
    <b-card no-body>
        <b-card-header>
            <!-- title and legend -->
            <b-card-title class="mb-50">
                Data Science
            </b-card-title>

        </b-card-header>

        <b-card-body>
            <div id="chart">
                <apexchart type="bar" height="430" :options="chartOptions" :series="series"></apexchart>
            </div>
        </b-card-body>
    </b-card>
</template>
  
<script>

import {
    BCard, BCardBody, BCardHeader, BCardTitle,
} from 'bootstrap-vue'

import apexchart from "vue-apexcharts";
export default {
    components: {
        BCard,
        BCardBody,
        BCardHeader,
        apexchart,

        BCardTitle,
    },
    data() {
        return {
            series: [
                {
                    data: [44, 55, 41, 64, 22, 43, 21]
                },
                {
                    data: [53, 32, 33, 52, 13, 44, 32]
                }
            ],
            chartOptions: {
                chart: {
                    type: 'bar',
                    height: 430
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        dataLabels: {
                            position: 'top',
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    offsetX: -6,
                    style: {
                        fontSize: '12px',
                        colors: ['#fff']
                    }
                },
                stroke: {
                    show: true,
                    width: 1,
                    colors: ['#fff']
                },
                tooltip: {
                    shared: true,
                    intersect: false
                },
                xaxis: {
                    categories: [' PRECINTO DE SEGURIDAD NEGRO GRANDE ', ' PRECINTO DE SEGURIDAD NEGRO GRANDE ', ' PRECINTO DE SEGURIDAD NEGRO GRANDE ', 'asdasd', 'asdasdasdasdasdas asd asda', 'asdasd', 'asdasdas'],
                },
            },



        }
    },
}
</script>
  