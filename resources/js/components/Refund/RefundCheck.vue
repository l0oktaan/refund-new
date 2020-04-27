<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
            <b-row class="justify-content-md-center">
                <b-col cols="10">
                    <b-tabs card pills vertical nav-wrapper-class="w-40" v-model="tabIndex[1]">
                        <b-tab v-for="(rule,x_index) in rules" :key="x_index">
                            <template slot="title">
                                <i :class="(rule.status == 0) ? 'fas fa-check-circle fa-lg' : 'fas fa-times-circle fa-lg'"></i> {{x_index+1}}
                            </template>
                            <rule-check
                                :refund_id="refund_id"
                                :rule="rule"
                                :refund_form_id="refund_form_id"
                                :details="refund_form.detail"
                                @update_detail="fetchData"
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
            office_id : 2,
            refund_form : null,
            rules : null,
            refund_detail : null,
            tabIndex: [0,0],
            alert: ''
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
                this.rules = await this.refund_form.form.rules;
                this.refund_detail = await this.refund_form.detail;
            }
        },
        rule_status(rule_id,status){
            this.$nextTick(() => {

            });
        }
    }
}
</script>

<style>

</style>
