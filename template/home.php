<?php get_header(); ?>

<?php get_template_part('includes/navInter') ?>

<?php $lang = pll_current_language(); ?>
<?php
/*
Template Name: Thesaurus Home
*/
global $ths_service_url, $ths_plugin_slug;

ini_set('display_errors', '0');

$ths_config = get_option('ths_config');

$site_language = strtolower(get_bloginfo('language'));
$lang = substr($site_language,0,2);

// echo "[".$lang."]";
// echo "<pre>"; print_r($response_json); echo "</pre>";

// set query using default param q (query) or s (wordpress search) or newexpr (metaiah)
$q = $_GET['q'];
$tquery = stripslashes( trim($q) );
$filter = $_GET['filter'];
$count=300;

// Possibilidade de uso futuro dependendo da solução no Solr, se for encontrada não será necessário
// // Tenta deixar a primeira letra do texto maiúscula quando form selecionado ths_exact_term
// if ( $filter == 'ths_exact_term' ){
//     $tquery = ucfirst($tquery);
//     echo "[".$tquery."]";
// }


// NOVO
// ths_termall - Palavra ou Termo do Descritor
// ths_regid - ID do Registro
// ths_qualifall - Palavra ou Termo do Qualificador
// ths_exact_descriptor - Descritor Exato
// ths_treenumber - Código Hierárquico

if ($tquery){
    switch ($filter) {
        case 'ths_termall':
            // *** Não pesquisa:
            // Educação
            // Intervenção
            // Proteção Civil
            // Systèmes de retenue pour enfant
            // santé

            // *** Pesquisa:
            // saúde
            // Protection de l'enfance

            $query = 'ths_termall:' . '(' . $tquery . ' AND django_ct:"thesaurus.identifierdesc")';

            break;

        case 'ths_regid':
            $query = 'ths_regid:' . '"' . $tquery . '" AND django_ct:"thesaurus.identifierdesc"';
            break;

        // Qualifiers
        case 'ths_qualifall':
            $query = 'ths_termall:' . '(' . $tquery . ' AND django_ct:"thesaurus.identifierqualif")';
            break;

        case 'ths_exact_term':
            // *** pesquisa ok:
            // Réforme d'animaux
            $query = 'ths_exact_term:' . '"' . $tquery . '" AND django_ct:"thesaurus.identifierdesc"';
            break;

        case 'ths_treenumber':
            $query = 'ths_treenumber:' . '"' . $tquery . '" AND django_ct:"thesaurus.identifierdesc"';
            break;

        default:
            $query = 'ths_termall:' . '"' . $tquery . '" AND django_ct:"thesaurus.identifierdesc"';
            break;
    }
}


if ($tquery){
    $ths_service_request = $ths_service_url . 'api/desc/thesaurus/search/?q=' . urlencode($query) . '&count=' . $count;
}

// echo "---> ".$ths_service_request."<br>";


$arr_docs_all = array();

$response = @file_get_contents($ths_service_request);
if ($response){
    $response_json = json_decode($response);

    // echo "<pre>"; print_r($response_json); echo "</pre>";

    $total = $response_json->diaServerResponse[0]->response->numFound;
    if ($total>0){
        $arr_result = array();
        
        foreach ( $response_json->diaServerResponse[0]->response->docs as $position => $docs){
            if ($docs->ths_decs_code[0]) {
                $arr_temp=array();
                $arr_sym_en = array();
                $arr_sym_es = array();
                $arr_sym_pt = array();
                $arr_sym_fr = array();

                $arr_temp['ths_decs_code']=$docs->ths_decs_code;

                if ($docs->ths_mh_en[0]) {
                    $arr_temp['ths_mh_en']=$docs->ths_mh_en[0];
                }

                if ($docs->ths_mh_es[0]) {
                    $arr_temp['ths_mh_es']=$docs->ths_mh_es[0];
                }

                if ($docs->ths_mh_pt[0]) {
                    // $arr_temp['ths_mh_pt']=utf8_decode($docs->ths_mh_pt[0]);
                    $arr_temp['ths_mh_pt']=$docs->ths_mh_pt[0];
                }

                if ($docs->ths_mh_fr[0]) {
                    $arr_temp['ths_mh_fr']=$docs->ths_mh_fr[0];
                }

                // Para os sinônimos foi necessário um tratamento que pesquisa na string a ocorrência de ?.
                // Isso se fez necessário pois o conteúdo indexado no XML para o Solr está em iso-8859-1. Isso quer dizer que
                // todos os caracteres que estão fora da faixa comportada por esse encode não foi traduzido, e em seu lugar
                // ficou cravado ?.
                // No momento esse foi o preço a ser pago até outra solução.
                // Utilizou-se então:
                // if (strpos(' '.$value,'?') != 1){
                //     array_push($arr_sym, $value);
                // }

                // EN
                if ($docs->ths_mh_et_en) {
                    foreach ($docs->ths_mh_et_en as $key => $value) {
                        if (strpos(' '.$value,'?') != 1){
                            array_push($arr_sym_en, $value);
                        }
                    }
                }
                if ($docs->ths_pep_en) {
                    foreach ($docs->ths_pep_en as $key => $value) {
                        if (strpos(' '.$value,'?') != 1){
                            array_push($arr_sym_en, $value);
                        }
                    }
                }
                if ($docs->ths_pep_et_en) {
                    foreach ($docs->ths_pep_et_en as $key => $value) {
                        if (strpos(' '.$value,'?') != 1){
                            array_push($arr_sym_en, $value);
                        }
                    }
                }

                uasort($arr_sym_en,"SortET");
                $arr_temp['arr_sym_en']=$arr_sym_en;
                unset($arr_sym_en);


                // ES
                if ($docs->ths_mh_et_es) {
                    foreach ($docs->ths_mh_et_es as $key => $value) {
                        if (strpos(' '.$value,'?') != 1){
                            array_push($arr_sym_es, $value);
                        }
                    }
                }
                if ($docs->ths_pep_es) {
                    foreach ($docs->ths_pep_es as $key => $value) {
                        if (strpos(' '.$value,'?') != 1){
                            array_push($arr_sym_es, $value);
                        }
                    }
                }
                if ($docs->ths_pep_et_es) {
                    foreach ($docs->ths_pep_et_es as $key => $value) {
                        if (strpos(' '.$value,'?') != 1){
                            array_push($arr_sym_es, $value);
                        }
                    }
                }

                uasort($arr_sym_es,"SortET");
                $arr_temp['arr_sym_es']=$arr_sym_es;
                unset($arr_sym_es);


                // PT
                if ($docs->ths_mh_et_pt) {
                    foreach ($docs->ths_mh_et_pt as $key => $value) {
                        if (strpos(' '.$value,'?') != 1){
                            array_push($arr_sym_pt, $value);
                        }
                    }
                }

                if ($docs->ths_pep_pt) {
                    foreach ($docs->ths_pep_pt as $key => $value) {
                        if (strpos(' '.$value,'?') != 1){
                            array_push($arr_sym_pt, $value);
                        }
                    }
                }
                if ($docs->ths_pep_et_pt) {
                    foreach ($docs->ths_pep_et_pt as $key => $value) {
                        if (strpos(' '.$value,'?') != 1){
                            array_push($arr_sym_pt, $value);
                        }
                    }
                }

                uasort($arr_sym_pt,"SortET");
                $arr_temp['arr_sym_pt']=$arr_sym_pt;
                unset($arr_sym_pt);


                // FR
                if ($docs->ths_mh_et_fr) {
                    foreach ($docs->ths_mh_et_fr as $key => $value) {
                        if (strpos(' '.$value,'?') != 1){
                            array_push($arr_sym_fr, $value);
                        }
                    }
                }
                if ($docs->ths_pep_fr) {
                    foreach ($docs->ths_pep_fr as $key => $value) {
                        if (strpos(' '.$value,'?') != 1){
                            array_push($arr_sym_fr, $value);
                        }
                    }
                }
                if ($docs->ths_pep_et_fr) {
                    foreach ($docs->ths_pep_et_fr as $key => $value) {
                        if (strpos(' '.$value,'?') != 1){
                            array_push($arr_sym_fr, $value);
                        }
                    }
                }

                uasort($arr_sym_fr,"SortET");
                $arr_temp['arr_sym_fr']=$arr_sym_fr;
                unset($arr_sym_fr);



                $arr_result[]=$arr_temp;

                unset($arr_temp);


            }
        }


    // Ordena o array por language_code
        function cmp_en($a, $b){
            return strcmp($a["ths_mh_en"], $b["ths_mh_en"]);
        }

        function cmp_es($a, $b){
            return strcmp($a["ths_mh_es"], $b["ths_mh_es"]);
        }

        function cmp_pt($a, $b){
            return strcmp($a["ths_mh_pt"], $b["ths_mh_pt"]);
        }

        function cmp_fr($a, $b){
            return strcmp($a["ths_mh_fr"], $b["ths_mh_fr"]);
        }

        switch ($lang) {
            case 'en':
            usort($arr_result, "cmp_en"); 
            break;
            case 'es':
            usort($arr_result, "cmp_es"); 
            break;
            case 'pt':
            usort($arr_result, "cmp_pt"); 
            break;
            case 'fr':
            usort($arr_result, "cmp_fr"); 
            break;
            default:
            usort($arr_result, "cmp_en"); 
            break;
        }


    }

} else {
    $arr_result = array();
}


// Faz o ordenamento correto de acordo com o idioma escolhido para visualização no navegador
switch ($lang) {
    case 'en':
    uasort($arr_result,"SortMHResultEN");
    break;
    case 'es':
    uasort($arr_result,"SortMHResultES");
    break;
    case 'pt':
    uasort($arr_result,"SortMHResultPT");
    break;
    case 'fr':
    uasort($arr_result,"SortMHResultFR");
    break;
    default:
    uasort($arr_result,"SortMHResultEN");
    break;
}






// TESTE =====================================================================

// DEBUG
// echo "<pre>"; print_r($arr_result); echo "</pre>";

// TESTE =====================================================================



?>



<section class="container" id="main_container">
    <div class="padding1">

        <div class="col-12 text-center">
            <div class="alert alert-success" role="alert">
                <?php
                pll_e('Search for');
                echo ":<b> ".stripslashes($q)." </b>";
                ?>
                |
                <?php if ( isset($total) && strval($total) == 0 ) :?>
                <?php pll_e('No results found'); ?>
                <?php else :?>
                    <?php if ( ( $query != '' || $user_filter != '' ) && strval($total) > 0) :?>
                    <?php pll_e('Results'); echo ': ' . $total ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>


        <?php if ( isset($total) && strval($total) == 0 ) :?>
        
        <?php else :?>

            <?php
                $qtd = 10; // Quantidade de linhas para mostrar
                $atual = (isset($_GET['pg'])) ? intval($_GET['pg']) : 1;
                $pagArr = array_chunk($arr_result, $qtd);
                $contar = count($pagArr);
                $resultado = $pagArr[$atual-1];

                ?>

                <div class="row-fluid">
                <?php
                if (is_array($resultado)) {
                ?>

                    <?php foreach ( $resultado as $key => $value) {

                        $ths_decs_code=$resultado[$key]['ths_decs_code'];
                        $ths_mh_en=$resultado[$key]['ths_mh_en'];
                        $ths_mh_es=$resultado[$key]['ths_mh_es'];
                        $ths_mh_pt=$resultado[$key]['ths_mh_pt'];
                        $ths_mh_fr=$resultado[$key]['ths_mh_fr'];
                        $ths_mh_eses=$resultado[$key]['ths_mh_eses'];

                        $ths_sym_en=$resultado[$key]['arr_sym_en'];
                        $ths_sym_es=$resultado[$key]['arr_sym_es'];
                        $ths_sym_pt=$resultado[$key]['arr_sym_pt'];
                        $ths_sym_fr=$resultado[$key]['arr_sym_fr'];
                        // print_r($resultado[$key]);
                        // print_r($resultado[$key][0]);
                        // echo "<pre>"; print_r($ths_sym_pt); echo "</pre>";

                        // Define se o array dos Sinonimos aparecerá aberto
                        $openDropdownEN=containsString($ths_sym_en,$q);
                        $openDropdownES=containsString($ths_sym_es,$q);
                        $openDropdownPT=containsString($ths_sym_pt,$q);                        
                        $openDropdownFR=containsString($ths_sym_fr,$q);
                    ?>

            <article class="col-12">
                <div class="row">
                    <div class="col-12 col-md-10">
                        <div class="table-responsive">
                            <span class="badge badge-descriptor">
                                <?php
                                    // echo "--> pg atual [".$atual."]<br>";
                                    if ($atual > 1 ){
                                        // echo "--> key".$key."<br>";
                                        $nkey = $key + ($qtd*($atual-1)) + 1;
                                    } else {
                                        $nkey = $key + 1;
                                    }
                                    echo $nkey.' / '.$total; ?>
                                    
                            </span>
                            <table class="table table-bordered table-sm font12">

                                <?php
                                    // Acompanha o idioma escolhido no portal
                                    switch ($lang) {
                                        case 'en':
                                ?>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php pll_e('Descriptor English'); ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_en)){ echo highlight($ths_mh_en, $q); } else { echo pll_e('Without translation'); } ?></b>
                                                    <?php if ( !empty($ths_sym_en) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>en"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse show setaCollapse" id="sym<?php echo $nkey;?>en">
                                                            <div class="dropdown-divider"></div><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_en as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php pll_e('Descriptor Spanish'); ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_es)){ echo highlight($ths_mh_es, $q); } else { echo pll_e('Without translation'); } ?></b>
                                                    <?php if ( !empty($ths_sym_es) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>es"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownES == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>es">
                                                            <div class="dropdown-divider"></div><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_es as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php pll_e('Descriptor Portuguese'); ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_pt)){ echo highlight($ths_mh_pt, $q); } else { echo pll_e('Without translation'); } ?></b>
                                                    <?php if ( !empty($ths_sym_pt) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>pt"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownPT == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>pt">
                                                            <div class="dropdown-divider"></div><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_pt as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php pll_e('Descriptor French'); ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_fr)){ echo highlight($ths_mh_fr, $q); } else { echo pll_e('Without translation'); } ?></b>
                                                    <?php if ( !empty($ths_sym_fr) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>fr"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownFR == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>fr">
                                                            <div class="dropdown-divider"></div><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_fr as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                <?php
                                            break;
                                        case 'es':
                                ?>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php pll_e('Descriptor Spanish'); ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_es)){ echo highlight($ths_mh_es, $q); } else { echo pll_e('Without translation'); } ?></b>
                                                    <?php if ( !empty($ths_sym_es) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>es"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse show setaCollapse" id="sym<?php echo $nkey;?>es">
                                                            <div class="dropdown-divider"></div><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_es as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php pll_e('Descriptor English'); ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_en)){ echo highlight($ths_mh_en, $q); } else { echo pll_e('Without translation'); } ?></b>
                                                    <?php if ( !empty($ths_sym_en) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>en"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownEN == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>en">
                                                            <div class="dropdown-divider"></div><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_en as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php pll_e('Descriptor Portuguese'); ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_pt)){ echo highlight($ths_mh_pt, $q); } else { echo pll_e('Without translation'); } ?></b>
                                                    <?php if ( !empty($ths_sym_pt) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>pt"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownPT == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>pt">
                                                            <div class="dropdown-divider"></div><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_pt as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php pll_e('Descriptor French'); ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_fr)){ echo highlight($ths_mh_fr, $q); } else { echo pll_e('Without translation'); } ?></b>
                                                    <?php if ( !empty($ths_sym_fr) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>fr"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownFR == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>fr">
                                                            <div class="dropdown-divider"></div><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_fr as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                <?php
                                            break;
                                        case 'pt':
                                ?>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php pll_e('Descriptor Portuguese'); ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_pt)){ echo highlight($ths_mh_pt, $q); } else { echo pll_e('Without translation'); } ?></b>
                                                    <?php if ( !empty($ths_sym_pt) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>pt"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse show setaCollapse" id="sym<?php echo $nkey;?>pt">
                                                            <div class="dropdown-divider"></div><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_pt as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php pll_e('Descriptor English'); ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_en)){ echo highlight($ths_mh_en, $q); } else { echo pll_e('Without translation'); } ?></b>
                                                    <?php if ( !empty($ths_sym_en) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>en"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownEN == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>en">
                                                            <div class="dropdown-divider"></div><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_en as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php pll_e('Descriptor Spanish'); ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_es)){ echo highlight($ths_mh_es, $q); } else { echo pll_e('Without translation'); } ?></b>
                                                    <?php if ( !empty($ths_sym_es) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>es"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownES == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>es">
                                                            <div class="dropdown-divider"></div><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_es as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php pll_e('Descriptor French'); ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_fr)){ echo highlight($ths_mh_fr, $q); } else { echo pll_e('Without translation'); } ?></b>
                                                    <?php if ( !empty($ths_sym_fr) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>fr"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownFR == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>fr">
                                                            <div class="dropdown-divider"></div><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_fr as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                <?php
                                            break;
                                        case 'fr':
                                ?>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php pll_e('Descriptor French'); ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_fr)){ echo highlight($ths_mh_fr, $q); } else { echo pll_e('Without translation'); } ?></b>
                                                    <?php if ( !empty($ths_sym_fr) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>fr"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse show setaCollapse" id="sym<?php echo $nkey;?>fr">
                                                            <div class="dropdown-divider"></div><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_fr as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php pll_e('Descriptor English'); ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_en)){ echo highlight($ths_mh_en, $q); } else { echo pll_e('Without translation'); } ?></b>
                                                    <?php if ( !empty($ths_sym_en) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>en"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownEN == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>en">
                                                            <div class="dropdown-divider"></div><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_en as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php pll_e('Descriptor Spanish'); ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_es)){ echo highlight($ths_mh_es, $q); } else { echo pll_e('Without translation'); } ?></b>
                                                    <?php if ( !empty($ths_sym_es) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>es"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownES == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>es">
                                                            <div class="dropdown-divider"></div><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_es as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php pll_e('Descriptor Portuguese'); ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_pt)){ echo highlight($ths_mh_pt, $q); } else { echo pll_e('Without translation'); } ?></b>
                                                    <?php if ( !empty($ths_sym_pt) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>pt"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownPT == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>pt">
                                                            <div class="dropdown-divider"></div><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_pt as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                <?php
                                            break;
                                    }
                                ?>

                            </table>
                        </div>
                    </div>
                    <div class="col-12 col-md-2 boxBtnSeeMore">
                        <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code.'&filter='.$filter.'&q='.stripslashes($q); ?>" class="btn btn-success btn-sm btnSeeMore"><?php pll_e('See details'); ?></a>
                    </div>
                </div>
                <br>
            </article>



                    <?php
                        $contador++;
                    }
                    ?>

                <?php

                    if ($total > $qtd){
                        ?>
                        <div class="row-fluid">

                            <br>
                            <font size="2"><?php pll_e('Page'); ?>:</font>
                            <?php 
                            for($i = 1; $i <= $contar; $i++){
                                if($i == $atual){
                                    printf('<font size="2"><b><a href="%s?filter=%s&q=%s">( %s )</a></b></font>', real_site_url($ths_plugin_slug), $filter, $q, $i);
                                } else {
                                    printf('<font size="2"><a href="%s?filter=%s&q=%s&pg=%s"> %s </a></font>', real_site_url($ths_plugin_slug), $filter, $q, $i, $i);
                                }
                            }
                            ?>

                        </div>

                        <?php
                    }
                    ?>

                <?php
                }
                ?>

                </div>

        <?php endif; ?> <!-- END if ( isset($total) && strval($total) == 0 ) -->

    </div> 
</section>

<?php get_footer(); ?>
