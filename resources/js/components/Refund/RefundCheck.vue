<template>
<div class="animated fadeIn">
        <b-row class="justify-content-md-center">
            <b-col cols="8">
                <b-card  class="bg-info" v-for="(rule,x_index) in rules" :key="x_index">
                    <div slot="header">
                        <div class="card-header-actions">
                            <b-badge variant="success">Success</b-badge>
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
                                v-else-if="fine_result_type(consider.id) == 'date'"
                                ref="r_date12" :id="'d121'"
                                :showDate="d1" 
                                @update="value => results[find_detail_index(consider.id)]['value'] = value"
                            ></my-date-picker>

                        </consider-check>

                        <!-- <b-card v-for="(sub_rule,y_index) in rule.sub_rules" :key="y_index"
                            :header="'หลักเกณฑ์ย่อย ' + rule.order + '.' + sub_rule.order + ' : ' + sub_rule.name"
                            bg-variant="light">
                                <consider-check
                                    v-for="(consider,index) in sub_rule.considers" :key="index"
                                    :consider = "consider"
                                >

                                    <toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                                        :labels="{checked: 'ใช่', unchecked: 'ไม่ใช่'}"
                                        :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                                        style="padding-top:4px; line-height:0px;"
                                        v-if="consider.type == 1"
                                        v-model="results[find_detail_index(consider.id)]['result']"

                                    />
                                    <b-form-input type="text"
                                        v-else-if="consider.type == 2"
                                        v-model="results[find_detail_index(consider.id)]['result']"
                                    ></b-form-input>
                                    <my-date-picker
                                        v-else-if="consider.type == 3 && consider.oper > 1"
                                        ref="r_date2" :id="'d12'"
                                        :showDate="date_show" @update="value => date_show = value"
                                    ></my-date-picker>
                                </consider-check>
                        </b-card> -->
                        <b-card v-for="(sub_rule) in rule.sub_rules" :key="sub_rule.id"
                            :header="'หลักเกณฑ์ย่อย ' + rule.order + '.' + sub_rule.order + ' : ' + sub_rule.name"
                            bg-variant="light">
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
                                        :showDate="getDateShow(consider.id)" 
                                        @update="value => results[find_detail_index(consider.id)]['value'] = value"
                                    ></my-date-picker>
                                </consider-check>
                        </b-card>
                </b-card>

                <p>{{results}}</p>
                <p>{{date_show}}</p>
                
            </b-col>
        </b-row>

        <b-row>
            <b-col>
                <div class="text-center" style="margin-bottom:5px;">
                    <b-button variant="primary" @click="checkConsider">ตรวจสอบเงื่อนไข</b-button>
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
            d1 : '2019-12-12',
            date_show: []
        }
    },
    watch :{
    },
    mounted() {
        this.getRefundDetail();
        this.fetchData();
    },
    methods: {
        fetchData(){
            var path = `/api/forms/${this.form_id}/form_rules`;
            axios.get(`${path}`)
            .then(response=>{
                this.rules = response.data.data;
            })
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
                return 'xxx';
                var d = new Date(result);
                
                //d.toLocaleDateString('th-TH', { day: 'numeric', month: 'long', year: 'numeric' });
            }else{
                return result;
            }
        },
        getDateShow(consider_id){
            var index = this.date_show.findIndex(i=>i.consider_id == consider_id);
            if (index > -1){
                console.log('date index :' + index);
                return this.date_show[index]['show'];
            }
            console.log('date index :' + index);
        },
        getRefundDetail(){
            var result = {};
            this.refund_details = [];
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${this.refund_form_id}/refund_details`;
            console.log('Get Detail : ' + path);
            axios.get(`${path}`)
            .then(response=>{
                this.refund_details = response.data.data;
                this.results = [];
                this.date_show = [];
                for (let i=0; i < this.refund_details.length; i++){
                    result = {
                        id : this.refund_details[i]['id'],
                        consider_id : this.refund_details[i]['consider_id'],
                        value: this.getResult(this.refund_details[i]['result_type'],this.refund_details[i]['value'])
                    }
                    this.results.push(result);
                    if (this.refund_details[i]['result_type'] == 'date'){
                        this.date_show.push(
                            {
                                id: this.refund_details[i]['id'],
                                consider_id : this.refund_details[i]['consider_id'],
                                show: this.refund_details[i]['value']
                            }
                        );                        
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
        checkConsider(){
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${this.refund_form_id}/refund_details`;
            axios.post(`${path}`,{
                state: 'update',
                detail: this.results
            })
            .then(response=>{

            })
            .catch(error=>{
                console.log('error :' + error + ' save path :' + path);
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
}
.sub_rule.card-header{
    background-color: rgb(90, 135, 141)!important;
}
</style>
