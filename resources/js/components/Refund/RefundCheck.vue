<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
            <b-row class="justify-content-md-center">
                <b-col cols="10">
                    <b-tabs class="tab" card pills vertical nav-wrapper-class="w-40" v-model="tabIndex[1]">
                        <b-tab v-for="(rule,x_index) in rules" :key="x_index">
                            <template slot="title">
                                <i class="fas fa-check-circle fa-lg pass"  v-if="arr_rule_status[arr_rule_status.findIndex(x=>x.rule_id==rule.id)]['status'] == 1"></i>
                                <i class="fas fa-times-circle fa-lg no_pass" v-else></i>
                                {{x_index+1}}
                            </template>
                            <rule-check
                                :refund_id="refund_id"
                                :rule="rule"
                                :refund_form_id="refund_form_id"
                                :details="refund_form.detail"
                                :refresh="arr_rule_status[arr_rule_status.findIndex(x=>x.rule_id == rule.id)]['refresh']"
                                @rule_passed="rule_passed"
                            ></rule-check>
                        </b-tab>
                    </b-tabs>
                </b-col>
            </b-row>
    </div>
</template>

<script>
export default {
    props: ['form_id','refund_id','refund_form_id'],
    data(){
        return {
            office_id: this.$store.getters.office_id,
            refund_form : null,
            rules : null,
            refund_detail : null,
            tabIndex: [0,0],
            alert: '',
            arr_rule_status: []
        }
    },
    mounted(){
        this.fetchData();
    },
    methods: {
        async fetchData(){
            let path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${this.refund_form_id}`;
            let refund_form = await axios.get(`${path}`);
            this.refund_form = refund_form.data.data;

            if (this.refund_form){
                this.arr_rule_status = [];
                this.rules = await this.refund_form.form.rules;
                for (let i=0; i<this.rules.length; i++){
                    this.arr_rule_status.push(
                        {
                            'rule_id' : this.rules[i]['id'],
                            'status': 0,
                            'refresh' : false
                        }
                    )
                }
                this.refund_detail = await this.refund_form.detail;
            }
        },
        rule_status(rule_id,status){
            this.$nextTick(() => {

            });
        },
        async rule_passed(item){
            let index = await this.arr_rule_status.findIndex(x=>x.rule_id == item.id);
            this.arr_rule_status[index]['status'] = item.value;
            await this.check_form_passed();
        },
        async check_form_passed(){
            let passed = true;
            await this.arr_rule_status.forEach((e)=>{
                //console.log("rule id :" + e.rule_id);
                if (e.status == 0){
                    passed = false;
                }
            })
            if (passed){
                let path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${this.refund_form_id}`;
                await axios.put(`${path}`,{
                    result: 1
                });
                this.$emit("refund_update");
                //console.log('Form passed!!!');
            }
        }
    }
}
</script>

<style scoped>
.pass{
    color: rgb(24, 117, 21);
}
.no_pass{
    color: rgb(255, 0, 0);
}
.tab{
    background-color: thistle!important;
}
</style>
