<template>
    <div class="animated fadeIn">
        <b-row>
             <b-col>
                 <b-card>
                     <div slot="header">
                         <i class='fa fa-align-justify'></i>
                         หลักเกณฑ์เงื่อนไข
                     </div>
                    <!-- <b-table striped hover :items="items" :fields="tebleFileds">
                        <template slot="index" slot-scope="data">
                            {{ data.index + 1 }}
                        </template>
                        <template slot="manage" >
                            <div>
                                <b-button variant="warning" class="btn-square btn-sm"><i class="fas fa-edit"></i></b-button>
                                <b-button variant="danger" class="btn-square btn-sm"><i class="fas fa-trash"></i></b-button>
                            </div>
                        </template>
                        <template slot="condition" >
                            <b-button block variant="primary" class="btn-square btn-sm"><i class="far fa-check-circle"></i>&nbsp;เงื่อนไข</b-button>
                        </template>
                    </b-table> -->
                 </b-card>


            </b-col>
        </b-row>
    </div>
</template>
<script>

export default {
    data() {
      return {
        // Note `isActive` is left out and will not appear in the rendered table
        tebleFileds: [{key:'index', label: 'ลำดับ'},
            'first_name',
            'last_name',
            'age',
            {key:'manage', label:'จัดการ'},
            {key:'condition', label:'เงื่อนไข'}
        ],
        items: []
      }
    }
}
</script>
<style scoped>
.card-body{
    padding: 0px!important;
}
</style>
