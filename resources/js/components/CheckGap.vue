<template>
    <div>
        <my-alert :AlertType="alert"></my-alert>
        <b-form-group>
            <label for="begin_date" style="text-align:left">วันที่ปัญหาอุปสรรคสิ้นสุด :</label>
            <my-date-picker ref="begin_date" :showDate="date_begin" @update="value => date_begin = value"></my-date-picker>
        </b-form-group>
        <b-form-group>
            <label for="end_date">วันที่ผู้รับจ้างแจ้งเหตุสิ้นสุด :</label>
            <my-date-picker ref="end_date" :showDate="date_end" @update="value => date_end = value"></my-date-picker>
        </b-form-group>
    </div>
</template>

<script>
export default {
    props: ['value'],
    data(){
        return {
            date_begin: null,
            date_end: null,
            alert: ''
        }
    },
    mounted(){
        if (this.value){
            let arr = this.value.split("|");
            this.date_begin = arr[0];
            this.date_end = arr[1];
        }else{
            this.date_begin = null;
            this.date_end = null;
        }
    },
    watch: {
        value(){
            if (!this.value || this.value == ''){
                this.$nextTick(()=>{
                    this.date_begin = null;
                    this.date_end = null;
                })
            }
        },
        show(){
            console.log('date show :' + this.show);
        },
        date_begin(newDate, oldDate){
            if (this.date_begin != '' && this.date_end){
                if (!this.checkDate(newDate,this.date_end)){
                    this.$nextTick(() => {
                        this.date_begin = oldDate;
                        this.$forceUpdate();
                    })
                }else{
                    this.$emit('input',this.date_begin + '|' + this.date_end);
                }
            }

        },
        date_end(newDate, oldDate){
            if (this.date_end != '' && this.date_begin){
                if (!this.checkDate(this.date_begin,newDate)){
                    this.$nextTick(() => {
                        this.date_end = oldDate;
                        this.$forceUpdate();
                    })
                }else{
                    this.$emit('input',this.date_begin + '|' + this.date_end);
                }
            }
        },
    },
    methods: {
        
        check_gap(){
            if (this.date_begin && this.date_end){

            }
        },
        diffDate(date1,date2){
            var d1 = new Date(date1);
            var d2 = new Date(date2);
            var diff = null;
            if (d2 > d1){
                diff = (d2.getTime() - d1.getTime())/(1000*60*60*24) + 1;
                return diff;
            }else{
                return false;
            }
        },
        checkDate(date1,date2){
            //console.log('check date : '+ date1 + ' and ' + date2);
            var d1 = new Date(date1);
            var d2 = new Date(date2);
            if (d2 > d1){
                //console.log('dateDiff :' + (d2.getTime() - d1.getTime())/(1000*60*60*24));
                return true;
            }else{
                this.alert = "require";
                return false;
            }

        },
    }
}
</script>

<style>

</style>
