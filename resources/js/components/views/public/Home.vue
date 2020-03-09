<template>
    <div>


<div class="contenedor_carga">
  <div class="iimage">
    <div id="carga"></div>
  </div>
</div>

        <div id="myCarousel" class="carousel slide" data-ride="carousel" style="max-height: 450px;">
            <!-- Indicators -->
            <ol class="carousel-indicators">

                  <li v-for="(url,index) in carouselImages"
                      :key="index"
                      data-target="#myCarousel"
                      :data-slide-to="index"
                      v-bind:class="[index === 0 ? 'active' : '']"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item" v-for="(url,index) in carouselImages" :key="index" :class="{active : index === 0}">
                    <img :src="url.carousel" style="width:100%; height: 400px;">
                </div>
            </div>

             <div data-v-ce5e9132="" class="container">
                <div data-v-ce5e9132="" id="topsearch">
           <!--         <a data-v-ce5e9132="" href="#" role="button" target="_blank" class="btn btn-top-search">IR AL
                        CATÁLOGO</a>
                    <a data-v-ce5e9132="" role="button" target="_blank" class="btn btn-top-search" @click="changeLanguage(2)">ESPAÑOL</a>
                    <a data-v-ce5e9132="" role="button" target="_blank" class="btn btn-top-search" @click="changeLanguage(1)">ENGLISH</a> -->

                </div>
            </div>


            <a v-show="carouselImages.length > 1" class="left carousel-control" href="#myCarousel" data-slide="prev" v-if="carouselImages.length>0">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a v-show="carouselImages.length > 1" class="right carousel-control" href="#myCarousel" data-slide="next" v-if="carouselImages.length>0">
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
                    <!-- <div class="col-md-12 hidden-sm hidden-md hidden-lg small-top-buffer">
                        <a href="#secretarias">18 Secretar&iacute;as</a><br>
                        <a href="#dependencias">299 Entidades del Gobierno</a><br>
                        <a href="#estados">32 Estados y sus municipios</a><br>
                        <a href="/gobierno/mexico-en-el-mundo">146 Embajadas y consulados</a>
                    </div> -->

                    <div class="row">
                        <div class="col-md-3 col-xs-6">
                            <div class="media office-sm-structure circle-quotes">
                                <a>
                                    <figure>
                                        <h2 :title="lang.header && lang.header.title ? lang.header.title: 'Recomendaciones'" v-text="visits.recommendation"></h2>
                                        <p>{{lang.header.title}}</p>
                                    </figure>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <div class="media office-sm-structure circle-quotes">
                                <a>
                                    <figure>
                                        <h2 :title="lang.header && lang.header.entity ? lang.header.entity: 'Entidad Emisora'" v-text="visits.issuingEntities"></h2>
                                        <p>{{lang.header.entity}}</p>
                                    </figure>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <div class="media office-sm-structure circle-quotes">
                                <a>
                                    <figure>
                                        <h2 :title="lang.header && lang.header.topics ? lang.header.topics: 'Temas'" v-text="visits.topic"></h2>
                                        <p>{{lang.header.topics}}</p>
                                    </figure>
                                </a>
                            </div>
                        </div>
                        <!-- <div class="col-md-3 hidden-xs">
                            <div class="media office-sm-structure circle-quotes">
                                <a href="/gobierno/mexico-en-el-mundo">
                                    <figure>
                                        <h2 v-text='visits.visits'></h2>
                                        <p>Visitas</p>
                                    </figure>
                                </a>
                            </div>
                        </div> -->
                        <div class="col-md-3 col-xs-6">
                            <div class="media office-sm-structure circle-quotes">
                                <a>
                                    <figure>
                                        <h2 :title="lang.header && lang.header.actions ? lang.header.actions: 'Temas'" v-text='visits.reportedaction'></h2>
                                        <p>{{lang.header.actions}}</p>
                                    </figure>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row" v-if="messages.activeSeridh">
                    <div class="col-md-12">
                        <h2 :title="lang.header && lang.header.seridh ? lang.header.seridh: '¿Qué es el SERIDH?'">{{lang.header.seridh}}</h2>
                        <hr class="red small-margin text-justify">
                        <p :title="lang.header && lang.header.messagesSeridh ? lang.header.messagesSeridh: '¿Qué es el SERIDH?'">
                            <span v-html="messages.seridh"></span>
                        </p>
                    </div>
                </div>

                <div class="row" v-if="messages.activeUndersecretary">
                    <div class="col-md-12">
                        <h2 :title="lang.header && lang.header.undersecretary ? lang.header.undersecretary: '¿Qué es el SERIDH?'">{{lang.header.undersecretary}}</h2>
                        <hr class="red small-margin">
                    </div>
                    <div  style="padding: 20px;">
                        <img style="float:left;margin-right: 25px;" :src="messages.path_undersecretary[0].url" width="165px" height="165px" class="img-responsive" alt="subsecretaria">
                        <span v-html="messages.undersecretary"></span>
                    </div>
                </div>

                <br>

                <div class="row" v-if="messages.activeDgdhd">
                    <div class="col-md-12">
                        <h2 :title="lang.header && lang.header.dgdhd ? lang.header.dgdhd: 'Mensaje de la DGDHD'">{{lang.header.dgdhd}}</h2>
                        <hr class="red small-margin">
                    </div>
                    <div style="padding: 20px;">
                        <img style="float:left;margin-right: 25px;" width="165px" height="165px" :src="messages.path_dgdhd[0].url"  alt="dgdh">
                        <span v-html="messages.dgdhd"></span>
                    </div>
                </div>



                <!-------    Busqueda Avnzada de recomendaciones ---->

                <div class="row" style="padding-top: 50px;" >
                    <div class="col-md-12 col-sm-12">
                        <h2 :title="lang.header && lang.header.search ? lang.header.search: 'Búsqueda'">{{lang.header.search}}</h2>
                        <hr class="red small-margin">
                    </div>


                    <div class="col-md-12">
                        <div class="panel-body animated fadeIn fast">
                            <div class="card" v-loading="LoadingFilters"
                                                element-loading-text="Cargando..."
                                                element-loading-spinner="el-icon-loading">
                            <div>
                                <div class="" style="
                                width: 100%;
                                display: flex;
                                flex-wrap: wrap;
                                justify-content: space-between;
                                vertical-align: middle;
                                text-align: center;
                                overflow: hidden;
                                align-items: center;">

                                        <a v-if="advancedsearch.length > 0" style="color:black; margin-left:20px; text-decoration:none; cursor:pointer;" @click="advancedSearch()"
                                        :title="lang.header && lang.header.previous ? lang.header.previous: 'Búsqueda anterior'"> <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> {{lang.header.previous}}</a>
                                        <a v-else></a>

                                        <!-- <el-checkbox :label="filters.exclusion" @change="filters.exclusion = !filters.exclusion " style="margin-top: 8px; right: 10%;">
                                            B&uacute;squeda por exclusi&oacute;n
                                        </el-checkbox> -->
                                       <a @click="info = !info" style="margin: 8px 2% 0px 0px; cursor: pointer; color:black; text-decoration:none;"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Clic para mayor información</a>
                                </div>
                            </div>


                                <div class="card-body" style="padding: 7px 10px 7px 20px; !important">
                                    <div class="row">
                                        <div class="col-md-4" v-for="(item,index) in arrayFilter" :key="index" style="padding-bottom: 5px;">
                                            <button class="btn btn-default btn-sm btn-block"
                                                    v-if="item.label !== 'Buscar'"
                                                    v-bind:class="[item.btn === false ? '' :'active']"
                                                    type="button" @click="panelSearch(item)">
                                                <span style="font-size: 15.9px;"> {{ item.label }}</span>
                                            </button>
                                            <button class="btn btn-default btn-sm btn-block"
                                                    v-else
                                                    v-bind:class="[item.btn === false ? '' :'active']"
                                                    type="button" @click="recommendationFilter()">
                                                <span class="glyphicon glyphicon-search" style="font-size: 15.9px;"></span>
                                                <span style="font-size: 15.9px;">   {{ item.label }} </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>






                             <div class="card animated fadeIn fast" v-show="info === true">
                                <div class="card-body col-md-12" style="padding: 5px 30px 5px 30px; border: 3px solid #545454; background: #F6F6F6; font-size: 12px;">


<strong><b>Instrucciones</b></strong><br>

El SERIDH permite hacer b&uacute;squedas avanzadas aplicando diferentes filtros de las ocho categor&iacute;as disponibles.<br>

<strong><b>Aplicar filtros de diferentes categor&iacute;as:</b></strong> Al seleccionar m&aacute;s de un filtro de diferentes categor&iacute;as, la b&uacute;squeda &uacute;nicamente mostrar&aacute; las recomendaciones que coincidan con todos los filtros seleccionados.<br>

Ej.  La selección: [Tema > Mujeres y A&ntilde;o > 2019] mostrar&aacute; s&oacute;lo las recomendaciones que est&eacute;n clasificadas con el tema “Mujeres” Y el a&ntilde;o “2019”. <br>

<strong><b>Aplicar diferentes filtros de la misma categor&iacute;a:</b></strong> Al seleccionar diferentes filtros de la misma categor&iacute;a, la b&uacute;squeda mostrar&aacute; las recomendaciones que coincidan con cualquiera de los filtros seleccionados.<br>

Ej. La selección: [Tema > Mujeres y Tema > Ni&ntilde;os, ni&ntilde;as y adolescentes] mostrar&aacute; todas las recomendaciones que coincidan con el tema “Mujeres” O el tema “Ni&ntilde;os, ni&ntilde;as y Adolescentes”.<br>

Para eliminar los resultados después de realizar una b&uacute;squeda e iniciar una nueva, debe seleccionar la opci&oacute;n Limpiar b&uacute;squeda anterior.

La base de datos completa puede descargase en la siguiente liga: <a href="https://bit.ly/38E2fRI" target=”_blank”>Clic aqu&iacute;.</a><br>

Si experimenta fallas técnicas o tiene comentarios sobre la informaci&oacute;n del SERIDH, puede ponerse en contacto a: dgdhumanos@sre.gob.mx.





                                </div>
                            </div>



                            <div class="card animated fadeIn fast" v-if="cardCheckbox === true && btnSelect !== 3 && btnSelect !== 6 && btnSelect !== 5" >
                                <div class="card-body col-md-12" style="padding: 20px;">
                                    <div v-for="(item,index) in arrayFilter" :key="index">
                                        <div v-if="btnSelect === item.id && item.id === 0 && item.btn">
                                            <div class="row animated fadeIn fast">
                                                <div class="col-md-12" style="padding-bottom: 20px;">
                                                    <el-input v-model="filterDate" 
                                                    size="mini" 
                                                    suffix-icon="el-icon-search"
                                                    placeholder="Buscar por Año" ></el-input> 
                                                </div>
                                                <el-checkbox-group v-model="filters.year" class="form-check">
                                                    <div class="col-md-1" :key="key" v-for="(year,key) in catYears.filter(data => !searchDate || data.date.toLowerCase().includes(searchDate.toLowerCase()))">
                                                        <el-checkbox :label="year.date"> {{year.date}} </el-checkbox>
                                                    </div>
                                                </el-checkbox-group>
                                            </div>
                                        </div>
                                        <div v-else-if="btnSelect === item.id && item.id === 1">
                                            <div class="row animated fadeIn fast">
                                                <div class="col-md-12" style="padding-bottom: 20px;">
                                                  <el-input v-model="searchEntities" 
                                                  size="mini" 
                                                  placeholder="Buscar por Entidad Emisora" suffix-icon="el-icon-search"></el-input> 
                                                </div>
                                                <el-checkbox-group v-model="filters.entities">
                                                    <div class="col-md-12" :key="key" v-for="(item,key) in catEntities.filter(data => !searchEnt || data.name.toLowerCase().includes(searchEnt.toLowerCase()))">
                                                        <el-checkbox :label="item.id">
                                                            {{item.name}}
                                                        </el-checkbox>
                                                    </div>
                                                </el-checkbox-group>
                                            </div>
                                        </div>
                                        <div v-else-if="btnSelect === item.id && item.id === 2">
                                            <div class="row animated fadeIn fast">
                                                <div class="col-md-12" style="padding-bottom: 20px;">
                                                  <el-input v-model="filterPopulation" 
                                                  size="mini" 
                                                  suffix-icon="el-icon-search"
                                                  placeholder="Buscar por Población"></el-input>
                                                </div>
                                                <el-checkbox-group v-model="filters.populations">
                                                    <div class="col-md-12" :key="key" v-for="(item,key) in catPopulations.filter(data => !searchPopulations || data.name.toLowerCase().includes(searchPopulations.toLowerCase()))">
                                                        <el-checkbox :label="item.id">
                                                            {{item.name}}
                                                        </el-checkbox>
                                                    </div>
                                                </el-checkbox-group>
                                            </div>
                                        </div>
                                        <div v-else-if="btnSelect === item.id && item.id === 4">
                                            <div class="row animated fadeIn fast">
                                                <div class="col-md-12" style="padding-bottom: 20px;">
                                                  <el-input v-model="filterAuthorities" 
                                                  size="mini" 
                                                  suffix-icon="el-icon-search"
                                                  placeholder="Buscar por Autoridad"></el-input>
                                                </div>
                                                <el-checkbox-group v-model="filters.authorities">
                                                    <div class="col-md-12" :key="key" v-for="(item,key) in catAutorities.filter(data => !searchAutorities || data.name.toLowerCase().includes(searchAutorities.toLowerCase()))">
                                                        <el-checkbox :label="item.id">
                                                            {{item.name}}
                                                        </el-checkbox>
                                                    </div>
                                                </el-checkbox-group>
                                            </div>

                                        </div>

                                        <div v-else-if="btnSelect === item.id && item.id === 7">
                                            <div class="row animated fadeIn fast">
                                                <div class="col-md-12" style="padding-bottom: 20px;">
                                                    <el-input v-model="filterActions" 
                                                    size="mini" 
                                                    suffix-icon="el-icon-search"
                                                    placeholder="Buscar por Acción Solicitada"></el-input>
                                                </div>
                                                <el-checkbox-group v-model="filters.actions">
                                                    <div class="col-md-12" :key="key" v-for="(item,key) in catActions.filter(data => !searchActions || data.name.toLowerCase().includes(searchActions.toLowerCase()))">
                                                        <el-checkbox :label="item.id">
                                                            {{item.name}}
                                                        </el-checkbox>
                                                    </div>
                                                </el-checkbox-group>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" v-show="cardCheckbox === true && btnSelect === 5">
                                <div class="card-body col-md-12" style="padding: 20px;">
                                    <div class="row animated fadeIn fast" >
                                        <div class="col-md-12" style="padding-bottom: 20px;">
                                                 <el-input
                                                    placeholder="Buscar por ODS"
                                                    size="mini"
                                                    suffix-icon="el-icon-search"
                                                    v-model="filterTextOds">
                                                </el-input>
                                        </div>
                                        <div class="col-md-12">
                                                <div style="overflow-x:scroll; padding: 10px; 15px;">
                                                <el-tree
                                                style="width: 5000px;"
                                                    ref="Ods"
                                                    :data="goalsOds.tree"
                                                    show-checkbox
                                                    node-key="id"
                                                    :props="defaultPropsOds"
                                                    :default-checked-keys="cacheOds"
                                                    :filter-node-method="filterNodeOds"
                                                    @check="OdsTree">
                                                </el-tree>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" v-show="cardCheckbox === true && btnSelect === 3">
                                <div class="card-body col-md-12" style="padding: 20px;">
                                    <div class="row animated fadeIn fast">
                                        <div class="col-md-12" style="padding-bottom: 20px;">
                                             <el-input
                                                    placeholder="Buscar por Tema"
                                                    size="mini"
                                                    suffix-icon="el-icon-search"
                                                    v-model="filterTextTopics">
                                             </el-input>
                                        </div>
                                        <div class="col-md-12">
                                            <el-tree
                                                ref="top"
                                                :data="catTopics.tree"
                                                show-checkbox
                                                node-key="id"
                                                :props="defaultPropsTopics"
                                                :default-checked-keys="cacheTopics"
                                                :filter-node-method="filterNodeTopic"
                                                @check="TopTree">
                                            </el-tree>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" v-show="cardCheckbox === true && btnSelect === 6">
                                <div class="card-body col-md-12" style="padding: 20px;">
                                    <div class="row animated fadeIn fast">
                                        <div class="col-md-12" style="padding-bottom: 20px;">
                                             <el-input
                                                    placeholder="Buscar por Derechos Humanos"
                                                    size="mini"
                                                    suffix-icon="el-icon-search"
                                                    v-model="filterTextRights">
                                             </el-input>
                                        </div>
                                        <div class="col-md-12">
                                            <el-tree
                                                ref="derechosHumanos"
                                                :data="catRights"
                                                show-checkbox
                                                highlight-current
                                                node-key="id"
                                                :props="defaultProps"
                                                :default-checked-keys="cacheRights"
                                                class="filter-tree"
                                                :filter-node-method="filterNode"
                                                @check="rightsTree">
                                            </el-tree>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-------  Fin de Busqueda Avnzada de recomendaciones ---->


                <!-------  Dashboards recomendaciones ------------>

                           <!-- <barcharcolums /> -->

                <!------- Fin de dashboard recomendaciones ------->

                <div class="row" style="padding-top: 50px;">
                    <div class="col-md-12">
                        <h2 :title="lang.header && lang.header.statistics ? lang.header.statistics: 'Estadísticas básicas'">{{lang.header.statistics}}</h2>
                        <hr class="red small-margin">
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12" >
                                <div class="row" v-loading="LoadingDashboards"
                                                element-loading-text="Cargando..."
                                                element-loading-spinner="el-icon-loading">
                                    <div class="col-md-12 text-center">
                                        <h5 :title="lang.header && lang.header.ridhEntity ? lang.header.ridhEntity: 'RIDH por Entidad'">{{lang.header.ridhEntity}}</h5>
                                    </div>

                                    <div class="col-md-12">
                                        <canvas id="entidad-emisora" width="80" height="30" ></canvas>
                                    </div>

                                    <div class="col-md-12">
                                                <a href="" 
                                                   style="width:25%;"
                                                   title="Descargar gráfico Entidad Emisora"
                                                   class="btn btn-primary btn-xs center-block"
                                                   @click="imgDownloader('img1EntidadEmisora','entidad-emisora')" 
                                                   id="img1EntidadEmisora"
                                                   download="Entidad_Emisora.png" >
                                                    <i class="fa fa-download"></i> Descargar gr&aacute;fico
                                                </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" >
                                <div class="row" v-loading="LoadingDashboards"
                                                element-loading-text="Cargando..."
                                                element-loading-spinner="el-icon-loading">
                                    <div class="col-md-12 text-center">
                                        <h5 :title="lang.header && lang.header.ridhYear ? lang.header.ridhYear: 'RIDH por Año'">{{lang.header.ridhYear}}</h5>
                                    </div>
                                    <div class="col-md-12">
                                        <canvas id="Anio" width="80" height="30"></canvas>
                                    </div>
                                    <div class="col-md-12">
                                                <a href="" 
                                                   title="Descargar gráfico por año"
                                                   style="width: 25%;"
                                                   class="btn btn-primary btn-xs center-block" 
                                                   @click="imgDownloader('img2Anio','Anio')" 
                                                   id="img2Anio"
                                                   download="Recomendaciones_por_año.png" >
                                                    <i class="fa fa-download"></i> Descargar gr&aacute;fico
                                                </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <div class="row" v-loading="LoadingDashboards"
                                                element-loading-text="Cargando..."
                                                element-loading-spinner="el-icon-loading">
                                        <div class="col-md-12" style="height: 60px;">
                                            <h5 style="vertical-align: middle;" :title="lang.header && lang.header.recommendationsReceived ? lang.header.recommendationsReceived: 'Recomendación Recibida'">{{lang.header.recommendationsReceived}}</h5>
                                        </div>
                                        <div class="col-md-12" id="divLoadAuthority">
                                            <canvas id="loadAuthority" width="100%" ></canvas>
                                       </div>
                                        <div class="col-md-12">
                                                    <a href="" 
                                                      style="width:40%;" 
                                                      title="Total de recomendaciones recibidas por autoridad"
                                                      class="btn btn-primary btn-xs center-block" 
                                                      @click="imgDownloader('autoridad','loadAuthority')" 
                                                      id="autoridad"
                                                      download="Total_de_recomendaciones_recibidas_por_autoridad.png" >
                                                        <i class="fa fa-download"></i> Descargar gr&aacute;fico
                                                    </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row" v-loading="LoadingDashboards"
                                                element-loading-text="Cargando..."
                                                element-loading-spinner="el-icon-loading">
                                        <div class="col-md-12" style="height: 60px;">
                                            <h5 style="vertical-align: middle;" :title="lang.header && lang.header.recommendationsReported ? lang.header.recommendationsReported: 'Recomendación Reportada'">{{lang.header.recommendationsReported}}</h5>
                                        </div>
                                        <div class="col-md-12" id="divLoadReportadasAuthority">
                                            <canvas id="loadReportadasAuthority" width="100%" ></canvas>
                                        </div>
                                        <div class="col-md-12">
                                            <a href="" 
                                                style="width:40%;" 
                                                title="Total de recomendaciones con al menos una acción reportada por autoridad"
                                                class="btn btn-primary btn-xs center-block" 
                                                @click="imgDownloader('eportadasAutoridad','loadReportadasAuthority')" 
                                                    id="eportadasAutoridad"
                                            download="Total_de_recomendaciones_con_al_menos_una_acción_reportada_por_autoridad.png" >
                                                <i class="fa fa-download"></i> Descargar gr&aacute;fico
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row" v-loading="LoadingDashboards"
                                                element-loading-text="Cargando..."
                                                element-loading-spinner="el-icon-loading">
                                    <div class="col-md-12 text-center">
                                        <h5 :title="lang.header && lang.header.ods ? lang.header.ods: 'ODS'">{{lang.header.ods}}</h5>
                                    </div>
                                    <div class="col-md-12">
                                        <canvas id="dashboardODS" width="100%" height="30" ></canvas>
                                    </div>
                                    <div class="col-md-12">
                                                <a href=""
                                                  style="width:25%;" 
                                                  title="Recomendación por objetivos de desarrollo sostenible"
                                                  class="btn btn-primary btn-xs center-block" 
                                                 @click="imgDownloader('Odsid','dashboardODS')" 
                                                     id="Odsid"
                                               download="Recomendación_por_dbjetivos_de_desarrollo_sostenible.png" >
                                                    <i class="fa fa-download"></i> Descargar gr&aacute;fico
                                                </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <br><br>

                <div class="col-md-12">
                    <h2 :title="lang.header && lang.header.allies ? lang.header.allies: 'Estadísticas básicas'">{{lang.header.allies}}</h2>
                    <hr class="red small-margin">
                </div>
                <div v-if="alliesImages.length<5">
                    <div class="row categorias">
                        <!-- col-md-offset-3 -->
                        <div v-bind:class="[offsetAlies('offset',alliesImages.length)]" id="id_of">
                            <div class="row">
                                <!-- 'col-sm-8 col-md-8 col-lg-5' -->
                                <div v-bind:class="[offsetAlies('col',alliesImages.length)]"   v-for="ally in alliesImages">
                                    <div class="card text-center card-gob center-block">
                                        <div class="titulocategoria">
                                            <div style="padding: 1px">
                                                <img data-v-ce5e9132="" :src="ally.allies" alt="" width="100%" height="88px" style="background: #2769c6;">
                                            </div>
                                            <h4 data-v-ce5e9132="" class="card-title">
                                                {{ally.text}}
                                            </h4>
                                            <br/>
                                            <a target="_blank" :href="ally.link" data-v-ce5e9132="" class="btn btn-categorias">Ir al enlace</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-12" v-if="alliesImages.length>4">

                        <carousel-3d border="0" display="4" :height="200" :width="360" :autoplay="true" :autoplay-timeout="3500" :disable3d="true" :space="365" :clickable="false" :controls-visible="true">
                        <slide v-for="(ally, index) in alliesImages" :key="index" :index="index" style="background: white">
                           <div class="row">
                            <div class="col-md-12 text-center card-gob">

                            <div style="background: #2769c6;">
                                <img :src="ally.allies" style="width: 100% !important; height: 100px;">
                            </div>
                                <div>
                                    <h4 data-v-ce5e9132="" class="card-title">
                                        {{ally.text}}
                                    </h4>
                                </div>

                            <br/>
                            <a :href="ally.link" target="_blank" class="btn btn-primary btn-xs pull-center active" style="width:40%; margin: 0px auto 10px auto;">Ir al enlace</a>
                             </div>
                           </div>
                        </slide>
                    </carousel-3d>
                </div>
            </div>
        </main>


    </div>
</template>

<script>
    import { mapState, mapGetters, mapActions, mapMutations } from "vuex";
    import HeaderSection from "../layouts/partials/HeaderSection";
    import { Carousel3d, Slide } from 'vue-carousel-3d';
    import barcharcolums from "../public/dashboard/BarChartColumns";

    export default {
          components: {Carousel3d,Slide,HeaderSection,barcharcolums},
        data() {
            return {
                //Buscar por
                filterDate:'',
                searchDate:'',
                searchEnt:'',
                filterPopulation:'',
                searchPopulations:'',
                searchEntities:'',
                searchAutorities:'',
                filterAuthorities:'',
                filterActions:'',
                searchActions:'',
                //fin de buscar por
                info: false,
                LoadingDashboards:false,
                LoadingFilters:false,
                cacheTopics:[],
                cacheRights:[],
                cacheOds:[],
                totalActions:0,
                jsonPublic:[],
                filters: {
                    year: [],
                    entities: [],
                    populations: [],
                    authorities: [],
                    rights: [],
                    topics: [],
                    ods: [],
                    actions:[],
                    exclusion:false
                },
                varEntidad: null,
                charEntidad: null,
                varOds: null,
                charOds: null,
                entidad: null,
                vartotalEntidad: [],
                varMesEntidad: [],
                varAcciones:[],
                charAcciones:[],
                varReportedActions:null,
                charReportedActions:null,
                loadReportadasAuthorityHeigth:0,
                filterTextRights: '',
                filterTextTopics: '',
                filterTextOds:'',
                defaultPropsTopics: {
                    children: 'children',
                    label: 'name'
                },
                defaultProps: {
                    children: 'children',
                    label: 'label'
                },
                defaultPropsOds: {
                    children: 'children',
                    label: 'label'
                },
                rights: [],
                topics: [],
                countRecommendations: 0,
                cardCheckbox: false,
                arrayFilter: [],
                checkedNames: [],
                btnSelect: 0,
                catYears: [],
                catEntities: [],
                catPopulations: [],
                catTopics: [],
                goalsOds:[],
                catAutorities: [],
                catOds: [],
                catActions:[],
                catRights: [],
                results: {},
                searchRecommendation:'',
                selectRecommendation:'',
                ridhYear:[],
                ridhYearTotal:[],
                messages:{},
                carouselImages: {},
                alliesImages: {},
                offset:0,
                col:'',
                lang: {
                    "header": {
                        "title": "Recomendaciones",
                        "entity" : "Entidad Emisora",
                        "topics" : "Temas",
                        "actions" : "Acciones reportadas",
                        "search" : "Búsqueda avanzada de recomendaciones",
                        "previous" : "Limpiar búsqueda anterior",
                        "seridh" : "¿Qué es el SERIDH?",
                        "undersecretary" : "Mensaje de la Subsecretaría para Asuntos Multilaterales y Derechos Humanos",
                        "dgdhd" : "Mensaje de la Dirección General de Derechos Humanos y Democracia",
                        "statistics" : "Estadísticas básicas",
                        "allies" : "Aliados",
                        "ridhEntity" : "Recomendaciones por Entidad Emisora",
                        "ridhYear" : "Recomendaciones por año",
                        "recommendationsReceived" : "Total de recomendaciones recibidas por autoridad",
                        "recommendationsReported" : "Total de recomendaciones con al menos una acción reportada por autoridad",
                        "ods" : "Recomendaciones por Objetivos de Desarrollo Sostenible",
                        "messagesSeridh" : ""
                    }
                },
            };
        },
        created() {
            Chart.plugins.register({
                beforeDraw: function(chartInstance, easing) {
                    var ctx = chartInstance.chart.ctx;
                    ctx.fillStyle = 'white'; 
                    var chartArea = chartInstance.chartArea;
                    ctx.fillRect(0, 0, 4000, 4000);
                }
            });
            this.activeLoaing(false);
            this.LoadingDashboards = true;
            this.getData();
            this.getCarousel();
            this.getMessages();
            this.getAllies();
            this.changeLanguage();

        },
        watch: {
            filterActions(val){
              this.searchActions = val.trim();
            },                
            filterAuthorities(val){
              this.searchAutorities = val.trim();
            },
            filterDate(val) {
             this.searchDate = val.trim();
            },
             searchEntities(val) {
             this.searchEnt = val.trim();
            },
            filterPopulation(val) {
             this.searchPopulations = val.trim();
            },
            filterTextOds(val) {
                let me = this;
                 me.$refs.Ods.filter(val);
            },
            filterTextRights(val) {
                let me = this;
                me.$refs.derechosHumanos.filter(val);
            },
            filterTextTopics(val) {
                let me = this;
                me.$refs.top.filter(val);
            }
        },
        methods: {
            ...mapActions("publico", ['activeLoaing','addVisits','addAdvancedSearch','addDetails','addcolorsOds']),
            imgDownloader(id,idcanvas){
                let url_base64jp = document.getElementById(idcanvas).toDataURL("image/png");
                let a =  document.getElementById(id);
                a.href = url_base64jp;
            },
//   filterCats(){
//                 let me = this; 
//                 me.catYears = me.catYears.filter(data =>{
//                   return String(data.date) === me.searchYear;
//                 });

//                  console.log("numeros",me.catYears);
               // me.searchYear
               // me.catYears
            //},
            previusSearch(){
                let me = this;
                me.$router.push({ path: `/publico/filtros` });
            },
            advancedSearch(){
                let me = this;
                setTimeout(item=>{
                    me.filters= {
                        year: [],
                        entities: [],
                        populations: [],
                        authorities: [],
                        rights: [],
                        topics: [],
                        actions:[],
                        ods: []
                    };
                    me.addDetails([]);
                    me.cacheTopics = [];
                    me.cacheRights = [];
                    me.cacheOds=[],
                        me.$refs.top.setCheckedKeys([]);
                    me.$refs.derechosHumanos.setCheckedKeys([]);
                    me.$refs.Ods.setCheckedKeys([]);
                },200);
                me.addAdvancedSearch([]);
            },
            getData() {
                var config = {
                    headers:{
                        'Content-Type':'application/json',
                        'Accept':'application/json'
                    }
                };
                axios.get('/api/public/index-public/recommendations',config).then(response => {
                    if (response.data.success) {
                        this.catYears = _.orderBy(response.data.catYears, ['date'], ['asc']);
                        this.catEntities = _.orderBy(response.data.catEntities, ['name'], ['asc']);
                        this.catPopulations = _.orderBy(response.data.catPopulations, ['name'], ['asc']);
                        this.catTopics = response.data.catTopics;
                        this.goalsOds = response.data.goalsOds;
                        this.catAutorities = _.orderBy(response.data.catAutorities, ['name'], ['asc']);
                        this.catOds = response.data.catOds;
                        this.catActions = _.orderBy(response.data.catActions, ['name'], ['asc']);
                        this.catRights =  response.data.catRights;
                    } else {
                        this.$notify.error({
                            title: 'Error',
                            message: 'Error en getData();'
                        })
                    }
                }).catch(error => {
                    this.$notify.error({
                        title: 'Error',
                        message: 'No se pudo completar la acci&oacute;n getData.'
                    });
                });
            },
            getEntidades() {
                let me = this;
                var config = {
                    headers:{
                        'Content-Type':'application/json',
                        'Accept':'application/json',
                        'url' : '/api/public/dashboard'
                    }
                }
                axios.get('/api/public/dashboard', config).then(function (response) {

                    console.log("Response: ",response);

                    me.LoadingDashboards = false;
                    //Obtener datos por dashboard por ODS
                    let Ods = response.data.lResults.dashboardOds;
                    //Obtener datos para dashboard recomendaciones por año
                    let Y = response.data.lResults.ridhYear;
                    for (let i = 0; i < Y.length; i++) {
                        me.ridhYearTotal.push(Y[i].total);
                        me.ridhYear.push(Y[i].date);
                    }
                    //Obtener datos para dashboard acciones reportadas
                    let j = response.data.lResults.dashboardReportedActions;
                    let namesReportedActions = [];
                    let countReportedActions = [];
                    for (let i = 0; i < j.length; i++) {
                        namesReportedActions.push(j[i].name);
                        countReportedActions.push(j[i].count);
                    }
                    let x = response.data.lResults.actions.data;
                    me.totalActions = response.data.lResults.actions.total;
                    let actionNames = [];
                    let actionCount = [];
                    for (let i = 0; i < x.length; i++) {
                        actionNames.push(x[i].name);
                        actionCount.push(x[i].count);
                    }
                    me.loadEntidades(response.data.lResults.entity);
                    me.loadAnio();
                    me.loadAuthority(response.data.lResults.dashboardAuthority);
                    me.loadOds(response.data.lResults.dashboardOds);
                    me.loadReportadasAuthority(response.data.lResults.dashboardReportadasAuthority);



                }).catch(function (error) {
                });
            },
            loadEntidades(data){
                let me = this;
                me.varEntidad = document.getElementById('entidad-emisora').getContext('2d');
                let total = [];
                let entidad = [];
                let colors = me.getColors(data.length);
                for (let i = 0; i < data.length; i++) {
                    total.push(data[i].total);
                    entidad.push(data[i].entidad);
                }
                me.charEntidad = new Chart(me.varEntidad, {
                    type: 'bar',
                    display:false,
                    data: {
                        labels: entidad, //etiquetas a mostrar
                        datasets: [{
                            label: '',
                            data: total, //valores a mostrar
                            backgroundColor: colors,
                            borderColor: colors,
                            borderWidth: 2,
                            // hoverBackgroundColor: ["rgba(0,255,0,0.2)","rgba(0,225,0,2)"],
                            // hoverBorderColor: "rgba(0,255,0,0.2)",
                        }]
                    },
                    options: {
                         plugins: {
                            datalabels: {
                                    color: 'black',
                                    align:'end',
                                    clamp: true
                                }
                        },
                        responsive: true,
                        legend: {
                            display: false
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    // maxTicksLimit: total.length
                                    display:true,
                                    beginAtZero: false
                                }
                            }],
                            elements: {
                                rectangle: {
                                    borderSkipped: 'left',
                                }
                            }
                        }
                    }
                });
               // me.varEntidad.style.backgroundColor = 'red';

            },
            downloadChart(canvasId){
                /*Get image of canvas element*/
                let url_base64jp = document.getElementById(canvasId).toDataURL("image/jpg");
                /*get download button (tag: <a></a>) */
                let a =  document.getElementById("download");
                /*insert chart image url to download button (tag: <a></a>) */
                a.href = url_base64jp;
            },
            loadAnio(){
                let me = this;
                me.varAnio = document.getElementById('Anio').getContext('2d');
                let colors = me.getColors(me.ridhYearTotal.length);
                me.charEntidad = new Chart( me.varAnio, {
                    type: 'line',
                    data: {
                        backgroundColor: 'red',
                        labels: me.ridhYear, //etiquetas a mostrar
                        datasets: [{
                            label: 'Año',
                            data: me.ridhYearTotal, //valores a mostrar
                            backgroundColor: colors,
                            borderColor: colors,
                            fill:false,
                            borderWidth: 2,
                            // hoverBackgroundColor: "rgba(255,99,132,0.4)",
                            // hoverBorderColor: "rgba(255,99,132,1)",
                        }]
                    },
                    options: {
                         plugins: {
                            datalabels: {
                                    color: 'black',
                                    align:'end',
                                    clamp: true
                                }
                        },
                        responsive: true,
                        legend: {
                            display: false
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    // maxTicksLimit: total.length
                                    beginAtZero: false
                                }
                            }],
                        }
                    }
                });
            },
            loadAcciones(actionNames,actionCount){
                let me = this;
                me.varAcciones = document.getElementById('id_acciones').getContext('2d');
                me.charAcciones = new Chart( me.varAcciones, {
                    type: 'pie',
                    data: {
                        labels: actionNames, //etiquetas a mostrar
                        datasets: [{
                            label: 'Entidad emisora 1',
                            data: actionCount, //valores a mostrar
                            backgroundColor: me.colors,
                            borderColor: me.colors,
                            fill:false,
                            borderWidth: 2,
                            // hoverBackgroundColor: "rgba(0,255,0,0.2)",
                            // hoverBorderColor: "rgba(0,255,0,0.2)",
                        }]
                    },
                    options: {
                         plugins: {
                            datalabels: {
                                    color: 'black',
                                    align:'end',
                                    clamp: true
                                }
                        },
                        responsive: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: false
                                }
                            }]
                        }
                    }
                });
            },
            loadReportedActions(names,count){
                let me = this;
                me.varReportedActions = document.getElementById('id_actionsReported').getContext('2d');
                me.charReportedActions = new Chart( me.varReportedActions, {
                    type: 'pie',
                    data: {
                        labels: names, //etiquetas a mostrar
                        datasets: [{
                            label: 'Entidad emisora 1',
                            data: count, //valores a mostrar
                            backgroundColor: me.colors,
                            borderColor: me.colors,
                            fill:false,
                            borderWidth: 2,
                            // hoverBackgroundColor: "rgba(0,255,0,0.2)",
                            // hoverBorderColor: "rgba(0,255,0,0.2)",
                        }]
                    },
                    options: {
                         plugins: {
                            datalabels: {
                                    color:'black',
                                    align:'end',
                                    clamp: true
                                }
                        },
                        responsive: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: false
                                }
                            }]
                        }
                    }
                });
            },
            loadOds(data){
                let me = this;
                me.varOds = document.getElementById('dashboardODS').getContext('2d');
                let count = [];
                let ods = [];
                let colors = [];
                for (let e = 0; e < me.colorsOds.length; e++) {
                    for (let i = 0; i < data.length; i++) {
                        if(String(me.colorsOds[e].id) === String(data[i].id) ){
                            count.push(data[i].count);
                            ods.push(data[i].name);
                            colors.push(me.colorsOds[e].color);
                        }
                    }
                }
                me.charOds = new Chart(me.varOds, {
                    type: 'bar',
                    display:false,
                    data: {
                        labels: ods, //etiquetas a mostrar
                        datasets: [{
                            label: '',
                            data: count, //valores a mostrar
                            backgroundColor: colors,
                            borderColor: colors,
                            borderWidth: 2,
                            // hoverBackgroundColor: ["rgba(0,255,0,0.2)","rgba(0,225,0,2)"],
                            // hoverBorderColor: "rgba(0,255,0,0.2)",
                        }]
                    },
                    options: {
                         plugins: {
                            datalabels: {
                                    color:'black',
                                    align:'end',
                                    clamp: true
                                }
                        },
                        responsive: true,
                        legend: {
                            display: false
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    // maxTicksLimit: total.length
                                    beginAtZero: false
                                }
                            }],
                        }
                    }
                });
            },
            loadAuthority(data){
                let densityCanvas = document.getElementById("loadAuthority").getContext('2d');
                let ctx = document.getElementById('divLoadAuthority');
                let labels = [''];
                let counts = [0];
                let colores = this.getColors(data.length + 1);
                let heigth = 0;
                for (let i = 0; i < data.length; i++) {
                    heigth = heigth + 30;
                    labels.push(data[i].name);
                    counts.push(data[i].count);
                }
                heigth = ( heigth >= 235 )? heigth: 235;
                heigth = `height: ${heigth}px;`;
                ctx.setAttribute('style', heigth);
                var densityData = {
                    label: '',
                    data: counts,
                    backgroundColor:colores,
                    borderColor: colores,
                    borderWidth: 2,
                    hoverBorderWidth: 0
                };
                var chartOptions = {
                     plugins: {
                            datalabels: {
                                    color:'black',
                                    align:'end',
                                    clamp: true
                                }
                        },
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            barPercentage: 0.8
                        }],
                    },
                    elements: {
                        rectangle: {
                            borderSkipped: 'left',
                        }
                    }
                };
                var barChart = new Chart(densityCanvas, {
                    type: 'horizontalBar',
                    data: {
                        labels: labels,
                        datasets: [densityData],
                    },
                    options: chartOptions
                });
            },
            getColors(count){
                let  data = [];
                for (let i = 0; i < count; i++) {
                    for (let e = 0; e < this.colors.length; e++) {
                        if(e < count){ data.push(this.colors[e]); }else{ break; }
                    }
                }
                return data;
            },
            loadReportadasAuthority(data){
                let densityCanvas = document.getElementById("loadReportadasAuthority").getContext('2d');
                let ctx = document.getElementById('divLoadReportadasAuthority');
                let labels = [''];
                let count = [0];
                let colores = this.getColors(data.length + 1);
                let heigth=0;
                for (let i = 0; i < data.length; i++) {
                    heigth = heigth + 30;
                    labels.push(data[i].name);
                    count.push(data[i].count);
                }
                heigth = ( heigth >= 235 )? heigth: 235;
                heigth = `height: ${heigth}px;`;
                ctx.setAttribute('style', heigth);
                var densityData = {
                    label: '',
                    data: count,
                    backgroundColor: colores,
                    borderColor: colores,
                    borderWidth: 2,
                    height: 530,
                    hoverBorderWidth: 0
                };
                var chartOptions = {
                     plugins: {
                            datalabels: {
                                    color:'black',
                                    align:'end',
                                    clamp: true
                                }
                        },
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            barPercentage: 0.8
                        }],
                    },
                    elements: {
                        rectangle: {
                            borderSkipped: 'left',
                        }
                    }
                };
                var barChart = new Chart(densityCanvas, {
                    type: 'horizontalBar',
                    data: {
                        labels: labels,
                        datasets: [densityData],
                    },
                    options: chartOptions
                });
            },
            TopTree() {
                let me = this;
                me.$refs.top.getCheckedNodes();
            },
            OdsTree() {
                let me = this;
            },
            rightsTree() {
                let me = this;
                me.$refs.derechosHumanos.getCheckedNodes();
            },
            filterNode(value, data) {
                if (!value) return true;
                return data.label.indexOf(value) !== -1;
            },
            filterNodeTopic(value, data) {
                if (!value) return true;
                return data.name.indexOf(value) !== -1;
            },
            filterNodeOds(value, data) {
                if (!value) return true;
                return data.label.indexOf(value) !== -1;
            },
            panelSearch(item) {
                let me = this;
                for (let i = 0; i < me.arrayFilter.length; i++) {
                    if (me.arrayFilter[i].id === item.id) {
                        me.arrayFilter[i].btn = !me.arrayFilter[i].btn;
                        me.btnSelect = me.arrayFilter[i].id;
                        me.cardCheckbox =  me.arrayFilter[i].btn;
                    }else{
                        me.arrayFilter[i].btn = false;
                    }
                }
            },
            labelForm(cats) {
                let me = this;
                for (let i = 0; i < cats.length; i++) {

                   if(cats[i].id === 4){
                        console.log("Name: ",cats[i].name);
                        console.log("data: ",_.orderBy(cats[i].data, ['name'], ['asc']));
                   }


                   me.arrayFilter.push({
                        id: cats[i].id,
                        label: cats[i].name,
                        btn: false,
                        data: _.orderBy(cats[i].data, ['name'], ['desc'])
                    });



                    me.checkedNames.push({
                        id: cats[i].id,
                        check: []
                    });
                }
                me.LoadingFilters = false;
            },
            recommendationFilter(){
                this.filters.rights = [];
                let me = this, url = '', data = {};
                let consultRights = [];
                let consultTopic = [];
                let consultOds = [];
                me.cacheTopics = [];
                me.cacheRights = [];
                me.cacheOds=[];
                me.addAdvancedSearch([]);
                let rights = this.$refs.derechosHumanos.getCheckedNodes();
                let topics = this.$refs.top.getCheckedNodes();
                let odss = this.$refs.Ods.getCheckedNodes();
                let right_topic = {
                    right:[],
                    topic:[],
                    ods:[]
                };
                let d = this.catRights[0].children;
                    let parent = [];
                    for (let r = 0; r < d.length; r++) {
                        parent.push(d[r]);
                    }
                if (rights && rights.length > 0) {
                    _.forEach(rights, (item, key) => {
                        for (let p = 0; p < parent.length; p++) {
                           if(parent[p].id === item.right_id){
                                right_topic.right.push(parent[p]);
                           }
                        }
                        this.cacheRights.push(item.id);
                        consultRights.push({
                            right_id: item.right_id,
                            subcategory_id: item.subcategory_id,
                            subrights_id: item.subrights_id,
                        })
                    });
                    this.filters.rights = consultRights;
                }
                _.uniqBy(data, function (e) {
                     return e.id;
                });
                let padreRigth = _.uniqBy(right_topic.right, 'label');
                         right_topic.right = [];
                    for (let y = 0; y < padreRigth.length; y++) {
                         right_topic.right.push(padreRigth[y].label);
                    }
                if (topics && topics.length > 0) {
                      let temmas = this.catTopics.tree[0].children;
                    _.forEach(topics, (item, key) => {
                        this.cacheTopics.push(item.id);
                        for (let j = 0; j < temmas.length; j++) {
                            if( item.hasOwnProperty('children') ) {
                            }else{
                                 if(item.cat_topic_id === temmas[j].id){
                                    right_topic.topic.push( temmas[j] );
                                 }
                            }
                        }
                        consultTopic.push({
                            cat_topic_id: item.cat_topic_id,
                            cat_subtopic_id: item.cat_subtopic_id,
                        })
                    });
                        let padreTopic = _.uniqBy(right_topic.topic, 'name');
                            right_topic.topic = [];
                        for (let y = 0; y < padreTopic.length; y++) {
                            right_topic.topic.push(padreTopic[y].name);
                        }
                    this.filters.topics = consultTopic;
                }
                if (odss && odss.length > 0) {
                      let padreOdss = this.goalsOds.tree[0].children;
                    _.forEach(odss, (item, key) => {
                        for (let h = 0; h < padreOdss.length; h++) {
                            if(item.ods_id === padreOdss[h].id){
                                 right_topic.ods.push( padreOdss[h] );
                            }
                        }
                        this.cacheOds.push(item.id);
                        consultOds.push({
                            ods_id: item.ods_id,
                            cat_goal_id: item.cat_goal_id,
                        })
                    });
                        let padreOdsss = _.uniqBy(right_topic.ods, 'label');
                            right_topic.ods = [];
                        for (let y = 0; y < padreOdsss.length; y++) {
                            right_topic.ods.push(padreOdsss[y].label);
                        }
                    this.filters.ods = consultOds;
                }
                let cats = me.arrayFilter;
                data = {
                    catalogos: cats
                };
                me.addAdvancedSearch([{ filters:this.filters,
                    rights: this.cacheRights,
                    topics: this.cacheTopics,
                    ods: this.cacheOds,
                    right_topic: right_topic}]);
                this.$router.push({
                    path: `/publico/filtros`//,
                    // query: data
                });
            },
            getCarousel(){
                var config = {
                    headers:{
                        'Content-Type':'application/json',
                        'Accept':'application/json'
                    },
                    params: {
                        type:1
                    }
                }
                axios.get('/api/public/messages/adminPublic', config).then(response => {
                    this.carouselImages = response.data;
                }).catch(error => {
                    this.$notify.error({
                        title: 'Error',
                        message: 'No se pudo completar la acción getData.'
                    });
                });
            },
            getMessages(){
               // console.log('Get datos de mensajes');
                var config = {
                    headers:{
                        'Content-Type':'application/json',
                        'Accept':'application/json'
                    },
                    params: {
                        type:2
                    }
                }
                axios.get('/api/public/messages/adminPublic', config).then(response => {
                    this.messages = response.data.dataPublic;
                    if (response.data.path_undersecretary!==null){
                        this.messages.path_undersecretary.push({url:response.data.path_undersecretary});
                    }else {
                        this.messages.path_undersecretary.push({url:''});
                    }
                    if (response.data.path_dgdhd!==null){
                        this.messages.path_dgdhd.push({url:response.data.path_dgdhd});
                    }else {
                        this.messages.path_dgdhd.push({url:''});
                    }
                }).catch(error => {
                    this.$notify.error({
                        title: 'Error',
                        message: 'No se pudo completar la acci&oacute;n getData.'
                    });
                });
            },
            offsetAlies(name,value){
                switch (name) {
                    case 'offset':
                    {
                        if(value === 3){
                            value = `col-md-offset-2`;
                         }else if(value === 2){
                            value = `col-md-offset-2`;
                         }else if(value===1){
                            value =  `col-md-offset-4`;
                         }else if(value=== 4){
                            value =  `col-md-offset-0`;
                            setTimeout(item=>{
                                let ctx = document.getElementById('id_of');
                                ctx.setAttribute('style', 'padding: 0px 40px');
                            },100);
                         }
                    break;
                    }
                    case 'col':
                    {
                    if(value === 3){
                      value = `col-sm-8 col-md-8 col-lg-3`;
                    }else if(value === 2){
                      value = `col-sm-8 col-md-8 col-lg-5`;
                    }else if(value === 1){
                      value = `col-sm-8 col-md-8 col-lg-5`;
                    }else if(value=== 4){
                      value = `col-sm-8 col-md-8 col-lg-3`;
                    }
                    break;
                    }
                }
                return value;
            },
            getAllies(){
              //  console.log('get aliados')
                var config = {
                    headers:{
                        'Content-Type':'application/json',
                        'Accept':'application/json'
                    },
                    params: {
                        type:3
                    }
                }
                axios.get('/api/public/messages/adminPublic', config).then(response => {
                    this.alliesImages = response.data;
                }).catch(error => {
                    this.$notify.error({
                        title: 'Error',
                        message: 'No se pudo completar la acción getData.'
                    });
                });
            },
            changeLanguage(lang){
                if(lang == 1){
                    axios.get('/api/public/get/language',{params:{lang}}).then(response => {
                        if(response.data){
                            this.lang = response.data;
                        }
                    })
                }
                else if(lang == 2){
                    axios.get('/api/public/get/language/spanish',{params:{lang}}).then(response => {
                        if(response.data){
                            this.lang = response.data;
                        }
                    })
                }
            },
        },
        computed:{
            ...mapState('publico',['visits','advancedsearch','detail','cats','colors','colorsOds']),
        },
        mounted() {
            let me = this;
            if(me.advancedsearch.length > 0){
                me.filters = me.advancedsearch[0].filters;
                if(me.advancedsearch[0].topics.length > 0){
                    me.cacheTopics = me.advancedsearch[0].topics;
                }
                if(me.advancedsearch[0].rights.length > 0){
                    me.cacheRights = me.advancedsearch[0].rights;
                }
                if(me.advancedsearch[0].ods.length > 0){
                    me.cacheOds = me.advancedsearch[0].ods;
                }
            }
            me.getEntidades();
            me.LoadingFilters = true;
            setTimeout(item=>{
               // alert("ejecutando labels from");
                    me.labelForm(me.cats);
                    console.log("Ejecutando catalogos: ",me.cats);

            },2500);


        },
    }
</script>

<style scoped>
.center-block {
  display: block;
  margin-left: auto;
  margin-right: auto;
}





.contenedor_carga{
 background-color: #DDDD;
  height: 100%;
  width:100%;
  position: fix;
  
  -webkit-transition: all 1s ease;
  -o-transition: all 1s ease;
  transition: all 1s ease;
  z-index: 10000;
}

#carga{
  border: 15px solid #ccc;
  border-top-color: #F4266A;
  border-top-style: groove;
  height: 100%;
  width:  100%;
  border-radius: 100%;
  
  position: absolute;
  top: 0px;
  bottom: 37px;
  left: -50px;
  right: 0px;
  margin:auto;
  
  -webkit-animation:girar 3s linear infinite;
  -o-animation: girar 3s linear infinite;
  animation: girar 2.5s linear infinite;
  
}

@keyframes girar{

  from{
  	transform: rotate(0deg);
  }
  to{
  transform: rotate(360deg);
  }

}

.iimage{
   background-image: url("/img/sre_vert.svg");
  background-repeat: no-repeat;
  height: 320px;
  width: 320px;
  position: relative;
  margin:auto;
}



</style>
