<template>
    <div>
        <header-section icon="el-icon-document" title="Bandeja de Documentos Publicos">
                <template slot="buttons">
                    <el-col :span="3" :offset="21">
                        <el-button size="small" type="success" @click="newRegisterDialog = true" style="width: 100%">
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
                    prop="documents.fileName"
                    label="Documento">
                </el-table-column>
                <el-table-column
                    prop="title"
                    label="Titulo del documento">
                </el-table-column>
                <el-table-column
                    prop="isPublished"
                    sortable
                    label="Estatus"
                    width="120">
                    <template slot-scope="scope">
                        {{ scope.row.isPublished ? 'Publicado' : 'Sin publicar' }}
                    </template>
                </el-table-column>
                <el-table-column
                    label="Acciones" header-align="left" align="center" width="200">
                    <template slot-scope="scope">
                        <el-button-group>
          <!--                  <el-tooltip
                                class="item"
                                effect="dark"
                                content="Editar"
                                placement="top-start">
                                <el-button
                                    type="primary"
                                    size="mini"
                                    icon="fas fa-edit"
                                    @click="editDocument(scope.row.hash)">
                                </el-button>
                            </el-tooltip>
          -->                  <el-tooltip
                                class="item"
                                effect="dark"
                                content="Editar"
                                placement="right-start">
                                <el-button
                                    type="info"
                                    size="mini"
                                    icon="fas fa-edit"
                                    @click="openEditDialog(scope.$index, scope.row.hash, scope.row.title, scope.row.description, scope.row.files)">
                                </el-button>
                            </el-tooltip>
                            <el-tooltip
                                v-if="! scope.row.isPublished"
                                class="item"
                                effect="dark"
                                content="Publicar"
                                placement="top-start">
                                <el-button
                                    type="success"
                                    size="mini"
                                    icon="fas fa-upload"
                                    @click="disableDialogPost(scope.row.hash)">
                                </el-button>
                            </el-tooltip>
                            <el-tooltip
                                v-else
                                class="item"
                                effect="dark"
                                content="Quitar de publicado"
                                placement="top-start">
                                <el-button
                                    type="danger"
                                    style="background: #9363a0; color: whitesmoke;border-color: #9363a0"
                                    size="mini"
                                    icon="fas fa-download"
                                    @click="disableDialogUnPost(scope.row.hash)">
                                </el-button>
                            </el-tooltip>
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
         <!--       <el-table-column
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
                </el-table-column>  -->
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

        <el-dialog
            v-if="publicDialog"
            :visible.sync="publicDialog"
            width="40%" style="text-align: center">
            <h3>¿Está seguro que quiere publicar este documento?</h3>
            <span slot="footer" class="dialog-footer">
                <el-button type="danger" @click="publicDialog = false">Cancelar</el-button>
                <el-button type="success" @click="publishRegister">Aceptar</el-button>
            </span>
        </el-dialog>

        <el-dialog
            v-if="unpublicDialog"
            :visible.sync="unpublicDialog"
            width="40%" style="text-align: center">
            <h3>¿Está seguro de cambiar este documento a estar sin publicar?</h3>
            <span slot="footer" class="dialog-footer">
                <el-button type="danger" @click="unpublicDialog = false">Cancelar</el-button>
                <el-button type="success" @click="unpublishRegister">Aceptar</el-button>
            </span>
        </el-dialog>


        <el-dialog title="Carga de Documentos Publicos"
                   :visible.sync="openRegisterDialog"
                   :center="true"
                   :destroy-on-close="true"
                   width="70%">
            <el-card shadow="never">
                <el-form ref="recommendationForm" :model="recommendationForm" label-width="120px" label-position="top" >
                <el-row :gutter="20">
                    <el-col :span="10">
                        <el-form-item label="Nombre del Documento"
                                      prop="title"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                            <el-input v-model="recommendationForm.title"></el-input>
                        </el-form-item>
                        <el-form-item label="Descripcion del Documento"
                                      prop="description"
                                      :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                            <el-input
                                v-model="recommendationForm.description"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row :gutter="10">
                    <el-col :span="24">
                        <el-form-item label="Agregue un documento PDF"
                                      prop="files"
                                      :rules="[
                                    { required: false, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                            <el-upload
                                class="upload-demo"
                                drag
                                action="/api/recommendations/upload/file"
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
                                <el-col :span="3.2" >
                                    <el-button size="medium" type="success" style="width: 100%" @click="submitForm(false)">Guardar sin publicar</el-button>
                                </el-col>
                                <el-col :span="3.2" >
                                    <el-button size="medium" type="primary" style="width: 100%" @click="submitForm(true)">Guardar y Publicar</el-button>
                                </el-col>
                            </el-row>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>
                </el-card>
        </el-dialog>

        <el-dialog title="Carga de Documentos Publicos"
                   :visible.sync="newRegisterDialog"
                   :center="true"
                   :destroy-on-close="true"
                   width="70%">
            <el-input
                v-if="newRegisterDialog"
                placeholder="Titulo del Documento"
                v-model="newRegisterName"
                maxlength="47"
                clearable>
            </el-input>
            <p></p>
            <br>
            <el-input
                v-if="newRegisterDialog"
                placeholder="Descripción del Documento"
                v-model="newRegisterDescription"
                maxlength="200"
                clearable>
            </el-input>
            <p></p>
            <el-form ref="newRegisterAcronym" :model="newRegisterAcronym" label-width="120px" label-position="top" >
                <el-form-item label="Agregue un documento PDF"
                              prop="files"
                              :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                    <el-upload
                        class="upload-demo"
                        drag
                        action="/api/recommendations/upload/file"
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
            </el-form>

            <span slot="footer" class="dialog-footer">
            <el-button type="danger" @click="newRegisterDialog = false">Cancelar</el-button>
            <el-button v-if="newRegisterDialog"
                       type="success"
                       :disabled="newRegisterName && newRegisterDescription === null"
                       @click="newRegister(false)">Guardar sin Publicar</el-button>
            <el-button v-if="newRegisterDialog"
                       type="primary"
                       :disabled="newRegisterName && newRegisterDescription && newRegisterAcronym === '' && null"
                       @click="newRegister(true)">Guardar y Publicar</el-button>
            </span>
        </el-dialog>

        <el-dialog title="Editar Documento Publico"
                   :visible.sync="editRegisterDialog"
                   width="70%">

            <el-input
                v-if="editRegisterDialog"
                placeholder="Nombre del SubTema"
                v-model="documents[indexRegister].title"
                maxlength="100"
                clearable>
            </el-input>
            <br><br>
            <el-input
                v-if="editRegisterDialog"
                placeholder="Nombre del SubTema"
                v-model="documents[indexRegister].description"
                maxlength="100"
                clearable>
            </el-input>


            <br><br>
            <el-form ref="newRegisterAcronym" :model="newRegisterAcronym" label-width="120px" label-position="top" >
                <el-form-item label="Agregue un documento PDF"
                              prop="files"
                              :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                    <el-upload
                        class="upload-demo"
                        drag
                        action="/api/recommendations/upload/file"
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
            </el-form>

            <p>Archivos agregados</p>
            <el-table
                size="mini"
                border
                :data="documents"
                style="width: 100%">
                <el-table-column
                    prop="documents[indexRegister].files"
                    label="Nombre">
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
            </el-table>


            <span slot="footer" class="dialog-footer">
            <el-button type="danger" @click="editRegisterDialog = false">Cancelar</el-button>
            <el-button v-if="editRegisterDialog"
                       type="primary"
                       :disabled="documents[indexRegister] === ''"
                       @click="editRegister">Aceptar</el-button>
            </span>
        </el-dialog>

        <el-dialog
            v-if="removeDialog"
            :visible.sync="removeDialog"
            width="40%" style="text-align: center">
            <h3>¿Está seguro que quiere eliminar este registo?</h3>
            <span slot="footer" class="dialog-footer">
                <el-button type="danger" @click="removeDialog = false">Cancelar</el-button>
                <el-button type="success" @click="disableSubtopic(removeHash)">Aceptar</el-button>
            </span>
        </el-dialog>

    </div>
</template>

<script>
    import HeaderSection from "../../layouts/partials/HeaderSection";
    import {mapActions, mapGetters } from 'vuex';

    export default {
        props: ['index'],

        components: {
            HeaderSection
        },

        data() {
            return {
                newRegisterName: '',
                newRegisterDescription: '',
                newRegisterAcronym: {
                    files: [],
                },

                show: false,

                documents: [],

                recommendationForm:{
                    title: '',
                    description: '',
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
                newRegisterDialog: false,
                editRegisterDialog: false,
                openRegisterDialog: false,
                indexRegister: null,
                hashRegister: null,
                nameRegister: null,
                descriptionRegister: null,
                acronymRegister: null,
                id: this.$route.params.id,
            }
        },
        created() {
            this.getDocument();

            this.startLoading();
            let id = this.$route.params.id;

            axios.get(`/api/recommendations/edit/doc/${id}`).then(response => {

                this.files = response.data.files;

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

        methods: {
            publishRegister() {
                let data = {
                    id: this.hashId
                };

                axios.post(`/api/recommendations/publish/doc/register`, data).then(response => {
                    this.$message({
                        type: "success",
                        message: "Se ha Publicado correctamente."
                    });

                    this.publicDialog = false;
                    this.getDocument();
                }).catch(error => {
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            unpublishRegister() {
                let data = {
                    id: this.hashId
                };

                axios.post('/api/recommendations/unpublish/doc/register', data).then(response => {
                    this.$message({
                        type: "success",
                        message: "Se ha quitado la publicacion correctamente."
                    });

                    this.unpublicDialog = false;
                    this.getDocument();
                }).catch(error => {
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            getDocument(currentPage = 1) {
                this.startLoading();

                let data = {
                    params: {
                        page: currentPage,
                        perPage: this.pagination.perPage,
                        isType: 2,
                    }
                };

                axios.get('/api/recommendations/get/files', data).then(response => {

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
                this.getDocument(currentPage)
            },

            handleSizeChange(sizePerPage) {
                this.pagination.perPage = sizePerPage;
                this.getDocument();
            },

            disableDialog(id) {
                this.removeDialog = true;
                //this.publicDialog = true;
                this.removeHash = id;
            },

            disableDialogPost(id) {
                this.publicDialog = true;
                this.hashId = id;
            },

            disableDialogUnPost(id) {
                this.unpublicDialog = true;
                this.hashId = id;
            },


            disableRecommendation(id) {
                this.startLoading();

                axios.delete(`/api/recommendations/remove/files/pdf/${id}`, {responseType: 'blob'}).then(response => {
                    this.stopLoading();
                    this.getDocument();
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
            editDocument(id) {
                let data = {
                    cat_transaction_type_id: 1,
                    action: 'Ingresa a editar un documento'
                };

                axios.post('/api/transaction', data).then(response => {
                    this.$router.push({
                        name: 'imagesEdit',
                        params: {id: id}
                    });
                }).catch(error => {
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            beforeUploadFile(file) {

                this.newRegisterAcronym.files = [];

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
                this.newRegisterAcronym.files.push(data.documentId);
            },

            removeFile(file){
                if( file.response !== undefined ) {
                    for( let i = this.newRegisterAcronym.files.length - 1; i >= 0; i--) {
                        if(this.newRegisterAcronym.files[i] === file.response.documentId) {
                            this.newRegisterAcronym.files.splice(i, 1);
                        }
                    }
                }
            },

            submitForm(type) {
                this.startLoading();

                this.$refs['recommendationForm'].validate((valid) => {
                    if (valid) {

                        this.recommendationForm.isPublished = type;

                        axios.post('/api/recommendations/save/file', this.recommendationForm).then(response => {
                            this.stopLoading();


                            this.$message({
                                type: "success",
                                title: 'Éxito',
                                message: "Se almaceno la información correctamente"
                            });
                            this.recommendationForm = {};
                            this.newRegisterDialog = false;
                            this.getDocument();

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

            saveForm() {
                this.startLoading();
                let id = this.$route.params.id;

                this.$refs['files'].validate((valid) => {
                    if (valid) {

                        axios.put(`/api/recommendations/update/document/${id}`, this.files).then(response => {
                            this.stopLoading();

                            this.$message({
                                type: "success",
                                title: 'Éxito',
                                message: "Se Guardo correctamente la informacion"
                            });

                            this.$router.push('/archivos/imagenes');
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

            newRegister(type) {
                this.startLoading();

                let data = {title: this.newRegisterName, description: this.newRegisterDescription,
                            files: this.newRegisterAcronym.files, isPublished: this.isPublished = type};

                axios.post('/api/recommendations/save/file', data).then(response => {

                    if (response.data.success) {
                        this.$notify({
                            type: "success",
                            message: "El registro se creó con éxito."
                        });

                        this.newRegisterName = '';
                        this.newRegisterDescription = '';
                        this.newRegisterAcronym.files = null;
                        this.newRegisterDialog = false;
                        this.getDocument();


                    } else {
                        this.$notify({
                            type: "warning",
                            message: "Error;" + "\nCargue el documento Asociado"
                        });
                    }

                    this.stopLoading();
                }).catch(error => {
                    this.stopLoading();

                    this.$notify({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            openEditDialog(index, id, title, description, files) {
                this.indexRegister = index;
                this.hashRegister = id;
                this.nameRegister = title;
                this.descriptionRegister = description;
                this.acronymRegister = files;

                let data = {cat_transaction_type_id: 1, action: 'Editar Catálogo de Entidades Emisoras'};

                axios.post('/api/transaction', data).then(response => {
                    this.$router.push({
                        name: 'imagesEdit',
                        params: {id: id}
                    });
                    this.editRegisterDialog = true;
                }).catch(error => {
                    this.$notify({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            editRegister() {
                this.startLoading();

                let data = {
                    id: this.hashRegister,
                    title: this.documents[this.indexRegister].title,
                    description: this.documents[this.indexRegister].description,
                    files: this.documents[this.indexRegister].files
                };

                axios.put('/api/recommendations/edit/doc', data).then(response => {

                    if (response.data.success) {
                        this.$notify({
                            type: "success",
                            message: "El registro se actualizó con éxito."
                        });

                        this.editRegisterDialog = false;
                        this.indexRegister = null;
                        this.hashRegister = null;
                        this.nameRegister = null;
                        this.descriptionRegister = null;
                        this.acronymRegister = null;
                        this.getSubtopic();
                    } else {
                        this.documents[this.indexRegister].title = this.nameRegister;
                        this.documents[this.indexRegister].description = this.nameRegister;
                        this.documents[this.indexRegister].files = this.acronymRegister;

                        this.$notify({
                            type: "warning",
                            message: response.data.message
                        });
                    }

                    this.stopLoading();
                }).catch(error => {
                    this.stopLoading();

                    this.$notify({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
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
