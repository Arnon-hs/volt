<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               <i class="el-icon-s-data"></i> Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg d-inline-flex justify-content-center align-items-center">
                    <div class="d-inline-block">
                        <vue3-chart-js
                                :id="lineChart.id"
                                :type="lineChart.type"
                                :data="lineChart.data"
                                :options="lineChart.options"
                                style="height:300px;width:auto;"
                        ></vue3-chart-js>
                    </div>
                    <div class="d-inline-block">
                        <vue3-chart-js
                                :id="lineChart2.id"
                                :type="lineChart2.type"
                                :data="lineChart2.data"
                                :options="lineChart2.options"
                                style="height:300px;width:auto;"
                        ></vue3-chart-js>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Vue3ChartJs from '@j-t-mcc/vue3-chartjs'

    export default {
        components: {
            AppLayout,
            Vue3ChartJs
        },
        props: [
            'stats'
        ],
        setup (props) {
            // console.log(props)
            let labels = props.stats.map(a => a.timestamp)
            let dataVoltage = props.stats.map(a => a.mains_voltage)
            let dataTemperature = props.stats.map(a => a.temperature)

            const lineChart = {
                id: 'line',
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            backgroundColor: 'rgba(0, 0, 0, 0.0)',
                            borderColor: '#424ef5',
                            label: 'Main voltage',
                            data: dataVoltage
                        }
                    ]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false
                }
            }

            const lineChart2 = {
                id: 'line2',
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            backgroundColor: 'rgba(0, 0, 0, 0.0)',
                            borderColor: '#DD1B16',
                            label: 'Temperature',
                            data: dataTemperature
                        }
                    ]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false
                }
            }

            const beforeRenderLogic = (event) => {
                //...
                //if(a === b) {
                //  event.preventDefault()
                //}
            }

            return {
                lineChart,
                lineChart2,
                beforeRenderLogic
            }
        },
    }
</script>
