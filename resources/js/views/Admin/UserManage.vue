<template>
    <div>
        <b-button variant="dark" @click="createUser()" >Create User</b-button>
        {{users}}
    </div>
</template>

<script>
export default {
    data(){
        return {
            users: []
        }
    },
    methods :{
        createUser(){
            try {
                let path = '/api/create_users';
                axios.get(path)
                .then(response=>{
                    this.users = response.data;
                })
            } catch (error) {
                console.log(error);
            }

        }
    }
}
</script>

<style>

</style>
