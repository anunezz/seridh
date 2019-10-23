<template>
<div>

    <div style="margin-bottom: 20px;">

        <h5>Módulo para la edición de multilenguaje SERIDH.</h5>

    </div>
        <el-form ref="tabform" :model="tabform" label-width="120px" label-position="top" >
            <el-form-item label="Crear nuevo idioma"
                          prop="newTabName"
                          :rules="[ { type: 'string', required: false, pattern: /^[a-z]+$/, message: 'el acronimo debe llevar letras minusculas', trigger: 'change'}
                                  ]">
                <el-input size="small" style="width : 270px" maxlength="2" show-word-limit placeholder="Escribe el Acronimo del idioma" v-model="tabform.newTabName" ></el-input>
            </el-form-item>
            <el-form-item>
                <el-button
                    size="small"
                    @click="addTab(tabform.newTabName)"
                >
                    añadir tab
                </el-button>
            </el-form-item>
        </el-form>


    <el-tabs type="border-card" v-model="activeName" @tab-click="getLang(activeName)">
        <el-tab-pane v-for="(lang, index) in langs" :key="index" :label="lang.acronym" :name="lang.acronym" @click="active=lang.acronym" >
            <v-jsoneditor v-model="data" :options="options" height="400px"></v-jsoneditor>

            <el-row :gutter="10">
                <el-col :span="3" >
                    <el-button type="success" style="width: 100%" @click="submitForm(lang.acronym)">Guardar</el-button>
                </el-col>
                <el-col :span="3" >
                    <el-button type="primary" style="width: 100%" @click="rollback()">Recuperar Anterior</el-button>
                </el-col>
            </el-row>
        </el-tab-pane>
    </el-tabs>

</div>
</template>

<script>

    export default {
        data() {
            return {
                data: {},
                newTabName: '',
                langs: [],
                tabIndex: 0,
                activeName: 'es',

                tabform: {
                    newTabName: ''
                },



                options: {
                    mode: "code",
                    onEditable: function(node) {
                        //console.log("node", node);
                        return true;
                    }
                }
            }
        },

        created() {
            axios.get('/api/get-langs').then(response => {
                this.langs = response.data.langs;
                this.tabIndex = this.langs.length;
                this.getLang('es');
            }).catch(err => {
                console.log(err);
            });
        },


        methods:
        {
            getLang(value) {
               this.value = value;

               axios.get("/api/get-lang/" + value).then(response => {
                   this.data = response.data;
               }).catch(err => {
                   console.log(err);
               });
        },

            submitForm(acronym) {
                this.startLoading();4

                let data = {
                    'acronym': acronym,
                    'data': this.data
                }

                        axios
                            .post('/api/lang/store', data).then(response => {
                            this.stopLoading();

                            this.$message({
                                type: "success",
                                title: 'Éxito',
                                message: "Se almaceno la información correctamente"
                            });

                        }).catch(error => {
                            this.stopLoading();

                            this.$message({
                                type: "warning",
                                message: "No fue posible completar la acción, intente nuevamente."
                            });
                        })
                    },

            getPlus(value) {
                this.value = value;
                this.data = {};
            },

            addTab(tabName) {
                this.$refs['tabform'].validate((valid) => {
                    if (valid) {

                        let newTabName = ++this.tabIndex + '';
                        this.langs.push({
                            acronym: tabName
                        });

                        this.newTabName = '';

                    }

                    else {
                        this.stopLoading();

                        this.$message({
                            type: "warning",
                            title: 'Error',
                            message: "Complete los campos para continuar"
                        });
                    }
                });



            },

            removeTab(targetName) {
                let tabs = this.langs;
                let activeName = this.activeName;
                if (activeName === targetName) {
                    tabs.forEach((tab, index) => {
                        if (tab.name === targetName) {
                            let nextTab = tabs[index + 1] || tabs[index - 1];
                            if (nextTab) {
                                activeName = nextTab.name;
                            }
                        }
                    });
                }

                this.activeName = activeName;
                this.langs = tabs.filter(tab => tab.name !== targetName);
            },

            rollback() {

            },

            }

        }

</script>

<style scoped>

</style>
