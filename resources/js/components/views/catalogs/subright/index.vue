<template>
    <div>
        <header-section icon="el-icon-document" title="Derechos Nivel 2">
            <template slot="buttons">
                <el-col :span="5" :offset="7">
                    <el-button type="success" @click="subRight" style="width: 100%">
                        Nuevo registro
                    </el-button>
                </el-col>
                <el-col :span="10" :offset="1">
                    <el-input
                        clearable
                        suffix-icon="fas fa-search"
                        placeholder="Buscar por derechos nivel 1 y nivel 2"
                        v-model="search"
                        @change="getSubrights(search)">
                    </el-input>
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
                    :data="subrights"
                    size="mini"
                    border
                    style="width: 100%">
                    <el-table-column
                        prop="rigth_recommendation.name"
                        label="Derechos Nivel 1">
                    </el-table-column>
                    <el-table-column
                        prop="name"
                        label="Derechos Nivel 2">
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
                                        @click="openEditDialog(scope.$index, scope.row.hash, scope.row.name, scope.row.rights_recommendations_id)">
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip v-if="scope.row.is_used" placement="right-start">
                                    <div slot="content">
                                        Este elemento no se puede eliminar dado que
                                        <br/>
                                        esta siendo utilizado por una recomendación
                                    </div>
                                    <span>
                                        <el-button
                                            type="danger"
                                            size="mini"
                                            icon="fas fa-trash"
                                            disabled>
                                        </el-button>
                                    </span>
                                </el-tooltip>
                                <el-tooltip
                                    v-if="! scope.row.is_used && scope.row.isActive"
                                    class="item"
                                    effect="dark"
                                    content="Eliminar"
                                    placement="right-start">
                                    <el-button
                                        type="danger"
                                        size="mini"
                                        icon="fas fa-trash"
                                        @click="disableDialog(scope.row.hash)">
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip
                                    v-if="! scope.row.is_used && ! scope.row.isActive"
                                    class="item"
                                    effect="dark"
                                    content="Habilitar"
                                    placement="right-start">
                                    <el-button
                                        type="success"
                                        size="mini"
                                        icon="fas fa-check"
                                        @click="enableRegister(scope.row.hash)">
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
                placeholder="Nombre del Derecho de Nivel 2"
                v-model="newRegisterName"
                maxlength="100"
                clearable>
            </el-input>
            <el-form ref="newRegisterAcronym" :model="newRegisterAcronym" label-position="top" >
            <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                <el-form-item label="Derechos de Nivel 1"
                              prop="rights_recommendations_id"
                              :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                    <el-select
                        v-model="newRegisterAcronym.rights_recommendations_id"
                        filterable
                        placeholder="Seleccionar"
                        clearable
                        style="width: 100%">
                        <el-option
                            v-for="(right, index) in rig"
                            :key="index"
                            :label="right.name"
                            :value="right.id">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-col>
            </el-form>
            <span slot="footer" class="dialog-footer">
            <el-button type="danger" @click="newRegisterDialog = false">Cancelar</el-button>
            <el-button v-if="newRegisterDialog"
                       type="primary"
                       :disabled="newRegisterName === '' || newRegisterAcronym.rights_recommendations_id.length===0"
                       @click="newRegister">Aceptar</el-button>
            </span>
        </el-dialog>

        <el-dialog title="Editar Registro Derecho Nivel 2"
                   :visible.sync="editRegisterDialog"
                   width="70%" :before-close="handleClose">
            <el-input
                v-if="editRegisterDialog"
                placeholder="Nombre del Derecho de Nivel 2"
                v-model="subrights[indexRegister].name"
                maxlength="100"
                clearable>
            </el-input>
            <br><br>
            <el-select v-if="editRegisterDialog"
                       :disabled="subrights[indexRegister].is_used && subrights[indexRegister].isActive"
                       v-model="subrights[indexRegister].rights_recommendations_id"
                       filterable placeholder="Seleccionar"
                       style="width: 100%">
                <el-option
                    v-for="(right , index) in rig"
                    :key="index"
                    :label="right.name"
                    :value="right.id">
                </el-option>
            </el-select>

            <span slot="footer" class="dialog-footer">
            <el-button type="danger" @click="getSubrights(),editRegisterDialog = false">Cancelar</el-button>
            <el-button v-if="editRegisterDialog"
                       type="primary"
                       :disabled="subrights[indexRegister].name === ''"
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
                <el-button type="success" @click="disableRegister(removeHash)">Aceptar</el-button>
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

                subrights: [],
                rights: [],
                rig: [],


                search: '',

                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10
                },

                newRegisterDialog: false,
                newRegisterName: '',
                newRegisterAcronym: {
                    rights_recommendations_id: [],
                },

                editRegisterDialog: false,
                indexRegister: null,
                hashRegister: null,
                nameRegister: null,
                acronymRegister: null,

                removeDialog: false,
                publicDialog: false,
                unpublicDialog: false,
                removeHash: null,
                hashId: null,

                apiToken: 'Bearer ' + sessionStorage.getItem('SERIDH_token'),
            }
        },

        created() {

            this.getSubrights();
            this.startLoading();
            axios.get('/api/recommendations/create').then(response => {

                this.rig = response.data.rig;

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
        },


        methods: {

            getSubrights(currentPage = 1) {
                this.startLoading();

                let data = {
                    params: {
                        page: currentPage,
                        perPage: this.pagination.perPage,
                        search: this.search,
                        cat: 11
                    }
                };

                axios.get('/api/cats/get/catalogos', data).then(response => {

                    if (response.data.success) {

                        this.rights = response.data.elements;
                        this.subrights = response.data.elements.data;
                        this.pagination.total = response.data.elements.total;
                        this.pagination.currentPage = response.data.elements.current_page;
                        this.pagination.perPage = response.data.elements.per_page;

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
                this.getSubrights(currentPage)
            },

            handleSizeChange(sizePerPage) {
                this.pagination.perPage = sizePerPage;
                this.getSubrights();
            },

            newRegister() {
                this.startLoading();

                let data = {cat: 11, name: this.newRegisterName, rights_recommendations_id: this.newRegisterAcronym.rights_recommendations_id};

                axios.post('/api/cats/new-register', data).then(response => {

                    if (response.data.success) {
                        this.$notify({
                            type: "success",
                            message: "El registro se creó con éxito."
                        });

                        this.newRegisterName = '';
                        this.newRegisterAcronym.rights_recommendations_id = null;
                        this.newRegisterDialog = false;
                        this.getSubrights();
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

            openEditDialog(index, id, name, acronym) {
                this.indexRegister = index;
                this.hashRegister = id;
                this.nameRegister = name;
                this.acronymRegister = acronym;

                let data = {cat_transaction_type_id: 1, action: 'Editar Catálogo de SubDerechos'};

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
                console.log(this.subrights[this.indexRegister].rights_recommendations_id);
                let data = {
                    id: this.hashRegister,
                    cat: 11,
                    name: this.subrights[this.indexRegister].name,
                    rights_recommendations_id: this.subrights[this.indexRegister].rights_recommendations_id
                };

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
                        this.acronymRegister = null;
                        this.getSubrights();
                    } else {
                        this.subrights[this.indexRegister].name = this.nameRegister;
                        this.subrights[this.indexRegister].rights_recommendations_id = this.acronymRegister;

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
                this.subrights[this.indexRegister].name = value.replace(/[#$%&?|+=*!<>"';()/{}[\]\\]/g, "");
            },

            onAcronymChanged(value){
                this.subrights[this.indexRegister].rights_recommendations_id = value.replace(/[#$%&?|+=*!<>"';()/{}[\]\\]/g, "");
            },

            disableDialog(id) {
                this.removeDialog = true;
                //this.publicDialog = true;
                this.removeHash = id;
            },

            disableSubRights(id) {
                this.startLoading();

                axios.delete(`/api/cats/remove/subright/${id}`, {responseType: 'blob'}).then(response => {
                    this.stopLoading();
                    this.getSubrights();
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

            subRight(){
                this.newRegisterName = '';
                this.newRegisterAcronym.rights_recommendations_id = '';
                this.newRegisterDialog = true;
            },

            handleClose(done) {
                this.$confirm('¿Seguro que quieres cerrar este cuadro?')
                    .then(_ => {
                        done();
                        this.getSubrights();
                    })
                    .catch(_ => {});
            },
            disableRegister(id) {
                this.startLoading();

                let data ={id: id, cat: 11};

                axios.post('/api/cats/disable-register', data).then(response => {
                    this.$notify({
                        type: "success",
                        message: "El registro se eliminó con éxito."
                    });

                    this.getSubrights();
                    this.removeDialog = false;
                    this.removeHash = null;
                }).catch(error => {
                    this.stopLoading();

                    this.$notify({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },

            enableRegister(id) {
                this.startLoading();

                let data ={id: id, cat: 11};

                axios.post('/api/cats/enable-register', data).then(response => {
                    this.$notify({
                        type: "success",
                        message: "El registro se habilito con éxito."
                    });

                    this.getSubrights();
                }).catch(error => {
                    this.stopLoading();

                    this.$notify({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },
        },
    }
</script>
