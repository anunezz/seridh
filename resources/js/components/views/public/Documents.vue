<template>
    <div class="container">

     
  <div class="row">
           <div class="col-md-12">
               <h2>Documentos</h2>
               <hr>
           </div>

<div class="col-md-12">
            <el-form size="small" ref="search" :model="search" >
                        <el-form-item>
                            <el-input style="width: 100%;" placeholder="Búscador de documentos" v-model="search.title">
                                <el-button :disabled="search.title === null" slot="append" icon="el-icon-search" @click="getByFilter"></el-button>
                            </el-input>
                            <div style="display: flex; margin-top: 10px; height: 23px;">
                                <transition v-model="search.title" name="el-fade-in-linear">
                                    <div v-show="show" class="transition-box">
                                        <el-button slot="append" icon="el-icon-refresh-left" @click="cleanFilters">Limpiar Búsqueda</el-button>
                                    </div>
                                </transition>
                            </div>
                        </el-form-item>
            </el-form>
</div>




<div class="col-md-12">
    <el-pagination
        :page-size="parseInt(pagination.perPage)"
        @size-change="handleSizeChange"
        @current-change="handleCurrentChange"
        layout="total"
        :current-page.sync="pagination.currentPage"
        :total="pagination.total">
    </el-pagination>
</div>


<div class="col-md-12">
<table class="table">
  <thead>
    <tr>
      <th scope="col">T&iacute;tulo</th>
      <th scope="col">Descripci&oacute;n</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(o, index) in documents" :key="index">
      <td valign="top" v-text="o.title"></td>
      <td valign="top" v-text="o.description">Otto</td>
      <td valign="top">
        <el-tooltip
                class="item"
                effect="dark"
                content="Descargar"
                placement="top-start">
               
                    <img src="/img/imagenPdf.png" style="height: 40px; width: 40px; cursor:pointer;" @click="downloadDocument(o.id, o.documents.fileNameHash)">

            </el-tooltip>
      </td>
    </tr>
  </tbody>
</table>
</div>

<div class="col-md-12">
      <el-pagination
                                @size-change="handleSizeChange"
                                @current-change="handleCurrentChange"
                                :current-page.sync="pagination.currentPage"
                                :page-sizes="[10, 20, 50, 100]"
                                :page-size="parseInt(pagination.perPage)"
                                layout="sizes, ->, prev, pager, next"
                                :total="pagination.total">
                            </el-pagination>
</div>

<br>
<br>

           </div>
       </div>





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

                numero: 0,

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
                    title: null
                },

                blogs: [],

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

                var config = {
                    headers:{
                        'Content-Type':'application/json',
                        'Accept':'application/json'
                    },
                    params: {
                        page: currentPage,
                        perPage: this.pagination.perPage,
                        isType: 2,
                        filters: this.filters
                    }
                }

                axios.get('/api/recommendations/get/public-files', config).then(response => {

                    if (response.data.success) {

                        this.documents = response.data.documents.data;
                        this.pagination.total = response.data.documents.total;
                        if( this.pagination.total === 0){ this.numero = 3; }
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

            getByFilter() {

                let _search = {
                    filters: this.search,
                    page: 1,
                    perPage: this.pagination.perPage,

                };

                axios.get('/api/public/filter-documents', {params: _search}).then(response => {
                    if (response.data.success) {

                        this.documents = response.data.files.data;
                        this.pagination.total = response.data.files.total;
                        if( this.pagination.total === 0){ this.numero = 3; }
                        this.pagination.currentPage = response.data.files.current_page;
                        this.pagination.perPage = response.data.files.per_page;
                    }
                    this.show = true
                });

            },

            cleanFilters() {
                this.search.title = null;
                this.getDocument();

                this.show = false

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
