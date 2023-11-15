<template>
    <div id="printMe" @click="print">
        <slot></slot>
    </div>
</template>

<script>

export default {
    methods:{
        async print (event) {

            if(event.target.tagName === 'svg'){
                await this.$htmlToPaper('printMe');
            }

        }
    },
}
</script>
