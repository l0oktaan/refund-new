<template>
<div>
    <b-row>
        <b-col cols="6">
            <my-date-picker :id="1"></my-date-picker>

        </b-col>

    </b-row>

</div>

</template>
<script>



export default {
    data(){
        return {
            value: '2015-01-01',
            showWeekNumber: false,
            monthName: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
        }
    },
    mounted(){

    },
    created(){

    },
    ready(){
        $(this.$refs.inputgroup).datepicker({

        });
    },
    methods: {
         dobFormatter(){
            var mydate = new Date();
            return mydate.toLocaleDateString();
        },
    },
    computed: {

    }
}
</script>
