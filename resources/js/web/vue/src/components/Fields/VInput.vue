<template id="template">
    <div class="form__group">
        <input
            :type="type"
            :value="value"
            :name="name"
            @input="$emit('input', $event.target.value)"
            :placeholder="placeholder"
            class="form__input"
            :class="bindClass"
             />
        <label class="error" v-if="error">{{errorMessage}}</label>
        <label class="form__label" :for="id">{{label}}</label>
    </div>
</template>
<!--{error:error}-->
<script>
export default {
    props: {
        type: {default() { return 'text'; }},
        error: {default() { return false }},
        errorClass: {default() { return '' }},
        value: '',
        placeholder:{},
        name: {},
        inputClass: {default() { return 'form__input' }},
        errorMessage:{default() { return 'error';}},
        id:{default(){ return 'name'}},
        label:{default(){return 'Name';}}
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

<style scoped>

</style>
