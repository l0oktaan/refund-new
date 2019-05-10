<template>
    <div class="animated fadeIn">
        <div class="text-right">
            <b-button variant="outline-success" @click="showModal">
                <i class="fas fa-plus-circle fa-2x"></i>&nbsp;<span>เพิ่มแบบฟอร์ม</span>
            </b-button>
            <b-button variant="outline-primary" @click="show">
                <i class="fas fa-search fa-2x"></i>&nbsp;<span>ค้นหา</span>
            </b-button>
            <my-alert :AlertType="alert"></my-alert>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            alert: ''
        }
    },
    methods: {
        showModal(){
            this.$root.$emit('bv::show::modal','modalNewForm')
        },
        show(){
            this.alert = "success"
        }
    }
}
</script>

<style scoped>
.btn{
    padding-top: 15px!important;
    padding-bottom: 15px!important;
}
i{
    vertical-align: middle!important;
}
</style>
