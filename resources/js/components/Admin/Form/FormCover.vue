<template>
    <b-col sm="12" md="6">
        <transition name="fade">
            <b-card no-body class="bg-primary">
            <b-card-body class="pb-0">
                <b-dropdown class="float-right" variant="transparent p-0" right>
                <template slot="button-content">
                    <i class="icon-settings"></i>
                </template>
                <b-dropdown-item><i class="fas fa-align-justify"></i>&nbsp;แสดงแบบฟอร์ม</b-dropdown-item>
                <b-dropdown-item @click="showForm"><i class="fas fa-edit"></i>&nbsp;แก้ไขแบบฟอร์ม</b-dropdown-item>
                <b-dropdown-item><i class="fas fa-trash"></i>&nbsp;ลบแบบฟอร์ม</b-dropdown-item>
                </b-dropdown>
                <h4 class="mb-0">ฟอร์มหมายเลข {{form_id}}</h4>
                <p>ฟอร์มการถอนคืนเงินรายได้แผ่นดินหมายเลข {{form_id}}</p>

            </b-card-body>

            </b-card>
            <!-- <b-card class="bg-default" no-body v-if="show">
                <div slot="header">
                    แบบฟอร์ม หมายเลข 1
                    <div class="card-header-actions">
                    <b-link href="#" class="card-header-action btn-setting">
                        <i class="icon-settings"></i>
                    </b-link>
                    <b-link class="card-header-action btn-minimize" v-b-toggle.collapse1>
                        <i class="icon-arrow-up"></i>
                    </b-link>
                    <b-link href="#" class="card-header-action btn-close" v-on:click="show = !show">
                        <i class="icon-close"></i>
                    </b-link>
                    </div>
                </div>
                <b-collapse id="collapse1" visible>
                    <b-card-body>
                        <div>
                            <span>ชื่อฟอร์ม :</span>
                        </div>
                        <div>
                            <span>ชื่อฟอร์ม :</span>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-outline-primary btn-sm"><i class="fas fa-align-justify"></i>&nbsp;แสดงฟอร์ม</button>
                            <button type="button" v-b-modal.modal-1 class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i>&nbsp;แก้ไข</button>
                            <button type="button" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i>&nbsp;ลบฟอร์ม</button>
                        </div>
                    </b-card-body>
                </b-collapse>
            </b-card> -->

        </transition>
        <b-modal :id="'modal-1' + form_id"
            :ref="'modal-1' + form_id"
            size="xl"
            @hide-header="true" hideFooter
            no-close-on-backdrop
            no-close-on-esc>
            <form-detail :form_id="form_id"></form-detail>
        </b-modal>
        <b-modal :id="'modal-2' + form_id"
            :ref="'modal-2' + form_id"
            size="lg"
            @hide-header="true" hideFooter
            no-close-on-backdrop
            no-close-on-esc>
            <h2>Modal {{form_id}}</h2>
        </b-modal>
    </b-col>

</template>
<script>
export default {
    props : ['form_id'],
    data(){
        return {
            show: true
        }
    },
    methods: {
        showForm(){
            var modalName = 'modal-1' + this.form_id;
            this.$refs[modalName].show()
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
.card-body{
    color: #fff!important;
}
.dropdown-item>i{
    color: #000!important;
}
</style>
