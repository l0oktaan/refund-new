
<template>
    <div class="animated fadeIn">
        <date-picker
            @confirm="dateSelected"
            v-model="date1"
            :first-day-of-week="1"
            :lang="lang"
            :format="format"
            ref="datePicker"
            confirm
            v-if="showCalendar">
        </date-picker>
        <b-form-group>
            <b-input-group>
              <b-form-input type="email" placeholder="Email" autocomplete="email"></b-form-input>
              <!-- Attach Left button -->
              <b-input-group-append>
                <b-button variant="primary"><i class="far fa-edit"></i></b-button>
              </b-input-group-append>
            </b-input-group>
          </b-form-group>
    </div>





</template>

<script>
import moment from 'moment'
export default {
    props: ['myDate'],
    data(){
        return {
            lang: {
                days: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
                months: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
                pickers: ['next 7 days', 'next 30 days', 'previous 7 days', 'previous 30 days'],
                placeholder: {
                    date: 'เลือกวันที่',
                    dateRange: 'Select Date Range'
                },
            },

            format: 'DD-MM-YYYY',
            date1: null,
            showCalendar: true
        }
    },
    watch: {
        myDate(){
            console.log('Show Date :' + this.myDate);
            if (this.myDate != ''){
                this.date1 = this.myDate;
                this.$forceUpdate();
            }

        },

    },
    methods: {
        dateSelected(){
            //console.log('date :' + this.date1);
            this.$emit('dateSelected',this.date1);
        },
        formatDate (d) {
        // you could also provide your own month names array
        const months = this.$refs.datePicker.translation.months
        return `${d.getDate().toString().padStart(2, 0)} ${months[d.getMonth()]} ${d.getFullYear()}`
        }
    }
}
</script>
