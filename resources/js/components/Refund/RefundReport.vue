<template>
    <b-button variant="outline-primary" @click="loadReport"><i class="fas fa-file-download fa-2x"></i></b-button>

</template>

<script>
import jsPDF from 'jspdf'
export default {
    props: ['refund_id','refund_form_id'],
    data(){
        return{
            refund : {}
        }
    },
    mounted(){

    },
    methods: {
        loadReport(){
            let pdfName = 'test';
            var doc = new jsPDF();
            doc.text("Refund Report", 10, 10);
            doc.save(pdfName + '.pdf');
        },
        getRefund(){
            var path = `/api/offices/${this.office_id}/refunds/${this.refuns_id}/refund_forms/${this.refund_form_id}`;
            axios.get(`${path}`)
            .then(response=>{
                this.refund = response.data.data;
            })
            .catch(error=>{

            })
        }
    }
}
</script>

<style>

</style>
