<template>
    <div>
        <nav style="margin-top: 5px!important;">
            <br style="margin-bottom: 200px;">
            <el-col :offset="10">
                <header-section icon="el-icon-document" title="Documentos"></header-section>
            </el-col>
            
            <p></p>
            <div align="center" class="form-group has-feedback">
                <input type="text" size="30" class="control" placeholder="Buscador de Documentos"></input>
                <i class="glyphicon glyphicon-search has-feedback"></i>
            </div>

            <el-tabs type="border-card">
                <template>
                    <el-main style="border-left: 16px solid #E9EEF3 ">
                        <el-card shadow="never">
                            <div slot="header">
                                <p>Archivos agregados</p>

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
                                <p></p>
                                <br></br>
                                <el-row>
                                    <el-col :span="6" v-for="(o, index) in documents" :key="index"
                                            :offset="index > 0 ? 1 : 1">
                                        <el-card :key="index" shadow="hover" :data="documents" style="height: 500px">
                                            <div class="col-md" >
                                               <!-- <iframe class="card-img-top" src="/app/recommendations/files/" alt="Card image cap"></iframe> -->
                                                <div class="card-body">
                                                    <h5 class="card-title">{{o.title ? o.title : 'Error al mostrar título'}}</h5>
                                                    <p class="card-text">
                                                        {{o.description ? o.description : 'Error al mostrar descripción' }}
                                                    </p>
                                                    <p class="card-text">
                                                        {{o.created_at ? o.created_at : 'Error al mostrar descripción' }}
                                                    </p>
                                                    <el-tooltip
                                                        style="margin-top: 40px"
                                                        class="item"
                                                        effect="dark"
                                                        content="Descargar"
                                                        placement="top-start">
                                                        <el-button
                                                            type="primary"
                                                            size="mini"
                                                            icon="el-icon-download"
                                                            style="background: #9363a0; color: whitesmoke;border-color: #9363a0"
                                                            @click="downloadDocument(o.id, o.documents.fileNameHash)">
                                                            Descargar
                                                        </el-button>
                                                    </el-tooltip>
                                          <!--          <el-tooltip
                                                        class="item"
                                                        effect="dark"
                                                        content="Abrir"
                                                        placement="top-start">
                                                        <el-button
                                                            type="primary"
                                                            size="mini"
                                                            icon="el-icon-view"
                                                            @click="showDiv = !showDiv">
                                                        </el-button>
                                                    </el-tooltip>
                                                    <div v-show=showDiv>
                                                        <iframe class="card-img-bottom" src="/app/recommendations/files/"
                                                                style="height: 150px; width: 250px;" alt=""></iframe>
                                                    </div> -->
                                                </div>

                                                <div align="right" >
                                                    <img class="card-img-bottom" src="/img/imagenPdf.png"
                                                         style="height: 80px; width: 80px;" alt="">
                                                </div>
                                            </div>
                                        </el-card>
                                    </el-col>
                                </el-row>
   <!--                                    <el-table
                                           size="mini"
                                           border
                                           :data="documents"
                                           style="width: 100%">
                                           <el-table-column>
                                               <div class="item">

                                                   <img src="/img/imagenPdf.png" style="height: 54px;" alt="">
                                               </div>
                                         </el-table-column>
                                           <el-table-column
                                               prop="title"
                                               label="Documentos">
                                           </el-table-column>
                                           <el-table-column
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
                                           </el-table-column>
                                       </el-table>
-->
                            </div>
                            <p></p>
                            <el-pagination
                                @size-change="handleSizeChange"
                                @current-change="handleCurrentChange"
                                :current-page.sync="pagination.currentPage"
                                :page-sizes="[10, 20, 50, 100]"
                                :page-size="parseInt(pagination.perPage)"
                                layout="sizes, ->, prev, pager, next"
                                :total="pagination.total">
                            </el-pagination>
                        </el-card>
                    </el-main>
                </template>
            </el-tabs>
        </nav>
    </div>
</template>


<script>
    //import publicdoc from ""
    import HeaderSection from "../layouts/partials/HeaderSection";
    import {mapGetters, mapActions} from 'vuex';

    export default {
        components: {
            HeaderSection
        },

        data() {
            return {

                show: false,

                currentDate: new Date(),
                recommendations: [],
                documents: [],
                files: [],
                showDiv: false,
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
            this.getDocument();

        },


        computed: {
            ...mapGetters("bulkLoading", [
                "errorsBulk"
            ])
        },


        methods: {

            ...mapActions("bulkLoading", ['addRows', 'indexRow']),
            getFile() {
                document.location.href = '/template/Recomendaciones.xlsm';
            },

            getDocument(currentPage = 1) {
                this.startLoading();

                let data = {
                    params: {
                        page: currentPage,
                        perPage: this.pagination.perPage,
                        isType: 2
                    }
                };

                axios.get('/api/recommendations/get/public-files', data).then(response => {

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

            downloadTemplate() {
                document.location.href = '/img/imagenPdf.png';
            },

            downloadDocument(id) {
                this.startLoading();
                console.log('id',id);
                let params = {responseType: 'blob'};

                axios.get(`/api/public/downloadDocumenPdf/${id}`, {params, responseType: 'blob'}).then(response => {

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

            countDocument(id) {
                this.startLoading();

                axios.get(`/api/public/count/documen/pdf/${id}`).then(response => {

                    this.stopLoading();

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


<style scoped>
    .el-upload-dragger {
        width: 100% !important
    }

    .el-upload {
        width: 100% !important;
    }
</style>
<style>
    .time {
        font-size: 13px;
        color: #999;
    }

    .bottom {
        margin-top: 13px;
        line-height: 12px;
    }

    .button {
        padding: 0;
        float: right;
    }

    .image {
        width: 50px;
        height: 50px;
        display: block;
    }

    .clearfix:before,
    .clearfix:after {
        display: table;
        content: "";
    }

    .clearfix:after {
        clear: both
    }

    #contenedor{
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
    }
</style>
