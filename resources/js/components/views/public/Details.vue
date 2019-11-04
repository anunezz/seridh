<template>
<div class="container">
    <div class="row">
    Estos son los detalles ......
    {{jsonDetails}}


        <div class="card" style="width: 100%">
        <div class="card-header">
            Detalle ejemplo....
        </div>
            <div class="card-body">
                CUERPO DEL DETALLE
            </div>
        </div>




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


