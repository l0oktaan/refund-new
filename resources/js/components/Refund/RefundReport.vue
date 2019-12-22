<template>
    <button class="btn btn-primary" @click="loadReport">Download PDF</button>
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