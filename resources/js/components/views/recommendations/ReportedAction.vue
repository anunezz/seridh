<template>
    <div>
        <el-dialog
            title="Información de acción reportada"
            :visible.sync="items.checked"
            width="85%"
            @close="close">
            <el-row v-if="items.invoice!=null" type="flex" class="row-bg" justify="end">
                <strong class="folio"><b>Folio: {{items.invoice}}</b></strong>
            </el-row>
            <el-form  ref="reportedAction" :model="items" label-width="120px" label-position="top">
            <el-row :gutter="20" style="margin-top: 50px">
                <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
                    <el-form-item label="Fecha de reporte" prop="date" :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-date-picker
                            v-model="items.date"
                            type="date"
                            placeholder="Seleccione fecha"
                            format="yyyy/MM/dd"
                            value-format="yyyy-MM-dd"
                            style="width: 100%">
                        </el-date-picker>
                    </el-form-item>
                </el-col>
                <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
                    <el-form-item label="Tipo de acción reportada" prop="cat_solidarity_action_id" :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-select
                            v-model="items.cat_solidarity_action_id"
                            filterable
                            multiple
                            placeholder="Seleccionar"
                            style="width: 100%">
                            <el-option
                                v-for="(action, index) in actions"
                                :key="index"
                                :label="action.name"
                                :value="action.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
                    <el-form-item label="Población beneficiaria" prop="cat_population_id" :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-select
                            v-model="items.cat_population_id"
                            filterable
                            multiple
                            placeholder="Seleccionar"
                            style="width: 203%">
                            <el-option
                                v-for="(population, index) in populations"
                                :key="index"
                                :label="population.name"
                                :value="population.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>
            </el-row>
f
                <el-row :gutter="20">
                <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
                    <el-form-item label="Autoridad encargada de atender" prop="cat_attendig_id" :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <el-select
                            v-model="items.cat_attendig_id"
                            filterable
                            multiple
                            placeholder="Seleccionar"
                            style="width: 203%">
                            <el-option
                                v-for="(attending, index) in attendings"
                                :key="index"
                                :label="attending.name"
                                :value="attending.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-row :gutter="10">
                <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                    <el-form-item label="Descripción" prop="description" :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                        <tinymce id="reportada" :other_options="tinyOptions" v-model="items.description"/>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-row type="flex" class="row-bg" justify="end">
                <el-button type="primary" v-if="items.action!==1" @click="add">Actualizar</el-button>
                <el-button type="primary" v-if="items.action===1" @click="add">Agregar</el-button>
                <el-button type="danger" @click="items.checked=!items.checked">Cancelar</el-button>
            </el-row>
        </el-form>
        </el-dialog>
    </div>
</template>

<script>
    export default {
        props:['items','typeAction'],
        data(){
            return{
                actions: [],
                populations: [],
                attendings: [],
                tinyOptions: {
                    language_url: '/js/tiny_es_MX.js',
                    indent_use_margin: true,
                    forced_root_block_attrs: {
                        "style": "font-family: Montserrat;font-size:14px;font-style: normal;font-weight: normal"
                    },
                    menubar: '',
                    statusbar: false,
                    branding: false,
                    min_height: 150,
                    browser_spellcheck: true,
                    font_formats: 'Montserrat=Montserrat;Soberana Sans=Soberana Sans;Arial=arial,helvetica,sans-serif;Times New Roman=Times New Roman, Times, serif;',
                    setup: function (ed) {
                        ed.settings.paste_postprocess = function (pl, o) {
                            ed.dom.setAttrib(ed.dom.select('li', o.node), 'style', 'font-family: Montserrat;font-size:14px;font-style: normal;font-weight: normal');
                            ed.dom.setAttrib(ed.dom.select('p', o.node), 'style', 'font-family: Montserrat;font-size:14px;font-style: normal;font-weight: normal');
                        }
                    },
                    paste_as_text: true,
                    paste_text_sticky: true,
                    paste_text_sticky_default: true,
                    toolbar1: 'bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent  ',
                    toolbar2: "",
                    plugins: [
                        'paste'
                    ]
                },
            }
        },
        created() {
            axios.get('/api/recommendations/create').then(response => {
                this.attendings = response.data.attendings;
                this.populations = response.data.populations;
                this.actions = response.data.actions;

            }).catch(error => {
                this.$message({
                    type: "warning",
                    message: "No fue posible completar la acción, intente nuevamente."
                });
            });
        },
        mounted() {
            if (this.typeAction===2){
                this.items.checked = false;
            }
        },
        methods:{
            close(){
                if (this.typeAction!==2) {
                    this.$refs['reportedAction'].resetFields();
                }
            },
            add(data){
                this.$refs['reportedAction'].validate((valid) => {
                    if(valid){
                        if (data){
                            this.$emit('addReport');
                             this.items.checked = false;
                        }else {
                            this.$emit('addReport');
                            this.items.checked = false;
                        }

                    }else{
                        this.$message({
                            type: "warning",
                            title: 'Error',
                            message: "Complete los campos para continuar"
                        });
                    }
                });
            }
        },
    }
</script>

<style scoped>
    .folio {
        box-shadow: 5px 5px 5px #566573 ;
        padding: 10px;
        background: #F8F9F9;
    }
</style>
