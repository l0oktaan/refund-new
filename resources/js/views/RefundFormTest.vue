<template>
<div>
    <b-row>
        <b-col cols="3">
            <b-form-input id="mydate1" type="date" v-model="myDate"></b-form-input>
            <b-form-input id="mydate2" type="date" v-model="myDate"></b-form-input>
        </b-col>

    </b-row>

</div>

</template>
<script>
import moment from 'moment'

export default {
    data(){
        return {
            myDate: '2019-07-24'
        }
    },
    mounted(){

    },


    methods: {

    },
    computed: {

    }
}
</script>
