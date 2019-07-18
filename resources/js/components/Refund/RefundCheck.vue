<template>
<div class="animated fadeIn">
        <b-card no-body class="sub_rule" v-for="(rule,x_index) in form_rule_list" :key="x_index">
            <b-card-body class="pb-0 sub_rule">
                <b-row align-v="center">
                    <b-col>
                        <span class="sub_rule_name">{{rule.order + '.(' + rule.id + ')' + rule.name + '. ' + rule.result}}</span>

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
                            <b-form-input type="text" :value="rule.condition" width="120px" v-else ></b-form-input>
                        </div>
                    </b-col>
                </b-row>
                <b-row v-for="(sub_rule,index) in rule.sub_rules" :key="index" align-v="center">
                    <b-col>
                        <span class="sub_rule_name">{{sub_rule.order + '. (' + sub_rule.id + ')' + sub_rule.name + '. ' + sub_rule.result}}</span>

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
            </b-card-body>
        </b-card>
        <h5>Form Rule :</h5>
        <p>{{form_rule}}</p>
        <h5>Form Rule List:</h5>
        <p>{{form_rule_list}}</p>
        <p>{{result_list}}</p>
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
    props: ['form_id'],
    data(){
        return {
            form_rule: [],
            form_rule_list: [],
            condition_list: [],
            result_list:[]
        }
    },
    mounted() {

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
                                condition: this.form_rule_list[i]['sub_rules'][j]['condition'],
                                condition_type:this.form_rule_list[i]['sub_rules'][j]['condition_type'],
                                result:this.form_rule_list[i]['sub_rules'][j]['result'],
                            })
                        }
                    }else{
                        arr.push({
                            rule: this.form_rule_list[i]['id'],
                            main_rule: 0,
                            condition: this.form_rule_list[i]['condition'],
                            condition_type:this.form_rule_list[i]['condition_type'],
                            result:this.form_rule_list[i]['result'],
                        });
                        console.log('Sub Rule ID :' + this.form_rule_list[i]['name']);
                    }

                }
                this.result_list = arr;
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
                    Object.assign(arr[index],{result: ''});
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
        changeResult(rule_id,x_index=-1,index=-1){
            //console.log('x_index :' + x_index + ' index :' + index);
            let rule_index = this.result_list.findIndex(i => i.rule === rule_id);
            if (index >= 0){
                this.form_rule_list[x_index]['sub_rules'][index].result = !this.form_rule_list[x_index]['sub_rules'][index].result;
            }else{
                this.form_rule_list[x_index].result = !this.form_rule_list[x_index].result;
            }

            this.$forceUpdate();
        },
        find_rule_index(rule_id){
            return this.result_list.findIndex(i => i.rule === rule_id);
        },
        createSolution(){
            var pass = false;
            for (i = 0 ; i <= this.result_list.length ; i++){
                if (this.result_list[i]['main_rule'] == 0){

                }else{

                    let result_type = this.form_rule.findIndex
                }
            }
        }
    },
    computed: {
        rulename(order , name){
            return `${order} ${name}`;
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
.sub_rule{
    padding-bottom: 10px!important;
}
.sub_rule_name{
    padding-top: 5px!important;
}

</style>
