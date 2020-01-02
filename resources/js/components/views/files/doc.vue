<template>
    <div>
        <header-section icon="el-icon-document-add" title="Carga de Documentos"></header-section>

        <el-form ref="recommendationForm" :model="recommendationForm" label-width="120px" label-position="top" >
            <el-row :gutter="20">
                <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
                    <el-form-item label="Entidad Emisora"
                                  prop="cat_entity_id"
                                  :rules="[
                                        { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                      ]">
                        <el-select
                            v-model="recommendationForm.cat_entity_id"
                            filterable
                            placeholder="Seleccionar"
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
                <el-col :xs="24" :sm="8" :md="8" :lg="8" :xl="8">
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
            <p></p>
            <br>

            <el-row :gutter="10">
                <el-col :span="24">
                    <el-form-item label="Agrege un documento PDF"
                                  prop="files"
                                  :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-upload
                            class="upload-demo"
                            drag
                            action="/api/recommendations/upload/file/recommendation"
                            accept=".pdf"
                            name="document"
                            clearFiles
                            :limit="1"
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
                    <el-form-item>
                        <el-row :gutter="5" type="flex" class="row-bg" justify="end">
                            <el-col :span="3">
                                <el-button size="medium" type="danger" style="width: 100%" @click="editRegisterDialog = false">Cancelar</el-button>
                            </el-col>
                            <el-col :span="3" >
                                <el-button size="medium" type="primary" style="width: 100%" @click="submitForm">Guardar</el-button>
                            </el-col>
                        </el-row>
                    </el-form-item>
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
                documents: [],
                entities: [],

                recommendationForm: {
                    cat_entity_id: null,
                    date: '',
                    files: [],
                },

                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10
                },

                removeDialog: false,
                publicDialog: false,
                unpublicDialog: false,
                removeHash: null,
                hashId: null,


                apiToken: 'Bearer ' + sessionStorage.getItem('SERIDH_token'),

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
            this.getDocumentRecommendation();

            this.startLoading();
            axios.get('/api/recommendations/create').then(response => {
                this.entities = response.data.entities;
                this.dates = response.data.dates;
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

            beforeUploadFile(file) {

                this.recommendationForm.files = [];

                if (file.size/1024/1024 > 6) {
                    this.$message.error('El archivo seleccionado excede el limite permitido');

                    return false;
                }

                if (file.type !== 'application/pdf') {
                    this.$message.error('Tipo de Archivo no permitido');

                    return false;
                }

                return true;
            },



            uploadedFile(data){
                this.recommendationForm.files.push(data.documentId);
                this.getDocumentRecommendation();
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

            handleCurrentChange(currentPage) {
                this.pagination.currentPage = currentPage;
                this.getDocument(currentPage)
            },

            handleSizeChange(sizePerPage) {
                this.pagination.perPage = sizePerPage;
                this.getDocument();
            },

            onError(err, file, fileList){
                this.$message({
                    type: 'warning',
                    message: 'No fue posible leer el archivo, inténtelo nuevamente.',
                });
            },


            disableDialog(id) {
                this.removeDialog = true;
                //this.publicDialog = true;
                this.removeHash = id;
            },

            disableRecommendation(id) {
                this.startLoading();

                axios.delete(`/api/recommendations/remove/documents/pdf/${id}`, {responseType: 'blob'}).then(response => {
                    this.stopLoading();
                    this.getDocumentRecommendation();
                    this.removeDialog = false;
                    this.removeHash = null;

                    this.$message({
                        type: "success",
                        title: 'Éxito',
                        message: "El documento se elimino correctamente"
                    });

                }).catch(error => {
                    this.stopLoading();

                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            submitForm() {
                this.startLoading();

                this.$refs['recommendationForm'].validate((valid) => {
                    if (valid) {

                        axios.post('/api/recommendations/save/doc', this.recommendationForm).then(response => {
                            this.stopLoading();

                            this.$message({
                                type: "success",
                                title: 'Éxito',
                                message: "Se almaceno la información correctamente"
                            });
                            this.recommendationForm = {};
                            this.$router.push('/archivos/');
                        }).catch(error => {
                            this.stopLoading();

                            this.$message({
                                type: "warning",
                                message: "No fue posible completar la acción, intente nuevamente. " + error
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
            },


        }
    }
</script>

<style scoped>
    .links {
        font-size: 25px;
        color: #9D2449;
        cursor: pointer;
        text-decoration: underline;
    }
</style>
