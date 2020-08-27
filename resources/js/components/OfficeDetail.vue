<template>
<b-row align-h="center">
    <b-col cols="10">        
        <my-alert :AlertType="alert"></my-alert>
        <b-form @submit="onSubmit">
            <b-row>
                <b-col cols="12"><h4 class="text-center">ข้อมูลหน่วยงาน</h4></b-col>
            </b-row>
            <b-row>
                <b-col cols="3" class="text-right"><label for="code">รหัสหน่วยงาน :</label></b-col>
                <b-col cols="3"><b-form-input :readonly="true" id="code" type="text" v-model="office.code"></b-form-input></b-col>
            </b-row>
            <b-row>
                <b-col cols="3" class="text-right"><label for="code">ชื่อหน่วยงาน :</label></b-col>
                <b-col cols="9"><b-form-input :readonly="true" id="name" type="text" v-model="office.name"></b-form-input></b-col>
            </b-row>
            <b-row>
                <b-col cols="3" class="text-right"><label for="code">ชื่อผู้ติดต่อ :</label></b-col>
                <b-col cols="4"><b-form-input id="contact" type="text" v-model="office.contact_name"></b-form-input></b-col>
            </b-row>
            <b-row>
                <b-col cols="3" class="text-right"><label for="code">หมายเลขโทรศัพท์ :</label></b-col>
                <b-col cols="4"><b-form-input id="phone"  type="text" v-model="office.phone"></b-form-input></b-col>
            </b-row>
            <b-row>
                <b-col cols="3" class="text-right"><label for="code">อีเมล์ :</label></b-col>
                <b-col cols="4"><b-form-input id="email"  type="email" v-model="office.email"></b-form-input></b-col>
            </b-row>
            <b-row align-h="center">                
                <b-col cols="12">
                    <div class="text-center">                        
                        <b-button type="submit" variant="dark" >บันทึกข้อมูล</b-button>                                    
                    </div>                                 
                </b-col>
            </b-row>
        </b-form>
    </b-col>
</b-row>
</template>
<script>
export default {
    data(){
        return {
            office_id: this.$store.getters.office_id,
            office: {},
            alert: ''
        }
    },
    mounted(){
        this.fetchData();
    },
    methods: {
        fetchData(){
            let path = `/api/offices/${this.office_id}`;
            
            axios.get(`${path}`)
            .then(response=>{
                this.office = response.data.data;
            })
            .catch(error=>{
                console.log('error :' + error)
            })
        },
        onSubmit(e){
            e.preventDefault()
            let path = `/api/offices/${this.office_id}`;
            axios.put(`${path}`,
                {
                    contact_name: this.office.contact_name,
                    phone: this.office.phone,
                    email: this.office.email
                }
            )
            .then(response=>{
                this.alert = 'success'
                this.fetchData();
            })
            .catch(error=>{
                this.alert = 'error'
            })
        }
    }
}
</script>

<style scoped>
.form-control{
    margin: 5px!important;
}
label{
    margin-top: 10px!important;
}

</style>