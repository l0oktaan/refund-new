<template>
<div class="animated fadeIn">
        <b-list-group flush>
            <b-list-group-item v-for="consider in iRule.considers" :key="consider.id" class="d-flex justify-content-between align-items-center">
                <div>
                    <b>เงื่อนไข : </b>{{consider.name}}
                    <span class="helpIcon">
                        <i class="fas fa-question-circle fa-2x"
                            :id="`exPopover1-${consider.id}`"
                            v-if="description(consider.description)">
                        </i>
                    </span>
                    <b-popover :target="`exPopover1-${consider.id}`"
                                placement="topright"
                                title="คำอธิบายเพิ่มเติม"
                                triggers="hover focus"
                                :content="`${consider.description}`"
                                v-if="description(consider.description)">
                    </b-popover>
                </div>


                <div variant="default" pill>
                    <toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                        :labels="{checked: 'ใช่', unchecked: 'ไม่ใช่'}"
                        :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                        style="padding-top:4px; line-height:0px;"
                        v-if="consider.type == 1"
                        v-model="considers[find_consider_index(consider.id)]['var1']"
                    />
                    <b-form-input type="text" v-else-if="consider.type == 2" v-model="considers[find_consider_index(consider.id)]['var2']"></b-form-input>
                    <my-date-picker
                        v-else-if="consider.type == 3 && consider.oper > 1"
                        ref="r_date" :id="'d11' + index"
                        :showDate="date_show" @update="value => considers[find_consider_index(consider.id)]['result'] = value"
                    ></my-date-picker>
                </div>
            </b-list-group-item>

        </b-list-group>

        <b-card no-body class="sub_rule" v-for="(sub_rule,index) in iRule.sub_rules" :key="index" >

            <b-list-group flush>
                <b-list-group-item v-for="consider in sub_rule.considers" :key="consider.id" class="d-flex justify-content-between align-items-center">
                    <div>
                        <b>เงื่อนไข : </b>{{consider.name}}
                        <span class="helpIcon">
                        <i class="fas fa-question-circle fa-2x"
                            :id="`exPopover1-${consider.id}`"
                            v-if="description(consider.description)">
                        </i>
                        </span>
                        <b-popover :target="`exPopover1-${consider.id}`"
                                    placement="topright"
                                    title="คำอธิบายเพิ่มเติม"
                                    triggers="hover focus"
                                    :content="`${consider.description}`"
                                    v-if="description(consider.description)">
                        </b-popover>

                    </div>
                        <div variant="default" pill>
                            <toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                            :labels="{checked: 'ใช่', unchecked: 'ไม่ใช่'}"
                            :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                            style="padding-top:4px; line-height:0px;"
                            v-if="consider.type == 1"
                            v-model="considers[find_consider_index(consider.id)]['var1']"
                        />
                        <b-form-input type="text"
                            v-else-if="consider.type == 2"
                            v-model="considers[find_consider_index(consider.id)]['var2']">
                        </b-form-input>
                        <my-date-picker
                            v-else-if="consider.type == 3 && consider.oper > 1"
                            :ref="'approve_date' + index" :id="'d12' + index"
                            :showDate="date_show" @update="value =>considers[find_consider_index(consider.id)]['result'] = value">
                        </my-date-picker>
                    </div>
                </b-list-group-item>

            </b-list-group>
        </b-card>



</div>
</template>

<script>
export default {
    props: ['rule'],
    data(){
        return {
            iRule: {},
            considers: [],
            state: 'new',
            refund_form_id: this.$route.params.id,
            date_show: '',
            date_show_sub: '',
            myCheck: {}
        }
    },
    watch: {
        iRule(){
            this.getConsider();
            this.$forceUpdate();
        }
    },
    mounted(){

         this.iRule = this.rule;
         this.$emit('ready', {considers: this.considers});

    },
    methods : {
        find_consider_index(id){
            //console.log('Find Consider : ' + id);
            return this.considers.findIndex(i => i.consider_id === id);
        },
        description(value){
            if (value == '' || value === null){
                return false;
            }else{
                return true;
            }
        },
        initConsider(rule_id,consider_id){
            this.considers.push({
                refund_form_id: this.refund_form_id,
                rule_id: rule_id,
                consider_id: consider_id,
                var1: false,
                var2: 'var2',
                var3: '',
                result: false
            })
        },
        getConsider(){
            var arr = [];
            var sub_rules = this.iRule.sub_rules;
            var consider = []
            if (this.state == 'new'){
                //console.log('subrules ' + sub_rules.length);
                if (sub_rules.length > 0){
                    for (let i = 0 ; i < sub_rules.length ; i++){
                        //console.log('subrules ' + sub_rules[i].name);

                        if (sub_rules[i].considers.length > 0){
                            for (let j = 0 ; j < sub_rules[i].considers.length ; j++){
                                this.initConsider(sub_rules[i].id,sub_rules[i].considers[j].id)
                            }
                        }else{
                            this.initConsider(sub_rules[i].id,sub_rules[i].considers.id)
                        }
                    }
                }else{
                    if (this.iRule.considers.length > 0){
                        for (let j = 0 ; j < this.iRule.considers.length ; j++){
                            this.initConsider(this.iRule.id, this.iRule.considers[j].id)
                        }
                    }else{
                        this.initConsider(this.iRule.id, this.iRule.considers.id)
                    }
                }
                //this.considers = consider;
                this.createRefundDetail();
            }else if (this.state == 'update'){

            }
            console.log('consider : ' + consider.length);
        },
        createRefundDetail(){

        },
        getValue(){
            return this.considers;
        }
    }
}
</script>

<style scoped>

</style>
