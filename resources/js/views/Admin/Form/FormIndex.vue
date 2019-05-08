<template>
    <div class="animated fadeIn">
        <form-find></form-find>
        <h2>รายการแบบฟอร์ม</h2>
        <b-row>
            <form-cover form_id="1"></form-cover>
            <form-cover form_id="2"></form-cover>
        </b-row>
        <b-modal id="modalNewForm"
            ref="modalNewForm"
            size="xl"
            @hide-header="true" hideFooter
            no-close-on-backdrop
            no-close-on-esc>
            <form-detail></form-detail>
        </b-modal>
        <b-modal id="modalRule"
            ref="modalRule"
            size="lg"
            @hide-header="true" hideFooter
            no-close-on-backdrop
            no-close-on-esc>
            <h2>Modal Rule</h2>
        </b-modal>
    </div>

</template>
<script>
export default {
    data(){
        return{
            id: 1,
            form_id: 0
        }
    }
}
</script>
<style scoped>
.btnAdd{
    border-radius: 50%;
    width: 45px;
    height: 45px;
    padding: 0px;
    vertical-align: middle;
}
</style>
