<template>
    <div v-loading="loading"
         element-loading-text="Esperando..."
         element-loading-spinner="el-icon-loading"
         style="width: 100%">



<!-- <div class="custom-splash" v-show="animate === true">
			<div id="splash_cont" class="animate">
				<svg height="400" width="400" xmlns="http://www.w3.org/2000/svg">
					<circle class="circle" cx="200" cy="200" r="195"></circle>
				</svg>
				<img id="ruby" src="img/sre_vert.svg" alt="" width="65%"/>
			</div>
		</div> -->


        <!-- <el-container
				v-loading.fullscreen.lock="status"
				:element-loading-text="message"
				element-loading-background="rgba(255, 255, 255, 0.75)"
				:class="{ 'blur': animate === true }">

			<vue-progress-bar></vue-progress-bar>

         </el-container> -->



        <el-backtop :visibility-height="500"/>
        <nav class="navbar navbar-inverse sub-navbar fixed-top" style="margin-top: 50px!important;">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#subenlaces">
                        <span class="sr-only">Interruptor de Navegación</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="?tab=">SERIDH <small>v {{$vertion}}</small> </a>
                </div>
                <div class="collapse navbar-collapse" id="subenlaces">
                    <ul class="nav subnav navbar-nav navbar-right">
                        <li class="landing-btn active">
                            <a @click="$router.push( {path: '/publico'})" style="cursor: pointer;">
                                Inicio
                            </a>
                        </li>
                        <li class="landing-btn">
                            <a @click="$router.push({name: 'PublicDocuments'})" style="cursor: pointer;">
                                Documentos
                            </a>
                        </li>
                        <li class="landing-btn">
                            <a @click="exportExcel()" style="cursor: pointer;">
                                Exportar Excel
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
    import Chart from 'chart.js';
    import { setTimeout } from 'timers';
    export default {
        data() {
            return {
                show: false,
				animate: true,
				showStatus :false
            };
        },

        computed: {
            ...mapState('publico',['visits','loading','prueba','cats','colors']),
        },

        created(){
            this.startLoading();
            this.stopLoading();

        },
        methods: {
            ...mapActions("publico", ['addVisits','activeLoaing','addCats','addColors']),
            event(){
                let me = this;
                var config = {
                    headers:{
                        'Content-Type':'application/json',
                        'Accept':'application/json'
                    }
                }

                axios.get('/api/public/recommendations/count', config).then(function (response) {
                    if (response.data.success){
                        let data = {
                            'recommendation':response.data.lResults.recommendation,
                            'issuingEntities': response.data.lResults.entity,
                            'topic': response.data.lResults.topics,
                            'reportedaction': response.data.lResults.reportedaction
                        };

                        me.addCats([]);
                        me.addVisits([]);
                        setTimeout(item=>{
                            me.addCats( response.data.lResults.cats );
                            me.addVisits( data );
                        },500);

                    }
                }).catch(function (error) {
                    me.$notify.error({
                        title: 'Error',
                        message: 'No se pudo completar la acción count()'
                    });
                });
            },
            exportExcel(){
            let me = this;
                me.activeLoaing(true);
                axios({ responseType: 'blob',
                    method: 'GET',
                    headers: { 'Authorization': 'Bearer ' +localStorage.getItem('token'),}  ,
                    url: '/api/public/exportRecomendaciones'}).then(function (response) {
                    setTimeout(item=>{
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download','ExportExcel.xlsx');
                        document.body.appendChild(link);
                        link.click();
                        me.activeLoaing(false);
                    },200);

                }).catch(function (error) {
                    me.activeLoaing(false);
                });
            }
        },
        mounted(){
            this.event();
        }
    }
</script>

<style>

    .sub_banner {
        text-align: center;
    }

    .card {
        position: relative;
        display: -ms-flexbox;
        display: -webkit-box;
        display: flex;
        -ms-flex-direction: column;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, .125);
        border-radius: .25rem;
    }

    a[data-v-2e10a77a]:link {
        text-decoration: none;
        color: #fff !important
    }

    a[data-v-2e10a77a]:hover {
        text-decoration: underline;
        color: #38a2f9 !important
    }

    a[data-v-2e10a77a]:visited {
        text-decoration: none;
        color: #fff !important
    }

    .panel-footer[data-v-2e10a77a] {
        font-family: Montserrat;
        font-size: 85%;
        color: #fff;
        line-height: 135%;
        background-image: url(https://framework-gb.cdn.gob.mx/landing/img/fondofooter.svg);
        height: auto;
        background-size: cover
    }

    #division[data-v-2e10a77a] {
        margin-top: 25%
    }

    #mail[data-v-2e10a77a] {
        margin-top: -6%
    }

    @media only screen and (max-width: 600px) {
        #division[data-v-2e10a77a] {
            margin-top: 5%
        }

        .logo_footer[data-v-2e10a77a] {
            width: 75%;
            margin-top: 25% !important;
            margin-left: 0 !important;
            padding-left: 0;
            -ms-flex-line-pack: center;
            align-content: center
        }

        #redes[data-v-2e10a77a] {
            margin-top: 10% !important
        }

        #mail[data-v-2e10a77a] {
            line-height: 300%
        }
    }

    @media screen and (min-width: 1600px) {
        .container[data-v-2e10a77a] {
            max-width: 5000px !important;
            width: 80% !important
        }
    }

    @media only screen and (min-width: 768px) and (max-width: 1024px) {
        #mail[data-v-2e10a77a] {
            font-size: 81%
        }
    }

    [data-v-ce5e9132]:focus {
        -webkit-box-shadow: 0 0 0 0 #000 !important;
        box-shadow: 0 0 0 0 #000 !important
    }

    .global[data-v-ce5e9132] {
        font-family: Montserrat, sans-serif;
        margin-bottom: 3rem
    }

    .dorado[data-v-ce5e9132] {
        color: #b38e5d
    }

    .doradoclaro[data-v-ce5e9132] {
        color: #d4c19c
    }

    .elemento-oculto[data-v-ce5e9132] {
        position: absolute !important;
        clip: rect(1px 1px 1px 1px);
        clip: rect(1px, 1px, 1px, 1px)
    }

    #carouselMainGobmxHead[data-v-ce5e9132] {
        position: relative
    }

    .carousel-indicators[data-v-ce5e9132] {
        margin: 3px
    }

    .carousel-indicators li[data-v-ce5e9132] {
        background-color: #9d2449;
        height: 10px;
        width: 10px;
        border-radius: 50%;
        border: 1px solid #fff;
        margin-bottom: 5px
    }

    .carousel-control-next[data-v-ce5e9132], .carousel-control-prev[data-v-ce5e9132] {
        width: 5%
    }

    #topsearch[data-v-ce5e9132] {
        color: #fff;
        position: absolute;
        bottom: 20px;
        z-index: 50
    }

    #topsearch p[data-v-ce5e9132] {
        margin: 2px;
        font-size: 20px !important;
        text-shadow: 2.5px 2.5px 5px #000
    }

    #topsearch a[data-v-ce5e9132]:hover {
        background-color: #b38e5d;
        text-decoration: none;
        color: #fff
    }

    #topsearch a[data-v-ce5e9132] {
        margin-bottom: 4px
    }

    #masbuscados[data-v-ce5e9132] {
        position: absolute
    }

    .btn-top-search[data-v-ce5e9132] {
        color: #fff;
        background-color: #000;
        border: 0;
        padding: 5px 7px;
        font-size: .7rem;
        margin-right: .25rem
    }

    .card-gob .list-unstyled[data-v-ce5e9132] {
        height: 5.2rem
    }

    .card-img-gob[data-v-ce5e9132] {
        width: 30%;
        margin-left: auto;
        margin-right: auto;
        padding-bottom: 0;
        margin-top: 5%
    }

    .card-body[data-v-ce5e9132] {
        padding-top: 2px;
        padding-bottom: 2px
    }

    .card-carousel a[data-v-ce5e9132]:visited {
        color: #212529
    }

    .card-footer[data-v-ce5e9132] {
        font-size: 11px;
        color: #fff;
        background-color: #285c4d;
        height: 8rem
    }

    .footerverde[data-v-ce5e9132] {
        background-color: #621132
    }

    .card-title[data-v-ce5e9132] {
        margin-bottom: 2px;
        height: 2.3rem
    }

    .card-gob[data-v-ce5e9132] {
        margin-bottom: 2rem
    }

    .card-gob h4[data-v-ce5e9132] {
        font-weight: 900;
        font-size: 1rem
    }

    .card-img-top[data-v-ce5e9132] {
        margin-bottom: 3%
    }

    .programas[data-v-ce5e9132] {
        height: 5.4rem
    }

    .programastab[data-v-ce5e9132] {
        height: 6.5rem
    }

    .programascel[data-v-ce5e9132] {
        height: 6.2rem
    }

    .card-gob[data-v-ce5e9132]:hover {
        -webkit-box-shadow: 0 5px 8px 0 #d1d1d1;
        box-shadow: 0 5px 8px 0 #d1d1d1
    }

    .card-gob p a[data-v-ce5e9132], .card-gob ul a[data-v-ce5e9132] {
        text-decoration: none;
        color: #706f6f
    }

    .card-gob a[data-v-ce5e9132]:hover {
        text-decoration: underline;
        color: #000
    }

    .titulocategoria a[data-v-ce5e9132]:visited {
        text-decoration: none;
        color: #000
    }

    .card-title a[data-v-ce5e9132]:visited {
        text-decoration: none
    }

    .card-body a[data-v-ce5e9132]:hover, .card-gob p a[data-v-ce5e9132]:hover, .card-gob ul a[data-v-ce5e9132]:hover {
        text-decoration: underline;
        color: #706f6f
    }

    .card-title a[data-v-ce5e9132]:hover, .card-title a[data-v-ce5e9132]:visited {
        text-decoration: underline;
        color: #000
    }

    .btn-categorias[data-v-ce5e9132] {
        color: #fff !important;
        background-color: #9d2449;
        border: 0;
        padding: 5px 7px;
        font-size: .9rem;
        margin-bottom: 10px
    }

    .btn-categorias[data-v-ce5e9132]:hover {
        color: #fff !important;
        background-color: #000
    }

    .card-carousel[data-v-ce5e9132] {
        border: 0;
        margin-bottom: 3rem
    }

    .categorias .card-gob[data-v-ce5e9132] {
        height: 290px
    }

    #topsearch h2[data-v-ce5e9132] {
        font-size: 20px
    }

    #glit[data-v-ce5e9132] {
        position: relative;
        margin-top: 2.8rem;
        margin-bottom: 3.7rem
    }

    #line[data-v-ce5e9132] {
        position: absolute;
        background-color: #b38e5d;
        bottom: -10px;
        width: 35px;
        height: 5px
    }

    #glit h3[data-v-ce5e9132] {
        font-weight: 400;
        color: #706f6f
    }

    @media screen and (min-width: 320px) {
        .next2[data-v-ce5e9132], .prev2[data-v-ce5e9132] {
            height: 2rem !important;
            width: 3rem;
            margin-top: -12% !important
        }

        .prev2[data-v-ce5e9132] {
            margin-left: 65% !important
        }

        .card-body[data-v-ce5e9132] {
            height: 8rem
        }

        .card-footer[data-v-ce5e9132] {
            height: 11rem
        }
    }

    @media screen and (min-width: 340px) {
        .categorias .card-gob[data-v-ce5e9132] {
            height: 320px
        }

        .next2[data-v-ce5e9132], .prev2[data-v-ce5e9132] {
            height: 2.5rem !important;
            margin-top: -14% !important
        }
    }

    @media screen and (min-width: 430px) {
        .categorias .card-gob[data-v-ce5e9132] {
            height: 350px !important
        }

        .next2[data-v-ce5e9132], .prev2[data-v-ce5e9132] {
            height: 2.5rem !important;
            margin-top: -11% !important
        }

        .prev2[data-v-ce5e9132] {
            margin-left: 75% !important
        }

        .card-body[data-v-ce5e9132], .card-footer[data-v-ce5e9132] {
            height: 6rem
        }
    }

    @media screen and (min-width: 500px) {
        .categorias .card-gob[data-v-ce5e9132] {
            height: 370px !important
        }

        .next2[data-v-ce5e9132], .prev2[data-v-ce5e9132] {
            height: 2.5rem !important;
            margin-top: -9% !important
        }

        .prev2[data-v-ce5e9132] {
            margin-left: 79% !important
        }
    }

    @media screen and (min-width: 576px) {
        .header_padding[data-v-ce5e9132] {
            padding-top: 2.5rem !important
        }

        .categorias .card-gob[data-v-ce5e9132] {
            height: 290px !important
        }

        .list-unstyled[data-v-ce5e9132] {
            margin-bottom: 20%
        }

        .card-footer[data-v-ce5e9132] {
            height: 6rem
        }

        .programascel[data-v-ce5e9132] {
            height: 4rem
        }
    }

    @media screen and (min-width: 768px) {
        .header_padding[data-v-ce5e9132] {
            padding-top: 48px
        }

        .categorias .card-gob[data-v-ce5e9132] {
            height: 310px !important
        }

        .next2[data-v-ce5e9132], .prev2[data-v-ce5e9132] {
            height: 2.5rem !important;
            margin-top: -6% !important
        }

        .prev2[data-v-ce5e9132] {
            margin-left: 85% !important
        }

        .list-unstyled[data-v-ce5e9132] {
            margin-bottom: 7%
        }

        .card-footer[data-v-ce5e9132] {
            height: 7rem
        }

        .card-body[data-v-ce5e9132] {
            height: 8rem
        }
    }

    @media screen and (min-width: 992px) {
        #topsearch p[data-v-ce5e9132], .btn-top-search[data-v-ce5e9132] {
            font-size: 1rem
        }

        .card-title[data-v-ce5e9132] {
            margin-bottom: 2px;
            height: 3.5rem
        }

        .programas[data-v-ce5e9132] {
            height: 7rem
        }

        .carousel-indicators li[data-v-ce5e9132] {
            height: 15px;
            width: 15px
        }

        #topsearch[data-v-ce5e9132] {
            bottom: 30px
        }

        .btn-top-search[data-v-ce5e9132] {
            padding: 5px 15px
        }

        .card-gob .list-unstyled[data-v-ce5e9132] {
            height: 6.7rem
        }

        .categorias .card-gob[data-v-ce5e9132] {
            height: 300px !important
        }

        .next2[data-v-ce5e9132], .prev2[data-v-ce5e9132] {
            height: 2.5rem !important;
            margin-top: -4.5% !important
        }

        .prev2[data-v-ce5e9132] {
            margin-left: 89% !important
        }

        .card-footer[data-v-ce5e9132] {
            height: 8rem
        }
    }

    @media screen and (min-width: 1200px) {
        .categorias .card-gob[data-v-ce5e9132] {
            height: 300px !important
        }

        .programas[data-v-ce5e9132] {
            height: 5.4rem
        }

        .card-body[data-v-ce5e9132] {
            height: 6.5rem
        }

        .card-footer[data-v-ce5e9132] {
            height: 9rem
        }

        .card-title[data-v-ce5e9132] {
            margin-bottom: 2px;
            height: 3rem
        }

        .card-gob .list-unstyled[data-v-ce5e9132] {
            height: 6rem
        }

        .prev2[data-v-ce5e9132] {
            margin-left: 91% !important
        }
    }

    @media screen and (min-width: 1391px) {
        .categorias .card-gob[data-v-ce5e9132] {
            height: 280px !important
        }

        .card-title[data-v-ce5e9132] {
            margin-bottom: 2px;
            height: 2.3rem
        }

        .card-gob .list-unstyled[data-v-ce5e9132] {
            height: 5.2rem
        }
    }

    @media screen and (min-width: 1600px) {
        .container[data-v-ce5e9132] {
            max-width: 5000px !important;
            width: 80% !important
        }

        .card-footer[data-v-ce5e9132] {
            font-size: .75rem
        }

        .categorias .card-gob[data-v-ce5e9132] {
            height: 290px !important
        }

        .next2[data-v-ce5e9132], .prev2[data-v-ce5e9132] {
            height: 2.5rem !important;
            margin-top: -4% !important
        }
    }

    @media screen and (min-width: 1800px) {
        .container[data-v-ce5e9132] {
            max-width: 5000px !important;
            width: 80% !important
        }

        .card-footer[data-v-ce5e9132] {
            font-size: .8rem
        }

        .categorias .card-gob[data-v-ce5e9132] {
            height: 320px !important
        }

        .card-gob .list-unstyled[data-v-ce5e9132] {
            height: 5.5rem
        }

        .card-body[data-v-ce5e9132] {
            height: 6rem
        }
    }

    @media screen and (min-width: 2000px) {
        .categorias .card-gob[data-v-ce5e9132] {
            height: 325px !important
        }

        .next2[data-v-ce5e9132], .prev2[data-v-ce5e9132] {
            height: 2.5rem !important;
            margin-top: -3% !important
        }

        .prev2[data-v-ce5e9132] {
            margin-left: 93.5% !important
        }

        .categorias .card-gob[data-v-ce5e9132] {
            height: 340px !important
        }

        .card-footer[data-v-ce5e9132] {
            height: 6rem
        }
    }

    @media screen and (min-width: 2300px) {
        .categorias .card-gob[data-v-ce5e9132] {
            height: 365px !important
        }

        .card-body[data-v-ce5e9132] {
            height: 5.5rem
        }
    }

    @media screen and (min-width: 2600px) {
        .categorias .card-gob[data-v-ce5e9132] {
            height: 390px !important
        }

        .next2[data-v-ce5e9132], .prev2[data-v-ce5e9132] {
            height: 2.7rem !important;
            margin-top: -2.5% !important
        }

        .prev2[data-v-ce5e9132] {
            margin-left: 95% !important
        }

        .card-footer[data-v-ce5e9132] {
            height: 5rem
        }
    }

    @media screen and (max-width: 767px) {
        .header_padding[data-v-ce5e9132] {
            padding-top: 68.91px
        }
    }

    .prev2[data-v-ce5e9132] {
        margin-left: 89%
    }

    .next2[data-v-ce5e9132], .prev2[data-v-ce5e9132] {
        height: 2.2rem;
        background-color: #9d2449;
        margin-top: -4%;
        opacity: 1 !important
    }

    .next2[data-v-ce5e9132]:hover, .prev2[data-v-ce5e9132]:hover {
        background-color: #000
    }

    .video-container[data-v-ce5e9132] {
        top: 0;
        left: 0;
        height: auto;
        width: 100%;
        overflow: hidden
    }

    video.fillWidth[data-v-ce5e9132] {
        width: 100%
    }

    .gobierno .circle-quotes {
        text-align: center;
        width: 230px;
        height: 230px;
    }

    .gobierno .circle-quotes h2 {
        font-size: 70px;
        font-weight: 900;
        text-indent: 0;
    }

    .gobierno .circle-quotes a:hover {
        color: rgb(169, 169, 169);
        transition: color 0.15s ease-in-out;
    }

    .gobierno .circle-quotes a {
        color: rgb(56, 56, 56);
        text-decoration: none;
    }

    a[data-v-2e10a77a]:link {
        text-decoration: none;
        color: #fff !important
    }

    a[data-v-2e10a77a]:hover {
        text-decoration: underline;
        color: #38a2f9 !important
    }

    a[data-v-2e10a77a]:visited {
        text-decoration: none;
        color: #fff !important
    }

    .panel-footer[data-v-2e10a77a] {
        font-family: Montserrat;
        font-size: 85%;
        color: #fff;
        line-height: 135%;
        background-image: url(https://framework-gb.cdn.gob.mx/landing/img/fondofooter.svg);
        height: auto;
        background-size: cover
    }

    #division[data-v-2e10a77a] {
        margin-top: 25%
    }

    #mail[data-v-2e10a77a] {
        margin-top: -6%
    }

    @media only screen and (max-width: 600px) {
        #division[data-v-2e10a77a] {
            margin-top: 5%
        }

        .logo_footer[data-v-2e10a77a] {
            width: 75%;
            margin-top: 25% !important;
            margin-left: 0 !important;
            padding-left: 0;
            -ms-flex-line-pack: center;
            align-content: center
        }

        #redes[data-v-2e10a77a] {
            margin-top: 10% !important
        }

        #mail[data-v-2e10a77a] {
            line-height: 300%
        }
    }

    @media screen and (min-width: 1600px) {
        .container[data-v-2e10a77a] {
            max-width: 5000px !important;
            width: 80% !important
        }
    }

    @media only screen and (min-width: 768px) and (max-width: 1024px) {
        #mail[data-v-2e10a77a] {
            font-size: 81%
        }
    }

    #global[data-v-66178b5d] {
        font-family: Montserrat
    }

    a[data-v-66178b5d]:visited {
        color: #000
    }

    .full-width-image[data-v-66178b5d] {
        width: 100vw;
        position: relative;
        left: 50%;
        margin-left: -50vw
    }

    .full-width-image img[data-v-66178b5d] {
        width: 100%
    }

    .image_hidden[data-v-66178b5d] {
        display: none
    }

    .menu-sticky[data-v-66178b5d] {
        position: -webkit-sticky;
        position: sticky;
        top: 80px
    }

    .showcase2[data-v-66178b5d] {
        padding: 0;
        margin: 0
    }

    .t_categoria[data-v-66178b5d] {
        position: absolute
    }

    .Absolute-Center[data-v-66178b5d] {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        text-align: center
    }

    .titulo_header[data-v-66178b5d] {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        width: 80%;
        height: 36%
    }

    #btn-buscar[data-v-66178b5d] {
        background-color: #b38e5d;
        border: none;
        border-radius: 0;
        width: 20%
    }

    .widht100[data-v-66178b5d] {
        width: 100%
    }

    #btn-buscar[data-v-66178b5d]:hover {
        background-color: #d4c19c
    }

    #buscador[data-v-66178b5d] {
        border: #b38e5d;
        border-radius: 0;
        width: 80%
    }

    #btnenlinea[data-v-66178b5d] {
        background-color: #9d2449;
        border: none;
        border-radius: 0;
        font-size: 70%
    }

    #btnenlinea[data-v-66178b5d]:hover {
        background-color: #621132
    }

    #btnenlinea[data-v-66178b5d]:active {
        color: #fff
    }

    .btnenlinea[data-v-66178b5d] {
        background-color: #9d2449;
        border: none;
        border-radius: 0;
        font-size: 70%
    }

    .btnenlinea[data-v-66178b5d]:hover {
        background-color: #621132
    }

    .btnenlinea[data-v-66178b5d]:active {
        color: #fff
    }

    #v-pills-tab[data-v-66178b5d] {
        background-color: #e6e6e6;
        font-weight: 700
    }

    .div_titulo_boton[data-v-66178b5d] {
        padding-left: 0
    }

    .menu[data-v-66178b5d] {
        background-color: #ccc;
        color: #3a3a3a;
        padding: 4px;
        border-radius: 1px;
        border-top: 1.5px solid #fff;
        border-bottom: 1.5px solid #fff;
        border-right: none;
        text-align: left;
        font-size: 14px
    }

    .menu[data-v-66178b5d]:focus {
        background-color: #9d2449;
        color: #fff;
        border-top: 3px solid #fff
    }

    .prueba[data-v-66178b5d] {
        background-color: #9d2449 !important;
        color: #fff;
        border: none
    }

    .cat[data-v-66178b5d] {
        color: #fff
    }

    .sub_cat[data-v-66178b5d] {
        padding-left: 10px;
        font-size: 14px
    }

    .titulo_tramite[data-v-66178b5d] {
        font-size: 1.3rem
    }

    .titulo_tramite a[data-v-66178b5d]:hover {
        color: #006fdd;
        text-decoration: underline
    }

    .texto_tramite[data-v-66178b5d] {
        font-size: 14px
    }

    .categorias-piso1[data-v-66178b5d] {
        margin-top: 20px
    }

    .texto_imagen[data-v-66178b5d] {
        text-align: center;
        color: #fff;
        width: 100%;
        text-shadow: 2.5px 2.5px 1px #000
    }

    .image_header[data-v-66178b5d] {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 100%
    }

    .mx-auto[data-v-66178b5d] {
        font-size: 90%
    }

    .texto_imagen[data-v-66178b5d] {
        font-size: 80%
    }

    @media only screen and (min-width: 450px) {
        .texto_imagen[data-v-66178b5d] {
            font-size: 70%
        }

        #btn-buscar[data-v-66178b5d] {
            width: 30%;
            height: 70%;
            font-size: 9px
        }

        #buscador[data-v-66178b5d] {
            width: 70%;
            height: 70%;
            font-size: 7px
        }

        .encabezado[data-v-66178b5d] {
            padding: 0;
            margin: 0
        }
    }

    @media only screen and (min-width: 0px) {
        .texto_categorias[data-v-66178b5d] {
            font-size: 10px
        }
    }

    @media only screen and (min-width: 400px) {
        .titulo_tramite[data-v-66178b5d] {
            font-size: 21px
        }

        .columna_tramites[data-v-66178b5d] {
            width: 100% !important
        }

        .div_titulo_boton[data-v-66178b5d] {
            width: 100%
        }

        .texto_tramite[data-v-66178b5d] {
            margin-bottom: 0;
            padding-bottom: 0 xp
        }

        .dropdown-menu[data-v-66178b5d] {
            font-size: .85rem
        }

        .texto_categorias[data-v-66178b5d] {
            font-size: 12px
        }
    }

    @media only screen and (min-width: 600px) {
        .texto_imagen[data-v-66178b5d] {
            font-size: 100%
        }

        #btn-buscar[data-v-66178b5d] {
            width: 30%;
            height: 70%;
            font-size: 9px
        }

        #buscador[data-v-66178b5d] {
            width: 70%;
            height: 70%;
            font-size: 9px
        }

        .titulo_header[data-v-66178b5d] {
            height: 82%
        }
    }

    @media only screen and (min-width: 0px) {
        .texto_imagen[data-v-66178b5d] {
            font-size: 48%
        }

        #btn-buscar[data-v-66178b5d] {
            width: 30%;
            height: 80%;
            font-size: 11px;
            line-height: 0
        }

        #buscador[data-v-66178b5d] {
            width: 70%;
            height: 80%;
            font-size: 11px
        }

        #btnenlinea[data-v-66178b5d] {
            margin-bottom: 5%
        }

        .encabezado nav[data-v-66178b5d] {
            padding: 0;
            margin: 0
        }

        .texto_imagen[data-v-66178b5d] {
            margin-top: -10%;
            font-size: 110%
        }

        .texto_categorias[data-v-66178b5d] {
            font-size: 14px
        }
    }

    @media only screen and (min-width: 1000px) {
        .texto_categorias[data-v-66178b5d] {
            font-size: 16px
        }
    }

    @media only screen and (min-width: 450px) {
        .texto_imagen[data-v-66178b5d] {
            font-size: 140%
        }

        #btn-buscar[data-v-66178b5d] {
            width: 30%;
            height: 80%;
            font-size: .7em
        }

        #buscador[data-v-66178b5d] {
            width: 70%;
            height: 80%;
            font-size: .7em
        }

        .encabezado[data-v-66178b5d] {
            padding: 0;
            margin: 0
        }
    }

    @media only screen and (min-width: 600px) {
        .texto_imagen[data-v-66178b5d] {
            font-size: 120%;
            margin-top: 5.5%
        }

        #btn-buscar[data-v-66178b5d] {
            width: 20%;
            height: 80%;
            font-size: .9em
        }

        #buscador[data-v-66178b5d] {
            width: 80%;
            height: 80%;
            font-size: .9em
        }
    }

    @media only screen and (min-width: 800px) {
        .texto_imagen[data-v-66178b5d] {
            font-size: 135%;
            margin-top: 5%
        }

        #btn-buscar[data-v-66178b5d] {
            width: 15%;
            height: 65%;
            font-size: 11px
        }

        #buscador[data-v-66178b5d] {
            width: 85%;
            height: 65%;
            font-size: 11px
        }
    }

    @media screen and (min-width: 950px) {
        .texto_imagen[data-v-66178b5d] {
            font-size: 150%
        }

        .colapsable[data-v-66178b5d] {
            display: none
        }

        #btn-buscar[data-v-66178b5d] {
            width: 20%;
            height: 70%;
            font-size: 13px
        }

        #buscador[data-v-66178b5d] {
            width: 80%;
            height: 70%;
            font-size: 13px
        }

        .widht100[data-v-66178b5d] {
            width: 80%
        }
    }

    @media screen and (min-width: 1300px) {
        .texto_imagen[data-v-66178b5d] {
            font-size: 200%
        }

        #btn-buscar[data-v-66178b5d] {
            width: 20%;
            height: 70%;
            font-size: 16px
        }

        #buscador[data-v-66178b5d] {
            width: 80%;
            height: 70%;
            font-size: 16px
        }
    }

    .progress-bar[data-v-66178b5d] {
        background-color: #9d2449
    }

    .progress[data-v-66178b5d] {
        height: .3em
    }

    .dropdown-menu.dropdown-menu-wide[data-v-66178b5d] {
        min-width: 100%;
        text-align: center
    }

    .boton_seleccion[data-v-66178b5d] {
        width: 100%
    }

    .carga_pagina[data-v-66178b5d] {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 120px;
        height: 120px
    }

    @-webkit-keyframes spin-data-v-66178b5d {
        to {
            -webkit-transform: rotate(1turn)
        }
    }

    @keyframes spin-data-v-66178b5d {
        to {
            -webkit-transform: rotate(1turn);
            transform: rotate(1turn)
        }
    }

    .paginacion li[data-v-66178b5d] {
        border: 0 solid #dee2e6 !important
    }

    .paginacion li a[data-v-66178b5d] {
        border: 1px solid #dee2e6 !important;
        border-radius: 0 !important
    }

    .paginacion li a.active[data-v-66178b5d] {
        color: #0056b3 !important;
        background-color: #ddd !important;
        border-radius: 0 !important
    }

    .nav-item[data-v-66178b5d] {
        background-color: #f2f4f8 !important;
        color: #3a3a3a !important
    }

    .consulta_requisitos[data-v-66178b5d] {
        text-align: center;
        font-size: 14px;
        padding: 0;
        margin: 0;
        text-decoration: underline !important;
        color: #7b9cf0 !important
    }

    .consulta_requisitos[data-v-66178b5d]:hover, .nav-link.active[data-v-66178b5d] {
        color: #12c !important
    }

    .btn.focus[data-v-66178b5d], .btn[data-v-66178b5d]:focus, [data-v-66178b5d]:focus {
        outline: 0 !important;
        -webkit-box-shadow: 0 0 0 0 #ff0 !important;
        box-shadow: 0 0 0 0 #ff0 !important
    }

    .subrayado[data-v-66178b5d] {
        text-decoration: underline
    }

    @media screen and (min-width: 0px) {
        .header_padding[data-v-66178b5d] {
            padding-top: 68.91px
        }
    }

    @media screen and (min-width: 576px) {
        .header_padding[data-v-66178b5d] {
            padding-top: 46.39px
        }
    }

    @media screen and (min-width: 768px) {
        .header_padding[data-v-66178b5d] {
            padding-top: 48px
        }
    }

    .scrollable-menu[data-v-66178b5d] {
        height: auto;
        max-height: 300px;
        overflow-x: hidden
    }

    .lista_dependencias[data-v-66178b5d]:focus {
        background-color: #d4c19c
    }

    .lista_dependencias[data-v-66178b5d]:active {
        background-color: #d4c19c !important
    }

    .lista_dependencias.active[data-v-66178b5d] {
        background-color: #d4c19c !important;
        color: #fff !important
    }

    @media screen and (max-width: 767px) {
        .espacio_dependencias[data-v-66178b5d] {
            display: none
        }
    }

    @media screen and (min-width: 768px) {
        .espacio_tramites_titulo[data-v-66178b5d] {
            display: none
        }
    }

    .search_dependencia[data-v-66178b5d] {
        border: 0 solid #000 !important;
        border: 1px solid
    }

    .search_dependencia[data-v-66178b5d], .search_dependencia[data-v-66178b5d]:focus {
        outline: 0 !important;
        -webkit-box-shadow: 0 0 0 0 rgba(38, 143, 255, .5) !important;
        box-shadow: 0 0 0 0 rgba(38, 143, 255, .5) !important
    }

    .search_dependencia[data-v-66178b5d]:focus {
        border: 0 solid #000 !important
    }

    .search_dependencia[data-v-66178b5d]:hover {
        outline: 0 !important;
        border: 0 solid #000 !important;
        -webkit-box-shadow: 0 0 0 0 rgba(38, 143, 255, .5) !important;
        box-shadow: 0 0 0 0 rgba(38, 143, 255, .5) !important
    }

    .dropdown-toggle[data-v-66178b5d] {
        margin-left: -.745em !important
    }

    .dropdown-item[data-v-66178b5d] {
        white-space: normal !important
    }

    .boton_en_linea[data-v-66178b5d], .boton_en_linea[data-v-66178b5d]:focus, .boton_en_linea[data-v-66178b5d]:hover {
        text-decoration: none !important
    }

    @media only screen and (min-width: 577px) {
        .botones_busqueda[data-v-66178b5d] {
            display: none
        }
    }

    @media only screen and (max-width: 576px) {
        .escritorio[data-v-66178b5d] {
            display: none
        }
    }

    @media only screen and (max-width: 767px) and (min-width: 577px) {
        .menu_izquierdo[data-v-66178b5d] {
            overflow: auto
        }

        [data-v-66178b5d]::-webkit-scrollbar {
            width: 5px
        }

        [data-v-66178b5d]::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 5px grey;
            box-shadow: inset 0 0 5px grey;
            border-radius: 10px
        }

        [data-v-66178b5d]::-webkit-scrollbar-thumb {
            background: grey;
            border-radius: 10px
        }

        [data-v-66178b5d]::-webkit-scrollbar-thumb:hover {
            background: grey
        }
    }

    .texto_categorias.active[data-v-66178b5d] {
        font-weight: 700
    }

    .filters {
        cursor: pointer;
    }

    .filters:hover {
        background-color: #9d2449;
        color: #fff;
        border-top: 3px solid #fff;
    }

    .ods {
        width: 125px;
        margin-bottom: 5px;
        cursor: pointer;
    }

    .icon_operation {
        width: 40px;
        margin-right: 5px;
        cursor: pointer;
    }

    /* Estilos Adrian Nuñez Alanis  */
    .first {
        width: 100%;
        height: 35px;
        border: 1px solid #13322B;
        border-radius: 4px;
        padding: 7px;
        background: white;
        color: black;
        cursor: pointer;
        text-align: left;
        font-size: 0.8em;
    }

    .first:hover {
        background: #13322B;
        color: white;
    }

    .firstClik {
        background: #13322B;
        color: white;
    }

    .firstSearch {
        background: #449d44;
        color: white;
    }

    #modalFilter {
        width: 95% !important;
    }

    .modalFilter {
        margin: 0px auto !important;
        top: 70px !important;
    }


    ul, #myUL {
        list-style-type: none;
    }

    #myUL {
        margin: 0;
        padding: 0;
    }

    .box {
        cursor: pointer;
        -webkit-user-select: none; /* Safari 3.1+ */
        -moz-user-select: none; /* Firefox 2+ */
        -ms-user-select: none; /* IE 10+ */
        user-select: none;
    }

    .box::before {
        content: "\2610";
        color: black;
        display: inline-block;
        margin-right: 6px;
    }

    .check-box::before {
        content: "\2611";
        color: dodgerblue;
    }

    .nested {
        display: none;
    }

    .active {
        display: block;
    }

























/* Content wrapper */
	.content-wrapper {
		height: 100%;
		background-image: url(/img/sre_white.png);

		background-repeat: no-repeat;
		background-size: cover;
		width: 100% !important;

	}

	.header-title-home {
		font-size: 14px;
		color: rgb(255, 255, 255);
		margin-top: 15px;
	}

	.el-button {
		border-bottom-right-radius: 0px;
		border-bottom-left-radius: 0px;
		border-bottom: none;
		box-shadow: none;
		font-weight: bold;
	}

	.logo-sre2 {
		/*background: url(/img/SRE_HORIZONTAL_FCFT.png) no-repeat;*/
		background-size: contain;
		height: 40px;
		width: 100px;
		overflow: hidden;
		margin-top: 10px;
		margin-left: 5px;
	}

	.bannerMain {
		/*background-image:url('/img/login/sre_white.png');*/
		background-repeat: no-repeat;
		background-size: cover;
		width: 100% !important;
	}

	@media screen and ( min-height: 768px ) {
		/* Content */
		.el-container {
			height: 768px
		}
	}

	@media screen and ( min-height: 896px ) {
		/* Content */
		.el-container {
			height: 896px
		}
	}

	@media screen and ( min-height: 912px ) {
		/* Content */
		.el-container {
			height: 912px
		}
	}

	@media screen and ( min-height: 1024px ) {
		/* Content */
		.el-container {
			height: 1024px
		}
	}

	@media screen and ( min-height: 1180px ) {
		/* Content */
		.el-container {
			height: 1180px
		}
	}

	@media screen and ( min-height: 1280px ) {
		/* Content */
		.el-container {
			height: 1280px
		}
	}

	.el-menu-item {

		border-bottom: none !important;
	}

	.el-menu-item:focus, .el-menu-item:hover {
		outline: 0;
		background-color: rgba(0, 0, 0, 0.2) !important;
	}

	.el-menu-item.border-menu-item.is-active {
		border-color: rgba(0, 0, 0, 0.1) !important;
	}

	.wabble-effect:nth-child(2n) {
		animation: keyframes1;
		animation-iteration-count: infinite;
		transform-origin: 50% 10%;
		animation-delay: -0.75s;
		animation-duration: .25s
	}

	.wabble-effect:nth-child(2n-1) {
		animation-name: keyframes2;
		animation-iteration-count: infinite;
		animation-direction: alternate;
		transform-origin: 30% 5%;
		animation-delay: -0.75s;
		animation-duration: .25s
	}

	@keyframes keyframes1 {
		0% {
			transform: rotate(-1deg);
			animation-timing-function: ease-in;
		}
		50% {
			transform: rotate(1.5deg);
			animation-timing-function: ease-out;
		}
	}

	@keyframes keyframes2 {
		0% {
			transform: rotate(1deg);
			animation-timing-function: ease-in;
		}
		50% {
			transform: rotate(-1.5deg);
			animation-timing-function: ease-out;
		}
	}



	/*//Animatae*/

	.blur {
		background: #fff;
		-webkit-filter: blur(5px);
		-moz-filter: blur(5px);
		-o-filter: blur(5px);
		-ms-filter: blur(5px);
		filter: blur(5px);
	}

	.custom-splash {
		position: absolute;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;

		z-index: 9999;

	}

	#splash_cont {
		background: rgba(255, 255, 255, 0.52);
		position: relative;
		z-index: 9999999;
	}

	#splash_cont.animate {

		height: 400px;
		width: 400px;
		position: relative;
		border-radius: 50%;
		margin: 0 auto;
		top: 45%;
		-webkit-transform: translateY(-50%);
		transform: translateY(-50%);
		-webkit-animation: move-ruby 0.7s ease 2.4s forwards;
		animation: move-ruby 0.7s ease 2.4s forwards;
	}

	#splash_cont.animate #ruby {
		position: absolute;
		top: 125px;
		left: 64.5px;
		-webkit-transform: scale(0);
		transform: scale(0);
		-webkit-animation: scale-ruby 0.48s ease 0s forwards;
		animation: scale-ruby 0.48s ease 0s forwards;
	}

	#splash_cont.animate .circle {
		fill: rgba(254, 82, 79, 0);
		stroke: rgba(254, 82, 79, 0);
		stroke-width: 4;
		stroke-dasharray: 1228;
		stroke-dashoffset: 0;
		-webkit-transform-origin: 50% 50%;
		transform-origin: 50% 50%;
		-webkit-transform: rotate(-90deg);
		transform: rotate(-90deg);
		-webkit-animation: animate-ruby-circle 1.3s ease 0.3s forwards;
		animation: animate-ruby-circle 1.3s ease 0.3s forwards;
	}

	#splash_cont.animate #splash_title {
		text-align: center;
		font-weight: 500;
		font-size: 1.75em;
		color: rgba(80, 80, 80, 0);
		-webkit-animation: splash_title 1.2s ease 1.2s forwards;
		animation: splash_title 1.2s ease 1.2s forwards;
		position: absolute;
		bottom: 0;
		left: 0;
		width: 100%;
		-webkit-transform: translateY(150%);
		transform: translateY(150%);
	}

	@-webkit-keyframes scale-ruby {
		0% {
			-webkit-transform: scale(0);
			transform: scale(0);
			top: 125px;
		}
		60% {
			-webkit-transform: scale(1.25);
			transform: scale(1.25);
			top: 120px;
		}
		100% {
			-webkit-transform: scale(1);
			transform: scale(1);
			top: 125px;
		}
	}

	@keyframes scale-ruby {
		0% {
			-webkit-transform: scale(0);
			transform: scale(0);
			top: 125px;
		}
		60% {
			-webkit-transform: scale(1.25);
			transform: scale(1.25);
			top: 120px;
		}
		100% {
			-webkit-transform: scale(1);
			transform: scale(1);
			top: 125px;
		}
	}

	@-webkit-keyframes animate-ruby-circle {
		0% {
			stroke-dashoffset: 1228;
			stroke: #dfcdb2;
		}
		70% {
			stroke: #c9af8d;
			stroke-width: 4;
		}
		90% {
			stroke-dashoffset: 0;
		}
		100% {
			stroke-dashoffset: 0;
			stroke: #dec4a1;
			stroke-width: 10;
		}
	}

	@keyframes animate-ruby-circle {
		0% {
			stroke-dashoffset: 1228;
			stroke: #dfcdb2;
		}
		70% {
			stroke: #c9af8d;
			stroke-width: 4;
		}
		90% {
			stroke-dashoffset: 0;
		}
		100% {
			stroke-dashoffset: 0;
			stroke: #dec4a1;
			stroke-width: 10;
		}
	}

	@-webkit-keyframes splash_title {
		0% {
			color: rgba(80, 80, 80, 0);
		}
		18% {
			color: #505050;
		}
		65% {
			color: #505050;
		}
		100% {
			color: rgba(80, 80, 80, 0);
		}
	}

	@keyframes splash_title {
		0% {
			color: rgba(80, 80, 80, 0);
		}
		18% {
			color: #505050;
		}
		65% {
			color: #505050;
		}
		100% {
			color: rgba(80, 80, 80, 0);
		}
	}

	@-webkit-keyframes move-ruby {
		0% {
			opacity: 1;
			top: 45%;
			-webkit-transform: scale(1) translateY(-50%);
			transform: scale(1) translateY(-50%);
		}
		20% {
			opacity: 1;
		}
		100% {
			opacity: 0;
			top: 35%;
			-webkit-transform: scale(0.01) translateY(-280%);
			transform: scale(0.01) translateY(-280%);
		}
	}

	@keyframes move-ruby {
		0% {
			opacity: 1;
			top: 45%;
			-webkit-transform: scale(1) translateY(-50%);
			transform: scale(1) translateY(-50%);
		}
		20% {
			opacity: 1;
		}
		100% {
			opacity: 0;
			top: 35%;
			-webkit-transform: scale(0.01) translateY(-280%);
			transform: scale(0.01) translateY(-280%);
		}
	}




</style>
