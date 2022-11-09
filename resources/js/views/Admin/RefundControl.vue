<template>
    <div>
        <!-- <div v-for="office in offices" :key="office.id">{{office.code + ' ' + office.name}}</div> -->
    </div>
</template>
<script>
export default{
    data(){
        return {
            offices: []
        }
    },
    mounted(){
        this.fetchData();
    },
    methods:{
        async fetchData(){
            let path = await `/api/offices`;
            console.log('path :' + path);
            let res = await axios.get(path);
            this.offices = await res.data.data;
        }
    }
}
</script>
<style scoped>

</style>