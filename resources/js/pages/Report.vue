<template>
    <div>
<div class="row" >
    <div class="col-md-8"><div class="card">
    
    <h5 class="card-header">ການເຄື່ອນໄຫວທຸລະກຳ</h5>
    <div class="card-body">
      <div class="table-responsive text-nowrap">
          <div class="d-flex justify-content-between mb-2">
                          <div class="d-flex flex-column">
                              <!-- <h1>ລາຍການສຶນຄ້າ</h1> -->
                          </div>
                          <div class="d-flex align-items-end">
                              <div class="btn-group me-2" role="group" aria-label="Basic example">
                                  <button type="button" class="btn btn-secondary" @click="month_type = 'm'"><i class="bx bx-chevron-right" v-if="month_type == 'm'"></i> ເດືອນ</button>
                                  <button type="button" class="btn btn-secondary" @click="month_type = 'y'"><i class="bx bx-chevron-right" v-if="month_type == 'y'"></i> ປີ</button>
                              </div>
                              <input type="date" class="form-control" v-model="dmy">
                          </div>
                      </div>
                      <LineChart :chartData="chData" :options="choption" />
      </div>
    </div>
  </div>
</div>
    <div class="col-md-4">

        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <span><i class="bx bx-trending-down fs-4"></i><br> ລາຍຮັບ</span>
                    <span> {{ formatPrice(sum_income) }} ກີບ</span>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <span><i class="bx bx-trending-down fs-4"></i><br> ລາຍຈ່າຍ</span>
                    <span> {{ formatPrice(sum_expense) }} ກີບ</span>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <span><i class="bx bx-trending-down fs-4"></i><br> ກຳໄລ</span>
                    <span> {{ formatPrice(sum_income - sum_expense) }} ກີບ</span>
                </div>
            </div>
        </div>

    </div>
</div>
    </div>
</template>

<script>
import axios from 'axios';
import { Chart, registerables } from 'chart.js';
import { LineChart } from 'vue-chart-3';
Chart.register(...registerables);
import { useStore } from '../Store/auth';
    export default {
        setup(){
        const store = useStore();
        return { store }
        },


        data(){
            return { 

                month_type:'m',
                dmy:new Date().toISOString().slice(0,10),



            testData : {
      labels: ['Paris', 'Nîmes', 'Toulon', 'Perpignan', 'Autre'],
      datasets: [
        {
          data: [30, 40, 60, 70, 5],
          backgroundColor: ['#77CEFF', '#0079AF', '#123E6B', '#97B0C4', '#A5C8ED'],
        },
      ],
    },

    chData:[],
    choption:{

        plugins:{
            tooltip:{
                callbacks:{
                    label: function (tooltipItem , data) {
                        return (
                            Number(tooltipItem.raw) .toFixed(0) .replace(/./g, function (c,i,a) {return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "." + c : c;}) + " ກີບ"
                        )
                    },
                },
                mode:"index",
                intersect:false,
            },
            },
            responsive:true,
            maintainAspectRatio:false,
            scales:{
                    y:{
                        ticks:{
                            display:true,
                            beginAtZero:false,
                            callback:function(value , index , values){
                                console.log(value)
                                return (Number(value) .toFixed(0) .replace(/./g, function (c,i,a) {return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "." + c : c ; }) + " ກີບ")
                            },
                            
                        },
                        gridLines:{
                            show:true,
            }
          }
        }
    },
        sum_income:0,
        sum_expense:0,

            }
        },

        components:{
            LineChart
        },

        methods: {

            formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        
            CreateReport(){

axios.post('api/report'  ,{ month_type : this.month_type , dmy:this.dmy} , { headers: {Authorization: "Bearer" + this.store.get_token,}})
                        .then((res) => {
               
                            let labels = res.data.labels
                            this.chData = {
                                labels:labels,
                                datasets:[
                                    {
                                        label:"ລາຍຮັບ",
                                        fill:false,
                                        borderColor:"#3fc3ee",
                                        data:res.data.income,
                                        backgroundColor:"#9BD0F5"
                                    },
                                    {
                                        label:"ລາຍຈ່າຍ",
                                        fill:false,
                                        borderColor:"#f1556c",
                                        data:res.data.expense,
                                        backgroundColor:"#FFB1C1"
                                    },
                                ]
                            }

                            this.sum_income = res.data.sum_income
                            this.sum_expense = res.data.sum_expense

                        })
                        .catch((error)=> {
                          console.log(error)
                          if (error) {
                        if (error.response.status == 401) {
                            this.store.remove_token();
                            this.store.remove_user();
                            localStorage.removeItem("web_token");
                            localStorage.removeItem("user_token");
                            this.$router.push("/login");
                        }
                    }
                        })

            }
        },
        created(){
            this.CreateReport();
        },

        watch:{
            dmy(){
                this.CreateReport()
            },
            month_type(){
                this.CreateReport()
            }
        }
        
    }
</script>

<style  scoped>
*{
    font-family:'Phetsarath OT';
}

</style>