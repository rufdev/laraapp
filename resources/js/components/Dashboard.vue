<template>
    <div class="container-fluid">
        <div
            class="row mt-3"
            v-if="
                $gate.isAdmin() ||
                    $gate.isSupport() ||
                    $gate.isGuest() ||
                    $gate.isTechnical()
            "
        >
            <div class="col-lg-3 col-6" v-if="dashboarddata.studenttotal">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 v-if="dashboarddata.usercount > 0">
                            {{ dashboarddata.usercount }}
                        </h3>
                        <h3
                            v-if="
                                dashboarddata.usercount === 0 ||
                                    dashboarddata.usercount === ''
                            "
                        >
                            0
                        </h3>

                        <p>No. of Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6" v-if="dashboarddata.studenttotal">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 v-if="dashboarddata.schools.length > 0">
                            {{ dashboarddata.schools.length }}
                        </h3>
                        <h3
                            v-if="
                                dashboarddata.schools.length === 0 ||
                                    dashboarddata.schools.length === ''
                            "
                        >
                            0
                        </h3>

                        <p>Number of Schools</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-school"></i>
                    </div>
                    <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
                </div>
            </div>

            <!-- ./col -->
            <div class="col-lg-3 col-6" v-if="dashboarddata.studenttotal">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 v-if="dashboarddata.studenttotal[0].totalmale > 0">
                            {{
                                Number(
                                    dashboarddata.studenttotal[0].totalmale
                                ).toLocaleString()
                            }}
                        </h3>
                        <h3
                            v-if="
                                dashboarddata.studenttotal[0].totalmale === 0 ||
                                    dashboarddata.studenttotal[0].totalmale ===
                                        ''
                            "
                        >
                            0
                        </h3>

                        <p>Total Male</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-male"></i>
                    </div>
                    <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6" v-if="dashboarddata.studenttotal">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3
                            v-if="dashboarddata.studenttotal[0].totalfemale > 0"
                        >
                            {{
                                Number(
                                    dashboarddata.studenttotal[0].totalfemale
                                ).toLocaleString()
                            }}
                        </h3>
                        <h3
                            v-if="
                                dashboarddata.studenttotal[0].totalfemale ===
                                    0 ||
                                    dashboarddata.studenttotal[0]
                                        .totalfemale === ''
                            "
                        >
                            0
                        </h3>

                        <p>Total Female</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-female"></i>
                    </div>
                    <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
                </div>
            </div>
            <!-- ./col -->
        </div>

        <div
            v-if="
                !(
                    $gate.isAdmin() ||
                    $gate.isEncoder() ||
                    $gate.isGuest() ||
                    $gate.isTechnical()
                )
            "
        >
            <not-found></not-found>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-danger">
                    <div class="card-header">
                        <div class="card-title">
                            <select name="school" id="school" class="form-control" @change="onSelectSchool($event)">>
                                <option v-for="item in dashboarddata.schools" v-bind:key="item.id" v-bind:value="item.id">
                                    {{ item.id }} | {{ item.name }}
                                </option>
                            </select>
                        </div>
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link active" href='#bar' data-toggle="tab">Stacked Bar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href='#pie' data-toggle="tab">Donut</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content p-0">
                            <div class="chart tab-pane active" id='bar' style="position: relative; height: 300px;">
                                <canvas id='stackedBarChart' style="height:230px; min-height:230px"></canvas>
                            </div>
                            <div class="chart tab-pane" id='pie' style="position: relative; height: 300px;">
                                <canvas id='donutChart' style="height:230px; min-height:230px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-lg-6" v-for="survey in surveydata" :key="survey.schoolid">

            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">{{survey.name}}</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <canvas :id="'donutChart' + survey.schoolid" style="height:230px; min-height:230px"></canvas>
              </div>

            </div>

            </div>
        </div> -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            dashboarddata: [],
            surveydata: [],
            chartdata : [],
            chartdatacreated: false,
            donutOptions: {
                maintainAspectRatio: false,
                responsive: true
            },
            barchartdata : []

        };
    },
    methods: {
        loaddonutchart() {
                $('#donutChart').remove(); // this is my <canvas> element
                $('#pie').append("<canvas id='donutChart' style='height:230px; min-height:230px'></canvas>");
                var donutChartCanvas = $("#donutChart").get(0).getContext("2d");

                var donutChart = new Chart(donutChartCanvas, {
                    type: "doughnut",
                    data: this.chartdata,
                    options: this.donutOptions
                });
        },
        loadstakedchart() {
                $('#stackedBarChart').remove(); // this is my <canvas> element
                $('#bar').append("<canvas id='stackedBarChart' style='height:230px; min-height:230px'></canvas>");
                var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d');

                var stackedBarChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                scales: {
                    xAxes: [{
                    stacked: true,
                    }],
                    yAxes: [{
                    stacked: true
                    }]
                }
                }

                var stackedBarChart = new Chart(stackedBarChartCanvas, {
                type: 'bar',
                data: this.barchartdata,
                options: stackedBarChartOptions
                })
        },
        getDashboardResults(page = 1) {
            axios.get("api/dashboard").then(response => {
                this.dashboarddata = response.data;
                var event = {
                    target: {value : 1}
                };
                this.onSelectSchool(event);
            });
        },
        onSelectSchool(event){
            axios.get("api/getschoolchartdata?schoolid=" + event.target.value).then(response => {
            const self = this;

            var dynamicColors = function() {
                var r = Math.floor(Math.random() * 255);
                var g = Math.floor(Math.random() * 255);
                var b = Math.floor(Math.random() * 255);
                return "rgb(" + r + "," + g + "," + b + ")";
            };
            this.chartdata = response.data[0].piedata;
            this.barchartdata = response.data[0].bardata;
            for (var key in this.chartdata.datasets[0].data) {
               this.chartdata.datasets[0].backgroundColor.push(dynamicColors());
            }

            // for (var key in this.chartdata) {
            //     this.chartdata = this.chartdata.map( function(val) {
            //                 return val.schoolid === self.surveydata[key].schoolid
            //                 ? (val = {...val,...val.datasets[0].backgroundColor.push(dynamicColors())})
            //                 : val
            //             });
            // }
            // for (var key in this.surveydata) {
            //     var data = {
            //         schoolid : this.surveydata[key].schoolid,
            //         name : this.surveydata[key].schoolname,
            //         labels : [],
            //         datasets : [{
            //             data : [],
            //             backgroundColor : []
            //         }]
            //     };
            //     var school = (this.chartdata.length > 0 ? this.chartdata.find( ({schoolid}) => schoolid === this.surveydata[key].schoolid) : false);
            //     if (school){
            //         this.chartdata = this.chartdata.map( function(val) {
            //             return val.schoolid === self.surveydata[key].schoolid
            //             ? (val = {...val,...val.labels.push(self.surveydata[key].levelname),...val.datasets[0].data.push(self.surveydata[key].totalstudents),...val.datasets[0].backgroundColor.push(dynamicColors())})
            //             : val
            //         });
            //     } else {
            //         data.labels.push(this.surveydata[key].levelname);
            //         data.datasets[0].data.push(this.surveydata[key].totalstudents);
            //         data.datasets[0].backgroundColor.push(dynamicColors());
            //         this.chartdata.push(data);
            //     }
            // }

            // for (var key in this.surveydata){
            //     var data =  {
            //         schoolid : this.surveydata[key].schoolid,
            //         name : this.surveydata[key].schoolname,
            //         labels : [],
            //         datasets : [
            //             {
            //                 label               : 'Total Male',
            //                 backgroundColor     : 'rgba(60,141,188,0.9)',
            //                 borderColor         : 'rgba(60,141,188,0.8)',
            //                 pointRadius          : false,
            //                 pointColor          : '#3b8bba',
            //                 pointStrokeColor    : 'rgba(60,141,188,1)',
            //                 pointHighlightFill  : '#fff',
            //                 pointHighlightStroke: 'rgba(60,141,188,1)',
            //                 data                : []
            //             },
            //             {
            //                 label               : 'Total Female',
            //                 backgroundColor     : 'rgba(210, 214, 222, 1)',
            //                 borderColor         : 'rgba(210, 214, 222, 1)',
            //                 pointRadius         : false,
            //                 pointColor          : 'rgba(210, 214, 222, 1)',
            //                 pointStrokeColor    : '#c1c7d1',
            //                 pointHighlightFill  : '#fff',
            //                 pointHighlightStroke: 'rgba(220,220,220,1)',
            //                 data                : []
            //             }
            //         ]
            //     }

            //     var school = (this.barchartdata.length > 0 ? this.barchartdata.find( ({schoolid}) => schoolid === this.surveydata[key].schoolid) : false);
            //     if (school){
            //         this.barchartdata = this.barchartdata.map( function(val) {
            //             return val.schoolid === self.surveydata[key].schoolid
            //             ? (val = {...val,...val.labels.push(self.surveydata[key].levelname),...val.datasets[0].data.push(self.surveydata[key].totalmale),...val.datasets[1].data.push(self.surveydata[key].totalfemale)})
            //             : val
            //         });
            //     } else {
            //         data.labels.push(this.surveydata[key].levelname);
            //         data.datasets[0].data.push(this.surveydata[key].totalmale);
            //         data.datasets[1].data.push(this.surveydata[key].totalfemale);
            //         this.barchartdata.push(data);
            //     }
            // }

            window.setTimeout(function() {
                self.loaddonutchart();
                self.loadstakedchart();
            }, 300);
        });
        }

    },
    created() {
        if (
            this.$gate.isAdmin() ||
            this.$gate.isSupport() ||
            this.$gate.isGuest() ||
            this.$gate.isTechnical()
        ) {
            this.getDashboardResults();
        }
    },
    mounted() {

    }
};
</script>
<style>
.report-modal-body {
    max-height: calc(100vh - 150px);
    overflow-y: auto;
    overflow-x: auto;
    white-space: pre;
    font-family: monospace;
}
</style>
