<template>
    <b-card>

        <b-card-header>
            <b-row>

                <b-col md="12">
                    <b-card-title>
                        Cantidad de Productos po Categoria
                    </b-card-title>
                    <hr>

                </b-col>

            </b-row>
        </b-card-header>

        <!-- title and legend -->

        <b-card-body>

            <b-row>
                <b-col md="6">

                    <b-form-group>
                        <label class="d-inline d-lg-flex">Categoria</label>
                        <v-select v-model="selectedCategoria" :options="booksCategoria" label="title"
                            placeholder="Seleccionar" style="color:brown ;  ">
                            <template #option="{ title, icon }">
                                <feather-icon :icon="icon" size="16" class="align-middle mr-50" />
                                <span> {{ title }}</span>
                            </template>
                        </v-select>
                    </b-form-group>

                </b-col>
                <b-col md="6">
                    <!-- info -->
                    <b-alert variant="info" show>
                        <h4 class="alert-heading">
                            La Categoria {{ catNombre }} Tiene {{ cantidad_productos }} Productos
                        </h4>

                    </b-alert>
                </b-col>
            </b-row>

            <b-col>

                <apexchart v-if="loaded" type="bar" height="5000" :options="chartOptions" :series="series"></apexchart>
            </b-col>







        </b-card-body>
    </b-card>
</template>
  
<script>

import {
    BRow, BAlert, BFormGroup, BCol, BFormSelect, BCard, BCardBody, BCardHeader, BCardTitle,
} from 'bootstrap-vue'
import { $themeColors } from '@themeConfig'
import apexchart from "vue-apexcharts";
import vSelect from 'vue-select'
export default {
    components: {
        BRow,
        BAlert,
        BFormGroup,
        BCol,
        vSelect,
        BCard,
        BCardBody,
        BCardHeader,
        apexchart,
        BFormSelect,
        BCardTitle,
    },
    data() {
        return {
            cantidad_productos: 0,
            catNombre: "",
            booksCategoria: [
                {
                    id: "",
                    title: "",
                    icon: 'ListIcon',
                },
            ],
            selectedCategoria: {
                id: "0",
                title: "",
                icon: 'ListIcon',
            },
            loaded: false,

            series: [{
                name: "",
                data: [21, 22, 10, 28, 16, 21, 13, 30]
            }],

            chartOptions: {
                chart: {
                    height: 350,
                    type: 'bar',
                    margin: 40,
                    events: {
                        click: function (chart, w, e) {
                            // console.log(chart, w, e)
                        }
                    }
                },
                // colors: [$themeColors.secondary],
                plotOptions: {
                    bar: {
                        columnWidth: '10',

                        distributed: true,
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val, opts) {
                        return val
                    },
                },
                legend: {
                    show: false
                },
                xaxis: {
                    categories: [],
                    labels: {

                        align: 'center',
                        style: {
                            colors: [$themeColors.secondary],
                            fontSize: '13px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            fontWeight: 10,
                        },
                        // offsetX: 100, // Ajusta el espaciado horizontal
                        offsetY: 50, // Ajusta el espaciado vertical
                    },
                   
                },
                yaxis: {
                    show: true,
                    labels: {
                        show: true,
                        align: 'left',
                        style: {
                            colors: [],
                            fontSize: '13px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            fontWeight: 10,
                        },
                    },
                },

                tooltip: {
                    enabled: true,
                    theme: "dark",

                },
            },
        }

    },
    watch: {
        selectedCategoria(newValue) {
            let me = this;
            me.series[0].data = [];
            // me.chartOptions.xaxis.categories = [];
            const axios = require("axios");
            // me.loaded = false;
            const formData = new FormData();
            formData.append("txt_catId", newValue.id);
            var url = "api/auth/CantidadCategoria";
            axios
                .post(url, formData)
                .then(function (response) {
                    var resp = response.data;
                    for (let i = 0; i < resp.length; i++) {

                        me.catNombre = resp[i].catNombre;
                        me.cantidad_productos = resp[i].cantidad_productos;
                    }

                })
                .catch((e) => {
                    alert("Falla al Obenter los Datos 😭" + e);
                });

        },
    },
    mounted() {
        let me = this
        me.cargaDato()
        me.cbxCategoria()
    },
    methods: {
        cbxCategoria() {
            let me = this;
            me.booksCategoria = [];
            var lista = [];
            var url = "api/auth/cbxCategoria";
            const axios = require("axios").default;

            axios.get(url).then(function (response) {
                var resp = response.data;
                for (let i = 0; i < resp.length; i++) {
                    lista.push({
                        id: resp[i].catId,
                        title: resp[i].catNombre,
                        icon: 'ListIcon',
                    });
                }
                me.booksCategoria = lista;
            }).catch((e) => {
                // alert("Error al Obtener Las Categorias " + e);
                console.log("cbxCategoria " + e)
                me.alertas("danger", "Categorias")
            });

        },


        cargaDato() {
            let me = this;
            me.series[0].data = [];
            me.chartOptions.xaxis.categories = [];
            const axios = require("axios");
            me.loaded = false;
            var url = "api/auth/CantidadCategoria_todo";
            axios
                .get(url)
                .then(function (response) {
                    var resp = response.data;
                    for (let i = 0; i < resp.length; i++) {
                        me.chartOptions.xaxis.categories.push(resp[i].catNombre);

                        me.chartOptions.xaxis.labels.style.colors.push($themeColors.secondary)
                        me.chartOptions.yaxis.labels.style.colors.push($themeColors.secondary)
                        me.series[0].data.push(resp[i].cantidad_productos);

                    }
                    // if (resp.length > 0) {
                    //     me.loaded = true;
                    //     me.show = false;
                    // }
                    me.loaded = true
                })
                .catch((e) => {
                    alert("Falla al Obenter los Datos 😭" + e);
                });

        }
    },

}
</script>
<style lang="scss">
@import '~@resources/scss/vue/libs/vue-select.scss';
</style>