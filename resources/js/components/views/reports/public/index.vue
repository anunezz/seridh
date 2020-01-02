<template>
    <div>
        <header-section icon="el-icon-document" title="Reportes">
            <template slot="buttons">
                <el-button
                    size="small"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push('/reportes')">
                    Regresar
                </el-button>
            </template>
        </header-section>

        <el-row :gutter="20">
            <el-col :span="6">
            <p>Documentos descargados</p>
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
                    prop="id"
                    label="Documento">
                </el-table-column>
                <el-table-column
                    prop="title"
                    label="Titulo del documento">
                </el-table-column>
                <el-table-column
                    prop="documents.downloadCount"
                    label="Descargas">
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
                recommendationForm:{
                  files: []
                },

                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10
                },

                apiToken: 'Bearer ' + sessionStorage.getItem('SERIDH_token'),

            }
        },
        created() {
            this.getDocument();

        },

        methods: {

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

            beforeUploadFile(img) {

                if (img.size/1024/1024 > 6) {
                    this.$message.error('El archivo seleccionado excede el limite permitido');

                    return false;
                }

                if (img.type !== img.type !== 'image/jpeg' && img.type !== 'image/jpg' && img.type !== 'image/png') {
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


            handleCurrentChange(currentPage) {
                this.pagination.currentPage = currentPage;
                this.getDocument(currentPage)
            },

            handleSizeChange(sizePerPage) {
                this.pagination.perPage = sizePerPage;
                this.getDocument();
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
