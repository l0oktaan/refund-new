<template>
    <div class="animated fadeIn">
        <div>
            <b-card no-body class="bg-primary">
                <b-card-body class="pb-0">

                    <b-dropdown class="float-right" variant="transparent p-0" right>
                    <template slot="button-content">
                        <i class="icon-settings"></i>
                    </template>
                        <b-dropdown-item @click="addSubRule(rule.id)"><i class="fas fa-plus"></i>&nbsp;เพิ่มหลักเกณฑ์ย่อย</b-dropdown-item>
                        <b-dropdown-item @click="editRule"><i class="fas fa-edit"></i>&nbsp;แก้ไขหลักเกณฑ์</b-dropdown-item>
                        <!--b-dropdown-item @click="showCondition(rule.id)" v-if="rule.sub_rules.length == 0"><i class="fas fa-link"></i>&nbsp;ข้อมูลเงื่อนไข</b-dropdown-item-->
                        <b-dropdown-item @click="delRule(rule.id)"><i class="fas fa-trash"></i>&nbsp;ลบหลักเกณฑ์</b-dropdown-item>
                    </b-dropdown>
                    <b-form-group label="ตัวเลือกหลักเกณฑ์ย่อย" v-if="rule.sub_rules.length > 1" class="float-right">
                        <b-form-radio-group
                            id="btn-radios-2"
                            v-model="result_type"
                            :options="arrResultType"
                            buttons
                            button-variant="outline-warning"
                            name="radio-btn-outline"
                        ></b-form-radio-group>
                    </b-form-group>
                    <b-row>
                        <b-col sm="1">
                            <div class="showSub" :class="{noSub: rule.sub_rules.length == 0}" @click="showSub = !showSub">
                                <i class="fa fa-arrow-circle-right fa-lg mt-4" v-if="!showSub"></i>
                                <i class="fa fa-arrow-circle-down fa-lg mt-4" v-if="showSub"></i>
                            </div>
                        </b-col>
                        <b-col>
                            <h4 class="mb-0">ลำดับที่ :{{rule.order}}</h4>
                            <p>{{rule.name}}</p>

                        </b-col>
                    </b-row>

                </b-card-body>
            </b-card>
            <div class="animated fadeIn" v-if="showSub">
                <b-card no-body class="bg-default sub_rule" v-for="sub_rule in rule.sub_rules" :key="sub_rule.id">
                <b-card-body class="pb-0 sub_rule">
                    <b-dropdown class="float-right" style="color: #000!important;" variant="transparent p-0" right>
                    <template slot="button-content">
                        <i class="icon-settings sub_rule"></i>
                    </template>
                        <b-dropdown-item @click="editSubRule(sub_rule.id,sub_rule.sub_of)"><i class="fas fa-edit"></i>&nbsp;แก้ไขหลักเกณฑ์ย่อย</b-dropdown-item>
                        <!--b-dropdown-item @click="showCondition(sub_rule.id)"><i class="fas fa-link"></i>&nbsp;ข้อมูลเงื่อนไข</b-dropdown-item-->
                        <b-dropdown-item @click="delRule(sub_rule.id)"><i class="fas fa-trash"></i>&nbsp;ลบหลักเกณฑ์ย่อย</b-dropdown-item>
                    </b-dropdown>
                    <b-row>
                        <b-col sm="1">

                        </b-col>
                        <b-col>
                            <h5 class="mb-0">เกณฑ์ย่อย ลำดับที่ :{{sub_rule.order}}</h5>
                            <p>{{sub_rule.name}}</p>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>
            </div>
            <b-modal id="modalCondition"
                ref="modalCondition"
                    size="lg"
                    hide-header hideFooter
                    no-close-on-backdrop
                    no-close-on-esc
                    @hidden="resetModalRule"
                    >
                    <rule-condition
                        :form_id = "form_id"
                        :rule_id = "c_rule_id"

                    ></rule-condition>
            </b-modal>
        </div>

    </div>
</template>
<script>

export default {
    props: ['form_id','rule'],
    data(){
        return {
            showSub: false,
            sub_rules: [],
            iRule: {},
            arrResultType: [
                {value : 1, text: 'หรือ'},
                {value : 2, text: 'และ'}
            ],
            result_type: 0,

            condition: [],
            c_rule_id: 0
        }
    },
    watch: {
        rule(){
            this.result_type = this.rule.result_type;
        },
        result_type(){
            if (this.result_type != 0){
                //console.log('rule id: '+ this.rule.id + 'change to' + this.result_type);
                this.updateResultType();
            }
        }
    },
    mounted(){
        // this.iRule = this.rule;
        // this.getSubRule();
        // this.$forceUpdate();
        //this.sub_rules = this.rule.sub_rules;
        this.result_type = this.rule.result_type;
        this.getSubRule();
        this.$forceUpdate();
    },
    methods: {
        updateResultType(){
            var path =`/api/forms/${this.form_id}/form_rules/${this.rule.id}`;
            axios.put(path,{
                name: this.rule.name,
                order: this.rule.order,
                rule_type: this.rule.rule_type,
                result_type: this.result_type,
                status: this.rule.status
            })
            .then(response=>{

            })

        },
        showRule(){

        },
        getSubRule(){
            var path = '';
            var id = 0;
            this.sub_rules = [];


            id = this.rule.id;
            path = `/api/forms/${this.form_id}/form_rules?sub_of=${id}`;

            axios.get(path)
            .then(response=>{
                this.sub_rules = response.data.data;

                this.$forceUpdate();
            })
            .catch(error=>{

            })

        },
        editRule(){
            this.$emit('editRule',{id: this.rule.id, sub_of: this.rule.sub_of});

        },
        editSubRule(id,sub_of){
            this.$emit('editRule',{id: id, sub_of: sub_of});

        },
        addSubRule(sub_of){
            this.$emit('addSubRule',sub_of);
        },
        showCondition(rule_id){
            this.c_rule_id = rule_id;
            this.$refs['modalCondition'].show();
        },
        delRule(id){
            this.$swal({
                    title: "กรุณายืนยันการลบหลักเกณฑ์",
                    text: "หากยืนยันการลบ หลักเกณฑ์ย่อยและเงื่อนไขจะถูกลบไปด้วย",
                    icon: "error",
                    closeOnClickOutside: false,
                    buttons: [
                        'ยกเลิก',
                        'ยืนยัน'
                    ],

                }).then(isConfirm =>{
                    if (isConfirm){
                        let path = `/api/forms/${this.form_id}/form_rules/${id}`;
                        axios.delete(path)
                        .then(response=>{
                            this.$emit('fetchRule');
                        })
                    }

                });
        },
        resetModalRule(){
            this.c_rule_id = 0;
        }
    }
}
</script>
<style scoped>
.btn{
    padding-left: 15px!important;
    padding-right: 15px!important;

}
.bg-primary{
    background-color: #20a8d8 !important;
}
.bg-default{
    color: #000!important;
}
.card-body{
    color: #fff!important;
}
.sub_rule{
    color: #000!important;
}
.card{
    margin: 10px!important;
}
.dropdown-item>i{
    color: #000!important;
}
.showSub{
    cursor: pointer;
}
.noSub{
    color: rgb(97, 97, 97)!important;
    cursor: default;
}
.float-right{
    margin-right: 5px;
}
</style>
