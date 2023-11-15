<template>
    <div class="skeleton flex" v-if="loading">
        <div class="load__paragraph left">
            <div  class="load load__text load__title"></div>
            <div class="load load__text"></div>
            <div class="load load__text"></div>
            <div class="load load__text"></div>
            <div class="load load__text"></div>
            <div class="load load__text"></div>
            <div class="load load__text"></div>
            <div class="load load__text"></div>
            <div class="load load__text"></div>
            <div class="load load__text"></div>
            <div class="load load__text"></div>
        </div>
        <div class=" right">
            <div class="load load__image"></div>
        </div>
    </div>
</template>

<script>
export default {
    name: "VSkeletonOfficeWithMap",
    props: ['loading'],
}
</script>
<style lang="scss" scoped>

.flex{
    display: flex;
}
.left{
    flex: 0 0 480px;

    height: 367px;
    padding-right: 30px !important;
    .load {
        &__text{
            height: 16px;
            margin-bottom: 10px;
        }
        &__title{
            height: 30px;
            margin-bottom: 30px;
        }
    }

}
.right {
    flex: 1 1 auto;
    height: 343px;
    padding: 12px;
    .load__image{
        height: 100%;
    }
}
@media (max-width: 767px) {
    .flex{
        display: block;
    }
}
</style>
