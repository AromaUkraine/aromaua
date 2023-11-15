<template>
  <form
    class="form"
    id="form_chouse"
    v-if="show"
    @submit.prevent="submitHandler"
    ref="form"
  >
    <span class="form-chouse__title">{{ __t("web.Need_help_choosing") }}</span>
    <p class="form-chouse__text">
      {{
        __t(
          "web.Request a call back and our managers will contact you as soon as possible time."
        )
      }}
    </p>
    <div class="form-chouse__inputs">

        <v-input
            type="text"
            v-model.trim="$v.name.$model"
            name="name"
            :error="validationError($v, 'name')"
            :errorClass="( isDisabled ) ? 'error' : ''"
            :inputClass="($v.name.$model.length) ? 'has-content' : ''"
            :errorMessage="__t('web.enter_your_name')"
            :label="__t('web.your_name')"
        ></v-input>

        <v-phone-number
            v-model.trim="$v.phone.$model"
            :error="validationError($v, 'phone')"
            :errorMessage="__t('web.enter_the_number')"
            :errorClass="( isDisabled ) ? 'error' : ''"
            :inputClass="($v.phone.$model.length) ? 'has-content' : ''"
            name="phone"
            :label="__t('web.your_phone')"
        ></v-phone-number>

        <magnific-popup-modal ref="modal" @close="closeModal" id="modal-successful">
          <p class="modal__message">{{__t('web.In the near future, our manager will contact you')}}</p>
        </magnific-popup-modal>

    </div>
    <button class="btn" type="submit">{{ __t("web.send_message") }}</button>
  </form>
</template>

<script>
import { required, minLength, maxLength } from "vuelidate/lib/validators";
import errors from "../../mixins/form-errors.mixin";


export default {
  name: "VFormHelp",
  mixins: [errors],
  props: {
    show: {
      title: String,
      likes: Boolean,
      default() {
        return false;
      },
    },
  },
  data: () => ({
    name: "",
    phone: "",
    terms: false,
  }),
  validations: {
    name: {
      required,
    },
    phone: {
      required,
    },
  },
    computed:{
        isDisabled(){
            return this.$v.$invalid
        },

    },
  methods: {
    submitHandler() {
        this.$v.$touch();

        if(!this.$v.$invalid) {
            console.log("submit");
            this.$refs.modal.open();
        }
    },
  isEmpty(name){
      console.log(name)
      //return !!this.email.length
  },
    closeModal(){
        this.name="";
        this.phone="";
        this.$v.$reset();
    }
  },
};
</script>

