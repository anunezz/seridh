<template>
    <div v-loading="loading"
         element-loading-text="Esperando..."
         element-loading-spinner="el-icon-loading"
         style="width: 100%">

         hola

    </div>
</template>

<script>
    import { mapState, mapGetters, mapActions, mapMutations } from "vuex";
    import Chart from 'chart.js';
    import { setTimeout } from 'timers';
    export default {

        name: 'bar-char-colums',

        data() {
            return {

            };
        },

        computed: {
            ...mapState('publico',['visits','loading','prueba','cats','colors']),
        },

        created(){


        },
        methods: {
            ...mapActions("publico", ['activeLoaing','addVisits','activeLoaing','addCats','addColors']),

        },
        mounted(){
            this.event();
        }
    }
</script>

<style>
</style>
