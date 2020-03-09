<template>
    <div class="container">

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content graficas" >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="false"> x </span></button>
                        <h4 class="modal-title" id="myModalLabel">Gr&aacute;ficas</h4>
                    </div>
                    <div class="modal-body">


                        <div class="row" >
                            <el-tabs tab-position="top">

                                <el-tab-pane label="Recomendaciones por año">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <canvas width="100%" id="Anio"></canvas>
                                        </div>

                                         <div class="col-md-12">
                                            <a href=""
                                                style="width:25%;"
                                                title="Descargar gráfico recomendación por año" 
                                                class="btn btn-primary btn-xs center-block" 
                                                @click="imgDownloader('imgAnioo','Anio')" 
                                                    id="imgAnioo"
                                            download="Recomendación_por_año.png" >
                                                <i class="fa fa-download"></i> Descargar gr&aacute;fico
                                            </a>
                                         </div>
                                    </div>
                                </el-tab-pane>

                                <el-tab-pane label="Recomendación por Entidad Emisora">
                                    <div class="row" >
                                        <div class="col-md-12">
                                            <canvas width="100%" id="Entidad"></canvas>
                                        </div>
                                        <div class="col-md-12">
                                            <a href="" 
                                                style="width:25%;"
                                                class="btn btn-primary btn-xs center-block" 
                                                title="Recomendación por Entidad Emisora"
                                                @click="imgDownloader('imgEntidadEmisora','Entidad')" 
                                                id="imgEntidadEmisora"
                                            download="Recomendación_por_Entidad_Emisora.png" >
                                                <i class="fa fa-download"></i> Descargar gr&aacute;fico
                                            </a>
                                         </div>
                                    </div>
                                </el-tab-pane>

                                <el-tab-pane label="Recomendación por acción solicitada">
                                    <div class="row">
                                        <div class="col-md-12" style="heigth: 500px;">
                                            <canvas width="100%" id="id_acciones"></canvas>
                                        </div>
                                        <div class="col-md-12">
                                            <a href="" 
                                                style="width:25%;"
                                                title="Descargar gráfico recomendación por acción solicitada"
                                                class="btn btn-primary btn-xs center-block" 
                                                @click="imgDownloader('imgAccionSolicitada','id_acciones')" 
                                                    id="imgAccionSolicitada"
                                              download="Recomendación_por_acción_solicitada.png" >
                                                <i class="fa fa-download"></i> Descargar gr&aacute;fico
                                            </a>
                                        </div>
                                    </div>
                                </el-tab-pane>

                                <el-tab-pane label="Recomendaciones por Objetivos de Desarrollo Sostenible">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <canvas width="100%" id="ODS"></canvas>
                                        </div>
                                        <div class="col-md-12">
                                            <a href=""
                                                style="width:25%;" 
                                                title="Descargar gráfico recomendación por objetivos de desarrollo sostenible"
                                                class="btn btn-primary btn-xs center-block" 
                                                @click="imgDownloader('imgOdss','ODS')" 
                                                    id="imgOdss"
                                            download="recomendación_por_objetivos_de_desarrollo_sostenible.png" >
                                                <i class="fa fa-download"></i> Descargar gr&aacute;fico
                                            </a>
                                        </div>
                                    </div>
                                </el-tab-pane>

                                <el-tab-pane label="Total de recomendaciones recibidas por autoridad">
                                    <div class="row">
                                        <div class="col-md-12" id="divLoadAuthority">
                                            <canvas width="100%" id="loadAuthority"></canvas>
                                        </div>
                                        <div class="col-md-12">
                                            <a href="" 
                                                style="width:25%;"
                                                title="Total de recomendaciones recibidas por autoridad"
                                                class="btn btn-primary btn-xs center-block" 
                                                @click="imgDownloader('imgAutoridad','loadAuthority')" 
                                                    id="imgAutoridad"
                                            download="Total_de_recomendaciones_recibidas_por_autoridad.png" >
                                                <i class="fa fa-download"></i> Descargar gr&aacute;fico
                                            </a>
                                        </div>
                                    </div>
                                </el-tab-pane>

                                <el-tab-pane label="Total de recomendaciones con al menos una acción reportada por autoridad">
                                    <div class="row">
                                        <div class="col-md-12" id="divLoadReportadasAuthority">
                                            <canvas id="loadReportadasAuthority" width="100%"></canvas>
                                        </div>
                                        <div class="col-md-12">
                                            <a href="" 
                                                style="width:25%;"
                                                title="Descargar gráfico total de recomendaciones con al menos una acción reportada por autoridad"
                                                class="btn btn-primary btn-xs center-block" @click="imgDownloader('imgRAutoridad','loadReportadasAuthority')" 
                                                id="imgRAutoridad"
                                            download="Total_de_recomendaciones_con_al_menos_una_acción_reportada_por_autoridad.png" >
                                                <i class="fa fa-download"></i> Descargar gr&aacute;fico
                                            </a>
                                        </div>
                                    </div>
                                </el-tab-pane>

                            </el-tabs>
                        </div>
                    </div>
                    <!-- <div class="modal-footer">
                               <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">kkkCerrar</button>
                           </div> -->
                </div>
            </div>
        </div>

        <div class="row" v-loading="loadingPage"
                                                element-loading-text="Cargando..."
                                                element-loading-spinner="el-icon-loading">
            <div class="col-md-12">
                <h2>Filtros</h2>
                <hr class="red small-margin">
            </div>

            <!-- <pre>
                {{ right_topic }}
            </pre> -->

            <div class="col-md-12">
                <div class="row animated fadeIn fast">
                    <div class="col-md-12">
                        <table width="100%" bordre="1px" class="animated fadeIn fast text-left;">
                            <thead>
                            <tr>
                                <td colspan="2"> <h5> Opciones seleccionadas. </h5></td>
                            </tr>
                            </thead>

                            <tr  v-if="params.year.length != 0">
                                <td width="70px" valign="top"> <label >A&ntilde;o:</label>   </td>
                                <td valign="top">
                            <span v-for="(i,ind) in params.year" :key="ind">
                                <span v-if="params.year.length -1 === ind"> {{ i }}. </span>
                                <span v-else> {{ i }}, &nbsp;</span>
                            </span>
                            <br>
                                </td>
                            </tr>

                            <tr v-if="params.entities.length != 0">
                                <td valign="top"><label >Entidad Emisora:</label></td>
                                <td valign="top">
                                    <span v-for="(i,ind) in params.entities" :key="ind">
                                        <span v-if="params.entities.length -1 === ind" > {{  namesCat(i,1) }}. </span>
                                        <span v-else> {{ namesCat(i,1) }}, &nbsp;</span>
                                    </span>
                                    <br>
                                </td>
                            </tr>

                            <tr v-if="params.populations.length != 0">
                                <td valign="top"><label >Poblaci&oacute;n:</label></td>
                                <td valign="top">
                                    <span v-for="(i,ind) in params.populations" :key="ind">
                                        <span v-if="params.populations.length -1 === ind" > {{  namesCat(i,2) }}. </span>
                                        <span v-else> {{ namesCat(i,2) }}, &nbsp;</span>
                                    </span>
                                    <br>
                                </td>
                            </tr>
                            <tr v-if="params.authorities.length != 0">
                                <td valign="top"><label >Autoridad</label></td>
                                <td valign="top">
                                    <span v-for="(i,ind) in params.authorities" :key="ind">
                                        <span v-if="params.authorities.length -1 === ind" > {{  namesCat(i,4) }}. </span>
                                        <span v-else> {{ namesCat(i,4) }}, &nbsp;</span>
                                    </span>
                                    <br>
                                </td>
                            </tr>
                            <tr v-if="right_topic.ods.length != 0">
                                <td width="100px" valign="top"><label >ODS</label></td>
                                <td valign="top">

                                    <ul style="list-style:none; margin:0; padding:0;">
                                        <li v-for="(i,and) in right_topic.ods" :key="and" v-text="i"></li>
                                    </ul>
                                    <br>
                               <!-- <span v-for="(i,and) in right_topic.ods" :key="and">
                                   <span v-if="right_topic.ods.length -1 === and" >&nbsp; {{i}}. </span>
                                   <span v-else> {{ i }}, &nbsp;</span>
                               </span> -->
                                </td>
                            </tr>
                            <tr v-if="right_topic.right.length != 0">
                                <td width="400px" valign="top"><label >Derechos Humanos</label></td>
                                <td valign="top">
                                    <ul style="list-style:none; margin:0; padding:0;">
                                        <li v-for="(i,and) in right_topic.right" :key="and">
                                            {{ i }}
                                        </li>
                                    </ul>
                                    <br>
                                    <!-- <span v-for="(i,and) in right_topic.right" :key="and">
                                        <span v-if="right_topic.right.length -1 === and" >&nbsp; {{i}}. </span>
                                        <span v-else> {{ i }}, &nbsp;</span>
                                    </span> -->
                                </td>
                            </tr>
                            <tr v-if="right_topic.topic.length != 0">
                               <td width="200px" valign="top"><label >Temas</label></td>
                               <td valign="top">
                                    <ul style="list-style:none; margin:0; padding:0;">
                                        <li v-for="(i,and) in right_topic.topic" :key="and" v-text="i"></li>
                                    </ul>
                                    <br>
                                   <!-- <span v-for="(i,and) in right_topic.topic" :key="and">
                                       <span v-if="right_topic.topic.length -1 === and" >&nbsp; {{i}}. </span>
                                       <span v-else> {{ i }}, &nbsp;</span>
                                   </span> -->
                               </td>
                            </tr>
                            <tr v-if="params.actions.length != 0">
                                <td valign="top"><label >Acci&oacute;n solicitada</label></td>
                                <td valign="top">
                                    <span v-for="(i,ind) in params.actions" :key="ind">
                                        <span v-if="params.actions.length -1 === ind" > {{  namesCat(i,7) }}. </span>
                                        <span v-else> {{ namesCat(i,7) }}, &nbsp;</span>
                                    </span>
                                    <br>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <br>




            <div class="col-md-12 animated fadeIn fast" style="margin-bottom: 10px;">
                <!-- <router-link to="/publico">
                    <button class="btn btn-success btn-sm pull-right" type="button">
                        Regresar <span class="glyphicon glyphicon glyphicon-share-alt" aria-hidden="true"></span>
                    </button>
                </router-link> -->

                <!-- <button type="button" v-show="jsonRecommendations.length > 0 " class="btn btn-primary btn-sm pull-right" @click="showDashboard()">  <span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Graficas</button> -->
            </div>

            <div class="col-md-12 animated fadeIn fast" style="margin-bottom: 10px;" >

                <div style="width: 100%;
                           display:flex;
                           justify-content: space-between">
                    <div>
                        &nbsp; <span class="glyphicon glyphicon-list-alt"></span> <strong> <b>Total: {{pagination.total}} </b></strong>
                    </div>
                    <div v-loading="loadingDashboard"
                                                element-loading-text="Cargando..."
                                                element-loading-spinner="el-icon-loading">
                        <button type="button" v-show="jsonRecommendations.length > 0 " class="pull-right btn btn-primary btn-sm" @click="showDashboard()">  <span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Gr&aacute;ficas</button>

                        <!-- <button class="pull-right btn btn-info btn-sm" @click="loadFile('word')" v-show="jsonRecommendations.length > 0 ">
                            <span class="glyphicon glyphicon glyphicon-file" aria-hidden="true"></span> WORD
                        </button>
                        <button class="pull-right btn btn-success btn-sm" style="margin-right: 5px;" @click="loadFile('excel')" v-show="jsonRecommendations.length > 0 ">
                            <span class="glyphicon glyphicon glyphicon-file" aria-hidden="true"></span> EXCEL
                        </button> -->
                        <button class="pull-right btn btn-info btn-sm" style="margin-right: 5px;" @click="loadFile('pdf')" v-show="jsonRecommendations.length > 0 ">
                            <span class="glyphicon glyphicon glyphicon-file" aria-hidden="true"></span> PDF
                        </button>
                    </div>
                </div>




            </div>


            <div class="col-md-12 animated fadeIn fast" v-show="jsonRecommendations.length > 0 ">
                <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page.sync="pagination.currentPage"
                    :page-sizes="[10, 20, 30, 40]"
                    :page-size="parseInt(pagination.perPage)"
                    layout="sizes, ->, prev, pager, next"
                    :total="pagination.total">
                </el-pagination>
            </div>

            <div class="col-md-12" style="padding-bottom: 50px !important;" v-if="pagination.total === 0 && loading == false && numero == 3" >
                <div class='alert alert-danger'>
                    No se encontraron recomendaciones.
                </div>
            </div>

            <div class="col-md-12  animated fadeIn fast" v-for="(item,index) in jsonRecommendations" :key="index">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-9">
                                <span v-html="cutRecommendation(item.recommendation)"></span>
                            </div>
                            <div class="col-md-3 pull-right" style="padding-top: 11px;">

                            <span class="icon-calendar" aria-hidden="true"
                                  style="float: left; padding-right: 5px; margin: 0px 0px 0px 50px;"></span>
                                <span v-text="item.date"></span>

                                <el-divider direction="vertical"></el-divider>
                                <span>

                                  {{ (from === 1 && index === 0)? from : from + index  }}   de {{ pagination.total  }}

                            </span>

                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">

                            <div class="col-md-12">
                                <button @click="showDetails(item)" class="btn btn-success pull-right btn-sm" type="button">Ver m&aacute;s detalles.</button>
                            </div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Entidad emisora</h5>
                                    </div>
                                    <div class="col-md-12">
                                        <ul style="list-style:none; margin:0; padding:0;">
                                            <li v-text="item.cat_entity_id"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Acci&oacute;n solicitada</h5>
                                    </div>
                                    <div class="col-md-12">
                                        <ul style="list-style:none; margin:0; padding:0;">
                                            <li v-for="(item,key) in splitNamesActions(item.implode_action)" :key="key" v-text="item"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Poblaci&oacute;n</h5>
                                    </div>
                                    <div class="col-md-12">
                                        <ul style="list-style:none; margin:0; padding:0;">
                                            <li v-for="(item,key) in splitNames(item.implode_population)" :key="key" v-text="item"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Acciones Reportadas</h5>
                                    </div>
                                    <div class="col-md-12" v-text=" item.reportedaction.length">

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Acci&oacute;n solicitada</h5>
                                    </div>
                                    <div class="col-md-12">
                                        <ul style="list-style:none; margin:0; padding:0;">
                                            <li v-for="(item,key) in splitNamesActions(item.implode_action)" :key="key" v-text="item"></li>
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
                                            <li v-for="(item,key) in splitNames(item.implode_attendig)" :key="key" v-text="item"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                         <h5>ODS</h5>
                                    </div>
                                    <div class="col-md-2" v-for="(i,key) in item.Ods" :key="key">
                                        {{  i.name.split(':')[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                         <h5>Derechos Humanos</h5>
                                    </div>
                                    <div class="col-md-4" v-for="(i,key) in item.cat_gob_order_id" :key="key">
                                        {{  i.name}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                         <h5>Temas</h5>
                                    </div>
                                    <div class="col-md-3" v-for="(i,key) in item.topic" :key="key">
                                        {{  i.name}}
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>ODS</h5>
                                    </div>
                                    <div class="col-md-12">
                                        <ul style="list-style:none; margin:0; padding:0;">
                                            <li v-for="(i,key) in item.Ods" :key="key">
                                                {{ i.name }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div> -->

                            <!-- <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Derechos Humanos</h5>
                                    </div>
                                    <div class="col-md-12">
                                        <ul style="list-style:none; margin:0; padding:0;">
                                            <li v-for="(i,key) in item.cat_gob_order_id" :key="key">
                                                {{ i.name}}

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div> -->

                            <!-- <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Temas</h5>
                                    </div>
                                    <div class="col-md-12">
                                        <ul style="list-style:none; margin:0; padding:0;">
                                            <li v-for="(i,key) in item.topic" :key="key">
                                                {{ i.name }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-md-12">
                                <button @click="showDetails(item)" class="btn btn-success pull-right btn-sm" type="button">Ver m&aacute;s detalles.</button>
                            </div>
                            <div class="col-md-12">
                                <!-- <el-backtop target=".page-component__scroll .el-scrollbar__wrap"></el-backtop> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState, mapGetters, mapActions, mapMutations } from "vuex";
    export default {
        name: "HomeAux",


        data() {
            return {
                loadingPage: false,
                loadingDashboard:false,
                varOds:null,
                charOds:null,
                varAnio: null,
                charEntidad: null,
                varEntidad: null,
                total: 0,
                numero:0,
                right_topic:{
                    topic:[],
                    right:[],
                    ods:[]
                },
                jsonRecommendations: [],
                varAcciones: '',
                charAcciones:'',
                varTemas: '',
                charTemas:'',
                params: {
                    year: [],
                    entities: [],
                    populations: [],
                    authorities: [],
                    rights: [],
                    topics: [],
                    actions:[],
                    ods: []
                },
                dataExportFile:[],
                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10
                },
                from: 0,
                to:0

            }
        },
        created() {
            let me = this;
            this.loadingPage = true;
            if(   me.advancedsearch.length === 0 || me.advancedsearch ===  null  ){
                this.$router.push({path:'/publico'});
                return;
            }else{
                me.showInfo();
                me.catSolidarityAction();
                window.scrollTo(0, 0);
            }

            this.loadingDashboard = true;

            this.activeLoaing(false);

        },
        mounted() {
        },
        computed:{
            ...mapState('publico',['loading','advancedsearch','cats','colors','colorsOds']),
        },
        methods: {
            ...mapActions("publico", ['activeLoaing','addAdvancedSearch','addCats','addDetails']),
            imgDownloader(id,idcanvas){
                console.log("Parametros de l aimagen a descargar: ",id,idcanvas);
                let url_base64jp = document.getElementById(idcanvas).toDataURL("image/jpg");
                let a =  document.getElementById(id);
                a.href = url_base64jp;
            },
            fnGoalsOds(item){
                let me = this;
                let childOds = [];
                let parentOds = [];
            },
            loadEntidades(data){
                let me = this;
                me.varEntidad = document.getElementById('Entidad').getContext('2d');
                let colors = me.getColors(data.length);
                let labels = [];
                let counts = [];
                for (let i = 0; i < data.length; i++) {
                    labels.push(data[i].name);
                    counts.push(data[i].count);
                }

                me.charEntidad = new Chart(me.varEntidad, {
                    type: 'bar',
                    display:false,
                    data: {
                        labels: labels, //etiquetas a mostrar
                        datasets: [{
                            label: '',
                            data: counts, //valores a mostrar
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
                            elements: {
                                rectangle: {
                                    borderSkipped: 'left',
                                }
                            }
                        }
                    }
                });
            },
            getColors(count){
                let  data = [];
                for (let i = 0; i < count; i++) {
                    for (let e = 0; e < this.colors.length; e++) {
                        if(e < count){
                            data.push(this.colors[e]);
                        }else{
                            break;
                        }
                    }
                }
                return data;
            },
            loadAnio(data){
                let me = this;
                let labels = [];
                let counts = [];
                let colors = me.getColors(data.length);

                for (let i = 0; i < data.length; i++) {
                    labels.push(data[i].name);
                    counts.push(data[i].count);
                }

                me.varAnio = document.getElementById('Anio').getContext('2d');
                me.charEntidad = new Chart( me.varAnio, {
                    type: 'line',
                    data: {
                        labels: labels, //etiquetas a mostrar
                        datasets: [{
                            label: 'Año',
                            data: counts, //valores a mostrar
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
                                    color:'black',
                                    align:'end',
                                    clamp: true
                                }
                        },
                        responsive: true,
                        // maintainAspectRatio: false,
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
            loadAcciones(data){
                let me = this;
                let colors = me.getColors(data.length);
                var actNames = [];
                var actCount = [];
                for (let i = 0; i < data.length; i++) {
                    actNames.push( data[i].name );
                    actCount.push( data[i].count );
                }

                me.varAcciones = document.getElementById('id_acciones').getContext('2d');
                me.charAcciones = new Chart( me.varAcciones, {
                    type: 'bar',
                    data: {
                        labels: actNames, //etiquetas a mostrar
                        datasets: [{
                            label: '',
                            data: actCount, //valores a mostrar
                            backgroundColor: colors,
                            borderColor: colors,
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
            loadOds(data){

                let me = this;
                me.varOds = document.getElementById('ODS').getContext('2d');
                let count = [];
                let ods = [];
                let colors = [];
               // console.table(me.colorsOds);

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
                var densityCanvas = document.getElementById("loadAuthority");
                let ctx = document.getElementById('divLoadAuthority');
                let colors = this.getColors(data.length + 1);
                let labels = [''];
                let counts = [0];
                let heigth=0;
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
                    backgroundColor:colors,
                    borderColor: colors,
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
            loadReportadasAuthority(data){
                var densityCanvas = document.getElementById("loadReportadasAuthority");
                let ctx = document.getElementById('divLoadReportadasAuthority');
                let colors = this.getColors(data.length + 1);
                let heigth = 0;
                let labels = [''];
                let count = [0];
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
                    backgroundColor: colors,
                    borderColor: colors,
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
            showDashboard(){
                let me = this;
                $('#myModal').modal('show');
            },
            catSolidarityAction(){
                let me = this;
                let data = {
                    params: me.advancedsearch[0].filters,
                };

                axios.post('/api/public/dashboardsFilters',data).then(function (response){

                    if (response.data.success === true) {
                        me.loadAcciones(response.data.lResults.dashboardActionRequested);
                        me.loadAnio(response.data.lResults.anio);
                        me.loadEntidades(response.data.lResults.entidad);
                        me.loadOds(response.data.lResults.ODS);
                        me.loadAuthority(response.data.lResults.Autoridad);
                        me.loadReportadasAuthority(response.data.lResults.datosReportadasAuthority);

                        me.loadingDashboard = false;


                    }
                }).catch(function (error){
                  //  console.error('No se pudo completar la acci&oacute;n catSolidarityAction()');
                    // me.$notify.error({
                    //         title: 'Error',
                    //         message: 'No se pudo completar la acci&oacute;n catSolidarityAction()'
                    // });
                });
            },
            handleCurrentChange(currentPage) {
                this.pagination.currentPage = currentPage;
                this.loadingPage = true;
                this.showInfo(currentPage)
            },

            handleSizeChange(sizePerPage) {
                this.pagination.perPage = sizePerPage;
                this.showInfo();
            },

            splitNames(value){
                value = value.split(',');
                return value;
            },
            splitNamesActions(value){
                value = value.split('|');
                return value;
            },
            showDetails(data){
                let me = this;
                me.addDetails(data);
                //   data = { data: data , catalogos: me.cats };

                //  me.$router.push({
                //     path: `/publico/filtros/detalle`,
                //     query: data
                // });

                me.$router.push({
                    path: `/publico/filtros/detalle`
                });



            },
            namesCat(value,num){
                let me = this;
                let data = me.cats[num].data;
                for (let i = 0; i < data.length; i++){
                    if(data[i].id === value){
                        return data[i].name;
                    }
                }
            },
            loadFile(value){
                let me = this;
                me.activeLoaing(true);
                axios({ responseType: 'blob',
                    method: 'POST',
                    headers: { 'Authorization': 'Bearer ' +localStorage.getItem('token'),}  ,
                    url: '/api/public/exportFile',
                    data: me.advancedsearch[0].filters}).then(function (response) {
                    setTimeout(item=>{
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download','Recomendaciones.pdf');
                        //  link.setAttribute('target','_blank');
                        document.body.appendChild(link);
                        link.click();
                        me.activeLoaing(false);
                    },200);

                }).catch(function (error) {
                  //  console.error("No se pudo completar la acci&oacute;n showInfo()");
                    // me.$notify.error({
                    //         title: 'Error',
                    //         message: 'No se pudo completar la acci&oacute;n showInfo()'
                    // });
                    me.activeLoaing(false);
                });




            },
            cutRecommendation(txt) {
                return txt = txt.substr(0, 264);
            },
            showInfo(currentPage = 1) {
                let me = this;

                let data = {
                    params:  me.advancedsearch[0].filters,
                    page: currentPage,
                    perPage: this.pagination.perPage
                };

                axios.post('/api/public/recommendationFilter', data).then(function (response) {
                        console.log("Response :",response);
                    if (response.data.success === true) {

                        me.params = me.advancedsearch[0].filters;

                        me.total = response.data.recommendations.data.length;
                        me.jsonRecommendations = response.data.recommendations.data;
                        me.right_topic = me.advancedsearch[0].right_topic;
                        me.pagination.total = response.data.recommendations.total;
                        me.from = response.data.recommendations.from;
                        me.to = response.data.recommendations.to;

                        if(response.data.recommendations.data.length === 0){
                            me.numero = 3;
                        }

                        me.pagination.currentPage = response.data.recommendations.current_page;
                        me.pagination.perPage = response.data.recommendations.per_page;



                        setTimeout(item => {
                            me.loadingPage = false;
                            me.activeLoaing(false);
                        },1000);

                    } else {
                        me.activeLoaing(false);
                    }
                }).catch(function (error) {
                    console.error("No se pudo completar la acci&oacute;n showInfo()");
                    // me.$notify.error({
                    //         title: 'Error',
                    //         message: 'No se pudo completar la acci&oacute;n showInfo()'
                    // });
                });
            }
        }
    }
</script>

<style scoped>
    @media screen and (min-width: 1200px) and (max-width: 5000px) {
        /* .graficas{
            height: 500px;
        } */

    }

    @media screen and (min-width: 992px) and (max-width: 1199px) {
        /* .graficas{
            height: 500px;
        } */
    }

    @media screen and (min-width: 768px) and (max-width: 991px) {
        /* .graficas{
            height: 500px;
        } */
    }

    @media screen and (min-width: 600px) and (max-width: 767px) {
    }

    @media screen and (min-width: 500px) and (max-width: 599px) {
        /* .graficas{
            height: 500px;
        } */
    }


    @media screen and (min-width: 400px) and (max-width: 499px) {
        /* .graficas{
            height: 500px;
        } */
    }

    @media screen and (min-width: 0px) and (max-width: 399px) {
        .graficas{
            height: 500px;
        }

    }


.Aniooclass, .autoridaddclass, .EntidadEmisoraclass, .AccionSolicitadaclass, .odssclass, .autoridadRdclass{
    color: #9D2449 !important;
    text-decoration:none;
}

.Aniooclass:hover, .autoridaddclass:hover, .EntidadEmisoraclass:hover, .AccionSolicitadaclass:hover, .odssclass:hover ,.autoridadRdclass:hover{
    color: #FFFFFF !important;
    text-decoration:none;
}


</style>
