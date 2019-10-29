<template>
<div>
    <b-row>
        <b-col cols="6">
            {{date}} <br/>date1 : {{date1}}<br/>date2 : {{date2}}
            <datetime
                v-model="date"
                placeholder="Select date"
                :format="{ year: 'numeric', month: 'long', day: 'numeric'}"
                value-zone = 'UTC+07:00'
                :week-start = "7"
                :phrases="{ok: 'ตกลง', cancel: 'ยกเลิก'}"

            ></datetime>
            <button @click="myclick">click</button>
        </b-col>
        <b-col>
            <my-date-picker :id="1" :showDate="date11" @update = "value => date1 = value"></my-date-picker>
            <my-date-picker :id="2" :showDate="date" @update = "value => date2 = value"></my-date-picker>
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
            date: '2019-10-29',
            date11: '',
            showWeekNumber: false,
            monthName: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
            date1: '',
            date2: ''
        }
    },
    mounted(){

    },
    created(){

    },
    ready(){

    },
    methods: {
        myclick(){
            this.date11='2019-10-25'
            this.$forceUpdate();
        },
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
