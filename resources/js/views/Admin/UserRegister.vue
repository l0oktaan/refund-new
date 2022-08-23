<template>
    <div class="content">
        <my-alert :AlertType="alert"></my-alert>
        <div class="form">
            <validation-observer ref="observer" v-slot="{ passes }">
                <b-form @submit.stop.prevent="passes(onSubmit)">
                    <b-row>
                        <b-col>
                            <p class="h4 text-center mb-4">บันทึกข้อมูลผู้ใช้ระบบ</p>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col>
                            <validation-provider
                                name="หน่วยงาน"
                                :rules="{ required: true }"
                                v-slot="validationContext"
                            >
                                <b-form-group>
                                    <label for="time_edit_date">หน่วยงาน<span class="require">*</span></label>
                                        <b-form-select
                                            v-model="user.office_id"
                                            :options="offices"
                                            text-field="name"
                                            value-field="id"                                        
                                            name="office"
                                            :state="getValidationState(validationContext)"
                                            aria-describedby="current-office-live-feedback"
                                        />
                                    <b-form-invalid-feedback id="current-office-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                        <!-- <b-col>
                            <b-form-select
                                            v-model="user.office_id"
                                            :options="offices"
                                            
                                            name="office"
                                        ></b-form-select>
                                <b-form-group>
                                    <label for="time_edit_date">หน่วยงาน<span class="require">*</span></label>
                                        
                                </b-form-group>
                        </b-col> -->
                    </b-row>
                    <b-row>
                        <b-col>
                            <validation-provider
                                name="ชื่อ-นามสกุล"
                                :rules="{ required: true, min: 5 }"
                                v-slot="validationContext"
                            >
                                <b-form-group>
                                    <label for="time_edit_date">ชื่อ-นามสกุล <span class="require">*</span></label>
                                        <!-- <b-input-group-prepend><b-input-group-text><i class="icon-key"></i></b-input-group-text></b-input-group-prepend> -->
                                        <b-form-input
                                            v-model="user.fullname"
                                            type="text"
                                            name="fullname"
                                            placeholder="ชื่อ-นามสกุล"
                                            :state="getValidationState(validationContext)"
                                            aria-describedby="current-fullname-live-feedback"
                                        />
                                    <b-form-invalid-feedback id="current-fullname-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col>
                            <validation-provider
                                name="ตำแหน่ง"
                                :rules="{ required: true, min: 5 }"
                                v-slot="validationContext"
                            >
                                <b-form-group>
                                    <label for="time_edit_date">ตำแหน่ง <span class="require">*</span></label>
                                        <!-- <b-input-group-prepend><b-input-group-text><i class="icon-key"></i></b-input-group-text></b-input-group-prepend> -->
                                        <b-form-input
                                            v-model="user.position"
                                            type="text"
                                            name="position"
                                            placeholder="ตำแหน่ง"
                                            :state="getValidationState(validationContext)"
                                            aria-describedby="current-position-live-feedback"
                                        />
                                    <b-form-invalid-feedback id="current-position-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                    </b-row>
                    <b-row >
                        <b-col>
                            <validation-provider
                                name="email"
                                :rules="{required:true,email:true}"
                                v-slot="validationContext"
                            >
                                <b-form-group>
                                    <label for="time_edit_date">email <span class="require">*</span></label>
                                        <b-form-input
                                            v-model="user.email"
                                            type="email"
                                            name="email"
                                            placeholder="email"
                                            :state="getValidationState(validationContext)"
                                            aria-describedby="confirm-email-live-feedback"
                                        />
                                    <b-form-invalid-feedback id="confirm-email-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col>
                            <validation-provider
                                name="หมายเลขโทรศัพท์"
                                :rules="{ required: true, min: 5 }"
                                v-slot="validationContext"
                            >
                                <b-form-group>
                                    <label for="time_edit_date">หมายเลขโทรศัพท์ <span class="require">*</span></label>
                                        <!-- <b-input-group-prepend><b-input-group-text><i class="icon-key"></i></b-input-group-text></b-input-group-prepend> -->
                                        <b-form-input
                                            v-model="user.phone"
                                            type="text"
                                            name="phone"
                                            placeholder="หมายเลขโทรศัพท์"
                                            :state="getValidationState(validationContext)"
                                            aria-describedby="current-phone-live-feedback"
                                        />
                                    <b-form-invalid-feedback id="current-phone-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col>
                            <div class="text-center">
                                <b-button type="submit" variant="primary">บันทึกข้อมูล</b-button>
                                
                                <b-button variant="danger" @click="onCancel">ล้างข้อมูล</b-button>
                            </div>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col>                        
                            <!-- <b-alert variant="success" show class="alertBox">
                                     <b>เงื่อนไขในการบันทึกข้อมูลผู้ใช้</b>
                                     <li>ความยาวไม่น้อยกว่า 8 ตัวอักษร</li>
                                     <li>แต่ไม่เกิน 16 ตัวอักษร</li>
                                     <li>มีตัวอักษรภาษาอังกฤษพิมพ์ใหญ่ (A-Z) อย่างน้อย 1 ตัวอักษร</li>
                                     <li>มีตัวอักษรภาษาอังกฤษพิมพ์เล็ก (a-z) อย่างน้อย 1 ตัวอักษร</li>
                                     <li>มีตัวเลข (1-9) อย่างน้อย 1 ตัวอักษร</li>
                            </b-alert> -->
                        </b-col>
                    </b-row>
                </b-form>
                </validation-observer>
        </div>
        <user-list ref="userList"></user-list>
    </div>
</template>

<script>
export default {
    data(){
        return {
            user: {
                fullname: '',
                position: '',
                username: '',
                office_id: '',
                email: '',
                phone: '',
            },
            
            alert: '',
            offices: [],
            users: [],
            //passRegex: /^[0-9][A-Z][a-z]+$/,
            passRegex: /^(?:(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*)$/
        }
    },
    async mounted(){
        await this.getOffice();
        await this.getUserAll();
    },
    methods :{
        getValidationState({ dirty, validated, valid = null }) {
            return dirty || validated ? valid : null;
        },
        createUser(){
            try {
                let path = '/api/create_users';
                axios.get(path)
                .then(response=>{
                    this.users = response.data;
                })
            } catch (error) {
                console.log(error);
            }
        },
        async getOffice(){
            console.log('get office');
            let path = await '/api/offices';
            let response = await axios.get(path);
            this.offices = response.data.data;
            // let arr = response.data.data;
            // for (let i=0;i<arr.length;i++){
            //     this.offices.push(
            //         {value: arr[i].id, text:arr[i].name}
            //     )
            // }
        },
        async getUserAll(){
            this.$refs.userList.fetchData();
        },
        async onSubmit(){
            let path = await `/api/users`;
            
            try {
                let res = await axios.post(`${path}`,{
                    "name" : this.user.fullname,
                    "email" : this.user.email,
                    "office_id" : this.user.office_id,
                    "position" : this.user.position,
                    "phone" : this.user.phone
                })
                this.alert = await 'success';
                await this.clearData();
                await this.$refs.observer.reset();
                await this.getUserAll();
            } catch (error) {
                console.log(error);
                this.alert = await 'error';
            }
        },
        async clearData(){
            this.user = await {};
            this.user = await {
                'name' : '',
                'office_id' :null,
                'position' : '',
                'email' : '',
                'phone' : ''
            },
            await this.$refs.observer.reset();
        },
        async onCancel(){
            await this.clearData();
            await this.$refs.observer.reset();
        }
    }
}
</script>

<style scoped>
.content{
    width: 100%;
    display: flex;
    justify-content: right;
    align-items: flex-start;
    flex-direction: column;
}
.form{
    display: block;
    width: 550px;
    align-self: center;
}
.col_name{
    text-align: right;
}
.row{
    margin-top: 5px;
}
</style>
