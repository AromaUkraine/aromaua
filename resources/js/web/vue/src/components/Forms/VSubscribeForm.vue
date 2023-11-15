<template>
    <form class="subscribe__form" @submit.prevent="submitHandler" ref="form">
        <div class="subscribe__container">
            <v-input
                type="text"
                v-model.trim="$v.email.$model"
                name="email"
                :error="(validationError($v, 'email') || formError('email'))"
                :errorClass="( isDisabled ) ? 'error' : ''"
                :inputClass="(isEmpty) ? 'has-content' : ''"
                :errorMessage="formError('email')"
                :label="__t('web.your_email')"
            ></v-input>
            <magnific-popup-modal ref="modal" @close="closeModal" id="modal-subscribe">
                <p class="modal__message">{{__t('web.You have successfully subscribed to the newsletter')}}</p>
            </magnific-popup-modal>

            <button type="submit" class="subscribe__submit btn">{{ __t('web.subscribe') }}</button>
        </div>
    </form>
</template>

<script>
import {required, email} from 'vuelidate/lib/validators'
import errors from "../../mixins/form-errors.mixin";

export default {
    name: "VSubscribeForm",
    mixins: [errors],
    data: () => ({
        email: "",
        terms: false,
    }),
    validations: {
        email: {required, email}
    },
    computed:{
        isDisabled(){
            return this.$v.$invalid
        },
        isEmpty(){
            return !!this.email.length
        },
    },
    methods: {

        async submitHandler() {

            this.$store.dispatch('clearError');

            this.$v.$touch();

            if (!this.$v.$invalid) {

                await this.$store.dispatch('subscribe', {email:this.email}).then((response)=>{
                    this.$refs.modal.open();
                }).catch( (errror) => {});
            }
        },
        closeModal(){
            this.email="";
            this.$v.$reset();
        }
    }
}
</script>

<style scoped>

</style>
