<template>
    <div>
        <header-section icon="el-icon-document" title="Derechos Nivel 3">
            <template slot="buttons">
                <el-col :span="5" :offset="7">
                    <el-button type="success" @click="newRightIII" style="width: 100%">
                        Nuevo registro
                    </el-button>
                </el-col>
                <el-col :span="10" :offset="1">
                    <el-input
                        clearable
                        suffix-icon="fas fa-search"
                        placeholder="Buscar por derechos nivel 2 y nivel 3"
                        v-model="search"
                        @change="getSubcategory(search)">
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
                    :data="subcategory"
                    size="mini"
                    border
                    style="width: 100%">
                    <el-table-column
                        prop="sub_right.name"
                        label="Derechos Nivel 2">
                    </el-table-column>
                    <el-table-column
                        prop="name"
                        label="Derechos Nivel 3">
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
                                        @click="openEditDialog(scope.$index, scope.row.hash, scope.row.name, scope.row.sub_rights_id)">
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
                placeholder="Nombre del Derecho de Nivel 3"
                v-model="newRegisterName"
                maxlength="100"
                clearable>
            </el-input>
            <el-form ref="newRegisterAcronym" :model="newRegisterAcronym" label-position="top" >
            <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                <el-form-item label="Derechos Nivel 2"
                              prop="sub_rights_id"
                              :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                    <el-select
                        v-model="newRegisterAcronym.sub_rights_id"
                        filterable
                        placeholder="Seleccionar"
                        clearable
                        style="width: 100%">
                        <el-option
                            v-for="(subright, index) in subrig"
                            :key="index"
                            :label="subright.name"
                            :value="subright.id">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-col>
            </el-form>
            <span slot="footer" class="dialog-footer">
            <el-button type="danger" @click="newRegisterDialog = false">Cancelar</el-button>
            <el-button v-if="newRegisterDialog"
                       type="primary"
                       :disabled="newRegisterName === ''|| newRegisterAcronym.sub_rights_id.length===0"
                       @click="newRegister">Aceptar</el-button>
            </span>
        </el-dialog>

        <el-dialog title="Editar Registro Derechos de Nivel 3"
                   :visible.sync="editRegisterDialog"
                   width="70%" :before-close="handleClose">
            <el-input
                v-if="editRegisterDialog"
                placeholder="Nombre del Derecho de Nivel 3"
                v-model="subcategory[indexRegister].name"
                maxlength="100"
                clearable>
            </el-input>
            <br><br>
            <h4>Derechos Nivel 2</h4>
            <el-select v-if="editRegisterDialog"
                       :disabled="subcategory[indexRegister].is_used && subcategory[indexRegister].isActive"
                       v-model="subcategory[indexRegister].sub_rights_id"
                       filterable placeholder="Seleccionar"
                       style="width: 100%">
                <el-option
                    v-for="(subright , index) in subrig"
                    :key="index"
                    :label="subright.name"
                    :value="subright.id">
                </el-option>
            </el-select>

            <span slot="footer" class="dialog-footer">
            <el-button type="danger" @click="getSubcategory(),editRegisterDialog = false">Cancelar</el-button>
            <el-button v-if="editRegisterDialog"
                       type="primary"
                       :disabled="subcategory[indexRegister].name === ''"
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
                subcategory: [],
                subrig: [],


                search: '',

                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10
                },

                newRegisterDialog: false,
                newRegisterName: '',
                newRegisterAcronym: {
                    sub_rights_id: [],
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

            this.getSubcategory();
            this.startLoading();
            axios.get('/api/recommendations/create').then(response => {

                this.subrig = response.data.subrig;

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

            getSubcategory(currentPage = 1) {
                this.startLoading();

                let data = {
                    params: {
                        page: currentPage,
                        perPage: this.pagination.perPage,
                        search: this.search,
                        cat: 12
                    }
                };

                axios.get('/api/cats/get/catalogos', data).then(response => {

                    if (response.data.success) {


                        this.subrights = response.data.elements.data;
                        this.subcategory = response.data.elements.data;
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
                this.getSubcategory(currentPage)
            },

            handleSizeChange(sizePerPage) {
                this.pagination.perPage = sizePerPage;
                this.getSubcategory();
            },

            newRegister() {
                this.startLoading();

                let data = {cat: 12, name: this.newRegisterName, sub_rights_id: this.newRegisterAcronym.sub_rights_id};

                axios.post('/api/cats/new-register', data).then(response => {

                    if (response.data.success) {
                        this.$notify({
                            type: "success",
                            message: "El registro se creó con éxito."
                        });

                        this.newRegisterName = '';
                        this.newRegisterAcronym.sub_rights_id = null;
                        this.newRegisterDialog = false;
                        this.getSubcategory();
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

                let data = {cat_transaction_type_id: 1, action: 'Editar Catálogo de SubCategory'};

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

                let data = {
                    id: this.hashRegister,
                    cat: 12,
                    name: this.subcategory[this.indexRegister].name,
                    sub_rights_id: this.subcategory[this.indexRegister].sub_rights_id
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
                        this.getSubcategory();
                    } else {
                        this.subcategory[this.indexRegister].name = this.nameRegister;
                        this.subcategory[this.indexRegister].sub_rights_id = this.acronymRegister;

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
                this.subcategory[this.indexRegister].name = value.replace(/[#$%&?|+=*!<>"';()/{}[\]\\]/g, "");
            },

            onAcronymChanged(value){
                this.subcategory[this.indexRegister].sub_rights_id = value.replace(/[#$%&?|+=*!<>"';()/{}[\]\\]/g, "");
            },

            disableDialog(id) {
                this.removeDialog = true;
                //this.publicDialog = true;
                this.removeHash = id;
            },

            disableSubRights(id) {
                this.startLoading();

                axios.delete(`/api/cats/remove/subcategory/${id}`, {responseType: 'blob'}).then(response => {
                    this.stopLoading();
                    this.getSubcategory();
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
            newRightIII(){
                this.newRegisterName = '';
                this.newRegisterAcronym.sub_rights_id = '';
                this.newRegisterDialog = true;
            },

            handleClose(done) {
                this.$confirm('¿Seguro que quieres cerrar este cuadro?')
                    .then(_ => {
                        done();
                        this.getSubcategory();
                    })
                    .catch(_ => {});
            },

            disableRegister(id) {
                this.startLoading();

                let data ={id: id, cat: 12};

                axios.post('/api/cats/disable-register', data).then(response => {
                    this.$notify({
                        type: "success",
                        message: "El registro se eliminó con éxito."
                    });

                    this.getSubcategory();
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

                let data ={id: id, cat: 12};

                axios.post('/api/cats/enable-register', data).then(response => {
                    this.$notify({
                        type: "success",
                        message: "El registro se habilito con éxito."
                    });

                    this.getSubcategory();
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
