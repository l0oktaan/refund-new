<template>
    <b-alert
      :show="dismissCountDown"
      dismissible
      fade
      variant="danger"
      @dismiss-count-down="countDownChanged"
      @dismissed="showed"

    >
      <span style="text-align: center"><i class="fas fa-exclamation-triangle"></i> {{message}}</span>
    </b-alert>
</template>

<script>
export default {
    props: ['message'],
    data() {
      return {
        dismissSecs: 5,
        dismissCountDown: 0,
        showDismissibleAlert: false,
        message_show: ''
      }
    },
    watch : {
        message(newVal, oldVal){
            console.log('alert message : ' + newVal);
            if (newVal != ''){

                //this.message_show = newVal;
                this.dismissCountDown = this.dismissSecs;
            }
        }
    },
    methods: {
      countDownChanged(dismissCountDown) {
        this.dismissCountDown = dismissCountDown
      },
      showAlert() {
        this.dismissCountDown = this.dismissSecs
      },
      showed(){
          this.$emit("clearMessage");
          this.dismissCountDown = 0;
      }
    }
}
</script>

<style>
.alert-danger{
    text-align: center!important;
}
</style>
