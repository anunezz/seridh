<template>
    <div>
        <header-section icon="el-icon-document-add" title="Bandeja de documentos asociados a las recomendaciones">
            <template slot="buttons">
                <el-col :span="3" :offset="21">
                    <el-button size="small" type="success" @click="newDocRec" style="width: 100%">
                        + Documento
                    </el-button>
                </el-col>
            </template>
        </header-section>

            <el-row :gutter="20">
                <el-col :span="6">
                    <p>Archivos agregados</p>
                    <p></p>
                    <el-pagination
                        :page-size="parseInt(pagination.perPage)"
                        @size-change="handleSizeChange"
                        @current-change="handleCurrentChange"
                        layout="total"
                        :current-page.sync="pagination.currentPage"
                        :total="pagination.total">
                    </el-pagination>
                </el-col>
            </el-row>

            <p></p>

            <el-row :gutter="20">
                <el-col :span="24">
                    <el-table
                        size="mini"
                        border
                        :data="documents"
                        style="width: 100%">
                        <el-table-column
                            prop="folio"
                            label="Folio">
                        </el-table-column>
                        <el-table-column
                            prop="documents.fileName"
                            label="Nombre del documento">
                        </el-table-column>

                        <el-table-column
                            label="Acciones" header-align="left" align="center" width="200">
                            <template slot-scope="scope">
                                <el-button-group>
                                    <el-tooltip
                                        class="item"
                                        effect="dark"
                                        content="Eliminar"
                                        placement="top-start">
                                        <el-button
                                            size="mini"
                                            type="danger"
                                            icon="fas fa-trash"
                                            @click="disableDialog(scope.row.hash)">
                                        </el-button>
                                    </el-tooltip>
                                </el-button-group>
                            </template>
                        </el-table-column>
                    <!--    <el-table-column
                            label="Acciones" header-align="left" align="center" width="200">
                            <template slot-scope="scope">
                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Descargar"
                                    placement="top-start">
                                    <el-button
                                        type="primary"
                                        size="mini"
                                        icon="el-icon-download"
                                        style="background: #9363a0; color: whitesmoke;border-color: #9363a0"
                                        @click="downloadDocument(scope.row.id, 'fileName')">
                                    </el-button>
                                </el-tooltip>
                            </template>
                        </el-table-column> -->
                    </el-table>
                    <br>
                    <el-pagination
                        @size-change="handleSizeChange"
                        @current-change="handleCurrentChange"
                        :current-page.sync="pagination.currentPage"
                        :page-sizes="[10, 20, 50, 100]"
                        :page-size="parseInt(pagination.perPage)"
                        layout="sizes, ->, prev, pager, next"
                        :total="pagination.total">
                    </el-pagination>
                </el-col>
            </el-row>

            <el-dialog
                v-if="removeDialog"
                :visible.sync="removeDialog"
                width="40%" style="text-align: center">
                <h3>¿Está seguro que quiere eliminar este documento?</h3>
                <span slot="footer" class="dialog-footer">
                <el-button type="danger" @click="removeDialog = false">Cancelar</el-button>
                <el-button type="success" @click="disableRecommendation(removeHash)">Aceptar</el-button>
            </span>
            </el-dialog>

        <el-dialog title="Carga de Documentos Asociados a las Recomendaciones"
                   :visible.sync="newRegisterDialog"
                   :center="true"
                   :destroy-on-close="true"
                   width="70%">
            <el-card shadow="never">
                <el-form ref="recommendationForm" :model="recommendationForm" label-width="120px" label-position="top" >
                    <el-row :gutter="20">
                        <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                            <el-form-item label="Nombre del Documento"
                                          prop="title"
                                          :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                                <el-input maxlength="70" v-model="recommendationForm.title"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
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
                                    clearable
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
                                    clearable
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
                            <el-form-item label="Agregar un documento PDF"
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
                                        <el-button size="medium" type="danger" style="width: 100%" @click="newRegisterDialog = false">Cancelar</el-button>
                                    </el-col>
                                    <el-col :span="3" >
                                        <el-button size="medium" type="primary" style="width: 100%" @click="submitForm">Guardar</el-button>
                                    </el-col>
                                </el-row>
                            </el-form-item>
                        </el-col>
                    </el-row>
                </el-form>
            </el-card>
        </el-dialog>



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


                recommendationForm:{
                    title: '',
                    files: [],
                    cat_entity_id:'',
                    date:'',
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

                newRegisterDialog: false,


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

            handleCurrentChange(currentPage) {
                this.pagination.currentPage = currentPage;
                this.getDocumentRecommendation(currentPage)
            },

            handleSizeChange(sizePerPage) {
                this.pagination.perPage = sizePerPage;
                this.getDocumentRecommendation();
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

            onError(err, file, fileList){
                this.$message({
                    type: 'warning',
                    message: 'No fue posible leer el archivo, inténtelo nuevamente.',
                });
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

            submitForm() {
                this.startLoading();

                this.$refs['recommendationForm'].validate((valid) => {
                    if (valid) {

                        axios.post('/api/recommendations/save/doc', this.recommendationForm).then(response => {
                            this.stopLoading();

                            this.$message({
                                type: "success",
                                title: 'Éxito',
                                message: "Se almaceno el documento con folio: " + response.data.folio
                            });
                            this.recommendationForm.title = '';
                            this.recommendationForm.cat_entity_id = '';
                            this.recommendationForm.date = '';
                            this.recommendationForm.files = [];
                            this.newRegisterDialog = false;
                            this.getDocumentRecommendation();

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

            downloadDocument(id) {
                this.startLoading();
                console.log('id',id);
                let params = {responseType: 'blob'};

                axios.get(`/api/public/downloadDocumentPublicPdf/${id}`, {params, responseType: 'blob'}).then(response => {

                    //this.documents = response.data.documents;

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

                        this.$message({
                            type: "warning",
                            message: "No fue posible completar la acción, intente nuevamente."
                        });
                    });
            },
            newDocRec(){
                this.recommendationForm.title = '';
                this.recommendationForm.cat_entity_id = '';
                this.recommendationForm.date = '';
                this.recommendationForm.files = [];
                this.newRegisterDialog = true;
            }

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
