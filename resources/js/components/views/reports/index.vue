<template>
    <div>
        <header-section icon="el-icon-document" title="Reportes">
            <template slot="buttons">
                <el-button
                    align="right"
                    size="small"
                    type="danger"
                    icon="el-icon-arrow-left"
                    @click="$router.push('/')">
                    Regresar
                </el-button>
            </template>
        </header-section>

        <el-row :gutter="10">
            <el-col :span="8">
                <a class="links"
                   @click="goTo('publicIndex', {cat_transaction_type_id : 1, action: 'Reportes Publico'})">
                    Documentos Públicos
                </a>
                <br><br>
                <span>Reportes</span>
            </el-col>
   <!--         <el-col :span="8">
                <a class="links"
                   @click="goTo('recommendationIndex', {cat_transaction_type_id : 1, action: 'Reportes de Recomendaciones'})">
                    Recomendaciones Publicas
                </a>
                <br><br>
                <span>Reportes</span>
            </el-col>
     -->   </el-row>
    </div>
</template>

<script>
    import HeaderSection from "../layouts/partials/HeaderSection";
    import {mapActions, mapGetters } from 'vuex';

    export default {

        components: {
            HeaderSection
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
