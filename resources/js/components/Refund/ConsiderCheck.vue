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


                <b-badge variant="default" pill>

                    <toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                        :labels="{checked: 'ใช่', unchecked: 'ไม่ใช่'}"
                        :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                        style="padding-top:4px; line-height:0px;"
                        v-if="consider.type == 1"
                        v-model="considers[find_consider_index(consider.id)]['var1']"
                    />
                    <b-form-input type="text" v-else-if="consider.type == 2" v-model="considers[find_consider_index(consider.id)]['var2']"></b-form-input>
                    <a-date-picker v-else-if="consider.type == 3" />

                </b-badge>



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
                         <b-badge variant="default" pill>
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
                            <a-date-picker v-else-if="consider.type == 3" />

                        </b-badge>
                    </b-list-group-item>

                </b-list-group>
            </b-card>
            <p>{{iRule}}</p>
            <p>{{considers}}</p>


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
.helpIcon{
    color:#ffc107;
}
.rule_name{
    margin: 5px!important;
    padding: 5px!important;
    background-color: #a2d4ff;
}
.rule_name>b{
    margin-left: 10px!important;
}
.tabTitle{
    font-size: 1rem;
    font-weight: bold;
}
.nav-link{
    padding-top: 10px!important;
}
.sub_rule{
    margin: 0px!important;
    border-bottom: 0px!important;
    border-left: 0px!important;
    border-right: 0px!important;

}
.sub_rule_name{
    padding-top: 2px !important;
    padding-bottom: 2px !important;
    padding-left: 10px!important;
}
.card-header{
    padding: 0px!important;
    background-color: #8bacc9;
}
</style>
