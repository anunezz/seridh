<template>
<div>
    <header-section icon="el-icon-document-add" title="Documentos">
        <template slot="buttons">
            <el-button
                size="small"
                type="danger"
                icon="el-icon-arrow-left"
                @click="$router.push('/archivos/')">
                Regresar
            </el-button>
        </template>
    </header-section>

    <el-row :gutter="10">
        <el-col :span="24">
            <el-select v-model="selectedCat"
                       placeholder="Seleccione un Opción"
                       style="width: 100%">
                <el-option
                    v-for="(cat, index) in cats"
                    :key="index"
                    :label="cat.name"
                    :value="cat.id">
                </el-option>
            </el-select>
        </el-col>
    </el-row>
    <br>
    <publicdoc v-if="selectedCat === 1"/>
    <recommendationdoc v-if="selectedCat === 2"/>

</div>
</template>

<script>

    import HeaderSection from "../layouts/partials/HeaderSection";
    import publicdoc from "../files/publicdoc/index";
    import recommendationdoc from "../files/recommendationdoc";


    export default {
        components: {
            HeaderSection,
            publicdoc,
            recommendationdoc,

        },

        data(){
            return{
                selectedCat: null,
                cats: [
                    {id:1, name: 'Bandeja de documentos publicos'},
                    {id:2, name: 'Bandeja de documento asociados a las recomendaciones'},

                ],
            }
        },

        methods: {
            goTo(link, data) {
                axios.post('/api/transaction', data).then(response => {
                    this.$router.push({
                        name: link
                    });
                }).catch(error => {
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
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
