<template>
<b-row>
    <b-col>
        <datetime
            v-model="date"
            placeholder="เลือกวันที่"
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
            console.log('change Date  :' + this.showDate);
            if (this.showDate != ''){
                this.date = this.showDate;
                console.log('----change Date 1 :' + this.date);
                this.$forceUpdate();
            }else{
                console.log('Clear Date');
                this.date = null;
            }

        },
        date(){
            console.log('date :' + this.date);
            var str = '';
            try{
                str = this.date.slice(0, 10);
            }catch{
                str = '';
            }
             console.log('date str :' + str);

           this.$emit('update',str);
            this.$forceUpdate();

        }
    }
}
</script>

<style scoped>

</style>
