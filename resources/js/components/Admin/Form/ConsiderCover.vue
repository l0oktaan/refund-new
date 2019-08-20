<template>
    <div class="animated fadeIn">

        <b-card class="bg-primary" v-for="(consider,index) in arr_considers" :key="index">
            <b-card-body class="pb-0">
                <b-dropdown class="float-right" style="color: #000!important;" variant="transparent p-0" right>
                <template slot="button-content">
                    <i class="icon-settings sub_rule"></i>
                </template>
                    <b-dropdown-item @click="toEdit(consider)"><i class="fas fa-link"></i>&nbsp;แก้ไข</b-dropdown-item>
                    <b-dropdown-item @click="delConsider(consider.id,consider.form_rule_id)"><i class="fas fa-trash"></i>&nbsp;ลบ</b-dropdown-item>
                </b-dropdown>
                <b-row>
                    <b-col sm="6">
                        <div class="textFiled">เงื่อนไข :{{consider.name}}</div>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>
<script>
export default{
    props: ['form_id','considers'],
    data(){
        return {
            arr_considers: [],
        }

    },
    methods: {
        delConsider(id,form_rule_id){
            this.$swal({
                    title: "กรุณายืนยันการลบเงื่อนไข",
                    text: "คุณต้องการลบเงื่อนไขนี้ใช่หรือไม่",
                    icon: "error",
                    closeOnClickOutside: false,
                    buttons: [
                        'ยกเลิก',
                        'ยืนยัน'
                    ],

                }).then(isConfirm =>{
                    if (isConfirm){
                        let path = `/api/forms/${this.form_id}/form_rules/${form_rule_id}/form_considers/${id}`;
                        axios.delete(path)
                        .then(response=>{
                            this.$emit('fetchConsider');
                            this.$parent.alert = 'success';
                        })
                    }
                });
        },
        toEdit(consider){
            this.$emit('toEdit',consider);
        }
    },
    watch: {
        considers(){
            this.arr_considers = this.considers;
            this.$forceUpdate();
        }
    },
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
