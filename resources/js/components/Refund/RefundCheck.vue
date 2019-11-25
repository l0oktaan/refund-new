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
                            v-if = "rule.considers.length > 0"
                            :considers = "rule.considers"
                        ></consider-check>
                        <b-card :header="'หลักเกณฑ์ ' + rule.order + '.' + sub_rule.order + ' : ' + sub_rule.name"
                            class="bg-primary sub_rule" v-for="(sub_rule,y_index) in rule.sub_rules" :key="y_index">
                                <consider-check
                                    v-if = "sub_rule.considers.length > 0"
                                    :considers = "sub_rule.considers"
                                ></consider-check>
                        </b-card>
                </b-card>
            </b-col>
        </b-row>
       <b-row>
            <b-col>
                <!-- <div class="text-center" style="margin-bottom:5px;">
                    {{showRule}}
                    <b-button variant="primary" @click="checkConsider()">บันทึกข้อมูล</b-button>
                </div> -->
            </b-col>
        </b-row>
        <b-row>
            <b-col>



            </b-col>
        </b-row>

    </div>
    <!-- <div>
        <b-list-group>
            <b-list-group-item v-for="(rule,index) in getRule()" :key="index">
                <div>
                    <h4>{{rule.name}}</h4>
                    <ul>
                        <li v-for="(sub_rule,index) in getSubRule(rule.id)" :key="index" >{{sub_rule.name}}</li>
                    </ul>
                </div>
            </b-list-group-item>
        </b-list-group>
    </div> -->
</template>
<script>
export default {
    props: ['form_id','refund_id'],
    data(){
        return {
            rules: [],
        }
    },
    watch :{

    },
    mounted() {
        this.fetchData()
    },
    methods: {
        fetchData(){
            var path = `/api/forms/${this.form_id}/form_rules?sub_of=${0}`;
            axios.get(`${path}`)
            .then(response=>{
                this.rules = response.data.data;
                this.getSubRule();
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
    }


}
</script>
<style scoped>
.tabTitle{
    font-size: 1rem;
    font-weight: bold;
}
.nav-link{
    padding-top: 10px!important;
}

.sub_rule_name{
    padding-top: 5px!important;
}
.rule_name{
    margin: 5px!important;
    background-color: #ffffff!important;
}
.card-header{
    padding: 5px!important;
    background-color: #20a8d8;
    color: #ffffff;
    font-size: 1rem!important;
}
.card{
    margin-bottom: 5px!important;
}
.card-body{
    background-color: #ffffff!important;
    padding: 2px!important;
    color: #000!important;
    font-size: 1rem!important;
}
.sub_rule{
    margin: 5px;
}
</style>
