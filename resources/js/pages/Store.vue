<template>
    <div>


        <div class="card">
  <h5 class="card-header">ລາຍການສະຕ໊ອກສຶນຄ້າ</h5>
  <div class="card-body">

    <div class="form" v-if="ShowForm">
        <div class="text-end">
          <button class="btn btn-info me-2" @click="SaveStore()" :disabled="CheckForm">ບັນທຶກ</button>
          <button class="btn btn-danger" @click="CancelStore">ຍົກເລິກ</button>
        </div>
      {{ FormStore }}
        <div class="row">
          <div class="col-md-3">Image</div>
          <div class="col-md-9">Input
          <div class="mb-2">
            <label class="form-label fs-5" for="product_name ">ຊື່ສິນຄ້າ:</label>
            <input type="text" class="form-control" id="product_name " v-model="FormStore.name">
          </div>

          <div class="mb-2">
            <label class="form-label fs-5" for="product_amount ">ຈຳນວນ:</label>
            <input type="text" class="form-control" id="product_amount " v-model="FormStore.amount">
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-2">
            <label class="form-label fs-5" for="product_price_buy ">ລາຄາຊື່:</label>
            <input type="text" class="form-control" id="product_price_buy" v-model="FormStore.price_buy">
          </div>
            </div>
            <div class="col-md-6">
              <div class="mb-2">
            <label class="form-label fs-5" for="product_price_sell ">ລາຄາຂາຍ:</label>
            <input type="text" class="form-control" id="product_price_sell" v-model="FormStore.price_sell">
          </div>
            </div>
          </div>
        </div>

        </div>
      </div>
      
    <div class="table-responsive text-nowrap" v-if="!ShowForm">
        <div class="d-flex justify-content-between mb-2">

            <div class="d-flex flex-column">
            <!-- <h1>ລາຍການສຶນຄ້າ</h1> -->
            <div class="d-flex align-items-center me-2 w-50">
            <i class="bx bx-sort-up fs-3 me-2"></i>
            <select class="form-select fs-6">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
          </select>
        </div>
            </div>


            <div class="d-flex  align-items-end  ">
                    <input type="text" class="form-control me-2" placeholder="ຄົ້ນຫາ.....">
                    <button @click="AddStore" class="btn btn-primary "><i class="bx bx-user-plus me-1 fs-5"></i>ເພີ່ມຂໍ້ມູນ</button>
            </div>
{{ StoreData }}
        </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th class="font-weight-bold ">ID</th>
            <th>ຮູບ</th>
            <th>ຊື່ສຶນຄ້າ</th>
            <th>ລາຄາຊື່</th>
            <th>ຈັດການ</th>
          </tr>
        </thead>
        <tbody>
          
          
            
          <tr v-for="list in StoreData" :key="list.id">
            <td>{{ list.id }}</td>
            <td>-</td>
            <td>
              {{ list.name }}
            </td>
            <td><span class="badge bg-label-warning me-1">{{ list.price_buy }}</span></td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-copy-alt me-1"></i> ກອບປີ້</a>
                  <a class="dropdown-item" href="javascript:void(0);" @click="EditStore(list.id)"><i class="bx bx-edit-alt me-1"></i> ເເກ້ໄຂ</a>
                  <a class="dropdown-item" href="javascript:void(0);" @click="DeleteStore(id)"><i class="bx bx-trash me-1"></i> ລົບຂໍ້ມູນ</a>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- <input type="text" v-model="text">
<button @click="add()" style="padding: 1px 20px; margin-left:10px ; border: none; background-color: black; color: white;cursor: pointer;">submit</button>
   -->  </div>
</template>

<script>
import { useStore } from '../Store/auth'
import axios from 'axios';
    export default {
        name:"Minipos14Store",

        data() {
            return {
                text:'',
                FormType: true,
                ShowForm:false,
                EditID:'',
                FormStore:{
                  name:'',
                  image:'',
                  amount:'',
                  price_buy:'',
                  price_sell:'',
                },
                StoreData:[],
            }
        },

        computed: {
            CheckForm() {
              if(this.FormStore.name == '' || this.FormStore.amount == '' || this.FormStore.price_buy == '' || this.FormStore.price_sell == '' ){
                return  true;
              }
              else {
                return  false;
              }
            }
        },

        setup(){
            const store = useStore();
            return {store}
        },

        methods: {
            add(){
         localStorage.setItem('web_token' , this.text);

               /* this.store.set_token(this.text); */

                },

                AddStore(){
                   this.ShowForm = true;
                  this.FormType = true;
                 this.FormStore.name = ''
                  this.FormStore.amount = ''
                  this.FormStore.price_buy = ''
                  this.FormStore.price_sell = ''
                },
                CancelStore(){
                  this.ShowForm = false;
                },
                EditStore(id){
                    console.log(id);
                    this.FormType = false;
                    this.EditID = id;

                    axios.get(`api/store/edit/${id}`, {headers: {"Content-Type":"multipart/form-data" , Authorization:"Bearer" + this.store.get_token}})
                    .then((res) => {
                        this.FormStore = res.data;
                        this.ShowForm = true;
                    })
                    .catch((err) => {
                      console.log('err :' , err)
                    })

                },

                DeleteStore(id){
                  axios.delete(`api/store/delete/${id}`, {headers: {Authorization:"Bearer" + this.store.get_token}})
                  .then((res) => {
                       if(res.data.success){
                        this.GetStore()
                       }
                    })
                    .catch((err) => {
                      console.log('err :' , err)
                    })

                },



                SaveStore(){
                        if(this.FormType){
                            //
                            axios.post('api/store/add' , this.FormStore ,  {headers: {"Content-Type":"multipart/form-data" , Authorization:"Bearer" + this.store.get_token}})
                            .then((res)=> {

                              if(res.data.success){
                                this.ShowForm = false;
                              }
                            }).catch((error) => {
                              console.log('err:' , error)
                            })
                        }
                        else {
                                  // update StoreData
                            axios.post(`api/store/update/${this.EditID}` , this.FormStore ,  {headers: {"Content-Type":"multipart/form-data" , Authorization:"Bearer" + this.store.get_token}})
                            .then((res)=> {

                              if(res.data.success){
                                this.ShowForm = false;
                                this.GetStore()
                              }
                            }).catch((error) => {
                              console.log('err:' , error)
                            })
                        }
                },


                GetStore(){
                      axios.get('api/store' , {headers: {Authorization:"Bearer" + this.store.get_token}}).then((res)=> {
                      this.StoreData = res.data;
                      })
                      .catch((error) =>{
                          console.log('err:' , error)
                      })
                },
               
        },
        created(){
                  this.GetStore();
                }
        
    }
</script>

<style lang="scss" scoped>

</style>