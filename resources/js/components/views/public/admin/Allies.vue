<template>
   <!-- https://github.com/wlada/vue-carousel-3d#usage -->
    <div>
       <div >


 Hay slider: {{ previewImages.length }}

 <div >
  <carousel-3d 
            :height="180" 
            :disable3d="true" 
                :space="365" 
            :clickable="true" 
     :controls-visible="true"
     
     >

    <slide v-for="(slide, i) in previewImages.length" :key="i" :index="i">
                  <div >
                            <div class="card text-center card-gob">
                            <div style="background: #2769c6; width: 100%; padding: 3.5em;">
                                <!-- <img :src="getExpReg(previewImages[i])" style="width: 100% !important; heigth: 150px;"> -->
                            </div>
                            <h4  class="card-title">
                             yyyyy   Lorem ipsum dolor sit amet, consectetur adipisicing elit. {{i}}
                            </h4>
                            <br/>
                            <a href="https://www.un.org/es" target="_blank" class="btn btn-primary btn-xs pull-center active" style="width:40%; margin: 0px auto 10px auto;">Ir al enlace</a>
                             </div>
                    </div>
                
    </slide>
  </carousel-3d>
</div>




  <button @click="mas()">Agregar imagenes </button>

                    <!-- <carousel-3d :height="220" :width="360" :border="1.5" :space="365" :clickable="false" :controls-visible="true">
                        <slide  v-for="(slide, i) in slides" :index="i" :key="i" >
                           <div class="row">
                            <div class="col-md-12 card text-center card-gob">
                            <div style="background: #2769c6; width: 100%; padding: 1.5em;">
                                <img src="img/logo-onu.png" style="width: 100% !important; heigth: 300px;">
                            </div>
                            <h4 data-v-ce5e9132="" class="card-title">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </h4>
                            <br/>
                            <a href="https://www.un.org/es" target="_blank" class="btn btn-primary btn-xs pull-center active" style="width:40%; margin: 0px auto 10px auto;">Ir al enlace</a>
                             </div>
                           </div>
                        </slide>
                    </carousel-3d> -->
                </div>



             <el-divider content-position="left">Vista previa</el-divider>

<div style="margin: 50px auto; " v-if="showSlides===false">

              <div class="card text-center card-gob" style="height: 220px; width:20%; display:inline-block;"
                         v-for="(image,index) in previewImages" 
                          :key="index">
                        <div style="background: #2769c6; width: 87%; height: 60px; padding: 20px;" >
                            <img :src="getExpReg(image)" style="width: 100%; height: 65px;">
                        </div>
                        <div style="text-aling:center; padding: 5px;">
                            <p>
                              <strong><b> Lorem ipsum dolor sit amet, consectetur adipisicing elit.</b></strong>
                            </p>

                            <a href="https://www.un.org/es" class="btn btn-categorias" style="cursor: pointer; text-decoration: none;" target="_blank" >Ir al enlace</a>

                        </div>
                    </div>

</div>
      


 




        


        <el-row class="showimages">
            <!-- <el-divider content-position="left">Vista previa</el-divider>
            <el-row style="margin-bottom: 30px">
                <el-col :offset="4">
                    <el-carousel trigger="click" height="250px"  style="width: 70%" v-if="previewImages.length>0">
                        <el-carousel-item v-for="(image,index) in previewImages" :key="index" style="text-align: center">
                            <img :src="getExpReg(image)" alt="" style="width:100%; height: 250px;">
                        </el-carousel-item>
                    </el-carousel>
                    <h3 v-else >No hay ninguna imagen</h3>
                </el-col>
            </el-row> -->



           
          
                
          



            <el-divider content-position="left">Lista de imagenes
                <span :class="{imageFull : previewImages.length > 0}" style="border-radius: 10px;padding: 3px;background: red;color: white;">
                    {{previewImages.length}}
                </span>
            </el-divider>
            <el-row style="margin-top: 50px">
                <el-col :span="24">
                    <el-upload
                        ref="carrusel"
                        id="listImg"
                        style="text-align: center"
                        action="/api/recommendations/updateImg/file"
                        name="document"
                        :headers="{'Authorization': apiToken}"
                        :data="{allies:true}"
                        list-type="picture-card"
                        accept=".jpg, .png, .jpeg"
                        :on-success="successImage"
                        :file-list="listImages"
                        :before-upload="beforeUploadFile"
                        :on-preview="handlePictureCardPreview"
                        :on-remove="handleRemove">

                        <i class="fas fa-cloud-upload-alt"> Cargar imagen (1500px X 400px)</i>
                    </el-upload>
                    <el-dialog :visible.sync="dialogVisible">
                        <img width="100%" :src="dialogImageUrl" alt="">
                    </el-dialog>
                </el-col>
            </el-row>
            <el-row type="flex" class="row-bg" justify="end" style="margin-top: 20px">
                <el-col :span="2.5">
                    <el-button type="primary" @click="submitImages" :disabled="previewImages.length===0">Guardar</el-button>
                </el-col>
            </el-row>
        </el-row>

    </div>
</template>

<script>
    import { Carousel3d, Slide } from 'vue-carousel-3d';
    export default {
          components: {
    'carousel-3d': Carousel3d,
    'slide': Slide
  },

        data(){
            return{
                dialogImageUrl: '',
                dialogVisible: false,
                previewImages:[],
                apiToken: 'Bearer ' + sessionStorage.getItem('SERIDH_token'),
                idsFiles:[],
                idsDelete:[],
                listImages: [],
                slides:0,
                showSlides: false
            }
        },

        created(){
            this.getFiles();
        },
        mounted() {

        },
        methods: {
        
            getExpReg(value){
                console.log("jkjkjkjkkjjkjkjk",value);
                if(value.fileNameHash === undefined){
                    return '';
                }else{
                     return `/img/public/allies/${value.fileNameHash}`;
                }
            },
            getFiles(){
                let $this = this;
                axios.get('/api/allies/images').then(response => {
                    console.log("Response imagenes aliados: ",response.data);
                    this.previewImages = response.data;
                    this.slides = response.data.length;

                   if(this.slides > 2){
                      this.showSlides = false;
                      
                     setTimeout(item=>{
                       this.showSlides = true;
                     },2000);

                    }else{
                      this.showSlides = false;
                    }


                    response.data.forEach(function(element){
                        $this.idsFiles.push(element.id);
                        $this.listImages.push({url:element.allies});
                    });
                }).catch(error => {
                    this.$notify.error({
                        title: 'Error',
                        message: 'No se pudo completar la acción getData.'
                    });
                });
            },
            handleRemove(file) {
                let idsDelete = [];
                let arrayDelete = this.previewImages.filter(function(item) {
                    return item.fileName === file.name;
                });
                let arrayDelete2 = this.previewImages.filter(function(item) {
                    return item.allies === file.url;
                });

                if (arrayDelete.length>0) {idsDelete.push(arrayDelete[0].id); this.idsFiles = this.idsFiles.filter(id => id !== arrayDelete[0].id);}
                if (arrayDelete2.length>0) {idsDelete.push(arrayDelete2[0].id); this.idsFiles = this.idsFiles.filter(id => id !== arrayDelete2[0].id);}

                let newArray = this.previewImages.filter(function(item) {
                    return item.fileName !== file.name;
                });
                this.previewImages = newArray;
                let newArray2 = this.previewImages.filter(function(item) {
                    return item.allies !== file.url;
                });
                this.previewImages = newArray2;
                if (idsDelete.length>0) this.idsDelete.push(idsDelete[0]);
            },
            handlePictureCardPreview(file) {
                console.log("File: ",file);
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;
            },
            successImage(response,file){
                this.idsFiles.push(response.documentId);
                this.previewImages.push({id:response.documentId, fileName:response.fileName,fileNameHash: response.fileNameHash ,path: response.allies });
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
            submitImages(){
                let params = {
                    type: 2,
                    ids: this.idsFiles,
                    idsDelete: this.idsDelete
                };
                axios.post('/api/recommendations/saveMessages', params).then(response => {
                    this.previewImages=[];
                    this.listImages=[];
                    this.getFiles();
                    this.$notify({
                        type: "success",
                        message: "Se actualizo la información correctamente"
                    });
                }).catch(error => {
                    console.log(error);
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            },
        }
    }
</script>

<style scoped>

 .card-gob .list-unstyled[data-v-ce5e9132] {
        height: 5.2rem
    }

    .el-carousel__item h3 {
        color: #475669;
        font-size: 14px;
        opacity: 0.75;
        line-height: 150px;
        margin: 0;
    }

    .el-carousel__item:nth-child(2n) {
        background-color: #99a9bf;
    }

    .el-carousel__item:nth-child(2n+1) {
        background-color: #d3dce6;
    }
    .showimages{
        border: 1px solid #DCDFE6;
        padding: 20px;
        border-radius: 5px;
    }
    .imageFull{
        background: #38a2f9 !important;
    }
    .btn-categorias {
        text-align: center;
        color: #fff !important;
        background-color: #9d2449;
        border: 0;
        padding: 5px 7px;
        font-size: .9rem;
        margin-bottom: 10px
    }





</style>
