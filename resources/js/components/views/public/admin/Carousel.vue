<template>
    <div>
        <el-row class="showimages">
            <el-divider content-position="left">Vista previa</el-divider>
            <el-row style="margin-bottom: 30px">
                <el-col :offset="4">
                    <el-carousel trigger="click" height="250px"  style="width: 70%" v-if="previewImages.length>0">
                        <el-carousel-item v-for="(image,index) in previewImages" :key="index" style="text-align: center">
                            <img :src="getExpReg(image)" alt="" style="width:100%; height: 250px;">
                        </el-carousel-item>
                    </el-carousel>
                    <h3 v-else >No hay ninguna imagen</h3>
                </el-col>
            </el-row>
            <el-divider content-position="left">Lista de imagenes
                <span :class="{imageFull : previewImages.length>0}" style="border-radius: 10px;padding: 3px;background: red;color: white;">
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
                        :data="{carousel:true}"
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
    export default {
        data(){
            return{
                dialogImageUrl: '',
                dialogVisible: false,
                previewImages:[],
                apiToken: 'Bearer ' + sessionStorage.getItem('SERIDH_token'),
                idsFiles:[],
                idsDelete:[],
                listImages: [],
            }
        },
        mounted() {
            this.getFiles();
        },
        methods: {
            getExpReg(value){
              return `/img/public/carousel/${value.fileNameHash}`;
            },
            getFiles(){
                let $this = this;
                axios.get('/api/carousel/images').then(response => {
                    this.previewImages = response.data;
                    response.data.forEach(function(element){
                        $this.idsFiles.push(element.id);
                        $this.listImages.push({url:element.carousel});
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
                    return item.carousel === file.url;
                });

                if (arrayDelete.length>0) {idsDelete.push(arrayDelete[0].id); this.idsFiles = this.idsFiles.filter(id => id !== arrayDelete[0].id);}
                if (arrayDelete2.length>0) {idsDelete.push(arrayDelete2[0].id); this.idsFiles = this.idsFiles.filter(id => id !== arrayDelete2[0].id);}

                let newArray = this.previewImages.filter(function(item) {
                    return item.fileName !== file.name;
                });
                this.previewImages = newArray;
                let newArray2 = this.previewImages.filter(function(item) {
                    return item.carousel !== file.url;
                });
                this.previewImages = newArray2;
                if (idsDelete.length>0) this.idsDelete.push(idsDelete[0]);
            },
            handlePictureCardPreview(file) {
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;
            },
            successImage(response,file){
                this.idsFiles.push(response.documentId);
                this.previewImages.push({id:response.documentId, fileName:response.fileName,fileNameHash:response.fileNameHash,path:response.carousel});
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
                    type: 1,
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


</style>
