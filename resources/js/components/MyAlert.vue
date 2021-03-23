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
        switch (this.AlertType){
          case "success":
            this.$swal({
              title: "ทำรายการสำเร็จ",
              icon: "success",
              timer: 1200,
              button: false,
            });
            break;
          case "error":
            this.$swal({
              title: "เกิดข้อผิดพลาด",
              icon: "error",
              timer: 1200,
              button: false,
            });
            break;
          case "require":
            this.$swal({
              title: "กรุณาตรวจสอบข้อมูล",
              icon: "error",
              timer: 1200,
              button: false,
            });
            break;
          case "pass":
            this.$swal({
              title: "เงื่อนไขถูกต้อง",
              icon: "success",
              timer: 1200,
              button: false,
            });
            break;
          case "notpass":
            this.$swal({
              title: "เงื่อนไขไม่ถูกต้อง",
              icon: "error",
              timer: 1200,
              button: false,
            });
            break;
            case "sendemail":
                this.$swal({
                title: "ระบบส่งการตั้งรหัสผ่านใหม่ไปที่ e-mail ที่ลงทะเบียนไว้แล้ว",
                icon: "success",
                timer: 5000,
                button: false,
                });
            break;
            case "emailfail":
                this.$swal({
                title: "ไม่พบ email ที่ระบุ",
                icon: "error",
                timer: 3000,
                button: false,
                });
            break;
          default:
        }


        // if (this.AlertType == "success"){
        //   this.$swal({
        //       title: "ทำรายการสำเร็จ",
        //       icon: "success",
        //       timer: 1200,
        //       button: false,
        //   });
        // }else if (this.AlertType == "error"){
        //   this.$swal({
        //       title: "เกิดข้อผิดพลาด",
        //       icon: "error",
        //       timer: 1200,
        //       button: false,
        //   });
        // }else if (this.AlertType == "require"){
        //   this.$swal({
        //       title: "กรุณาตรวจสอบข้อมูล",
        //       icon: "error",
        //       timer: 1200,
        //       button: false,
        //   });
        // }else if (this.AlertType == "pass"){
        //   this.$swal({
        //       title: "เงื่อนไขถูกต้อง",
        //       icon: "success",
        //       timer: 1200,
        //       button: false,
        //   });
        // }else if (this.AlertType == "notpass"){
        //   this.$swal({
        //       title: "เงื่อนไขไม่ถูกต้อง",
        //       icon: "error",
        //       timer: 1200,
        //       button: false,
        //   });
        // }

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
