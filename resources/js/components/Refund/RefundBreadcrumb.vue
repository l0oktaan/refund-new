<template>
    <!-- Breadcrumb-->
    <div>
        <p>{{crumbs}}</p>
        <b-breadcrumb :items="crumbs"/>

    </div>

</template>
<script>
export default {
    data(){
        return {
            id: this.$route.params.id
        }
    },
    computed: {
        crumbs: function() {
            let pathArray = this.$route.path.split("/")
            console.log('nav :' + pathArray);

            pathArray.shift();
            console.log('nav shift :' + pathArray + 'id :' + this.id);
            // let breadcrumbs = pathArray.reduce((breadcrumbArray, path, idx) => {
            //     breadcrumbArray.push({
            //     path: path,
            //     to: breadcrumbArray[idx - 1]
            //         ? "/" + breadcrumbArray[idx - 1].path + "/" + path
            //         : "/" + path,
            //     text: this.$route.matched[idx].meta.breadCrumb || path,
            //     });

            //     return breadcrumbArray;
            // }, [])
            // return breadcrumbs;


        }
    }
}
</script>
