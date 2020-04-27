<template>
    <div class="animated fadeIn">
        <b-form  @submit.stop.prevent="passes(onSubmit)">
            <b-row>
                <b-col>
                    <!-- <p>{{results}}</p>
                    <p>{{result_tmp}}</p> -->
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

                    <b-card v-for="(sub_rule,i_index) in rule.sub_rules" :key="i_index">
                        <b-form-checkbox>
                            <span>{{'หลักเกณฑ์ย่อย ' + rule.order + '.' + sub_rule.order + ' : ' + sub_rule.name}}</span>
                        </b-form-checkbox>

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
            rule_select: 0
        }
    },
    watch: {
        details(){
            if (details){
                this.createResult();
            }
        }
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
        }

    }
}

</script>

<style>

</style>
