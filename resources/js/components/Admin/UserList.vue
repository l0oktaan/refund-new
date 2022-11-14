<template>
    <div class="container">
        
        <b-table striped hover :items="user_list" :fields="fields">
            <template #cell(actions)="row">
                <b-button v-if="row.item.type!='admin'" size="sm" @click="edit(row.item)" class="mr-1">
                  แก้ไข
                </b-button>
                <b-button v-if="row.item.type!='admin'" variant="danger" size="sm" @click="to_delete(row.item)">
                  ลบ
                </b-button>
              </template>
        </b-table>
        <my-alert :AlertType="alert"></my-alert>
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
                    key: 'sub_office_name',
                    label: 'หน่วยงานย่อย',
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
                },
                { key: 'actions', label: 'Actions' }
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
        },
        async edit(item){
            let user = await JSON.parse(JSON.stringify(item));
            await this.$emit("userEdit",user);
        },
        async to_delete(item){
            this.$swal({
                title: "กรุณายืนยันการลบข้อมูลผู้ใช้งาน",
                text: "",
                icon: "error",
                closeOnClickOutside: false,
                buttons: [
                    'ยกเลิก',
                    'ยืนยัน'
                ],

            }).then(isConfirm =>{
                if (isConfirm){
                    let path = `/api/users/${item.id}`;
                    axios.delete(path)
                    .then(response=>{
                        this.alert = 'success';
                        this.fetchData();
                        this.$emit("clearData");
                    })
                }

            });
        }
    }
}
</script>
<style scoped>
.contrainer{
    width: 100%;
}
</style>