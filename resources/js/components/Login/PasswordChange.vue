<template>
<div>
    <my-alert :AlertType="alert"></my-alert>
    <div class="app flex-row align-items-center">
    <div class="container">
        <b-row class="justify-content-center">
        <b-col md="9">
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
                            <p class="h4 text-center mb-4">เปลี่ยนรหัสผ่าน</p>
                        </b-col>
                    </b-row>
                    <b-row v-if="user_status == 2">
                        <b-col>
                            <validation-provider
                                name="รหัสผ่านเดิม"
                                :rules="{ required: true, min: 5 }"
                                v-slot="validationContext"
                                v-if="user_status && user_status == 2"
                            >
                                <b-form-group>
                                    <label for="time_edit_date">รหัสผ่านเดิม <span class="require">*</span></label>
                                        <!-- <b-input-group-prepend><b-input-group-text><i class="icon-key"></i></b-input-group-text></b-input-group-prepend> -->
                                        <b-form-input
                                            v-model="current_password"
                                            type="password"
                                            name="current-password"
                                            placeholder="รหัสผ่านเดิม"
                                            :state="getValidationState(validationContext)"
                                            aria-describedby="current-password-live-feedback"
                                        />
                                    <b-form-invalid-feedback id="current-password-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                    </b-row>
                   <b-row>
                        <b-col>
                            <validation-provider
                                name="รหัสผ่านใหม่"
                                :rules="{ regex: passRegex,required:true,min:8,max:16 }"
                                v-slot="validationContext"
                                pattern="yes"

                            >
                                <b-form-group>
                                    <label for="time_edit_date">รหัสผ่านใหม่ <span class="require">*</span></label>
                                        <!-- <b-input-group-prepend><b-input-group-text><i class="icon-key"></i></b-input-group-text></b-input-group-prepend> -->
                                        <b-form-input
                                            v-model="new_password"
                                            type="password"
                                            name="new_password"
                                            placeholder="รหัสผ่านใหม่"
                                            :state="getValidationState(validationContext)"
                                            aria-describedby="new-password-live-feedback"
                                            
                                        />
                                    <b-form-invalid-feedback id="new-password-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col>
                            <!-- rules="required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,16}/|confirmed:รหัสผ่านใหม่" -->
                            <validation-provider
                                name="ยืนยันรหัสผ่าน"
                                :rules="{regex: passRegex,required:true,min:8,max:16,confirmed:'รหัสผ่านใหม่'}"
                                
                                v-slot="validationContext"
                                pattern="yes"
                            >
                                <b-form-group>
                                    <label for="time_edit_date">ยืนยันรหัสผ่าน <span class="require">*</span></label>
                                        <!-- <b-input-group-prepend><b-input-group-text><i class="icon-key"></i></b-input-group-text></b-input-group-prepend> -->
                                        <b-form-input
                                            v-model="confirm_password"
                                            type="password"
                                            name="confirm_password"
                                            placeholder="ยืนยันรหัสผ่าน"
                                            :state="getValidationState(validationContext)"
                                            aria-describedby="confirm-password-live-feedback"
                                        />
                                    <b-form-invalid-feedback id="confirm-password-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col>
                            <div class="text-center">
                                <b-button type="submit" variant="primary">บันทึกข้อมูล</b-button>
                                <b-button v-if="user_status > 1" type="reset" variant="danger" @click="onCancel">ยกเลิก</b-button>
                            </div>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col>
                            <b-alert variant="success" show class="alertBox">
                                
                                     <b>เงื่อนไขในการตั้งรหัสผ่าน</b>
                                     <li>ความยาวไม่น้อยกว่า 8 ตัวอักษร</li>
                                     <li>แต่ไม่เกิน 16 ตัวอักษร</li>
                                     <li>มีตัวอักษรภาษาอังกฤษพิมพ์ใหญ่ (A-Z) อย่างน้อย 1 ตัวอักษร</li>
                                     <li>มีตัวอักษรภาษาอังกฤษพิมพ์เล็ก (a-z) อย่างน้อย 1 ตัวอักษร</li>
                                     <li>มีตัวเลข (1-9) อย่างน้อย 1 ตัวอักษร</li>
                                
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
            current_password: '',
            new_password: '',
            confirm_password: '',
            alert: '',
            user_status: '',
            //passRegex: /^[0-9][A-Z][a-z]+$/,
            passRegex: /^(?:(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*)$/
        }
    },
    mounted(){
        this.user_status = this.$store.getters.user.status;
    },
    methods: {
        getValidationState({ dirty, validated, valid = null }) {
            return dirty || validated ? valid : null;
        },
        onSubmit(){
            let path = `/api/change_password`;
            axios.post(`${path}`,{
                username: this.$store.getters.username,
                new_password: this.new_password
            })
            .then(response=>{

                if (response.data = 'ok'){
                    this.alert = 'success';
                    setTimeout(() => {
                        this.$store.dispatch('logout');
                        this.$router.push('/login');
                    }, 2000);
                }
            })
            .catch(error=>{
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
