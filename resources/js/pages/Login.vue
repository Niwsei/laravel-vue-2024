<template>
    <div class="d-flex justify-content-center pt-5">
  <div class="authentication-wrapper authentication-basic container-p-y col-md-4 ">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">

          <h4 class="mb-2">ສະບາຍດີ! 👋</h4>
          <p class="mb-4">ຍິນດີຕ້ອນຮັບ , ກາລຸນາເຂົ້າສູ່ລະບົບ</p>
            <div class="mb-3">
              <label for="email" class="form-label">ອີເມລ</label>
              <input type="text" class="form-control" id="email"  placeholder="email"  v-model="email">
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">ລະຫັດຜ່ານ</label>
              </div>
              <div class="input-group input-group-merge">
                <input :type="show_pass" id="password" class="form-control" @keyup.enter="login()" placeholder="············" v-model="password" >
                <span class="input-group-text cursor-pointer"  @click="show_pass == 'password' ? show_pass = 'text' : show_pass = 'password'" >
                    <i class="bx bx-hide" v-if="show_pass == 'password'"></i>
                    <i class="bx bx-show" v-if="show_pass =='text'"></i>
                </span>
              </div>
            </div>
            <div class="mb-3">
            </div>
            <div class="alert alert-danger" role="alert" v-if="check_email_text || check_pass_text || text_error">{{text_error}}{{ check_email_text }} {{ check_pass_text }}</div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" :disabled="check_from_login" @click="login()" >ເຂົ້າສູ່ລະບົບ</button>
            </div>

          <p class="text-center">
            <span>ບໍ່ມີບັນຊີຜູ້ໃຊ້?</span>
            <router-link to="/register">
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
    export default {
        data(){
            return{
               /*  check_from_login: true, */
                email: '',
                password:'',
                check_email_text: '',
                check_pass_text: '',
                show_pass:'password',
                text_error:''
            }
        },

        computed: {
            check_from_login(){
                let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                //ກວດອີເມລ
                if (this.email){
                    if(!emailRegex.test(this.email)){
                        this.check_email_text = 'ອີເມລບໍ່ຖິກຕ້ອງ!'
                    }else{
                        this.check_email_text = '';
                    }
                }
                else {
                    this.check_email_text = '';
                }

                if(this.password){
                    if(this.password.length < 6){
                        this.check_pass_text = 'ລະຫັດຜ່ານ ຕ້ອງຫຼາຍກ່ວາ 5 ຕົວອັກສອນ';
                    }
                    else {
                        this.check_pass_text = '';
                    }
                }
                else {
                    this.check_pass_text = '';
                }


                if(!emailRegex.test(this.email) || this.password.length < 6){
                    return true
                }
                else {
                    return false 
                }
            }
        },
        methods: {
            login(){
                if(this.email != '' && this.password != '') {
                    axios.post('api/login' , {
                               login_email: this.email,
                               login_password: this.password
                                }).then((res) => {
                                    if(res.data.success){
                                        this.email = '';
                                        this.password = '' ;
                                        localStorage.setItem('web_token', res.data.token);
                                        localStorage.setItem('web_user' , JSON.stringify(res.data.user));
                                        this.$router.push('/');
                                    }else {
                                        this.text_error = res.data.message;
                                    }
                                  /*   console.log(res); */
                                }).catch((err) => {
                                    console.log(err);
                                })
                }
            }
        }
        
    }
</script>

<style lang="scss" scoped>

</style>