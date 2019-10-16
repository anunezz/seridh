<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
    import { mapState, mapGetters, mapActions, mapMutations } from "vuex";

    export default {
        data() {
            return {

            };
        },

        computed: {
            ...mapGetters('loading', ['message','status']),
        },

        created() {
            this.startLoading();


            this.stopLoading();
        },

        methods: {


        }
    }
</script>

<style scoped>




</style>
