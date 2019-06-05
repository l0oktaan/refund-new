<template>
    <div>
        <b-list-group>
            <b-list-group-item v-for="(rule,index) in getRule()" :key="index">
                <div>
                    <h4>{{rule.name}}</h4>
                    <ul>
                        <li v-for="(sub_rule,index) in getSubRule(rule.id)" :key="index" >{{sub_rule.name}}</li>
                    </ul>
                </div>
            </b-list-group-item>
        </b-list-group>
    </div>
</template>
<script>
export default {
    props: ['form_id'],
    data(){
        return {
            form_rule: []
        }
    },
    mounted() {

            console.log('get form rule');
            this.fetchData();

    },
    methods: {
        fetchData(){
            var path = `/api/forms/${this.form_id}/form_rules`;
            axios.get(path)
            .then(response=>{
                this.form_rule = response.data.data;
            })
        },
        getRule(){
            var main_rule = this.form_rule.filter(function(rule){
                return rule.sub_of == 0;
            })
            return main_rule;
        },
        getSubRule(id){
            var sub_rule = this.form_rule.filter(function(rule){
                return rule.sub_of == id;
            })
            return sub_rule;
        }
    },
    computed: {
        rulename(order , name){
            return `${order} ${name}`;
        },

    }
}
</script>
