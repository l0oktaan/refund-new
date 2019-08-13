<template>
    <div class="animated fadeIn">
        <div>
        <my-alert :AlertType="alert"></my-alert>
        <b-form @submit="onSubmit">
            <b-row>
                <b-col>
                    <b-form-group>
                        <label for="name">รายละเอียดเงื่อนไข</label>
                        <b-form-input type="text"
                            placeholder="รายละเอียดเงื่อนไข"
                            name="name"
                            v-model = "consider_name"

                            >
                        </b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col cols="3">
                    <b-form-group label="ปรเภทเงื่อนไข">
                        <b-form-select
                            v-model="consider_type"
                            :options="type_list"
                            name="consider_type"
                        ></b-form-select>
                    </b-form-group>
                </b-col>
                <b-col cols="3" v-if="consider_type==3">
                    <b-form-group label="การตรวจสอบเงื่อนไข">
                        <b-form-select
                            v-model="consider_oper"
                            :options="oper_list"
                            name="consider_oper"
                        ></b-form-select>
                    </b-form-group>
                </b-col>
                <b-col cols="3" v-if="(consider_type==3) && (consider_oper==1)">
                        <b-form-group>
                        <label for="var1">ข้อมูลตรวจสอบ</label>
                        <b-form-input type="text"
                            placeholder="จำนวนวัน"
                            name="var1"
                            v-model = "consider_var1"
                            >
                        </b-form-input>
                    </b-form-group>
                </b-col>
                <b-col cols="3" v-if="(consider_type==3) && (consider_oper==2)">
                    <b-form-group>
                        <label for="date1">ข้อมูลตรวจสอบ</label>
                        <my-date-picker
                            name="date1"
                            @dateSelected="dateSelected"
                        ></my-date-picker>
                    </b-form-group>
                </b-col>
            </b-row>

            <div class="text-center">
                <b-button type="submit" variant="primary">บันทึกเงื่อนไข</b-button>
            </div>
            <consider-cover :considers="consider_list"></consider-cover>
        </b-form>
        </div>
    </div>
</template>
<script>
export default {
    props: ['form_id','rule_id'],
    data(){
        return {
            f_id: 0,
            r_id: 0,
            consider_list : [],
            consider_order: 0,
            consider_name: '',
            consider_type: 0,
            consider_oper: 0,
            consider_var1: '',
            consider_var2: '',
            order_list: ['ลำดับ'],
            type_list: [
                {value: 0, text: 'ประเภทเงื่อนไข'},
                {value: 1, text: 'ใช่หรือไม่'},
                {value: 2, text: 'ใส่ข้อความ'},
                {value: 3, text: 'ตรวจสอบข้อมูล'},
            ],
            oper_list:[
                {value: 0, text: 'ตัวเลือกการตรวจสอบ'},
                {value: 1, text: 'ไม่เกินจำนวนวัน'},
                {value: 2, text: 'ไม่เกินวันที่'},
            ],
            alert: '',
            lang: 'th',
            state: 'new',
            alert: ''
        }
    },
    mounted(){
        this.clearData();
        this.fetchData();
    },
    methods: {
        onSubmit(e){
            e.preventDefault();
            var consider = {};
            var path = `/api/forms/${this.form_id}/form_rules/${this.rule_id}/form_considers`;
            console.log('order: '+ this.consider_order + ' name :' + this.consider_name + ' path: ' + path);
            if(this.state == 'new'){
                axios.post(path,{
                    order: this.consider_order,
                    name: this.consider_name,
                    type: this.consider_type,
                    oper: this.consider_oper,
                    var1: this.consider_var1,
                    var2: this.consider_var2
                })
                .then(response=>{
                    consider = response.data.data;

                    this.state = "update";
                    this.consider_order = consider.order;
                    this.consider_name = consider.name;
                    this.consider_type = consider.type;
                    this.consider_oper = consider.oper;
                    this.consider_var1 = consider.var1;
                    this.consider_var2 = consider.var2;
                    this.alert = "success"
                    this.fetchData();
                })
                .catch(error=>{

                })
            }
        },
        dateSelected(value){
            console.log('date :' + value);
        },
        fetchData(){

            var path = `/api/forms/${this.form_id}/form_rules/${this.rule_id}/form_considers`;
            axios.get(`${path}`)
            .then(response=>{
                this.consider_list = response.data.data;
            })
            .catch(error=>{

            })
        },
        clearData(){
            this.state = "new";
            this.consider_list = [],
            this.consider_order = consider.order;
            this.consider_name = consider.name;
            this.consider_type = consider.type;
            this.consider_oper = consider.oper;
            this.consider_var1 = consider.var1;
            this.consider_var2 = consider.var2;
            this.alert = "";
        }
    }
}
</script>
