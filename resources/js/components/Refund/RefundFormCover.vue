<template>
<b-col cols="6">
    <div class="animated fadeIn">

        <b-card no-body class="bg-default">
            <b-card-body class="pb-0 ">
                <div class="textFiled">ฟอร์มลำดับที่ : {{form.order}}</div>
                <div class="textFiled">ชื่อแบบฟอร์ม : {{form.name1}}</div>
                <div></div>
            </b-card-body>
        </b-card>

    </div>
    </b-col>
</template>
<script>
export default {
    props: ['form'],
    data(){
        return {
            selectForm: []
        }
    }
}
</script>
