<template>
<div class="animated fadeIn">
    <my-alert :AlertType="alert"></my-alert>
        <b-row class="justify-content-md-center">
            <b-col cols="10">
                <b-card class="bg-dark">

                    <b-card  class="bg-info rule" v-for="(rule,x_index) in rules" :key="x_index">
                    <div slot="header">
                        <div class="card-header-actions">
                            <b-badge variant="success"></b-badge>
                        </div>
                        <i class="fas fa-angle-double-right fa-lg"></i><span> หลักเกณฑ์ {{rule.order}} : {{rule.name}}</span>
                    </div>
                        <consider-check
                            v-for="(consider,index) in rule.considers" :key="index"
                            :consider = "consider"
                        >

                            <toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                                :labels="{checked: 'ใช่', unchecked: 'ไม่ใช่'}"
                                :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                                style="padding-top:4px; line-height:0px;"
                                v-if="consider.type == 1"
                                v-model="results[find_detail_index(consider.id)]['value']"
                            />
                            <b-form-input type="text"
                                v-if="fine_result_type(consider.id) == 'number' || fine_result_type(consider.id) == 'value'"
                                v-model="results[find_detail_index(consider.id)]['value']"
                            ></b-form-input>
                            <my-date-picker
                                v-if="fine_result_type(consider.id) == 'date'"
                                :ref="'c_date_' + consider.id" :id="'d121'"
                                :showDate="date_show[date_show.findIndex(i=>i.consider_id==consider.id)]['show']"
                                @update="value => results[find_detail_index(consider.id)]['value'] = value"
                            ></my-date-picker>
                        </consider-check>

                        <b-card v-for="(sub_rule) in rule.sub_rules" :key="sub_rule.id"

                            >
                            <b-card-header>
                                <b-form-checkbox>
                                    <span class="sub_rule">{{'หลักเกณฑ์ย่อย ' + rule.order + '.' + sub_rule.order + ' : ' + sub_rule.name}}</span>
                                </b-form-checkbox>

                            </b-card-header>
                            <consider-check
                                v-for="(consider,index) in sub_rule.considers" :key="index"
                                :consider = "consider"
                            >

                                <toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                                    :labels="{checked: 'ใช่', unchecked: 'ไม่ใช่'}"
                                    :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                                    style="padding-top:4px; line-height:0px;"
                                    v-if="consider.type == 1"
                                    v-model="results[find_detail_index(consider.id)]['value']"
                                />
                                <b-form-input type="text"
                                    v-if="fine_result_type(consider.id) == 'number' || fine_result_type(consider.id) == 'value'"
                                    v-model="results[find_detail_index(consider.id)]['value']"
                                ></b-form-input>
                                <my-date-picker
                                    v-else-if="fine_result_type(consider.id) == 'date'"
                                    ref="r_date1" :id="'d11'"
                                    :showDate="date_show[date_show.findIndex(i=>i.consider_id==consider.id)]['show']"
                                    @update="value => results[find_detail_index(consider.id)]['value'] = value"
                                ></my-date-picker>
                            </consider-check>
                        </b-card>
                </b-card>

                 </b-card>


                <!-- <p>result: {{results}}</p>
                <p>date shoe: {{date_show_temp}}</p>
                <p>date shoe: {{date_show}}</p> -->
                <!-- <p>refund form status :{{refund_form_result}}</p> -->
                <!-- <p>rules :{{rules}}</p> -->
                <!-- <p>result :{{results}}</p>
                <p>rule_result :{{rule_result}}</p> -->

            </b-col>
        </b-row>
        <b-row align-h="center">
            <b-col cols="10">
                <b-alert show variant="danger" v-if="refund_form_result==0" class="text-center">ข้อมูลยังไม่ตรงตามหลักเกณฑ์เงื่อนไข กรุณาตรวจสอบข้อมูล !!!</b-alert>
                <b-alert show variant="success" v-else class="text-center">ข้อมูลตรงตามหลักเกณฑ์เงื่อนไข</b-alert>
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <div class="text-center" style="margin-bottom:5px;">
                    <b-button variant="primary" @click="onSubmit">ตรวจสอบเงื่อนไข</b-button>
                </div>

            </b-col>
        </b-row>

    </div>

</template>
<script>
export default {
    props: ['form_id','refund_id','refund_form_id'],
    data(){
        return {
            office_id: 2,
            rules: [],
            results: [],
            refund_details: [],
            dd1 : '2019-12-03',
            d1 : '',
            date_show: [],
            date_show_temp: [],
            refund_form: {},
            rule_result: [],
            xxx: {},
            refund_form_result: 0,
            alert: ''
        }
    },
    watch :{
        refund_form_result(newVal,oldVal){
            if (newVal == 1){
                this.$emit('refund_update');
            }
        }
    },
    mounted() {
        this.getRefundDetail();
        this.fetchData();
        this.checkRefundFormResult();
        setTimeout( () => {
                    this.check();
                }, 1000);
    },
    methods: {
        checkRefundFormResult(){
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${this.refund_form_id}?result`
            axios.get(`${path}`)
            .then(response=>{
                this.refund_form_result = response.data;
            })
            .catch(error=>{
            })
        },
        fetchData(){
            this.rule_result = [];
            var path = `/api/forms/${this.form_id}/form_rules`;
            axios.get(`${path}`)
            .then(response=>{
                this.rules = response.data.data;
            })
            this.$forceUpdate();
            setTimeout( () => this.showDate(), 1000);
        },
        getResult(type,result){
            console.log(type + " : " + result);
            if (type == 'boolean'){
                if (result == '0'){
                    return false;
                }else if (result == '1'){
                    return true;
                }else{
                    return false
                }
            }else if (type == 'date'){
                console.log("is date : " + result);
                return result;
                var d = new Date(result);
                //d.toLocaleDateString('th-TH', { day: 'numeric', month: 'long', year: 'numeric' });
            }else{
                return result;
            }
        },
        showDate(){
            for (let i=0; i < this.date_show_temp.length; i++){
                this.date_show[i]['show'] = this.date_show_temp[i]['show'];
                this.$forceUpdate();
            }
        },
        getRefundDetail(){
            var result = {};
            this.refund_details = [];
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${this.refund_form_id}/refund_details`;
            console.log('Get Detail : ' + path);
            axios.get(`${path}`)
            .then(response=>{
                //this.refund_form = response.data.data;
                this.refund_details = response.data.data;
                //this.refund_details = []; //this.refund_form.detail;
                //console.log('refund detail :' + this.refund_details.length);
                this.results = [];
                this.date_show_temp = [];
                for (let i=0; i < this.refund_details.length; i++){
                    try {
                        result = {
                        id : this.refund_details[i]['id'],
                        consider_id : this.refund_details[i]['consider_id'],
                        value: this.getResult(this.refund_details[i]['result_type'],this.refund_details[i]['value']),
                        status : this.refund_details[i]['status'],
                    }
                    this.results.push(result);
                    if (this.refund_details[i]['result_type'] == 'date'){
                        this.date_show_temp.push(
                            {
                                id: this.refund_details[i]['id'],
                                consider_id : this.refund_details[i]['consider_id'],
                                show: this.refund_details[i]['value']
                            }
                        );
                        this.date_show.push(
                            {
                                id: this.refund_details[i]['id'],
                                consider_id : this.refund_details[i]['consider_id'],
                                show: ''
                            }
                        );
                    }
                    } catch (error) {
                        console.log('error :' + error);
                    }
                }
                this.$forceUpdate();
            })
            .catch(error=>{
            })
        },
        fine_result_type(consider_id){
            return this.refund_details[this.refund_details.findIndex(i => i.consider_id == consider_id)]['result_type'];
        },
        find_detail_index(id){
            //console.log('Find Consider : ' + id);
            //if (this.refund_details.length > 0){
                return this.results.findIndex(i => i.consider_id == id);
            //}
        },
        getDetailValue(consider_id){
            console.log('Find Consider : ' + consider_id + ' length : ' + this.refund_details.length);
           // if (this.refund_details.length > 0){
                return this.refund_details[this.refund_details.findIndex(i => i.consider_id === consider_id)]['id'];
            //}
        },
        onSubmit(){
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${this.refund_form_id}/refund_details`;
            axios.post(`${path}`,{
                state: 'update',
                detail: this.results
            })
            .then(response=>{
                this.alert = 'success';
                //this.getRefundDetail();
                //this.fetchData();
                setTimeout(()=>{
                    this.check();
                },2000);
            })
            .catch(error=>{
                console.log('error :' + error + ' save path :' + path);
            })
        },
        check(){
            var detail = [];
            var result = [];
            var rule = {};
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${this.refund_form_id}/refund_details`;
            axios.get(`${path}`)
            .then(response=>{
               detail = response.data.data;
               this.rule_result = [];
                for (let index = 0; index < this.rules.length; index++){
                    rule = this.rules[index];
                    if (rule.sub_rules.length > 0){
                        let arr = [];
                        let sub_rules = rule.sub_rules;
                        for (let i=0; i<sub_rules.length; i++){
                            let arr_sub = [];
                            let considers = sub_rules[i]['considers'];
                            for (let j=0; j<considers.length; j++){
                                //console.log('detail  : ' + detail[0]['id']);
                                //arr_sub.push(detail[z]['status']);
                                arr_sub.push(detail[detail.findIndex(x=>x.consider_id==considers[j]['id'])].status);
                            }
                            arr.push((arr_sub.every(r=>r==1)) ? 1 : 0);
                        }
                        if (rule.result_type == 1){
                            result.push((arr.some(r=>r==1)) ? 1 : 0);
                            this.$forceUpdate();
                        }else if (rule.result_type == 2){
                            result.push((arr.every(r=>r==1)) ? 1 : 0);
                            this.$forceUpdate();
                        }
                    }else{
                        let arr = [];
                        let considers = rule.considers;
                        for (let j=0; j<considers.length; j++){
                            arr.push(detail[detail.findIndex(x=>x.consider_id==considers[j]['id'])]['status']);
                        }
                        result.push((arr.every(r=>r==1)) ? 1 : 0);
                        this.$forceUpdate();
                    }
                    console.log('array lenght ' + result.length + ' result :' + result + ' OK :' + result.every(x=>x==1));
                }
                 this.refund_form_result = result.every(x=>x==1) ? 1 : 0;
                this.$forceUpdate();
                var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${this.refund_form_id}`;
                axios.put(`${path}`,{
                    result: this.refund_form_result
                })
                .then(response=>{
                    var tmp = response.data.data;
                    console.log('for result :' + tmp.result);
                    this.$emit('refund_update');
                    this.$forceUpdate();
                })
                .catch(error=>{
                    this.alert = "error";
                })
            })
        }
    }
}
</script>
<style scoped>
.card{
    margin-bottom: 5px!important;
}
.card-body{
    background-color: #ffffff!important;
    padding: 0px!important;
    color: #000!important;
}
.sub_rule{
    margin: 5px;
   border: 0px!important;
   color: #fff;
}
.sub_rule.card-header{
    color: #fff;
}
.rule{
    margin: 10px!important;
}
</style>
