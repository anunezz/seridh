<template>
    <div>
        <el-backtop :visibility-height="500"/>
        <header-section icon="fa-edit" :title="lang.header && lang.header.title ? lang.header.title: 'Agregar Recomendación'">
            <template slot="buttons">
                <el-button
                    size="medium"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push('/recomendaciones')">
                    Regresar
                </el-button>
       <!--         <el-button
                    size="medium"
                    type="success"
                    icon="fas fa-flag-usa"
                    @click="changeLanguage(1)">
                    English
                </el-button> -->

            </template>
        </header-section>
        <el-tabs ref="tabs" type="border-card" v-model="activeName">
            <el-tab-pane label="Recomendación" name="first">
                <el-form ref="recommendationForm" :model="recommendationForm" label-position="top" >
                    <el-row>
                        <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                            <el-form-item :label="lang.form && lang.form.text? lang.form.text : 'Texto de recomendación'"
                                          prop="recommendation"
                                          :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                                <tinymce
                                    id="recomendations"
                                    :other_options="tinyOptions"
                                    v-model="recommendationForm.recommendation"/>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row :gutter="20">
                        <el-col :xs="24" :sm="8" :md="8" :lg="8" :xl="8">
                            <el-form-item label="Año de registro"
                                          prop="date"
                                          :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur', 'change']},
                                      ]">
                                <el-date-picker
                                    v-model="recommendationForm.date"
                                    type="year"
                                    style="width: 100%"
                                    value-format="yyyy"
                                    placeholder="Seleccione año">
                                </el-date-picker>
                            </el-form-item>
                        </el-col>
                        <el-col :xs="24" :sm="8" :md="8" :lg="8" :xl="8">
                            <el-form-item label="¿La recomendación esta vigente?"
                                          prop="validity"
                                          :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur', 'change']},
                                      ]">
                                <el-select v-model="recommendationForm.validity" clearable placeholder="Seleccionar" style="width: 100%">
                                    <el-option
                                        v-for="item in options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>

                        <el-col :xs="24" :sm="8" :md="8" :lg="8" :xl="8">
                            <el-form-item :label="lang.form && lang.form.population? lang.form.population : '¿Es dirigida al Estado Mexicano?'"
                                          prop="directed"
                                          :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur', 'change']},
                                      ]">
                                <el-select v-model="recommendationForm.directed" clearable placeholder="Seleccionar" style="width: 100%">
                                    <el-option
                                        v-for="item in options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row :gutter="20">
                        <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
                            <el-form-item :label="lang.form && lang.form.entity? lang.form.entity : 'Entidad Emisora'"
                                          prop="cat_entity_id"
                                          :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur', 'change']},
                                      ]">
                                <el-select
                                    v-model="recommendationForm.cat_entity_id"
                                    filterable
                                    :placeholder="lang.form && lang.form.elegir? lang.form.elegir : 'Seleccionar'"
                                    style="width: 100%;">
                                    <el-option
                                        v-for="(entitie, index) in entities"
                                        :key="index"
                                        :label="entitie.name"
                                        :value="entitie.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
                            <el-form-item :label="lang.form && lang.form.power? lang.form.power : 'Poder de Gobierno'"
                                          prop="cat_gob_power_id"
                                          :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: ['blur', 'change']},
                                  ]">
                                <el-select
                                    v-model="recommendationForm.cat_gob_power_id"
                                    filterable
                                    multiple
                                    :placeholder="lang.form && lang.form.elegir? lang.form.elegir : 'Seleccionar'"
                                    style="width: 100%">
                                    <el-option
                                        v-for="(power, index) in powers"
                                        :key="index"
                                        :label="power.name"
                                        :value="power.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row :gutter="20">
                        <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                            <el-form-item :label="lang.form && lang.form.attending? lang.form.attending : 'Autoridadad'"
                                          prop="cat_attendig_id"
                                          :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur', 'change']},
                                      ]">
                                <el-select
                                    v-model="recommendationForm.cat_attendig_id"
                                    filterable
                                    multiple
                                    :multiple-limit="5"
                                    :placeholder="lang.form && lang.form.elegir? lang.form.elegir : 'Seleccionar'"
                                    style="width: 100%">
                                    <el-option
                                        v-for="(attending, index) in attendings"
                                        :key="index"
                                        :label="attending.name"
                                        :value="attending.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row :gutter="20">
                        <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                            <el-form-item :label="lang.form && lang.form.solidarity? lang.form.solidarity : 'Acción Solicitada'"
                                          prop="cat_solidarity_action_id"

                                          :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur', 'change']},
                                      ]">
                                <el-select
                                    v-model="recommendationForm.cat_solidarity_action_id"
                                    filterable
                                    multiple
                                    :placeholder="lang.form && lang.form.elegir? lang.form.elegir : 'Seleccionar'"
                                    style="width: 100%">
                                    <el-option
                                        v-for="(action, index) in actions"
                                        :key="index"
                                        :label="action.name"
                                        :value="action.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row :gutter="20">
                        <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
                            <el-form-item :label="lang.form && lang.form.population? lang.form.population : 'Personas o Grupos Específicos'"
                                          prop="cat_population_id"
                                          :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur', 'change']},
                                      ]">
                                <el-select
                                    v-model="recommendationForm.cat_population_id"
                                    filterable
                                    multiple
                                    :placeholder="lang.form && lang.form.elegir? lang.form.elegir : 'Seleccionar'"
                                    style="width: 100%">
                                    <el-option
                                        v-for="(population, index) in populations"
                                        :key="index"
                                        :label="population.name"
                                        :value="population.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
                            <el-form-item :label="lang.form && lang.form.order? lang.form.order : 'Orden de Gobierno'"
                                          prop="cat_gob_order_id"
                                          :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: ['blur', 'change']},
                                      ]">
                                <el-select
                                    v-model="recommendationForm.cat_gob_order_id"
                                    filterable
                                    multiple
                                    :placeholder="lang.form && lang.form.elegir? lang.form.elegir : 'Seleccionar'"
                                    style="width: 100%">
                                    <el-option
                                        v-for="(order, index) in orders"
                                        :key="index"
                                        :label="order.name"
                                        :value="order.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-divider></el-divider>
                    <el-row>
                        <el-tabs tab-position="left" style="padding: 25px">
                            <el-tab-pane label="Derechos">
                                <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                                    <el-input
                                        prefix-icon="el-icon-search"
                                        placeholder="Buscar"
                                        size="medium"
                                        v-model="filterRights">
                                    </el-input>
                                    <el-form-item prop="listRights" :rules="[
                                        { required: true, message: 'Debes seleccionar al menos un derecho', trigger: 'blur'},
                                      ]">
                                        <el-tree
                                            id="rights"
                                            ref="rights"
                                            :data="rights"
                                            show-checkbox
                                            node-key="id"
                                            :props="defaultProps"
                                            :filter-node-method="filterNode"
                                            :default-checked-keys="showIdsRights"
                                            @check="rightsTree">
                                        </el-tree>
                                    </el-form-item>
                                </el-col>
                            </el-tab-pane>
                            <el-tab-pane label="Temas">
                                <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                                    <el-input
                                        prefix-icon="el-icon-search"
                                        placeholder="Buscar"
                                        size="medium"
                                        v-model="filterTopics">
                                    </el-input>
                                    <el-form-item prop="listThemes" :rules="[
                                        { required: true, message: 'Debes seleccionar al menos un tema', trigger:'blur'},
                                      ]">
                                        <el-tree
                                            id="topics"
                                            ref="topics"
                                            :data="topics"
                                            show-checkbox
                                            node-key="id"
                                            accordion
                                            :filter-node-method="filterTopic"
                                            :props="defaultTopics"
                                            :default-checked-keys="showIdsThemes"
                                            @check="themesTree">
                                        </el-tree>
                                    </el-form-item>
                                </el-col>
                            </el-tab-pane>
                            <el-tab-pane label="ODS">
                                <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                                    <el-input
                                        prefix-icon="el-icon-search"
                                        placeholder="Buscar"
                                        size="medium"
                                        v-model="filterGoalsOds">
                                    </el-input>
                                    <el-form-item prop="listGoalsOds" :rules="[
                                        { required: true, message: 'Debes seleccionar al menos un ODS', trigger:'blur'},
                                      ]">
                                        <el-tree
                                            id="goals"
                                            ref="goalsOds"
                                            :data="goalsOds"
                                            show-checkbox
                                            node-key="id"
                                            :props="defaultProps"
                                            :filter-node-method="filterNode"
                                            :default-checked-keys="showOdsIds"
                                            @check="goalsOdsTree">
                                        </el-tree>
                                    </el-form-item>
                                </el-col>
                            </el-tab-pane>
                        </el-tabs>
                    </el-row>
                    <el-row :gutter="20">
                    </el-row>
                    <br>
                    <el-divider></el-divider>
                    <el-row style="margin-bottom: 10px">
                        <strong><b>Documentos</b></strong>
                    </el-row>
                    <transfer-document v-if="showTransfer" :items="recommendationForm"/>
                    <el-divider></el-divider>
                    <br>
                    <el-row :gutter="10">
                        <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                            <el-form-item :label="lang.form && lang.form.comment? lang.form.comment : 'Nombre oficial del reporte'"
                                          prop="comments"
                                          :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: ['blur', 'change']},
                                  ]">
                                <tinymce id="comments" :other_options="tinyOptions" v-model="recommendationForm.comments"/>
                            </el-form-item>
                        </el-col>
                    </el-row>
                </el-form>
                <el-row type="flex" class="row-bg" justify="end">
                    <el-col :xs="24" :sm="3" :md="3" :lg="3" :xl="3">
                        <el-button type="primary" @click="validForm('1')">
                            Siguiente
                            <i class="el-icon-arrow-right"/>
                        </el-button>
                    </el-col>
                </el-row>

            </el-tab-pane>
            <el-tab-pane :disabled="valForm" label="Acción reportada" name="second">
                <el-button style="margin-top: 20px;" type="primary" icon="fas fa-plus-circle" @click="newReport(1)"> Agregar</el-button>
                <reported-action :items="reportedAction" :typeAction="errorReport" @addReport="addReport"/>
                <el-form style="margin-top: 50px" label-width="120px" label-position="top" >
                    <el-divider content-position="left">
                        <strong :class="{acction : reportedAct.length>0  }" style=" background: #fc0203; color: white;padding: 2px; border-radius: 5px">
                            <b>{{reportedAct.length}}</b>
                        </strong> Acciones agregadas</el-divider>
                    <h4 v-if="errortable" style="color: red;margin-top:50px">Complete todos los campos de cada accione reportada</h4>
                    <el-row style="margin-top: 50px">
                        <el-table
                            :data="reportedAct"
                            border
                            style="width: 100%"
                            v-if="reportedAct.length>0">
                            <el-table-column
                                label="Tipo de acción reportada">
                                <template slot-scope="scope">
                                    <div v-for="action in typeAcction(scope.row.cat_solidarity_action_id)">
                                        <span class="badge">{{action}}</span>
                                    </div>
                                </template>
                            </el-table-column>
                            <el-table-column
                                label="Autoridad encargada de atender">
                                <template slot-scope="scope">
                                    <div  v-for="attending in typeAttendings(scope.row.cat_attendig_id)">
                                        <span class="badge">{{attending}}</span>
                                    </div>
                                </template>
                            </el-table-column>
                            <el-table-column
                                label="Acciones" width="200">
                                <template slot-scope="scope">
                                    <el-button
                                        size="mini"
                                        @click="handleEdit(scope.$index, scope.row)">Editar</el-button>
                                    <el-button
                                        size="mini"
                                        type="danger"
                                        @click="handleDelete(scope.$index, scope.row)">Eliminar</el-button>
                                </template>
                            </el-table-column>
                        </el-table>
                    </el-row>
                </el-form>
                <el-row style="margin-top: 50px" type="flex" class="row-bg" justify="end">
                    <el-col :xs="24" :sm="3" :md="3" :lg="3" :xl="3">
                        <el-button type="primary" @click="validForm('2')">
                            Siguiente
                            <i class="el-icon-arrow-right"/>
                        </el-button>
                    </el-col>
                </el-row>
            </el-tab-pane>
            <el-tab-pane :disabled="valForm" label="Control de datos" name="third">
                <el-form ref="evaluationAction" :model="recommendationForm" label-width="120px" label-position="top" >
                    <action-evaluation v-if="showAct" :items="recommendationForm.dataControl"/>
                </el-form>
                <el-row :gutter="5" type="flex" class="row-bg" justify="end">
                    <el-col :xs="24" :sm="6" :md="4" :lg="4" :xl="4">
                        <el-button size="medium" type="danger" style="width: 100%" @click="$router.push('/recomendaciones')">Cancelar</el-button>
                    </el-col>
                    <el-col :xs="24" :sm="6" :md="4" :lg="4" :xl="4">
                        <el-button size="medium" type="success" style="width: 100%" @click="submitForm(false)">Guardar sin publicar</el-button>
                    </el-col>
                    <el-col :xs="24" :sm="6" :md="4" :lg="4" :xl="4">
                        <el-button size="medium" type="primary" style="width: 100%" @click="submitForm(true)">Guardar y Publicar</el-button>
                    </el-col>
                </el-row>
            </el-tab-pane>
        </el-tabs>
    </div>
</template>

<script>
    import HeaderSection from "../layouts/partials/HeaderSection";
    import {mapActions, mapGetters } from 'vuex';
    import reportedAction from "./ReportedAction";
    import actionEvaluation from "./DataControl";
    import transferDocument from "./TransferDocument";

    export default {
        props: ['index'],

        components: {
            HeaderSection,
            reportedAction,
            actionEvaluation,
            transferDocument
        },

        data() {
            return {
                activeName: 'first',
                valForm:true,
                showTransfer:false,
                showAct:false,
                errortable:false,
                errorReport:null,
                documents: [],
                show: false,
                show2: true,
                // tree: [],
                filterTopics:'',
                filterRights:'',
                filterGoalsOds: '',
                options: [{
                    value: 1,
                    label: 'Si'
                }, {
                    value: 0,
                    label: 'No'
                }],
                reportedAct:[],
                showIdsRights:[],
                showIdsThemes:[],
                showOdsIds:[],
                tree: null,
                defaultProps: {
                    children: 'children',
                    label: 'label'
                },
                defaultTopics: {
                    children: 'children',
                    label: 'name'
                },

                lang: {
                    "header": {
                        "title": "Agregar recomendación"
                    }
                },
                entities: [],
                orders: [],
                powers: [],
                attendings: [],
                rights: [],
                populations: [],
                actions: [],
                topics: [],
                goalsOds:[],
                // subtopics: [],
                ods: [],
                dates: [],


                props: {
                    label: 'name',
                    children: 'zones'
                },

                apiToken: 'Bearer ' + sessionStorage.getItem('SERIDH_token'),

                recommendationForm: {
                    recommendation: '',
                    validity:null,
                    directed:null,
                    cat_entity_id: null,
                    cat_gob_order_id: [],
                    cat_gob_power_id: [],
                    cat_attendig_id: [],
                    cat_population_id: [],
                    cat_solidarity_action_id: [],
                    //cat_subtopic_id: null,
                    // cat_ods_id: [],
                    date: '',
                    //cat_topic_id: null,
                    comments: '',
                    listRights: [],
                    listThemes: [],
                    listGoalsOds: [],
                    invoice:null,
                    dataControl:{
                        recommendation_id:null,
                        typeIndicator:null,
                        levelAttention:null,
                        attentionClassification:null,
                    },
                    // files: [],
                    documents: []
                },
                reportedAction:{},
                tinyOptions: {
                    language_url: '/js/tiny_es_MX.js',
                    indent_use_margin: true,
                    forced_root_block_attrs: {
                        "style": "font-family: Montserrat;font-size:14px;font-style: normal;font-weight: normal"
                    },
                    menubar: '',
                    statusbar: false,
                    branding: false,
                    min_height: 150,
                    browser_spellcheck: true,
                    font_formats: 'Montserrat=Montserrat;Soberana Sans=Soberana Sans;Arial=arial,helvetica,sans-serif;Times New Roman=Times New Roman, Times, serif;',
                    setup: function (ed) {
                        ed.settings.paste_postprocess = function (pl, o) {
                            ed.dom.setAttrib(ed.dom.select('li', o.node), 'style', 'font-family: Montserrat;font-size:14px;font-style: normal;font-weight: normal');
                            ed.dom.setAttrib(ed.dom.select('p', o.node), 'style', 'font-family: Montserrat;font-size:14px;font-style: normal;font-weight: normal');
                        }
                    },
                    paste_as_text: true,
                    paste_text_sticky: true,
                    paste_text_sticky_default: true,
                    toolbar1: 'bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent  ',
                    toolbar2: "",
                    plugins: [
                        'paste'
                    ]
                },
                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10
                },
            }
        },
        created() {
            this.getDocumentRecommendation();
            this.errorReport = 2;
            this.newReport(2);
            this.startLoading();
            axios.get('/api/recommendations/create').then(response => {
                this.ods = response.data.ods;
                this.entities = response.data.entities;
                this.orders = response.data.orders;
                this.powers = response.data.powers;
                this.attendings = response.data.attendings;
                this.rights = response.data.rights;
                this.populations = response.data.populations;
                this.actions = response.data.actions;
                this.topics = response.data.topics;
                this.goalsOds = response.data.goalsOds;
                this.subtopics = response.data.subtopics;
                this.ods = response.data.ods;
                this.dates = response.data.dates;
                this.tree = response.data.tree;

                this.stopLoading();
                if (this.indexEdit!=null){
                    this.errorData(this.indexEdit);
                }
                this.showAct = true;
                this.showTransfer = true;
            }).catch(error => {
                this.stopLoading();

                this.$message({
                    type: "warning",
                    message: "No fue posible completar la acción, intente nuevamente."
                });
            });

        },
        computed: {
            ...mapGetters("bulkLoading",[
                "editRow",
                "indexEdit"
            ]),
        },
        watch: {
            filterGoalsOds(val) {
                this.$refs.goalsOds.filter(val);
            },
            filterRights(val) {
                this.$refs.rights.filter(val);
            },
            filterTopics(val) {
                this.$refs.topics.filter(val);
            }
        },
        methods: {
            ...mapActions("bulkLoading", ['deleteRow']),

            themesTree(){
                let ide = this.$refs.topics.getCheckedNodes();
                this.recommendationForm.listThemes=[];
                if (ide.length!==0){
                    let $this = this;
                    ide.forEach(function(el){
                        if(el.cat_topic_id!==undefined){
                            $this.recommendationForm.listThemes.push(el);
                        }
                    });
                }
            },

            goalsOdsTree(){
                let ide = this.$refs.goalsOds.getCheckedNodes();
                this.recommendationForm.listGoalsOds=[];
                if (ide.length!==0){
                    let $this = this;
                    ide.forEach(function(el){
                        if(el.ods_id!==undefined){
                            $this.recommendationForm.listGoalsOds.push(el);
                        }
                    });
                }
            },

            rightsTree(){
                let ids = this.$refs.rights.getCheckedNodes();
                this.recommendationForm.listRights=[];
                if (ids.length!==0){
                    let $this = this;
                    ids.forEach(function(el) {
                        if (el.add===1){
                            $this.recommendationForm.listRights.push(el);
                        }
                    });
                }
            },
            errorData(e){
                let edit = this.editRow(this.index);
                let reporte = [];
                for (let i = 0; i < 2; i++) {
                    let arrayR = [];
                    if (i===0) arrayR = edit.errorReportedActions;
                    else arrayR = edit.goodReportedActions ;
                    arrayR.forEach(function(rep) {
                        let row = {};
                        row.invoice = null;
                        row.recommendation_id = null;
                        row.cat_solidarity_action_id = rep.reportedActions;
                        row.cat_population_id = rep.population;
                        row.date = rep.date;
                        row.cat_attendig_id = rep.authorities;
                        row.description = rep.description;
                        reporte.push(row);
                    });
                }
                this.reportedAct = reporte;
                this.recommendationForm.recommendation = edit.recommendation;
                this.recommendationForm.validity = edit.validity;
                this.recommendationForm.directed = edit.directed;
                this.recommendationForm.cat_entity_id = edit.entity ? edit.entity.id : null;
                this.recommendationForm.cat_gob_order_id = edit.gobOrder ? edit.gobOrder: [];
                this.recommendationForm.cat_gob_power_id = edit.gobPower ? edit.gobPower : [];
                this.recommendationForm.cat_attendig_id = edit.attending ? edit.attending : [];
                this.recommendationForm.cat_population_id = edit.population ? edit.population : [];
                this.recommendationForm.cat_solidarity_action_id = edit.solidarityAction ? edit.solidarityAction : [];
                this.recommendationForm.cat_ods_id = edit.odsIds ? edit.odsIds : [];
                this.recommendationForm.date = edit.anio ? edit.anio : null;
                this.recommendationForm.listRights= edit.tree.rightsListR ? edit.tree.rightsListR : [];
                this.recommendationForm.listThemes= edit.tree.topicsListThemes ? edit.tree.topicsListThemes : [];
                this.recommendationForm.listGoalsOds = edit.tree.goalsOdsList ? edit.tree.goalsOdsList : [];
                this.recommendationForm.documents = edit.docs;
                this.recommendationForm.comments = edit.comments;
                this.showIdsRights= edit.tree.rightsShowIds;
                this.showIdsThemes = edit.tree.topicsShowIdes;
                this.showOdsIds = edit.tree.showOdsIds;
                this.recommendationForm.dataControl.recommendation_id = edit.dataControl.recommendation_id;
                this.recommendationForm.dataControl.typeIndicator = edit.dataControl.typeIndicator;
                this.recommendationForm.dataControl.levelAttention = edit.dataControl.levelAttention;
                this.recommendationForm.dataControl.attentionClassification = edit.dataControl.attentionClassification;

            },
            changeLanguage(lang){
                if(lang == 1){
                    axios.get('/api/get-language',{params:{lang}}).then(response => {
                        if(response.data){
                            this.lang = response.data;
                        }
                    })
                }
            },
            submitForm(type) {
                this.startLoading();
                this.errortable = false;
                var table = false;
                this.reportedAct.forEach(function (element) {
                    if (element.cat_attendig_id.length === 0) table = true;
                    if (element.cat_attendig_id.length === 0) table = true;
                    if (element.cat_population_id.length === 0) table = true;
                    if (element.cat_solidarity_action_id.length === 0) table = true;
                    if (element.date.length === 0) table = true;
                    if (element.description === '') table = true;
                });
                this.errortable = table;

                this.$refs['recommendationForm'].validate((valid) => {
                    if (valid){
                        if (this.errortable === false){
                            this.recommendationForm.isPublished = type;
                            let params = {
                                recommendation:this.recommendationForm,
                                reported: this.reportedAct
                            };

                            axios.post('/api/recommendations', params).then(response => {
                                this.stopLoading();
                                this.deleteRow(this.index);
                                this.$message({
                                    type: "success",
                                    title: 'Éxito',
                                    message: "Se almaceno la recomendación con folio: " + response.data.folio
                                });
                                this.recommendationForm = {};
                                this.$router.push('/recomendaciones');
                            }).catch(error => {
                                this.stopLoading();
                                this.$message({
                                    type: "warning",
                                    message: "No fue posible completar la acción, intente nuevamente."
                                });
                            })
                        }else {
                            this.stopLoading();
                            this.$message({
                                type: "warning",
                                title: 'Error',
                                message: "Complete los campos para continuar"
                            });
                        }
                    }else {
                        this.stopLoading();
                        this.$message({
                            type: "warning",
                            title: 'Error',
                            message: "Complete los campos para continuar"
                        });
                    }
                });
            },
            newReport(data){
                // this.errorReport = 2;
                if (data===1){
                    this.errorReport = 200;
                }
                this.reportedAction = {};
                this.reportedAction = {
                    invoice:null,
                    recommendation_id:null,
                    cat_solidarity_action_id:null,
                    cat_population_id:null,
                    date:'',
                    cat_attendig_id:'',
                    description:'',
                    action:1,
                    checked:true
                };
            },
            addReport(){
                if(this.reportedAction.action===1){
                    let copy = Object.assign({}, this.reportedAction);
                    this.reportedAct.push(copy);
                }else {
                    let el = this.reportedAct[this.reportedAction.index];
                    el.invoice = this.reportedAction.invoice;
                    el.recommendation_id = this.reportedAction.recommendation_id;
                    el.cat_solidarity_action_id = this.reportedAction.cat_solidarity_action_id;
                    el.cat_population_id = this.reportedAction.cat_population_id;
                    el.date= this.reportedAction.date;
                    el.cat_attendig_id= this.reportedAction.cat_attendig_id;
                    el.description= this.reportedAction.description;
                }

            },
            typeAcction(e){
                var listAcction = [];
                let $this = this;
                e.forEach(function(item){
                    var result = $this.actions.filter(action => action.id === item);
                    listAcction.push(result[0].name);
                });
                return listAcction;
            },
            typeAttendings(e){
                var listAttendings = [];
                let $this = this;
                e.forEach(function(item){
                    var result = $this.attendings.filter(attending => attending.id === item);
                    listAttendings .push(result[0].name);
                });
                return listAttendings;
            },
            handleEdit(index, row) {
                this.reportedAction = {
                    invoice:null,
                    recommendation_id:null,
                    cat_solidarity_action_id:row.cat_solidarity_action_id,
                    cat_population_id:row.cat_population_id,
                    date:row.date,
                    cat_attendig_id:row.cat_attendig_id,
                    description:row.description,
                    action:2,
                    index: index,
                    checked:true
                };
            },
            handleDelete(index, row) {
                this.$confirm('¿Está seguro que quiere eliminar esta acción reportada?',{
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    type: 'warning'
                }).then(() => {
                    this.reportedAct.splice(index,1);
                    this.$message({
                        type: "success",
                        title: 'Éxito',
                        message: "Se elimino la acción reportada"
                    });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Eliminación cancelada'
                    });
                });

            },
            filterNode(value, data) {
                if (!value) return true;
                return data.label.indexOf(value) !== -1;
            },
            filterTopic(value, data) {
                if (!value) return true;
                return data.name.indexOf(value) !== -1;
            },

            getDocumentRecommendation(currentPage = 1) {
                this.startLoading();

                let data = {
                    params: {
                        page: currentPage,
                        perPage: this.pagination.perPage,
                        isType: 1
                    }
                };

                axios.get('/api/recommendations/get/recommendation/files', data).then(response => {

                    if (response.data.success) {

                        this.documents = response.data.documents.data;
                        this.pagination.total = response.data.documents.total;
                        this.pagination.currentPage = response.data.documents.current_page;
                        this.pagination.perPage = response.data.documents.per_page;

                        this.stopLoading();
                    }

                }).catch(error => {
                    this.stopLoading();

                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },
            validForm(tap){

                if (tap === '1'){
                    this.$refs['recommendationForm'].validate((valid) => {
                        if (valid){
                            this.$refs.tabs.currentName='1';
                            this.valForm = false;
                            this.activeName = 'third';
                            this.activeName = 'second';

                        }
                        else{
                            this.$message({
                                type: "warning",
                                title: 'Error',
                                message: "Complete los campos para continuar"
                            });
                        }
                    });
                }
                if (tap === '2'){

                    this.$refs.tabs.currentName='third';
                    this.valForm = false;

                }
            }
        },
    }

</script>

<style>
    .el-upload-dragger { width: 100% !important}
    .el-upload { width: 100% !important;}
    .demo-input-label {
        display: inline-block;
        width: 130px;
    }
    .acction{
        background: #38a2f9 !important;
    }
    .badge {
        background-color: #eeeeef;
        border-radius: 10px;
        padding: 3px;
        color: #909399;
    }
    #goals div > div> div> .el-tree-node__content{
        height: 35px;
        white-space: normal;
        line-height: 17px;
    }

    #goals div > div> div> div> .el-tree-node__content{
        height: 78px;
        white-space: initial;
    }
    #rights div > div> div> div> div> div> .el-tree-node__content{
        height: 35px;
        white-space: initial;
        line-height: 17px;
    }
    #topics div > div> div> div> .el-tree-node__content{
        height: 34px;
        white-space: initial;
        line-height: 17px;
    }

    .el-select {
        width: 400px;
    }

    .transition-box {

        width: 400px;
        height: 100px;
        text-align: center;

        padding: 0px 2px;

        margin-left: 50px;
    }

    .transition-box2 {
        margin-bottom: 10px;
        width: 900px;
        height: 100px;
        border-radius: 4px;

        text-align: center;

        padding: 0px 20px;
        box-sizing: border-box;
        margin-right: 20px;
    }

</style>

