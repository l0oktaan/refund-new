<template>
<div>
    <my-alert :AlertType="alert"></my-alert>
    <div class="app flex-row align-items-center">
    <div class="container">
        <b-row class="justify-content-center">
        <b-col md="8">
          <b-card-group>
            <b-card no-body class="text-white bg-primary py-5 d-md-down-none" style="width:44%">
              <b-card-body class="text-center">
                <div class="text-center">
                    <div class="logo"></div>
                    <!-- <b-img center src="/images/cgd_white.png" fluid alt="Responsive image"></b-img> -->
                    <h4>ระบบถอนคืนเงินรายได้แผ่นดิน</h4>
                </div>
              </b-card-body>
            </b-card>
            <b-card>



                <validation-observer ref="observer" v-slot="{ passes }">
                <b-form @submit.stop.prevent="passes(onSubmit)">
                    <b-row>
                        <b-col>
                            <p class="h4 text-center mb-4">ลืมรหัสผ่าน</p>
                        </b-col>
                    </b-row>

                    <b-row>
                        <b-col>

                            <validation-provider
                                name="email"
                                :rules="{required:true,email:true}"

                                v-slot="validationContext"

                            >
                                <b-form-group>
                                    <label for="time_edit_date">กรอกอีเมล์ที่ลงทะเบียนไว้เพื่อรับวิธีเปลี่ยนรหัสผ่าน <span class="require">*</span></label>

                                        <b-form-input
                                            v-model="email"
                                            type="email"
                                            name="email"
                                            placeholder="ระบุอีเมล์"
                                            :state="getValidationState(validationContext)"
                                            aria-describedby="confirm-email-live-feedback"
                                            :disabled="waiting"
                                        />
                                    <b-form-invalid-feedback id="confirm-email-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col cols="2"></b-col>
                        <b-col cols="4">
                            <b-button type="submit" variant="primary" block>
                                <b-icon icon="arrow-clockwise" animation="spin" font-scale="1" v-if="waiting" variant="warning"></b-icon>
                                <span v-if="!waiting">ดำเนินการ</span>
                            </b-button>
                        </b-col>
                        <b-col cols="4">
                            <b-button type="reset" variant="danger" @click="onCancel" block>ยกเลิก</b-button>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col>
                            <b-alert variant="success" show class="alertBox">
                                     <span>ระบบจะส่งวิธีการยกเลิกรหัสผ่านไปที่อีเมล์ที่ลงทะเบียนไว้เท่านั้น</span>
                            </b-alert>
                        </b-col>
                    </b-row>
                </b-form>
                </validation-observer>
            </b-card>
          </b-card-group>
        </b-col>
      </b-row>
      <b-row class="justify-content-center">
        <b-col md="6">
          <b-card-group>

          </b-card-group>
        </b-col>
      </b-row>
    </div>
  </div>

</div>
</template>

<script>
export default {
    data(){
        return {
            email: '',
            current_password: '',
            new_password: '',
            confirm_password: '',
            alert: '',
            user_status: '',
            //passRegex: /^[0-9][A-Z][a-z]+$/,
            passRegex: /^(?:(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*)$/,
            waiting: false
        }
    },
    mounted(){
        // this.user_status = this.$store.getters.user.status;
    },
    methods: {
        getValidationState({ dirty, validated, valid = null }) {
            return dirty || validated ? valid : null;
        },
        onSubmit(){
            let path = `/api/auth/reset-password`;
            this.waiting=true;
            axios.post(`${path}`,{
                email: this.email
            })
            .then(response=>{

                if (response.data.message == 'OK'){
                    this.alert = 'sendemail';
                    setTimeout(() => {
                        this.$store.dispatch('logout');
                        this.$router.push('/login');
                    }, 5000);
                }else{
                    this.alert = "emailfail";
                    this.waiting=false;
                }
            })
            .catch(error=>{
                this.waiting=false;
                console.log(error);
                this.alert = 'error';
            })
        },
        onCancel(){
            this.$router.push('/');
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
.logo{
    margin: auto;
    width: 150px;
    height: 173px;
    background-image: url('/images/cgd_white.png');
}
</style>
