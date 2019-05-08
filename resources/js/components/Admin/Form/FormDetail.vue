<template>
    <div class="animated fadeIn">
        <b-card>
            <div slot="header">
                <strong>รายละเอียดฟอร์ม</strong>
            </div>
            <b-form-group>
                <label for="formName1">ชื่อแบบฟอร์ม</label>
                <b-form-input type="text" id="formName1" placeholder="ชื่อแบบฟอร์ม" :value="form_id"></b-form-input>
            </b-form-group>
            <b-form-group>
                <label for="formName2">ชื่อแบบฟอร์ม เพิ่มเติม</label>
                <b-form-input type="text" id="formName2" placeholder="ชื่อแบบฟอร์ม เพิ่มเติม"></b-form-input>
            </b-form-group>
            <b-form-group>
                <label for="formName3">ชื่อแบบฟอร์ม เพิ่มเติม</label>
                <b-form-input type="text" id="formName3" placeholder="ชื่อแบบฟอร์ม เพิ่มเติม"></b-form-input>
            </b-form-group>
                <form-rule-list></form-rule-list>
                <b-button @click="showModal2">Open First Modal</b-button>
        </b-card>
    </div>
</template>
<script>
export default {
    props: ['form_id'],
    data(){
        return{

        }
    },
    methods: {
        showModal2(){

            //var modalName = 'modal-2'+this.form_id
            var modalName
            if (this.form_id == null ){
                modalName = 'modalRule'
            }else{
                modalName = 'modal-2'+this.form_id
            }
            this.$root.$emit('bv::show::modal',modalName);
        }
    }
}
</script>
