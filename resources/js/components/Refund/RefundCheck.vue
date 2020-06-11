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
                            :detail="refund_form.detail"
                            :refresh="arr_rule_status[arr_rule_status.findIndex(x=>x.rule_id == rule.id)]['refresh']"
                            @rule_passed="rule_passed"
                            @reload="reload_check"
                        ></rule-check>
                    </b-tab>
                </b-tabs>
            </b-col>
        </b-row>
        <b-modal id="contract_form"
            ref="contract_form"
            size="lg"
            hide-header hideFooter
            no-close-on-backdrop
            no-close-on-esc

        >
            <b-card>
                <div slot="header">
                    <strong>ข้อมูลคู่สัญญา</strong>
                </div>
                <validation-observer ref="observer" v-slot="{ passes }">
                <b-form @submit.stop.prevent="passes(saveContract)">
                    <validation-provider
                            name="ชื่อคู่สัญญา"
                            :rules="{ required: true, min: 5 }"
                            v-slot="validationContext"
                        >
                        <b-form-group>
                            <label for="contract_party">ชื่อคู่สัญญา : <span class="require">*</span></label>
                            <b-form-input type="text"
                                placeholder="ชื่อคู่สัญญา"
                                v-model="contract_party"
                                :state="getValidationState(validationContext)"
                                aria-describedby="input-1-live-feedback"
                            >
                            </b-form-input>
                            <b-form-invalid-feedback id="input-1-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                        </b-form-group>
                        </validation-provider>
                        <validation-provider
                                name="สัญญาเลขที่"
                                :rules="{ required: true, min: 5 }"
                                v-slot="validationContext"
                            >
                            <b-form-group>
                                <label for="contract_no">สัญญาเลขที่ :<span class="require">*</span></label>
                                <b-form-input type="text"
                                    placeholder="ใส่เลขที่สัญญา"
                                    name="contract_no"
                                    v-model="contract_no"
                                    :state="getValidationState(validationContext)"
                                    aria-describedby="input-2-live-feedback"
                                >
                                </b-form-input>
                                <b-form-invalid-feedback id="input-2-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>

                    <div class="text-center">
                        <b-button type="submit" variant="primary">บันทึกข้อมูล</b-button>
                        <b-button type="reset" variant="danger" @click="deleteRefund" >ยกเลิก</b-button>
                    </div>

                </b-form>
                </validation-observer>
            </b-card>
        </b-modal>
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
            arr_rule_status: [],
            contract_party: '',
            contract_no: ''
        }
    },
    mounted(){
        this.checkContract();
        this.fetchData();
    },

    methods: {
        getValidationState({ dirty, validated, valid = null }) {
            return dirty || validated ? valid : null;
        },
        deleteRefund(){
            this.$router.replace('/refund/refunds');
        },
        async saveContract(){
            let path = await `/api/offices/${this.office_id}/refunds/${this.refund_id}/contracts`;
            console.log('path :' + path);
            let response = await axios.post(`${path}`,
                {
                    contract_party : this.contract_party,
                    contract_no : this.contract_no
                }
            );

            if (response.data.data){
                this.$store.commit('refund_contract_no',this.contract_no)
                this.$bvModal.hide('contract_form');
            }

        },
        async checkContract(){
            let path = await `/api/offices/${this.office_id}/refunds/${this.refund_id}/contracts`;
            console.log('path :' + path);
            let response = await axios.get(`${path}`);
            let contracts = await response.data.data;
            //console.log('contract :' + contracts.length);
            if (!contracts || contracts.length == 0){
                this.$bvModal.show('contract_form');
            }else{
                this.$store.commit('refund_contract_no',contracts[0].contract_no);
            }
        },
        reload_check(){
            this.fetchData();
        },
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
