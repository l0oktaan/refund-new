<template>
<div class="animated fadeIn">
        <b-row>
            <b-col sm="12">
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
                                v-model="results[find_detail_index(consider.id)]['result']"
                            />
                            <b-form-input type="text"
                                v-else-if="consider.type == 2"
                                v-model="results[find_detail_index(consider.id)]['result']"
                            ></b-form-input>
                            <my-date-picker
                                v-else-if="consider.type == 3 && consider.oper > 1"
                                ref="r_date" :id="'d11'"
                                :showDate="date_show" @update="value => results[find_detail_index(consider.id)]['result'] = value"
                            ></my-date-picker>

                        </consider-check>

                        <b-card v-for="(sub_rule,y_index) in rule.sub_rules" :key="y_index"
                            :header="'หลักเกณฑ์ย่อย ' + rule.order + '.' + sub_rule.order + ' : ' + sub_rule.name"
                            bg-variant="light">
                                <consider-check
                                    v-for="(consider,y_index) in sub_rule.considers" :key="y_index"
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
                                        ref="r_date" :id="'d11'"
                                        :showDate="date_show" @update="value => date_show = value"
                                    ></my-date-picker>
                                </consider-check>
                        </b-card>
                </b-card>

                {{refund_details}}
                <p>{{results}}</p>
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
            date_show: ''
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
        getSubRule(){
            var path = '';
            var id = 0;
            var sub_rule = [];
            this.showRule =[];

            console.log('get sub rule' + this.rules.length);
            for (let i = 0 ; i < this.rules.length ; i++){
                id = this.rules[i].id;
                path = `/api/forms/${this.form_id}/form_rules?sub_of=${id}`;
                console.log('get sub rule path :' + path);
                Object.assign(this.rules[i],{sub_rules: sub_rule});
                axios.get(path)
                .then(response=>{
                    sub_rule = response.data.data;
                    console.log('sub rule ' + id + ': ' + sub_rule.length);

                    if (sub_rule.length > 0){
                        //Object.assign(this.rules[i],{_showDetails: true});
                        Object.assign(this.rules[i],{sub_rules: sub_rule});
                        //return sub_rule;
                    }
                    this.showRule = this.rules;
                    this.$forceUpdate();
                })
                .catch(error=>{

                })
            }

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
            }else{
                return result;
            }
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
                for (let i=0; i < this.refund_details.length; i++){
                    result = {
                        id : this.refund_details[i]['id'],
                        consider_id : this.refund_details[i]['consider_id'],
                        result : this.getResult(this.refund_details[i]['result_type'],this.refund_details[i]['value'])
                    }
                    this.results.push(result);
                }

                this.$forceUpdate();
            })
            .catch(error=>{

            })

        },
        fine_detail(consider){

        },

        find_detail_index(id){
            //console.log('Find Consider : ' + id);
            //if (this.refund_details.length > 0){
                return this.results.findIndex(i => i.consider_id === id);
            //}
        },
        getDetailValue(consider_id){
            console.log('Find Consider : ' + consider_id + ' length : ' + this.refund_details.length);
           // if (this.refund_details.length > 0){
                return this.refund_details[this.refund_details.findIndex(i => i.consider_id === consider_id)]['id'];
            //}

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
