<template>
    <div class="animated fadeIn">
        <b-card>
            <div slot="header">
                <strong>รายละเอียดฟอร์ม</strong>
            </div>
            <b-form @submit="onSubmit">
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
                <div class="text-center">
                    <b-button type="submit" variant="primary">บันทึกข้อมูล</b-button>
                    <b-button type="reset" variant="danger">ยกเลิก</b-button>
                </div>

            </b-form>
            <form-rule-list></form-rule-list>



        </b-card>
    </div>
</template>
<script>
export default {
    props: ['form_id'],
    data(){
        return{
            status: "new"
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
                this.status = "edit"
            }
            this.$root.$emit('bv::show::modal',modalName);
        },
        onSubmit(e){
            e.preventDefault()
        }
    }
}
</script>
