<template>
    <div>
        <header-section icon="el-icon-document" title="Autoridad encargada de atender">
            <template slot="buttons">

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
                    <el-card class="box-card">

                        <div  class="text item" :body-style="{ width: '100%' }" style="float:right; padding: 0px 0px 20px 0px;">
                            <el-tooltip class="item" effect="dark" content="Nuevo" placement="top-start">
                                <el-button type="primary"
                                        size="mini"
                                        icon="el-icon-plus"
                                        @click="newAutority"
                                        style="padding-button: 10px;">
                                        Nuevo
                                </el-button>
                            </el-tooltip>
                        </div>

                        <!-- <div style="margin-top: 15px;">
                        <el-input placeholder="Buscar por Autoridad encargada de atender" v-model="advancedText" class="input-with-select" clearable>
                            <el-select v-model="advancedSelect" slot="prepend" placeholder="Búsqueda avanzada" style="width: 200px;">
                                <el-option label="Mostrar Todo" value="all"></el-option>
                                <el-option label="Siglas" value="acronym"></el-option>
                                <el-option label="Nombre" value="name"></el-option>
                            </el-select>
                            <el-button slot="append" icon="el-icon-search" @click="advancedSearch(advancedSelect,advancedText)"></el-button>
                        </el-input>
                        </div> -->

                    </el-card>
                </el-col>
            <el-col :span="24">
                <el-table
                    :data="attendings"
                    size="mini"
                    border
                    style="width: 100%">
                    <el-table-column
                        prop="acronym"
                        label="Siglas">
                    </el-table-column>
                    <el-table-column
                        prop="name"
                        label="Nombre de la Autoridad encargada de atender">
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
                                        @click="openEditDialog(scope.$index, scope.row.hash, scope.row.name, scope.row.acronym)">
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
             <el-row :gutter="20">
                 <el-col :span="24">
                    <el-input
                        v-if="newRegisterDialog"
                        placeholder="Nombre de la Autoridad"
                        v-model="newRegisterName"
                        maxlength="100"
                        clearable>
                    </el-input>
                    <div style="margin: 20px 0;"></div>
                 </el-col>

                 <el-col :span="24">
                    <el-input
                        v-if="newRegisterDialog"
                        placeholder="Siglas"
                        v-model="newRegisterAcronym"
                        maxlength="100"
                        clearable>
                    </el-input>
                  </el-col>
                </el-row>

                <span slot="footer" class="dialog-footer">
                    <el-button type="danger" @click="newRegisterDialog = false">Cancelar</el-button>
                    <el-button v-if="newRegisterDialog"
                            type="primary"
                            :disabled="newRegisterName === '' || newRegisterAcronym==='' "
                            @click="newRegister">Aceptar</el-button>
                </span>

        </el-dialog>

        <el-dialog title="Editar Registro"
                   :visible.sync="editRegisterDialog"
                   width="70%"
                   :before-close="handleClose">
            <el-input
                v-if="editRegisterDialog"
                placeholder="Nombre de la Autoridad"
                v-model="attendings[indexRegister].name"
                maxlength="100"
                clearable>
            </el-input>
            <el-input
                v-if="editRegisterDialog && ! attendings[indexRegister].is_used"
                placeholder="País"
                v-model="attendings[indexRegister].acronym"
                maxlength="100"
                clearable>
            </el-input>
            <span slot="footer" class="dialog-footer">
            <el-button type="danger" @click="getAttendings(),editRegisterDialog = false">Cancelar</el-button>
            <el-button v-if="editRegisterDialog"
                       type="primary"
                       :disabled="attendings[indexRegister].name === ''"
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
                <el-button type="success" @click="disableAuthority(removeHash)">Aceptar</el-button>
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

                attendings: [],

                search: '',

                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10
                },

                newRegisterDialog: false,
                newRegisterName: '',
                newRegisterAcronym: null,

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

                advancedSelect:'',
                advancedText:'',

                apiToken: 'Bearer ' + sessionStorage.getItem('SERIDH_token'),
            }
        },

        created() {
            this.getAttendings();
        },


        methods: {
            advancedSearch(action,search,currentPage = 1){
              let me = this;

                me.startLoading();
                let data = {
                        page: currentPage,
                        perPage: me.pagination.perPage,
                        data: {action: action, search: search.trim(),name: 'authorityAttending'}
                };

                if(action === 'all'){
                   me.advancedText = '';
                }
                console.log("Busqueda por accion: ",action);
                console.log("Busqueda por busqueda ",search);

                axios.post('/api/cats/searchCats', data).then(response => {
                    if (response.data.success) {
                      console.log("Response catalogos: ",response);
                        me.attendings = response.data.lResults.data;
                        me.pagination.total = response.data.lResults.total;
                        me.pagination.currentPage = response.data.lResults.current_page;
                        me.pagination.currentPage = response.data.lResults.current_page;
                        me.pagination.perPage = response.data.lResults.per_page;
                        me.stopLoading();
                    }
                }).catch(error => {
                    me.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },
            getAttendings(currentPage = 1) {
                this.startLoading();

                let data = {
                    params: {
                        page: currentPage,
                        perPage: this.pagination.perPage,
                        search: this.search
                    }
                };

                axios.get('/api/cats/get/catalogos', data).then(response => {

                    if (response.data.success) {

                        this.attendings = response.data.attendig.data;
                        this.pagination.total = response.data.attendig.total;
                        this.pagination.currentPage = response.data.attendig.current_page;
                        this.pagination.perPage = response.data.attendig.per_page;

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
                if(this.advancedSelect.length > 0){
                  this.advancedSearch(this.advancedSelect,this.advancedText);
                  return;
                }

                this.getAttendings(currentPage)
            },

            handleSizeChange(sizePerPage) {
                this.pagination.perPage = sizePerPage;
                if(this.advancedSelect.length > 0){
                  this.advancedSearch(this.advancedSelect,this.advancedText);
                  return;
                }

                this.getAttendings();
            },

            newRegister() {
                this.startLoading();

                let data = {cat: 4, name: this.newRegisterName, acronym: this.newRegisterAcronym};

                axios.post('/api/cats/new-register', data).then(response => {

                    if (response.data.success) {
                        this.$notify({
                            type: "success",
                            message: "El registro se creó con éxito."
                        });

                        this.newRegisterName = '';
                        this.newRegisterAcronym = null;
                        this.newRegisterDialog = false;
                        this.getAttendings();
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

                let data = {cat_transaction_type_id: 1, action: 'Editar Catálogo de Autoridad encargada de atender'};

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
                    cat: 4,
                    name: this.attendings[this.indexRegister].name,
                    acronym: this.attendings[this.indexRegister].acronym
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
                        this.getAttendings();
                    } else {
                        this.attendings[this.indexRegister].name = this.nameRegister;
                        this.attendings[this.indexRegister].acronym = this.acronymRegister;

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
                this.attendings[this.indexRegister].name = value.replace(/[#$%&?|+=*!<>"';()/{}[\]\\]/g, "");
            },

            onAcronymChanged(value){
                this.attendings[this.indexRegister].acronym = value.replace(/[#$%&?|+=*!<>"';()/{}[\]\\]/g, "");
            },

            disableDialog(id) {
                this.removeDialog = true;
                //this.publicDialog = true;
                this.removeHash = id;
            },

            disableAuthority(id) {
                this.startLoading();

                axios.delete(`/api/cats/remove/attendig/${id}`, {responseType: 'blob'}).then(response => {
                    this.stopLoading();
                    this.getAttendings();
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
            newAutority(){
                this.newRegisterName = '';
                this.newRegisterAcronym = '';
                this.newRegisterDialog = true;
            },
            handleClose(done) {
                this.$confirm('¿Seguro que quieres cerrar este cuadro?')
                    .then(_ => {
                        done();
                        this.getAttendings();
                    })
                    .catch(_ => {});
            }
        },
    }
</script>
