
<template>
    <date-picker 
        @confirm="dateSelected"
        v-model="date1" 
        :first-day-of-week="1" 
        :lang="lang"
        format="myformat"
        confirm></date-picker>
</template>

<script>
export default {
    data(){
        return {
            lang: {
                days: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
                months: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],                
                pickers: ['next 7 days', 'next 30 days', 'previous 7 days', 'previous 30 days'],
                placeholder: {
                    date: 'เลือกวันที่',
                    dateRange: 'Select Date Range'
                }
            },
            date1: '',
            myformat: {
                stringify: (date) => {
                return date ? Moment(date).format('LL') : null
                },
                parse: (value) => {
                return value ? Moment(value, 'LL').toDate() : null
                }
            }
        }
    },
    methods: {
        dateSelected(){
            //console.log('date :' + this.date1);
            this.$emit('dateSelected',this.date1);
        }
    }
}
</script>

