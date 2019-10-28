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

            this.$emit('update-1',this.date);
        }
    }
}
</script>

<style>

</style>
