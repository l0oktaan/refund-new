<template>
<div class="animated fadeIn">

        <div class="rule_name" slot="header"><b>หลักเกณฑ์ {{rule.order}}.</b><b>{{rule.name}}</b></div>
        <b-list-group flush>
            <b-list-group-item v-for="consider in rule.considers" :key="consider.id">
                <b-row>
                    <b-col cols="6">
                        <b>เงื่อนไข : </b>{{consider.name}} {{consider.description}}
                        <i class="fas fa-question-circle fa-2x" v-if="description(consider.description)"></i>
                    </b-col>
                    <b-col cols="6">
                        <toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                            :labels="{checked: 'ใช่', unchecked: 'ไม่ใช่'}"
                            :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                            style="padding-top:4px; line-height:0px;"


                            v-if="consider.type == 1"
                        />
                        <a-date-picker v-if="consider.type == 3" />
                    </b-col>
                </b-row>

            </b-list-group-item>

        </b-list-group>


</div>
</template>

<script>
export default {
    props: ['rule'],
    data(){
        return {
            iRule: {}
        }
    },
    methods : {
        description(value){
            if (value == '' || value === null){
                return false;
            }else{
                return true;
            }
        }
    }
}
</script>

<style scoped>

.rule_name{
    margin: 5px!important;
    padding: 5px!important;
}
.rule_name>b{
    margin-left: 10px!important;
}
</style>
