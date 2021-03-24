<template>
    <div style="margin: auto;">


        <light-timeline :items="time_line">
            <template slot='tag' slot-scope='{ item }'>
                <span class="mydate">{{item.date}}</span>
            </template>
            <template slot='symbol' slot-scope='{ item }'>
                <div class="my_icon_class"><i :class="item.icon + ' fa-lg'"></i></div>
            </template>
            <template slot='content' slot-scope='{ item }'>
                <span :class="item.class">{{item.status}}</span>
            </template>
        </light-timeline>
    </div>
</template>

<script>
const theme = 'red';
export default {
    props: ['refund_id'],
    data(){
        return {
            office_id: this.$store.getters.office_id,
            refund: null,
            items: [
                {
                    tag: '2018-01-12',
                    content: 'hallo'
                },
                {
                    tag: '2018-01-13',
                    color: '#dcdcdc',
                    type: 'circle',
                    content: 'world'
                },
                {
                    type: 'star',
                    tag: '2018-01-14',
                    htmlMode: true,
                    content: `<div style="color: ${theme};"> =v = </div>`
                }
            ],
            time_line: [],
            refund_status: [],
            arr_refund_status: this.$store.getters.arr_refund_status,
            user_type : this.$store.getters.user_type
        }
    },
    mounted(){
        this.fetchData();
    },
    computed: {

    },
    methods: {
        get_status_text(status){

            try {
                if (this.user_type == 'admin'){
                    return (status == 8) ? this.arr_refund_status[this.arr_refund_status.findIndex(x=>x.status.includes(status))].text.admin : this.arr_refund_status[this.arr_refund_status.findIndex(x=>x.status.includes(status))].text;
                }else{
                    return (status == 8) ? this.arr_refund_status[this.arr_refund_status.findIndex(x=>x.status.includes(status))].text.user : this.arr_refund_status[this.arr_refund_status.findIndex(x=>x.status.includes(status))].text;
                }
            } catch (error) {
                return '?';
            }


        },
        async fetchData(){
            this.time_line = [];

            let path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_status`;
            let response = await axios.get(`${path}`);
            this.refund_status = await response.data.data;
            for (let i=0; i<this.refund_status.length; i++){
                await this.time_line.push({
                    date: await this.getThaiDate(this.refund_status[i].status_date),
                    icon: 'fas fa-check-circle',
                    status: await this.get_status_text(this.refund_status[i].status_code),
                    class: 'content'
                })
            }
            // .then(response=>{
                // this.refund_status = response.data.data[0];
                // for (let i=0; i<this.refund_status.length; i++){
                //     this.time_line.push({
                //         date: this.getThaiDate(this.refund_status[i].status_date),
                //         icon: 'fas fa-check-circle',
                //         status: this.refund_status[i].status_code,
                //         class: 'content'
                //     })
                // }
                // this.time_line = [
                //     {
                //         date: this.getThaiDate(this.refund.create_date),
                //         icon: 'fas fa-check-circle',
                //         status: 'สร้างรายการ',
                //         class: 'content'
                //     },
                //     {
                //         date: this.getThaiDate(this.refund.sent_date),
                //         icon: 'fas fa-check-circle',
                //         status: 'ส่งรายการถอนคืน',
                //         class: 'content'
                //     }

                //     // {
                //     //     type: 'star',
                //     //     tag: '2018-01-14',
                //     //     htmlMode: true,
                //     //     content: `<div style="color: ${theme};"> =v = </div>`
                //     // }
                // ];
                // if (this.refund.status >= 9){
                //     this.time_line.push({
                //         date: this.getThaiDate(this.refund.consider_date),
                //         icon: 'fas fa-check-circle',
                //         status: 'อยู่ระหว่างพิจารณา',
                //         class: 'content'
                //     })
                // }
                // if (this.refund.return_date){
                //     this.time_line.push({
                //         date: this.getThaiDate(this.refund.return_date),
                //         icon: 'fas fa-check-circle',
                //         status: 'ขอให้ชี้แจง/ขอเอกสารเพิ่มเติม',
                //         class: 'content'
                //     })
                // }
                // if ((this.refund.return_date <= this.refund.consider_date) && !(this.refund.draft_date)){
                //     this.time_line.push({
                //         date: this.getThaiDate(this.refund.return_date),
                //         icon: 'fas fa-check-circle',
                //         status: 'อยู่ระหว่างพิจารณา',
                //         class: 'content'
                //     })
                // }
                // if (this.refund.disscuss_date){
                //     this.time_line.push({
                //         date: this.getThaiDate(this.refund.disscuss_date),
                //         icon: 'fas fa-check-circle',
                //         status: 'อยู่ระหว่างหารือหน่วยงานฯ',
                //         class: 'content'
                //     })
                // }
                // if (this.refund.draft_date){
                //     this.time_line.push({
                //         date: this.getThaiDate(this.refund.draft_date),
                //         icon: 'fas fa-check-circle',
                //         status: 'เสนอร่าง',
                //         class: 'content'
                //     })
                // }
                // if (this.refund.director_date){
                //     this.time_line.push({
                //         date: this.getThaiDate(this.refund.director_date),
                //         icon: 'fas fa-check-circle',
                //         status: 'เสนอผู้อำนวยกอง',
                //         class: 'content'
                //     })
                // }
                // if (this.refund.status == 99){
                //     this.time_line.push({
                //         date: this.getThaiDate(this.refund.complete_date),
                //         icon: 'fas fa-check-circle',
                //         status: 'แจ้งผลการพิจารณาแล้ว',
                //         class: 'complete'
                //     })
                // }
            // })
        },
        getThaiDate(item){
            var d = new Date(item);
            return d.toLocaleDateString('th-TH', { day: 'numeric', month: 'short', year: 'numeric', hour: 'numeric', minute : 'numeric' });
            //return moment(String(value)).format('LL')
        },
    }
}

</script>

<style scoped>
.line-container{
    font-family: 'Trirong'!important;
    margin-left: 20%!important;

}
.content{
    color: #000!important;
    font-weight: bold;
}
.complete{
    color: rgb(0, 119, 16)!important;
    font-weight: bold;
}
.my_icon_class{
    color:rgb(3, 185, 27)!important;
}
.mydate{

    color:#000!important;
}
.line-container::after{
    background-color: rgb(231, 66, 0)!important;
}

</style>
