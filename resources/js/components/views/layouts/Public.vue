<template>
    <div>

 <nav class="navbar navbar-inverse sub-navbar fixed-top" style="margin-top: 50px!important;">
		  <div class="container">
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#subenlaces">
		        <span class="sr-only">Interruptor de Navegación</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="?tab=">SERIDH </a>
		    </div>
		    <div class="collapse navbar-collapse" id="subenlaces">
		      <ul class="nav subnav navbar-nav navbar-right">
	            <li class="landing-btn active">
	                <a href="index.html">
	            		Inicio
	            	</a>
	        	</li>
	        	<li class="landing-btn">
		            <a href="catalogo.html">
		                Catálogo
		            </a>
		        </li>
		    	<li class="landing-btn">
		            <a href="#">
		                Preguntas frecuentes
		            </a>
		        </li>
		   		<li class="landing-btn">
		            <a href="#">
		                Metogología
		            </a>
		        </li>
		        <li class="landing-btn">
		            <a href="#">
		                Datos abiertos
		            </a>
		        </li>
		      </ul>
		    </div>
		  </div>
</nav>


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
