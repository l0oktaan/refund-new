<template>
<div>
    <my-date-picker
        name="date1"
        @dateSelected="dateSelected"
        :myDate="myDate"
    ></my-date-picker>
    <p>{{showDate}}</p>
    <refund-check :form_id="form_id"></refund-check>
</div>

</template>
<script>
import moment from 'vue-moment'
export default {
    data(){
        return {
            form_id : this.$route.params.id,
            myDate: new Date('10-02-1979'),
            showDate: null
        }
    },
    methods: {
        dateSelected(value){
            this.showDate = value;
        }
    }
}
</script>
