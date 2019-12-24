<template>
    <b-button variant="outline-primary" @click="loadReport"><i class="fas fa-file-download fa-2x"></i></b-button>

</template>

<script>
import jsPDF from 'jspdf'
export default {
    data(){
        return{

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
        }
    }
}
</script>

<style>

</style>
