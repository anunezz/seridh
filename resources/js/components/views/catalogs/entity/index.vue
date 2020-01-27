<template>
    <div>
        <header-section icon="el-icon-document" title="Entidad Emisora">
            <template slot="buttons">
                <el-col :span="5" :offset="7">
                    <el-button type="success" @click="newEntity" style="width: 100%">
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
                    :data="entities"
                    size="mini"
                    border
                    style="width: 100%">
                    <el-table-column
                        prop="acronym"
                        label="Siglas">
                    </el-table-column>
                    <el-table-column
                        prop="name"
                        label="Nombre de la Entidad Emisora">
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
            <el-input v-if="newRegisterDialog"
                      placeholder="Nombre de la Entidad Emisora"
                      v-model="newRegisterName"
                      maxlength="100"
                      clearable>
            </el-input>
            <p></p>
            <br>
            <el-form ref="tabform" :model="tabform" label-width="120px" label-position="top" >
                <el-form-item prop="newRegisterAcronym"
                              :rules="[ {  required: true, message: 'Este campo es requerido', trigger: 'blur',} ,
                           {  type: 'string', required: false, pattern: /^[A-Z]+$/, message: 'el acronimo debe llevar solo letras mayusculas', trigger: 'change'}
                                  ]">
                    <el-input v-if="newRegisterDialog" placeholder="Siglas" v-model="tabform.newRegisterAcronym" maxlength="15" clearable></el-input>
                </el-form-item>
            </el-form>

            <span slot="footer" class="dialog-footer">
            <el-button type="danger" @click="newRegisterDialog = false">Cancelar</el-button>
            <el-button v-if="newRegisterDialog"
                       type="primary"
                       :disabled=" newRegisterName  === ''"
                       @click="newRegister">Aceptar</el-button>
            </span>
        </el-dialog>


        <el-dialog title="Editar Registro"
                   :visible.sync="editRegisterDialog"
                   width="70%" :before-close="handleClose">
            <el-input
                v-if="editRegisterDialog"
                placeholder="Tipo de Información"
                v-model="entities[indexRegister].name"
                maxlength="100"
                clearable>
            </el-input>
            <el-input
                v-if="editRegisterDialog && ! entities[indexRegister].is_used"
                placeholder="País"
                v-model="entities[indexRegister].acronym"
                maxlength="100"
                clearable>
            </el-input>
            <span slot="footer" class="dialog-footer">
            <el-button type="danger" @click="getEntities(),editRegisterDialog = false">Cancelar</el-button>
            <el-button v-if="editRegisterDialog"
                       type="primary"
                       :disabled="entities[indexRegister].name && entities[indexRegister].acronym === ''"
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

                entities: [],

                search: '',

                pagination: {
                    currentPage: 1,
                    total: 0,
                    perPage: 10
                },

                newRegisterDialog: false,
                newRegisterName: '',
             //   newRegisterAcronym: '',

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

                tabform: {
                    newRegisterAcronym: '',
                },
            }
        },

        created() {

            this.getEntities();
        },

        methods: {

            getEntities(currentPage = 1) {
                this.startLoading();

                let data = {
                    params: {
                        page: currentPage,
                        perPage: this.pagination.perPage,
                        search: this.search,
                        cat: 1
                    }
                };

                axios.get('/api/cats/get/catalogos', data).then(response => {

                    if (response.data.success) {

                        this.entities = response.data.entity.data;
                        this.pagination.total = response.data.entity.total;
                        this.pagination.currentPage = response.data.entity.current_page;
                        this.pagination.perPage = response.data.entity.per_page;

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
                this.getEntities(currentPage)
            },

            handleSizeChange(sizePerPage) {
                this.pagination.perPage = sizePerPage;
                this.getEntities();
            },

            newRegister() {
                this.startLoading();

                this.$refs['tabform'].validate((valid) => {
                    if (valid) {

                        let data = {cat: 1, name: this.newRegisterName, acronym: this.tabform.newRegisterAcronym};

                        axios.post('/api/cats/new-register', data).then(response => {

                            if (response.data.success) {
                                this.$notify({
                                    type: "success",
                                    message: "El registro se creó con éxito."
                                });

                                this.newRegisterName = '';
                                this.tabform.newRegisterAcronym = null;
                                this.newRegisterDialog = false;
                                this.getEntities();

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
                    } else {
                        this.stopLoading();

                        this.$message({
                            type: "warning",
                            title: 'Error',
                            message: "Complete los campos para continuar"
                        });
                    }
                });
            },

            openEditDialog(index, id, name, acronym) {
                this.indexRegister = index;
                this.hashRegister = id;
                this.nameRegister = name;
                this.acronymRegister = acronym;

                let data = {cat_transaction_type_id: 1, action: 'Editar Catálogo de Entidades Emisoras'};

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
                    cat: 1,
                    name: this.entities[this.indexRegister].name,
                    acronym: this.entities[this.indexRegister].acronym
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
                        this.getEntities();
                    } else {
                        this.entities[this.indexRegister].name = this.nameRegister;
                        this.entities[this.indexRegister].acronym = this.acronymRegister;

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
                this.entities[this.indexRegister].name = value.replace(/[#$%&?|+=*!<>"';()/{}[\]\\]/g, "");
            },

            onAcronymChanged(value){
                this.entities[this.indexRegister].acronym = value.replace(/[#$%&?|+=*!<>"';()/{}[\]\\]/g, "");
            },

            disableDialog(id) {
                this.removeDialog = true;
                //this.publicDialog = true;
                this.removeHash = id;
            },

            disableRegister(id) {
                this.startLoading();

                let data ={id: id, cat: 1};

                axios.post('/api/cats/disable-register', data).then(response => {
                    this.$notify({
                        type: "success",
                        message: "El registro se eliminó con éxito."
                    });

                    this.getEntities();
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
            newEntity(){
                console.log('nueva entidad');
                this.newRegisterName = '';
                this.tabform.newRegisterAcronym='';
                this.newRegisterDialog = true
            },

            handleClose(done) {
                this.$confirm('¿Seguro que quieres cerrar este cuadro?')
                    .then(_ => {
                        done();
                        this.getEntities();
                    })
                    .catch(_ => {});
            }
        },
    }
</script>
