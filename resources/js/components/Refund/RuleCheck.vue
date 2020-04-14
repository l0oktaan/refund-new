<template>
    <div class="animated fadeIn">
        <b-form  @submit.stop.prevent="passes(onSubmit)">
            <b-row>
                <b-col>
                    {{results}}
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
                            <div>


                                    <toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                                        v-if="consider.type == 1"
                                        :labels="{checked: 'ใช่', unchecked: 'ไม่ใช่'}"
                                        :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                                        style="padding-top:4px; line-height:0px;"


                                    />
                                    <!-- <b-form-input type="text"
                                        v-if="fine_result_type(consider.id) == 'number' || fine_result_type(consider.id) == 'value'"
                                        v-model="results[find_detail_index(consider.id)]['value']"
                                    ></b-form-input> -->
                                    <!-- <my-date-picker
                                        v-if="fine_result_type(consider.id) == 'date'"
                                        :ref="'c_date_' + consider.id" :id="'d121'"
                                        :showDate="date_show[date_show.findIndex(i=>i.consider_id==consider.id)]['show']"
                                        @update="value => results[find_detail_index(consider.id)]['value'] = value"
                                    ></my-date-picker> -->

                            </div>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
            <b-row v-else>
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
                                    <div>
                                        {{consider.detail}}
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
    created(){
        if (this.rule){
            this.i_rule = this.rule;
        }

    },
    watch: {
        i_rule(){
            console.log('check rule');
            this.results = [];
            if (this.rule.sub_rules.length == 0){
                for (let j = 0; j < rule.considers.length; j++){
                    let result = {
                        id : rule.considers[j].id,
                        // value : this.detail[this.detail.findIndex(x=>x.id == rule.considers[j].id)]['value'],
                        // status : this.detail[this.detail.findIndex(x=>x.id == rule.considers[j].id)]['status'],
                    }
                    this.results.push(result);
                }
            }
        }
    }
}
</script>

<style>

</style>
