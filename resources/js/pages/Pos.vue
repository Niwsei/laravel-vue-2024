<template>
    <div class="row">
        <div class="col-8">
            <div class="card mb-3">
                <div class="card-body">
                 <input type="search" class=" form-control" placeholder="ຄົ້ນຫາ..." v-model="Search" @keyup.enter="GetStore()">
                </div>
            </div>
            <perfect-scrollbar>
              <div style="height: 66vh;">
            <div class="row m-1"  >        
                <div class=" col-md-3" v-for="item in StoreData.data" :key="item.id" >
                <div class=" card h-100 cursor-pointer" style="position: relative;" @click="AddProduct(item.id)">
                  <span v-for="i in ListOrder" :key="i.id">
                  <span class="number-list" v-if="item.id == i.id" style="position: absolute; top: 0;right: 0; background-color: blueviolet; border-radius:0px 5px 0px 8px;width: 22px;height: 22px;text-align: center;outline: none;color: white;"> {{ i.order_amount }}</span>
                </span>
      <img class="img-pos card-img-top" :src=" url + '/assets/img/' + item.image" v-if="item.image" >
      <img class="img-pos card-img-top" :src=" url + '/assets/img/download.jpeg'" v-else>
      <div class="card-body p-1 text-center">
        <h5 class="card-title">{{item.name}}</h5>
        <p class="card-text">
        {{ item.price_sell }}
        </p>
       
      </div>
    </div>
  </div>
            </div>
            </div>
        </perfect-scrollbar>
        </div>



        <div class="col-4">
           <div class="card">
            <div class="card-body p-0">
              <div class="p-4">
              <label for="customer_name">ຊື່ລູກຄ້າ:</label>
              <input type="text" class="form-control mt-2" id="customer_name" placeholder="......." v-model="customer_name">
              <label for="customer_tel">ເບີໂທ:</label>
              <input type="text" class="form-control mt-2" id="customer_tel" placeholder="......." v-model="customer_tel">
            </div>
              <hr>
              <div class="p-4">
                <div class="d-flex justify-content-between  text-info align-items-center">
                  <span class="fs-5 fw-bold">
                    ລວມຍອດເງີນ:
                  </span>
                  <span class="fs-5 fw-bold">
                    {{ formatPrice(TotalAmount) }} ກີບ
                  </span>
                </div>
                <button class="btn btn-success mt-2 fw-bold w-100 fs-5" :disabled="!TotalAmount" @click="ShowModal()"> ຊຳລະເງີນ</button>
              </div>


              <PerfectScrollbar class="mb-3">
                <div  style="height: 40vh;">
  <div class="table-responsive text-nowrap mb-3">
    <table class="table border">
      <thead>
        <tr>
          <th>ລາຍລະອຽດ  </th>
          <th>ລາຄາ</th>
          <th>ລາຄາລວມ</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for=" list in ListOrder" :key="list.id">
          <td>{{list.name}}</td>
          <td class="text-end " style="background-color: none;">{{formatPrice(list.price_sell)}} <br> <i class="bx bx-minus-circle cursor-pointer text-danger" @click="RemoveProduct(list.id)"></i> {{ formatPrice(list.order_amount) }} <i class="bx bx-plus-circle cursor-pointer text-success" @click="AddProduct(list.id)"></i> | <i class="bx bx-trash-alt cursor-pointer text-danger" @click="DeleteProduct(list.id)"></i></td>
          <td class="text-end">{{ formatPrice(list.order_amount * list.price_sell) }}</td>
        </tr>
        
      </tbody>

    </table>
  </div>
</div>
</PerfectScrollbar>
            </div>
           </div>
        </div>


        <div class="modal fade" id="confirm_pay_modal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel1">ການຊຳລະເງີນ</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                      <div class="d-flex justify-content-between">
                    <span>ລວມຍອດເງີນ:</span>
                    <span>{{ formatPrice(TotalAmount) }} ກີບ</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>ຮັບເງີນນຳລູກຄ້າ:</span>
                    <span>{{ formatPrice(CashAmount) }} ກີບ</span>
                </div>
                <div class="d-flex justify-content-between text-danger" v-if="(CashAmount-TotalAmount)>0">
                    <span>ເງີນທອນ:</span>
                    <span>{{ formatPrice(CashAmount - TotalAmount) }} ກີບ</span>
                </div>


                <div class="d-flex justify-content-center">
                  <div class="row" style="width: 250px;">


                  <div class="col-md-4 mt-2">
                <button class="btn btn-primary" style="width: 60px;" @click="AddNum('1')">1</button>
                  </div>

                  <div class="col-md-4 mt-2">
                <button class="btn btn-primary" style="width: 60px;" @click="AddNum('2')">2</button>
                  </div>

                  <div class="col-md-4 mt-2">
                <button class="btn btn-primary" style="width: 60px;" @click="AddNum('3')">3</button>
                  </div>

                  <div class="col-md-4 mt-2">
                <button class="btn btn-primary" style="width: 60px;" @click="AddNum('4')">4</button>
                  </div>

                  <div class="col-md-4 mt-2">
                <button class="btn btn-primary" style="width: 60px;" @click="AddNum('5')">5</button>
                  </div>

                  <div class="col-md-4 mt-2">
                <button class="btn btn-primary" style="width: 60px;" @click="AddNum('6')">6</button>
                  </div>

                  <div class="col-md-4 mt-2">
                <button class="btn btn-primary" style="width: 60px;" @click="AddNum('7')">7</button>
                  </div>

                  <div class="col-md-4 mt-2">
                <button class="btn btn-primary" style="width: 60px;" @click="AddNum('8')">8</button>
                  </div>

                  <div class="col-md-4 mt-2">
                <button class="btn btn-primary" style="width: 60px;" @click="AddNum('9')">9</button>
                  </div>

                  <div class="col-md-4 mt-2">
                <button class="btn btn-primary" style="width: 60px;" @click="AddNum('00')">00</button>
                  </div>

                  <div class="col-md-4 mt-2">
                <button class="btn btn-primary" style="width: 60px;" @click="AddNum('0')">0</button>
                  </div>

                  <div class="col-md-4 mt-2">
                <button class="btn btn-danger" style="width: 60px;" @click="AddNum('-')"><i class="bx bx-left-arrow-alt " style="height: 23px;"></i></button>
                  </div>

                  </div>
                </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ປິດ</button>
                  <button type="button" class="btn btn-primary" :disabled="!(CashAmount>=TotalAmount)" @click="ConfirmPay">ຢືນຢັນຊຳລະເງີນ</button>
                </div>
              </div>
            </div>
          </div>
    </div>

</template>

<script>
import { PerfectScrollbar } from 'vue3-perfect-scrollbar';
import { useStore } from '../Store/auth'
    export default {

  data :() => ({
            url:window.location.origin,
        Sort:'desc',
        PerPage:'30',
        Search:'',
        StoreData:[],
        ListOrder:[],
        CashAmount:0,
        customer_name:'',
        customer_tel:'',


  }),

  setup(){
            const store = useStore();
            return {store}
        },

        watch: {
            Search(){
              if(this.Search == "" || this.Search.length > 0){
                this.GetStore()
            }
        }
      },


        methods: {
          AddNum(num){
              if(num == '-'){
                  this.CashAmount = this.CashAmount.slice(0 , -1)
              }else {
                this.CashAmount = this.CashAmount + num;
              }
          },



          ShowModal(){
            $('#confirm_pay_modal').modal('show')
          },

          async openLink(link){
            const response = await fetch(`${link}` , { headers:{Authorization: 'Bearer'+ this.store.get_token}})
            const html = await response.text();
            const blob = new Blob([html] , {type: "text/html"});
            const blobUrl = URL.createObjectURL(blob);
            window.open(blobUrl , "_blank");
          },
          

          ConfirmPay(){
            axios.post('api/transection/add' , {
              customer_name: this.customer_name,
              customer_tel:this.customer_tel,
              listorder:this.ListOrder,
              acc_type: 'income'
            },{headers: {Authorization:"Bearer" + this.store.get_token}})
            .then((res) => {
              if (res.data.success) {
                $('#confirm_pay_modal').modal('hide')
                this.ListOrder = [];
                this.CashAmount = '';
                this.customer_name= '';
                this.customer_tel = '';
                 this.GetStore()


              /*    window.open(this.url + '/api/bills/print/' + res.data.bill_id , '_blank') */
                 this.openLink(this.url + '/api/bills/print/' + res.data.bill_id , '_blank' )


                            this.$swal({
                                position:'center',
                                toast:true,
                                icon: 'success',
                                title: res.data.message,
                                showConfirmButton: false,
                                timer: 1800,
                            });
                        }
                        else{
                            this.$swal({
                                title: res.data.message,
                                icon:'error',
                                showConfirmButton:false,
                                timer:1800
                            })
                        }
            })
            .catch((error) =>{
                        console.log('err:' , error)
                        if(error) {
                          if(error.response.status == 401) {
                            this.store.remove_token()
                            this.store.remove_user()
                            localStorage.removeItem('web_token')
                            localStorage.removeItem('user_token')
                            this.$router.push('/login')
                            
                          }
                        }
                      })
          },

          formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },

          AddProduct(id){
               let item = this.StoreData.data.find((i) => i.id == id);
               let list_order_item = this.ListOrder.find((i) => i.id == id);

               if(list_order_item){
                  list_order_item.order_amount++;
               }else{
                this.ListOrder.push({
                id:item.id,
                name: item.name,
                order_amount:1, 
                price_sell:item.price_sell
                  
               })
               }


              
          },
          RemoveProduct(id){
                let item  =this.ListOrder.find((i) => i.id == id)

                if(item){
                    item.order_amount--;
                    if(item.order_amount < 1){
                      this.ListOrder.splice(this.ListOrder.map((i)=>id).indexOf(id),1);
                    
                }else{
                  return
                }
              }
          },
          DeleteProduct(id){
            this.ListOrder.splice(this.ListOrder.map((i)=>id).indexOf(id),1);
          },

            GetStore(page){
                     axios.get(`api/store?page=${page}&sort=${this.Sort}&perpage=${this.PerPage}&search=${this.Search}` , {headers: {Authorization:"Bearer" + this.store.get_token}})
                      .then((res)=> {
                      this.StoreData = res.data;
                      console.log("Data: "  ,res.data.data);
     

                      })
                      .catch((error) =>{
                        console.log('err:' , error)
                        if(error) {
                          if(error.response.status == 401) {
                            this.store.remove_token()
                            this.store.remove_user()
                            localStorage.removeItem('web_token')
                            localStorage.removeItem('user_token')
                            this.$router.push('/login')
                            
                          }
                        }
                      })
                },

        },

        created(){
   this.GetStore()
        },


        computed: {
          TotalAmount() {
            let caculate = this.ListOrder.reduce((num , item) =>  parseInt(num) + (parseInt(item.order_amount) * parseInt(item.price_sell)) , 0 )

            return caculate
          }
        }
        
    }
</script> 

<style scoped>
/* .ps {
  height: 400px;
} */
.img-pos {
  object-fit: cover;
  width: 100%;
  height: 110px;
  object-position: center;
}
* {
  -webkit-user-select: none;
}
</style>