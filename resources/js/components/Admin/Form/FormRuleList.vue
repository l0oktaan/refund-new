<template>
    <div class="animated fadeIn">
        <b-row>
             <b-col>
                 <b-card>
                     <div slot="header" class="navbar">
                         <ul class="nav navbar-nav d-md-down-none">
                            <li class="nav-item px-3">
                                <i class='fa fa-align-justify'></i>
                                    หลักเกณฑ์เงื่อนไข
                            </li>
                        </ul>
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item px-3">
                                <b-button variant="outline-success" @click="addRule">
                                    <i class="fas fa-plus-circle fa-2x"></i>&nbsp;<span>เพิ่มหลักเกณฑ์</span>
                                </b-button>
                            </li>
                        </ul>
                    </div>
                    <b-table striped hover :items="rules" :fields="tableFileds">
                        <template slot="index" slot-scope="data">
                            {{ data.index + 1 }}
                        </template>
                        <template slot="manage" slot-scope="data">
                            <div>
                                <b-button variant="success" class="btn-square btn-sm" @click="editRule(data.item.id)"><i class="fas fa-edit"></i></b-button>
                                <b-button variant="danger" class="btn-square btn-sm"><i class="fas fa-trash"></i></b-button>
                            </div>
                        </template>
                        <template slot="condition" >
                            <b-button block variant="primary" class="btn-square btn-sm"><i class="far fa-check-circle"></i>&nbsp;เงื่อนไข</b-button>
                        </template>
                    </b-table>
                 </b-card>
            </b-col>
        </b-row>
        <b-modal id="modalRule"
            ref="modalRule"
            size="lg"
            hide-header hideFooter
            no-close-on-backdrop
            no-close-on-esc
            @hidden="resetModalRule"
            >
            <form-rule
                :form_id = "form_id"
                :rule_id = "rule_id"
            ></form-rule>
        </b-modal>
    </div>
</template>
<script>

export default {
    props : ['form_id'],
    data() {
      return {
        // Note `isActive` is left out and will not appear in the rendered table
        tableFileds: [{key:'order', label: 'ลำดับ'},
            {key:'name' ,label: 'ชื่อเกณฑ์'},
            {key:'manage', label:'จัดการ'},
            {key:'condition', label:'เงื่อนไข'}
        ],
        items: [],
        rules: [],
        fid: 0,
        rule_id: -1,
        rCount: 0
      }
    },
    mounted(){
        this.rules = [];
    },
    watch: {
        form_id(){
            this.fid = this.form_id;
            if (this.fid > 0){
                this.fetchData();
                console.log('get rule');
            }else{
                this.clearData();
            }
        }
    },
    methods: {
        fetchData(){
            var path = `/api/forms/${this.form_id}/form_rules`;
            console.log('path :' + path);
            axios.get(path)
            .then(response=>{
                this.rules = response.data.data;
                console.log('rule :' + this.rules);
            })
            .catch(error=>{
                console.log(error);
            })
        },
        clearData(){
            this.fid = -1;
            this.rules = [];
        },
        editRule(id){
            this.rule_id = id;
            this.$refs['modalRule'].show();
        },
        addRule(){
            this.rule_id = 0;
            this.$refs['modalRule'].show();
        },
        resetModalRule(){
            this.rule_id = -1;
            this.fetchData();
        }
    }
}
</script>
<style scoped>
.card-body{
    padding: 0px!important;
}
.btn{
    padding-top: 5px!important;
    padding-bottom: 5px!important;
    vertical-align: middle!important;
}
i{
    vertical-align: middle!important;
}
.card-header{
    padding: 5px!important;
}
</style>
