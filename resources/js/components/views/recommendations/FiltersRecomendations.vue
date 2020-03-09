<template>
    <div>



        <el-dialog
            v-if="show"
            :visible.sync="show"
            width="80%">

             <pre>
                   {{selectFilter}}
            </pre>

             <h3>Filtros avanzados recomendaciones</h3>
            <hr>

            <el-row style="margin-top: 20px" :gutter="20">

                <el-col :span="24" >


                            <div>
                                <div class="" style="
                                width: 100%;
                                display: flex;
                                flex-wrap: wrap;
                                justify-content: space-between;
                                vertical-align: middle;
                                text-align: center;
                                overflow: hidden;
                                align-items: center;">

                                        <el-checkbox>
                                            Publicados
                                        </el-checkbox>

                                        <el-checkbox>
                                            Sin publicar
                                        </el-checkbox>

                                        <el-checkbox>
                                            Sin publicar
                                        </el-checkbox>

                                        <el-checkbox>
                                            B&uacute;squeda por exclusi&oacute;n
                                        </el-checkbox>

                                </div>
                            </div>




                </el-col>

                <el-col :span="6" v-for="(item,index) in filters" :key="index" >
                    <div style="width: 100%;">
                          <el-button style="width: 100%;" @click="actived = index"> {{ item }}  </el-button>
                    </div>
                </el-col>

                <el-col :span="24">
                    <br>
                    <div style="width: 100%; border: 0.5px #DDDDDD solid; padding: 5px;" v-if="actived === 0" >
                        <el-row style="margin: 10px" :gutter="20">
                            <el-checkbox-group v-model="selectFilter.date" class="form-check animated fadeIn fast">
                                    <div style="width: 100%;">
                                        <el-col :span="2" v-for="(item,index) in date" :key="index">
                                                    <el-checkbox :label="item"> {{item}} </el-checkbox>
                                        </el-col>
                                    </div>
                            </el-checkbox-group>
                        </el-row>
                    </div>

                    <div style="width: 100%; border: 0.5px #DDDDDD solid; padding: 5px;" v-if="actived === 1" >
                           <el-row style="margin: 10px" :gutter="20">
                                <el-checkbox-group v-model="selectFilter.entities" class="form-check animated fadeIn fast">
                                        <div style="width: 100%;">
                                            <el-col :span="24" v-for="(item,index) in entities" :key="index">
                                                        <el-checkbox :label="item.id"> {{item.name}} </el-checkbox>
                                            </el-col>
                                        </div>
                                </el-checkbox-group>
                            </el-row>
                    </div>
                    <div style="width: 100%; border: 0.5px #DDDDDD solid; padding: 5px;" v-if="actived === 2" >
                            hola estas en Poblacion
                    </div>
                    <div style="width: 100%; border: 0.5px #DDDDDD solid; padding: 5px;" v-if="actived === 3" >
                            hola estas en Temas
                    </div>
                    <div style="width: 100%; border: 0.5px #DDDDDD solid; padding: 5px;" v-if="actived === 4" >
                            hola estas en Autoridad
                    </div>
                    <div style="width: 100%; border: 0.5px #DDDDDD solid; padding: 5px;" v-if="actived === 5" >
                            hola estas en ODS
                    </div>
                    <div style="width: 100%; border: 0.5px #DDDDDD solid; padding: 5px;" v-if="actived === 6" >
                            hola estas en Derechos Humanos
                    </div>
                    <div style="width: 100%; border: 0.5px #DDDDDD solid; padding: 5px;" v-if="actived === 7" >
                            hola estas en Accion Solicitada
                    </div>


                </el-col>

            </el-row>





            <span slot="footer" class="dialog-footer">
                <el-button type="primary" @click="show = false">Cancelar</el-button>
                <el-button type="success" @click="searchFilters('searchRecommendation')" >Buscar</el-button>
            </span>
        </el-dialog>




    </div>
</template>

<script>
    export default {
        props:['show'],
        data(){
            return{
                filters:['Fecha','Entidad Emisora','Población','Temas','Autoridad','ODS','Derechos Humanos','Acción Solicitada'],
                selectFilter:{
                    date:[],
                    entities:[]
                },
                actived: 0,
                date:[],
                entities:[]
            }
        },
        created() {
        },
        mounted() {
            this.getCats();
        },
        methods:{
            searchFilters(action){

                console.log("action: ",action);

                        let data = { action: action };

                        if( action === 'searchRecommendation')
                        {
                           data.filter = this.selectFilter;
                        }

                        if(action === 'deleteRecommendation'){
                            data.deleteId = 'ok';
                        }





                    axios.post('/api/recommendations/advancedFiltersRecommendation',
                           data
                    ).then(response => {
                        if(response.data.success === true){
                            this.date = response.data.lResults.date;
                        }



                        console.log("Catalogos axios: ",response);

                    }).catch(error => {
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                 });
            },
            getCats(){
                axios.get('/api/recommendations/getCatsFilters').then(response => {
                    if(response.data.success === true){
                        this.date = response.data.lResults.date;
                         console.log("Entidad emisora: ",response.data.lResults);
                         this.entities = response.data.lResults.entities;

                    }

                    console.log("Catalogos axios: ",response);

                }).catch(error => {
                this.$message({
                    type: "warning",
                    message: "No fue posible completar la acción, intente nuevamente."
                });
            });
            }
        },
    }
</script>

<style scoped>
</style>
