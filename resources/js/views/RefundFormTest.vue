<template>
<div>
    <b-row>
        <b-col cols="6">
            {{date}} <br/>date1 : {{date}}<br/>date11 : {{date11}}<br/>date22 : {{date22}}

            <button @click="myclick">click</button>
        </b-col>
        <b-col>
            <my-date-picker ref="d1" :id="1" :showDate="date" @update = "value => date1 = value"></my-date-picker>
            <!-- <my-date-picker :id="2" :showDate="date" @update = "value => date2 = value"></my-date-picker> -->
            <my-date-picker :id="3" :showDate="xxx" @update = "value => date22 = value"></my-date-picker>
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
            date: '2019-10-22',

            showWeekNumber: false,
            monthName: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
            date1: '',
            date2: '',
            date11: '2019-10-25',
            date22 : '',
            xxx: ''
        }
    },
    mounted(){
        this.xxx = '2019-11-11'
    },
    created(){

    },
    ready(){

    },
    computed: {

    },
    methods: {
        myclick(){
            this.$refs.d1.date = '2019-10-25';
            this.date = '2019-10-25';
            this.$forceUpdate();
        },
        getDate1(value){
            console.log('update date' + value);
            this.date1 = value;
            this.$forceUpdate();
        },
        mydate(){
            return '2019-12-22'
        }

    },

}
</script>
