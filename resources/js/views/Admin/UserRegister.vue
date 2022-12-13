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
<!-- 
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
                             -->
                            <b-form-group>
                                <label for="time_edit_date">หน่วยงาน<span class="require">*</span></label>
                                <b-input-group>                                 
                                    <b-form-input 
                                        list="my-list-id" 
                                        v-model="user.office"
                                        :required="true"  
                                        :disabled="status=='edit'"                                  
                                    >
                                    </b-form-input>
                                    <b-input-group-append class="btnClear" :disabled="status=='edit'" @click="clear_office">                                    
                                        <b-input-group-text>
                                            <b-icon icon="x" />
                                        </b-input-group-text>
                                    </b-input-group-append>
                                    <datalist id="my-list-id">                                        
                                        <option v-for="item in offices" :value="item.name"></option>
                                    </datalist>                                
                                </b-input-group>
                            </b-form-group>
                            <!-- <b-form-group>



                                <label for="time_edit_date">หน่วยงาน<span class="require">*</span></label>
                                <b-form-input 
                                    list="my-list-id" 
                                    v-model="office_selected"
                                    :required="true"                                    
                                >
                                </b-form-input>
                                <datalist id="my-list-id">
                                    <option value="0" text="หน่วยงาน"></option>
                                    <option v-for="item in offices" :value="item.name"></option>
                                </datalist>
                                {{office_id_selected}}
                            </b-form-group> -->
                            
                            
                            
                            
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
                            
                            <b-form-checkbox
                                id="checkbox-1"
                                v-model="is_sub_office"
                                name="sub_office"
                                :value="true"
                                :unchecked-value="false"
                                class="mb-2"
                            > หน่วยงานในสังกัด <span class="require" v-if="is_sub_office">*</span>
                            </b-form-checkbox>
                            <validation-provider
                                name="หน่วยงานในสังกัด"
                                :rules="{ required: is_sub_office, min: is_sub_office ? 10 : 0 }"
                                v-slot="validationContext"
                            >
                                <b-form-group>                                    
                                    <!-- <label for="time_edit_date"></label> -->
                                        <!-- <b-input-group-prepend><b-input-group-text><i class="icon-key"></i></b-input-group-text></b-input-group-prepend> -->
                                        <b-form-input
                                            :disabled="!is_sub_office"
                                            v-model="user.sub_office_name"
                                            type="text"
                                            name="office_sub_name"
                                            placeholder="หน่วยงานในสังกัด"
                                            :state="getValidationState(validationContext)"
                                            aria-describedby="current-sub_office_name-live-feedback"
                                        />
                                    <b-form-invalid-feedback id="current-sub_office_name-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                                </b-form-group>
                            </validation-provider>
                        </b-col>
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
                                            v-model="user.name"
                                            type="text"
                                            name="name"
                                            placeholder="ชื่อ-นามสกุล"
                                            :state="getValidationState(validationContext)"
                                            aria-describedby="current-name-live-feedback"
                                        />
                                    <b-form-invalid-feedback id="current-name-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
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
                                            :disabled="status=='edit'"
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
                                <b-button variant="success" @click="importUser">User Temp</b-button>
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
        <user-list ref="userList" @userEdit="userEdit" @clearData="clearData"></user-list>
    </div>
</template>

<script>
export default {
    data(){
        return {
            user: {
                name: '',
                position: '',
                username: '',
                office_id: '',
                sub_office_name: '',
                email: '',
                phone: '',
            },
            status: 'new',
            is_sub_office: false,
            alert: '',
            offices: [],
            users: [],
            //passRegex: /^[0-9][A-Z][a-z]+$/,
            passRegex: /^(?:(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*)$/,
            office_selected: null
        }
    },
    async mounted(){
        await this.getOffice();
        await this.getUserAll();
    },
    watch: {
              
            'user.office' : function (newValue,oldValue){                
                if (newValue == oldValue){
                    return;
                }
                this.user.office_id =  newValue ? this.offices.find(x=>x.name == newValue).id : null
            },
            
    },

    methods :{
        async delay (ms) {
            new Promise(resolve => setTimeout(resolve, ms))
        },
  

        
        async makeALoopWait(users) {
            
            for (let i = 0; i < users.length; i += 1) {
                let path2 = await `/api/users`;
                try {
                    await axios.post(`${path2}`,{
                        "order" : users[i].order,
                        "code" : users[i].code,
                        "office_id" : users[i].office_id,
                        "name" : users[i].name,
                        "email" : users[i].email,
                        "position" : users[i].position,
                        "phone" : users[i].phone,
                        "sub_office_name" : users[i].sub_office_name,
                        "type" : "2"
                    });
                    await console.log('count : ' + (i+1));
                    await this.delay(1000)
                    
                } catch (error) {
                    console.log(error);
                }
            }
        },
        async importUser(){
            var path = '/api/user_temp';
            var res = await axios.get(`${path}`);
            var user_temp = await res.data.data;
            // await onsole.log(user_temp.length);

            let path2 = await `/api/users`;
            var count = await 0;

            await this.makeALoopWait(user_temp);
            // const promises = user_temp.map(async (item,index) => {
                
                    
            //         await axios.post(`${path2}`,{
            //                 "order" : item.order,
            //                 "code" : item.code,
            //                 "office_id" : item.office_id,
            //                 "name" : item.name,
            //                 "email" : item.email,
            //                 "position" : item.position,
            //                 "phone" : item.phone,
            //                 "sub_office_name" : '',
            //                 "type" : "2"
            //             });
            //         count = await  this.delay(count);
                        
                        
                    
                    
               
                
                    
                
                
            // });
            // await Promise.all(promises);
            

        },
        clear_office(){
            if (this.status =='edit'){
                return;
            }
            this.user.office = null;
        },
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
        async userEdit(item){
            this.status = await "edit";
            this.user = await item;

            if (this.user.level == '3'){
                this.is_sub_office = true;
            }else{
                this.is_sub_office = false;
            }
            console.log(this.user.sub_office_name)
            
            // this.office_selected = item.office
        },
        async onSubmit(){
            if (this.status == "new"){
                let path = await `/api/users`;
                
                try {
                    let res = await axios.post(`${path}`,{
                        "name" : this.user.name,
                        "email" : this.user.email,
                        "office_id" : this.user.office_id,
                        "sub_office_name" : this.is_sub_office ? this.user.sub_office_name : '',
                        "type" : this.is_sub_office ? "3" : "2",
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
            }else if (this.status == "edit"){
                let path = await `/api/users/${this.user.id}`;
                let res = await axios.put(`${path}`,{
                    "name" : this.user.name,                                        
                    "sub_office_name" : this.is_sub_office ? this.user.sub_office_name : '',
                    "position" : this.user.position,
                    "phone" : this.user.phone
                })
                this.alert = await 'success';
                await this.clearData();
                await this.$refs.observer.reset();
                await this.getUserAll();
            }
        },
        async clearData(){
            this.user = await {};
            this.user = await {
                'name' : '',
                'office_id' :null,
                'sub_office_name' : '',
                'level' : '',
                'position' : '',
                'email' : '',
                'phone' : ''
            },
            this.status = await "new";
            this.is_sub_office = await false;
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
.btnClear{
    cursor: pointer;
}
</style>
