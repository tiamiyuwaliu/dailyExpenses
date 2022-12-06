<template>
    <AdminLayout :title="__('Welcome :name', {name: $page.props.auth.user.name})">

        <v-row
            align="start"
            class="dashboard-statistics"
            no-gutters
        >
            <v-col v-for="stat in stats" :key="stat.title" cols="12" md="3" class="each ">
                <v-hover v-slot="{ isHovering, props }">
                    <v-card
                        v-bind="props"
                        :class="isHovering ? 'elevation-lg' : 'elevation-sm'"
                        class="ma-2 pa-4 rounded-lg" >
                        <div class="clearfix">
                            <div class="float-left">
                                <v-btn
                                    variant="tonal"
                                    :icon="stat.icon"
                                    :color="isHovering? 'primary' : 'grey'"
                                ></v-btn>
                            </div>
                            <div class="float-right">
                                <h3 class="text-h3 font-weight-thin " :class="isHovering ? 'text-dark' : 'text-grey'">{{stat.count}}</h3>
                            </div>
                        </div>

                        <div class="mt-2">
                            <h4 class="font-weight-light title pb-3 ">{{stat.title}}</h4>
                        </div>
                    </v-card>
                </v-hover>
            </v-col>

        </v-row>

        <v-row class="mt-3" no-gutters align="start">
            <v-col>
                <v-card class="pa-10 ma-2 elevation-sm">
                    <vue3-chart-js
                        :id="doughnutChart.id"
                        :type="doughnutChart.type"
                        :data="doughnutChart.data"
                    ></vue3-chart-js>
                </v-card>
            </v-col>
            <v-col>
                <v-card class="pa-10 ma-2 elevation-sm">
                    <vue3-chart-js
                        :id="doughnutChart.id"
                        :type="doughnutChart.type"
                        :data="doughnutChart.data"
                    ></vue3-chart-js>
                </v-card>
            </v-col>
        </v-row>
    </AdminLayout>
</template>

<script>
import AdminLayout from '@/Pages/Admin/Layout/Base.vue'
import { Head } from '@inertiajs/inertia-vue3';
import Vue3ChartJs from "@j-t-mcc/vue3-chartjs";

 export default  {
    setup () {
        const doughnutChart = {
            id: 'doughnut',
            type: 'line',
            data: {
                labels: ['VueJs', 'EmberJs', 'ReactJs', 'AngularJs'],
                datasets: [
                    {
                        label: 'My First Dataset',
                        data: [65, 59, 80, 81, 56, 55, 40],
                        fill: true,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }
                ]
            }
        }

        return {
            doughnutChart,
        }
    },
     data() {

         return {
             stats: this.$page.props.stats,
             chartData: {
                 labels: [ 'January', 'February', 'March' ],
                 datasets: [ { data: [40, 20, 12] } ]
             },
             chartOptions: {
                 responsive: true
             }
         }
     },
     components: {
         AdminLayout, Vue3ChartJs
     }
 }
</script>
