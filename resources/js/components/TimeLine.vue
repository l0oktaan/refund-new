<template>
    <light-timeline :items='items'></light-timeline>
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
            ]
        }
    },
    mounted(){
        this.fetchData();
    },
    methods: {
        fetchData(){
            let path = `/api/offices/${this.office_id}/refunds/${this.refund_id}`;
            axios.get(`${path}`)
            .then(response=>{
                
            })
        }
    }
}

</script>

<style>

</style>