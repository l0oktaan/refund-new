<template>
<b-row>
    <b-col>
        <datetime
            v-model="date"
            placeholder="Select date"
            :format="{ year: 'numeric', month: 'long', day: 'numeric'}"
            value-zone = 'UTC+07:00'
            :week-start = "7"
            :phrases="{ok: 'ตกลง', cancel: 'ยกเลิก'}"
            :input-id="'myDate' + id"
            input-class="time-input"
        ></datetime>
    </b-col>
</b-row>

</template>

<script>

export default {
    props : ['id','showDate'],
    data(){
        return {
            date: null,

        }
    },
    mounted(){


    },
    created(){

    },
    methods: {

    },
    watch: {
        showDate(){
            this.date = this.showDate;
        },
        date(){

            this.$emit('update',this.date);
        }
    }
}
</script>

<style scoped>
.time-input{

    width: 100%!important;

    padding: 0.375rem 0.75rem!important;
    font-size: 0.8rem!important;
    font-weight: 400!important;
    line-height: 1.6!important;
    color: #5c6873!important;
    background-color: #fff!important;
    background-clip: padding-box!important;
    border: 1px solid #e4e7ea!important;
    border-radius: 0.25rem!important;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out!important;
}
</style>
