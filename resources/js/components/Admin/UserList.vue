<template>
    <div class="container">
        <b-row>
            <b-col cols="6"></b-col>
            <b-col cols="6">
                <b-form-group
                    label="คำค้น"
                    label-for="filter-input"
                    label-cols-sm="3"
                    label-align-sm="right"
                    label-size="sm"
                    class="mb-0"
                    >
                    <b-input-group size="sm">
                        <b-form-input
                        id="filter-input"
                        v-model="filter"
                        type="search"
                        placeholder="ใส่คำค้น"
                        ></b-form-input>

                        <b-input-group-append>
                        <b-button :disabled="!filter" @click="filter = ''">ล้าง</b-button>
                        </b-input-group-append>
                    </b-input-group>
                    </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <b-table striped hover 
                    :items="user_list" 
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"
                    :filter="filter"
                >
                    <template #cell(actions)="row">
                        <b-button v-if="row.item.type!='admin'" size="sm" @click="edit(row.item)" class="mr-1">
                          แก้ไข
                        </b-button>
                        <b-button v-if="row.item.type!='admin'" variant="danger" size="sm" @click="to_delete(row.item)">
                          ลบ
                        </b-button>
                      </template>
                </b-table>
            </b-col>
        </b-row>
        <b-row class="foot">
            <b-col cols="1">
                <div style="text-align:right;">
                    <b-form-select v-model="perPage" :options="pageOptions"></b-form-select>
                </div>
            </b-col>
            <b-col cols="3">
               <p style="text-align:left; margin-top:5px;">รายการต่อหน้า</p>
            </b-col>
            <b-col cols="4">
                <div style="text-align:center;">
                    <b-pagination
                        align="center"                        
                        pills                        
                        
                        limit="10"
                        v-model="currentPage"
                        :total-rows="totalRows"
                        :per-page="perPage" 
                    ></b-pagination>
                    <b-button v-if="refund_filter" variant="danger" @click="set_refund_show('all')">แสดงทั้งหมด</b-button>
                </div>
            </b-col>
            <b-col cols="4"></b-col>
        </b-row>
        <b-row align-h="center">
            <!-- <b-col>
                <b-pagination
                    v-model="currentPage"
                    :total-rows="totalRows"
                    :per-page="perPage"                    
                    size="sm"
                    class="my-0"
                ></b-pagination>
            </b-col> -->
            </b-row>
            <b-row>
            <b-col>
                <!-- <b-form-group
                    label="Per page"
                    label-for="per-page-select"
                    
                    label-align-sm="right"
                    label-size="sm"
                    class="mb-0"
                >
                    <b-form-select
                        id="per-page-select"
                        v-model="perPage"
                        :options="pageOptions"
                        size="sm"                        
                    ></b-form-select>
                </b-form-group> -->
            </b-col>
        </b-row>
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
            totalRows: 1,
            currentPage: 1,
            perPage: 10,
            pageOptions: [5, 10, 15, { value: 100, text: "แสดงทั้งหมด" }],
            filter: null
        }
    },
    mounted(){
        this.fetchData();
    },
    watch: {
        
    },
    methods:{
        async fetchData(){
            let path = await '/api/users';
            let res = await axios.get(`${path}`);
            this.user_list = await res.data.data;
            this.totalRows = await this.user_list.length
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