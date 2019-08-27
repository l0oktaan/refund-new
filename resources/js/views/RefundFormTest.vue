<template>
<div>
    <b-row>
        <b-col cols="3">
            <a-range-picker
                @change="onRangeChange"
                :format="dateFormat"
            />
        </b-col>

    </b-row>

</div>

</template>
<script>
import moment from 'moment'

export default {
    data(){
        return {
            picker: null,
            due: null,
            lang: {
                days: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
                months: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
                pickers: ['next 7 days', 'next 30 days', 'previous 7 days', 'previous 30 days'],
                placeholder: {
                    date: 'เลือกวันที่',
                    dateRange: 'Select Date Range'
                },

            },
            dateFormat: "LL",
        }
    },
    mounted(){
        moment.locale('th');
        this.getDate();
    },


    methods: {
        moment,
        getDate(){
            $('.datepicker').datepicker();
        },
        dateSelected(value){
            this.showDate = value;
        },
        getDate(){
            return '';
        },
        onRangeChange(date, dateString){

        }
    },
    computed: {
        formatDate(){
            return  '';
        }
    }
}
</script>
