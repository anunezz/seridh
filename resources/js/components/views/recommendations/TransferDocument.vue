<template>
    <el-row type="flex" class="row-bg" justify="center">
            <el-transfer
                id="transfer"
                :titles="['Lista de documentos', 'Documentos agregados']"
                filterable
                :filter-method="filterMethod"
                filter-placeholder="Buscar folio"
                v-model="items.documents"
                :data="data">
                <el-button type="primary" plain style="margin-left: 10px" slot="left-footer" size="small" @click="getDocumentRecommendation">Actualizar lista</el-button>
                <span slot="right-footer" size="small"/>
            </el-transfer>
    </el-row>
</template>

<script>
    export default {
        props:['items'],
        data(){
            return{
                data: [],
                filterMethod(query, item) {
                    return item.label.toLowerCase().indexOf(query.toLowerCase()) > -1;
                }
            }
        },
        mounted() {
            this.getDocumentRecommendation();
        },
        methods:{
            getDocumentRecommendation(){
                let documentos = [];
                let data = {
                    params: {
                        transfer:true
                    }
                };

                axios.get('/api/recommendations/get/recommendation/files', data).then(response => {
                    if (response.data.success) {
                        let dat = response.data.documents;
                        dat.forEach((element) => {
                            documentos.push({
                                label: element.folio,
                                key: element.id,
                            });
                        });
                    }
                }).catch(error => {
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
                this.data = documentos;
            },
        }
    }
</script>

<style>
    #transfer .el-transfer-panel__header{
        height: 40px;
        width: 600px;
        line-height: 40px;
        background: #bcc8e0;
        margin: 0;
        padding-left: 15px;
        border-bottom: 1px solid #EBEEF5;
        box-sizing: border-box;
        color: #000;
    }
    #transfer .el-transfer-panel {
        border: 1px solid #EBEEF5;
        border-radius: 4px;
        overflow: hidden;
        background: #FFF;
        display: inline-block;
        vertical-align: middle;
        width: 250px;
        max-height: 100%;
        box-sizing: border-box;
        position: relative;
    }
</style>
