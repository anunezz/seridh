<template>
<div>
    <header-section icon="el-icon-document-add" title="Catalogos">
        <template slot="buttons">
            <el-button
                size="small"
                type="danger"
                icon="el-icon-arrow-left"
                @click="$router.push('/administracion/')">
                Regresar
            </el-button>
        </template>
    </header-section>

    <el-row :gutter="10">
        <el-col :span="24">
            <el-select v-model="selectedCat"
                       placeholder="Seleccione un catálogo"
                       style="width: 100%">
                <el-option
                    v-for="(cat, index) in cats"
                    :key="index"
                    :label="cat.name"
                    :value="cat.id">
                </el-option>
            </el-select>
        </el-col>
    </el-row>
    <br>
    <entities v-if="selectedCat === 1"/>
    <order v-if="selectedCat === 2"/>
    <power v-if="selectedCat === 3"/>
    <authority v-if="selectedCat === 4"/>
    <population v-if="selectedCat === 5"/>
    <requested v-if="selectedCat === 6"/>
    <ods v-if="selectedCat === 7"/>
    <goalsods v-if="selectedCat === 13"/>
    <topics v-if="selectedCat === 8"/>
    <subtopic v-if="selectedCat === 10"/>
    <right v-if="selectedCat === 9"/>
    <subright v-if="selectedCat === 11"/>
    <Subcategory v-if="selectedCat === 12"/>


</div>
</template>

<script>

    import HeaderSection from "../layouts/partials/HeaderSection";
    import Entities from "../catalogs/entity/index";
    import Order from "../catalogs/government order/index";
    import Power from "../catalogs/government power/index";
    import Authority from "../catalogs/authority/index";
    import Population from "../catalogs/population/index";
    import Requested from "../catalogs/requested action/index";
    import Ods from "../catalogs/ods/index";
    import Topics from "../catalogs/topics/index";
    import Right from "../catalogs/rights/index";
    import Subtopic from "../catalogs/subtopic/index";
    import Subright from "../catalogs/subright/index";
    import Subcategory from "../catalogs/subcategory/index";
    import Goalsods from "../catalogs/goalsods/index";

    export default {
        components: {
            HeaderSection,
            Entities,
            Order,
            Power,
            Authority,
            Population,
            Requested,
            Ods,
            Topics,
            Right,
            Subtopic,
            Subright,
            Subcategory,
            Goalsods
        },

        data(){
            return{
                selectedCat: null,
                cats: [
                    {id:6,  name: 'Acción Solicitada'},
                    {id:4,  name: 'Autoridad encargada de atender'},
                    {id:9,  name: 'Derechos Nivel 1'},
                    {id:11, name: 'Derechos Nivel 2'},
                    {id:12, name: 'Derechos Nivel 3'},
                    {id:1,  name: 'Entidad Emisora'},
                    {id:13, name: 'Metas ODS'},
                    {id:7,  name: 'ODS'},
                    {id:2,  name: 'Orden de Gobierno'},
                    {id:3,  name: 'Poder de Gobierno'},
                    {id:5,  name: 'Población'},
                    {id:10, name: 'SubTemas'},
                    {id:8,  name: 'Temas'},



                ],
            }
        },

        methods: {
            goTo(link, data) {
                axios.post('/api/transaction', data).then(response => {
                    this.$router.push({
                        name: link
                    });
                }).catch(error => {
                    this.$message({
                        type: "warning",
                        message: "No fue posible completar la acción, intente nuevamente."
                    });
                });
            }
        }
    }
</script>

<style scoped>
    .links {
        font-size: 25px;
        color: #9D2449;
        cursor: pointer;
        text-decoration: underline;
    }
</style>
