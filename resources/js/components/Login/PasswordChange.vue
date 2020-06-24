<template>
<div>
    <my-alert :AlertType="alert"></my-alert>
    <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <b-col md="6">
          <b-card-group>
            <b-card>
                <div slot="header">
                    <strong>เปลี่ยนรหัสผ่าน</strong>
                </div>
                <validation-observer ref="observer" v-slot="{ passes }">
                <b-form @submit.stop.prevent="passes(onSubmit)">
                    <validation-provider
                            name="รหัสผ่านเดิม"
                            :rules="{ required: true, min: 5 }"
                            v-slot="validationContext"
                            v-if="user_status && user_status == 2"
                        >
                        <b-form-group>
                            <label for="contract_party">รหัสผ่านเดิม : <span class="require">*</span></label>
                            <b-form-input type="text"
                                placeholder="รหัสผ่านเดิม"
                                v-model="current_password"
                                :state="getValidationState(validationContext)"
                                aria-describedby="current-password-live-feedback"
                            >
                            </b-form-input>
                            <b-form-invalid-feedback id="current-password-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                        </b-form-group>
                        </validation-provider>
                        <validation-provider
                                name="รหัสผ่านใหม่"
                                :rules="{ required: true, min: 5 }"
                                v-slot="validationContext"
                            >
                            <b-form-group>
                                <label for="contract_no">รหัสผ่านใหม่ :<span class="require">*</span></label>
                                <b-form-input type="text"
                                    placeholder="รหัสผ่านใหม่"
                                    name="new_password"
                                    v-model="new_password"
                                    :state="getValidationState(validationContext)"
                                    aria-describedby="new-password-live-feedback"
                                >
                                </b-form-input>
                                <b-form-invalid-feedback id="new-password-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                        <validation-provider
                                name="ยืนยันรหัสผ่าน"
                                :rules="{ required: true, min: 5 }"
                                v-slot="validationContext"
                            >
                            <b-form-group>
                                <label for="contract_no">ยืนยันรหัสผ่าน :<span class="require">*</span></label>
                                <b-form-input type="text"
                                    placeholder="ยืนยันรหัสผ่านอีกครั้ง"
                                    name="confirm_password"
                                    v-model="confirm_password"
                                    :state="getValidationState(validationContext)"
                                    aria-describedby="confirm-password-live-feedback"
                                >
                                </b-form-input>
                                <b-form-invalid-feedback id="confirm-password-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>

                    <div class="text-center">
                        <b-button type="submit" variant="primary">บันทึกข้อมูล</b-button>
                    </div>
                </b-form>
                </validation-observer>
            </b-card>
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
            user_status: ''
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
                new_passwor: this.new_password
            })
            .then(response=>{
                console.log('response :' + response.data);
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
        }
    }
}
</script>

<style>

</style>
