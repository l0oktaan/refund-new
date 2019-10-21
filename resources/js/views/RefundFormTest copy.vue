<template>
<div>
    <b-row>
        <b-col cols="6">

            <input type="text" value="02/16/12" data-date-format="mm/dd/yy" class="datepicker" >
            <b-form-input
                id="mydate1"
                type="date"
            >
            </b-form-input>
            <b-form-input id="mydate2" type="date" ></b-form-input>
            <a-date-picker @change="onChange" :defaultValue="iDate" :format="dateFormat" lang="th" />
            <span>{{ new Date() | moment("DD MMMM YYYY") }}</span>
            <input id="datepicker" type="text"/>
             <input class="input-medium" type="text" data-provide="datepicker" data-date-language="th">
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
            showDate: Date(),



        }
    },
    mounted(){
        moment.locale('th-TH');
this.fetchData();
    },
    created(){

    },
    ready(){

    },
    methods: {
        fetchData(){
            $('#mydate1').datepicker();
        },
        moment,

        onChange(){

        },
        mydate(){
            moment('2019/08/15','LL');
        }
    },
    computed: {
        iDate(){
           return moment(this.showDate,"DD MM YYYY");
        }
    }
}
</script>
