<template>
<b-row>
    <b-col cols="6">
        <b-form-input
            type="date"
            v-model="myDate"
            @click="iClick"
            id="myPick"
        ></b-form-input>
    </b-col>

</b-row>

</template>

<script>


export default {
    data(){
        return {
            myDate: null,
            myDate2: null
        }
    },
    mounted(){

    },
    created(){

    },
    methods: {
        iClick(){
            $("#myPick").datepicker();
        }
    }
}
</script>

<style>

</style>
