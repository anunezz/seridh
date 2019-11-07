<template>
<div class="container">
    <div class="row" style="padding-bottom: 50px;">

    <div class="col-md-12">
      <h2>Recomendación detallada</h2>
      <hr class="red small-margin">
    </div>

     <div class="col-md-12">
         <h5> Recomendación</h5>
      <p v-text="reccommendation"></p>
     </div>


    <div class="col-md-4">
      <div class="row">
        <div class="col-md-12">
            <h5>Entidad Emisora</h5>
        </div>
        <div class="col-md-12">
           <ul style="list-style:none; margin:0; padding:0;">
               <li v-text="entity"></li>
           </ul>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="row">
        <div class="col-md-12">
            <h5>Orden de gobierno</h5>
        </div>
        <div class="col-md-12">
           <ul style="list-style:none; margin:0; padding:0;">
               <li v-for="(item,index) in catGobOrder" :key="index" v-text="item"></li>
           </ul>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="row">
        <div class="col-md-12">
            <h5>Poder de gobierno</h5>
        </div>
        <div class="col-md-12">
           <ul style="list-style:none; margin:0; padding:0;">
               <li v-for="(item,index) in CatGobPower" :key="index" v-text="item"></li>
           </ul>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="row">
        <div class="col-md-12">
            <h5>Autoridad</h5>
        </div>
        <div class="col-md-12">
           <ul style="list-style:none; margin:0; padding:0;">
               <li v-for="(item,index) in CatAttending" :key="index" v-text="item"></li>
           </ul>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="row">
        <div class="col-md-12">
            <h5>Acción Solidaria</h5>
        </div>
        <div class="col-md-12">
           <ul style="list-style:none; margin:0; padding:0;">
               <li v-for="(item,index) in CatSolidarityAction" :key="index" v-text="item"></li>
           </ul>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="row">
        <div class="col-md-12">
            <h5>Población</h5>
        </div>
        <div class="col-md-12">
           <ul style="list-style:none; margin:0; padding:0;">
               <li v-for="(item,index) in population" :key="index" v-text="item"></li>
           </ul>
        </div>
      </div>
    </div>



    <!-- <div class="col-md-4">
      Entidad emisora
    </div>

    <div class="col-md-4">
      Poder de gobierno
    </div>
   Id de la recomendación {{ jsonDetails }} -->

    </div>
</div>
</template>


<script>
export default {
 data(){
     return{
      jsonDetails:[], //json
      reccommendation:'', //Recomendación
      entity:'', //Entidad emisora
      catGobOrder:[],//Orden de gobierno
      CatGobPower:[],//Poder de gobierno
      population:[], //Poblacion
      CatAttending:[], //Autoridad,
      CatSolidarityAction:[]//Acción solidaria
     }
 },
 methods:{
   fnrecommendation(Details){
     let me = this;
     me.jsonDetails;
        axios.post('/api/public/detailsRecommendation',{
            'details': Details
        }).then(function (response) {

            console.log("RESPOSE: ",response);
           //return;

            if(response.data.success === true){
            me.reccommendation = response.data.lResults.recommendation;
            me.entity =  response.data.lResults.entity;
            me.population = response.data.lResults.population;
            me.catGobOrder = response.data.lResults.catGobOrder;
            me.CatGobPower = response.data.lResults.CatGobPower;
            me.CatAttending = response.data.lResults.CatAttending;
            me.CatSolidarityAction = response.data.lResults.CatSolidarityAction;

            console.log("RECOMENDACION DETALLES: ",response.data);

            }else{
            //  alert("Error fnrecommendation;");
            }
        }).catch(function (error) {
            console.log(error);
        });
   }
 },
 mounted(){
   let me = this;
   me.jsonDetails = me.$route.params.json;
   window.scrollTo(0,0);

  me.fnrecommendation(me.jsonDetails);


 }
}
</script>

<style lang="stylus" scoped>

</style>


