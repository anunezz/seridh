<template>
    <div>
        <header-section icon="fa-edit" title="Editar recomendacion">
            <template slot="buttons">
                <el-button
                    size="medium"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push('/recomendaciones')">
                    Regresar
                </el-button>
            </template>
        </header-section>
        <el-form ref="recommendationForm" :model="recommendationForm" label-width="120px" label-position="top" >
            <el-row :gutter="10">
                <el-col :span="24">
                    <el-form-item label="Texto de Recomendación"
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
                    <el-form-item label="Entidad Emisora"
                                  prop="cat_entity_id"
                                  :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                      ]">
                        <el-select
                            v-model="recommendationForm.cat_entity_id"
                            filterable
                            placeholder="Seleccionar"
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
                    <el-form-item label="Orden de Gobierno"
                                  prop="cat_gob_order_id"
                                  :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                      ]">
                        <el-select
                            v-model="recommendationForm.cat_gob_order_id"
                            filterable
                            multiple
                            placeholder="Seleccionar"
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
                    <el-form-item label="Poder de Gobierno"
                                  prop="cat_gob_power_id"
                                  :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-select
                            v-model="recommendationForm.cat_gob_power_id"
                            filterable
                            multiple
                            placeholder="Seleccionar"
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
                    <el-form-item label="Autoridadad"
                                  prop="cat_attendig_id"
                                  :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                      ]">
                        <el-select
                            v-model="recommendationForm.cat_attendig_id"
                                   filterable
                                   multiple
                                   placeholder="Seleccionar"
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
                    <el-form-item label="Población"
                                  prop="cat_population_id"
                                  :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                      ]">
                        <el-select
                            v-model="recommendationForm.cat_population_id"
                            filterable
                            multiple
                            placeholder="Seleccionar"
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
                    <el-form-item label="Acción Solidaria"
                                  prop="cat_solidarity_action_id"
                                  :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                      ]">
                        <el-select
                            v-model="recommendationForm.cat_solidarity_action_id"
                            filterable
                            multiple
                            placeholder="Seleccionar"
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
                    <el-form-item label="ODS"
                                  prop="cat_ods_id"
                                  :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                      ]">
                        <el-select
                            v-model="recommendationForm.cat_ods_id"
                            filterable
                            multiple
                            placeholder="Seleccionar"
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
                    <el-form-item label="Año de registro"
                                  prop="date"
                                  :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: 'blur'},
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
            </el-row>
            <el-row :gutter="20">
                <el-col :span="12">
                    <el-tree
                        ref="rights"
                        :data="rights"
                        show-checkbox
                        node-key="id"
                        :props="defaultProps"
                        :default-checked-keys="showIds"
                        @check="rightsTree">
                    </el-tree>
                </el-col>
                <el-col :span="12">
                    <el-tree
                        ref="tree"
                        :data="topics"
                        show-checkbox
                        node-key="id"
                        :props="defaultProps"
                        :default-checked-keys="showIde"
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

            <p>Archivos agregados</p>
            <el-table
                size="mini"
                border
                :data="recommendationForm.documents"
                style="width: 100%">
                <el-table-column
                    prop="fileName"
                    label="Nombre">
                </el-table-column>
                <el-table-column
                    label="Acciones" header-align="left" align="center" width="200">
                    <template slot-scope="scope">
                        <el-button-group>
                            <el-tooltip
                                class="item"
                                effect="dark"
                                content="Descargar archivo"
                                placement="top-start">
                                <el-button
                                    type="primary"
                                    size="mini"
                                    icon="fas fa-file"
                                    @click="showFile(scope.row.hash)">
                                </el-button>
                            </el-tooltip>
                            <el-tooltip
                                v-if="scope.row.is_creator || $store.state.user.profile === 1"
                                class="item"
                                effect="dark"
                                content="Eliminar"
                                placement="top-start">
                                <el-button
                                    size="mini"
                                    type="danger"
                                    icon="fas fa-trash"
                                    @click="deleteFile(scope.row.hash, scope.$index)">
                                </el-button>
                            </el-tooltip>
                        </el-button-group>
                    </template>
                </el-table-column>
            </el-table>

            <el-row :gutter="10">
                <el-col :span="24">
                    <el-form-item label="Comentarios"
                                  prop="comments"
                                  :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <tinymce id="comments" :other_options="tinyOptions" v-model="recommendationForm.comments"/>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-row :gutter="10">
                <el-col :span="3" :offset="13">
                    <el-button type="danger" style="width: 100%" @click="$router.push('/recomendaciones')">Cancelar</el-button>
                </el-col>
                <el-col :span="3.5" >
                    <el-button type="success" style="width: 100%" @click="submitForm(false)">Actualizar y Quitar de publicado </el-button>
                </el-col>
                <el-col :span="3.1" >
                    <el-button type="primary" style="width: 100%" @click="submitForm(true)">Actualizar y Publicar</el-button>
                </el-col>
            </el-row>
        </el-form>


    </div>
</template>

<script>
    import HeaderSection from "../layouts/partials/HeaderSection";

    export default {
        components: {
            HeaderSection
        },

        data() {
            return {
                showIds:[],
                showIde:[],

                tree: null,
                defaultProps: {
                    children: 'children',
                    label: 'label'
                },


                entities: [],
                orders: [],
                powers: [],
                attendings: [],
                rights: [],
                populations: [],
                actions: [],
                reviews: [],
                topics: [],
             //   subtopics: [],
                ods: [],
                dates: [],


                props: {
                    label: 'name',
                    children: 'zones'
                },

                recommendationId: this.$route.params.id,
                apiToken: 'Bearer ' + sessionStorage.getItem('SERIDH_token'),

                recommendationForm: {
                    recommendation: '',
                    cat_entity_id: null,
                    cat_gob_order_id: [],
                    cat_gob_power_id: [],
                    cat_attendig_id: [],
                    cat_rights_recommendation_id: null,
                    cat_population_id: [],
                    cat_solidarity_action_id: [],
                    cat_review_right_id: null,
                    cat_review_topic_id: null,
                    //cat_subtopic_id: [],
                    cat_ods_id: [],
                    date: null,
                    comments: '',
                    listThemes: [],
                    listRights: []

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
            let recommendationId = this.$route.params.id;

            axios.get(`/api/recommendations/${recommendationId}/edit`).then(response => {
                this.entities = response.data.entities;
                this.orders = response.data.orders;
                this.powers = response.data.powers;
                this.attendings = response.data.attendings;
                this.rights = response.data.rights;
                this.populations = response.data.populations;
                this.actions = response.data.actions;
                this.reviews = response.data.reviews;
                this.topics = response.data.topics;
         //       this.subtopics = response.data.subtopics;
                this.ods = response.data.ods;
                this.dates = response.data.dates;
                this.tree = response.data.tree;
                this.recommendationForm = response.data.recommendationForm;
                this.recommendationForm.files = [];
                this.showIds = response.data.showIds;
                this.showIde = response.data.showIde;

                this.stopLoading();

            }).catch(error => {
                this.stopLoading();

                this.$message({
                    type: "warning",
                    message: "No fue posible completar la acción, intente nuevamente."
                });
            });
        },
        methods: {
            handleCheckChange(data, checked, indeterminate) {
                console.log(data, checked, indeterminate);
            },

            themesTree(){
                let ide = this.$refs.tree.getCheckedNodes();
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

            loadNode(node, resolve) {
                if (node.level === 0) {
                    return resolve([ { name: 'Tema(s)' }]);
                }
                if (node.level > 2) return resolve([]);

                let hasChild;
                if (node.data.name === 'copito') {
                    hasChild = true;
                } else if (node.data.name === 'style') {
                    hasChild = false;
                } else {
                    hasChild = Math.random() > 0.5;
                }

                setTimeout(() => {
                    let data;
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
                let recommendationId = this.$route.params.id;

                this.$refs['recommendationForm'].validate((valid) => {
                    if (valid) {

                        this.recommendationForm.isPublished = type;

                        axios.put(`/api/recommendations/${recommendationId}`, this.recommendationForm).then(response => {
                            this.stopLoading();

                            this.$message({
                                type: "success",
                                title: 'Éxito',
                                message: "Se actualizo la información correctamente"
                            });

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
                    }
                });
            },

            showFile(id) {

                axios.get(`/api/recommendations/get/file/${id}`, {responseType: 'blob'}).then(response => {
                    let disposition = response.headers['content-disposition'];
                    let filename = '';
                    if (disposition && disposition.indexOf('inline') !== -1) {
                        let filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                        let matches = filenameRegex.exec(disposition);
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
                })
                    .catch(error => {
                        console.log("error", error);
                    });

            },

            deleteFile(id, index) {
                this.startLoading();

                axios.get(`/api/recommendations/remove/file/${id}`, {responseType: 'blob'}).then(response => {
                    this.stopLoading();

                    this.recommendationForm.documents.splice(index, 1);

                    this.$message({
                        type: "success",
                        title: 'Éxito',
                        message: "El archivo se elimino correctamente"
                    });

                }).catch(error => {
                    this.stopLoading();

                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },
        },
    }

</script>

<style>
    .el-upload-dragger { width: 100% !important}
    .el-upload { width: 100% !important;}
</style>

