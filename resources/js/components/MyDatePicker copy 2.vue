<template>
<b-row>
    <b-col cols="6">
        <input type="text" id="datepicker" />
        <input name="dateInput2" type="text" id="dateInput2" value="" readonly />
    </b-col>
</b-row>

</template>

<script>

export default {
    props : ['id'],
    data(){
        return {
            myDate: null,
            myDate2: null,
            showWeekNumber: false,
            monthName: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
        }
    },
    mounted(){
        $.datepicker.regional['th'] ={
            changeMonth: true,
            changeYear: true,
            //defaultDate: GetFxupdateDate(FxRateDateAndUpdate.d[0].Day),
            yearOffSet: +543,
            showOn: "button",
            buttonImage: 'images/calendar.gif',
            buttonImageOnly: true,
            dateFormat: 'dd M yy',
            dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
            dayNamesMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
            monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
            monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
            constrainInput: true,

            prevText: 'ก่อนหน้า',
            nextText: 'ถัดไป',
            yearRange: '-20:+0',
            buttonText: 'เลือก',
        };
        $.datepicker.setDefaults($.datepicker.regional['th']);
        $( "#datepicker" ).datepicker( $.datepicker.regional["th"] ); // Set ภาษาที่เรานิยามไว้ด้านบน
        $( "#datepicker" ).datepicker("setDate", new Date()); //Set ค่าวันปัจจุบัน

    },
    created(){

    },
    methods: {
        dobFormatter(){
            var mydate = new Date();
            return mydate.toLocaleDateString();
        },
    }
}
</script>

<style>

</style>
