<?php
require_once "../app/functions/functions.php";
require_once "../config/config2.php";
require_once '../app/model/M_Perfil.php';
use app\models\M_Perfil;
session_start();
$perfil = new M_Perfil; // região 1
$filtro_areas = $perfil->getArea(); // Area filtro 
$filtro_indicadores = $perfil->getIndicador(); // Indicador em evolucao
$filtro2_indicadores = $perfil->getFiltroIndicador(); // Filtro indicadores
$filtro_regioes = $perfil->getRecorteGeografico(); // Regiao filtro
// echo "<pre>ola";
// var_dump($filtro_indicadores);
// echo "</pre>";
$pagina = "compare";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Amazônia Legal em Dados</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"
    />
    <meta name="description" content="Visão integrada do território formado pelos nove estados da Amazônia Legal">
    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <link href="./main.87c0748b313a1dda75f5.css" rel="stylesheet"></head>
    <script src="https://d3js.org/d3.v4.min.js"></script>
    <?php include_once("../template/app-header-includes.php"); ?>
    <link href="../assets/style/rodape.css" rel="stylesheet"></link>
    <link href="../assets/style/main2021.css" rel="stylesheet"></link>
    <link href="./assets/style/compare2021.css" rel="stylesheet"></link>
    <link href="../template/assets/styles/loginForm/loginForm.css" rel="stylesheet">
    <link href="../template/assets/styles/loginForm/recuperarSenhaForm.css" rel="stylesheet">
    <link href="../template/assets/styles/loginForm/codigoSegurancaForm.css" rel="stylesheet">
    <link href="../template/assets/styles/registerForm/registerForm.css" rel="stylesheet">
    <!-- Download of folder with data -->
    <script src="../assets/js/js-zip/dist/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="//www.amcharts.com/lib/4/lang/pt_BR.js"></script>
</head>
<body>
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar" >
   <?php include_once("../template/app-header.php"); ?>
    </div>    
         <div class="app-main"  id="topo" name="topo">
            <?php include_once("../template/app-sidebar.php"); ?>
            </div>    <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title">
                            <div class="page-title-wrapper">
                                <div class="row row-especial" style="float: left">
                                    <div class="col-lg-6">
                                        <div class="page-title-heading">
                                            <h2>Compare</h2>  
                                        </div>                              
                                    </div> 
                                    <div class="col-lg-6 page-title-actions text-right float-right"> 
                                        <script>
                                            var _subject = encodeURI("Conheça o perfil do indicador - Plataforma Amazônia Legal");
                                            var _body = encodeURIComponent("Um amigo está te recomendando a página do indicador: ");
                                            var _url = encodeURIComponent(window.location.href);
                                            var _body2 = encodeURIComponent("\n ============================================= \n Este email foi enviado via Plataforma da Amazônia Legal. \"A região da Amazônia Legal corresponde a cerca de 60% do território brasileiro e 28,2 milhões de habitantes correspondendo a 14% do total nacional e é formada por estados e 808 municípios.\" \n ")

                                            function enviarEmail(){
                                               window.location.href='mailto:mail@example.org?subject='+_subject+'&body='+_body+_url+_body2;
                                            }
                                        </script>
                                        <a href="#" onclick="javascript: enviarEmail()">    
                                        <img class="btn-email" src="../assets/images/svg/Enviar_Email.svg" alt="Enviar a página por e-mail"></a>
                                    </div>                          
                                    <div class="col-lg-12 col-sm-12">
                                     <form class="" id="form-search" method="POST" action="../app/controllers/comparecontroller.php" >
                                        <div class="form-row">
                                                <input type="hidden" name="group_id" id="group_id" value=""></input>
                                                <div class="col-md-3 col-lg-2 ml-1 mr-1">
                                                        <div class="position-relative form-group">
                                                        <img class="filtro-ico" src="../assets/images/svg/filtro-recorte-geografico.svg"/>
                                                        <select name="regiao" id="opt_regiao" class="form-control form-control-1">
                                                             <option value="" disabled selected hidden>&nbsp;Recorte geográfico</option>

                                                            <?php 
                                                            sort($filtro_regioes);
                                                            foreach ($filtro_regioes as $regiao){
                                                                 echo "<option value='".utf8_encode($regiao["REGIAO"])."'>&nbsp;".utf8_encode($regiao["REGIAO"])."</option>";
                                                            }
                                                            ?>
                                                        </select></div>
                                                </div>
                                                <div class="col-md-3 col-lg-2 ml-1 mr-1">
                                                        <div class="position-relative form-group">
                                                        <img class="filtro-ico" src="../assets/images/svg/filtro-recorte-geografico.svg"/>
                                                        <select name="regiao1" id="opt_regiao2" class="form-control form-control-1">
                                                             <option value="" disabled selected hidden>&nbsp;Recorte geográfico</option>

                                                            <?php 
                                                            foreach ($filtro_regioes as $regiao){
                                                                 echo "<option value='".utf8_encode($regiao["REGIAO"])."'>&nbsp;".utf8_encode($regiao["REGIAO"])."</option>";
                                                            }
                                                            ?>
                                                        </select></div>
                                                </div>
                                                <div class="col-md-3 col-lg-3 ml-2">
                                                        <div class="position-relative form-group">
                                                        <img class="filtro-ico" src="../assets/images/svg/filtro-area.svg"/>    
                                                        <select name="area" id="opt_area" class="form-control form-control-2">
                                                        <option value="" disabled selected hidden>Área</option>
                                                        <?php            
                                                            $areas = []; // áreas das regiões
                                                            $area_atual = "";
                                                            foreach ($filtro_areas as $ind){
                                                                $id_grupo = $perfil->getAreaRegiaoID(utf8_encode($ind["AREA"]),utf8_encode($ind["REGIAO"]));
                                                                if(utf8_encode($ind["REGIAO"]) != $area_atual and $area_atual != ""){
                                                                    echo "</optgroup>";
                                                                }
                                                                if (!in_array(utf8_encode($ind["REGIAO"]), $areas)){
                                                                    echo "<optgroup label = '".utf8_encode($ind["REGIAO"])."'>";
                                                                    $area_atual = utf8_encode($ind["REGIAO"]);
                                                                    array_push($areas, $area_atual);
                                                                }
                                                                echo "<option data-region='".utf8_encode($ind["REGIAO"])."' value='".utf8_encode($ind["AREA"])."__".$id_grupo."'>".utf8_encode($ind["AREA"])."</option>";
                                                            }
                                                            ?>
                                                        </select></div>
                                                </div>
                                                <div class="col-md-3 col-lg-3">
                                                    <div class="position-relative form-group form-group-1">
                                                        <?php    
                                                        $areas = []; // áreas dos indicadores
                                                        $area_atual = "";
                                                        $indicadores = [];
                                                        ?>
                                                        <img class="filtro-ico" src="../assets/images/svg/filtro-indicador.svg"/>
                                                        <select name="indicador" id="opt_indicador" class="form-control form-control-3" width="100px">
                                                            <option value="" disabled selected hidden>Indicador</option>
                                                        <?php    
                                                            foreach ($filtro_indicadores as $ind){
                                                                if (!in_array(utf8_encode($ind["AREA"]), $areas)){
                                                                    echo "<optgroup label = '".utf8_encode($ind["AREA"])."'>";
                                                                    $area_atual = utf8_encode($ind["AREA"]);
                                                                    array_push($areas, $area_atual);
                                                                }
                                                                if (!in_array($ind["INDICADOR"]."__".$ind["id"], $indicadores)){
                                                                    echo "<option value='".utf8_encode($ind["INDICADOR"])."__".utf8_encode($ind["id"])."'>".utf8_encode($ind["GRUPO"])."</option>";
                                                                    array_push($indicadores, $ind["INDICADOR"]."__".$ind["id"]);
                                                                }    
                                                            }
                                                        ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-lg-1 position-relative row form-check btn-pesquisar">
                                                    <div class="col-sm-11 col-lg-11 offset-lg-1">
                                                        <button class="btn btn-secondary bg-bordo btn-pesquisar-1">Pesquisar</button>
                                                    </div>
                                                </div>
                                        </div>
                                    </form>
                                </div>  
                            </div>  
                        </div>
                        <div>
                        </div>    
                    </div>            
                    <div class="tabs-animation">
                        <div class="row">
                            <div class="col-sm-12 col-lg-6">
                                <h4 class="titulo"><?php echo $_GET["regiao"]; ?></h4>
                                <div class="mb-3 card">
                                    <div class="card-header-tab card-header">
                                        <div class="card-header-title font-size-lg font-weight-normal evolucao">
                                            <?php
                                                $nome_indicador = $perfil->getNomeIndicadorAtual($_GET["indicador"], $_GET["regiao"], $_GET["area"]);
                                                echo $nome_indicador[0][0];
                                            ?>
                                        </div>
                                        <div class="btn-actions-pane-right text-capitalize actions-icon-btn">
                                        </div> 
                                    </div>
                                    <div class="card-body">
                                        <h4 class="texto"><?php    
                                            echo $perfil->getTextoIndicadorEvolucao($_GET["indicador"],$_GET["regiao"]);
                                        ?></h4>    
                                        <?php 
                                            $perfil->getTextoEvolucao($_GET["indicador"]);
                                            $graficos_evolucao = $perfil->getGraficosEvolucao($_GET["indicador"],$_GET["regiao"], $_GET["area"]);
                                        ?>    
                                        <?php 
                                            $vez = 0;
                                            foreach($graficos_evolucao as $grafico){
                                                if ($vez == 0 and $grafico["unico"] != 1){
                                                    echo  "<div class=\"card-header\""."><ul class=\"nav nav-justified\">"; 
                                                    $vez = 1;
                                                }
                                            } 
                                        ?>   
                                        <?php
                                            $i = 0;
                                            foreach($graficos_evolucao as $grafico){
                                                if ($grafico["ativo"] == "1" and $grafico["unico"] != 1){
                                                    echo "<li class=\"nav-item active\">";     
                                                    echo "<a data-toggle=\"tab\" href=\"#tab-eg7-0\" class=\"nav-link active\">".$grafico["titulo"]."</a></li>";  
                                                } else if ($grafico["unico"] != 1){
                                                    echo "<li class=\"nav-item\">"; 
                                                    echo "<a data-toggle=\"tab\" href=\"#tab-eg7-".$i."\" class=\"nav-link\">".$grafico["titulo"]."</a></li>";    
                                                }
                                                $i++;

                                            }
                                        ?>
                                        <?php 
                                            $vez = 0;
                                            foreach($graficos_evolucao as $grafico){
                                                if ($vez == 0 and $grafico["unico"] != 1){
                                                    echo  "</ul></div>"; 
                                                    $vez = 1;
                                                }
                                            }  
                                        ?>      
                                        <div class="card-body">
                                            <div class="tab-content">
                                            <?php        
                                                $indice = 0;
                                                foreach($graficos_evolucao as $grafico){
                                                    //require_once '../assets/plots/'.$grafico["arquivo"];
                                                    //$pieces = explode(".", $grafico["arquivo"]);
                                                    // include_once '../assets/plots/'.$pieces[0].".php";
                                                    if ($grafico["ativo"] == "1"){
                                                        echo "<div class=\"tab-pane active\" id=\"tab-eg7-0\" role=\"tabpanel\">";
                                                    }else{
                                                        echo "<div class=\"tab-pane\" id=\"tab-eg7-".$indice."\" role=\"tabpanel\">";
                                                    }
                                                    $regiao = $_GET["regiao"];
                                                    $secao = "evolucao";
                                                    // echo "indice:".$indice;
                                                    include("../app/controllers/graphicgenerator.php");
                                                    $indice++;
                                                    //var_dump($grafico);
                                                    // echo "<iframe width=\"100%\" height=\"370\" src=\"../assets/plots/".$grafico["arquivo"]."\" frameborder=\"0\" allowfullscreen></iframe>";
                                                    echo "<p class=\"fonte\">".$grafico["fonte"].$grafico["OBS"]."</p>";
                                                    echo "</div>";
                                                } 
                                            ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                if(!empty($perfil->temTerritorializacao($_GET["indicador"],$_GET["regiao"]))){
                                    $regiao = $_GET["regiao"];
                                    include("temterritorializacao.php");
                                }    
                                ?>
                                <?php
                                    if( !empty($perfil->temCenarios($_GET["indicador"],$_GET["regiao"])) ){ 
                                        $regiao = $_GET["regiao"];      
                                        include("temcenarios.php"); 
                                    }                           
                                ?>    
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <h4 class="titulo"><?php echo $_GET["regiao1"]; ?></h4>
                                <div class="mb-3 card">
                                    <div class="card-header-tab card-header">
                                        <div class="card-header-title font-size-lg font-weight-normal evolucao">
                                            <?php
                                                $nome_indicador = $perfil->getNomeIndicadorAtual($_GET["indicador"], $_GET["regiao1"], $_GET["area"]);
                                                echo $nome_indicador[0][0];
                                            ?>
                                        </div>
                                        <div class="btn-actions-pane-right text-capitalize actions-icon-btn">
                                        </div> 
                                    </div>
                                    <div class="card-body">
                                        <h4 class="texto"><?php    
                                            echo $perfil->getTextoIndicadorEvolucao($_GET["indicador"],$_GET["regiao1"]);
                                        ?></h4>    
                                        <?php 
                                            $perfil->getTextoEvolucao($_GET["indicador"]);
                                            $graficos_evolucao = $perfil->getGraficosEvolucao($_GET["indicador"],$_GET["regiao1"], $_GET["area"]);
                                        ?>    
                                        <?php 
                                            $vez = 0;
                                            foreach($graficos_evolucao as $grafico){
                                                if ($vez == 0 and $grafico["unico"] != 1){
                                                    echo  "<div class=\"card-header\""."><ul class=\"nav nav-justified\">"; 
                                                    $vez = 1;
                                                }
                                            } 
                                        ?>   
                                        <?php
                                            $i = 0;
                                            foreach($graficos_evolucao as $grafico){
                                                if ($grafico["ativo"] == "1" and $grafico["unico"] != 1){
                                                    echo "<li class=\"nav-item active\">";     
                                                    echo "<a data-toggle=\"tab\" href=\"#tab-eg8-0\" class=\"nav-link active\">".$grafico["titulo"]."</a></li>";
                                                } else if ($grafico["unico"] != 1){
                                                    echo "<li class=\"nav-item\">"; 
                                                    echo "<a data-toggle=\"tab\" href=\"#tab-eg8-".$i."\" class=\"nav-link\">".$grafico["titulo"]."</a></li>";    
                                                }
                                                $i++;
                                            }
                                        ?>
                                        <?php 
                                            $vez = 0;
                                            foreach($graficos_evolucao as $grafico){
                                                if ($vez == 0 and $grafico["unico"] != 1){
                                                    echo  "</ul></div>"; 
                                                    $vez = 1;
                                                }
                                            }  
                                        ?>      
                                        <div class="card-body">
                                            <div class="tab-content">
                                            <?php        
                                                //var_dump($graficos_evolucao);
                                                $indice = 0;
                                                
                                                foreach($graficos_evolucao as $grafico){
                                                    //echo "oi";
                                                    //require_once '../assets/plots/'.$grafico["arquivo"];
                                                    //$pieces = explode(".", $grafico["arquivo"]);
                                                    // include_once '../assets/plots/'.$pieces[0].".php";
                                                    if ($grafico["ativo"] == "1"){
                                                         echo "<div class=\"tab-pane active\" id=\"tab-eg8-0\" role=\"tabpanel\">";
                                                     }else{
                                                        echo "<div class=\"tab-pane\" id=\"tab-eg8-".$indice."\" role=\"tabpanel\">";                                                        
                                                     }
                                                    $regiao = $_GET["regiao1"];
                                                    $secao = "evolucao";
                                                    // echo "indice:".$indice;
                                                    include("../app/controllers/graphicgenerator.php");
                                                    $indice++;
                                                    // echo "<iframe width=\"100%\" height=\"370\" src=\"../assets/plots/".$grafico["arquivo"]."\" frameborder=\"0\" allowfullscreen></iframe>";
                                                    echo "<p class=\"fonte\">".$grafico["fonte"].$grafico["OBS"]."</p>";
                                                    echo "</div>";
                                                } 
                                            ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                if(!empty($perfil->temTerritorializacao($_GET["indicador"],$_GET["regiao1"]))){
                                    $regiao = $_GET["regiao1"];
                                    include("temterritorializacao.php");
                                }    
                                ?>
                                <?php
                                    if( !empty($perfil->temCenarios($_GET["indicador"],$_GET["regiao1"])) ){  
                                        $regiao = $_GET["regiao1"];     
                                        include("temcenarios.php"); 
                                    }      
                                ?>                         
                            </div>
                        </div>
                    </div>
                </div>
                <div class="app-wrapper-footer">
                    <?php include_once("../template/app-footer.php"); ?>
                </div>    </div>
    </div>
</div>
<div class="app-drawer-wrapper">
    <div class="drawer-nav-btn">
        <button type="button" class="hamburger hamburger--elastic is-active">
            <span class="hamburger-box"><span class="hamburger-inner"></span></span></button>
    </div>
    <div class="drawer-content-wrapper">
        <div class="scrollbar-container">
            <h3 class="drawer-heading">Servers Status</h3>
            <div class="drawer-section">
                <div class="row">
                    <div class="col">
                        <div class="progress-box"><h4>Server Load 1</h4>
                            <div class="circle-progress circle-progress-gradient-xl mx-auto">
                                <small></small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="progress-box"><h4>Server Load 2</h4>
                            <div class="circle-progress circle-progress-success-xl mx-auto">
                                <small></small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="progress-box"><h4>Server Load 3</h4>
                            <div class="circle-progress circle-progress-danger-xl mx-auto">
                                <small></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="mt-3"><h5 class="text-center card-title">Live Statistics</h5>
                    <div id="sparkline-carousel-3"></div>
                    <div class="row">
                        <div class="col">
                            <div class="widget-chart p-0">
                                <div class="widget-chart-content">
                                    <div class="widget-numbers text-warning fsize-3">43</div>
                                    <div class="widget-subheading pt-1">Packages</div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="widget-chart p-0">
                                <div class="widget-chart-content">
                                    <div class="widget-numbers text-danger fsize-3">65</div>
                                    <div class="widget-subheading pt-1">Dropped</div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="widget-chart p-0">
                                <div class="widget-chart-content">
                                    <div class="widget-numbers text-success fsize-3">18</div>
                                    <div class="widget-subheading pt-1">Invalid</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="text-center mt-2 d-block">
                        <button class="mr-2 border-0 btn-transition btn btn-outline-danger">Escalate Issue</button>
                        <button class="border-0 btn-transition btn btn-outline-success">Support Center</button>
                    </div>
                </div>
            </div>
            <h3 class="drawer-heading">File Transfers</h3>
            <div class="drawer-section p-0">
                <div class="files-box">
                    <ul class="list-group list-group-flush">
                        <li class="pt-2 pb-2 pr-2 list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left opacity-6 fsize-2 mr-3 text-primary center-elem">
                                        <i class="fa fa-file-alt"></i>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading font-weight-normal">TPSReport.docx</div>
                                    </div>
                                    <div class="widget-content-right widget-content-actions">
                                        <button class="btn-icon btn-icon-only btn btn-link btn-sm">
                                            <i class="fa fa-cloud-download-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="pt-2 pb-2 pr-2 list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left opacity-6 fsize-2 mr-3 text-warning center-elem">
                                        <i class="fa fa-file-archive"></i>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading font-weight-normal">Latest_photos.zip</div>
                                    </div>
                                    <div class="widget-content-right widget-content-actions">
                                        <button class="btn-icon btn-icon-only btn btn-link btn-sm">
                                            <i class="fa fa-cloud-download-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="pt-2 pb-2 pr-2 list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left opacity-6 fsize-2 mr-3 text-danger center-elem">
                                        <i class="fa fa-file-pdf"></i>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading font-weight-normal">Annual Revenue.pdf</div>
                                    </div>
                                    <div class="widget-content-right widget-content-actions">
                                        <button class="btn-icon btn-icon-only btn btn-link btn-sm">
                                            <i class="fa fa-cloud-download-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="pt-2 pb-2 pr-2 list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left opacity-6 fsize-2 mr-3 text-success center-elem">
                                        <i class="fa fa-file-excel"></i>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading font-weight-normal">Analytics_GrowthReport.xls</div>
                                    </div>
                                    <div class="widget-content-right widget-content-actions">
                                        <button class="btn-icon btn-icon-only btn btn-link btn-sm">
                                            <i class="fa fa-cloud-download-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <h3 class="drawer-heading">Tasks in Progress</h3>
            <div class="drawer-section p-0">
                <div class="todo-box">
                    <ul class="todo-list-wrapper list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="todo-indicator bg-warning"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" id="exampleCustomCheckbox1266" class="custom-control-input">
                                            <label class="custom-control-label" for="exampleCustomCheckbox1266">&nbsp;</label></div>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Wash the car
                                            <div class="badge badge-danger ml-2">Rejected</div>
                                        </div>
                                        <div class="widget-subheading"><i>Written by Bob</i></div>
                                    </div>
                                    <div class="widget-content-right widget-content-actions">
                                        <button class="border-0 btn-transition btn btn-outline-success">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        <button class="border-0 btn-transition btn btn-outline-danger">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="todo-indicator bg-focus"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" id="exampleCustomCheckbox1666" class="custom-control-input">
                                            <label class="custom-control-label" for="exampleCustomCheckbox1666">&nbsp;</label></div>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Task with hover dropdown menu</div>
                                        <div class="widget-subheading">
                                            <div>By Johnny
                                                <div class="badge badge-pill badge-info ml-2">NEW</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-content-right widget-content-actions">
                                        <div class="d-inline-block dropdown">
                                            <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="border-0 btn-transition btn btn-link">
                                                <i class="fa fa-ellipsis-h">
                                                </i>
                                            </button>
                                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right"><h6 tabindex="-1" class="dropdown-header">Header</h6>
                                                <button type="button" disabled="" tabindex="-1" class="disabled dropdown-item">Action</button>
                                                <button type="button" tabindex="0" class="dropdown-item">Another Action</button>
                                                <div tabindex="-1" class="dropdown-divider"></div>
                                                <button type="button" tabindex="0" class="dropdown-item">Another Action</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="todo-indicator bg-primary"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" id="exampleCustomCheckbox4777" class="custom-control-input">
                                            <label class="custom-control-label" for="exampleCustomCheckbox4777">&nbsp;</label></div>
                                    </div>
                                    <div class="widget-content-left flex2">
                                        <div class="widget-heading">Badge on the right task</div>
                                        <div class="widget-subheading">This task has show on hover actions!</div>
                                    </div>
                                    <div class="widget-content-right widget-content-actions">
                                        <button class="border-0 btn-transition btn btn-outline-success">
                                            <i class="fa fa-check">
                                            </i>
                                        </button>
                                    </div>
                                    <div class="widget-content-right ml-3">
                                        <div class="badge badge-pill badge-success">Latest Task</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="todo-indicator bg-info"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" id="exampleCustomCheckbox2444" class="custom-control-input">
                                            <label class="custom-control-label" for="exampleCustomCheckbox2444">&nbsp;</label></div>
                                    </div>
                                    <div class="widget-content-left mr-3">
                                        <div class="widget-content-left"><img width="42" class="rounded" src="assets/images/avatars/1.jpg" alt=""/></div>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Go grocery shopping</div>
                                        <div class="widget-subheading">A short description ...</div>
                                    </div>
                                    <div class="widget-content-right widget-content-actions">
                                        <button class="border-0 btn-transition btn btn-sm btn-outline-success">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        <button class="border-0 btn-transition btn btn-sm btn-outline-danger">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="todo-indicator bg-success"></div>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" id="exampleCustomCheckbox3222" class="custom-control-input">
                                            <label class="custom-control-label" for="exampleCustomCheckbox3222">&nbsp;</label></div>
                                    </div>
                                    <div class="widget-content-left flex2">
                                        <div class="widget-heading">Development Task</div>
                                        <div class="widget-subheading">Finish React ToDo List App</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="badge badge-warning mr-2">69</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <button class="border-0 btn-transition btn btn-outline-success">
                                            <i class="fa fa-check">
                                            </i>
                                        </button>
                                        <button class="border-0 btn-transition btn btn-outline-danger">
                                            <i class="fa fa-trash-alt">
                                            </i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <h3 class="drawer-heading">Urgent Notifications</h3>
            <div class="drawer-section">
                <div class="notifications-box">
                    <div class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--one-column">
                        <div class="vertical-timeline-item dot-danger vertical-timeline-element">
                            <div><span class="vertical-timeline-element-icon bounce-in"></span>
                                <div class="vertical-timeline-element-content bounce-in"><h4 class="timeline-title">All Hands Meeting</h4><span class="vertical-timeline-element-date"></span></div>
                            </div>
                        </div>
                        <div class="vertical-timeline-item dot-warning vertical-timeline-element">
                            <div><span class="vertical-timeline-element-icon bounce-in"></span>
                                <div class="vertical-timeline-element-content bounce-in"><p>Yet another one, at <span class="text-success">15:00 PM</span></p><span class="vertical-timeline-element-date"></span></div>
                            </div>
                        </div>
                        <div class="vertical-timeline-item dot-success vertical-timeline-element">
                            <div><span class="vertical-timeline-element-icon bounce-in"></span>
                                <div class="vertical-timeline-element-content bounce-in">
                                    <h4 class="timeline-title">Build the production release
                                        <div class="badge badge-danger ml-2">NEW</div>
                                    </h4>
                                    <span class="vertical-timeline-element-date"></span></div>
                            </div>
                        </div>
                        <div class="vertical-timeline-item dot-primary vertical-timeline-element">
                            <div><span class="vertical-timeline-element-icon bounce-in"></span>
                                <div class="vertical-timeline-element-content bounce-in">
                                    <h4 class="timeline-title">Something not important
                                        <div class="avatar-wrapper mt-2 avatar-wrapper-overlap">
                                            <div class="avatar-icon-wrapper avatar-icon-sm">
                                                <div class="avatar-icon"><img
                                                        src="assets/images/avatars/1.jpg"
                                                        alt=""></div>
                                            </div>
                                            <div class="avatar-icon-wrapper avatar-icon-sm">
                                                <div class="avatar-icon"><img
                                                        src="assets/images/avatars/2.jpg"
                                                        alt=""></div>
                                            </div>
                                            <div class="avatar-icon-wrapper avatar-icon-sm">
                                                <div class="avatar-icon"><img
                                                        src="assets/images/avatars/3.jpg"
                                                        alt=""></div>
                                            </div>
                                            <div class="avatar-icon-wrapper avatar-icon-sm">
                                                <div class="avatar-icon"><img
                                                        src="assets/images/avatars/4.jpg"
                                                        alt=""></div>
                                            </div>
                                            <div class="avatar-icon-wrapper avatar-icon-sm">
                                                <div class="avatar-icon"><img
                                                        src="assets/images/avatars/5.jpg"
                                                        alt=""></div>
                                            </div>
                                            <div class="avatar-icon-wrapper avatar-icon-sm">
                                                <div class="avatar-icon"><img
                                                        src="assets/images/avatars/6.jpg"
                                                        alt=""></div>
                                            </div>
                                            <div class="avatar-icon-wrapper avatar-icon-sm">
                                                <div class="avatar-icon"><img
                                                        src="assets/images/avatars/7.jpg"
                                                        alt=""></div>
                                            </div>
                                            <div class="avatar-icon-wrapper avatar-icon-sm">
                                                <div class="avatar-icon"><img
                                                        src="assets/images/avatars/8.jpg"
                                                        alt=""></div>
                                            </div>
                                            <div class="avatar-icon-wrapper avatar-icon-sm avatar-icon-add">
                                                <div class="avatar-icon"><i>+</i></div>
                                            </div>
                                        </div>
                                    </h4>
                                    <span class="vertical-timeline-element-date"></span></div>
                            </div>
                        </div>
                        <div class="vertical-timeline-item dot-info vertical-timeline-element">
                            <div><span class="vertical-timeline-element-icon bounce-in"></span>
                                <div class="vertical-timeline-element-content bounce-in"><h4 class="timeline-title">This dot has an info state</h4><span class="vertical-timeline-element-date"></span></div>
                            </div>
                        </div>
                        <div class="vertical-timeline-item dot-dark vertical-timeline-element">
                            <div><span class="vertical-timeline-element-icon is-hidden"></span>
                                <div class="vertical-timeline-element-content is-hidden"><h4 class="timeline-title">This dot has a dark state</h4><span class="vertical-timeline-element-date"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalLongAno" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ex
                ampleModalLongTitle">Melhor indicador do último ano</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <?php $data_destaques_interno = $perfil->getDestaquesInterno($_GET["indicador"],"valor"); ?>
                 <table style="width: 100%;" id="example" class="table  table-hover table-striped table-bordered text-center">
                        <thead>
                        <tr>
                            <th class="td-wd-30 text-left">Estado</th>
                            <th>Variação</th>
                            <th>Valor</th>     
                            <th>Posição</th>     
                        </tr>
                        </thead>
                        <tbody>           
                        <?php
                            $linha = 0;
                            foreach ($data_destaques_interno as $linha){
                                echo "<tr>";
                                $vez = 1;
                                foreach ($linha as $l){
                                    if ($vez == 1){
                                        echo "<td class=\"text-left\">".$l."</td>";
                                        $vez = 0;
                                    }else{
                                        echo "<td>".$l."</td>";
                                    }
                                }
                                 echo "</tr>";                                              
                             }    
                        ?>
                        </tfoot>
                        </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalLongRanking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Melhor variação no ranking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <?php $data_destaques_interno = $perfil->getDestaquesInterno($_GET["indicador"],"posicao"); ?>

                 <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered dataTable text-center">
                        <thead>
                        <tr>
                            <th class="td-wd-30 text-left">Estado</th>
                            <th>Variação</th>
                            <th>Valor</th>
                            <th>Posição</th>
                        </tr>
                        </thead>
                        <tbody>
                                        
                        <?php
                            $linha = 0;
                            foreach ($data_destaques_interno as $linha){
                                
                                echo "<tr>";
                                $vez = 1;
                                foreach ($linha as $l){
                                    if ($vez == 1){
                                        echo "<td class=\"text-left\">".$l."</td>";
                                        $vez = 0;
                                    }else{
                                        echo "<td>".$l."</td>";
                                    }
                                    
                                }
                                 echo "</tr>";                                        
                                                 
                             }    

                        ?>
                        </tfoot>
                        </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalLongIndicador" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Melhor variação do indicador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <?php $data_destaques_interno = $perfil->getDestaquesInterno($_GET["indicador"],"variacao"); ?>
                 <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered text-center">
                        <thead>
                        <tr>
                            <th class="td-wd-30 text-left">Estado</th>
                            <th>Variação</th>
                            <th>Valor</th>
                            <th>Posição</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $linha = 0;
                            foreach ($data_destaques_interno as $linha){
                                
                                echo "<tr>";
                                $vez = 1;
                                foreach ($linha as $l){
                                    if ($vez == 1){
                                        echo "<td class=\"text-left\">".$l."</td>";
                                        $vez = 0;
                                    }else{
                                        echo "<td>".$l."</td>";
                                    }
                                    
                                }
                                 echo "</tr>";                                        
                                                 
                             }    

                        ?>
                        </tfoot>
                        </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="alertaNaoCadastrado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title card-header-title" id="ex
                ampleModalLongTitle">Amazônia Legal em Dados</h5>
                <div class="btn-actions-pane-right actions-icon-btn">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button> 
                </div>
            </div>
            <div class="modal-body">
               <p> Cadastre-se para habilitar esta funcionalidade. </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<?php include_once("../template/app-form-cadastro.php"); ?>
<?php include_once("../template/app-form-login.php"); ?>
<?php include_once("../template/app-form-recuperar-senha.php"); ?>
<?php include_once("../template/app-form-codigo-seguranca-email.php"); ?>
<div class="app-drawer-overlay d-none animated fadeIn"></div><script type="text/javascript" src="./assets/scripts/main.87c0748b313a1dda75f5.js"></script>
<script        src="https://code.jquery.com/jquery-3.5.1.min.js"
              integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
              crossorigin="anonymous"></script>
              <script type="text/javascript" src="./assets/scripts/main-perfil.js"></script>
              <script type="text/javascript" src="./assets/scripts/main-rodape.js"></script>
              <script type="text/javascript" src="../template/assets/scripts/loginForm/loginForm.js"></script>
              <script type="text/javascript" src="../template/assets/scripts/loginForm/recuperarSenhaForm.js"></script>
              <script type="text/javascript" src="../template/assets/scripts/loginForm/codigoSegurancaForm.js"></script>
              <script type="text/javascript" src="../template/assets/scripts/registerForm/registerForm.js"></script>
</body>
</html>
