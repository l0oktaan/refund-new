<template>
    <div class="container">
        
        <b-table striped hover :items="user_list" :fields="fields"></b-table>
    </div>
    
</template>
<script>
export default {
    data(){
        return {
            user_list: [],
            fields: [
                {
                    key: 'office',
                    label: 'หน่วยงาน',
                    sortable: true
                },
                {
                    key: 'name',
                    label: 'ชื่อ-นามสกุล',
                    sortable: true
                },
                {
                    key: 'username',
                    label: 'Username',
                    sortable: true
                },
                {
                    key: 'email',
                    label: 'Email',
                    sortable: true,                    
                }
            ],
        }
    },
    mounted(){
        this.fetchData();
    },
    methods:{
        async fetchData(){
            let path = await '/api/users';
            let res = await axios.get(`${path}`);
            this.user_list = await res.data.data;
        }
    }
}
</script>
<style scoped>
.contrainer{
    width: 100%;
}
</style>