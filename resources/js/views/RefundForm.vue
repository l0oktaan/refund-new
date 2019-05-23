<template>
    <div class="animated fadeIn">
        <h4>ข้อมูลการถอนคืนเงินรายได้</h4>
        <b-tabs v-model="tabIndex">
            <b-tab active>
              <template slot="title">
                <h5>ขั้นตอนที่ 1 : <i class="far fa-check-square fa-lg"></i></h5>
                <span>{{tabs[0].title}}</span>
              </template>
              <b-row>
                  <b-col cols="6" v-for="(form,index) in forms" :key="index">
                    <div class="animated fadeIn">
                        <b-card no-body :class="isSelect[index] ? 'bg-info' : 'bg-default'">
                            <b-card-body class="pb-0 ">
                                <div class="float-right">
                                    <toggle-button :value="false" :sync="true" :width="70" :height="25"
                                        :labels="{checked: 'เลือก', unchecked: 'ไม่เลือก'}"
                                        :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                                        style="padding-top:5px; line-height:35px;"
                                        v-model="isSelect[index]"
                                        @change="confirmChange(form,index)"
                                    />
                                </div>

                                <div class="textFiled">ฟอร์มลำดับที่ : {{form.order}}</div>
                                <div class="textFiled">ชื่อแบบฟอร์ม : {{form.name1}}</div>
                                <div></div>
                            </b-card-body>
                        </b-card>
                    </div>
                </b-col>
              </b-row>

            </b-tab>
            <b-tab>
              <template slot="title">
                <h5>ขั้นตอนที่ 2 : <i class="far fa-square fa-lg"></i></h5>
                <span>{{tabs[1].title}}</span>
              </template>
              <br> 1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
              et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
              aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
              dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
              officia deserunt mollit anim id est laborum.
            </b-tab>
            <b-tab>
              <template slot="title">
                <h5>ขั้นตอนที่ 3 : <i class="far fa-square fa-lg"></i></h5>
                <span>{{tabs[2].title}}</span>
              </template>
              <br> 1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
              et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
              aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
              dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
              officia deserunt mollit anim id est laborum.
            </b-tab>
          </b-tabs>
            <p>is select{{isSelect}}</p>
            <p>select{{arrFormSelected}}</p>
    </div>
</template>
<script>
export default {
    data(){
        return {
            tabIndex: 0,
            tabs: [
                {title: 'เลือกแบบฟอร์มขอถอนคืน', status: 1},
                {title: 'ข้อมูลสัญญา', status: 1},
                {title: 'ข้อมูลการอนุมัติ งด/ลด/ขยายเวลา', status: 1},
            ],
            forms: [],
            arrFormSelected: [],
            isSelect: [],
            form_id: 0,
        }
    },
    mounted(){
        this.getForm();
        this.$forceUpdate();
    },
    methods: {
        getForm(){
            var path = '/api/forms';
            var forms = [];

            axios.get(path)
            .then(response=>{
                forms = response.data.data;
                this.forms = forms;
                this.createArray();
                console.log('form :' + forms.length);
            })
        },
        confirmChange(form,index){


            let formIndex = this.arrFormSelected.findIndex(i => i.id === form.id);

            if (formIndex >= 0){

                this.arrFormSelected.splice(formIndex,1);

            }else{
                this.arrFormSelected.push(
                    {id: form.id, name: form.name1, order: form.order, selectIndex: index}
                );

            }
            this.arrFormSelected = this.sortArrays(this.arrFormSelected);

        },
        sortArrays(arr){
            return _.orderBy(arr,'order','asc');
        },
        createArray(){
            console.log('create array');
            if (this.forms.length > 0){
                for (let i = 0 ; i < this.forms.length ; i++){
                    this.isSelect.push(false);
                }
            }
        }
    }
}
</script>
<style scoped>
.tabTitle{
    font-size: 1rem;
    font-weight: bold;
}
.nav-link{
    padding-top: 10px!important;
}

</style>
