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
                    <!--<el-button
                        size="small"
                        type="primary"
                        icon="fas fa-file-excel"
                        :disabled="downloading">
                        {{ downloadText }}
                    </el-button>-->
                    <el-button
                        v-if="$store.state.user.profile === 1 || 2"
                        icon="fas fa-upload"
                        size="small"
                        type="success"
                        @click="cargaMasiva">
                        Carga Masiva
                    </el-button>
                    <el-button
                        v-if="$store.state.user.profile === 1 || 2"
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
        <el-row>
            <div align="left">
                <el-button size="mini" @click="show=!show">Flitros de búsqueda</el-button>
                <!--  <transition name="boton">
                        <el-button size="mini" v-on:click="getRecommendations" plain @click="cleanFilters" icon="el-icon-refresh-left"><slot>Limpiar Filtro</slot></el-button>
                      </transition>
                  -->
                <!--  <transition name="el-fade-in-linear">
                      <div v-show="getByFilter" class="transition-box">.el-fade-in-linear</div>
                 </transition> -->
            </div>
        </el-row>

        <el-row :gutter="20">
            <el-col :span="6">
                <el-pagination
                    :page-size="parseInt(pagination.perPage)"
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    layout="total"
                    :current-page.sync="pagination.currentPage"
                    :total="pagination.total">
                </el-pagination>
            </el-col>
            <el-col :span="6" :offset="12">
                <!--     <el-button
                         size="medium"
                         icon="fas fa-search"
                         style="width: 100%"
                         @click="showFilters = true">
                         Filtros
                     </el-button>
                -->

            </el-col>
        </el-row>

        <div id="filtersArea">
            <transition appear name="filters">
                <el-container class="form-filters" v-if="show">
                    <el-header style="background-color: rgb(157, 36, 56);">
                        <el-row :gutter="20">
                            <el-col :span="12">
                                <el-button
                                    class="close-button"
                                    type="text"
                                    @click="show = false">
                                    <i class="el-icon-arrow-right"></i>
                                    Minimizar
                                </el-button>
                            </el-col>
                        </el-row>
                    </el-header>
                    <el-main style="border-left: 16px solid #E9EEF3 ">
                        <el-card shadow="never">
                            <div slot="header">
                                <span class="title">Flitros de búsqueda</span>
                            </div>
                            <el-form ref="search" :model="search" label-width="120px" label-position="top">
                                <el-row :gutter="20">
                                    <el-col :span="24">
                                        <el-form-item label="Fecha">
                                            <el-date-picker
                                                style="width: 100%"
                                                v-model="search.date"
                                                type="year"
                                                placeholder="Seleccione un año">
                                            </el-date-picker>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                <el-row>
                                    <el-col :span="24">
                                        <el-form-item label="Recomendación">
                                            <el-input v-model="search.recommendation"/>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                <el-row>
                                    <el-col :span="24">
                                        <el-form-item label="Entidad">
                                            <el-select
                                                v-model="search.cat_entity_id"
                                                filterable
                                                clearable
                                                placeholder="Seleccionar"
                                                style="width: 100%">
                                                <el-option
                                                    v-for="(entitie, index) in catEntity"
                                                    :key="index"
                                                    :label="entitie.name"
                                                    :value="entitie.id">
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                <el-row>
                                    <el-col :span="24">
                                        <el-form-item label="Estatus">
                                            <el-checkbox-group v-model="search.isPublished" :max="1">
                                                <el-checkbox :label="1">Publicado</el-checkbox>
                                                <el-checkbox :label="0">Sin publicar</el-checkbox>
                                            </el-checkbox-group>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                            </el-form>
                            <el-row>
                                <div align="right">
                                    <el-button type="primary" size="small" @click="getByFilter">
                                        Buscar
                                    </el-button>
                                    <el-button type="danger" size="small" plain @click="cleanFilters">
                                        Limpiar
                                    </el-button>
                                </div>
                            </el-row>
                        </el-card>
                    </el-main>
                </el-container>
            </transition>
        </div>
        <el-row :gutter="20">
            <el-col :span="24">
                <el-table
                    size="mini"
                    border
                    :data="recommendations"
                    style="width: 100%">
                    <el-table-column
                        prop="invoice"
                        sortable
                        label="Folio"
                        width="150">
                    </el-table-column>
                    <el-table-column
                        prop="recommendation"
                        sortable
                        label="Recomendación">
                        <template slot-scope="scope">
                            <span v-html="scope.row.format_rec"></span>
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="date"
                        sortable
                        label="Fecha"
                        width="100">
                    </el-table-column>
                    <el-table-column
                        prop="entity.name"
                        sortable
                        width="350"
                        label="Entidad Emisora">
                    </el-table-column>
                    <el-table-column
                        prop="isPublished"
                        sortable
                        label="Estatus"
                        width="120"
                        :filters="[{ text: 'Prublicado', value: 1 }, { text: 'Sin publicar', value: 0 }]"
                        :filter-method="filterEstatus">
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
                                    content="No Publicar"
                                    placement="top-start">
                                    <el-button
                                        type="info"
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
            <h3>¿Está seguro que quiere dejar de publicar esta recomendación?</h3>
            <span slot="footer" class="dialog-footer">
                <el-button type="danger" @click="unpublicDialog = false">Cancelar</el-button>
                <el-button type="success" @click="unpublishRegister">Aceptar</el-button>
            </span>
        </el-dialog>

        <el-dialog
            title="Carga masiva"
            :visible.sync="dialogVisible"
            width="50%">
            <p>
                1. Para ver el formato en el que tiene que realizar la carga masiva, haga clic en la siguiente liga
                <el-link type="primary" @click="getFile"> Formato Excel</el-link>
                .
            </p>
            <p>
                2. Para adjuntar el archivo con la información de sus becarios, haga clic en "Seleccionar archivo"
                escoja el archivo y luego haga clic en "Subir".
            </p>
            <span slot="footer" class="dialog-footer">
                <el-upload
                    class="upload-demo"
                    ref="upload"
                    accept=".xlsx"
                    name="document"
                    action="/api/recommendations/upload/excel"
                    :before-upload="beforeUploadFile"
                    :headers="{'Authorization': apiToken}"
                    :auto-upload="false"
                    :on-error="onError"
                    :on-success="onSeccess">
                    <el-button style="margin-bottom: 10px" slot="trigger" size="small"
                               type="info">Selecciona un archivo</el-button>
                    <el-button size="small" @click="dialogVisible = false,$refs.upload.uploadFiles=[]">Cancelar</el-button>
                    <el-button style="margin-left: 10px;" size="small" type="success"
                               @click="submitUpload">Cargar</el-button>
                  <div slot="tip" class="el-upload__tip">Solo archivos Excel</div>
                </el-upload>
            </span>
        </el-dialog>

        <el-dialog
            title="Errores de carga masiva"
            :visible.sync="errorCarga"
            width="85%">
            <el-table
                :data="errorsBulk"
                style="width: 100%"
                max-height="500">
                <el-table-column type="expand">
                    <template slot-scope="props">
                        <el-row v-if="errorReco(props.row.errorsAll)" style="border: 3px #F56C6C solid;width: 100%">
                            <el-row class="errors">
                                <el-col :span="24"><strong><b>DATOS INCORRECTOS DE LA RECOMENDACIÓN</b></strong></el-col>
                            </el-row>

                            <el-row style="padding: 5px" :gutter="20">
                                <el-col :span="12" v-if="props.row.errorsAll.errorRecommendation!==null">
                                    <strong><b>Recomendación:</b></strong>
                                    <ul>
                                        <li v-for="re in props.row.errorsAll.errorRecommendation">{{re}}</li>
                                    </ul>
                                </el-col>
                                <el-col :span="12" v-if="props.row.errorsAll.errorEntity!==null">
                                    <strong><b>Entidad emisora:</b></strong>
                                    <ul>
                                        <li v-for="entity in props.row.errorsAll.errorEntity">{{entity}}</li>
                                    </ul>
                                </el-col>
                            </el-row>
                            <el-row style="padding: 5px" :gutter="20">
                                <el-col :span="12" v-if="props.row.errorsAll.errorOrdenGob!==null">
                                    <strong><b>Orden de Gobierno:</b></strong>
                                    <ul>
                                        <li v-for="ordenGob in props.row.errorsAll.errorOrdenGob">{{ordenGob}}</li>
                                    </ul>
                                </el-col>
                                <el-col :span="12" v-if="props.row.errorsAll.errorPower!==null">
                                    <strong><b>Poder de Gobierno:</b></strong>
                                    <ul>
                                        <li v-for="power in props.row.errorsAll.errorPower">{{power}}</li>
                                    </ul>
                                </el-col>
                            </el-row>
                            <el-row style=" padding: 5px" :gutter="20">
                                <el-col :span="12" v-if="props.row.errorsAll.errorAuthority!==null">
                                    <strong><b>Autoridad:</b></strong>
                                    <ul>
                                        <li v-for="auto in props.row.errorsAll.errorAuthority">{{auto}}</li>
                                    </ul>
                                </el-col>
                                <el-col :span="12" v-if="props.row.errorsAll.errorPop!==null">
                                    <strong><b>Población:</b></strong>
                                    <ul>
                                        <li v-for="pop in props.row.errorsAll.errorPop">{{pop}}</li>
                                    </ul>
                                </el-col>
                            </el-row>
                            <el-row style=" padding: 5px" :gutter="20">
                                <el-col :span="12" v-if="props.row.errorsAll.errorAction!==null">
                                    <strong><b>Acción Solidaria:</b></strong>
                                    <ul>
                                        <li v-for="action in props.row.errorsAll.errorAction">{{action}}</li>
                                    </ul>
                                </el-col>
                                <el-col :span="12" v-if="props.row.errorsAll.errorAnio!==null">
                                    <strong><b>Año de registro:</b></strong>
                                    <ul>
                                        <li v-for="anio in props.row.errorsAll.errorAnio">{{anio}}</li>
                                    </ul>
                                </el-col>
                            </el-row>
                            <el-row style=" padding: 5px" :gutter="20">
                                <el-col :span="24" v-if="props.row.errorsAll.errorOds!==null">
                                    <strong><b>ODS:</b></strong>
                                    <ul>
                                        <li v-for="ods in props.row.errorsAll.errorOds">{{ods}}</li>
                                    </ul>
                                </el-col>
                            </el-row>
                            <el-row style=" padding: 5px" :gutter="20">
                                <el-col :span="24" v-if="props.row.errorsAll.errorRightslll!==null">
                                    <strong><b>Derecho(s):</b></strong>
                                    <ul>
                                        <li v-for="right in props.row.errorsAll.errorRightslll">{{right}}</li>
                                    </ul>
                                </el-col>
                            </el-row>
                            <el-row style=" padding: 5px" :gutter="20">
                                <el-col :span="24" v-if="props.row.errorsAll.errorTopics!==null">
                                    <strong><b>Tema(s):</b></strong>
                                    <ul>
                                        <li v-for="topic in props.row.errorsAll.errorTopics">{{topic}}</li>
                                    </ul>
                                </el-col>
                            </el-row>
                            <el-row style=" padding: 5px" :gutter="20">
                                <el-col :span="24" v-if="props.row.errorsAll.errorComment!==null">
                                    <strong><b>No tiene nombre oficial del reporte:</b></strong>
                                    <ul>
                                        <li v-for="comment in props.row.errorsAll.errorComment">{{comment}}</li>
                                    </ul>
                                </el-col>
                            </el-row>
                            <el-row style="padding: 5px" :gutter="20" v-if="props.row.errorsAll.errorDocs!==null">
                                <el-col :span="12" >
                                    <strong><b>Folio(s) no encontrado(s) en el sistema:</b></strong>
                                    <ul>
                                        <li v-for="doc in props.row.errorsAll.errorDocs">{{doc}}</li>
                                    </ul>
                                </el-col>
                            </el-row>
                        </el-row>
                        <el-row v-if="props.row.errorReportedActions.length>0"style="border: 3px #F56C6C solid;width: 100%">
                            <el-row class="errors">
                                <el-col :span="24"><strong><b>DATOS INCORRECTOS DE ACCIONES REPORTADAS</b></strong></el-col>
                            </el-row>
                            <el-row style=" padding: 15px" v-for="reported in props.row.errorReportedActions" v-bind:key="reported.rowExcel">
                                <el-row :gutter="20">
                                    <el-divider content-position="left"><strong><b>Error en la fila: {{reported.rowExcel}}</b></strong></el-divider>
                                </el-row>
                                <el-row class="errorRep" v-if="reported.errorDate !== null">
                                    <strong><b>Fecha no valida:</b></strong>
                                    {{reported.errorDate}}
                                </el-row>
                                <el-row class="errorRep" v-if="reported.errorReportedActions.length>0">
                                    <strong><b>Acciones reportadas no validas:</b></strong>
                                    <ul>
                                        <li v-for="repAct in reported.errorReportedActions">
                                            {{repAct}}
                                        </li>
                                    </ul>
                                </el-row>
                                <el-row class="errorRep" v-if="reported.errorPopulation.length>0">
                                    <strong><b>Población beneficiaria</b></strong>
                                    <ul>
                                        <li v-for="popu in reported.errorPopulation">
                                            {{popu}}
                                        </li>
                                    </ul>
                                </el-row>
                                <el-row class="errorRep" v-if="reported.errorAuthorities.length>0">
                                    <strong><b>Autoridades encargadas de atender: </b></strong>
                                    <ul>
                                        <li v-for="aut in reported.errorAuthorities">
                                            {{aut}}
                                        </li>
                                    </ul>
                                </el-row>
                                <el-row class="errorRep" v-if="reported.errorDescription!==null">
                                    <strong><b>Descripción:</b></strong>
                                    {{reported.errorDescription}}
                                </el-row>
                            </el-row>
                        </el-row>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="row"
                    label="Error en fila (Excel)"
                    width="115">
                </el-table-column>
                <el-table-column
                    label="Recomendación">
                    <template slot-scope="recommendation">
                        <span>{{ recommendation.row.textTrunc}}</span>
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
            <el-col>Total: {{errorsBulk.length}}</el-col>
            <span slot="footer" class="dialog-footer">
            <el-button type="primary" size="mini" @click="errorCarga=false">Cancelar</el-button>
            </span>
        </el-dialog>

    </div>
</template>

<script>
    import HeaderSection from "../layouts/partials/HeaderSection";
    import {mapGetters, mapActions} from 'vuex';

    export default {
        components: {
            HeaderSection
        },

        data() {
            return {
                show: false,

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
                errorCarga: false,
                errorRecommendations: [],
                totalErrors: 0,
                checkList: [],
                catEntity: [],
                checked: false,
                checked2: false,
                search: {
                    date: null,
                    recommendation: null,
                    cat_entity_id: null,
                    isPublished: []
                }


            }
        },

        created() {

            this.getRecommendations();
        },
        computed: {
            ...mapGetters("bulkLoading", [
                "errorsBulk"
            ])
        },


        methods: {

            ...mapActions("bulkLoading", ['addRows', 'indexRow']),
            getFile() {
                document.location.href = '/template/Recomendaciones.xlsx';
            },
            filterEstatus(value, row) {
                return row.isPublished === value;
            },

            submitUpload() {
                if (this.$refs.upload.uploadFiles.length===0){
                    this.$message({
                        type: 'warning',
                        message: 'No se seleccionó ningún archivo'
                    });
                }
                this.addRows([]);
                this.$refs.upload.submit();
                this.dialogVisible = false;

            },

            cleanFilters() {
                this.search.recommendation = null;
                this.search.isPublished = [];
                this.search.date = null;
                this.search.cat_entity_id = null;

                this.getRecommendations();

            },

            getByFilter() {

                let _search = {
                    filters: this.search,
                    page: 1,
                    perPage: this.pagination.perPage,

                };


                axios.get('/api/filter-recommendations', {params: _search}).then(response => {
                    if (response.data.success) {

                        this.recommendations = response.data.recommendations.data;
                        this.pagination.total = response.data.recommendations.total;
                        this.pagination.currentPage = response.data.recommendations.current_page;
                        this.pagination.perPage = response.data.recommendations.per_page;
                    }
                });
                this.show = false;

            },

            onError(err, file, fileList) {
                this.stopLoading();
                this.$message({
                    type: 'warning',
                    message: 'No fue posible leer el archivo, inténtelo nuevamente.',
                });
            },
            beforeUploadFile(file) {
                this.startLoading();
                var type = file.name;
                var find = type.search(".xlsx");
                if (file.size / 1024 / 1024 > 6) {
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

            onSeccess(response, file, fileList) {
                this.$refs.upload.uploadFiles=[];
                if (response.success) {
                    this.recommendations = [];
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

                    if (response.filas.length > 0) {
                        this.addRows(response.filas);
                        this.totalErrors = response.filas.length;
                        this.errorCarga = true;
                    }
                    this.stopLoading();
                } else {
                    this.stopLoading();
                    this.$message({
                        type: 'warning',
                        message: 'Archivo incorrecto, descargue el Formato Excel correcto.',
                    });
                }
            },

            bulkLoad(e, index) {
                e.index = index;
                this.indexRow(index);
                this.$router.push({
                    name: 'RecommendationCreate',
                    params: {index: index}
                })
            },

            changeLanguage(language) {
                if (language == 1) {

                }
            },

            addRegister() {
                this.indexRow(null);
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
                    if (response.data.success) {
                        this.recommendations = response.data.recommendations.data;
                        this.pagination.total = response.data.recommendations.total;
                        this.pagination.currentPage = response.data.recommendations.current_page;
                        this.pagination.perPage = response.data.recommendations.per_page;
                        this.catEntity = response.data.entity;
                        this.showFilters = false;
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
            },
            errorReco(data){
                var show = false;
                if (data.errorAction!==null) show = true;
                if (data.errorAnio!==null) show = true;
                if (data.errorAuthority!==null) show = true;
                if (data.errorComment!==null) show = true;
                if (data.errorEntity!==null) show = true;
                if (data.errorOds!==null) show = true;
                if (data.errorOrdenGob!==null) show = true;
                if (data.errorPop!==null) show = true;
                if (data.errorPower!==null) show = true;
                if (data.errorRecommendation!==null) show = true;
                if (data.errorRights!==null) show = true;
                if (data.errorRightslll!==null) show = true;
                if (data.errorTopics!==null) show = true;
                if (data.errorDocs!==null) show = true;
                return show;
            },
            cargaMasiva(){
                this.$refs.upload.uploadFiles=[];
                this.dialogVisible = true;
            }
        },
    }
</script>


<style scoped>
    .errors {
        margin-bottom: 20px;
        text-align: center;
        background-color: #F56C6C;
        color: white; padding: 10px;
    }
    .form-filters {
        position: absolute;
        top: 0;
        right: 0;
        width: 35%;
        min-width: 650px;
        height: 100%;
        background: #fff !important;
        z-index: 1000;
    }

    .filters-enter-active {
        animation-duration: 0.5s;
        animation-name: fadeInRight;
    }

    .filters-leave-active {
        animation-duration: 0.5s;
        animation-name: fadeOutRight;
    }

    .close-button {
        color: #fff !important;
    }

    .close-button:hover {
        opacity: 0.75;
    }
    .el-divider--horizontal {
        display: block;
        height: 4px;
        width: 100%;
        margin: 24px 0;
        background-color: #ca8c6f;
    }
    .errorRep{
        margin-top: 10px;
        border-top: 1px solid #cacaca;
        padding: 7px;
    }
</style>



