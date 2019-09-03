<template>
<div>
    <b-row>
        <b-col cols="3">
            <b-form-input
                id="mydate1"
                type="date"

            >
            </b-form-input>
            <b-form-input id="mydate2" type="date" ></b-form-input>
            <a-date-picker @change="onChange" :defaultValue="iDate" :format="dateFormat" lang="th" />
            <span>{{ new Date() | moment("DD MMMM YYYY") }}</span>
        </b-col>

    </b-row>

</div>

</template>
<script>
import moment from 'moment'

export default {
    data(){
        return {
            dateFormat: 'LL',
            showDate: null,
            iDate: null
        }
    },
    mounted(){
        moment.locale('th-TH');
        this.showDate = new Date(2522,10,2);
        this.iDate = moment(this.showDate);
    },

    ready(){

    },
    methods: {
        format(value, event) {
            return "yyyy"
        },
        onChange(){

        },
        mydate(){
            moment('2019/08/15','LL');
        }
    },
    computed: {

    }
}
</script>
