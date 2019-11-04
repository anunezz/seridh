<template>
    <div>
        <header-section icon="fas fa-copy" title="Bandeja de entrada de Recomendaciones">
            <template slot="buttons">
                <el-button
                    size="small"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push('/')">
                    Regresar
                </el-button>
                <el-button-group>
                    <el-button
                        size="small"
                        type="primary"
                        icon="fas fa-file-excel"
                        :disabled="downloading">
                        {{ downloadText }}
                    </el-button>
                    <el-button
                        icon="fas fa-upload"
                        size="small"
                        type="success"
                        @click="dialogVisible = true">
                        Carga Masiva
                    </el-button>
                    <el-button
                        size="small"
                        type="success"
                        icon="fas fa-edit"
                        @click="addRegister">
                        + Recomendación
                    </el-button>
                </el-button-group>
                <el-button-group v-if="errorsBulk.length>0">
                    <el-tooltip content="Eliminar errores de importación" placement="bottom">
                        <el-button type="primary" size="small" icon="el-icon-delete" @click="addRows([])"></el-button>
                    </el-tooltip>
                    <el-badge :value="errorsBulk.length" :max="99" class="item">
                        <el-button type="danger" size="small" @click="errorCarga=true">Errores</el-button>
                    </el-badge>
                </el-button-group>

            </template>
        </header-section>
        <el-dialog
            title="Carga masiva"
            :visible.sync="dialogVisible"
            width="50%">
            <p>
                1. Para ver el formato en el que tiene que realizar la carga masiva, haga clic en la siguiente liga <el-link type="primary" @click="getFile"> Formato Excel</el-link>.
            </p>
            <p>
                2. Para adjuntar el archivo con la información de sus becarios, haga clic en "Seleccionar archivo" escoja el archivo y luego haga clic en "Subir".
            </p>
            <span slot="footer" class="dialog-footer">
                <el-upload
                    class="upload-demo"
                    ref="upload"
                    accept=".xlsm"
                    name="document"
                    action="/api/recommendations/upload/excel"
                    :before-upload="beforeUploadFile"
                    :headers="{'Authorization': apiToken}"
                    :auto-upload="false"
                    :on-error="onError"
                    :on-success="onSeccess">
                    <el-button style="margin-bottom: 10px" slot="trigger" size="small" type="info">Selecciona un archivo</el-button>
                    <el-button size="small" @click="dialogVisible = false">Cancelar</el-button>
                    <el-button style="margin-left: 10px;" size="small" type="success" @click="submitUpload">Cargar</el-button>
                  <div slot="tip" class="el-upload__tip">Solo archivos Excel</div>
                </el-upload>
            </span>
        </el-dialog>

        <el-dialog
            title="Errores de carga masiva"
            :visible.sync="errorCarga"
            width="80%">
            <el-table
                size="mini"
                border
                :data="errorsBulk"
                style="width: 100%"
                max-height="260">
                <el-table-column
                    prop="recommendation"
                    label="Recomendación">
                    <template slot-scope="scope">
                        <span v-html="scope.row.recommendation"></span>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="entity.name"
                    label="Entidad Emisora">
                </el-table-column>
                <el-table-column
                    prop="ods"
                    label="ODS">
                </el-table-column>
                <el-table-column
                    prop="isPublished"
                    label="Estatus">
                    <template slot-scope="scope">
                        {{ scope.row.isPublished===1 ? 'Publicado' : 'Sin publicar' }}
                    </template>
                </el-table-column>
                <el-table-column
                    label="Acciones" header-align="left" align="center" width="200">
                    <template slot-scope="scope">
                        <el-button-group>
                            <el-tooltip
                                class="item"
                                effect="dark"
                                content="Editar"
                                placement="top-start">
                                <el-button
                                    type="primary"
                                    size="mini"
                                    icon="fas fa-edit"
                                    @click="bulkLoad(scope.row,scope.$index)">
                                </el-button>

                            </el-tooltip>
                        </el-button-group>
                    </template>
                </el-table-column>
            </el-table>
            <br>
            <el-pagination
                :page-size="parseInt(pagination.perPage)"
                @size-change="handleSizeChange"
                @current-change="handleCurrentChange"
                layout="total, ->, prev, pager, next"
                :current-page.sync="pagination.currentPage"
                :total="errorsBulk.length">
            </el-pagination>
            <span slot="footer" class="dialog-footer">
            <el-button type="primary" size="mini" @click="errorCarga=false">Cancelar</el-button>
            </span>
        </el-dialog>

        <el-row :gutter="20">
            <el-col :span="6">
                <el-pagination
                    @size-change="handleSizeChange"
                    :current-page.sync="pagination.currentPage"
                    :page-sizes="[10, 20, 50, 100]"
                    :page-size="parseInt(pagination.perPage)"
                    layout="sizes">
                </el-pagination>
            </el-col>
            <el-col :span="6" :offset="12">
                <el-button
                    size="medium"
                    icon="fas fa-search"
                    style="width: 100%"
                    @click="showFilters = true">
                    Filtros
                </el-button>
            </el-col>
        </el-row>
        <br>
        <el-row :gutter="20">
            <el-col :span="24">
                <el-table
                    size="mini"
                    border
                    :data="recommendations"
                    style="width: 100%">
                    <el-table-column
                        prop="date.name"
                        label="Fecha">
                    </el-table-column>
                    <el-table-column
                        prop="recommendation"
                        label="Recomendación">
                        <template slot-scope="scope">
                            <span v-html="scope.row.recommendation"></span>
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="entity.name"
                        label="Entidad Emisora">
                    </el-table-column>
                    <el-table-column
                        prop="isPublished"
                        label="Estatus">
                        <template slot-scope="scope">
                            {{ scope.row.isPublished ? 'Publicado' : 'Sin publicar' }}
                        </template>
                    </el-table-column>
                    <el-table-column
                        label="Acciones" header-align="left" align="center" width="200">
                        <template slot-scope="scope">
                            <el-button-group>
                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Editar"
                                    placement="top-start">
                                    <el-button
                                        type="primary"
                                        size="mini"
                                        icon="fas fa-edit"
                                        @click="editRegister(scope.row.hash)">
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
                                        size="mini"
                                        icon="fas fa-download"
                                        @click="disableDialogUnPost(scope.row.hash)">
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip
                                    v-if="(scope.row.is_creator || $store.state.user.profile === 1) && scope.row.isActive"
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
                <br>
                <el-pagination
                    :page-size="parseInt(pagination.perPage)"
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    layout="total, ->, prev, pager, next"
                    :current-page.sync="pagination.currentPage"
                    :total="pagination.total">
                </el-pagination>
            </el-col>
        </el-row>

        <el-dialog
            v-if="removeDialog"
            :visible.sync="removeDialog"
            width="40%" style="text-align: center">
            <h3>¿Está seguro que quiere eliminar esta recomendación?</h3>
            <span slot="footer" class="dialog-footer">
                <el-button type="danger" @click="removeDialog = false">Cancelar</el-button>
                <el-button type="success" @click="disableRecommendation(removeHash)">Aceptar</el-button>
            </span>
        </el-dialog>

        <el-dialog
            v-if="publicDialog"
            :visible.sync="publicDialog"
            width="40%" style="text-align: center">
            <h3>¿Está seguro que quiere publicar esta recomendación?</h3>
            <span slot="footer" class="dialog-footer">
                <el-button type="danger" @click="publicDialog = false">Cancelar</el-button>
                <el-button type="success" @click="publishRegister">Aceptar</el-button>
            </span>
        </el-dialog>

        <el-dialog
            v-if="unpublicDialog"
            :visible.sync="unpublicDialog"
            width="40%" style="text-align: center">
            <h3>¿Está seguro de cambiar esta recomendación a estar sin publicar?</h3>
            <span slot="footer" class="dialog-footer">
                <el-button type="danger" @click="unpublicDialog = false">Cancelar</el-button>
                <el-button type="success" @click="unpublishRegister">Aceptar</el-button>
            </span>
        </el-dialog>

    </div>
</template>

<script>
    import HeaderSection from "../layouts/partials/HeaderSection";
    import { mapGetters, mapActions } from 'vuex';

    export default {
        components: {
            HeaderSection
        },

        data() {
            return {
                recommendations: [],
                downloading: false,
                downloadText: 'Descargar Excel',
                dialogVisible: false,

                filters: {
                    recommendation: '',
                },

                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10
                },
                showFilters: false,
                removeDialog: false,
                publicDialog: false,
                unpublicDialog: false,
                removeHash: null,
                hashId: null,
                apiToken: 'Bearer ' + sessionStorage.getItem('SERIDH_token'),
                errorCarga:false,
                errorRecommendations:[],
                totalErrors: 0,
            }
        },

        created() {
            this.getRecommendations();
        },
        computed: {
            ...mapGetters("bulkLoading",[
                "errorsBulk"
            ])
        },
        methods: {
            ...mapActions("bulkLoading", ['addRows','indexRow']),
            getFile() {
                document.location.href = '/template/Recomendaciones.xlsm';
            },

            submitUpload() {
                this.$refs.upload.submit();
                this.dialogVisible = false;

            },

            onError(err, file, fileList){
                this.stopLoading();
                this.$message({
                    type: 'warning',
                    message: 'No fue posible leer el archivo, inténtelo nuevamente.',
                });
            },
            beforeUploadFile(file) {
                this.startLoading();
                var type = file.name;
                var find = type.search(".xlsm");
                if (file.size/1024/1024 > 6) {
                    this.stopLoading();
                    this.$message.error('El archivo seleccionado excede el limite permitido');
                    return false;
                }
                if (find === -1) {
                    this.stopLoading();
                    this.$message.error('Tipo de Archivo no permitido');
                    return false;
                }
                return true;
            },

            onSeccess(response, file, fileList){
                if (response.success){
                    this.recommendations= [];
                    this.getRecommendations();
                    let data = {
                        cat_transaction_type_id: 6,
                        action: 'Iportación de Recomendaciones'
                    };

                    axios.post('/api/transaction', data).then(response => {
                    }).catch(error => {
                        this.$message({
                            type: "warning",
                            message: "No fue posible completar la acción, intente nuevamente."
                        });
                    });

                    if (response.filas.length>0){
                        this.addRows(response.filas);
                        this.totalErrors = response.filas.length;
                        this.errorCarga=true;
                    }
                    this.stopLoading();
                }else {
                    this.stopLoading();
                    this.$message({
                        type: 'warning',
                        message: 'Archivo incorrecto, descargue el Excel.',
                    });
                }
            },

            bulkLoad(e,index){
                e.index=index;
                this.indexRow(index);
                this.$router.push({
                    name: 'RecommendationCreate',
                    params: {index: index}
                })
            },

            changeLanguage(language){
                if(language == 1){

                }
            },

            addRegister() {
                let data = {
                    cat_transaction_type_id: 1,
                    action: 'Ingresa a crear una recomendación'
                };

                axios.post('/api/transaction', data).then(response => {
                    this.$router.push({
                        name: 'RecommendationCreate'
                    });
                }).catch(error => {
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            editRegister(id) {
                let data = {
                    cat_transaction_type_id: 1,
                    action: 'Ingresa a editar una recomendación'
                };

                axios.post('/api/transaction', data).then(response => {
                    this.$router.push({
                        name: 'RecommendationEdit',
                        params: {id: id}
                    });
                }).catch(error => {
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            publishRegister() {
                let data = {
                    id: this.hashId
                };

                axios.post(`/api/recommendations/publish/register`, data).then(response => {
                    this.$message({
                        type: "success",
                        message: "Se ha Publicado correctamente."
                    });

                    this.publicDialog = false;
                    this.getRecommendations();
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

                axios.post('/api/recommendations/unpublish/register', data).then(response => {
                    this.$message({
                        type: "success",
                        message: "Se ha quitado la publicacion correctamente."
                    });

                    this.unpublicDialog = false;
                    this.getRecommendations();
                }).catch(error => {
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            getRecommendations(currentPage = 1) {
                this.startLoading();

                let data = {
                    params: {
                        page: currentPage,
                        perPage: this.pagination.perPage,
                        filters: this.filters
                    }
                };

                axios.get('/api/recommendations', data).then(response => {
                    this.recommendations = response.data.recommendations.data;
                    this.pagination.total = response.data.recommendations.total;
                    this.pagination.currentPage = response.data.recommendations.current_page;
                    this.pagination.perPage = response.data.recommendations.per_page;

                    this.showFilters = false;

                    this.stopLoading();
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
                this.getRecommendations(currentPage)
            },

            handleSizeChange(sizePerPage) {
                this.pagination.perPage = sizePerPage;
                this.getRecommendations();
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

                axios.delete(`/api/recommendations/${id}`, {responseType: 'blob'}).then(response => {
                    this.stopLoading();
                    this.getRecommendations();
                    this.removeDialog = false;
                    this.removeHash = null;

                    this.$message({
                        type: "success",
                        title: 'Éxito',
                        message: "La recomendación se elimino correctamente"
                    });

                }).catch(error => {
                    this.stopLoading();

                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            }
        },
    }
</script>



<style scoped>

</style>
