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


        },
        mounted(){
            let recaptchaScript = document.createElement('script')
    recaptchaScript.setAttribute('src', 'https://framework-gb.cdn.gob.mx/gobmx.js')
    document.head.appendChild(recaptchaScript);
        }
    }
</script>

<style scoped>




</style>
