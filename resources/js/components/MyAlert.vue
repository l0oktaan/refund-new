<template>

</template>
<script>
export default {
  props: ['AlertType'],
  data(){
    return{
      alert: ''
    }
  },
  watch: {
    AlertType(){
      if (this.AlertType != ""){
        if (this.AlertType == "success"){
          this.$swal({
              title: "ทำรายการสำเร็จ",
              icon: "success",
              timer: 1200,
              button: false,
          });
        }else if (this.AlertType == "error"){
          this.$swal({
              title: "เกิดข้อผิดพลาด",
              icon: "error",
              timer: 1200,
              button: false,
          });
        }else if (this.AlertType == "require"){
          this.$swal({
              title: "กรุณาตรวจสอบข้อมูล",
              icon: "error",
              timer: 1200,
              button: false,
          });
        }else if (this.AlertType == "pass"){
          this.$swal({
              title: "เงื่อนไขถูกต้อง",
              icon: "success",
              timer: 1200,
              button: false,
          });
        }else if (this.AlertType == "notpass"){
          this.$swal({
              title: "เงื่อนไขไม่ถูกต้อง",
              icon: "error",
              timer: 1200,
              button: false,
          });
        }

        this.$parent.alert = "";
      }
    }
  }
}
</script>

<style scoped>
.swal-title{
  font-size: 0.8em!important;
}
</style>
