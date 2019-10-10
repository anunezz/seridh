<template>
    <div>
        <el-row :gutter="10">
            <el-col :span="8">
                <el-badge :value="openNotices" class="item">
                    <a class="links"
                       @click="goTo('NoticesIndex', {cat_transaction_type_id : 1, action: 'Ingresa a Notices'})">
                        Bandeja de Notice
                    </a>
                </el-badge>
                <br><br>
                <span>Bandeja de entrada</span>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                openNotices: 0
            }
        },

        created() {
            axios.get('/api/count-pending-registers').then(response => {
                this.openNotices = response.data.notices;
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
