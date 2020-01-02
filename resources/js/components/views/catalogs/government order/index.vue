<template>
    <div>
        <header-section icon="el-icon-document" title="Orden de Gobierno">
            <template slot="buttons">
                <el-col :span="5" :offset="7">
                    <el-button type="success" @click="newRegisterDialog = true" style="width: 100%">
                        Nuevo registro
                    </el-button>
                </el-col>

            </template>
        </header-section>

        <el-row :gutter="20">
            <el-col :span="6">
                <p>Archivos agregados</p>
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
        <br>
        <el-row :gutter="20">
            <el-col :span="24">
                <el-table
                    :data="orders"
                    size="mini"
                    border
                    style="width: 100%">
                    <el-table-column
                        prop="name"
                        label="Nombre de Orden de Gobierno">
                    </el-table-column>
                    <el-table-column
                        label="Acciones" header-align="left" align="center">
                        <template slot-scope="scope">
                            <el-button-group size="mini">
                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Editar"
                                    placement="right-start">
                                    <el-button
                                        type="info"
                                        size="mini"
                                        icon="fas fa-edit"
                                        @click="openEditDialog(scope.$index, scope.row.hash, scope.row.name)">
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip
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

        <el-dialog title="Nuevo Registro"
                   :visible.sync="newRegisterDialog"
                   width="70%">
            <el-input
                v-if="newRegisterDialog"
                placeholder="Nombre de Orden de Gobierno"
                v-model="newRegisterName"
                maxlength="100"
                clearable>
            </el-input>
            <span slot="footer" class="dialog-footer">
            <el-button type="danger" @click="newRegisterDialog = false">Cancelar</el-button>
            <el-button v-if="newRegisterDialog"
                       type="primary"
                       :disabled="newRegisterName === ''"
                       @click="newRegister">Aceptar</el-button>
            </span>
        </el-dialog>

        <el-dialog title="Editar Registro"
                   :visible.sync="editRegisterDialog"
                   width="70%">
            <el-input
                v-if="editRegisterDialog"
                placeholder="Tipo de Información"
                v-model="orders[indexRegister].name"
                maxlength="100"
                clearable>
            </el-input>
            <span slot="footer" class="dialog-footer">
            <el-button type="danger" @click="editRegisterDialog = false">Cancelar</el-button>
            <el-button v-if="editRegisterDialog"
                       type="primary"
                       :disabled="orders[indexRegister].name === ''"
                       @click="editRegister">Aceptar</el-button>
            </span>
        </el-dialog>

        <el-dialog
            v-if="removeDialog"
            :visible.sync="removeDialog"
            width="40%" style="text-align: center">
            <h3>¿Está seguro que quiere eliminar este registo?</h3>
            <span slot="footer" class="dialog-footer">
                <el-button type="danger" @click="removeDialog = false">Cancelar</el-button>
                <el-button type="success" @click="disableOrder(removeHash)">Aceptar</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
    import HeaderSection from "../../layouts/partials/HeaderSection";

    export default {



        components: {
            HeaderSection
        },

        data() {
            return {

                orders: [],

                search: '',

                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10
                },

                newRegisterDialog: false,
                newRegisterName: '',

                editRegisterDialog: false,
                indexRegister: null,
                hashRegister: null,
                nameRegister: null,

                removeDialog: false,
                publicDialog: false,
                unpublicDialog: false,
                removeHash: null,
                hashId: null,

                apiToken: 'Bearer ' + sessionStorage.getItem('SERIDH_token'),
            }
        },

        created() {
            this.startLoading();
            axios.get('/api/recommendations/create').then(response => {
                this.ods = response.data.ods;
                this.entities = response.data.entities;
                this.orders = response.data.orders;
                this.powers = response.data.powers;
                this.attendings = response.data.attendings;
                this.rights = response.data.rights;
                this.populations = response.data.populations;
                this.actions = response.data.actions;
                this.topics = response.data.topics;
                //    this.subtopics = response.data.subtopics;
                this.ods = response.data.ods;
                this.dates = response.data.dates;
                this.tree = response.data.tree;
                this.stopLoading();
                if (this.indexEdit!=null){
                    this.errorData(this.indexEdit);
                }

            }).catch(error => {
                this.stopLoading();

                this.$message({
                    type: "warning",
                    message: "No fue posible completar la acción, intente nuevamente."
                });
            });


            this.getOrders();
        },


        methods: {

            getOrders(currentPage = 1) {
                this.startLoading();

                let data = {
                    params: {
                        page: currentPage,
                        perPage: this.pagination.perPage,
                        search: this.search,
                        cat: 2
                    }
                };

                axios.get('/api/cats/get/catalogos', data).then(response => {

                    if (response.data.success) {

                        this.orders = response.data.order.data;
                        this.pagination.total = response.data.order.total;
                        this.pagination.currentPage = response.data.order.current_page;
                        this.pagination.perPage = response.data.order.per_page;

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
                this.getOrders(currentPage)
            },

            handleSizeChange(sizePerPage) {
                this.pagination.perPage = sizePerPage;
                this.getOrders();
            },

            newRegister() {
                this.startLoading();

                let data = {cat: 2, name: this.newRegisterName};

                axios.post('/api/cats/new-register', data).then(response => {

                    if (response.data.success) {
                        this.$notify({
                            type: "success",
                            message: "El registro se creó con éxito."
                        });

                        this.newRegisterName = '';
                        this.newRegisterDialog = false;
                        this.getOrders();
                    } else {
                        this.$notify({
                            type: "warning",
                            message: response.data.message
                        });
                    }

                    this.stopLoading();
                }).catch(error => {
                    this.stopLoading();

                    this.$notify({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            openEditDialog(index, id, name) {
                this.indexRegister = index;
                this.hashRegister = id;
                this.nameRegister = name;

                let data = {cat_transaction_type_id: 1, action: 'Editar Catálogo de Orden de Gobierno'};

                axios.post('/api/transaction', data).then(response => {
                    this.editRegisterDialog = true;
                }).catch(error => {
                    this.$notify({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            editRegister() {
                this.startLoading();

                let data = {id: this.hashRegister, cat: 2, name: this.orders[this.indexRegister].name};

                axios.put('/api/cats/update/register', data).then(response => {

                    if (response.data.success) {
                        this.$notify({
                            type: "success",
                            message: "El registro se actualizó con éxito."
                        });

                        this.editRegisterDialog = false;
                        this.indexRegister = null;
                        this.hashRegister = null;
                        this.nameRegister = null;
                        this.getOrders();
                    } else {
                        this.orders[this.indexRegister].name = this.nameRegister;

                        this.$notify({
                            type: "warning",
                            message: response.data.message
                        });
                    }

                    this.stopLoading();
                }).catch(error => {
                    this.stopLoading();

                    this.$notify({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            onNameChanged(value) {
                this.orders[this.indexRegister].name = value.replace(/[#$%&?|+=*!<>"';()/{}[\]\\]/g, "");
            },

            disableDialog(id) {
                this.removeDialog = true;
                //this.publicDialog = true;
                this.removeHash = id;
            },

            disableOrder(id) {
                this.startLoading();

                axios.delete(`/api/cats/remove/order/${id}`, {responseType: 'blob'}).then(response => {
                    this.stopLoading();
                    this.getOrders();
                    this.removeDialog = false;
                    this.removeHash = null;

                    this.$message({
                        type: "success",
                        title: 'Éxito',
                        message: "El registro se eliminó correctamente"
                    });

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

