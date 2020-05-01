<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
        <b-form  @submit="onSubmit">
            <b-row>
                <b-col>
                    <!-- <p>{{rule}}</p> -->
                    <p>{{results}}</p>
                    <p>{{arr_detail}}</p>
                    <p>{{rule_passed}}</p>
                    <!-- <p>{{result_tmp}}</p> -->
                    <p>{{rule_select}}</p>
                    <b-card bg-variant="primary" text-variant="white" class="p-1 pl-2">
                        <span>หลักเกณฑ์ {{rule.order}} : {{rule.name}}</span>
                    </b-card>


                    <consider-check
                        v-for="(consider,index) in rule.considers" :key="index"
                        :consider = "consider"
                    >
                        <div v-if="results && result_show">
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
                                :showDate="result_show[result_show.findIndex(x=>x.consider_id == consider.id)].value"
                                @update="value => results[results.findIndex(x=>x.consider_id == consider.id)].value = value"
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

                                <div v-if="results && result_show">
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
                                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'value' || results[findResultIndex(consider.id)]['result_type'] == 'number'"
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

                                <div v-if="results && result_show">
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
                        <b-button type="submit" variant="primary" v-if="!rule_passed">ตรวจสอบเงื่อนไข</b-button>
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
            arr_detail: [],
            rule_passed: false
        }
    },
    watch: {
        // details(){
        //     if (details){
        //         this.createResult();
        //     }
        // },
        rule_select(newVal,oldVal){
            if (newVal){
                this.select_rule(newVal);
            }
        },
        async rule(){

            // this.results = await this.createResult();
            // await this.getRefundDetail();
        }
    },
    async mounted(){
        this.results = await this.createResult();
        await this.getRefundDetail();
    },
    methods: {
        check_rule_pass(){
            let status = 0;
            let tmp = this.results.filter(x=>x.rule_id == this.rule_select);
            for (let i=0; i<tmp.length; i++){
                status += parseInt(tmp[i]['status']);
            }
            this.$nextTick(() => {
                if (status != 0 && tmp.length == status){
                    this.rule_passed = true;
                }else{
                    this.rule_passed = false;
                }
            })
        },
        select_rule(rule_id){
            for (let i=0; i<this.results.length; i++){
                this.$nextTick(() => {
                    if (this.results[i]['rule_id'] == rule_id){
                        this.results[i]['selected'] = 1
                    }else{
                        this.results[i]['selected'] = 0
                    }
                });
            }
        },
        async getRefundDetail(){
            let tmp = 0;

            if (this.rule.sub_rules.length > 1){
                for (let i=0; i<this.results.length; i++){

                        if (this.results[i]['selected'] == 1){
                            tmp = this.results[i]['rule_id'];
                        }
                }
                if (!tmp == 0){
                    await this.$nextTick(() => {
                        this.rule_select = tmp;
                    });
                }
            }else{
                await this.$nextTick(() => {
                    this.rule_select = this.rule.id;
                });
            }
            await this.check_rule_pass();

            setTimeout(() => {
                this.result_show = this.result_tmp;
            }, 500);
        },
        async createResult(){
            let tmp = [];
            this.result_tmp = [];
            this.result_show = [];
            if (this.rule.sub_rules.length > 0){
                for (let i=0; i<this.rule.sub_rules.length; i++){
                    for (let j=0; j<this.rule.sub_rules[i]['considers'].length; j++){
                        let detail = await this.findDetail(this.rule.sub_rules[i]['considers'][j].id);
                        await tmp.push(detail);
                    }
                }
            }else{
                for (let j=0; j<this.rule.considers.length; j++){
                    let detail = await this.findDetail(this.rule.considers[j].id);
                    await tmp.push(detail);
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
        async sentResult(){
            let result_detail = [];
            result_detail = await this.results.filter(x=>x.rule_id == this.rule_select);

            console.log('sent detail :' + result_detail.length);
            let path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${this.refund_form_id}/refund_details`;
            let tmp = await axios.post(`${path}`,
                {
                    state: 'update-2',
                    detail: result_detail
                })
            //this.arr_detail.push(tmp);
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
            //this.arr_detail = result_detail;
        },
        async onSubmit(e){
            e.preventDefault();

            //var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${this.refund_form_id}/refund_details`;
            if (this.rule.sub_rules.length > 0){  //Has Sub Rule

                //let sub_rule = await this.rule.sub_rules;
                if (this.rule.result_type == 1){  // หรือ

                    if (this.rule_select != 0){

                        //let tmp_rule = await sub_rule[sub_rule.findIndex(x=>x.id == this.rule_select)]
                        let result = await this.sentResult();
                    }
                }

            }else{ //Main Rule
                let result = await this.sentResult();
            }
            let update = await this.$emit("update_detail");
            let check = await this.check_rule_pass();

        }

    }
}

</script>

<style>

</style>
