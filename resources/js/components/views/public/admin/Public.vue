<template>
<div>

<el-card class="box-card">
    <el-row>
        <el-col offset="22">
            <el-button
                size="small"
                type="danger"
                icon="el-icon-arrow-left"
                @click="$router.push('/administracion/')">
                Regresar
            </el-button>
        </el-col>
    </el-row>
    <el-row :gutter="2" style="margin-bottom: 20px">
        <h2>Administrador del portal público</h2>
    </el-row>

    <el-row>
        <el-collapse :accordion="true"  :value="collapse" >
            <el-collapse-item name="1">
                <template slot="title">
                    <h3>Configuración de carrusel</h3>
                </template>
                <carousel/>
            </el-collapse-item>
            <el-collapse-item name="2">
                <template slot="title">
                    <h3>Configuración de mensajes</h3>
                </template>
                <messages/>
            </el-collapse-item>
            <el-collapse-item name="3">
                <template slot="title">
                    <h3>Configuración de aliados</h3>
                </template>
                <allies/>
            </el-collapse-item>
        </el-collapse>
    </el-row>
</el-card>
</div>
</template>

<script>
    import messages from './Messages';
    import allies from './Allies';
    import carousel from './Carousel';

export default {
    components:{
        messages,
        allies,
        carousel
    },
    data() {
      return {
          collapse:['3']
      }
    },
}
</script>

<style scoped>
</style>
