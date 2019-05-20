<template>
    <div class="animated fadeIn">

        <b-card no-body class="bg-default">
            <b-card-body class="pb-0">
                <b-dropdown class="float-right" variant="transparent p-0" right>
                <template slot="button-content">
                    <i class="icon-settings"></i>
                </template>
                    <b-dropdown-item><i class="fas fa-align-justify"></i>&nbsp;แสดงแบบฟอร์ม</b-dropdown-item>
                    <b-dropdown-item @click="showRule"><i class="fas fa-edit"></i>&nbsp;แก้ไขแบบฟอร์ม</b-dropdown-item>
                    <b-dropdown-item><i class="fas fa-trash"></i>&nbsp;ลบแบบฟอร์ม</b-dropdown-item>
                </b-dropdown>

                <h4 class="mb-0">ลำดับที่ :{{sub_rule}}</h4>



            </b-card-body>
        </b-card>
    </div>
</template>
<script>
export default {
    props: ['sub_rule'],
    data(){
        return {
            rule: {}
        }
    },
    mounted(){

    },
    methods: {
        showRule(){

        }
    }
}
</script>
