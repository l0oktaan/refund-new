<template>
    <!-- <b-button variant="outline-primary" @click="loadReport"><i class="fas fa-file-download fa-2x"></i></b-button> -->
    <div class="book">
        <div class="page">
            <div class="subpage">
                <b-row>
                    <b-col cols="12">{{form.name1}}</b-col>
                </b-row>
                <b-row>
                    <b-col cols="12">{{form.name2}}</b-col>
                </b-row>
            </div>
        </div>
        <div class="page">
            <div class="subpage">Page 2/2</div>
        </div>
    </div>
</template>

<script>
import jsPDF from 'jspdf'
export default {
    props: ['refund_id','refund_form_id'],
    data(){
        return{
            refund : {},
            office_id: 2,
            obj: {
                'id' : 1111,
                'form' : {
                    'id' : 'f_111',
                    'name' : 'form 1'
                }
            }
        }
    },
    mounted(){
        this.getRefund();
    },
    computed: {
        form(){
            return this.refund.form;
        }
    },
    methods: {
        loadReport(){
            let pdfName = 'test';
            var doc = new jsPDF();
            doc.setFont('Trirong');
            doc.text("ทดสอบ", 10, 10);
            doc.save(pdfName + '.pdf');
        },
        getRefund(){
            var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${this.refund_form_id}`;
            axios.get(`${path}`)
            .then(response=>{
                this.refund = _.cloneDeep(response.data.data);
            })
            .catch(error=>{

            })
        }
    }
}
</script>

<style scoped>
.page {
        width: 297mm;
        height: 210mm;
        padding: 5mm;
        margin: 10mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}
.subpage {
    padding: 5mm;
    border: 5px red solid;
    height: 195mm;
    outline: 5mm #FFEAEA solid;
}

@page {
    size: A4;
    margin: 0;
}
</style>
