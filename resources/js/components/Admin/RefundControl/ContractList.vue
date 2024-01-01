<template>
    <div>

        <b-table striped hover :items="items" :fields="fields" sort-icon-left>
            <template #cell(ลำดับ)="data">
                {{ data.index + 1 }}
            </template>
            <template #cell(การนำส่ง-ถอนคืน)="row">
                <b-button size="sm" @click="row.toggleDetails" class="mr-2">
                {{ row.detailsShowing ? 'ซ่อน' : 'แสดง'}} รายการนำส่ง
                </b-button>

                <!-- As `row.showDetails` is one-way, we call the toggleDetails function on @change -->
                <!-- <b-form-checkbox v-model="row.detailsShowing" @change="row.toggleDetails">
                Details via check
                </b-form-checkbox> -->
            </template>
            <template #row-details="row">
                <b-card>
                    <div>
                        <div class="myflex">
                            <h3>รายการนำส่ง</h3>
                            <b-button @click="showDepositData(data)">เพิ่มรายการนำส่ง</b-button>
                        </div>
                        <b-table striped hover :items="deposit_items" :fields="deposit_fields" sort-icon-left>
                            <template #cell(ลำดับ)="data">
                                {{ data.index + 1 }}
                            </template>
                            <template #cell(จัดการข้อมูล)="data">
                                <b-button size="sm" @click="showDepositData(data)">จัดการข้อมูล</b-button>
                            </template>
                        </b-table>
                    </div>
                    <div>
                        <div class="myflex mt-2">
                            <h3>รายการถอนคืน</h3>
                            <b-button @click="showWithdrawData(data)">เพิ่มรายการอนุมัติถอนคืน</b-button>
                        </div>

                        <b-table striped hover :items="refund_items" :fields="refund_fields" sort-icon-left>
                            <template #cell(ลำดับ)="data">
                                {{ data.index + 1 }}
                            </template>
                            <template #cell(จัดการข้อมูล)="data">
                                <b-button size="sm" @click="showWithdrawData(data)">จัดการข้อมูล</b-button>
                            </template>
                        </b-table>
                    </div>
                    <b-button size="sm" @click="row.toggleDetails">Hide Details</b-button>
                </b-card>
            </template>

        </b-table>
        <b-modal v-model="showDeposit" ref="showDeposit" id="showDeposit"
            size="xl"
            hideFooter
            no-close-on-backdrop
            no-close-on-esc
            @hidden="resetDeposit"
            title="ข้อมูลการนำส่ง/เบิกหักผลักส่ง"
        >
            <deposit-form :contract_new_id="contract_new_id" @fetchDeposit="fetchDeposit"></deposit-form>
        </b-modal>
        <b-modal v-model="showWithdraw" ref="showWithdraw" id="showWithdraw"
            size="xl"
            hideFooter
            no-close-on-backdrop
            no-close-on-esc
            @hidden="resetWithdraw"
            title="ข้อมูลการถอนคืน"
        >
            <withdraw-form :contract_new_id="contract_new_id" @fetchWithdraw="fetchWithdraw"></withdraw-form>
        </b-modal>
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
            fields: [
                'ลำดับ',
                {
                    key: 'contract_no',
                    label: 'เลขที่สัญญา',
                    sortable: true,
                    // Variant applies to the whole column, including the header and footer

                },
                {
                    key: 'contract_party',
                    label: 'ชื่อคู่สัญญา',
                    sortable: true,
                    // Variant applies to the whole column, including the header and footer

                },
                'การนำส่ง-ถอนคืน'
            ],
            deposit_fields:[
                'ลำดับ',
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
                    sortable: true,
                    // Variant applies to the whole column, including the header and footer

                },
                {
                    key: 'amount_in_contract',
                    label: 'จำนวนเงินที่นำส่ง เฉพาะสัญญานี้',
                    sortable: true,
                    // Variant applies to the whole column, including the header and footer

                },
                'จัดการข้อมูล'

            ],
            refund_fields:[
                'ลำดับ',
                {
                    key: 'refund_order',
                    label: 'ครั้งที่',
                    sortable: true,
                    // Variant applies to the whole column, including the header and footer

                },
                {
                    key: 'refund_amount',
                    label: 'จำนวนเงิน',
                    sortable: true,
                    // Variant applies to the whole column, including the header and footer

                },
                {
                    key: 'balance',
                    label: 'สิทธิคงเหลือ',
                    sortable: true,
                    // Variant applies to the whole column, including the header and footer

                },
                {
                    key: 'refund_case',
                    label: 'อนุมัติให้ตาม',
                    sortable: true,
                    // Variant applies to the whole column, including the header and footer

                },
                {
                    key: 'approve_book_no',
                    label: 'เลขที่หนังสืออนุมัติ',
                    sortable: true,
                    // Variant applies to the whole column, including the header and footer

                },
                {
                    key: 'modified_by',
                    label: 'ผู้บันทึก',
                    sortable: true,
                    // Variant applies to the whole column, including the header and footer

                },
                'จัดการข้อมูล'
            ],
            items : [
                { 'id' : 1,  'office_id' : 1, 'contract_party' : 'บจ. 1234', 'contract_no' : '20/2566', 'status' : 1},
                { 'id' : 2,  'office_id' : 1, 'contract_party' : 'บจ. ABCD', 'contract_no' : '22/2566', 'status' : 1},
            ],
            deposit_items: [
                {
                    'id' : 1,
                    'item_id' : 1,
                    'deposit_no' : '1111111111',
                    'deposit_date' : '2022-09-20',
                    'amount' : 10000,
                    'amount_in_contract' : 10000,
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
        addDeposit(contract_new_id){
            this.showDeposit = true
        },
        showDepositData(){
            this.showDeposit = true
            // this.$refs['showDeposit'].show()


        },
        showWithdrawData(){
            this.showWithdraw = true
        },
        resetDeposit(){
            console.log('Close Deposit Modal');
        },
        resetWithdraw(){

        },
        fetchDeposit(){

        },
        fetchWithdraw(){

        }
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
</style>
