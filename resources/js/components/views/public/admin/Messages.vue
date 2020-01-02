<template>
    <div>
        <!--<img class="card-img-bottom" src="/img/public/messages/dgdh.jpg"
             style="height: 80px; width: 80px;" alt="">
        <pre>{{messages.path_dgdhd}}</pre>-->
        <el-row class="showMessages">
            <el-form  ref="messages" :model="messages" label-width="120px" label-position="top">
                <el-row style="margin-bottom: 50px">
                    <el-row>
                        <el-col :span="20">
                            <h3><span style="color: red">*</span>¿Qué es SERIDH?</h3>
                        </el-col>
                        <el-col :span="4">
                            <el-switch
                                style="display: block"
                                v-model="messages.activeSeridh"
                                active-color="#13ce66"
                                active-text="Activo">
                            </el-switch>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-form-item prop="seridh" :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                            <el-input  type="textarea" :rows="5" placeholder="Escribe un mensaje" v-model="messages.seridh"></el-input>
                        </el-form-item>
                    </el-row>
                </el-row>
                <el-divider/>
                <el-row :gutter="20" style="margin-bottom: 50px">
                    <el-col :xs="24" :sm="16" :md="16" :lg="16" :xl="16">
                        <el-row>
                            <el-col :span="20">
                                <h3><span style="color: red">*</span>Mensaje de la Subsecretaria</h3>
                            </el-col>
                            <el-col :span="4">
                                <el-switch
                                    v-model="messages.activeUndersecretary"
                                    active-color="#13ce66"
                                    active-text="Activo">
                                </el-switch>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-form-item prop="undersecretary" :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                                <el-input  type="textarea" :rows="5" placeholder="Escribe un mensaje" v-model="messages.undersecretary"></el-input>
                            </el-form-item>
                        </el-row>
                    </el-col>
                    <el-col :xs="24" :sm="8" :md="8" :lg="8" :xl="8" style="padding: 10px">
                        <el-form-item prop="path_undersecretary" :rules="[
                                    { required: true, message: 'Debe cargar una imagen', trigger: 'blur'},
                                  ]">
                            <el-upload
                                class="upload-demo"
                                :limit="1"
                                name="document"
                                action="/api/recommendations/updateImg/file"
                                :before-upload="beforeUploadFile"
                                accept=".jpg, .png, .jpeg"
                                :data="{undersecretary:true}"
                                :headers="{'Authorization': apiToken}"
                                :on-success="fileSuccess"
                                :on-remove="fileRemove"
                                :file-list="messages.path_undersecretary"
                                list-type="picture">
                                <span v-if="showSecre===false">Imagen actual</span>
                                <el-button size="small" type="primary" v-if="showSecre">Clic para subir imagen</el-button>
                                <div slot="tip" class="el-upload__tip" v-if="showSecre">Solo archivos jpg/png con un tamaño menor de 500kb</div>
                            </el-upload>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-divider/>
                <el-row :gutter="20">
                    <el-col :xs="24" :sm="16" :md="16" :lg="16" :xl="16">
                        <el-row>
                            <el-col :span="20">
                                <h3><span style="color: red">*</span>Mensaje de la DGDHD</h3>
                            </el-col>
                            <el-col :span="4">
                                <el-switch
                                    v-model="messages.activeDgdhd"
                                    active-color="#13ce66"
                                    active-text="Activo">
                                </el-switch>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-form-item prop="dgdhd" :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                                <el-input  type="textarea" :rows="5" placeholder="Escribe un mensaje" v-model="messages.dgdhd"></el-input>
                            </el-form-item>
                        </el-row>
                    </el-col>
                    <el-col :xs="24" :sm="8" :md="8" :lg="8" :xl="8" style="padding: 35px">
                        <el-form-item prop="path_dgdhd" :rules="[
                                    { required: true, message: 'Debe cargar una imagen', trigger: 'blur'},
                                  ]">
                            <el-upload
                                ref="dgdhd"
                                :limit="1"
                                name="document"
                                action="/api/recommendations/updateImg/file"
                                :before-upload="beforeUploadFile"
                                accept=".jpg, .png, .jpeg"
                                :headers="{'Authorization': apiToken}"
                                :on-success="fileSuccess"
                                :on-remove="fileRemove"
                                :file-list="messages.path_dgdhd"
                                list-type="picture">
                                <span v-if="showDgdhd===false">Imagen actual</span>
                                <el-button size="small" type="primary" v-if="showDgdhd">Clic para subir imagen</el-button>
                                <div slot="tip" class="el-upload__tip" v-if="showDgdhd">Solo archivos jpg/png con un tamaño menor de 500kb</div>
                            </el-upload>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row type="flex" class="row-bg" justify="end">
                    <el-col :span="2.5">
                        <el-button type="primary" @click="submitForm">Guardar</el-button>
                    </el-col>
                </el-row>
            </el-form>
        </el-row>

    </div>
</template>

<script>
    export default {
        data(){
            return{
                showDgdhd:true,
                showSecre:true,
                messages:{},
                apiToken: 'Bearer ' + sessionStorage.getItem('SERIDH_token'),
            }
        },
        created() {
            this.getData();
        },
        methods: {
            getData(){
                let $this = this;
                axios.get('/api/recommendations/adminPublic').then(response => {
                    this.messages = response.data.dataPublic;

                    if (response.data.path_undersecretary!==null){
                        this.messages.path_undersecretary.push({url:response.data.path_undersecretary});
                        $this.showSecre = false;
                    }

                    if (response.data.path_dgdhd!==null){
                        this.messages.path_dgdhd.push({url:response.data.path_dgdhd});
                        $this.showDgdhd = false;
                    }
                }).catch(error => {
                    this.$notify.error({
                        title: 'Error',
                        message: 'No se pudo completar la acción getData.'
                    });
                });
            },
            submitForm() {
                this.$refs['messages'].validate((valid) => {
                    if(valid){
                        this.messages.type=2;
                        axios.post('/api/recommendations/saveMessages', this.messages).then(response => {
                            this.getData();
                            this.$notify({
                                type: "success",
                                message: "Se actualizo la información correctamente"
                            });
                        }).catch(error => {
                            this.$message({
                                type: "warning",
                                message: "No fue posible completar la acción, intente nuevamente."
                            });
                        });
                    }else{
                        this.$message({
                            type: "warning",
                            title: 'Error',
                            message: "Complete los campos para continuar"
                        });
                    }
                });
            },
            fileRemove(file, fileList) {
                /*this.messages.path_dgdhd = [];
                this.messages.path_undersecretary = [];*/
                let params = {
                    url:file.url,
                };

                axios.post('/api/recommendations/deleteImg/file', params).then(response => {
                    this.getData();
                }).catch(error => {
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
                console.log(file.url);
                this.showDgdhd = true;
                this.showSecre = true;
                console.log(file, fileList);
            },
            fileSuccess(response, file,fileList) {
                this.getData();
                /*this.showDgdhd = false;
                console.log(file);*/
            },
            beforeUploadFile(file) {
                if (file.size/1024/1024 > 6) {
                    this.$message.error('El archivo seleccionado excede el limite permitido');
                    return false;
                }

                if (file.type !== 'image/jpeg' && file.type !== 'image/jpg' && file.type !== 'image/png') {
                    this.$message.error('Tipo de Archivo no permitido');
                    return false;
                }
                return true;
            },
        }
    }
</script>

<style scoped>
    .showMessages{
        border: 1px solid #DCDFE6;
        padding: 20px;
        border-radius: 5px;
    }
</style>
