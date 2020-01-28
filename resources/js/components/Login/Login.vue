<template>

  <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <b-col md="8">
          <b-card-group>
            <b-card no-body class="text-white bg-primary py-5 d-md-down-none" style="width:44%">
              <b-card-body class="text-center">
                <div>
                    <b-img center src="/images/cgd_white.png" fluid alt="Responsive image"></b-img>
                    <h4>ระบบถอนคืนเงินรายได้แผ่นดิน</h4>
                </div>
              </b-card-body>
            </b-card>
            <b-card no-body class="p-4">
              <b-card-body >
                <div class="animated fadeIn">
                <b-form>
                    <b-row>
                        <b-col>
                            <p class="text-muted">ใส่รหัสผู้ใช้งานระบบ</p>
                            <b-input-group class="mb-3">
                                <b-input-group-prepend><b-input-group-text><i class="icon-user"></i></b-input-group-text></b-input-group-prepend>
                                <b-form-input v-model="username" type="text" class="form-control" placeholder="รหัสผู้ใช้งาน" autocomplete="username email" />
                            </b-input-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col>
                            <p class="text-muted">ใส่รหัสผ่าน</p>
                            <b-input-group class="mb-3">
                                <b-input-group-prepend><b-input-group-text><i class="icon-lock"></i></b-input-group-text></b-input-group-prepend>
                                <b-form-input v-model="password" type="password" class="form-control" placeholder="รหัสผ่าน" />
                            </b-input-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col class="text-center align-bottom">
                            <b-button variant="primary" @click="login">เข้าสู่ระบบ</b-button>
                        </b-col>
                    </b-row>

                </b-form>
                </div>

              </b-card-body>
            </b-card>
          </b-card-group>
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
            dismissSecs: 3,
            dismissCountDown: 0,
            username: 'admin',
            password: 'secret'
        }
    },
    methods: {
        checkUser(){
            this.state = 'password';

            this.dismissCountDown = this.dismissSecs
            this.alertMessage = 'ไม่พบชื่อผู้ใช้ระบบ!!!'
            this.$emit("authenticated", true);
        },
        checkPassword(){
            this.state = 'username';

            this.dismissCountDown = this.dismissSecs
            this.alertMessage = 'รหัสผ่านไม่ถูกต้อง!!!'
            this.$emit("authenticated", true);
            this.$router.push('/refund');
        },
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
        login(){
            var path = '/api/login';
            axios.post(path,{
                username: this.username,
                password: this.password
            })
            .then(response=>{
                var user = response.data.data;
                var success = response.data.success;
                console.log(success);
                if (user.type == "admin"){
                    this.$store.commit('SET_USER','admin')
                    this.$router.push('/admin')
                }else{
                     //this.$store.commit('SET_USER',user.username) ;
                    this.$router.push('/refund')
                }
                console.log('state :' + this.$store.state.user)
                // path = '/api/profile';
                // axios.get(path)
                // .then(response=>{
                //     console.log('Get Auth :' + response.data);
                // })
                // .catch(error=>{

                // })
                // console.log('Success');
            })
            .catch(error=>{
                console.log(error);
            })
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
</style>
