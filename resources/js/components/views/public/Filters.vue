<template>
<!-- style="padding: 20px 10px;" -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Filtros</h2>
            <hr class="red small-margin">
        </div>
        <div class="col-md-12">
             <span class="glyphicon glyphicon-list-alt" ></span> Total: 4
        </div>
        <div class="col-md-12">
           <div class="row">
                <div v-for="(item,index) in names" :key="index" class="col-md-2">
                    <h5 v-text="item.label"></h5>
                    <ul>
                        <li v-for="(i, indexx) in changeNamesValues(item)" :key="indexx">
                            <span v-if="item.id === 0" v-text="i.year"></span>
                            <span v-else v-text="i.name"></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <button class="pull-right btn btn-info btn-xs" @click="loadPdf()">
                PDF <span class="glyphicon glyphicon glyphicon-file" aria-hidden="true"></span>
            </button>
            <button class="pull-right btn btn-success btn-xs" @click="loadExcel()">
                EXCEL <span class="glyphicon glyphicon glyphicon-file" aria-hidden="true"></span>
            </button>
            <button class="pull-right btn btn-info btn-xs" @click="loadWord()">
                WORD <span class="glyphicon glyphicon glyphicon-file" aria-hidden="true"></span>
            </button>
        </div>
        <div class="col-md-12" v-for="(item,index) in texto" :key="index">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Titulo de la recomendación
                    <div class="pull-right">
                        <span style="float: left; padding-right: 20px;">
                            <span class="icon-calendar" aria-hidden="true"></span> 12/12/2019 &nbsp; &nbsp;
                        </span>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                          <span v-text="showString(item.txt,index,true)"></span> <button @click="btnshow(item.txt, index
                          )">+</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 pull-right" style="padding: 20px;">
            <router-link :to="{ name:'PublicHome' }" >
                <button class="btn btn-success pull-right btn-sm" type="button">
                    Regresar <span class="glyphicon glyphicon glyphicon-share-alt" aria-hidden="true"></span>
                </button>
            </router-link>
        </div>
    </div>
</div>
</template>

<script>
   // import PublicoRecomendaciones from '@/components/views/public/Index.vue';

   export default {
      data(){
         return {
           json:[],
           check:[],
           names:[],
           jsonTxt:[],
           texto:[{txt: '1 texto agregado ... Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt nisi dolores, omnis dicta distinctio possimus illo nulla totam magnam. Deleniti porro officia suscipit repudiandae, blanditiis magnam ipsam est culpa qLorem ipsum dolor sit, amet consectetur adipisicing elit. Doloremque voluptatem eum non, error nihil repellendus commodi, velit mollitia, quas ut dolores omnis cupiditate praesentium neque perspiciatis libero ex id consequatur? Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga dicta provident, corrupti quis, non doloribus omnis id nobis expedita explicabo error beatae excepturi asperiores quos ex vitae laboriosam, eveniet consequuntur.'},
                  {txt: '2 texto agregado ... Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt nisi dolores, omnis dicta distinctio possimus illo nulla totam magnam. Deleniti porro officia suscipit repudiandae, blanditiis magnam ipsam est culpa qLorem ipsum dolor sit, amet consectetur adipisicing elit. Doloremque voluptatem eum non, error nihil repellendus commodi, velit mollitia, quas ut dolores omnis cupiditate praesentium neque perspiciatis libero ex id consequatur? Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga dicta provident, corrupti quis, non doloribus omnis id nobis expedita explicabo error beatae excepturi asperiores quos ex vitae laboriosam, eveniet consequuntur.'}],

         }
      },
      methods:{
       btnshow(string,index){
           let me = this;
           let buscar = me.jsonTxt.find(item.id === index);

           if(buscar){



           }else{
               console.error("error");
           }



       },
       showString(string,index,bool){
        let me = this;
        let buscar =  me.jsonTxt.find(item => {  return item.id === index });

         if(buscar){

           if(buscar.show === true){
               return buscar.text.substr(0,160);
           }else{
               return buscar.original;
           }


         }else{
            me.jsonTxt.push({id: index, text:string, show: bool, original: string});
            return string.substr(0,160);
         }
       },
       changeNamesValues(value){
        let me = this;
        if(value.id === 0){
          return value.data;
        }else{
           console.log("ARREGLO: ",value);

           let data = [];

           for (let i = 0; i < value.data.length; i++){
             console.log("ID:",value.data[i].id);
             console.log("name:",value.data[i].name);




           }


           console.log("DATA: ",me.check);

           return data;

        }


       },
       loadPdf(){
           let me = this;
           console.log("descarga pdf..");
           window.open('/api/public/listarPdf','_blank');
       },
       loadExcel(){
           let me = this;
           window.open('/api/public/listarExcel','_blank');
       },
       loadWord(){
           let me = this;
          // alert("Estas descargando el documento de word...");
           window.open('/api/public/listarWord','_blank');
       }
      },
        computed: {
        },
        created(){
        },
        computed:{
        },
        mounted(){
            let me = this;
                me.json = me.$route.params.json;

               console.log("JSON FILTER: ",me.json);


                me.check= me.json.check;
                me.names = me.json.names;
                me.names = me.names.filter(item => {
                    return item.label != "Buscar Recomendación";
                });

                console.log("CHEKS: ",me.check);

           // console.log("ARREGLO SELECCIONADOS: ",me.json);
        }
    }
</script>

<style scoped>
.sub_banner{
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
    border: 1px solid rgba(0,0,0,.125);
    border-radius: .25rem;
}
a[data-v-2e10a77a]:link{text-decoration:none;color:#fff!important}a[data-v-2e10a77a]:hover{text-decoration:underline;color:#38a2f9!important}a[data-v-2e10a77a]:visited{text-decoration:none;color:#fff!important}.panel-footer[data-v-2e10a77a]{font-family:Montserrat;font-size:85%;color:#fff;line-height:135%;background-image:url(https://framework-gb.cdn.gob.mx/landing/img/fondofooter.svg);height:auto;background-size:cover}#division[data-v-2e10a77a]{margin-top:25%}#mail[data-v-2e10a77a]{margin-top:-6%}@media only screen and (max-width:600px){#division[data-v-2e10a77a]{margin-top:5%}.logo_footer[data-v-2e10a77a]{width:75%;margin-top:25%!important;margin-left:0!important;padding-left:0;-ms-flex-line-pack:center;align-content:center}#redes[data-v-2e10a77a]{margin-top:10%!important}#mail[data-v-2e10a77a]{line-height:300%}}@media screen and (min-width:1600px){.container[data-v-2e10a77a]{max-width:5000px!important;width:80%!important}}@media only screen and (min-width:768px) and (max-width:1024px){#mail[data-v-2e10a77a]{font-size:81%}}[data-v-ce5e9132]:focus{-webkit-box-shadow:0 0 0 0 #000!important;box-shadow:0 0 0 0 #000!important}.global[data-v-ce5e9132]{font-family:Montserrat,sans-serif;margin-bottom:3rem}.dorado[data-v-ce5e9132]{color:#b38e5d}.doradoclaro[data-v-ce5e9132]{color:#d4c19c}.elemento-oculto[data-v-ce5e9132]{position:absolute!important;clip:rect(1px 1px 1px 1px);clip:rect(1px,1px,1px,1px)}#carouselMainGobmxHead[data-v-ce5e9132]{position:relative}.carousel-indicators[data-v-ce5e9132]{margin:3px}.carousel-indicators li[data-v-ce5e9132]{background-color:#9d2449;height:10px;width:10px;border-radius:50%;border:1px solid #fff;margin-bottom:5px}.carousel-control-next[data-v-ce5e9132],.carousel-control-prev[data-v-ce5e9132]{width:5%}#topsearch[data-v-ce5e9132]{color:#fff;position:absolute;bottom:20px;z-index:50}#topsearch p[data-v-ce5e9132]{margin:2px;font-size:20px!important;text-shadow:2.5px 2.5px 5px #000}#topsearch a[data-v-ce5e9132]:hover{background-color:#b38e5d;text-decoration:none;color:#fff}#topsearch a[data-v-ce5e9132]{margin-bottom:4px}#masbuscados[data-v-ce5e9132]{position:absolute}.btn-top-search[data-v-ce5e9132]{color:#fff;background-color:#000;border:0;padding:5px 7px;font-size:.7rem;margin-right:.25rem}.card-gob .list-unstyled[data-v-ce5e9132]{height:5.2rem}.card-img-gob[data-v-ce5e9132]{width:30%;margin-left:auto;margin-right:auto;padding-bottom:0;margin-top:5%}.card-body[data-v-ce5e9132]{padding-top:2px;padding-bottom:2px}.card-carousel a[data-v-ce5e9132]:visited{color:#212529}.card-footer[data-v-ce5e9132]{font-size:11px;color:#fff;background-color:#285c4d;height:8rem}.footerverde[data-v-ce5e9132]{background-color:#621132}.card-title[data-v-ce5e9132]{margin-bottom:2px;height:2.3rem}.card-gob[data-v-ce5e9132]{margin-bottom:2rem}.card-gob h4[data-v-ce5e9132]{font-weight:900;font-size:1rem}.card-img-top[data-v-ce5e9132]{margin-bottom:3%}.programas[data-v-ce5e9132]{height:5.4rem}.programastab[data-v-ce5e9132]{height:6.5rem}.programascel[data-v-ce5e9132]{height:6.2rem}.card-gob[data-v-ce5e9132]:hover{-webkit-box-shadow:0 5px 8px 0 #d1d1d1;box-shadow:0 5px 8px 0 #d1d1d1}.card-gob p a[data-v-ce5e9132],.card-gob ul a[data-v-ce5e9132]{text-decoration:none;color:#706f6f}.card-gob a[data-v-ce5e9132]:hover{text-decoration:underline;color:#000}.titulocategoria a[data-v-ce5e9132]:visited{text-decoration:none;color:#000}.card-title a[data-v-ce5e9132]:visited{text-decoration:none}.card-body a[data-v-ce5e9132]:hover,.card-gob p a[data-v-ce5e9132]:hover,.card-gob ul a[data-v-ce5e9132]:hover{text-decoration:underline;color:#706f6f}.card-title a[data-v-ce5e9132]:hover,.card-title a[data-v-ce5e9132]:visited{text-decoration:underline;color:#000}.btn-categorias[data-v-ce5e9132]{color:#fff!important;background-color:#9d2449;border:0;padding:5px 7px;font-size:.9rem;margin-bottom:10px}.btn-categorias[data-v-ce5e9132]:hover{color:#fff!important;background-color:#000}.card-carousel[data-v-ce5e9132]{border:0;margin-bottom:3rem}.categorias .card-gob[data-v-ce5e9132]{height:290px}#topsearch h2[data-v-ce5e9132]{font-size:20px}#glit[data-v-ce5e9132]{position:relative;margin-top:2.8rem;margin-bottom:3.7rem}#line[data-v-ce5e9132]{position:absolute;background-color:#b38e5d;bottom:-10px;width:35px;height:5px}#glit h3[data-v-ce5e9132]{font-weight:400;color:#706f6f}@media screen and (min-width:320px){.next2[data-v-ce5e9132],.prev2[data-v-ce5e9132]{height:2rem!important;width:3rem;margin-top:-12%!important}.prev2[data-v-ce5e9132]{margin-left:65%!important}.card-body[data-v-ce5e9132]{height:8rem}.card-footer[data-v-ce5e9132]{height:11rem}}@media screen and (min-width:340px){.categorias .card-gob[data-v-ce5e9132]{height:320px}.next2[data-v-ce5e9132],.prev2[data-v-ce5e9132]{height:2.5rem!important;margin-top:-14%!important}}@media screen and (min-width:430px){.categorias .card-gob[data-v-ce5e9132]{height:350px!important}.next2[data-v-ce5e9132],.prev2[data-v-ce5e9132]{height:2.5rem!important;margin-top:-11%!important}.prev2[data-v-ce5e9132]{margin-left:75%!important}.card-body[data-v-ce5e9132],.card-footer[data-v-ce5e9132]{height:6rem}}@media screen and (min-width:500px){.categorias .card-gob[data-v-ce5e9132]{height:370px!important}.next2[data-v-ce5e9132],.prev2[data-v-ce5e9132]{height:2.5rem!important;margin-top:-9%!important}.prev2[data-v-ce5e9132]{margin-left:79%!important}}@media screen and (min-width:576px){.header_padding[data-v-ce5e9132]{padding-top:2.5rem!important}.categorias .card-gob[data-v-ce5e9132]{height:290px!important}.list-unstyled[data-v-ce5e9132]{margin-bottom:20%}.card-footer[data-v-ce5e9132]{height:6rem}.programascel[data-v-ce5e9132]{height:4rem}}@media screen and (min-width:768px){.header_padding[data-v-ce5e9132]{padding-top:48px}.categorias .card-gob[data-v-ce5e9132]{height:310px!important}.next2[data-v-ce5e9132],.prev2[data-v-ce5e9132]{height:2.5rem!important;margin-top:-6%!important}.prev2[data-v-ce5e9132]{margin-left:85%!important}.list-unstyled[data-v-ce5e9132]{margin-bottom:7%}.card-footer[data-v-ce5e9132]{height:7rem}.card-body[data-v-ce5e9132]{height:8rem}}@media screen and (min-width:992px){#topsearch p[data-v-ce5e9132],.btn-top-search[data-v-ce5e9132]{font-size:1rem}.card-title[data-v-ce5e9132]{margin-bottom:2px;height:3.5rem}.programas[data-v-ce5e9132]{height:7rem}.carousel-indicators li[data-v-ce5e9132]{height:15px;width:15px}#topsearch[data-v-ce5e9132]{bottom:30px}.btn-top-search[data-v-ce5e9132]{padding:5px 15px}.card-gob .list-unstyled[data-v-ce5e9132]{height:6.7rem}.categorias .card-gob[data-v-ce5e9132]{height:300px!important}.next2[data-v-ce5e9132],.prev2[data-v-ce5e9132]{height:2.5rem!important;margin-top:-4.5%!important}.prev2[data-v-ce5e9132]{margin-left:89%!important}.card-footer[data-v-ce5e9132]{height:8rem}}@media screen and (min-width:1200px){.categorias .card-gob[data-v-ce5e9132]{height:300px!important}.programas[data-v-ce5e9132]{height:5.4rem}.card-body[data-v-ce5e9132]{height:6.5rem}.card-footer[data-v-ce5e9132]{height:9rem}.card-title[data-v-ce5e9132]{margin-bottom:2px;height:3rem}.card-gob .list-unstyled[data-v-ce5e9132]{height:6rem}.prev2[data-v-ce5e9132]{margin-left:91%!important}}@media screen and (min-width:1391px){.categorias .card-gob[data-v-ce5e9132]{height:280px!important}.card-title[data-v-ce5e9132]{margin-bottom:2px;height:2.3rem}.card-gob .list-unstyled[data-v-ce5e9132]{height:5.2rem}}@media screen and (min-width:1600px){.container[data-v-ce5e9132]{max-width:5000px!important;width:80%!important}.card-footer[data-v-ce5e9132]{font-size:.75rem}.categorias .card-gob[data-v-ce5e9132]{height:290px!important}.next2[data-v-ce5e9132],.prev2[data-v-ce5e9132]{height:2.5rem!important;margin-top:-4%!important}}@media screen and (min-width:1800px){.container[data-v-ce5e9132]{max-width:5000px!important;width:80%!important}.card-footer[data-v-ce5e9132]{font-size:.8rem}.categorias .card-gob[data-v-ce5e9132]{height:320px!important}.card-gob .list-unstyled[data-v-ce5e9132]{height:5.5rem}.card-body[data-v-ce5e9132]{height:6rem}}@media screen and (min-width:2000px){.categorias .card-gob[data-v-ce5e9132]{height:325px!important}.next2[data-v-ce5e9132],.prev2[data-v-ce5e9132]{height:2.5rem!important;margin-top:-3%!important}.prev2[data-v-ce5e9132]{margin-left:93.5%!important}.categorias .card-gob[data-v-ce5e9132]{height:340px!important}.card-footer[data-v-ce5e9132]{height:6rem}}@media screen and (min-width:2300px){.categorias .card-gob[data-v-ce5e9132]{height:365px!important}.card-body[data-v-ce5e9132]{height:5.5rem}}@media screen and (min-width:2600px){.categorias .card-gob[data-v-ce5e9132]{height:390px!important}.next2[data-v-ce5e9132],.prev2[data-v-ce5e9132]{height:2.7rem!important;margin-top:-2.5%!important}.prev2[data-v-ce5e9132]{margin-left:95%!important}.card-footer[data-v-ce5e9132]{height:5rem}}@media screen and (max-width:767px){.header_padding[data-v-ce5e9132]{padding-top:68.91px}}.prev2[data-v-ce5e9132]{margin-left:89%}.next2[data-v-ce5e9132],.prev2[data-v-ce5e9132]{height:2.2rem;background-color:#9d2449;margin-top:-4%;opacity:1!important}.next2[data-v-ce5e9132]:hover,.prev2[data-v-ce5e9132]:hover{background-color:#000}.video-container[data-v-ce5e9132]{top:0;left:0;height:auto;width:100%;overflow:hidden}video.fillWidth[data-v-ce5e9132]{width:100%}
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
a[data-v-2e10a77a]:link{text-decoration:none;color:#fff!important}a[data-v-2e10a77a]:hover{text-decoration:underline;color:#38a2f9!important}a[data-v-2e10a77a]:visited{text-decoration:none;color:#fff!important}.panel-footer[data-v-2e10a77a]{font-family:Montserrat;font-size:85%;color:#fff;line-height:135%;background-image:url(https://framework-gb.cdn.gob.mx/landing/img/fondofooter.svg);height:auto;background-size:cover}#division[data-v-2e10a77a]{margin-top:25%}#mail[data-v-2e10a77a]{margin-top:-6%}@media only screen and (max-width:600px){#division[data-v-2e10a77a]{margin-top:5%}.logo_footer[data-v-2e10a77a]{width:75%;margin-top:25%!important;margin-left:0!important;padding-left:0;-ms-flex-line-pack:center;align-content:center}#redes[data-v-2e10a77a]{margin-top:10%!important}#mail[data-v-2e10a77a]{line-height:300%}}@media screen and (min-width:1600px){.container[data-v-2e10a77a]{max-width:5000px!important;width:80%!important}}@media only screen and (min-width:768px) and (max-width:1024px){#mail[data-v-2e10a77a]{font-size:81%}}#global[data-v-66178b5d]{font-family:Montserrat}a[data-v-66178b5d]:visited{color:#000}.full-width-image[data-v-66178b5d]{width:100vw;position:relative;left:50%;margin-left:-50vw}.full-width-image img[data-v-66178b5d]{width:100%}.image_hidden[data-v-66178b5d]{display:none}.menu-sticky[data-v-66178b5d]{position:-webkit-sticky;position:sticky;top:80px}.showcase2[data-v-66178b5d]{padding:0;margin:0}.t_categoria[data-v-66178b5d]{position:absolute}.Absolute-Center[data-v-66178b5d]{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;text-align:center}.titulo_header[data-v-66178b5d]{position:absolute;top:0;bottom:0;left:0;right:0;margin:auto;width:80%;height:36%}#btn-buscar[data-v-66178b5d]{background-color:#b38e5d;border:none;border-radius:0;width:20%}.widht100[data-v-66178b5d]{width:100%}#btn-buscar[data-v-66178b5d]:hover{background-color:#d4c19c}#buscador[data-v-66178b5d]{border:#b38e5d;border-radius:0;width:80%}#btnenlinea[data-v-66178b5d]{background-color:#9d2449;border:none;border-radius:0;font-size:70%}#btnenlinea[data-v-66178b5d]:hover{background-color:#621132}#btnenlinea[data-v-66178b5d]:active{color:#fff}.btnenlinea[data-v-66178b5d]{background-color:#9d2449;border:none;border-radius:0;font-size:70%}.btnenlinea[data-v-66178b5d]:hover{background-color:#621132}.btnenlinea[data-v-66178b5d]:active{color:#fff}#v-pills-tab[data-v-66178b5d]{background-color:#e6e6e6;font-weight:700}.div_titulo_boton[data-v-66178b5d]{padding-left:0}.menu[data-v-66178b5d]{background-color:#ccc;color:#3a3a3a;padding:4px;border-radius:1px;border-top:1.5px solid #fff;border-bottom:1.5px solid #fff;border-right:none;text-align:left;font-size:14px}.menu[data-v-66178b5d]:focus{background-color:#9d2449;color:#fff;border-top:3px solid #fff}.prueba[data-v-66178b5d]{background-color:#9d2449!important;color:#fff;border:none}.cat[data-v-66178b5d]{color:#fff}.sub_cat[data-v-66178b5d]{padding-left:10px;font-size:14px}.titulo_tramite[data-v-66178b5d]{font-size:1.3rem}.titulo_tramite a[data-v-66178b5d]:hover{color:#006fdd;text-decoration:underline}.texto_tramite[data-v-66178b5d]{font-size:14px}.categorias-piso1[data-v-66178b5d]{margin-top:20px}.texto_imagen[data-v-66178b5d]{text-align:center;color:#fff;width:100%;text-shadow:2.5px 2.5px 1px #000}.image_header[data-v-66178b5d]{display:block;margin-left:auto;margin-right:auto;width:100%}.mx-auto[data-v-66178b5d]{font-size:90%}.texto_imagen[data-v-66178b5d]{font-size:80%}@media only screen and (min-width:450px){.texto_imagen[data-v-66178b5d]{font-size:70%}#btn-buscar[data-v-66178b5d]{width:30%;height:70%;font-size:9px}#buscador[data-v-66178b5d]{width:70%;height:70%;font-size:7px}.encabezado[data-v-66178b5d]{padding:0;margin:0}}@media only screen and (min-width:0px){.texto_categorias[data-v-66178b5d]{font-size:10px}}@media only screen and (min-width:400px){.titulo_tramite[data-v-66178b5d]{font-size:21px}.columna_tramites[data-v-66178b5d]{width:100%!important}.div_titulo_boton[data-v-66178b5d]{width:100%}.texto_tramite[data-v-66178b5d]{margin-bottom:0;padding-bottom:0xp}.dropdown-menu[data-v-66178b5d]{font-size:.85rem}.texto_categorias[data-v-66178b5d]{font-size:12px}}@media only screen and (min-width:600px){.texto_imagen[data-v-66178b5d]{font-size:100%}#btn-buscar[data-v-66178b5d]{width:30%;height:70%;font-size:9px}#buscador[data-v-66178b5d]{width:70%;height:70%;font-size:9px}.titulo_header[data-v-66178b5d]{height:82%}}@media only screen and (min-width:0px){.texto_imagen[data-v-66178b5d]{font-size:48%}#btn-buscar[data-v-66178b5d]{width:30%;height:80%;font-size:11px;line-height:0}#buscador[data-v-66178b5d]{width:70%;height:80%;font-size:11px}#btnenlinea[data-v-66178b5d]{margin-bottom:5%}.encabezado nav[data-v-66178b5d]{padding:0;margin:0}.texto_imagen[data-v-66178b5d]{margin-top:-10%;font-size:110%}.texto_categorias[data-v-66178b5d]{font-size:14px}}@media only screen and (min-width:1000px){.texto_categorias[data-v-66178b5d]{font-size:16px}}@media only screen and (min-width:450px){.texto_imagen[data-v-66178b5d]{font-size:140%}#btn-buscar[data-v-66178b5d]{width:30%;height:80%;font-size:.7em}#buscador[data-v-66178b5d]{width:70%;height:80%;font-size:.7em}.encabezado[data-v-66178b5d]{padding:0;margin:0}}@media only screen and (min-width:600px){.texto_imagen[data-v-66178b5d]{font-size:120%;margin-top:5.5%}#btn-buscar[data-v-66178b5d]{width:20%;height:80%;font-size:.9em}#buscador[data-v-66178b5d]{width:80%;height:80%;font-size:.9em}}@media only screen and (min-width:800px){.texto_imagen[data-v-66178b5d]{font-size:135%;margin-top:5%}#btn-buscar[data-v-66178b5d]{width:15%;height:65%;font-size:11px}#buscador[data-v-66178b5d]{width:85%;height:65%;font-size:11px}}@media screen and (min-width:950px){.texto_imagen[data-v-66178b5d]{font-size:150%}.colapsable[data-v-66178b5d]{display:none}#btn-buscar[data-v-66178b5d]{width:20%;height:70%;font-size:13px}#buscador[data-v-66178b5d]{width:80%;height:70%;font-size:13px}.widht100[data-v-66178b5d]{width:80%}}@media screen and (min-width:1300px){.texto_imagen[data-v-66178b5d]{font-size:200%}#btn-buscar[data-v-66178b5d]{width:20%;height:70%;font-size:16px}#buscador[data-v-66178b5d]{width:80%;height:70%;font-size:16px}}.progress-bar[data-v-66178b5d]{background-color:#9d2449}.progress[data-v-66178b5d]{height:.3em}.dropdown-menu.dropdown-menu-wide[data-v-66178b5d]{min-width:100%;text-align:center}.boton_seleccion[data-v-66178b5d]{width:100%}.carga_pagina[data-v-66178b5d]{position:absolute;top:50%;left:50%;width:120px;height:120px}@-webkit-keyframes spin-data-v-66178b5d{to{-webkit-transform:rotate(1turn)}}@keyframes spin-data-v-66178b5d{to{-webkit-transform:rotate(1turn);transform:rotate(1turn)}}.paginacion li[data-v-66178b5d]{border:0 solid #dee2e6!important}.paginacion li a[data-v-66178b5d]{border:1px solid #dee2e6!important;border-radius:0!important}.paginacion li a.active[data-v-66178b5d]{color:#0056b3!important;background-color:#ddd!important;border-radius:0!important}.nav-item[data-v-66178b5d]{background-color:#f2f4f8!important;color:#3a3a3a!important}.consulta_requisitos[data-v-66178b5d]{text-align:center;font-size:14px;padding:0;margin:0;text-decoration:underline!important;color:#7b9cf0!important}.consulta_requisitos[data-v-66178b5d]:hover,.nav-link.active[data-v-66178b5d]{color:#12c!important}.btn.focus[data-v-66178b5d],.btn[data-v-66178b5d]:focus,[data-v-66178b5d]:focus{outline:0!important;-webkit-box-shadow:0 0 0 0 #ff0!important;box-shadow:0 0 0 0 #ff0!important}.subrayado[data-v-66178b5d]{text-decoration:underline}@media screen and (min-width:0px){.header_padding[data-v-66178b5d]{padding-top:68.91px}}@media screen and (min-width:576px){.header_padding[data-v-66178b5d]{padding-top:46.39px}}@media screen and (min-width:768px){.header_padding[data-v-66178b5d]{padding-top:48px}}.scrollable-menu[data-v-66178b5d]{height:auto;max-height:300px;overflow-x:hidden}.lista_dependencias[data-v-66178b5d]:focus{background-color:#d4c19c}.lista_dependencias[data-v-66178b5d]:active{background-color:#d4c19c!important}.lista_dependencias.active[data-v-66178b5d]{background-color:#d4c19c!important;color:#fff!important}@media screen and (max-width:767px){.espacio_dependencias[data-v-66178b5d]{display:none}}@media screen and (min-width:768px){.espacio_tramites_titulo[data-v-66178b5d]{display:none}}.search_dependencia[data-v-66178b5d]{border:0 solid #000!important;border:1px solid}.search_dependencia[data-v-66178b5d],.search_dependencia[data-v-66178b5d]:focus{outline:0!important;-webkit-box-shadow:0 0 0 0 rgba(38,143,255,.5)!important;box-shadow:0 0 0 0 rgba(38,143,255,.5)!important}.search_dependencia[data-v-66178b5d]:focus{border:0 solid #000!important}.search_dependencia[data-v-66178b5d]:hover{outline:0!important;border:0 solid #000!important;-webkit-box-shadow:0 0 0 0 rgba(38,143,255,.5)!important;box-shadow:0 0 0 0 rgba(38,143,255,.5)!important}.dropdown-toggle[data-v-66178b5d]{margin-left:-.745em!important}.dropdown-item[data-v-66178b5d]{white-space:normal!important}.boton_en_linea[data-v-66178b5d],.boton_en_linea[data-v-66178b5d]:focus,.boton_en_linea[data-v-66178b5d]:hover{text-decoration:none!important}@media only screen and (min-width:577px){.botones_busqueda[data-v-66178b5d]{display:none}}@media only screen and (max-width:576px){.escritorio[data-v-66178b5d]{display:none}}@media only screen and (max-width:767px) and (min-width:577px){.menu_izquierdo[data-v-66178b5d]{overflow:auto}[data-v-66178b5d]::-webkit-scrollbar{width:5px}[data-v-66178b5d]::-webkit-scrollbar-track{-webkit-box-shadow:inset 0 0 5px grey;box-shadow:inset 0 0 5px grey;border-radius:10px}[data-v-66178b5d]::-webkit-scrollbar-thumb{background:grey;border-radius:10px}[data-v-66178b5d]::-webkit-scrollbar-thumb:hover{background:grey}}.texto_categorias.active[data-v-66178b5d]{font-weight:700}
.filters{
	cursor: pointer ;
}
.filters:hover {
    background-color: #9d2449;
    color: #fff;
    border-top: 3px solid #fff;
}
.ods{
	width: 125px;
	margin-bottom: 5px;
	cursor: pointer;
}
.icon_operation{
	width: 40px;
	margin-right: 5px;
	cursor: pointer;
}
/* Estilos Adrian Nuñez Alanis  */
.first{
 width: 100%;
 height: 50px;
 border: 1px solid  #13322B;
 border-radius: 4px;
 padding: 7px;
 background:  white;
 color: black;
 cursor:pointer;
 text-align: left;
 font-size: 0.8em;
}
.first:hover{
  background: #13322B;
  color: white;
}
.firstClik{
  background: #13322B;
  color: white;
}

.firstSearch{
  background: #449d44;
  color: white;
}

#modalFilter{
    width: 95% !important;
}

.modalFilter{
margin: 0px auto !important;
top: 70px !important;
}


</style>
