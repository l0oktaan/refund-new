<template>
<div>
    <my-alert :AlertType="alert"></my-alert>
    <div v-if="refund_form">
        <b-card no-body>
            <b-tabs card pills vertical nav-wrapper-class="w-40" v-model="tabIndex[1]">
                <b-tab v-for="(rule,index) in refund_form.form.rules" :key="index">
                    <template slot="title">
                        <i class="icon-calculator"></i> {{index+1}}
                    </template>
                    <rule-check :rule="rule"></rule-check>
                    <!-- <div >
                        <b-row>
                            <b-col cols="5"><div>หลักเกณฑ์</div></b-col>
                            <b-col cols="4"><div>เงื่อนไข</div></b-col>
                            <b-col cols="3"><div>เงื่อนไข</div></b-col>
                        </b-row>
                        <b-row v-if="rule.sub_rules.length == 0">
                            <b-col cols="5">
                                {{index+1 + '. ' + rule.name}}
                                <div v-if="rule.description">
                                    <b-btn size="sm" v-b-toggle="'desc' + rule.id" variant="ghost-success" ><i class="fas fa-question-circle fa-1x"></i>&nbsp;คำอธิบาย</b-btn>
                                    <b-collapse visible :id="'desc' + rule.id">
                                        <b-alert variant="success" show>
                                            {{rule.description}}
                                        </b-alert>
                                    </b-collapse>
                                </div>
                            </b-col>
                            <b-col cols="4">
                                <div v-for="consider in rule.considers" :key="consider.id">
                                    {{consider.name}}
                                </div>
                            </b-col>
                            <b-col cols="3"><div>เงื่อนไข</div></b-col>

                        </b-row>
                        <b-row v-else>
                            <b-col cols="12">
                                <b-row>
                                    <b-col cols="12">
                                        {{index+1 + '. ' + rule.name}}
                                    </b-col>
                                </b-row>
                                <b-row v-for="(sub_rule,index_y) in rule.sub_rules" :key="index_y">
                                    <b-col cols="5">
                                        <b-form-radio name="some-radios" value="A">{{index+1 + '.'}} {{index_y+1 + ' ' + sub_rule.name}}</b-form-radio>
                                        <div v-if="sub_rule.description">
                                            <b-btn v-b-toggle="'desc' + sub_rule.id" variant="ghost-success" ><i class="fas fa-question-circle fa-1x"></i>&nbsp;คำอธิบาย</b-btn>
                                            <b-collapse visible :id="'desc' + sub_rule.id">
                                                <b-alert variant="success" show>
                                                    {{sub_rule.description}}
                                                </b-alert>
                                            </b-collapse>
                                        </div>
                                    </b-col>
                                    <b-col cols="7">
                                        <b-row v-for="consider in sub_rule.considers" :key="consider.id">
                                            <b-col cols="7">
                                                 <div>
                                                    {{consider.name}}
                                                </div>
                                            </b-col>
                                            <b-col cols="5">
                                                 <div>
                                                    เงื่อนไข
                                                </div>
                                            </b-col>
                                        </b-row>
                                    </b-col>
                                </b-row>
                            </b-col>
                        </b-row>
                    </div> -->
                </b-tab>
            </b-tabs>
        </b-card>
    </div>

</div>

</template>
<script>
export default {
    name: 'rules',
    props: ['form_id','refund_id','refund_form_id'],
    data(){
        return {
            office_id: 2,
            refund_form: null,
            rule_length: 0,
            select_rule: null,
            arr_rule_select: [],
            arr_rule: [],
            tabIndex: [0, 0],
            tabs: [
                'Calculator',
                'Shopping cart',
                'Charts'
            ],
            alert: ''
        }
    },
    mounted(){
        this.fetchData();
    },
    computed: {

    },
    methods : {
        fetchData(){
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${this.refund_form_id}`
            console.log(path);
            axios.get(`${path}`)
            .then(response=>{
                this.$nextTick(() => {
                        this.refund_form = response.data.data;
                        if (this.refund_form){
                            this.rule_length = this.refund_form.form.rules.length;
                            this.create_arr_rule();
                            //console.log('Rule Length :' + this.rule_length);
                        }
                    })

            })
        },
        create_arr_rule(){
            var rules = [];
            if (this.refund_form){
                this.arr_rule = [];
                rules = this.refund_form.form.rules;
                for (let i = 0 ; i < rules.length ; i++){
                    //let rule = rules[i];
                    if (rules[i].sub_rules.length == 0){
                        for (let x =0; x < rules[i]['considers'].length; x++){
                            Object.assign(rules[i]['considers'][x],{detail: this.getDetail(rules[i]['considers'][x]['id'])});
                        }

                    }else{
                        for (let j = 0; j < rules[i].sub_rules.length; j++){
                            for (let x =0; x < rules[i]['sub_rules'][j]['considers'].length; x++){
                                Object.assign(rules[i]['sub_rules'][j]['considers'][x],{detail: this.getDetail(rules[i]['sub_rules'][j]['considers'][x]['id'])});
                            }

                        }
                    }
                }
            }
        },
        getDetail(consider_id){
            return this.refund_form.detail[this.refund_form.detail.findIndex(x=> x.consider_id == consider_id)];
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
    padding: 5px!important;
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
.helpIcon{
    color: rgb(46, 158, 158);
}
.alert{
    margin-top: 5px!important;
}
</style>
