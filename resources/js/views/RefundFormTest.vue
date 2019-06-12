<template>
    <refund-check :form_id="form_id"></refund-check>
</template>
<script>
export default {
    data(){
        return {
            form_id : this.$route.params.id
        }
    }
}
</script>
