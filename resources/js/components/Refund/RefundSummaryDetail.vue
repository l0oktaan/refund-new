<template>
    <div class="detail">

            <p>{{name3.includes('693') ? 'หน่วยงานอนุมัติให้แก้ไขอัตรค่าปรับเป็นร้อยละ 0 ' : 'หน่วยงานอนุมัติให้งด ลดค่าปรับ'}}</p>
            <b-row style="margin-bottom: 10px">
                <b-col cols="1"></b-col>
                <b-col cols="1" style="text-align:right;">{{ 'ตั้งแต่วันที่:  '}}</b-col>
                <b-col cols="3">
                    <my-date-picker ref="date_start" :id="refuns_id + 13" :showDate="date_start" @update="value =>date_start = value"></my-date-picker>
                </b-col>
                <b-col cols="1" style="text-align:right;">{{ 'ถึง:  '}}</b-col>
                <b-col cols="3">
                    <my-date-picker ref="date_end" :id="refuns_id + 13" :showDate="date_end" @update="value =>date_end = value"></my-date-picker>
                </b-col>
                <b-col cols="2" >

                        <b-input-group append="วัน" style="margin: 0 5px">
                            <b-form-input readonly id="approve_refund_days" v-model="days"></b-form-input>
                        </b-input-group>

                </b-col>
                <b-col cols="1">
                    <b-button variant="dark" style="margin-left: 5px" @click="onSubmit">บันทึก</b-button>
                </b-col>
            </b-row>
            <b-row v-for="(item,index) in details" :key="index">
                <b-col cols="1" style="text-align:right;">{{index+1}}</b-col>
                <b-col cols="1" style="text-align:right;">{{ 'ตั้งแต่วันที่:  '}}</b-col>
                <b-col cols="2">
                    {{getThaiDate(item.start_date)}}
                </b-col>
                <b-col cols="1" style="text-align:right;">{{ 'ถึง:  '}}</b-col>
                <b-col cols="2">
                    {{getThaiDate(item.end_date)}}
                </b-col>
                <b-col cols="2" >
                    {{item.refund_days}} วัน
                </b-col>
                <b-col cols="2">
                    <b-button variant="primary" style="margin-left: 5px" @click="toEdit(item)">แก้ไข</b-button>
                    <b-button variant="danger" style="margin-left: 5px" @click="toDelete(item.id)">ลบ</b-button>
                </b-col>
            </b-row>


    </div>
</template>

<script>
export default {
    props: ["office_id","refund_id","name3"],
    data() {
        return {
            date_start: '',
            date_end : '',
            details: [],
            days: 0,
            state : 'new',
            detail_id: 0
        }
    },
    watch:{
         date_start(newDate, oldDate){
            if (this.date_start != '' && this.date_end){
                if (!this.checkDate(newDate,this.date_end)){
                    this.$nextTick(() => {
                        this.date_start = oldDate;
                        this.$forceUpdate();
                    })
                }else{
                    this.days = this.diffDate(this.date_start,this.date_end);
                }
            }
        },
        date_end(newDate, oldDate){
            if (this.date_end != '' && this.date_start){
                if (!this.checkDate(this.date_start,newDate)){
                    this.$nextTick(() => {
                        this.date_end = oldDate;
                        this.$forceUpdate();
                    })
                }else{
                    this.days = this.diffDate(this.date_start,this.date_end);
                    // this.checkEqualDate(newDate,this.date_delivery);
                }
            }
        },
    },
    mounted(){
        this.fetchData();
    },
    methods: {
        async fetchData(){
            let path = await `/api/offices/${this.office_id}/refunds/${this.refund_id}/approve_refund_details`;
            console.log(path);
            let res = await axios.get(`${path}`)
            if (res){
                this.details = await res.data.data;
            }
        },
        async clearData(){
            this.date_start = await '';
            this.date_end =  await '';
            this.days = await 0;
            this.state = await "new";
        },
        diffDate(date1,date2){
            var d1 = new Date(date1);
            var d2 = new Date(date2);
            var diff = null;
            if (d2 >= d1){
                diff = (d2.getTime() - d1.getTime())/(1000*60*60*24) + 1;
                return diff;
            }else{
                this.alert = "error";
                return false;
            }
        },
        checkDate(date1,date2){
            //console.log('check date : '+ date1 + ' and ' + date2);
            var d1 = new Date(date1);
            var d2 = new Date(date2);
            if (d2 >= d1){
                //console.log('dateDiff :' + (d2.getTime() - d1.getTime())/(1000*60*60*24));
                return true;
            }else{
                this.alert = "error";
                return false;
            }

        },
        toEdit(item){
            this.detail_id = item.id;
            this.date_start = item.start_date;
            this.date_end = item.end_date;
            this.state = "update";
        },
        async toDelete(id){
            let isConfirm = await this.$swal({
                title: "คุณต้องการลบข้อมูล ใช่หรือไม่",
                //text: `คุณต้องการลบข้อมูล ใช่หรือไม่`,
                icon: "warning",
                closeOnClickOutside: false,
                buttons: [
                    'ยกเลิก',
                    'ยืนยัน'
                ],
            })
            if (isConfirm){
                let path = await `/api/offices/${this.office_id}/refunds/${this.refund_id}/approve_refund_details/${id}`;
                try {
                    await axios.delete(`${path}`)
                    await this.fetchData();
                    await this.$emit('fetchDetail',this.details);
                    await this.clearData();
                } catch (error) {
                    console.log(error);
                }
            }

        },
        async onSubmit(){
            let path = await `/api/offices/${this.office_id}/refunds/${this.refund_id}/approve_refund_details`;

            if (this.state == 'new'){
                try {

                    const response = await axios.post(`${path}`,{
                        //receive_date: this.approve.receive_date,
                        refund_days: this.days,
                        start_date: this.date_start,
                        end_date: this.date_end,
                    })
                    // await console.log(response.data);
                    await this.fetchData();
                    await this.$emit('fetchDetail',this.details);
                    await this.clearData();
                } catch (error) {
                    console.log(error);
                }

            }else if (this.state == 'update'){
                try {
                    path = await `${path}/${this.detail_id}`;
                    await axios.put(`${path}`,{
                        //receive_date: this.approve.receive_date,
                        refund_days: this.days,
                        start_date: this.date_start,
                        end_date: this.date_end
                    })
                    await this.fetchData();
                    await this.$emit('fetchDetail',this.details);
                    await this.clearData();
                } catch (error) {
                    console.log(error);
                }
            }
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
.detail{
    border: 1px solid #000000;
    padding: 5px;
    margin: 5px;
}
.detail .row .col-1,.col-2,.col-3{
    padding-right: 0px;
    padding-left: 2px;
}
</style>
