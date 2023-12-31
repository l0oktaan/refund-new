<template>
    <div>
       <b-tabs active-tab-class="tab-active">
            <!--================================= Tab Form ==================================-->
            <b-tab>
                <template slot="title">
                    <h6>เลือกหน่วยงาน</h6>
                    <span></span>
                </template>
                <b-form-group>
                    <label for="time_edit_date">หน่วยงาน<span class="require">*</span></label>
                    <b-input-group>
                        <b-form-input
                            list="my-list-id"
                            v-model="office"
                            :required="true"

                        >
                        </b-form-input>
                        <b-input-group-append class="btnClear" @click="clear_office">
                            <b-input-group-text>
                                <b-icon icon="x" />
                            </b-input-group-text>
                        </b-input-group-append>
                        <datalist id="my-list-id">
                            <option v-for="(item,index) in offices" :key="index" :value="item.name"></option>
                        </datalist>
                    </b-input-group>
                </b-form-group>
            </b-tab>
            <b-tab :disabled="false">
                <template slot="title">
                    <h6>รายการสัญญา</h6>
                    <span></span>

                </template>
                <contract-list :office="office" :office_id="office_id"></contract-list>
            </b-tab>
       </b-tabs>
    </div>
</template>
<script>
export default{
    data(){
        return {
            office: null,
            office_id: null,
            offices: []
        }
    },
    watch: {
        'office' : function (newValue,oldValue){
                if (newValue == oldValue){
                    return;
                }
                this.office_id = newValue ? this.offices.find(x=>x.name == newValue).id : null
            },
    },
    mounted(){
        this.getOffice();
    },
    methods:{
        async getOffice(){
            let path = await '/api/offices';
            let response = await axios.get(path);
            this.offices = response.data.data;

        },
        clear_office(){

            this.office = null;
        },
    }
}
</script>
<style scoped>
.content{
    width: 100%;
    display: flex;
    justify-content: right;
    align-items: flex-start;
    flex-direction: column;
}
.form{
    display: block;
    width: 550px;
    align-self: center;
}
.col_name{
    text-align: right;
}
.row{
    margin-top: 5px;
}
.btnClear{
    cursor: pointer;
}
</style>
