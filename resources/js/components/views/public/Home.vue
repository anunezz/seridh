<template>
<div  v-loading="loading"  element-loading-text="Buscando recomendaciones..."
                           element-loading-spinner="el-icon-loading"
                           element-loading-background="rgba(0, 0, 0, 0.8)">
		<div id="myCarousel" class="carousel slide" data-ride="carousel" style="max-height: 450px;">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#myCarousel" data-slide-to="1"></li>
				<li data-target="#myCarousel" data-slide-to="2"></li>
                <li data-target="#myCarousel" data-slide-to="3"></li>
                <li data-target="#myCarousel" data-slide-to="4"></li>
			</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner">
				<div class="item active">
					<img src="img/slider/bg.png" style="width:100%; height: 450px;">
				</div>

				<div class="item">
					<img src="img/slider/3.jpg" style="width:100%;height: 450px;">
				</div>

				<div class="item">
					<img src="img/slider/4.jpg" style="width:100%;height: 450px;">
				</div>

				<div class="item">
					<img src="img/slider/11.jpg" style="width:100%;height: 450px;">
				</div>

				<div class="item">
					<img src="img/slider/la.jpg" style="width:100%;height: 450px;">
				</div>

			</div>
	        <div data-v-ce5e9132="" class="container"><div data-v-ce5e9132="" id="topsearch">
				<a data-v-ce5e9132="" href="#" role="button" target="_blank" class="btn btn-top-search">IR AL CATÁLOGO</a><a data-v-ce5e9132="" href="#" role="button" target="_blank" class="btn btn-top-search">ESPAÑOL</a><a data-v-ce5e9132="" href="#" role="button" target="_blank" class="btn btn-top-search">ENGLISH</a></div></div>


			<!-- Left and right controls -->
			<a class="left carousel-control" href="#myCarousel" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left"></span>
				<span class="sr-only">Anterior</span>
			</a>
			<a class="right carousel-control" href="#myCarousel" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right"></span>
				<span class="sr-only">Siguiente</span>
			</a>
		</div>
		<div class="sub_banner">

		</div>

		<br/>

		<main class="page">
	      <div class="container">
	      	<div class="gobierno">
                <div class="col-md-12 hidden-sm hidden-md hidden-lg small-top-buffer">
                <a href="#secretarias">18 Secretarías</a><br>
                <a href="#dependencias">299 Entidades del Gobierno</a><br>
                <a href="#estados">32 Estados y sus municipios</a><br>
                <a href="/gobierno/mexico-en-el-mundo">146 Embajadas y consulados</a>
                </div>

            <div class="row">
                <div class="col-md-3 hidden-xs">
                    <div class="media office-sm-structure circle-quotes">
                        <a href="#secretarias">
                            <figure>
                                <h2 v-text="countRecommendations"></h2>
                                <p>Recomendaciones</p>
                            </figure>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 hidden-xs">
                    <div class="media office-sm-structure circle-quotes">
                        <a href="#dependencias">
                            <figure>
                                <h2 v-text="issuingEntities"></h2>
                                <p>Entidades emisoras</p>
                            </figure>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 hidden-xs">
                    <div class="media office-sm-structure circle-quotes">
                        <a href="#estados">
                            <figure>
                                <h2>32</h2>
                                <p>Temas</p>
                            </figure>
                        </a>
                    </div>
                </div>
	        <div class="col-md-3 hidden-xs">
                <div class="media office-sm-structure circle-quotes">
                    <a href="/gobierno/mexico-en-el-mundo">
                        <figure>
                            <h2 v-text='visitas'></h2>
                            <p>Visitas</p>
                        </figure>
                    </a>
                </div>
	        </div>
            </div>

	      </div>


            <div class="row">
                <div class="col-md-12">
                    <h2>¿Qué es el SERIDH?</h2>
                    <hr class="red small-margin">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                </div>
            </div>




<div class="row">
    <div class="col-md-12">
      <h2>Búsqueda Avanzada de Recomendaciones</h2>
      <hr class="red small-margin">
    </div>
    <div class="col-md-12">
        <div class="panel-body animated fadeIn fast">
            <div class="card">
                <div class="card-body" style="padding: 5px;">
                    <div class="col-md-3" v-for="(item,index) in arrayFilter" :key="index" style="padding: 5px;">
                        <div v-if="item.label !== 'Buscar'" class="first" v-bind:class="[item.btn === false ? '' :'firstClik']" style="padding: 5px!important;" @click="panelBusqueda(item)" if>
                            <div v-text="item.label" style="float:left; width: 85%;"> {{item.label}} </div>
                            <div style="float:left; width: 10%;" class="text-right"><span v-bind:class="[item.btn === false ? 'glyphicon glyphicon-chevron-up' : 'glyphicon glyphicon-chevron-down']" aria-hidden="true"></span></div>
                        </div>
                        <div v-else class="first firstSearch" style="padding: 5px!important;" @click="recommendationFilter()">
                            <div v-text="item.label" style="float:left; width: 85%;"> {{item.label}} </div>
                            <div style="float:left; width: 10%;" class="text-right"><span class="icon-search" aria-hidden="true"></span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card" v-if="cardCheckbox === true">
                <div class="card-body col-md-12" style="padding: 20px;">

                        <div class="row">
                            <div class="col-md-12">
                                <h4>Seleccionar</h4>
                            </div>

                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" placeholder="Buscar">
                            </div>
                        </div>


                    <div v-for="(item,index) in arrayFilter" :key="index">
                        <div v-if="btnSelect === item.id && item.id !== 0 && item.id !== 6 ">
                            <div class="form-check animated fadeIn fast" v-for="(i,index) in item.data" :key="index">
                                <label class="form-check-label">
                                    <input @change="checkbox(item.id,i.id,i.name)" type="checkbox" class="form-check-input" :value="i.id" v-model="checkedNames[item.id].check">
                                    {{i.name}}
                                </label>
                            </div>
                        </div>
                        <div v-else-if="btnSelect === item.id && item.id === 0">
                            <div class="form-check animated fadeIn fast" v-for="(i,index) in item.data" :key="index">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" :value="i.year" v-model="checkedNames[item.id].check">
                                    {{i.year}}
                                </label>
                            </div>
                        </div>

                        <div v-else-if="btnSelect === item.id && item.id === 6">
                            <ul>
                                <li v-for="(itemUno,indexUno) in item.data" :key="indexUno">
                                    <div class="form-check animated fadeIn fast">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" :value="itemUno.id">
                                            {{itemUno.name}}
                                        </label>
                                    </div>

                                    <ul>
                                        <li v-for="(itemDos,indexDos) in  itemUno.data" :key="indexDos">
                                            <!-- <span v-text="itemDos.name"></span> -->
                                                <div class="form-check animated fadeIn fast">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input" :value="itemDos.id" v-model="checkedNames[item.id].check">
                                                        {{itemDos.name}}
                                                    </label>
                                                </div>
                                            <ul>
                                                <li v-for="(itemTres,indexTres) in itemDos.data" :key="indexTres">
                                                    <span v-text="itemTres.name"></span>
                                                    <ul>
                                                        <li v-for="(itemCuatro,indexCuatro) in itemTres.data" :key="indexCuatro">
                                                            <span v-text="itemCuatro.name"></span>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>





                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{checkedNames}}

	        <h2>Enlaces de interés</h2>
	        <hr class="red small-margin">
	        <div class="row categorias">

	        	<div class="col-sm-6 col-md-6 col-lg-3">
	        		<div class="card text-center card-gob">
		        		<div class="titulocategoria">
		        			<div style="background: #2769c6;padding: 1em;">
		        				<img data-v-ce5e9132="" src="img/logo-onu.png" alt="">
		        			</div>
	        				<h4 data-v-ce5e9132="" class="card-title">
                        	Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                 			</h4>
                 			<br/>
                 			<a data-v-ce5e9132="" class="btn btn-categorias">Ir al enlace &gt;</a>
	                 	</div>
                 	</div>
	        	</div>

	        	<div class="col-sm-6 col-md-6 col-lg-3">
	        		<div class="card text-center card-gob">
		        		<div class="titulocategoria">
		        			<div style="background: #0468b1;padding: 1em;">
		        				<img data-v-ce5e9132="" src="img/pnud-logo-30.svg" style="height: 54px;" alt="">
		        			</div>
	        				<h4 data-v-ce5e9132="" class="card-title">
                        	Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                 			</h4>
                 			<br/>
                 			<a data-v-ce5e9132="" class="btn btn-categorias">Ir al enlace &gt;</a>
	                 	</div>
                 	</div>
	        	</div>
	        	<div class="col-sm-6 col-md-6 col-lg-3">
	        		<div class="card text-center card-gob">
		        		<div class="titulocategoria">
		        			<div style="background: #0468b1;padding: 1em;">
		        				<img data-v-ce5e9132="" src="img/pnud-logo-30.svg" style="height: 54px;" alt="">
		        			</div>
	        				<h4 data-v-ce5e9132="" class="card-title">
                        	Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                 			</h4>
                 			<br/>
                 			<a data-v-ce5e9132="" class="btn btn-categorias">Ir al enlace &gt;</a>
	                 	</div>
                 	</div>
	        	</div>
	        	<div class="col-sm-6 col-md-6 col-lg-3">
	        		<div class="card text-center card-gob">
		        		<div class="titulocategoria">
		        			<div style="background: #0468b1;padding: 1em;">
		        				<img data-v-ce5e9132="" src="img/pnud-logo-30.svg" style="height: 54px;" alt="">
		        			</div>
	        				<h4 data-v-ce5e9132="" class="card-title">
                        	Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                 			</h4>
                 			<br/>
                 			<a data-v-ce5e9132="" class="btn btn-categorias">Ir al enlace &gt;</a>
	                 	</div>
                 	</div>
	        	</div>
	        </div>

	      </div>
	    </main>


</div>
</template>

<script>
    export default {
        data() {
            return {
              countRecommendations:0,
              idPage: 1,
              cardCheckbox:false,
              visitas:0,
              issuingEntities: 0,
              arrayFilter:[],
              checkedNames:[],
              btnSelect:0,
              loading:false,
              tableData:[],
              results:{},
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
            };
        },
        computed: {
        },
        created() {
        },
        methods: {
            treeDerechosHumanos(){
             let me = this;
            },
            checkbox(key,value,name){
             let me = this;
             console.log("Estas ern la funcion checkbox: ",key,value,name);

            },
            filters(){
              let me = this;
              let suma = 0;
              let data = {};

              for (let i = 0; i < me.checkedNames.length; i++) {
                  if(me.checkedNames[i].check.length > 0){
                    suma = suma + 1;
                  }else{
                     suma = suma + 0;
                  }
              }

              if(suma === 0 ){
                  me.message("warning","Sin results.");
              }else{
                 data.check = me.checkedNames;
                 data.names = me.arrayFilter;
                 me.$router.push({name:'PublicFilter', params: {json: data }});
                 //me.$router.push({path: '/publico/filtros', params: {json:me.checkedNames }});
              }

            },
            panelBusqueda(item){
                let me = this;
                for (let i = 0; i < me.arrayFilter.length; i++) {
                    me.arrayFilter[i].btn = false;
                    if(me.arrayFilter[i].id === item.id){
                          me.arrayFilter[i].btn = (me.arrayFilter[i].btn === false)? true : false;
                          me.btnSelect = me.arrayFilter[i].id;
                          me.cardCheckbox = true;
                    }
                }
            },
            count(){
             let me = this;
                axios.get('/api/public/recommendations/count').then(function (response) {
                    me.countRecommendations = response.data.recommendation;
                    me.issuingEntities = response.data.issuingEntities;
                }).catch(function (error) {
                    console.log(error);
                });
             me.countRecommendations ='';
            },
            visits(){
                let me = this;
                axios.post('/api/public/visits',{
                    'id': me.idPage
                }).then(function (response){
                   // console.log("RESPONSE VISITS: ",response);
                    me.visitas = response.data.lResults;
                }).catch(function (error) {
                    console.log(error);
                });
            },
            labelForm(){
             let me = this;
                axios.get('/api/public/recommendations/labelsForm').then(function (response) {
                  console.log("LabelsForm: ",response.data.lResults);
                  for (let i = 0; i < response.data.lResults.length; i++){
                      me.arrayFilter.push({ id: response.data.lResults[i].id,
                                         label: response.data.lResults[i].name,
                                           btn: false,
                                          data: response.data.lResults[i].data });

                       me.checkedNames.push({id: response.data.lResults[i].id,
                                          check: []})
                  }


                  console.log("arrayFilter: ",me.arrayFilter);

                }).catch(function (error) {
                    console.log(error);
                });
            },
            viewRecommendations(data){
                let me = this;
                console.log("Nueva funcion de recomendaciones....",data);
                $("#modalFilter").modal('hide');

                setTimeout(item =>{
                 this.$router.push( '/publico/filtros' );
              //  me.$router.push({path: '/publico/filtros',array:1});
                // /publico/filtros/
                //, params: { array: data}
                // me.$router.push({
                //     name: 'PublicFilter',
                //     id: data });
                },500);


            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.recommendationFilter(page);
            },
            recommendationFilter(){
              let me = this,url='',data={};
                    data={
                        'date': me.checkedNames[0].check,
                        'entity_id':me.checkedNames[1].check,
                        'population_id': me.checkedNames[2].check,
                        'attending_id': me.checkedNames[4].check,
                        'ods_id': me.checkedNames[5].check
                    };
                  axios.post('/api/public/recommendationFilter', data).then(function (response){
                     if(response.data.success === true){
                        console.log("RESPONSErecommendationFilter(): ",response);
                       // return;
                        let datos = {};
                        datos.check = me.checkedNames;
                       // datos.names = me.arrayFilter;
                        datos.names = response.data.lResults.checkNames;
                        datos.count = response.data.lResults.count;
                        datos.jsonFilters = response.data.lResults.jsonFilters;
                        me.$router.push({name:'PublicFilter', params: {json: datos }});
                     }else{

                     }
                }).catch(function (error) {
                    me.loading=false;
                    console.log(error);
                });
            },
            message(type,msj){
            let me = this;
                    this.$message({
                        message: msj,
                        type: type
                    });
            },
            changeValuesNames(value){
            let me = this;
            console.log("Value: ",value);
            },
            transformNamesTableColums(value,num){

                console.log("Formando el nombre de la columna");
                console.log(value,num);

                if(num === 0){
                    value = value.substr(0,4);
                 return value;
                }
                console.log("transformacion de datos: ",value,num);

                let me = this,valueColumTable = '',nametable='',i='',name='';
                nametable = me.arrayFilter.find(item => item.id === num);
                for (let i = 0; i < nametable.data.length; i++) {
                  if(nametable.data[i].id === value){
                    name = nametable.data[i].name;
                  }
                }
                return name;
            },
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;

            }
        },
        mounted(){
            let me = this;
            me.count();
            me.visits();
            me.labelForm();
        }
    }
</script>

<style scoped>
.sub_banner{
	text-align: center;
}
.card {
    position: relative;
    display: -ms-flexbox;
    display: -webkit-box;
    display: flex;
    -ms-flex-direction: column;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0,0,0,.125);
    border-radius: .25rem;
}
a[data-v-2e10a77a]:link{text-decoration:none;color:#fff!important}a[data-v-2e10a77a]:hover{text-decoration:underline;color:#38a2f9!important}a[data-v-2e10a77a]:visited{text-decoration:none;color:#fff!important}.panel-footer[data-v-2e10a77a]{font-family:Montserrat;font-size:85%;color:#fff;line-height:135%;background-image:url(https://framework-gb.cdn.gob.mx/landing/img/fondofooter.svg);height:auto;background-size:cover}#division[data-v-2e10a77a]{margin-top:25%}#mail[data-v-2e10a77a]{margin-top:-6%}@media only screen and (max-width:600px){#division[data-v-2e10a77a]{margin-top:5%}.logo_footer[data-v-2e10a77a]{width:75%;margin-top:25%!important;margin-left:0!important;padding-left:0;-ms-flex-line-pack:center;align-content:center}#redes[data-v-2e10a77a]{margin-top:10%!important}#mail[data-v-2e10a77a]{line-height:300%}}@media screen and (min-width:1600px){.container[data-v-2e10a77a]{max-width:5000px!important;width:80%!important}}@media only screen and (min-width:768px) and (max-width:1024px){#mail[data-v-2e10a77a]{font-size:81%}}[data-v-ce5e9132]:focus{-webkit-box-shadow:0 0 0 0 #000!important;box-shadow:0 0 0 0 #000!important}.global[data-v-ce5e9132]{font-family:Montserrat,sans-serif;margin-bottom:3rem}.dorado[data-v-ce5e9132]{color:#b38e5d}.doradoclaro[data-v-ce5e9132]{color:#d4c19c}.elemento-oculto[data-v-ce5e9132]{position:absolute!important;clip:rect(1px 1px 1px 1px);clip:rect(1px,1px,1px,1px)}#carouselMainGobmxHead[data-v-ce5e9132]{position:relative}.carousel-indicators[data-v-ce5e9132]{margin:3px}.carousel-indicators li[data-v-ce5e9132]{background-color:#9d2449;height:10px;width:10px;border-radius:50%;border:1px solid #fff;margin-bottom:5px}.carousel-control-next[data-v-ce5e9132],.carousel-control-prev[data-v-ce5e9132]{width:5%}#topsearch[data-v-ce5e9132]{color:#fff;position:absolute;bottom:20px;z-index:50}#topsearch p[data-v-ce5e9132]{margin:2px;font-size:20px!important;text-shadow:2.5px 2.5px 5px #000}#topsearch a[data-v-ce5e9132]:hover{background-color:#b38e5d;text-decoration:none;color:#fff}#topsearch a[data-v-ce5e9132]{margin-bottom:4px}#masbuscados[data-v-ce5e9132]{position:absolute}.btn-top-search[data-v-ce5e9132]{color:#fff;background-color:#000;border:0;padding:5px 7px;font-size:.7rem;margin-right:.25rem}.card-gob .list-unstyled[data-v-ce5e9132]{height:5.2rem}.card-img-gob[data-v-ce5e9132]{width:30%;margin-left:auto;margin-right:auto;padding-bottom:0;margin-top:5%}.card-body[data-v-ce5e9132]{padding-top:2px;padding-bottom:2px}.card-carousel a[data-v-ce5e9132]:visited{color:#212529}.card-footer[data-v-ce5e9132]{font-size:11px;color:#fff;background-color:#285c4d;height:8rem}.footerverde[data-v-ce5e9132]{background-color:#621132}.card-title[data-v-ce5e9132]{margin-bottom:2px;height:2.3rem}.card-gob[data-v-ce5e9132]{margin-bottom:2rem}.card-gob h4[data-v-ce5e9132]{font-weight:900;font-size:1rem}.card-img-top[data-v-ce5e9132]{margin-bottom:3%}.programas[data-v-ce5e9132]{height:5.4rem}.programastab[data-v-ce5e9132]{height:6.5rem}.programascel[data-v-ce5e9132]{height:6.2rem}.card-gob[data-v-ce5e9132]:hover{-webkit-box-shadow:0 5px 8px 0 #d1d1d1;box-shadow:0 5px 8px 0 #d1d1d1}.card-gob p a[data-v-ce5e9132],.card-gob ul a[data-v-ce5e9132]{text-decoration:none;color:#706f6f}.card-gob a[data-v-ce5e9132]:hover{text-decoration:underline;color:#000}.titulocategoria a[data-v-ce5e9132]:visited{text-decoration:none;color:#000}.card-title a[data-v-ce5e9132]:visited{text-decoration:none}.card-body a[data-v-ce5e9132]:hover,.card-gob p a[data-v-ce5e9132]:hover,.card-gob ul a[data-v-ce5e9132]:hover{text-decoration:underline;color:#706f6f}.card-title a[data-v-ce5e9132]:hover,.card-title a[data-v-ce5e9132]:visited{text-decoration:underline;color:#000}.btn-categorias[data-v-ce5e9132]{color:#fff!important;background-color:#9d2449;border:0;padding:5px 7px;font-size:.9rem;margin-bottom:10px}.btn-categorias[data-v-ce5e9132]:hover{color:#fff!important;background-color:#000}.card-carousel[data-v-ce5e9132]{border:0;margin-bottom:3rem}.categorias .card-gob[data-v-ce5e9132]{height:290px}#topsearch h2[data-v-ce5e9132]{font-size:20px}#glit[data-v-ce5e9132]{position:relative;margin-top:2.8rem;margin-bottom:3.7rem}#line[data-v-ce5e9132]{position:absolute;background-color:#b38e5d;bottom:-10px;width:35px;height:5px}#glit h3[data-v-ce5e9132]{font-weight:400;color:#706f6f}@media screen and (min-width:320px){.next2[data-v-ce5e9132],.prev2[data-v-ce5e9132]{height:2rem!important;width:3rem;margin-top:-12%!important}.prev2[data-v-ce5e9132]{margin-left:65%!important}.card-body[data-v-ce5e9132]{height:8rem}.card-footer[data-v-ce5e9132]{height:11rem}}@media screen and (min-width:340px){.categorias .card-gob[data-v-ce5e9132]{height:320px}.next2[data-v-ce5e9132],.prev2[data-v-ce5e9132]{height:2.5rem!important;margin-top:-14%!important}}@media screen and (min-width:430px){.categorias .card-gob[data-v-ce5e9132]{height:350px!important}.next2[data-v-ce5e9132],.prev2[data-v-ce5e9132]{height:2.5rem!important;margin-top:-11%!important}.prev2[data-v-ce5e9132]{margin-left:75%!important}.card-body[data-v-ce5e9132],.card-footer[data-v-ce5e9132]{height:6rem}}@media screen and (min-width:500px){.categorias .card-gob[data-v-ce5e9132]{height:370px!important}.next2[data-v-ce5e9132],.prev2[data-v-ce5e9132]{height:2.5rem!important;margin-top:-9%!important}.prev2[data-v-ce5e9132]{margin-left:79%!important}}@media screen and (min-width:576px){.header_padding[data-v-ce5e9132]{padding-top:2.5rem!important}.categorias .card-gob[data-v-ce5e9132]{height:290px!important}.list-unstyled[data-v-ce5e9132]{margin-bottom:20%}.card-footer[data-v-ce5e9132]{height:6rem}.programascel[data-v-ce5e9132]{height:4rem}}@media screen and (min-width:768px){.header_padding[data-v-ce5e9132]{padding-top:48px}.categorias .card-gob[data-v-ce5e9132]{height:310px!important}.next2[data-v-ce5e9132],.prev2[data-v-ce5e9132]{height:2.5rem!important;margin-top:-6%!important}.prev2[data-v-ce5e9132]{margin-left:85%!important}.list-unstyled[data-v-ce5e9132]{margin-bottom:7%}.card-footer[data-v-ce5e9132]{height:7rem}.card-body[data-v-ce5e9132]{height:8rem}}@media screen and (min-width:992px){#topsearch p[data-v-ce5e9132],.btn-top-search[data-v-ce5e9132]{font-size:1rem}.card-title[data-v-ce5e9132]{margin-bottom:2px;height:3.5rem}.programas[data-v-ce5e9132]{height:7rem}.carousel-indicators li[data-v-ce5e9132]{height:15px;width:15px}#topsearch[data-v-ce5e9132]{bottom:30px}.btn-top-search[data-v-ce5e9132]{padding:5px 15px}.card-gob .list-unstyled[data-v-ce5e9132]{height:6.7rem}.categorias .card-gob[data-v-ce5e9132]{height:300px!important}.next2[data-v-ce5e9132],.prev2[data-v-ce5e9132]{height:2.5rem!important;margin-top:-4.5%!important}.prev2[data-v-ce5e9132]{margin-left:89%!important}.card-footer[data-v-ce5e9132]{height:8rem}}@media screen and (min-width:1200px){.categorias .card-gob[data-v-ce5e9132]{height:300px!important}.programas[data-v-ce5e9132]{height:5.4rem}.card-body[data-v-ce5e9132]{height:6.5rem}.card-footer[data-v-ce5e9132]{height:9rem}.card-title[data-v-ce5e9132]{margin-bottom:2px;height:3rem}.card-gob .list-unstyled[data-v-ce5e9132]{height:6rem}.prev2[data-v-ce5e9132]{margin-left:91%!important}}@media screen and (min-width:1391px){.categorias .card-gob[data-v-ce5e9132]{height:280px!important}.card-title[data-v-ce5e9132]{margin-bottom:2px;height:2.3rem}.card-gob .list-unstyled[data-v-ce5e9132]{height:5.2rem}}@media screen and (min-width:1600px){.container[data-v-ce5e9132]{max-width:5000px!important;width:80%!important}.card-footer[data-v-ce5e9132]{font-size:.75rem}.categorias .card-gob[data-v-ce5e9132]{height:290px!important}.next2[data-v-ce5e9132],.prev2[data-v-ce5e9132]{height:2.5rem!important;margin-top:-4%!important}}@media screen and (min-width:1800px){.container[data-v-ce5e9132]{max-width:5000px!important;width:80%!important}.card-footer[data-v-ce5e9132]{font-size:.8rem}.categorias .card-gob[data-v-ce5e9132]{height:320px!important}.card-gob .list-unstyled[data-v-ce5e9132]{height:5.5rem}.card-body[data-v-ce5e9132]{height:6rem}}@media screen and (min-width:2000px){.categorias .card-gob[data-v-ce5e9132]{height:325px!important}.next2[data-v-ce5e9132],.prev2[data-v-ce5e9132]{height:2.5rem!important;margin-top:-3%!important}.prev2[data-v-ce5e9132]{margin-left:93.5%!important}.categorias .card-gob[data-v-ce5e9132]{height:340px!important}.card-footer[data-v-ce5e9132]{height:6rem}}@media screen and (min-width:2300px){.categorias .card-gob[data-v-ce5e9132]{height:365px!important}.card-body[data-v-ce5e9132]{height:5.5rem}}@media screen and (min-width:2600px){.categorias .card-gob[data-v-ce5e9132]{height:390px!important}.next2[data-v-ce5e9132],.prev2[data-v-ce5e9132]{height:2.7rem!important;margin-top:-2.5%!important}.prev2[data-v-ce5e9132]{margin-left:95%!important}.card-footer[data-v-ce5e9132]{height:5rem}}@media screen and (max-width:767px){.header_padding[data-v-ce5e9132]{padding-top:68.91px}}.prev2[data-v-ce5e9132]{margin-left:89%}.next2[data-v-ce5e9132],.prev2[data-v-ce5e9132]{height:2.2rem;background-color:#9d2449;margin-top:-4%;opacity:1!important}.next2[data-v-ce5e9132]:hover,.prev2[data-v-ce5e9132]:hover{background-color:#000}.video-container[data-v-ce5e9132]{top:0;left:0;height:auto;width:100%;overflow:hidden}video.fillWidth[data-v-ce5e9132]{width:100%}
.gobierno .circle-quotes {
    text-align: center;
    width: 230px;
    height: 230px;
}
.gobierno .circle-quotes h2 {
    font-size: 70px;
    font-weight: 900;
    text-indent: 0;
}
.gobierno .circle-quotes a:hover {
    color: rgb(169, 169, 169);
    transition: color 0.15s ease-in-out;
}
.gobierno .circle-quotes a {
    color: rgb(56, 56, 56);
    text-decoration: none;
}
a[data-v-2e10a77a]:link{text-decoration:none;color:#fff!important}a[data-v-2e10a77a]:hover{text-decoration:underline;color:#38a2f9!important}a[data-v-2e10a77a]:visited{text-decoration:none;color:#fff!important}.panel-footer[data-v-2e10a77a]{font-family:Montserrat;font-size:85%;color:#fff;line-height:135%;background-image:url(https://framework-gb.cdn.gob.mx/landing/img/fondofooter.svg);height:auto;background-size:cover}#division[data-v-2e10a77a]{margin-top:25%}#mail[data-v-2e10a77a]{margin-top:-6%}@media only screen and (max-width:600px){#division[data-v-2e10a77a]{margin-top:5%}.logo_footer[data-v-2e10a77a]{width:75%;margin-top:25%!important;margin-left:0!important;padding-left:0;-ms-flex-line-pack:center;align-content:center}#redes[data-v-2e10a77a]{margin-top:10%!important}#mail[data-v-2e10a77a]{line-height:300%}}@media screen and (min-width:1600px){.container[data-v-2e10a77a]{max-width:5000px!important;width:80%!important}}@media only screen and (min-width:768px) and (max-width:1024px){#mail[data-v-2e10a77a]{font-size:81%}}#global[data-v-66178b5d]{font-family:Montserrat}a[data-v-66178b5d]:visited{color:#000}.full-width-image[data-v-66178b5d]{width:100vw;position:relative;left:50%;margin-left:-50vw}.full-width-image img[data-v-66178b5d]{width:100%}.image_hidden[data-v-66178b5d]{display:none}.menu-sticky[data-v-66178b5d]{position:-webkit-sticky;position:sticky;top:80px}.showcase2[data-v-66178b5d]{padding:0;margin:0}.t_categoria[data-v-66178b5d]{position:absolute}.Absolute-Center[data-v-66178b5d]{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;text-align:center}.titulo_header[data-v-66178b5d]{position:absolute;top:0;bottom:0;left:0;right:0;margin:auto;width:80%;height:36%}#btn-buscar[data-v-66178b5d]{background-color:#b38e5d;border:none;border-radius:0;width:20%}.widht100[data-v-66178b5d]{width:100%}#btn-buscar[data-v-66178b5d]:hover{background-color:#d4c19c}#buscador[data-v-66178b5d]{border:#b38e5d;border-radius:0;width:80%}#btnenlinea[data-v-66178b5d]{background-color:#9d2449;border:none;border-radius:0;font-size:70%}#btnenlinea[data-v-66178b5d]:hover{background-color:#621132}#btnenlinea[data-v-66178b5d]:active{color:#fff}.btnenlinea[data-v-66178b5d]{background-color:#9d2449;border:none;border-radius:0;font-size:70%}.btnenlinea[data-v-66178b5d]:hover{background-color:#621132}.btnenlinea[data-v-66178b5d]:active{color:#fff}#v-pills-tab[data-v-66178b5d]{background-color:#e6e6e6;font-weight:700}.div_titulo_boton[data-v-66178b5d]{padding-left:0}.menu[data-v-66178b5d]{background-color:#ccc;color:#3a3a3a;padding:4px;border-radius:1px;border-top:1.5px solid #fff;border-bottom:1.5px solid #fff;border-right:none;text-align:left;font-size:14px}.menu[data-v-66178b5d]:focus{background-color:#9d2449;color:#fff;border-top:3px solid #fff}.prueba[data-v-66178b5d]{background-color:#9d2449!important;color:#fff;border:none}.cat[data-v-66178b5d]{color:#fff}.sub_cat[data-v-66178b5d]{padding-left:10px;font-size:14px}.titulo_tramite[data-v-66178b5d]{font-size:1.3rem}.titulo_tramite a[data-v-66178b5d]:hover{color:#006fdd;text-decoration:underline}.texto_tramite[data-v-66178b5d]{font-size:14px}.categorias-piso1[data-v-66178b5d]{margin-top:20px}.texto_imagen[data-v-66178b5d]{text-align:center;color:#fff;width:100%;text-shadow:2.5px 2.5px 1px #000}.image_header[data-v-66178b5d]{display:block;margin-left:auto;margin-right:auto;width:100%}.mx-auto[data-v-66178b5d]{font-size:90%}.texto_imagen[data-v-66178b5d]{font-size:80%}@media only screen and (min-width:450px){.texto_imagen[data-v-66178b5d]{font-size:70%}#btn-buscar[data-v-66178b5d]{width:30%;height:70%;font-size:9px}#buscador[data-v-66178b5d]{width:70%;height:70%;font-size:7px}.encabezado[data-v-66178b5d]{padding:0;margin:0}}@media only screen and (min-width:0px){.texto_categorias[data-v-66178b5d]{font-size:10px}}@media only screen and (min-width:400px){.titulo_tramite[data-v-66178b5d]{font-size:21px}.columna_tramites[data-v-66178b5d]{width:100%!important}.div_titulo_boton[data-v-66178b5d]{width:100%}.texto_tramite[data-v-66178b5d]{margin-bottom:0;padding-bottom:0xp}.dropdown-menu[data-v-66178b5d]{font-size:.85rem}.texto_categorias[data-v-66178b5d]{font-size:12px}}@media only screen and (min-width:600px){.texto_imagen[data-v-66178b5d]{font-size:100%}#btn-buscar[data-v-66178b5d]{width:30%;height:70%;font-size:9px}#buscador[data-v-66178b5d]{width:70%;height:70%;font-size:9px}.titulo_header[data-v-66178b5d]{height:82%}}@media only screen and (min-width:0px){.texto_imagen[data-v-66178b5d]{font-size:48%}#btn-buscar[data-v-66178b5d]{width:30%;height:80%;font-size:11px;line-height:0}#buscador[data-v-66178b5d]{width:70%;height:80%;font-size:11px}#btnenlinea[data-v-66178b5d]{margin-bottom:5%}.encabezado nav[data-v-66178b5d]{padding:0;margin:0}.texto_imagen[data-v-66178b5d]{margin-top:-10%;font-size:110%}.texto_categorias[data-v-66178b5d]{font-size:14px}}@media only screen and (min-width:1000px){.texto_categorias[data-v-66178b5d]{font-size:16px}}@media only screen and (min-width:450px){.texto_imagen[data-v-66178b5d]{font-size:140%}#btn-buscar[data-v-66178b5d]{width:30%;height:80%;font-size:.7em}#buscador[data-v-66178b5d]{width:70%;height:80%;font-size:.7em}.encabezado[data-v-66178b5d]{padding:0;margin:0}}@media only screen and (min-width:600px){.texto_imagen[data-v-66178b5d]{font-size:120%;margin-top:5.5%}#btn-buscar[data-v-66178b5d]{width:20%;height:80%;font-size:.9em}#buscador[data-v-66178b5d]{width:80%;height:80%;font-size:.9em}}@media only screen and (min-width:800px){.texto_imagen[data-v-66178b5d]{font-size:135%;margin-top:5%}#btn-buscar[data-v-66178b5d]{width:15%;height:65%;font-size:11px}#buscador[data-v-66178b5d]{width:85%;height:65%;font-size:11px}}@media screen and (min-width:950px){.texto_imagen[data-v-66178b5d]{font-size:150%}.colapsable[data-v-66178b5d]{display:none}#btn-buscar[data-v-66178b5d]{width:20%;height:70%;font-size:13px}#buscador[data-v-66178b5d]{width:80%;height:70%;font-size:13px}.widht100[data-v-66178b5d]{width:80%}}@media screen and (min-width:1300px){.texto_imagen[data-v-66178b5d]{font-size:200%}#btn-buscar[data-v-66178b5d]{width:20%;height:70%;font-size:16px}#buscador[data-v-66178b5d]{width:80%;height:70%;font-size:16px}}.progress-bar[data-v-66178b5d]{background-color:#9d2449}.progress[data-v-66178b5d]{height:.3em}.dropdown-menu.dropdown-menu-wide[data-v-66178b5d]{min-width:100%;text-align:center}.boton_seleccion[data-v-66178b5d]{width:100%}.carga_pagina[data-v-66178b5d]{position:absolute;top:50%;left:50%;width:120px;height:120px}@-webkit-keyframes spin-data-v-66178b5d{to{-webkit-transform:rotate(1turn)}}@keyframes spin-data-v-66178b5d{to{-webkit-transform:rotate(1turn);transform:rotate(1turn)}}.paginacion li[data-v-66178b5d]{border:0 solid #dee2e6!important}.paginacion li a[data-v-66178b5d]{border:1px solid #dee2e6!important;border-radius:0!important}.paginacion li a.active[data-v-66178b5d]{color:#0056b3!important;background-color:#ddd!important;border-radius:0!important}.nav-item[data-v-66178b5d]{background-color:#f2f4f8!important;color:#3a3a3a!important}.consulta_requisitos[data-v-66178b5d]{text-align:center;font-size:14px;padding:0;margin:0;text-decoration:underline!important;color:#7b9cf0!important}.consulta_requisitos[data-v-66178b5d]:hover,.nav-link.active[data-v-66178b5d]{color:#12c!important}.btn.focus[data-v-66178b5d],.btn[data-v-66178b5d]:focus,[data-v-66178b5d]:focus{outline:0!important;-webkit-box-shadow:0 0 0 0 #ff0!important;box-shadow:0 0 0 0 #ff0!important}.subrayado[data-v-66178b5d]{text-decoration:underline}@media screen and (min-width:0px){.header_padding[data-v-66178b5d]{padding-top:68.91px}}@media screen and (min-width:576px){.header_padding[data-v-66178b5d]{padding-top:46.39px}}@media screen and (min-width:768px){.header_padding[data-v-66178b5d]{padding-top:48px}}.scrollable-menu[data-v-66178b5d]{height:auto;max-height:300px;overflow-x:hidden}.lista_dependencias[data-v-66178b5d]:focus{background-color:#d4c19c}.lista_dependencias[data-v-66178b5d]:active{background-color:#d4c19c!important}.lista_dependencias.active[data-v-66178b5d]{background-color:#d4c19c!important;color:#fff!important}@media screen and (max-width:767px){.espacio_dependencias[data-v-66178b5d]{display:none}}@media screen and (min-width:768px){.espacio_tramites_titulo[data-v-66178b5d]{display:none}}.search_dependencia[data-v-66178b5d]{border:0 solid #000!important;border:1px solid}.search_dependencia[data-v-66178b5d],.search_dependencia[data-v-66178b5d]:focus{outline:0!important;-webkit-box-shadow:0 0 0 0 rgba(38,143,255,.5)!important;box-shadow:0 0 0 0 rgba(38,143,255,.5)!important}.search_dependencia[data-v-66178b5d]:focus{border:0 solid #000!important}.search_dependencia[data-v-66178b5d]:hover{outline:0!important;border:0 solid #000!important;-webkit-box-shadow:0 0 0 0 rgba(38,143,255,.5)!important;box-shadow:0 0 0 0 rgba(38,143,255,.5)!important}.dropdown-toggle[data-v-66178b5d]{margin-left:-.745em!important}.dropdown-item[data-v-66178b5d]{white-space:normal!important}.boton_en_linea[data-v-66178b5d],.boton_en_linea[data-v-66178b5d]:focus,.boton_en_linea[data-v-66178b5d]:hover{text-decoration:none!important}@media only screen and (min-width:577px){.botones_busqueda[data-v-66178b5d]{display:none}}@media only screen and (max-width:576px){.escritorio[data-v-66178b5d]{display:none}}@media only screen and (max-width:767px) and (min-width:577px){.menu_izquierdo[data-v-66178b5d]{overflow:auto}[data-v-66178b5d]::-webkit-scrollbar{width:5px}[data-v-66178b5d]::-webkit-scrollbar-track{-webkit-box-shadow:inset 0 0 5px grey;box-shadow:inset 0 0 5px grey;border-radius:10px}[data-v-66178b5d]::-webkit-scrollbar-thumb{background:grey;border-radius:10px}[data-v-66178b5d]::-webkit-scrollbar-thumb:hover{background:grey}}.texto_categorias.active[data-v-66178b5d]{font-weight:700}
.filters{
	cursor: pointer ;
}
.filters:hover {
    background-color: #9d2449;
    color: #fff;
    border-top: 3px solid #fff;
}
.ods{
	width: 125px;
	margin-bottom: 5px;
	cursor: pointer;
}
.icon_operation{
	width: 40px;
	margin-right: 5px;
	cursor: pointer;
}
/* Estilos Adrian Nuñez Alanis  */
.first{
 width: 100%;
 height: 35px;
 border: 1px solid  #13322B;
 border-radius: 4px;
 padding: 7px;
 background:  white;
 color: black;
 cursor:pointer;
 text-align: left;
 font-size: 0.8em;
}
.first:hover{
  background: #13322B;
  color: white;
}
.firstClik{
  background: #13322B;
  color: white;
}

.firstSearch{
  background: #449d44;
  color: white;
}

#modalFilter{
    width: 95% !important;
}

.modalFilter{
margin: 0px auto !important;
top: 70px !important;
}


ul, #myUL {
  list-style-type: none;
}

#myUL {
  margin: 0;
  padding: 0;
}

.box {
  cursor: pointer;
  -webkit-user-select: none; /* Safari 3.1+ */
  -moz-user-select: none; /* Firefox 2+ */
  -ms-user-select: none; /* IE 10+ */
  user-select: none;
}

.box::before {
  content: "\2610";
  color: black;
  display: inline-block;
  margin-right: 6px;
}

.check-box::before {
  content: "\2611";
  color: dodgerblue;
}

.nested {
  display: none;
}

.active {
  display: block;
}



</style>
