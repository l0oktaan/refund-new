<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
        <b-form  @submit="onSubmit">
            <b-row>
                <b-col>
                    <p>{{rule}}</p>
                    <p>{{results}}</p>
                    <p>{{arr_detail}}</p>
                    <!-- <p>{{result_tmp}}</p> -->
                    <!-- <p>{{rule_select}}</p> -->
                    <b-card bg-variant="primary" text-variant="white" class="p-1 pl-2">
                        <span>หลักเกณฑ์ {{rule.order}} : {{rule.name}}</span>
                    </b-card>


                    <consider-check
                        v-for="(consider,index) in rule.considers" :key="index"
                        :consider = "consider"
                    >
                        <div v-if="results">
                            <toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'boolean'"
                                :labels="{checked: 'ใช่', unchecked: 'ไม่ใช่'}"
                                :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                                style="padding-top:4px; line-height:0px;"
                                v-model="results[findResultIndex(consider.id)]['value']"
                            />
                            <b-form-input type="text"
                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'value'"
                                v-model="results[findResultIndex(consider.id)]['value']"
                            ></b-form-input>
                            <my-date-picker
                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'date'"
                                :id="consider.id"
                                :showDate="result_show[findResultIndex(consider.id)]['value']"
                                @update="value => results[findResultIndex(consider.id)]['value'] = value"
                            ></my-date-picker>
                        </div>
                    </consider-check>
                    <b-form-radio-group id="radio-group-1" v-model="rule_select" name="sub_rule" v-if="(rule && rule.sub_rules.length > 1)">

                        <b-card v-for="(sub_rule,i_index) in rule.sub_rules" :key="i_index">
                            <b-form-radio :value="sub_rule.id" >
                                <span>{{'หลักเกณฑ์ย่อย ' + rule.order + '.' + sub_rule.order + ' : ' + sub_rule.name}}</span>
                            </b-form-radio>

                            <consider-check
                                v-for="(consider,index) in sub_rule.considers" :key="index"
                                :consider = "consider"
                            >

                                <div v-if="results">
                                    <b-form>
                                        <b-form-group :disabled="!(rule_select == sub_rule.id)">
                                            <toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'boolean'"
                                                :labels="{checked: 'ใช่', unchecked: 'ไม่ใช่'}"
                                                :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                                                style="padding-top:4px; line-height:0px;"
                                                v-model="results[findResultIndex(consider.id)]['value']"
                                            />
                                            <b-form-input type="text"
                                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'value'"
                                                v-model="results[findResultIndex(consider.id)]['value']"
                                            ></b-form-input>
                                            <my-date-picker
                                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'date'"
                                                :id="consider.id"
                                                :showDate="result_show[findResultIndex(consider.id)]['value']"
                                                @update="value => results[findResultIndex(consider.id)]['value'] = value"
                                            ></my-date-picker>
                                        </b-form-group>
                                    </b-form>

                                </div>
                            </consider-check>
                        </b-card>
                    </b-form-radio-group>
                    <div v-else>
                        <b-card v-for="(sub_rule,i_index) in rule.sub_rules" :key="i_index">

                            <span>{{'หลักเกณฑ์ย่อย ' + rule.order + '.' + sub_rule.order + ' : ' + sub_rule.name}}</span>


                            <consider-check
                                v-for="(consider,index) in sub_rule.considers" :key="index"
                                :consider = "consider"
                            >

                                <div v-if="results">
                                    <toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                                        v-if="results[findResultIndex(consider.id)]['result_type'] == 'boolean'"
                                        :labels="{checked: 'ใช่', unchecked: 'ไม่ใช่'}"
                                        :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                                        style="padding-top:4px; line-height:0px;"
                                        v-model="results[findResultIndex(consider.id)]['value']"
                                    />
                                    <b-form-input type="text"
                                        v-if="results[findResultIndex(consider.id)]['result_type'] == 'value'"
                                        v-model="results[findResultIndex(consider.id)]['value']"
                                    ></b-form-input>
                                    <my-date-picker
                                        v-if="results[findResultIndex(consider.id)]['result_type'] == 'date'"
                                        :id="consider.id"
                                        :showDate="result_show[findResultIndex(consider.id)]['value']"
                                        @update="value => results[findResultIndex(consider.id)]['value'] = value"
                                    ></my-date-picker>
                                </div>
                            </consider-check>
                        </b-card>
                    </div>
                </b-col>
            </b-row>
            <b-row>
                <b-col>
                    <div class="text-center" style="margin-bottom:5px;">
                        <b-button type="submit" variant="primary">ตรวจสอบเงื่อนไข</b-button>
                    </div>
                </b-col>
            </b-row>
        </b-form>
    </div>

</template>

<script>
export default {
    props: ['refund_id','rule','refund_form_id','details'],
    data(){
        return {
            office_id: 2,
            results: null,
            result_show: null,
            result_tmp: [],
            alert: '',
            rule_select: 0,
            arr_detail: []
        }
    },
    watch: {
        details(){
            if (details){
                this.createResult();
            }
        },

    },
    mounted(){
        this.getRefundDetail();

    },
    methods: {
        async getRefundDetail(){
            this.results = await this.createResult();
            this.$forceUpdate();
            setTimeout(() => {
                this.result_show = this.result_tmp;
            }, 1000);
        },
        async createResult(){
            let tmp = [];
            this.result_tmp = [];
             this.result_show = [];

            if (this.rule.sub_rules.length > 0){
                for (let i=0; i<this.rule.sub_rules.length; i++){
                    for (let j=0; j<this.rule.sub_rules[i]['considers'].length; j++){
                        let detail = await this.findDetail(this.rule.sub_rules[i]['considers'][j].id);
                        tmp.push(detail);
                    }
                }
            }else{
                for (let j=0; j<this.rule.considers.length; j++){
                    let detail = await this.findDetail(this.rule.considers[j].id);
                    tmp.push(detail);
                }
            }
            return tmp;
        },
        findDetail(consider_id){
            let detail = null;
            let index = this.details.findIndex(x=>x.consider_id == consider_id);
            detail = _.cloneDeep(this.details[index]);
            if (detail){
                console.log('find detail :' + consider_id + ' index : ' + index + ' type :' + detail.result_type);
                if (detail.result_type == 'boolean'){
                    detail.value = (detail.value == 1) ? true : false;
                }
                this.result_tmp.push(
                    {
                        "consider_id" : detail.consider_id,
                        "value" : detail.value
                    }
                );
                this.result_show.push(
                    {
                        "consider_id" : detail.consider_id,
                        "value" : ""
                    }
                );
            }
            return detail;
        },
        findResultIndex(consider_id){
            return this.results.findIndex(x=>x.consider_id == consider_id);
        },
        async sentResult(rule){
            let result_detail = [];
            let path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${this.refund_form_id}/refund_details`;
            let tmp = await axios.post(`${path}`,
                {
                    state: 'update-2',
                    detail: this.results
                })
            this.arr_detail.push(tmp);
            // for (let i=0; i< rule.considers.length; i++){
            //     let arr_detail = [];
            //     await arr_detail.push(this.results[this.results.findIndex(x=>x.consider_id == consider_id)]);
            //     let consider_id = rule.considers[i]['consider_id']
            //     let tmp = await axios.post(`${path}`,
            //         {
            //             state: 'update-2',
            //             detail: arr_detail
            //         })
            //     result_detail.push(tmp);
            // }
            this.arr_detail = result_detail;
        },
        async onSubmit(e){
            e.preventDefault();
            //var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${this.refund_form_id}/refund_details`;
            if (this.rule.sub_rules.length > 0){  //Has Sub Rule
                let sub_rule = await this.rule.sub_rules;
                if (this.rule.result_type == 1){  // หรือ
                    if (this.rule_select != 0){
                        let tmp_rule = await sub_rule[sub_rule.findIndex(x=>x.id == this.rule_select)]
                        let result = await this.sentResult(tmp_rule);
                    }
                }

            }else{ //Main Rule

            }


        }

    }
}

</script>

<style>

</style>
