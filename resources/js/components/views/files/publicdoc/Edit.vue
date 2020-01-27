<template>
    <div>
        <header-section icon="el-icon-document-add" title="Editar Documento">
            <template slot="buttons">
                <el-button
                    size="medium"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push({name: 'documentFiles',params: {type: 1}});">
                    Regresar
                </el-button>
            </template>
        </header-section>


        <el-form ref="files" :model="files" label-width="120px" label-position="top" >

            <el-row :gutter="20">
                <el-col :span="10">
                    <el-form-item label="Nombre del Documento"
                                  prop="title"
                                  :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-input v-model="files.title"></el-input>
                    </el-form-item>
                    <el-form-item label="Descripcion del Documento"
                                  prop="description"
                                  :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-input v-model="files.description"></el-input>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-row v-if = "documents.length===0">
                <p>Carga de Documentos</p>
                <el-row :gutter="10">
                    <el-col :span="24">
                        <el-form-item>
                            <el-upload
                                class="upload-demo"
                                drag
                                action="/api/recommendations/upload/file"
                                accept=".pdf"
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
            </el-row>


            <el-row v-if="documents.length>0">
                <h4>Archivo cargado</h4>
                <el-table
                    size="mini"
                    border
                    :data="documents"
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
                                    content="Eliminar"
                                    placement="top-start">
                                    <el-button
                                        size="mini"
                                        type="danger"
                                        icon="fas fa-trash"
                                        @click="disableDialog(scope.row.id)">
                                    </el-button>
                                </el-tooltip>
                            </el-button-group>
                        </template>
                    </el-table-column>
                </el-table>
            </el-row>
            <p></p>
            <el-row :gutter="10">
                <el-col :span="24">
                    <el-form-item>
                            <el-row :gutter="5" type="flex" class="row-bg" justify="end">
                                <el-col :span="3">
                                    <el-button size="medium" type="danger" style="width: 100%" @click="$router.push({name: 'documentFiles',params: {type: 1}});">
                                        Cancelar
                                    </el-button>
                                </el-col>
                                <el-col :span="3.2" >
                                    <el-button size="medium" type="success" style="width: 100%" @click="saveForm(false)" :disabled="documents.length===0">Guardar sin publicar</el-button>
                                </el-col>
                                <el-col :span="3.2" >
                                    <el-button size="medium" type="primary" style="width: 100%" @click="submitForm(true)" :disabled="documents.length===0">Guardar y Publicar</el-button>
                                </el-col>
                            </el-row>
                    </el-form-item>
                </el-col>
            </el-row>
        </el-form>

        <el-dialog
            v-if="removeDialog"
            :visible.sync="removeDialog"
            width="40%" style="text-align: center">
            <h3>¿Está seguro que quiere eliminar este registo?</h3>
            <span slot="footer" class="dialog-footer">
                <el-button type="danger" @click="removeDialog = false">Cancelar</el-button>
                <el-button type="success" @click="disableDocument(removeHash)">Aceptar</el-button>
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
                documents: [],
                deleteID:null,

                files:{
                    title: "",
                    description: "",
                    files: [],
                },

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

            }
        },
        created() {
            this.startLoading();
            let id = this.$route.params.id;

            axios.get(`/api/recommendations/edit/document/${id}`).then(response => {
                this.documents.push( response.data.files.documents);
                this.files = response.data.files;

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

            beforeUploadFile(file) {

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
                this.documents.push( {id:data.documentId,fileName:data.name});
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


            handleCurrentChange(currentPage) {
                this.pagination.currentPage = currentPage;
                this.getDocument(currentPage)
            },

            handleSizeChange(sizePerPage) {
                this.pagination.perPage = sizePerPage;
                this.getDocument();
            },

            saveForm() {
                this.startLoading();
                let id = this.$route.params.id;
                let data = {
                    deleteID:this.deleteID,
                    text:this.files,
                    newfile:this.documents[0].id,
                    isPublish:false,
                };
                this.$refs['files'].validate((valid) => {
                    if (valid) {

                        axios.put(`/api/recommendations/update/document/${id}`, data).then(response => {
                            this.stopLoading();

                            this.$message({
                                type: "success",
                                title: 'Éxito',
                                message: "Se Guardo correctamente la informacion"
                            });

                            this.$router.push({
                                name: 'documentFiles',
                                params: {type: 1}
                            });
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
            },


            submitForm() {
                this.startLoading();
                let id = this.$route.params.id;
                let data = {
                    deleteID:this.deleteID,
                    text:this.files,
                    newfile:this.documents[0].id,
                    isPublish:true,
                };
                this.$refs['files'].validate((valid) => {
                    if (valid) {

                        this.files.isPublished = true;

                        axios.put(`/api/recommendations/update/document/publi/${id}`, data).then(response => {
                            this.stopLoading();


                            this.$message({
                                type: "success",
                                title: 'Éxito',
                                message: "Se almaceno la información correctamente"
                            });

                            this.$router.push({
                                name: 'documentFiles',
                                params: {type: 1}
                            });
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

            disableDialog(id) {
                this.removeDialog = true;
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

            disableDocument(id) {
                // this.startLoading();
                this.documents = [];
                this.deleteID = id;
                this.removeDialog=false;
               /* axios.delete(`/api/recommendations/remove/file/${id}`, {responseType: 'blob'}).then(response => {
                    this.stopLoading();

                    this.removeDialog = false;
                    this.removeHash = null;

                    this.$message({
                        type: "success",
                        title: 'Éxito',
                        message: "El registro se eliminó correctamente"
                    });

                }).catch(error => {
                    this.stopLoading();

                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });*/
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
