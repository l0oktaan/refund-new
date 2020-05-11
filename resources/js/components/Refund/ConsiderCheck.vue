<template>
<div class="animated fadeIn">

    <b-row>
        <b-col cols="12">
            <div class="brand-card">
                <div class="brand-card-body">
                    <div class="p-2" style="max-width:15%" align-v="center">
                        <span class="align-middle consider_head">เงื่อนไข </span>
                    </div>
                    <div class="p-2 pl-4 mr-3 float-left text-left">
                        <span class="align-middle">{{consider.name}}</span>
                        <span class="helpIcon align-middle">
                            <i class="fas fa-question-circle fa-2x"
                                :id="`exPopover1-${consider.id}`"
                                v-if="description(consider.description)"
                                @click="showDesc = true"
                                style="cursor: pointer">
                            </i>
                        </span>
                        <b-popover :target="`exPopover1-${consider.id}`"
                                    placement="topright"
                                    triggers="hover focus"
                                    content="ดูคำอธิบาย"
                                    v-if="description(consider.description)"
                                    >
                        </b-popover>
                        <b-alert v-if="description(consider.description)"
                            variant="info"
                            dismissible
                            fade
                            :show="showDesc"
                            @dismissed="showDesc = false"
                            >
                            <h6>คำอธิบาย</h6>
                            <span>{{consider.description}}</span>
                        </b-alert>
                    </div>
                    <div class="p-2" style="max-width:30%">

                            <slot></slot>

                    </div>
                </div>
            </div>

        </b-col>

    </b-row>
        <!-- <b-list-group flush v-if="consider">
            <b-list-group-item class="d-flex justify-content-between align-items-center">
               <div>
                    <b>เงื่อนไข : </b>{{consider.name}}
                    <span class="helpIcon">
                        <i class="fas fa-question-circle fa-2x"
                            :id="`exPopover1-${consider.id}`"
                            v-if="description(consider.description)"
                            @click="showDesc = true"
                            style="cursor: pointer">
                        </i>
                    </span>
                    <b-popover :target="`exPopover1-${consider.id}`"
                                placement="topright"
                                triggers="hover focus"
                                content="ดูคำอธิบาย"
                                v-if="description(consider.description)"
                                >
                    </b-popover>
                    <b-alert v-if="description(consider.description)"
                        variant="info"
                        dismissible
                        fade
                        :show="showDesc"
                        @dismissed="showDesc = false"
                        >
                        <h6>คำอธิบาย</h6>
                        <span>{{consider.description}}</span>
                    </b-alert>
                </div>


                <div variant="default" pill>
                    <slot></slot>
                </div>
            </b-list-group-item>
        </b-list-group> -->
</div>
</template>

<script>
export default {
    props: ['rule','consider'],
    data(){
        return {
            iRule: {},
            //considers: [],
            state: 'new',
            refund_form_id: this.$route.params.id,
            date_show: '',
            date_show_sub: '',
            myCheck: {},
            showDesc: true
        }
    },

    watch: {
        // iRule(){
        //     this.getConsider();
        //     this.$forceUpdate();
        // }
    },
    mounted(){
        //  this.iRule = this.rule;
        //  this.$emit('ready', {considers: this.considers});
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
.list-group-item{
    padding: 5px!important;
}
.helpIcon{
    color: rgb(46, 158, 158);
}
.alert{
    margin-bottom: 2px;
}
.detail{
    padding: 10px!important;
}
.brand-card{
    margin-bottom: 5px!important;
    border-width: 0px;
    background: transparent!important;

}
.consider_head{
    font-size: 1.1em;
    font-weight: bold;
}
</style>
