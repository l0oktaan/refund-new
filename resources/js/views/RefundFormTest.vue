<template>
<div>
    <b-row>
        <b-col cols="6">
            {{date}} <br/>new : {{date1}}
            <datetime
                v-model="date"
                placeholder="Select date"
                :format="{ year: 'numeric', month: 'long', day: 'numeric'}"
                value-zone = 'UTC+07:00'
                :week-start = "7"
                :phrases="{ok: 'ตกลง', cancel: 'ยกเลิก'}"

            ></datetime>

        </b-col>
        <b-col>
            <my-date-picker :id="1" :showDate="date" @update-1 = "getDate1"></my-date-picker>
        </b-col>
    </b-row>

</div>

</template>
<script>

import { Settings } from 'luxon'

Settings.defaultLocale = 'th'

export default {
    data(){
        return {
            date: '2019-10-28',

            showWeekNumber: false,
            monthName: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
            date1: ''
        }
    },
    mounted(){

    },
    created(){

    },
    ready(){

    },
    methods: {
        getDate1(value){
            console.log('update date' + value);
            this.date1 = value;
            this.$forceUpdate();
        }
    },
    computed: {

    }
}
</script>
