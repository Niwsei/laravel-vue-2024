<template>
  <div class="card">
    
  <h5 class="card-header">ການເຄື່ອນໄຫວທຸລະກຳ</h5>
  <div class="card-body">
    <div class="table-responsive text-nowrap">
        <div class="d-flex justify-content-between mb-2">
                        <div class="d-flex flex-column">
                            <!-- <h1>ລາຍການສຶນຄ້າ</h1> -->
                            <div class="d-flex align-items-center me-2">
                                <div
                                    class="d-flex justify-content-center me-2 cursor-pointer" @click="ChangSort"
                             
                                >
                                    <i
                                        class="bx bx-sort-up fs-3 me-2"
                                        v-if="Sort == 'asc'"
                                    ></i>
                                    <i
                                        class="bx bx-sort-down fs-3 me-2"
                                        v-else
                                    ></i>
                                </div>
                                <select
                                    class="form-select fs-6"
                                    v-model="PerPage"
                                    @change="getTransection()"
                                >
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex align-items-end">
                            <div class="btn-group me-2" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary" @click="month_type = 'm'"><i class="bx bx-chevron-right" v-if="month_type == 'm'"></i> ເດືອນ</button>
                                <button type="button" class="btn btn-secondary" @click="month_type = 'y'"><i class="bx bx-chevron-right" v-if="month_type == 'y'"></i> ປີ</button>
                            </div>

                   
                            <input type="date" class="form-control" data-date-format="DD/MM/YYYY" v-model="dmy" >
                        </div>
                        <!-- {{ StoreData }} -->
                    </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ວັນທີ</th>
            <th>ເລກທີທຸລະກຳ</th>
            <th>ປະເພດທຸລະກຳ</th>
            <th>ລາຍລະອຽດ</th>
            <th>ມູນຄ່າ</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="list in TransectionData.data" :key="list.id" >
            <td> {{ date(list.created_at) }}</td>
            <td> {{ list.tran_id }}</td>
            <td>{{ list.tran_type }}</td>
            <td>{{ list.tran_detail }}</td>
            <td class="text-end">{{ formatPrice(list.price) }}</td>
          </tr>
        </tbody>
      </table>
      <pagination  :pagination="TransectionData" offset="4" @paginate="getTransection($event)"   />
    </div>
  </div>
</div>
</template>

<script>
import moment from 'moment';
import axios from 'axios';
import { useStore } from '../Store/auth';

    export default {
        data(){
            return {
                    Sort:'desc',
                    PerPage:10,
                    month_type:'m',
                    TransectionData:[],
                    dmy: new Date().toISOString().slice(0,10),
            }
        },
        setup(){
          const store = useStore();
          return {store}
        },
        components:{
             moment
        },
        
        watch:{

          month_type(){
            this.getTransection();
          },
          dmy(){
            this.getTransection();
          }

        },

        methods: {
          formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },

            date(value){
              return moment(value).format("DD/MM/YYYY");

            },


            ChangSort() {
            if (this.Sort == "asc") {
                this.Sort = "desc";
            } else {
                this.Sort = "asc";
            }
            this.getTransection();
        },
        getTransection(page){
                    axios.post(`api/transection?page=${page}&sort=${this.Sort}&perpage=${this.PerPage}` ,{ 
                  month_type:this.month_type,
                  dmy:this.dmy,
                      
                } , { headers: {
                            Authorization: "Bearer" + this.store.get_token,
                        }})
                        .then((res) => {
                          this.TransectionData = res.data
                          console.log("data" , res.data.data);  
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
          this.getTransection();
        }
    }
</script>

<style lang="scss" scoped>

</style>