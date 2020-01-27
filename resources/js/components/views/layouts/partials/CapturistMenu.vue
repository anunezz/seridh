<template>
    <div>
        <el-row :gutter="10">
            <el-col :span="8">
                <el-badge :value="registers" class="item">
                    <a class="links"
                       @click="goTo('RecommendationsIndex', {cat_transaction_type_id : 1, action: 'Ingresa al index de recomendaciones'})">
                      Recomendaciones
                    </a>
                </el-badge>
                <br><br>
                <span>Bandeja de entrada de Recomendaciones</span>
            </el-col>
            <el-col :span="2">
                <a class="links"
                   @click="goTo('filesIndex', {cat_transaction_type_id : 1, action: 'Subir Documentos e imagenes'})">
                    Archivos
                </a>
                <br><br>
                <span>Bandeja de Documentos</span>
            </el-col>
        </el-row>
        <br><br>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                registers: 0,
            }
        },

        created() {
            axios.get('/api/count-registers').then(response => {
                this.registers = response.data.registers;
            }).catch(error => {
                this.$message({
                    type: "warning",
                    message: "No fue posible completar la acción, intente nuevamente."
                });
            });
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
        },
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
