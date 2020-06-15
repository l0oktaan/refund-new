<template>  
    <div>
        <my-date-picker ref="begin_date" :showDate="iDate" @update="value => iDate = value"></my-date-picker>
    </div>
</template>

<script>
export default {
    props: ['value'],
    data(){
        return {
            iDate: null,
            
        }
    },
    mounted(){
        if (this.value){            
            this.iDate = this.value;            
        }else{
            this.iDate = null;
        }
    },
    watch : {
        value(){
            if (!this.value || this.value == ''){
                this.$nextTick(()=>{
                    this.iDate = null;                    
                })
            }else{
                this.iDate = this.value;
            }
            //console.log('date :' + this.value);
        },
        iDate(newDate, oldDate){            
            this.$emit('input',this.iDate);             
        },
    }
}
</script>

<style scoped>
.time-input{
    border-color: rgb(2, 74, 182)!important;
}
</style>