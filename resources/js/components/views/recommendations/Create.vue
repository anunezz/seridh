<template>
    <div>
        <header-section icon="fa-edit" :title="lang.header && lang.header.title ? lang.header.title: 'Agregar Recomendación'">
            <template slot="buttons">
                <el-button
                    size="medium"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push('/recomendaciones')">
                    Regresar
                </el-button>
                <el-button
                    size="medium"
                    type="success"
                    icon="fas fa-flag-usa"
                    @click="changeLanguage(1)">
                    English
                </el-button>

            </template>
        </header-section>
        <el-form ref="recommendationForm" :model="recommendationForm" label-width="120px" label-position="top" >
            <el-row :gutter="10">
                <el-col :span="24">
                    <el-form-item :label="lang.form && lang.form.text? lang.form.text : 'Texto de Recomendación'"
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
                <el-col :span="8">
                    <el-form-item :label="lang.form && lang.form.entity? lang.form.entity : 'Entidad Emisora'"
                                  prop="cat_entity_id"
                                  :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                      ]">
                        <el-select
                            v-model="recommendationForm.cat_entity_id"
                            filterable
                            :placeholder="lang.form && lang.form.elegir? lang.form.elegir : 'Seleccionar'"
                            style="width: 100%">
                            <el-option
                                v-for="(entitie, index) in entities"
                                :key="index"
                                :label="entitie.name"
                                :value="entitie.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>

                <el-col :span="8">
                    <el-form-item :label="lang.form && lang.form.order? lang.form.order : 'Orden de Gobierno'"
                                  prop="cat_gob_order_id"
                                  :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: 'blur'},
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

                <el-col :span="8">
                    <el-form-item :label="lang.form && lang.form.power? lang.form.power : 'Poder de Gobierno'"
                                  prop="cat_gob_power_id"
                                  :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
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
                <el-col :span="8">
                    <el-form-item :label="lang.form && lang.form.attending? lang.form.attending : 'Autoridadad'"
                                  prop="cat_attendig_id"
                                  :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                      ]">
                        <el-select
                            v-model="recommendationForm.cat_attendig_id"
                            filterable
                            multiple
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
                <el-col :span="8">
                    <el-form-item :label="lang.form && lang.form.population? lang.form.population : 'Población'"
                                  prop="cat_population_id"
                                  :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: 'blur'},
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

                <el-col :span="8">
                    <el-form-item :label="lang.form && lang.form.solidarity? lang.form.solidarity : 'Acción Solidaria'"
                                  prop="cat_solidarity_action_id"
                                  :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: 'blur'},
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
                <el-col :span="12">
                    <el-form-item :label="lang.form && lang.form.goals? lang.form.goals : 'ODS (Objetivos de Desarrollo Sostenible)'"
                                  prop="cat_ods_id"
                                  :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                      ]">
                        <el-select
                            v-model="recommendationForm.cat_ods_id"
                            filterable
                            multiple
                            :placeholder="lang.form && lang.form.elegir? lang.form.elegir : 'Seleccionar'"
                            style="width: 100%">
                            <el-option
                                v-for="(od, index) in ods"
                                :key="index"
                                :label="od.name"
                                :value="od.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>

                <el-col :span="8">
                    <el-form-item :label="lang.form && lang.form.review? lang.form.review : 'Fecha de registro'"
                                  prop="cat_date_id"
                                  :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                      ]">
                        <el-select
                            v-model="recommendationForm.cat_date_id"
                            filterable
                            :placeholder="lang.form && lang.form.elegir? lang.form.elegir : 'Seleccionar'"
                            style="width: 100%">
                            <el-option
                                v-for="(date, index) in dates"
                                :key="index"
                                :label="date.name"
                                :value="date.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col :span="12">
                    <el-tree
                        ref="rights"
                        :data="rights"
                        show-checkbox
                        node-key="id"
                        :props="defaultProps"
                        :default-checked-keys="[]"
                        @check="rightsTree">
                    </el-tree>
                </el-col>
                <el-col :span="12">
                    <el-tree
                        ref="themes"
                        :data="tree"
                        show-checkbox
                        node-key="id"
                        :props="defaultProps"
                        :default-checked-keys="[]"
                        @check="themesTree">
                    </el-tree>

                </el-col>
            </el-row>
            <br>
            <el-divider></el-divider>
            <el-row :gutter="10">
                <el-col :span="24">
                    <el-form-item>
                        <el-upload
                            class="upload-demo"
                            drag
                            action="/api/recommendations/upload/file"
                            accept=".jpg, .pdf, .png, .jpeg"
                            name="document"
                            :auto-upload="true"
                            :before-upload="beforeUploadFile"
                            :headers="{'Authorization': apiToken}"
                            :before-remove="removeFile"
                            :on-success="uploadedFile"
                            :on-error="onError">
                            <i class="el-icon-upload"></i>
                            <div class="el-upload__text">
                                Suelta tu archivo aquí o <em>haz clic para cargar</em>
                                (Tamaño máximo 6MB)
                            </div>
                        </el-upload>
                    </el-form-item>
                </el-col>
            </el-row>

            <el-row :gutter="10">
                <el-col :span="24">
                    <el-form-item :label="lang.form && lang.form.comment? lang.form.comment : 'Comentarios'"
                                  prop="comments"
                                  :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <tinymce id="comments" :other_options="tinyOptions" v-model="recommendationForm.comments"/>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-row :gutter="10">
                <el-col :span="3" :offset="14">
                    <el-button type="danger" style="width: 100%" @click="$router.push('/recomendaciones')">Cancelar</el-button>
                </el-col>
                <el-col :span="3.2" >
                    <el-button type="success" style="width: 100%" @click="submitForm(false)">Guardar sin publicar</el-button>
                </el-col>
                <el-col :span="3" >
                    <el-button type="primary" style="width: 100%" @click="submitForm(true)">Guardar y Publicar</el-button>
                </el-col>
            </el-row>
        </el-form>


    </div>
</template>

<script>
    import HeaderSection from "../layouts/partials/HeaderSection";
    import {mapActions, mapGetters } from 'vuex';

    export default {
        props: ['index'],

        components: {
            HeaderSection
        },

        data() {
            return {

                tree: null,
                defaultProps: {
                    children: 'children',
                    label: 'label'
                },

                lang: {
                    "header": {
                        "title": "Agregar Recomendación"
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
                subtopics: [],
                ods: [],
                dates: [],


                props: {
                    label: 'name',
                    children: 'zones'
                },

                apiToken: 'Bearer ' + sessionStorage.getItem('SERIDH_token'),

                recommendationForm: {
                    recommendation: '',
                    cat_entity_id: null,
                    cat_gob_order_id: [],
                    cat_gob_power_id: [],
                    cat_attendig_id: [],
                    cat_population_id: [],
                    cat_solidarity_action_id: [],
                    //cat_subtopic_id: null,
                    cat_ods_id: [],
                    cat_date_id: null,
                    //cat_topic_id: null,
                    comments: '',
                    listRights: [],
                    listThemes: [],


                    files: []
                },

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
            }
        },
        created() {
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
                this.subtopics = response.data.subtopics;
                this.ods = response.data.ods;
                this.dates = response.data.dates;
                this.tree = response.data.tree;

                this.stopLoading();
                if (this.indexEdit!=null){
                    this.errorData(this.indexEdit);
                }

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
            ])
        },
        methods: {
            ...mapActions("bulkLoading", ['deleteRow']),

            themesTree(){
                let ide = this.$refs.themes.getCheckedNodes();
                this.recommendationForm.listThemes=[];
                if (ide.lenght!==0){
                    let $this = this;
                    ide.forEach(function(el){
                        if(el.cat_topic_id!==undefined){
                            $this.recommendationForm.listThemes.push(el);
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
                        if (el.right_id!==undefined){
                            $this.recommendationForm.listRights.push(el);
                        }
                    });
                }
            },
            errorData(e){
                let edit = this.editRow(this.index);
                this.recommendationForm.recommendation = edit.recommendation;
                this.recommendationForm.cat_entity_id = edit.entity ? edit.entity.id : null;
                this.recommendationForm.cat_gob_order_id = edit.gobOrder ? edit.gobOrder.id: null;
                this.recommendationForm.cat_gob_power_id = edit.gobPower ? edit.gobPower.id : null;
                this.recommendationForm.cat_attendig_id = edit.attending ? edit.attending.id : null;
                this.recommendationForm.cat_rights_recommendation_id = edit.rightsRe ? edit.rightsRe.id : null;
                this.recommendationForm.cat_population_id = edit.population ? edit.population.id : null;
                this.recommendationForm.cat_solidarity_action_id = edit.solidarityAction ? edit.solidarityAction.id : null;
                this.recommendationForm.cat_review_right_id = edit.reviewRight ? edit.reviewRight.id : null;
                this.recommendationForm.cat_review_topic_id = edit.review_topic ? edit.review_topic.id : null;
                this.recommendationForm.cat_subtopic_id = edit.subtopic ? edit.subtopic.id : null;
                this.recommendationForm.cat_ods_id = edit.odsIds ? edit.odsIds : [];
                this.recommendationForm.comments = edit.comments;

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


            handleCheckChange(data, checked, indeterminate) {
                console.log(data, checked, indeterminate);
            },
            loadNode(node, resolve) {
                if (node.level === 0) {
                    return resolve([ { name: 'Tema(s)' }]);
                }
                if (node.level > 2) return resolve([]);

                var hasChild;
                if (node.data.name === 'copito') {
                    hasChild = true;
                } else if (node.data.name === 'style') {
                    hasChild = false;
                } else {
                    hasChild = Math.random() > 0.5;
                }

                setTimeout(() => {
                    var data;
                    if (hasChild) {
                        data = [
                            {
                                name: 'A1.5.1-Acceso a la justicia y debido proceso'
                            },
                            {
                                name: 'Acceso a actividades deportivas y recreativas'
                            }
                        ];
                    } else {
                        data = [];
                    }

                    resolve(data);
                }, 500);
            },

            beforeUploadFile(file) {

                if (file.size/1024/1024 > 6) {
                    this.$message.error('El archivo seleccionado excede el limite permitido');

                    return false;
                }

                if (file.type !== 'application/pdf' && file.type !== 'image/jpeg' && file.type !== 'image/jpg' && file.type !== 'image/png') {
                    this.$message.error('Tipo de Archivo no permitido');

                    return false;
                }

                return true;
            },

            uploadedFile(data){
                this.recommendationForm.files.push(data.documentId);
            },

            removeFile(file){
                if( file.response !== undefined ) {
                    for( let i = this.recommendationForm.files.length - 1; i >= 0; i--) {
                        if(this.recommendationForm.files[i] === file.response.documentId) {
                            this.recommendationForm.files.splice(i, 1);
                        }
                    }
                }
            },

            onError(err, file, fileList){
                this.$message({
                    type: 'warning',
                    message: 'No fue posible leer el archivo, inténtelo nuevamente.',
                });
            },

            submitForm(type) {
                this.startLoading();

                this.$refs['recommendationForm'].validate((valid) => {
                    if (valid) {

                        this.recommendationForm.isPublished = type;

                        axios.post('/api/recommendations', this.recommendationForm).then(response => {
                            this.stopLoading();
                            this.deleteRow(this.index);
                            this.$message({
                                type: "success",
                                title: 'Éxito',
                                message: "Se almaceno la información correctamente"
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
                    }
                    else {
                        this.stopLoading();

                        this.$message({
                            type: "warning",
                            title: 'Error',
                            message: "Complete los campos para continuar"
                        });
                    }
                });
            }
        },
    }

</script>

<style>
    .el-upload-dragger { width: 100% !important}
    .el-upload { width: 100% !important;}
</style>

