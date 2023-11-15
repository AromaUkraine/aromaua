<template>
    <div class="modal mfp-hide" ref="modal" :id="id">
      <div class="modal__header">
        <button class="modal__close" @click="close" type="button" title="Закрыть"></button>
      </div>
      <div class="modal__body">
         <slot></slot>
      </div>
    </div>

</template>


<script>

  import $ from 'jquery'
  import 'magnific-popup'

  export default {
    name: 'magnific-popup-modal',

    props: {
      show: {
        type: Boolean,
        default: false
      },
      id: {default(){ return 'modal-successful'}},
      config: {
        type: Object,

        default: function () {
            // console.log(this.id);
          return {
            items: { src: '#'+ this.id },
            // magnific defaults
            showCloseBtn: false,
            type: 'ajax',
            preloader: true,
            fixedBgPos: true,
            fixedContentPos: true,
            removalDelay: 500,
            midClick: true
          }
        }
      }
    },

    data () {
      return {
        visible: this.show
      }
    },

    mounted () {
      this[this.visible ? 'open' : 'close']()
    },

    methods: {

      /**
       * Opens the modal
       * @param {object} options Last chance to define options on this call to Magnific Popup's open() method
       */
      open: function (options) {
        if (!!$.magnificPopup.instance.isOpen && this.visible) {
          return
        }

        let root = this

        let config = _.extend(
          this.config,
          {
            items: {
              src: $(this.$refs.modal),
              type: 'inline'
            },
            callbacks: {
              open: function () {
                root.visible = true
                root.$emit('open')
              },
              close: root.close
            }
          },
          options || {})

        $.magnificPopup.open(config)
      },

      /**
       * Closes the modal
       */
      close: function () {
        if (!$.magnificPopup.instance.isOpen && !this.visible) {
          return
        }

        this.visible = false
        $.magnificPopup.close()
        this.$emit('close')
      },

      /**
       * Toggles modal open/closed
       */
      toggle: function () {
        this[this.visible ? 'close' : 'open']()
      }
    }
  }

</script>


