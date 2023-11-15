<template>
    <div class="modal" id="modal-successful">
      <div class="modal__header">
        <button class="modal__close" type="button" title="Закрыть"></button>
      </div>
      <div class="modal__body">
        <p class="modal__message">В ближайшее время наш менеджер свяжется с Вами.</p>
      </div>
    </div>
</template>

<script>
export default {
    data:()=>({

    }),
    mounted(){
        eventBus.$on('showModalSuccess', function(data){
            console.log(data);
        })
    }
}
//  mfp-hide
</script>
