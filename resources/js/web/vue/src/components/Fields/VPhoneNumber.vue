<template>
    <div class="form__group">
        <input
            :type="type"
            :value="value"
            v-mask="mask"
            class="form__input"
            :class="bindClass"
            :placeholder="placeholder"
            :errorMessage="errorMessage"
            @input="$emit('input', $event.target.value)"
        />
        <label class="error" v-if="error">{{errorMessage}}</label>
        <label class="form__label" :for="id">{{label}}</label>
    </div>
</template>
<script>
import { VueMaskDirective } from 'v-mask'
import { VueMaskFilter } from 'v-mask'

Vue.directive('mask', VueMaskDirective);
Vue.filter('VMask', VueMaskFilter)

export default {
    name: "VPhoneNumber",
    props: {
        type: {default() { return 'text'; }},
        error: {default() { return false }},
        value: '',
        mask: {default() {
                return ['+38 (',/\d/, /\d/, /\d/, ') ', /\d/, /\d/, /\d/, ' ', /\d/, /\d/, /\d/, /\d/];
        }},
        placeholder:{},
        name: {},
        inputClass: {default() { return '' }},
        errorMessage:{default() { return 'error';}},
        errorClass: {default() { return '' }},
        id:{default(){ return 'phone'}},
        label:{default(){return 'Phone';}}
    },
    computed:{
        bindClass(){
            let bindClass = '';
            if(this.error){
                bindClass = this.errorClass;
            }
            if(this.inputClass.length) {
                bindClass += ' '+this.inputClass
            }

            return bindClass;
        }
    }
}
</script>
