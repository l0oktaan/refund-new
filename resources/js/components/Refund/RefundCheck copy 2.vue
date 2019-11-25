<template>
<div class="animated fadeIn">
        <b-row>
            <b-col sm="12">

                <b-card no-body class="sub_rule" v-for="(rule,x_index) in form_rule_list" :key="x_index">
                    <div class="rule_name" slot="header">
                        <div class="card-header-actions">
                            <!-- <b-badge variant="success">Success</b-badge> -->
                        </div>
                         <i class="fas fa-angle-double-right fa-lg"></i><span> หลักเกณฑ์ {{rule.order}} : {{rule.name}}</span>
                    </div>
                    <consider-check
                        :rule="rule"
                        :ref="`rule${x_index}`"
                        @ready="getConsider"
                    ></consider-check>
                    <!-- <b-card-body class="pb-0 sub_rule">
                        <b-row>

                        </b-row>
                        <b-row align-v="center">
                            <b-col>
                                <span class="sub_rule_name">{{rule.order + '. ' + rule.name}}</span>

                            </b-col>
                            <b-col>
                                <div v-if="rule.sub_rules.length == 0">

                                    <toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                                        :labels="{checked: 'ใช่', unchecked: 'ไม่ใช่'}"
                                        :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                                        style="padding-top:4px; line-height:0px;"
                                        v-model="result_list[find_rule_index(rule.id)]['result']"
                                        @change="changeResult(rule.id,x_index)"
                                        v-if="rule.condition_type == 1"
                                    />
                                    <b-form-input type="text"
                                        :value="rule.condition"
                                        width="120px"
                                        v-else
                                        v-model="result_list[find_rule_index(rule.id)]['result']"
                                        @change="changeResult(rule.id,x_index)"
                                    >
                                    </b-form-input>
                                </div>
                            </b-col>
                        </b-row>
                        <b-row v-for="(sub_rule,index) in rule.sub_rules" :key="index" align-v="center">
                            <b-col>
                                <span class="sub_rule_name">{{sub_rule.order + '. ' + sub_rule.name}}</span>

                            </b-col>
                            <b-col>

                                    <toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                                        :labels="{checked: 'ใช่', unchecked: 'ไม่ใช่'}"
                                        :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                                        style="padding-top:4px; line-height:0px;"
                                        v-model="result_list[find_rule_index(sub_rule.id)]['result']"
                                        @change="changeResult(sub_rule.id,x_index,index)"
                                        v-if="sub_rule.condition_type == 1"
                                    />
                                    <b-form-input type="text" v-else></b-form-input>

                            </b-col>
                        </b-row>
                    </b-card-body> -->
                </b-card>
            </b-col>
        </b-row>
       <b-row>
            <b-col>
                <div class="text-center" style="margin-bottom:5px;">
                    {{showRule}}
                    <b-button variant="primary" @click="checkConsider()">บันทึกข้อมูล</b-button>
                </div>
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
            form_rule: [],
            form_rule_list: [],
            condition_list: [],
            result_list:[],
            arrResult: [],
            state: 'new',
            showRule: null

        }
    },
    watch :{
        refund_id(){
            if (this.refund_id == 0){

            }
        }
    },
    mounted() {
            this.showRule = [];
            console.log('get form rule');
            this.fetchData();

    },
    methods: {
        fetchData(){
            var path = `/api/forms/${this.form_id}/form_rules`;
            var arr = [];
            var result = [];
            axios.get(path)
            .then(response=>{
                this.form_rule = response.data.data;
                this.addDefaultResult();
                this.form_rule_list = this.getMainRule();

                for (let i = 0 ; i < this.form_rule_list.length ; i++){
                    Object.assign(this.form_rule_list[i],{sub_rules: this.getSubRule(this.form_rule_list[i]['id'])});

                    if (this.form_rule_list[i]['sub_rules'].length > 0){
                        for (let j=0 ; j < this.form_rule_list[i]['sub_rules'].length ; j++){
                            arr.push({
                                rule: this.form_rule_list[i]['sub_rules'][j]['id'],
                                main_rule: this.form_rule_list[i]['id'],
                                considers: this.form_rule_list[i]['sub_rules'][j]['considers'],
                                condition: this.form_rule_list[i]['sub_rules'][j]['condition'],
                                condition_type:this.form_rule_list[i]['sub_rules'][j]['condition_type'],
                                result:this.form_rule_list[i]['sub_rules'][j]['result'],
                            })
                        }
                    }else{
                        arr.push({
                            rule: this.form_rule_list[i]['id'],
                            main_rule: 0,
                            considers: this.form_rule_list[i]['considers'],
                            condition: this.form_rule_list[i]['condition'],
                            condition_type:this.form_rule_list[i]['condition_type'],
                            result:this.form_rule_list[i]['result'],
                        });
                        console.log('Sub Rule ID :' + this.form_rule_list[i]['name']);
                    }
                }
                this.result_list = arr;
                this.getResult();
            })
        },

        createConditionList(){
            var arr = [];
            this.form_rule_list.forEach(function(element, index, arr){
                if (element.sub_rules.length > 0){
                    element.sub_rules.forEach(function(e, i, arr){
                        arr.push({rule_id: element.id, })
                    });
                }
            });
        },
        addDefaultResult(){
            var arr = this.form_rule;
            this.form_rule.forEach(function(element,index,arr){
                if (arr[index]['condition_type'] == 1){
                    Object.assign(arr[index],{result: false});
                }else{
                    Object.assign(arr[index],{result: arr[index]['condition']});
                }
            });
            this.form_rule = arr;
        },
        getMainRule(){
            var main_rule = this.form_rule.filter(function(rule){
                return rule.sub_of == 0;
            })
            return main_rule;
        },
        getRule(){
            var main_rule = this.form_rule.filter(function(rule){
                return rule.sub_of == 0;
            })
            return main_rule;
        },
        getSubRule(id){
            var sub_rule = this.form_rule.filter(function(rule){
                return rule.sub_of == id;
            })
            return sub_rule;
        },
        changeResult(rule_id,i_index=-1,j_index=-1){
            //console.log('i_index :' + i_index + ' index :' + index);
            let rule_index = this.result_list.findIndex(i => i.rule === rule_id);
            if (j_index >= 0){
                if (this.form_rule_list[i_index]['sub_rules'][j_index].result_type == 1){
                    this.form_rule_list[i_index]['sub_rules'][j_index].result = !this.form_rule_list[i_index]['sub_rules'][j_index].result;
                }else{
                    this.form_rule_list[i_index]['sub_rules'][j_index].result = this.result_list[rule_index].result;
                }

            }else{
                if (this.form_rule_list[i_index].result_type == 1){
                    this.form_rule_list[i_index].result = !this.form_rule_list[i_index].result;
                }else{
                    this.form_rule_list[i_index].result = this.result_list[rule_index].result;
                }

            }

            this.$forceUpdate();
            this.getResult();
        },
        find_rule_index(rule_id){
            return this.result_list.findIndex(i => i.rule === rule_id);
        },

        getResult(){
            var result = false;
            var arrResult = [];
            this.form_rule_list.forEach(function(element,index){
                let arr = [];
                if (element.sub_rules.length > 0){
                    for (let i = 0 ; i < element.sub_rules.length ; i++){
                        if (element.sub_rules[i]['condition_type'] == 1){
                            arr.push(element.sub_rules[i]['result']);
                        }else{
                            if (element.sub_rules[i]['condition'] == element.sub_rules[i]['result']){
                                arr.push(false);
                            }else{
                                arr.push(true);
                            }
                        }
                    }
                    if (element.result_type == 1){
                        arrResult.push(arr.some(x=> x == true));
                    }else{
                        arrResult.push(arr.every(x=> x == true));
                    }
                }else{
                    if (element.condition_type == 1){
                        arrResult.push(element.result);
                    }else{
                        if (element.condition == element.result){
                            arrResult.push(false);
                        }else{
                            arrResult.push(true);
                        }
                    }
                }
            });
            this.arrResult = arrResult;
        },
        isSuccess(value){
            if (value){
                return "fas fa-check-square fa-lg"
            }else{
                return "fas fa-square fa-lg"
            }
        },
        getConsider(value){
            this.showRule.push(value.considers);
            console.log('get consider :' + value.considers);
        }
    },
    computed: {
        rulename(order , name){
            return `${order} ${name}`;
        }
    },
    watch : {
        result_list(){
            //this.getResult();
        }
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
}
.card-header{
    padding: 5px!important;
    background-color: #20a8d8;
    color: #ffffff;
}
.card{
    margin-bottom: 5px!important;
}
</style>
