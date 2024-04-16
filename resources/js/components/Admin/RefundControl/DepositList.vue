<template>
    <div>
        <h5>ผลการค้นหารายการนำส่ง :</h5>
        <b-table striped hover :items="items" :fields="deposit_fields" sort-icon-left v-model="currentItems">
            <template #cell(ลำดับ)="data">
                {{ data.index + 1 }}
            </template>
            <template #cell(deposit_date)="data">
                {{ getThaiDate(data.value) }}
            </template>
            <template #cell(amount)="data">
                {{ data.value | numeral('0,0.00')}}
            </template>
        </b-table>
    </div>
</template>

<script>
export default {
    props: ['office','office_id'],
    data(){
        return {
            contract_new_id: null,
            showDeposit: false,
            showWithdraw: false,
            currentItems: [],
            deposit_fields:[
                'ลำดับ',
                {
                    key: 'deposit_office',
                    label: 'ชื่อหน่วยงาน / ชื่อผู้ประกอบการ',
                    sortable: true,
                    class: 'unit_name'
                    // Variant applies to the whole column, including the header and footer

                },
                {
                    key: 'deposit_no',
                    label: 'เลขที่นำส่งฯ',
                    sortable: true,
                    // Variant applies to the whole column, including the header and footer

                },
                {
                    key: 'deposit_date',
                    label: 'วันที่ผ่านรายการ',
                    sortable: true,
                    // Variant applies to the whole column, including the header and footer

                },
                {
                    key: 'amount',
                    label: 'จำนวนเงินที่นำส่ง',
                    class: 'text-right'
                    // Variant applies to the whole column, including the header and footer

                },
                'จัดการข้อมูล'

            ],


            items: [
                {
                    'id' : 1,
                    'deposit_office' : 'หน่วยงานทดสอบ',
                    'deposit_no' : '1111111111',
                    'deposit_date' : '2022-09-20',
                    'amount' : 10000,
                    'description' : 'description'
                }
            ],
            refund_items: [
                {
                    'id' : 1,
                    'item_id' : 2,
                    'refund_order' : 1,
                    'refund_amount' : 10000,
                    'balance' : 0,
                    'refund_case' : 'โควิด',
                    'approve_book_no' : 'กค 1122.1/1222',
                    'modified_by' : 'user1',
                    'description' : 'description'
                }
            ]
        }
    },
    watch : {
        office(){
            if (this.office){
                console.log(this.office_id + ' : ' + this.office)
            }else{
                console.log("clear office!!!")
            }
        }
    },
    methods : {
        toggleDetails(row) {
            if(row._showDetails){
                this.$set(row, '_showDetails', false)
            }else{
                this.currentItems.forEach(item => {
                    this.$set(item, '_showDetails', false)
                })
                this.$nextTick(() => {
                    this.$set(row, '_showDetails', true)
                })
            }
        },
        addDeposit(contract_new_id){
            this.showDeposit = true
        },
        showDepositData(data){
            this.showDeposit = true
            // this.$refs['showDeposit'].show()
            console.log(data);

        },
        showWithdrawData(data){
            this.showWithdraw = true
            console.log(data);
        },
        resetDeposit(){
            console.log('Close Deposit Modal');
        },
        resetWithdraw(){

        },
        fetchDeposit(){

        },
        fetchWithdraw(){

        },
        getThaiDate(item){
            var d = new Date(item);
            return d.toLocaleDateString('th-TH', { day: 'numeric', month: 'long', year: 'numeric' });
            //return moment(String(value)).format('LL')
        },
    }
}
</script>

<style scoped>
.myflex{
    display: flex;
    flex-direction: row;
    align-items: center;
    margin-bottom: 10px;
}
.myflex > .btn{
    margin-left: 10px;
}
.unit_name{
    width: 50px!important;
}

</style>
