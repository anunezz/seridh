<template>
<div class="container">
    <div class="row">


   Id de la recomendación {{ jsonDetails }}

    </div>
</div>
</template>


<script>
export default {
 data(){
     return{
      jsonDetails:[]
     }
 },
 methods:{

 },
 mounted(){
   let me = this;
   me.jsonDetails = me.$route.params.json;
 }
}
</script>

<style lang="stylus" scoped>

</style>


