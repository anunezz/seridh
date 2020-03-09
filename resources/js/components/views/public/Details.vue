<template>
    <div class="container  animated fadeIn fast">

        <div class="row" style="padding-bottom: 50px;">

            <div class="col-md-12">
                <h2>Recomendación</h2>
                <hr class="red small-margin">
            </div>

            <div class="col-md-12" >
                <button class="btn btn-primary btn-sm pull-right" @click="regresar()" type="button"> Regresar </button>
                <button class="pull-right btn btn-info btn-sm" style="margin-right: 5px;" @click="loadFile(id)" >
                    <span class="glyphicon glyphicon glyphicon-file" aria-hidden="true"></span> PDF
                </button>
            </div>

            <div class="row">
                <div class="col-md-12">

                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-01">Recomendación</a></li>
                        <li><a data-toggle="tab" href="#tab-04" v-if="reportedAction.length > 0">Acción Reportada</a></li>
                        <li><a data-toggle="tab" href="#tab-05" v-if="docs.length > 0">Documentos</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-01">
                            <div class="row  animated fadeIn fast">
                                <div class="col-md-12 pull-right text-fight" style="padding-top: 11px;">
                                    <span class="icon-calendar" aria-hidden="true"  style="float: left; padding-right: 5px;"></span>
                                    <span v-text="date"> </span>
                                    <strong style="float: right;"><b> Folio: </b><span v-text="invoice" ></span> </strong>
                                </div>

                                <div class="col-md-12">
                                    <h5> Recomendación</h5>
                                    <p v-html="reccommendation"></p>
                                </div>

                                <div class="row container-fluid">
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
                                                    <!-- <pre>
                                                        {{catGobOrder}}
                                                    </pre> -->

                                                    <li v-for="(i,key) in splitNames(catGobOrder)" :key="key" v-text="i"></li>
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
                                                    <!-- <pre>
                                                        {{CatGobPower}}
                                                    </pre> -->
                                                    <li v-for="(i,key) in splitNames(CatGobPower)" :key="key" v-text="i"></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row container-fluid">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5>Autoridad</h5>
                                            </div>
                                            <div class="col-md-12">
                                                <ul style="list-style:none; margin:0; padding:0;">
                                                    <!-- <pre>
                                                        {{CatAttending}}
                                                    </pre> -->
                                                    <li v-for="(i,key) in splitNames(CatAttending)" :key="key" v-text="i"></li>
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
                                                    <!-- <pre>
                                                        {{population}}
                                                    </pre> -->
                                                    <li v-for="(i,key) in splitNames(population)" :key="key" v-text="i"></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5>Acción Solicitada</h5>
                                            </div>
                                            <div class="col-md-12">
                                                <ul style="list-style:none; margin:0; padding:0;">
                                                    <!-- <pre>
                                                        {{CatSolidarityAction.split('|')}}
                                                    </pre> -->
                                                    <li v-for="(i,key) in CatSolidarityAction.split('|')" :key="key">{{ i.trim() }}</li>
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
                                            <div class="col-md-12">

                                                <table>
                                                    <tr v-for="(i,key) in ods" :key="key">
                                                        <td colspan="1" WIDTH="100" valign="top"> <strong> <b> {{ i.name }} </b> </strong> </td>
                                                        <td colspan="1" valign="top">
                                                            <ul>
                                                                <li v-for="(ii,idx) in i.data" :key="idx">
                                                                    {{ ii }}
                                                                </li>
                                                            </ul>
                                                            <br>
                                                        </td>
                                                    </tr>
                                                </table>
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
                                                    <li v-for="(i,key) in ods" :key="key">
                                                        {{ i.name }}
                                                        <ul>
                                                            <li v-for="(ii,keydos) in i.data" :key="keydos">
                                                                {{ ii }}
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5>Derechos Humanos</h5>
                                            </div>
                                            <div class="col-md-12">
                                                <ul style="list-style:none; margin:0; padding:0;">
                                                    <li v-for="(i,key) in right" :key="key">
                                                        {{ i.name}}
                                                        <ul style="list-style:none;">
                                                            <li v-for="(ii,keydos) in i.data" :key="keydos">
                                                                {{ ii.name }}
                                                                <ul style="list-style:none;">
                                                                    <li v-for="(iii,keytres) in ii.data" :key="keytres">
                                                                        {{ iii.name }}
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5>Temas</h5>
                                            </div>
                                            <div class="col-md-12">
                                                <ul style="list-style:none; margin:0; padding:0;">
                                                    <li v-for="(i,key) in topic" :key="key">
                                                        {{ i.name }}
                                                        <ul style="list-style:none;">
                                                             <!-- <pre>
                                                                {{ i.subtop }}
                                                            </pre> -->
                                                            <li v-for="(ii,keydos) in noduplicar(i.subtop)" :key="keydos">
                                                                <!-- &nbsp;  {{ ii.name.substr(6) }} .split('.-')[1]-->
                                                                <!-- &nbsp; &nbsp; {{ii.name}} ---- -->
                                                                &nbsp; &nbsp; {{ ii.name.replace(/([a-zA-Z]{1}[0-9]{1,2}[.][0-9]{1,2}[.][-])/,'') }}
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12" style="padding-top: 20px;">
                                        <h5>Comentarios</h5>
                                        <p v-html="comments"></p>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="tab-pane" id="tab-04" v-if="reportedAction.length > 0">
                            <div class="panel-body animated fadeIn fast" v-for="(item,index) in reportedAction" :key="index">
                                <div class="card" >
                                    <div class="card-body" style="padding: 15px !important" >
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong><b>Folio: </b></strong> <span v-text="item.invoice"></span>
                                                    </div>
                                                    <div class="col-md-6 text-right">

                                                        <span class="icon-calendar" aria-hidden="true"></span>
                                                        <span v-text="item.date"></span>

                                                        <el-divider direction="vertical"></el-divider>
                                                        <span> {{ index +1 }} de {{ reportedAction.length }}  </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <strong><b>Tipo de Acción Reportada</b></strong>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <ul style="list-style:none; margin:0; padding:0;">
                                                                    <li v-for="(i,key) in item.action" :key="key" v-text="i.name"></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <strong><b>Población beneficiaria</b></strong>

                                                            </div>
                                                            <div class="col-md-12">
                                                                <ul style="list-style:none; margin:0; padding:0;">
                                                                    <li v-for="(i,key) in item.population" :key="key" v-text="i.name"></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <strong><b>Descripción</b></strong>
                                                    </div>
                                                    <div class="col-md-12" v-html="item.description"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-05">
                            <div class="row">
                                <div class="col-md-12">
                                    <strong><b>Documentos asociados a la recomendación</b></strong>
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <ul style="list-style:none; margin:0; padding:0;">

                                        <el-table
                                            size="mini"
                                            border
                                            :data="docs"
                                            style="width: 60%">
                                            <el-table-column type="expand">
                                                <template slot-scope="props">
                                                    <p>Año de Registro: {{ props.row.date }}</p>
                                                    <p>Folio: {{ props.row.folio }}</p>
                                                        <el-tooltip
                                                            class="item"
                                                            effect="dark"
                                                            content="Descargar"
                                                            placement="top-start">
                                                            <el-button
                                                                style="margin-right: 5px;"
                                                                type="primary"
                                                                size="mini"
                                                                icon="el-icon-download"
                                                                @click="downloadDocument(props.row.id, 'fileName')">
                                                                Descargar
                                                            </el-button>
                                                        </el-tooltip>

                                                </template>
                                            </el-table-column>
                                            <el-table-column
                                                label="Documentos">
                                                <div class="item">
                                                    <img src="/img/imgpdf.png" style="height: 54px;" alt="">
                                                </div>
                                            </el-table-column>
                                            <el-table-column
                                                prop="title"
                                                label="Nombre del Documento">
                                            </el-table-column>
                                        </el-table>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="col-md-12" style="top: 20px;">
                        <router-link to="/publico/filtros" @click="addDetails(null)">
                            <button class="btn btn-primary btn-sm pull-right" type="button"> Regresar </button>
                        </router-link>
                    </div>


                </div>
            </div>

        </div>
    </div>
</template>


<script>
    import { mapState, mapGetters, mapActions, mapMutations } from "vuex";
    export default {
        data(){
            return{
                id:null,
                data:[],
                catalogo:[],
                jsonDetails:[], //json
                reccommendation:'', //Recomendación
                entity:'', //Entidad emisora
                catGobOrder:'',//Orden de gobierno
                CatGobPower:[],//Poder de gobierno
                population:[], //Poblacion
                CatAttending:[], //Autoridad,
                CatSolidarityAction:[],//Acción solidaria
                ods:[], //ods
                comments:[],
                right:[],
                subright:[],
                reportedAction:[],
                date:'',
                topic:[],
                invoice:'',
                docs:[],
                entities: '',
                id: null,
            }
        },
        methods:{
            ...mapActions("publico", ['addVisits','activeLoaing','addCats','addDetails']),
            noduplicar(data){

                _.uniqBy(data, function (e) {
                    return e.id;
                });

                return _.uniqBy(data, 'name');
                //return data;
            },
            regresar(){
                this.$router.push({path:'/publico/filtros'});
            },

            downloadDocument(id) {
                this.startLoading();
                console.log('id',id);
                let params = {responseType: 'blob'};

                axios.get(`/api/public/downloadDocumentPublicPdf/${id}`, {params, responseType: 'blob'}).then(response => {

                    let disposition = response.headers['content-disposition'];
                    var filename = '';
                    if (disposition && disposition.indexOf('inline') !== -1) {
                        var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                        var matches = filenameRegex.exec(disposition);
                        if (matches != null && matches[1]) {
                            filename = matches[1].replace(/['"]/g, '');
                        }
                    }

                    let blob = new Blob([response.data]);
                    const linkUrl = window.URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = linkUrl;

                    link.setAttribute('download', filename);
                    document.body.appendChild(link);
                    link.click();

                    this.countDocument(id);
                })

                    .catch(error => {
                        this.stopLoading();

                    });
            },

            loadFile(id){
                let me = this;
               me.activeLoaing(true);
                axios({ responseType: 'blob',
                    method: 'POST',
                    headers: { 'Authorization': 'Bearer ' +localStorage.getItem('token'),}  ,
                    url: '/api/public/exportFile',
                    data: {id: id}}).then(function (response) {
                    setTimeout(item=>{
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download','Recomendación.pdf');
                        document.body.appendChild(link);
                        link.click();
                        me.activeLoaing(false);
                    },200);

                }).catch(function (error) {
                    console.error("No se pudo completar la acci&oacute;n showInfo()");
                    // me.$notify.error({
                    //         title: 'Error',
                    //         message: 'No se pudo completar la acci&oacute;n showInfo()'
                    // });
                    me.activeLoaing(false);
                });


            },
            splitNamesAcction(data){
                console.log(data);
                return data;
               // return data.split('|');
            },
            splitNames(value){

                console.log("Data split: ",value);

                if(value.length === 1){
                    return value;
                }
                // else{

                // }
                // value = value.split(',');
                return value;
            },
            namesCat(value,num){
                let me = this;
                let data = me.catalogo[num].data;
                for (let i = 0; i < data.length; i++){
                    if(data[i].id === value){
                        return data[i].name;
                    }
                }
            },
            fnrecommendation(data){
                let me = this;
                me.catalogo = me.cats;
                data = me.detail;
                me.reccommendation = data.recommendation;
                me.entity = data.cat_entity_id;
                me.population = data.implode_population;
                me.catGobOrder = data.implode_order;
                me.CatGobPower = data.implode_power;
                me.CatAttending = data.implode_attendig;
                me.CatSolidarityAction = data.implode_action;
                me.ods = data.Ods;
                me.comments = data.comments;
                me.date = data.date;
                me.id = data.id;
                me.right = data.cat_gob_order_id;
                me.subright = data.subright;
                me.invoice = data.invoice;
                me.topic = data.topic;
                me.docs = data.docs;
                me.entities = data.cat_entity_id;

                //reported actions
                me.reportedAction = data.reportedaction;

            },
            splitNames(value){
                if(value.length === 0){
                    return value;
                }
                value = value.split(',');
                return value;
            }
        },
        computed:{
            ...mapState('publico',['visits','loading','prueba','cats','detail']),
        },
        mounted(){
            if(this.detail === null || this.detail.length === 0 || this.detail === ''){
                this.$router.push({path:'/publico'});
                return;
            }

            this.fnrecommendation( this.detail );
            window.scrollTo(0, 0);
        },

    }
</script>

<style lang="stylus" scoped>

</style>


