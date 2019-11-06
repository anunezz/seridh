<template>
<div class="container">
    <div class="row">

    <div class="col-md-12">
        <h3>
            Detalles de la recomendación
        </h3>
    </div>


<div class="card" style="width: 100%;">
    <div class="card-header">
         Featured
    </div>
    <div class="card-body">
         Featured
    </div>
</div>


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


