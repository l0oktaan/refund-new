<template>
    <div class="animated fadeIn">
        <b-form  @submit.stop.prevent="passes(onSubmit)">
            <b-row>
                <b-col>
                    <p>{{results}}</p>
                    <!-- <p>{{detail}}</p> -->

                </b-col>
            </b-row>
            <b-row>
                <b-col cols="5"><div>หลักเกณฑ์</div></b-col>
                <b-col cols="4"><div>เงื่อนไข</div></b-col>
                <b-col cols="3"><div>รายละเอียด</div></b-col>
            </b-row>
            <b-row v-if="rule.sub_rules.length == 0">
                <b-col cols="5">
                    {{rule.order + '. ' + rule.name}}
                    <div v-if="rule.description">
                        <b-btn size="sm" v-b-toggle="'desc' + rule.id" variant="ghost-success" ><i class="fas fa-question-circle fa-1x"></i>&nbsp;คำอธิบาย</b-btn>
                        <b-collapse visible :id="'desc' + rule.id">
                            <b-alert variant="success" show>
                                {{rule.description}}
                            </b-alert>
                        </b-collapse>
                    </div>
                </b-col>
                <b-col cols="7">
                    <b-row v-for="consider in rule.considers" :key="consider.id">
                        <b-col cols="7">
                            <div>
                                {{consider.name}}
                            </div>
                        </b-col>
                        <b-col cols="5">
                            <div v-if="results.length > 0">
                                    <toggle-button :value = "false" :sync = "true" :width="60" :height="25"

                                        v-if="get_result_type(consider.id) == 'boolean'"
                                        :labels="{checked: 'ใช่', unchecked: 'ไม่ใช่'}"
                                        :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                                        style="padding-top:4px; line-height:0px;"
                                        v-model="results[results.findIndex(x=>x.consider_id == consider.id)].result"
                                    />
                                    <!-- <p>{{results[results.findIndex(x=>x.consider_id == consider.id)]['result']}}</p> -->
                                    <b-form-input type="text"
                                        v-if="get_result_type(consider.id) == 'value' || get_result_type(consider.id) == 'number'"
                                        v-model="results[results.findIndex(x=>x.consider_id == consider.id)]['result']"
                                    ></b-form-input>



                                    <my-date-picker
                                        v-if="get_result_type(consider.id) == 'date'"
                                        :id="consider.id"
                                        :ref="'mydate' + consider.id"

                                        @update="value=>results[results.findIndex(x=>x.consider_id == consider.id)].result = value"
                                    ></my-date-picker>

                            </div>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
            <b-row v-if="rule.sub_rules.length > 0">
                <b-col cols="12">
                    <b-row>
                        <b-col cols="12">
                            {{rule.order + '. ' + rule.name}}
                        </b-col>
                    </b-row>
                    <b-row v-for="(sub_rule,index_y) in rule.sub_rules" :key="index_y">
                        <b-col cols="5">
                            <b-form-radio name="some-radios" value="A">{{rule.order + '.'}} {{index_y+1 + ' ' + sub_rule.name}}</b-form-radio>
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
                                    <div v-if="results">
                                         <toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                                            :id="consider.id"
                                            v-if="get_result_type(consider.id) == 'boolean'"
                                            :labels="{checked: 'ใช่', unchecked: 'ไม่ใช่'}"
                                            :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                                            style="padding-top:4px; line-height:0px;"
                                            v-model="results[results.findIndex(x=>x.consider_id == consider.id)].result"
                                        />
                                        <!-- <p>{{results[results.findIndex(x=>x.consider_id == consider.id)]['result']}}</p> -->
                                        <b-form-input type="text"
                                            v-if="get_result_type(consider.id) == 'value'"
                                            v-model="results[results.findIndex(x=>x.consider_id == consider.id)]['result']"
                                        ></b-form-input>
                                        <my-date-picker
                                            v-if="get_result_type(consider.id) == 'date'"
                                            :id="'mydate-' + consider.id"
                                            :showDate="results[results.findIndex(x=>x.consider_id == consider.id)].show"
                                            @update="value=>results[results.findIndex(x=>x.consider_id == consider.id)].result = value"
                                        ></my-date-picker>
                                    </div>
                                </b-col>
                            </b-row>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
        </b-form>
    </div>

</template>

<script>
export default {
    props: ['rule','detail'],
    data(){
        return {
            results: [],
            i_rule: {}
        }
    },
    mounted(){
        this.fetchData();
    },
    created(){
        // this.fetchData();
        // if (this.rule){
        //     this.i_rule = this.rule;
        // }

    },
    watch: {
        // i_rule(){

        //     this.results = [];
        //     let _results = [];
        //     if (this.rule.sub_rules.length == 0){

        //         for (let j = 0; j < this.rule.considers.length; j++){

        //             // let i_result = this.detail[this.detail.findIndex(x=>x.consider_id == this.rule.considers[j]['id'])]
        //             // if (i_result.result_type == "boolean"){
        //             //     i_result.value = (i_result.value == 0 || !i_result.value) ? false : true;
        //             // }
        //             try{
        //                 let index = this.detail.findIndex(x=>x.consider_id == this.rule.considers[j].id);
        //                 console.log('create result :' + this.rule.considers[j].id + ' index : ' + index);
        //                 let i_result = {
        //                     "id" : this.detail[index]['id'],
        //                     "consider_id" : this.detail[index]['consider_id'],
        //                     "result_type" : this.detail[index]['result_type'],
        //                     "selected" : this.detail[index]['selected'],
        //                     "show" : this.getResult(this.detail[index]['result_type'],this.detail[index]['value']),
        //                     "result" : this.getResult(this.detail[index]['result_type'],this.detail[index]['value']),
        //                     "status" : this.detail[index]['status']
        //                 }
        //                 // console.log('id :' + this.detail[index]['id']);
        //                 // console.log('consider_id :' + this.detail[index]['consider_id']);
        //                 // console.log('result type :' + this.detail[index]['result_type']);
        //                 // console.log('selected :' + this.detail[index]['selected']);
        //                 // console.log('result :' + this.getResult(this.detail[index]['result_type'],this.detail[index]['value']));
        //                 // console.log('status :' + this.detail[index]['status']);
        //                 // console.log('id :' + i_result.id);
        //                 // console.log('consider_id :' + i_result.consider_id);
        //                 // console.log('result type :' + i_result.result_type);
        //                 // console.log('selected :' + i_result.selected);
        //                 // console.log('result :' + i_result.result);
        //                 // console.log('status :' + i_result.status);
        //                 _results.push(i_result);
        //             }catch (error){
        //                 console.log('error push result : ' + error);
        //             }

        //         }
        //     }else{
        //         for (let i = 0; i < this.rule.sub_rules.length; i++){
        //             for (let j = 0; j < this.rule.sub_rules[i]['considers'].length; j++){
        //                 //let i_result = this.detail[this.detail.findIndex(x=>x.consider_id == this.rule.sub_rules[i].considers[j].id)]
        //                 let index = this.detail.findIndex(x=>x.consider_id == this.rule.sub_rules[i].considers[j].id);
        //                 let i_result = {
        //                     id : this.detail[index]['id'],
        //                     consider_id : this.detail[index]['consider_id'],
        //                     result_type : this.detail[index]['result_type'],
        //                     selected : this.detail[index]['selected'],
        //                     show: this.getResult(this.detail[index]['result_type'],this.detail[index]['value']),
        //                     result : this.getResult(this.detail[index]['result_type'],this.detail[index]['value']),
        //                     status : this.detail[index]['status']
        //                 }

        //                 _results.push(i_result);
        //                 // console.log('sub rule consider :' + this.rule.sub_rules[0]['considers']['id']);
        //             }
        //         }
        //     }
        //     this.$nextTick(() => {
        //         this.results = _results;
        //         this.$forceUpdate();
        //     })

        // }
    },
    methods: {
        fetchData(){


            this.results = [];
            let _results = [];
            if (this.rule.sub_rules.length == 0){

                for (let j = 0; j < this.rule.considers.length; j++){

                    // let i_result = this.detail[this.detail.findIndex(x=>x.consider_id == this.rule.considers[j]['id'])]
                    // if (i_result.result_type == "boolean"){
                    //     i_result.value = (i_result.value == 0 || !i_result.value) ? false : true;
                    // }
                    try{
                        let index = this.detail.findIndex(x=>x.consider_id == this.rule.considers[j].id);
                        //console.log('create result :' + this.rule.considers[j].id + ' index : ' + index);
                        let i_result = {
                            "id" : this.detail[index]['id'],
                            "consider_id" : this.detail[index]['consider_id'],
                            "result_type" : this.detail[index]['result_type'],
                            "selected" : this.detail[index]['selected'],
                            "show" : this.getResult(this.detail[index]['result_type'],this.detail[index]['value']),
                            "result" : this.getResult(this.detail[index]['result_type'],this.detail[index]['value']),
                            "status" : this.detail[index]['status']
                        }
                        // console.log('id :' + this.detail[index]['id']);
                        // console.log('consider_id :' + this.detail[index]['consider_id']);
                        // console.log('result type :' + this.detail[index]['result_type']);
                        // console.log('selected :' + this.detail[index]['selected']);
                        // console.log('result :' + this.getResult(this.detail[index]['result_type'],this.detail[index]['value']));
                        // console.log('status :' + this.detail[index]['status']);
                        // console.log('id :' + i_result.id);
                        // console.log('consider_id :' + i_result.consider_id);
                        // console.log('result type :' + i_result.result_type);
                        // console.log('selected :' + i_result.selected);
                        // console.log('result :' + i_result.result);
                        // console.log('status :' + i_result.status);
                        _results.push(i_result);
                    }catch (error){
                        console.log('error push result : ' + error);
                    }

                }
            }else{
                for (let i = 0; i < this.rule.sub_rules.length; i++){
                    for (let j = 0; j < this.rule.sub_rules[i]['considers'].length; j++){
                        //let i_result = this.detail[this.detail.findIndex(x=>x.consider_id == this.rule.sub_rules[i].considers[j].id)]
                        let index = this.detail.findIndex(x=>x.consider_id == this.rule.sub_rules[i].considers[j].id);
                        let i_result = {
                            id : this.detail[index]['id'],
                            consider_id : this.detail[index]['consider_id'],
                            result_type : this.detail[index]['result_type'],
                            selected : this.detail[index]['selected'],
                            show: this.getResult(this.detail[index]['result_type'],this.detail[index]['value']),
                            result : this.getResult(this.detail[index]['result_type'],this.detail[index]['value']),
                            status : this.detail[index]['status']
                        }

                        _results.push(i_result);
                        // console.log('sub rule consider :' + this.rule.sub_rules[0]['considers']['id']);
                    }
                }
            }
            this.$nextTick(() => {
                this.results = _results;
                this.showDate();
                this.$forceUpdate();
            })


        },
        find_result_index(id){
            //console.log('Find Consider : ' + id);
            //if (this.refund_details.length > 0){
                // return this.results.findIndex(i => i.consider_id == id);
                return this.detail.findIndex(i => i.consider_id == id);
            //}
        },
        get_result_type(id){
            if (this.results){
                let index = this.results.findIndex(x => x.consider_id == id);
                if (index >= 0){
                    let result_type = String(this.results[index]['result_type']);
                    //console.log('result type : ' + result_type);
                    return result_type;
                }else{
                    return "error " + id;
                }
            }

        },
        getResult(type,result){
            //console.log(type + " : " + result);
            if (type == 'boolean'){
                if (result == '0'){
                    return false;
                }else if (result == '1'){
                    return true;
                }else{
                    return false
                }
            }else if (type == 'date'){
                //console.log("is date : " + result);
                return result;
                var d = new Date(result);
                //d.toLocaleDateString('th-TH', { day: 'numeric', month: 'long', year: 'numeric' });
            }else{
                return result;
            }
        },
        showDate(){
            if (this.results){
                for (let i=0; i < this.results.length; i++){
                    if (this.results[i]['result_type'] == 'date'){

                        let refName = String('mydate' + this.results[i]['consider_id']);
                        this.$nextTick(() => {
                            console.log('Show date ' + refName + ' : ' + this.results[i]['show']);
                            this.$refs[refName].date = this.results[i]['show'];
                        })
                        this.$forceUpdate();
                    }
                }
            }
        }
    }
}
</script>

<style>

</style>
