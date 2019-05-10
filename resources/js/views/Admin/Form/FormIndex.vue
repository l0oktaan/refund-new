<template>
    <div class="animated fadeIn">
        <form-find></form-find>
        <h2 @click="showForm">รายการแบบฟอร์ม</h2>
        <b-row>
            <form-cover @onShowForm = "showForm" v-for="form in forms" :key="form.id" :form_id="form.id"></form-cover>

        </b-row>
        <b-modal id="modalForm"
            ref="modalForm"
            size="xl"
            @hide-header="true" hideFooter
            no-close-on-backdrop
            no-close-on-esc
            @hidden="resetModalForm">
            <form-detail :form_id="form_id"></form-detail>
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
            form_id: 0,
            forms : []
        }
    },
    methods: {
        showForm(id){
            console.log('show :' + id);
            this.form_id = id;
            this.$refs['modalForm'].show();
        },
        resetModalForm(){
            this.form_id = 0;
        },
        fetchData(){
            axios.get('/api/forms')
            .then(response=>{
                this.forms = response.data.data;
                console.log(this.forms);
            })
        }
    },
    mounted(){
        this.fetchData();
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
