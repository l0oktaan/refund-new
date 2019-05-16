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
                    {{rules}}
                    <b-table :items="rules" :fields="tableFileds" striped >
                        <template slot="show" slot-scope="row">
                            {{ row }}
                        </template>
                        <template slot="manage" slot-scope="row">
                            <b-button size="sm" @click="row.toggleDetails" class="mr-2">
                            {{ row.detailsShowing ? 'Hide' : 'Show'}} Details
                            </b-button>

                            <!-- As `row.showDetails` is one-way, we call the toggleDetails function on @change -->
                            <b-form-checkbox v-model="row.detailsShowing" @change="row.toggleDetails">
                            Details via check
                            </b-form-checkbox>
                        </template>

                        <template slot="row-details" slot-scope="row">
                            <b-card>
                            <b-row class="mb-2">
                                <b-col sm="3" class="text-sm-right"><b>Age:</b></b-col>
                                <b-col>{{ row.order }}</b-col>
                            </b-row>

                            <b-row class="mb-2">
                                <b-col sm="3" class="text-sm-right"><b>Is Active:</b></b-col>
                                <b-col>{{ row.name }}</b-col>
                            </b-row>

                            <b-button size="sm" @click="row.toggleDetails">Hide Details</b-button>
                            </b-card>
                        </template>
                    </b-table>
                    <!--b-table striped hover :items="rules" :fields="tableFileds">
                        <template slot="index" slot-scope="data">
                            {{ data.index + 1 }}
                        </template>
                        <template slot="show_details" slot-scope="row">
                            <b-button size="sm" @click="row.toggleDetails" class="mr-2">
                            {{ row.detailsShowing ? 'Hide' : 'Show'}} Details
                            </b-button>




                        </template>

                        <template slot="manage" slot-scope="data">
                            <div>
                                <b-button variant="success" class="btn-square btn-sm" @click="editRule(data.item.id)"><i class="fas fa-edit"></i></b-button>
                                <b-button variant="danger" class="btn-square btn-sm"><i class="fas fa-trash"></i></b-button>
                            </div>
                        </template>
                        <template slot="condition" slot-scope="data">
                            <b-button block variant="primary" class="btn-square btn-sm" v-if="data.item.rule_type!=1"><i class="far fa-check-circle"></i>&nbsp;เงื่อนไข</b-button>
                        </template>
                    </b-table-->

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
        tableFileds: [
            {key:'show',label: 'Show'},
            {key:'order', label: 'ลำดับ'},
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
            var path = `/api/forms/${this.form_id}/form_rules?sub_of=0`;
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
        getSubRule(r_id){
            var path = `/api/forms/${this.form_id}/form_rules?sub_of=${r_id}`;
            var sub_rule = [];
            console.log('path :' + path);
            axios.get(path)
            .then(response=>{
                sub_rule = response.data.data;
                return sub_rule;
            })
            .catch(error=>{

            })
        },
        showDetail(row){
            row._showDetails = "true";
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
