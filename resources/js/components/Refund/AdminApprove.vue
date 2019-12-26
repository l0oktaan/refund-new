<template>
  <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
        <b-row align-h="center">
            <b-col cols="6">
                <div>
                    <b-row>
                        <b-col>
                            <b-form-group
                                label-cols-sm="4"
                                label="ผลการตรวจสอบ :"
                                label-align-sm="right"
                                label-for="load_form"
                            >
                                <toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                                :labels="{checked: 'อนุมัติ', unchecked: 'ไม่'}"
                                :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                                style="padding-top:4px; line-height:0px;"                                
                                v-model="isApprove"
                            />
                                


                            </b-form-group>
                        </b-col>
                    </b-row>
                   <b-row>
                        <b-col>
                            <b-form-group
                                label-cols-sm="4"
                                label="คำอธิบายเพิ่มเติม :"
                                label-align-sm="right"
                                label-for="description"
                            >
                                <b-form-textarea
                                    ref="description"
                                    id="desription"
                                    v-model = "description"
                                    placeholder="ใส่คำอธิบาย"
                                    rows="3"
                                    no-resize
                                ></b-form-textarea>

                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col>
                            <b-form-group
                                label-cols-sm="4"
                                label="วันที่บันทึก :"
                                label-align-sm="right"
                                label-for="complete_date"                                >
                                <my-date-picker ref="complete_date" :id="11" :showDate="date_complete" @update="value => refund.complete_date = value"></my-date-picker>
                            </b-form-group>
                        </b-col>
                    </b-row>
                     <b-row>
                        <b-col>
                            <b-form-group
                                label-cols-sm="4"
                                label=""
                                label-align-sm="right"
                                label-for="description"
                            >
                                <b-button variant="primary" size="md" @click="onSubmit()">บันทึกข้อมูล</b-button>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </div>
            </b-col>
        </b-row>        


    </div>
</template>

<script>
export default {
    props: ['refund_status', 'refund_id'],
    data(){
        return{
            date_approve: '',
            description: '',
            isApprove: false
        }
    },
    methods: {
        onSubmit(){

        }
    }

}
</script>

<style>

</style>