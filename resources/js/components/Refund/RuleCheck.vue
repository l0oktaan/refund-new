<template>
    <div class="animated fadeIn">
        <my-alert :AlertType="alert"></my-alert>
        <b-form  @submit="onSubmit">
            <b-row>
                <b-col>
                    <!-- <p>{{rule}}</p> -->
                    <!-- <p>{{results}}</p> -->
                    <!--<p>{{arr_detail}}</p>
                    <p>{{rule_passed}}</p> -->
                    <!-- <p>{{result_show}}</p> -->
                    <!-- <p>{{rule_select}}</p> -->
                    <!-- <p>{{arr_rule_select}}</p> -->
                    <b-card bg-variant="primary" text-variant="white" class="p-1 pl-2">
                        <span>หลักเกณฑ์ {{rule.order}} : {{rule.name}}</span>
                    </b-card>


                    <consider-check
                        v-for="(consider,index) in rule.considers" :key="index"
                        :consider = "consider"
                        :iClass="(details) ? (details.findIndex(x=>x.consider_id == consider.id) >= 0) ? details[details.findIndex(x=>x.consider_id == consider.id)].status : '' : ''"
                    >
                        <div v-if="results && result_show">

                            <toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'boolean'"
                                :labels="{checked: 'ใช่', unchecked: 'ไม่ใช่'}"
                                :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                                style="padding-top:4px; line-height:0px;"
                                v-model="results[findResultIndex(consider.id)]['value']"
                            />
                            <b-form-select
                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'inArray'"
                                :options="getOptions(consider.var1)"
                                v-model="results[findResultIndex(consider.id)]['value']"
                                >
                            </b-form-select>

                            <b-form-input type="text"
                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'value'"
                                v-model="results[findResultIndex(consider.id)]['value']"
                            ></b-form-input>
                            <b-input-group :append="(consider.type == 5) ? consider.var1 : 'วัน'"
                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'number'"
                            >
                                <b-form-input v-model="results[findResultIndex(consider.id)]['value']" @keypress="isNumber($event)"></b-form-input>
                            </b-input-group>
                            <thai-date
                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'date'"
                                v-model="results[findResultIndex(consider.id)]['value']"
                            ></thai-date>
                            <!-- <my-date-picker
                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'date'"

                                :id="consider.id"
                                :showDate="result_show[result_show.findIndex(x=>x.consider_id == consider.id)].value"
                                @update="value => results[results.findIndex(x=>x.consider_id == consider.id)].value = value"
                            ></my-date-picker> -->

                            <check-gap
                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'gap'"
                                v-model="results[findResultIndex(consider.id)]['value']"
                            ></check-gap>
                            <check-gap-2
                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'gap2'"
                                v-model="results[findResultIndex(consider.id)]['value']"
                            ></check-gap-2>

                        </div>
                    </consider-check>
                    <b-form-radio-group id="radio-group-1" v-model="rule_select" name="sub_rule" v-if="(rule && rule.sub_rules.length > 1 && rule.result_type == 1)">

                        <b-card v-for="(sub_rule,i_index) in rule.sub_rules" :key="i_index" :class="rule_select == sub_rule.id ? '' : 'bg-secondary'">
                            <b-form-radio :value="sub_rule.id" >
                                <span>{{'หลักเกณฑ์ย่อย ' + rule.order + '.' + sub_rule.order + ' : ' + sub_rule.name}}</span>
                            </b-form-radio>

                            <consider-check
                                v-for="(consider,index) in sub_rule.considers" :key="index"
                                :consider = "consider"
                                :iClass="(details) ? (details.findIndex(x=>x.consider_id == consider.id) >= 0) ? details[details.findIndex(x=>x.consider_id == consider.id)].status : '' : ''"
                            >

                                <div v-if="results && result_show">
                                    <b-form>
                                        <b-form-group :disabled="!(rule_select == sub_rule.id)">
                                            <toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'boolean'"
                                                :labels="{checked: 'ใช่', unchecked: 'ไม่ใช่'}"
                                                :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                                                style="padding-top:4px; line-height:0px;"
                                                v-model="results[findResultIndex(consider.id)]['value']"
                                            />
                                            <b-form-select
                                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'inArray'"
                                                :options="getOptions(consider.var1)"
                                                v-model="results[findResultIndex(consider.id)]['value']"
                                                >
                                            </b-form-select>

                                            <b-form-input type="text"
                                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'value'"
                                                v-model="results[findResultIndex(consider.id)]['value']"
                                            ></b-form-input>
                                            <b-input-group :append="(consider.type == 5) ? consider.var1 : 'วัน'"
                                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'number'"
                                            >
                                                <b-form-input v-model="results[findResultIndex(consider.id)]['value']" @keypress="isNumber($event)"></b-form-input>
                                            </b-input-group>
                                            <thai-date
                                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'date'"
                                                v-model="results[findResultIndex(consider.id)]['value']"
                                            ></thai-date>
                                            <!-- <my-date-picker
                                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'date'"

                                                :id="consider.id"
                                                :showDate="result_show[findResultIndex(consider.id)]['value']"
                                                @update="value => results[findResultIndex(consider.id)]['value'] = value"
                                            ></my-date-picker> -->
                                            <check-gap
                                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'gap'"
                                                v-model="results[findResultIndex(consider.id)]['value']"
                                            ></check-gap>
                                            <check-gap-2
                                                v-if="results[findResultIndex(consider.id)]['result_type'] == 'gap2'"
                                                v-model="results[findResultIndex(consider.id)]['value']"
                                            ></check-gap-2>
                                        </b-form-group>
                                    </b-form>

                                </div>
                            </consider-check>
                        </b-card>
                    </b-form-radio-group>
                    <div v-else>
                        <b-card v-for="(sub_rule,i_index) in rule.sub_rules" :key="i_index">

                            <span>{{'หลักเกณฑ์ย่อย ' + rule.order + '.' + sub_rule.order + ' : ' + sub_rule.name}}</span>


                            <consider-check
                                v-for="(consider,index) in sub_rule.considers" :key="index"
                                :consider = "consider"
                                :iClass="(details) ? (details.findIndex(x=>x.consider_id == consider.id) >= 0) ? details[details.findIndex(x=>x.consider_id == consider.id)].status : '' : ''"
                            >

                                <div v-if="results && result_show">
                                    <toggle-button :value = "false" :sync = "true" :width="60" :height="25"
                                        v-if="results[findResultIndex(consider.id)]['result_type'] == 'boolean'"
                                        :labels="{checked: 'ใช่', unchecked: 'ไม่ใช่'}"
                                        :color="{checked: '#41831b', unchecked: '#7c7c7c'}"
                                        style="padding-top:4px; line-height:0px;"
                                        v-model="results[findResultIndex(consider.id)]['value']"
                                    />
                                    <b-form-select
                                        v-if="results[findResultIndex(consider.id)]['result_type'] == 'inArray'"
                                        :options="getOptions(consider.var1)"
                                        v-model="results[findResultIndex(consider.id)]['value']"
                                        >
                                    </b-form-select>

                                    <b-form-input type="text"
                                        v-if="results[findResultIndex(consider.id)]['result_type'] == 'value'"
                                        v-model="results[findResultIndex(consider.id)]['value']"
                                    ></b-form-input>
                                    <b-input-group :append="(consider.type == 5) ? consider.var1 : 'วัน'"
                                        v-if="results[findResultIndex(consider.id)]['result_type'] == 'number'"
                                    >
                                        <b-form-input v-model="results[findResultIndex(consider.id)]['value']" @keypress="isNumber($event)"></b-form-input>
                                    </b-input-group>
                                    <!-- <my-date-picker
                                        v-if="results[findResultIndex(consider.id)]['result_type'] == 'date'"

                                        :id="consider.id"
                                        :showDate="result_show[findResultIndex(consider.id)]['value']"
                                        @update="value => results[findResultIndex(consider.id)]['value'] = value"
                                    ></my-date-picker> -->
                                    <thai-date
                                        v-if="results[findResultIndex(consider.id)]['result_type'] == 'date'"
                                        v-model="results[findResultIndex(consider.id)]['value']"
                                    ></thai-date>
                                    <check-gap
                                        v-if="results[findResultIndex(consider.id)]['result_type'] == 'gap'"
                                        v-model="results[findResultIndex(consider.id)]['value']"
                                    ></check-gap>
                                    <check-gap-2
                                        v-if="results[findResultIndex(consider.id)]['result_type'] == 'gap2'"
                                        v-model="results[findResultIndex(consider.id)]['value']"
                                    ></check-gap-2>
                                </div>
                            </consider-check>
                        </b-card>
                    </div>
                </b-col>
            </b-row>
            <b-row>
                <b-col>
                    <div class="text-center" style="margin-bottom:5px;">
                        <b-button type="submit" variant="primary" v-if="!rule_passed">ตรวจสอบเงื่อนไข</b-button>
                        <b-button  variant="danger" @click="clearData" v-if="rule_passed">ยกเลิก</b-button>
                    </div>

                </b-col>
            </b-row>
        </b-form>
    </div>

</template>

<script>
export default {
    props: ['refund_id','rule','refund_form_id','detail','refresh'],
    data(){
        return {
            office_id: this.$store.getters.office_id,
            results: null,
            result_show: null,
            result_tmp: [],
            alert: '',
            rule_select: 0,
            arr_rule_select: [],
            arr_detail: [],
            rule_passed: false,
            refund_status: this.$store.getters.refund_status,
            date_begin: null,
            date_end: null,
            send_prop: 'test',
            details: []
        }
    },
    watch: {
        // details(){
        //     if (details){
        //         this.createResult();
        //     }
        // },
        rule_select(newVal,oldVal){
            if (newVal){
                if (this.rule.result_type == 1){
                    this.select_rule(newVal);
                }

            }
        },
        async refresh(){
            if (this.refresh){
                this.results = await this.createResult();
                await this.getRefundDetail();
            }
            // this.results = await this.createResult();
            // await this.getRefundDetail();
        },
        rule_passed(newVal,oldVal){
            if (newVal == true){
                this.$emit("rule_passed", {id:this.rule.id,value:1});
            }else{
                this.$emit("rule_passed", {id:this.rule.id,value:0});
            }
        }
    },
    async mounted(){
        this.details = await this.getDetail();
        this.results = await this.createResult();
        if (this.rule.result_type == 2 && this.rule.sub_rules.length>1){
            this.$nextTick(()=>{
                for (let i=0; i<this.results.length; i++){
                    this.results[i]['selected'] = 1;
                }
            })

        }
        await this.getRefundDetail();
    },
    methods: {
        getBeginDate(val){
            if(val){
                let mydate = val.split("|");
                return mydate[0];
            }else{
                return ''
            }
        },
        getEndDate(val){
            if(val){
                let mydate = val.split("|");
                return mydate[1];
            }else{
                return ''
            }
        },
        isNumber: function(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();;
            } else {
                return true;
            }
        },
        getOptions(value){
            return value.split(",");
        },
        clearData(){
            if (this.rule_passed){

                this.$swal({
                title: "ต้องการลบข้อมูล ใช่หรือไม่",
                //text: `กรุณายืนยัน`,

                icon: "warning",
                closeOnClickOutside: false,
                buttons: [
                    'กลับ',
                    'ยืนยัน'
                ],

            })
            .then(isConfirm =>{
                if (isConfirm){
                    this.rule_passed = false;
                        if (this.rule.sub_rules.length > 1 && this.rule.result_type == 1){
                            this.rule_select = 0;
                            this.$nextTick(()=>{
                                for (let i=0; i<this.results.length; i++){
                                    console.log('type :' + this.results[i]['result_type']);
                                    this.results[i]['selected'] = 0;
                                    this.results[i]['status'] = 0;
                                    switch (this.results[i]['result_type']){
                                        case 'boolean' :
                                            this.results[i]['value'] = false;
                                            break;
                                        case 'inArray' :
                                        case 'gap' :
                                        case 'gap2' :
                                        case 'value' :
                                            this.results[i]['value'] = '';
                                            this.result_show[this.result_show.findIndex(x=>x.consider_id == this.results[i]['consider_id'])]['value'] = '';
                                            break;
                                        case 'date' :
                                            this.results[i]['value'] = '';
                                            this.result_show[this.result_show.findIndex(x=>x.consider_id == this.results[i]['consider_id'])]['value'] = '';

                                            break;
                                        case 'number' :
                                            this.results[i]['value'] = 0;

                                    }
                                }
                            })

                        }else{
                            console.log('result length :' + this.results.length);
                            this.$nextTick(()=>{
                                for (let i=0; i<this.results.length; i++){
                                    this.results[i]['status'] = 0;
                                    switch (this.results[i]['result_type']){
                                        case 'boolean' :
                                            this.results[i]['value'] = false;
                                            break;
                                        case 'inArray' :
                                        case 'gap' :
                                        case 'gap2' :
                                        case 'value' :
                                            this.results[i]['value'] = '';
                                            this.result_show[this.result_show.findIndex(x=>x.consider_id == this.results[i]['consider_id'])]['value'] = '';
                                            break;

                                        case 'date' :
                                            this.results[i]['value'] = '';
                                            this.result_show[this.result_show.findIndex(x=>x.consider_id == this.results[i]['consider_id'])]['value'] = '';

                                            break;
                                        case 'number' :
                                            this.results[i]['value'] = 0;
                                    }
                                }
                            })

                        }
                        //this.createResult();
                        let path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${this.refund_form_id}/refund_details`;
                        axios.post(`${path}`,
                        {
                            state: 'update-2',
                            detail: this.results
                        })
                    this.$nextTick(()=>{
                        let path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${this.refund_form_id}/refund_details`;
                        axios.get(`${path}`)
                        .then(response=>{
                            this.details = response.data.data;
                        })

                    })





                 }})

            }
        },

        async recheck_rule_pass(){
            let rule_pass = false;
            let status = 0;
            let path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${this.refund_form_id}/refund_details`;
            let response = await axios.get(`${path}`);
            let results = await response.data.data;
            let details = [];
            let result_tmp = [];
            if (this.arr_rule_select.length > 0){
                for (let i=0; i<this.arr_rule_select.length; i++){
                    let tmp = await results.filter(x=>x.rule_id == this.arr_rule_select[i]);
                    result_tmp = details;
                    details = result_tmp.concat(tmp);
                    // console.log('id "' + this.arr_rule_select[i] + 'result concat :' + details.length);
                }
            }else{
                details = await results.filter(x=>x.rule_id == this.rule_select);
            }

            for (let i=0; i<details.length; i++){
                status = await status + parseInt(details[i]['status']);
            }
            // console.log('detail length :' + details.length + 'pass :' + status);
            if (status != 0 && details.length == status){
                this.alert = 'pass';
                //console.log('rule passed !!')
                return  true;
            }else{
                this.alert = 'notpass';
                // console.log('rule not passed !!')
                return  false;
            }

        },
        async check_rule_pass(){
            let status = 0;
            let tmp = [];
            let tmp2 = [];
            if (this.arr_rule_select.length > 0){
                for (let i=0; i<this.arr_rule_select.length; i++){
                    let tmp3 = await this.results.filter(x=>x.rule_id == this.arr_rule_select[i]);
                    tmp2 = tmp;
                    tmp = tmp2.concat(tmp3);
                }
            }else{
                tmp = await this.results.filter(x=>x.rule_id == this.rule_select);
            }





            for (let i=0; i<tmp.length; i++){
                status = await status + parseInt(tmp[i]['status']);
            }
            this.$nextTick(() => {
                if (status != 0 && tmp.length == status){
                    this.rule_passed = true;
                }else{
                   this.rule_passed = false;
                }
                this.$forceUpdate();
            })
            return this.rule_passed;
        },
        select_rule(rule_id){
            for (let i=0; i<this.results.length; i++){
                this.$nextTick(() => {
                    if (this.results[i]['rule_id'] == rule_id){
                        this.results[i]['selected'] = 1
                    }else{
                        this.results[i]['selected'] = 0
                        this.results[i]['status'] = 0
                        this.details[this.details.findIndex(x=>x.consider_id == this.results[i]['consider_id'])]['status'] = 0;
                        switch (this.results[i]['result_type']){
                            case 'boolean' :
                                this.results[i]['value'] = false;
                                break;
                            case 'inArray' :
                            case 'gap' :
                            case 'value' :
                            case 'date' :
                                this.results[i]['value'] = '';
                                break;

                            case 'number' :
                                this.results[i]['value'] = 0;

                        }
                    }
                });
            }
        },
        async getRefundDetail(){
            let tmp = 0;

            if (this.rule.sub_rules.length > 0){
                if (this.rule.sub_rules.length == 1){
                    this.rule_select = this.rule.sub_rules[0]['id'];
                }else{
                    for (let i=0; i<this.results.length; i++){

                        if (this.results[i]['selected'] == 1){
                            tmp = this.results[i]['rule_id'];
                        }
                }
                if (!tmp == 0){
                    await this.$nextTick(() => {
                        this.rule_select = tmp;
                    });
                }
                }

            }else{
                await this.$nextTick(() => {
                    this.rule_select = this.rule.id;
                });
            }
            let pass = await this.check_rule_pass();




            setTimeout(() => {
                this.result_show = this.result_tmp;
            }, 500);
        },
        async getDetail(){

            let path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${this.refund_form_id}/refund_details`;
            let response = await axios.get(`${path}`);
            let details = await response.data.data;
            return details;

        },
        async createResult(){
            let tmp = [];
            this.result_tmp = [];
            this.result_show = [];
            if (this.rule.sub_rules.length > 0){

                for (let i=0; i<this.rule.sub_rules.length; i++){
                    //result_type == 2 (AND)
                    if (this.rule.result_type == 2 && this.rule.sub_rules.length > 1){
                        this.arr_rule_select.push(this.rule.sub_rules[i].id)
                    }

                    for (let j=0; j<this.rule.sub_rules[i]['considers'].length; j++){
                        let detail = await this.findDetail(this.rule.sub_rules[i]['considers'][j].id);
                        await tmp.push(detail);
                    }
                }
            }else{
                for (let j=0; j<this.rule.considers.length; j++){
                    let detail = await this.findDetail(this.rule.considers[j].id);
                    await tmp.push(detail);
                }
            }
            return tmp;
        },
        findDetail(consider_id){
            let detail = null;
            let index = this.details.findIndex(x=>x.consider_id == consider_id);
            detail = _.cloneDeep(this.details[index]);
            if (detail){
                //console.log('find detail :' + consider_id + ' index : ' + index + ' type :' + detail.result_type);
                if (detail.result_type == 'boolean'){
                    detail.value = (detail.value == 1) ? true : false;
                }
                this.result_tmp.push(
                    {
                        "consider_id" : detail.consider_id,
                        "value" : detail.value
                    }
                );
                this.result_show.push(
                    {
                        "consider_id" : detail.consider_id,
                        "value" : ""
                    }
                );
            }
            return detail;
        },
        findResultIndex(consider_id){
            return this.results.findIndex(x=>x.consider_id == consider_id);
        },
        async sentResult(){
            let result_detail = [];
            let result_tmp = []
            console.log('sent detail :');
            if (this.arr_rule_select.length > 0){
                for (let i=0; i<this.arr_rule_select.length; i++){
                    let tmp = await this.results.filter(x=>x.rule_id == this.arr_rule_select[i]);
                    result_tmp = result_detail;
                    result_detail = result_tmp.concat(tmp);
                }
            }else{
                result_detail = await this.results;
            }


            console.log('sent detail :' + result_detail.length);
            let path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${this.refund_form_id}/refund_details`;
            let tmp = await axios.post(`${path}`,
                {
                    state: 'update-2',
                    detail: result_detail
                })

            //this.arr_detail.push(tmp);
            // for (let i=0; i< rule.considers.length; i++){
            //     let arr_detail = [];
            //     await arr_detail.push(this.results[this.results.findIndex(x=>x.consider_id == consider_id)]);
            //     let consider_id = rule.considers[i]['consider_id']
            //     let tmp = await axios.post(`${path}`,
            //         {
            //             state: 'update-2',
            //             detail: arr_detail
            //         })
            //     result_detail.push(tmp);
            // }
            //this.arr_detail = result_detail;
        },
        async onSubmit(e){
            e.preventDefault();

            //var path = `/api/offices/${this.office_id}/refunds/${this.refund_id}/refund_forms/${this.refund_form_id}/refund_details`;
            if (this.rule.sub_rules.length > 1){  //Has Sub Rule

                //let sub_rule = await this.rule.sub_rules;
                if (this.rule.result_type == 1){  // หรือ

                    if (this.rule_select != 0){

                        //let tmp_rule = await sub_rule[sub_rule.findIndex(x=>x.id == this.rule_select)]
                        let result = await this.sentResult();
                    }
                }else{
                    let result = await this.sentResult();
                }
            }else{ //Main Rule
                let result = await this.sentResult();
            }
            this.details = await this.getDetail();
            this.results = await this.createResult();
            await this.getRefundDetail();
            //let update = await this.$emit("update_detail");
            // let check = await this.recheck_rule_pass();
            // console.log("check :" + check);
            this.rule_passed = await this.recheck_rule_pass();

            if (this.rule_passed){
                // this.alert = 'pass';
                this.$emit("rule_passed", {
                    id:this.rule.id,
                    value : 1
                });
            }else{
                // this.alert = 'notpass';
                this.$emit("rule_passed", {
                    id:this.rule.id,
                    value : 0
                });
            }
        }

    }
}

</script>

<style scoped>
.card {
    margin-bottom: 5px!important;
}
.card-body{
    padding: 10px!important;
}
.custom-select{
    color: #000!important;
}
</style>
