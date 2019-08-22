<template>
<b-row>
    <b-col cols="3">
        <b-form-input
            type="date"
            v-model="myDate"

        ></b-form-input>
        <b-form-input
            type="text"
            v-model="myDate2"

        ></b-form-input>
        <p>{{ new Date() | moment("DD/MM/YYYY") }}</p>
        <p>{{ myDate | moment("DD/MM/YYYY") }}</p>
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
    }
}
</script>

<style>

</style>
