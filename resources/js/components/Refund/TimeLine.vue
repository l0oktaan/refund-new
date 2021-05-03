<template>
    <div>
        <highcharts :constructorType="'ganttChart'" class="hc" :options="chartOptions" ref="chart"></highcharts>

    </div>

</template>

<script>

export default {
    props: ['list'],
    data() {
    return {
      chartOptions: {
        chart: {
            style: {
                fontFamily: 'Trirong'
            }
        },
        title: {
            text: "Timeline การดำเนินการตามสัญญา",
            style: {
                fontFamily: 'Trirong',
                fontSize: 16
            },
        },
        xAxis: [{
            visible: false,

        }],
        yAxis: {
            title: {
                style: {
                    fontFamily: 'Trirong'
                }
            }
        },
        // xAxis: {
        //   min: Date.UTC(2020, 4, 1),
        //   max: Date.UTC(2020, 4, 30)
        // },
        // xAxis:{
        //     type: 'date',
        //     dateTimeLabelFormats: {
        //         day: '%e/%m',

        //     }
        // },
        // xAxis: [{
        //     // visible: false,
        //     type: 'date',
        //     dateTimeLabelFormats: {
        //         month: '%B/%Y'
        //     },
        //     tickInterval: 1000 * 60 * 60 * 24* 30, // Day
        // }],
        // yAxis: {
        //     type: 'category',
        //         grid: {
        //         borderColor: '#3a5d96',
        //         columns: [{
        //             title: {
        //                 text: 'start',
        //                 rotation: 45,
        //                 y: -15,
        //                 x: -15
        //             },
        //             labels: {
        //                 format: '{point.start}'
        //             }
        //         }]
        //     },
        // },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    // format: '{point.start}',
                    formatter: function(){
                        return new Date(this.point.start).toLocaleDateString('th-TH', { day: 'numeric', month: 'short', year: 'numeric' }) + ' - ' + new Date(this.point.end).toLocaleDateString('th-TH', { day: 'numeric', month: 'short', year: 'numeric' })
                    },
                    style: {
                        cursor: 'default',
                        pointerEvents: 'none'
                    }
                }
            }
        },

        tooltip: {
            xDateFormat: '%a %b %d, %H:%M'
        },
        series:[],
        // series: [
        //   {
        //     name: "Project 1",
        //     data: [
        //     //   {
        //     //     name: "Start prototype",
        //     //     start: Date.UTC(2014, 10, 18),
        //     //     end: Date.UTC(2014, 10, 25),
        //     //     completed: 0.25
        //     //   },
        //     //   {
        //     //     name: "Test prototype",
        //     //     start: Date.UTC(2020,4,1),
        //     //     end: Date.UTC(2020,4,25),
        //     //     fill: "#fa0"
        //     //   },
        //     //   {
        //     //     name: "Test prototype",
        //     //     start: Date.UTC(2020,4,1),
        //     //     end: Date.UTC(2020,5,31),
        //     //     fill: "#fa0"
        //     //   },
        //     //   {
        //     //     name: "Develop",
        //     //     start: Date.UTC(2014, 10, 20),
        //     //     end: Date.UTC(2014, 10, 25),
        //     //     completed: {
        //     //       amount: 0.12,
        //     //       fill: "#fa0"
        //     //     }
        //     //   },
        //     //   {
        //     //     name: "Run acceptance tests",
        //     //     start: Date.UTC(2014, 10, 23),
        //     //     end: Date.UTC(2014, 10, 26)
        //     //   }
        //     ]
        //   }
        // ]
      }
    };
  },
  mounted(){
      if (this.list){


          this.chartOptions.series.push({
              name: "Project 1",
              data: this.list
          })
      }

  },
  methods:{
      getThaiDate(item){
            var d = new Date(item);
            return d.toLocaleDateString('th-TH', { day: 'numeric', month: 'short', year: 'numeric' });
            //return moment(String(value)).format('LL')
        },
  }
}
</script>

<style scoped>
.highcharts-title{
    font-family: 'Trirong'!important;
}
</style>

