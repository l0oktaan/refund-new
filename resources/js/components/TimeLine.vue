<template>
    <light-timeline :items='time_line'>
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
            time_line: []
        }
    },
    mounted(){
        this.fetchData();
    },
    computed: {
        
    },
    methods: {
        fetchData(){
            this.time_line = [];
            let path = `/api/offices/${this.office_id}/refunds/${this.refund_id}`;
            axios.get(`${path}`)
            .then(response=>{
                this.refund = response.data.data[0];
                this.time_line = [
                    {
                        date: this.getThaiDate(this.refund.create_date),
                        icon: 'fas fa-check-circle',
                        status: 'สร้างรายการ',
                        class: 'content'
                    },
                    {
                        date: this.getThaiDate(this.refund.sent_date),     
                        icon: 'fas fa-check-circle',                   
                        status: 'ส่งรายการถอนคืน',
                        class: 'content'
                    }
                    
                    // {
                    //     type: 'star',
                    //     tag: '2018-01-14',
                    //     htmlMode: true,
                    //     content: `<div style="color: ${theme};"> =v = </div>`
                    // }
                ];
                if (this.refund.status >= 9){
                    this.time_line.push({
                        date: this.getThaiDate(this.refund.consider_date),
                        icon: 'fas fa-check-circle',
                        status: 'เจ้าหน้าที่รับเรื่อง',
                        class: 'content'
                    })
                }
                if (this.refund.return_date){
                    this.time_line.push({
                        date: this.getThaiDate(this.refund.return_date),
                        icon: 'fas fa-check-circle',
                        status: 'ขอให้ชี้แจง/ขอเอกสารเพิ่มเติม',
                        class: 'content'
                    })
                }
                if (this.refund.status == 99){
                    this.time_line.push({
                        date: this.getThaiDate(this.refund.complete_date),
                        icon: 'fas fa-check-circle',
                        status: 'แจ้งผลการพิจารณาแล้ว',
                        class: 'complete'
                    })
                }
            })
        },
        getThaiDate(item){
            var d = new Date(item);
            return d.toLocaleDateString('th-TH', { day: 'numeric', month: 'short', year: 'numeric' });
            //return moment(String(value)).format('LL')
        },
    }
}

</script>

<style scoped>
.line-container{
    font-family: 'Trirong'!important;
    
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