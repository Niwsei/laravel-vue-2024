<template>
<div class="d-flex justify-content-center pt-5">
  <div class="authentication-wrapper authentication-basic container-p-y col-md-4 ">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">

          <h4 class="mb-2">ລົງທະບຽນ ບັນຊີຜູ້ໃຊ້ໃຫມ່</h4>
          <div class="mb-3">
              <label for="name" class="form-label">ຊື່ຜູ້ໃຊ້:</label>
              <input type="text" class="form-control" id="name" placeholder="your username" v-model="username">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">ອີເມລ:</label>
              <input type="text" class="form-control" id="email" placeholder="your email" v-model="email">
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">ລະຫັດຜ່ານ:</label>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control"  placeholder="your password" v-model="password">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>

            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password2">ຢືນຢັນລະຫັດຜ່ານ:</label>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password2" class="form-control"  placeholder="your password" v-model="password2">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>

            <div class="alert alert-danger" role="alert" v-if="text_error">
                {{ text_error }}
            </div>

            <div class="alert alert-warning" role="alert" v-if="password_error">
                {{ password_error }}
            </div>


            <div class="mb-3">
            </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" @click="Register" >ລົງທະບຽນ</button>
            </div>

          <p class="text-center">
            <span>ມີບັນຊີຜູ້ໃຊ້ເເລ້ວ!</span>
            <router-link to="/login">
              <span>ລົງທະບຽນ</span>
            </router-link>
          </p>
        </div>
      </div>
      <!-- /Register -->
    </div>
  </div>
</div>
</template>

<script>
import axios from 'axios';
    export default {
        data() {
            return {
                username: '',
                email: '',
                password: '',
                password2: '',
                text_error: '',
                password_error: '',
            };
        },
        methods: {
            Register(){
                    if(this.username == '' || this.email == '' || this.password == '' || this.password2 == ''){
                        this.text_error = "ກາລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບຖ້ວນ!";
                    }
                    else {
                            if(this.password == this.password2){
                                this.text_error = ''
                                axios.post('api/register' , {
                                    from_user_name:this.username,
                                    from_email:this.email,
                                    from_password:this.password,
                                }).then((res) => {
                                    if(res.data.success){
                                        this.text_error = '';
                                        this.username = '';
                                        this.email = '';
                                        this.password = '' ;
                                        this.password2 = '';
                                        this.$router.push('/login')
                                    }else {
                                        this.text_error = res.data.message;
                                    }
                                    console.log(res);
                                }).catch((err) => {
                                    console.log(err);
                                })
                            }
                            else {
                                this.password_error = 'ລະຫັດຜ່ານບໍ່ຕົງກັນ!'
                            }
                        
                    }
            }
        },
        setup(){

        }
        
    }
</script>

<style lang="scss" scoped>

</style>