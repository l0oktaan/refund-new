<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <b-col md="8">
        <b-form @submit.stop.prevent="onSubmit">
          <b-card-group>
            <b-card no-body class="text-white bg-primary py-5 d-md-down-none" style="width:44%">
              <b-card-body class="text-center">

                <div class="text-center">
                    <div class="logo"></div>
                    <!-- <b-img center src="/images/cgd_white.png" fluid alt="Responsive image"></b-img> -->
                    <h4 class="mt-4">ระบบถอนคืนเงินรายได้แผ่นดิน</h4>
                </div>
              </b-card-body>
            </b-card>
            <b-card no-body class="p-4">
              <b-card-body class="txt">
                  <b-row>
                      <b-col>
                          <p class="h4 text-center mb-4">เข้าสู่ระบบ</p>
                      </b-col>
                  </b-row>
                <b-row>
                    <b-col>
                        <p class="text-muted txt">ใส่ชื่อผู้ใช้งานระบบ</p>
                        <b-input-group class="mb-3">
                            <b-input-group-prepend><b-input-group-text><i class="icon-user"></i></b-input-group-text></b-input-group-prepend>
                            <b-form-input :disabled="waiting" maxlength="15" ref="username" v-model="username" type="text" class="form-control" placeholder="รหัสผู้ใช้งาน" autocomplete="username" @keyup.enter="onEnter" />
                        </b-input-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col>
                        <p class="text-muted txt">ใส่รหัสผ่าน</p>
                        <b-input-group class="mb-3">
                            <b-input-group-prepend><b-input-group-text><i class="icon-lock"></i></b-input-group-text></b-input-group-prepend>
                            <b-form-input :disabled="waiting" maxlength="12" ref="password" v-model="password" type="password" class="form-control" placeholder="รหัสผ่าน"  @keyup.enter="onEnter" />
                        </b-input-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col cols="3"></b-col>
                    <b-col cols="6" class="text-center align-bottom mb-2">
                        <b-button block variant="primary" @click="login">
                            <b-icon icon="arrow-clockwise" animation="spin" font-scale="1" v-if="waiting" variant="warning"></b-icon><span v-if="!waiting">เข้าสู่ระบบ</span></b-button>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col>
                        <div class="alert">
                            <b-alert
                                variant="danger"
                                dismissible
                                fade
                                :show="dismissCountDown"
                                @dismiss-count-down="countDownChanged"
                            >
                                {{alertMessage}}
                            </b-alert>
                        </div>
                    </b-col>
                </b-row>
                <b-row>
                      <b-col>
                          <p class="text-right forgot"><b-link @click="forgot">ลืมรหัสผ่าน <b-icon icon="exclamation-circle-fill" variant="danger"></b-icon></b-link></p>
                      </b-col>
                  </b-row>
              </b-card-body>
            </b-card>
          </b-card-group>
        </b-form>
        </b-col>
      </b-row>
    </div>
  </div>

</template>
<script>
export default {
    data(){
        return {
            state: 'username',
            showAlert: false,
            alertMessage: '',
            dismissSecs: 5,
            dismissCountDown: 0,
            username: '',
            password: '',
            waiting: false
        }
    },
    created(){
        // this.$store.dispatch('checkLogin');
    },
    watch: {
        username(){

        }
    },
    computed: {
        isValid(){
            if (this.username != '' && this.password != ''){
                return true;
            }else{
                this.dismissCountDown = this.dismissSecs
                this.alertMessage = 'กรุณาใส่ชื่อผู้ใช้ หรือรหัสผ่าน!!!'
                return false;
            }
        }
    },
    methods: {
        forgot(){
            this.$router.push('/forgot');
        },
        onEnter(){
            if (this.isValid){
                this.login();
            }else{
                return;
            }
        },
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
        login(){
            if (!this.isValid){
                if (this.username == ''){
                    this.$refs.username.focus();
                }else if (this.password == ''){
                    this.$refs.password.focus();
                }

                return;
            }
            this.waiting = true;
            this.$store.dispatch('login',{
                username : this.username,
                password : this.password
            })
            .then(() => {

                if (this.$store.getters.user.status == 1){
                    this.$router.push('/passchange')
                }
            })
            .catch(error=>{
                this.waiting = false;
                this.dismissCountDown = this.dismissSecs
                this.alertMessage = 'ชื่อหรือรหัสผ่านไม่ถูกต้อง!!!'

            })

            // await console.log('user :' + this.$store.getters.user_type)
            // if (this.$store.getters.user_type == 'admin'){
            //     await this.$router.push('/admin')
            // }else if (this.$store.getters.user_type == 'user'){
            //     await this.$router.push('/refund')
            // }


            // var path = '/api/login';
            // axios.post(path,{
            //     username: this.username,
            //     password: this.password
            // })
            // .then(response=>{
            //     var user = response.data.data;
            //     var success = response.data.success;
            //     console.log(success);
            //     if (user.type == "admin"){
            //         this.$store.commit('SET_USER','admin')
            //         this.$router.push('/admin')
            //     }else{
            //          //this.$store.commit('SET_USER',user.username) ;
            //         this.$router.push('/refund')
            //     }
            //     console.log('state :' + this.$store.state.user)
            //     // path = '/api/profile';
            //     // axios.get(path)
            //     // .then(response=>{
            //     //     console.log('Get Auth :' + response.data);
            //     // })
            //     // .catch(error=>{

            //     // })
            //     // console.log('Success');
            // })
            // .catch(error=>{
            //     console.log(error);
            // })
        }

    }
}
</script>

<style scoped>
img{
    max-width: 150px;
    margin-bottom: 15px!important;
}
.alertBox{
    margin-top: 15px;
}
.txt{
    margin-bottom: 5px;
    padding-bottom: 0px!important;
}
.alert{
    min-height: 50px;
}
.logo{
    margin: auto;
    width: 150px;
    height: 173px;
    background-image: url('/images/cgd_white.png');
}
.forgot{
    margin-bottom: 0!important;
    color: rgb(173, 35, 0);
}
.forgot>a{
    margin-bottom: 0!important;
    color: rgb(173, 35, 0);
}
</style>
