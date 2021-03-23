<template>
  <reset :token="token"></reset>

</template>

<script>
export default {
    data(){
        return {
            token : this.$route.query.token
        }
    }
}
</script>

<style>

</style>
