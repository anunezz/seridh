<template>
   <!-- https://github.com/wlada/vue-carousel-3d#usage -->
   <div>
       <el-row class="showimages">
           <el-divider content-position="left">Vista previa de aliados</el-divider>
           <el-row :gutter="20" type="flex" class="row-bg" justify="center" v-if="alliesImages.length<5">
               <el-col :xs="24" :sm="5" :md="5" :lg="5" :xl="5" v-for="(ally,index) in alliesImages" :key="index" style="height: 285px;border: 1px solid #DCDFE6; padding: 1px;margin: 20px">
                   <img :src="ally.allies" style="width: 100% !important; height: 100px;background: #2769c6">
                   <el-row style="padding:5px;text-align: center;height: 140px;">
                       <strong><b>
                           <h5 style="margin: 0px">
                               {{ally.text}}
                           </h5>
                       </b></strong>

                   </el-row>
                   <el-row style="text-align: center;margin-bottom: 10px">
                       <el-col :offset="4">
                           <el-link :href="ally.link" :underline="false" target="_blank" style="background: #9D2449;border-radius: 3px;color: #fff;padding: 3px;">
                               Ir al enlace
                           </el-link>
                           <el-button-group style="margin-left: 8px">
                               <el-tooltip class="item" effect="dark" content="Editar aliado" placement="bottom">
                                   <el-button type="primary" size="mini" icon="el-icon-edit" circle @click="editAlly(ally,index)"/>
                               </el-tooltip>
                               <el-tooltip class="item" effect="dark" content="Eliminar aliado" placement="bottom">
                                   <el-button type="danger" size="mini" icon="el-icon-delete" circle @click="deleteAlly(ally,index)"> </el-button>
                               </el-tooltip>
                           </el-button-group>
                       </el-col>
                   </el-row>
               </el-col>
           </el-row>
           <el-row v-if="alliesImages.length>4">
                   <div style="width: 80%; margin: 0px 30px 0px 120px;" >
                   <!-- <carousel-3d :height="230" :width="360" :id="carouselId" :autoplay="true" :autoplay-timeout="5000"> -->
                   <carousel-3d border="0"  :height="300" :id="carouselId" :width="360" :autoplay="true" :autoplay-timeout="3500" :disable3d="true" :space="365" :clickable="false" :controls-visible="true">
                       <slide v-for="(ally, index) in alliesImages" :key="index" :index="index" style="background: white">
                           <!--<figure>
                               <img :src="ally.allies" style="width: 100% !important; heigth: 300px;background: #2769c6">
                           </figure>-->
                           <el-row style="padding: 1px">
                               <!--                               <el-row style="background: #2769c6;">-->
                               <img :src="ally.allies" style="width: 100% !important; height: 100px;background: #2769c6">
                               <!--                               </el-row>-->
                               <el-row style="padding:5px;text-align: center;height: 85px;">
                                   <strong><b>
                                       <h5 style="margin: 0px">
                                           {{ally.text}}
                                       </h5>
                                   </b></strong>

                               </el-row>
                               <el-row style="text-align: center;margin-bottom: 8px">
                                   <el-col :offset="4">
                                       <el-link :href="ally.link" :underline="false" target="_blank" style="background: #9D2449;border-radius: 3px;color: #fff;padding: 3px;width: 30%;">
                                           Ir al enlace
                                       </el-link>
                                       <el-button-group style="margin-left: 60px">
                                           <el-tooltip class="item" effect="dark" content="Editar aliado" placement="bottom">
                                               <el-button type="primary" size="mini" icon="el-icon-edit" circle @click="editAlly(ally,index)"/>
                                           </el-tooltip>
                                           <el-tooltip class="item" effect="dark" content="Eliminar aliado" placement="bottom">
                                               <el-button type="danger" size="mini" icon="el-icon-delete" circle @click="deleteAlly(ally,index)"> </el-button>
                                           </el-tooltip>

                                       </el-button-group>
                                   </el-col>
                               </el-row>
                           </el-row>

                       </slide>
                   </carousel-3d>
                 </div>
               </el-row>
           <el-row v-if="alliesImages.length===0" style="text-align: center">
               <h3>No hay ningún aliado</h3>
           </el-row>
           <el-divider content-position="left">Configuración</el-divider>
           <el-row :gutter="20">
               <el-form  ref="allies" :model="formAllies" label-width="120px" label-position="top">
               <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">

                       <el-form-item label="Texto" prop="text" :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                           <el-input placeholder="Escribe algun texto" type="textarea" :rows="4" maxlength="235" show-word-limit v-model="formAllies.text"></el-input>
                       </el-form-item>
                       <el-form-item label="Link" prop="link" :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                           <el-input placeholder="https://www.ejemplo.mx/" v-model="formAllies.link">
                               <el-button slot="append" icon="el-icon-search" @click=" testUrl" :disabled="formAllies.link.length===0"></el-button>
                           </el-input>
                       </el-form-item>

               </el-col>
               <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
                    <h3><span style="margin-left: 50px">Imagen</span></h3>
                   <el-row type="flex" class="row-bg" justify="left">
                       <el-col :span="2" :offset="5">
                           <el-form-item prop="idImage" :rules="[
                                    { required: true, message: 'Este campo es requerido', trigger: 'blur'},
                                  ]">
                               <el-upload
                                   id="ally"
                                   :disabled="enableLoad"
                                   class="avatar-uploader"
                                   action="/api/recommendations/updateImg/file"
                                   name="document"
                                   :headers="{'Authorization': apiToken}"
                                   :data="{allies:true}"
                                   accept=".jpg, .png, .jpeg"
                                   :show-file-list="false"
                                   :on-success="allySuccess"
                                   :before-upload="beforeUploadFile">
                                   <img v-if="imageUrl" :src="imageUrl" class="avatar" style="width: 300px" alt="">
                                   <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                               </el-upload>
                           </el-form-item>
                       </el-col>
                   </el-row>
               </el-col>
               </el-form>
           </el-row>
           <el-row type="flex" class="row-bg" justify="end">
               <el-button type="success" @click="previewSee">Ver vista previa</el-button>
               <el-button type="primary" @click="submitAlly">Guardar</el-button>
           </el-row>
       </el-row>
   </div>
</template>

<script>
    import { Carousel3d, Slide } from 'vue-carousel-3d';
    export default {
         components: {Carousel3d,Slide},
        data(){
            return{
                dialogImageUrl: '',
                dialogVisible: false,
                previewImages:[],
                apiToken: 'Bearer ' + sessionStorage.getItem('SERIDH_token'),
                idsFiles:[],
                idsDelete:[],
                listImages: [],
                alliesImages:{},
                formAllies:{
                    idImage:null,
                    text:'',
                    link:'',
                    allies:''
                },
                imageUrl: '',
                index:null,
                enableLoad:false,
                carouselId:1,
                allDelete:[],
            }
        },

        created(){
            this.getFiles();
        },
        mounted() {

        },
        methods: {

            getFiles(){
                axios.get('/api/allies/images').then(response => {
                    this.alliesImages = response.data;
                }).catch(error => {
                    this.$notify.error({
                        title: 'Error',
                        message: 'No se pudo completar la acción getData.'
                    });
                });
            },
            submitAlly(){
                let params = {
                    type: 3,
                    allAllies: this.alliesImages,
                    deletes: this.allDelete
                };
                this.startLoading();
                axios.post('/api/recommendations/saveMessages', params).then(response => {
                    this.alliesImages = {};
                    this.getFiles();
                    this.stopLoading();
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

            },
            allySuccess(res) {
                this.imageUrl = res.path;
                this.formAllies.idImage = res.documentId;
                this.formAllies.allies= res.path;
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
            editAlly(data,index){
                this.index = index;
                this.formAllies.idImage = data.id;
                this.formAllies.text = data.text;
                this.formAllies.link = data.link;
                this.imageUrl = data.allies;
                this.enableLoad = true;
            },
            previewSee(){
                if (this.index !== null){
                    this.alliesImages[this.index].text = this.formAllies.text;
                    this.alliesImages[this.index].link = this.formAllies.link;
                    this.enableLoad = false;
                }else {
                    this.$refs['allies'].validate((valid) => {
                        if(valid){
                            this.alliesImages.push({
                                id:this.formAllies.idImage,
                                text: this.formAllies.text,
                                link: this.formAllies.link,
                                allies: this.formAllies.allies
                            });
                            this.carouselId++;
                        }else{
                            this.$message({
                                type: "warning",
                                title: 'Error',
                                message: "Complete los campos para continuar"
                            });
                        }
                    });
                }
                this.index = null;
                this.formAllies.idImage = null;
                this.formAllies.text = '';
                this.formAllies.link = '';
                this.formAllies.allies = '';
                this.imageUrl = '';
            },
            testUrl(){
                window.open(this.formAllies.link,'_blank');
            },
            deleteAlly(data,ind){
                this.$confirm('¿Está seguro que quiere eliminar este aliado?',{
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    type: 'warning'
                }).then(() => {
                    this.alliesImages.splice(ind, 1);
                    this.allDelete.push(data.id);
                    this.carouselId++;
                    this.index = null;
                    this.formAllies.idImage = null;
                    this.formAllies.text = '';
                    this.formAllies.link = '';
                    this.formAllies.allies = '';
                    this.imageUrl = '';
                    this.$message({
                        type: "success",
                        title: 'Éxito',
                        message: "Se elimino aliado de la lista"
                    });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Eliminación cancelada'
                    });
                });
            }
        }
    }
</script>

<style scoped>

    .showimages{
        border: 1px solid #DCDFE6;
        padding: 20px;
        border-radius: 5px;
    }

    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
        border: 2px dashed #DCDFE6;
    }
    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }
</style>
