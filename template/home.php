<?php get_header(); ?>

<?php get_template_part('includes/navInter') ?>

<?php 
$lang = pll_current_language();
$lang_another = $_GET[lang_another];
?>

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

$q = $_GET['q'];
$tquery = stripslashes( trim($q) );
$filter = $_GET['filter'];
$pmt =  $_GET['pmt'];


// Quantidade máxima de documentos que retornarão
$count=2000;


if ($tquery){
    switch ($filter) {
        case 'ths_termall':

            $query = 'ths_termall:' . '((' . $tquery . ') AND django_ct:"thesaurus.identifierdesc")';
            // Search for: fisiol | No results found
            // Search for: fisiol* | Results: 61
            // Search for: Arterivirus Aedes | No results found
            // Search for: Arterivirus OR Aedes | Results: 4 
            // Search for: Achyranthes calea OR Anemia Infecciosa Equina | No results found
            // Search for: "Achyranthes calea" OR "Anemia Infecciosa Equina" | Results: 3
            // Search for: saude | Results: 524

            // teste
            // $query = 'ths_termall:' . '(' . $tquery . '* AND django_ct:"thesaurus.identifierdesc")';
            // Search for: fisiol | Results: 61 
            // Search for: Arterivirus Aedes | No results found
            // Search for: Arterivirus OR Aedes | Results: 2 
            // Search for: Achyranthes calea OR Anemia Infecciosa Equina | No results found
            // Search for: saude | Results: 524 

            // teste
            // $query = 'ths_termall:' . '(*' . $tquery . '* AND django_ct:"thesaurus.identifierdesc")';
            // Search for: Arterivirus Aedes | No results found 
            // Search for: fisiol | Results: 76
            // Search for: Arterivirus OR Aedes | Results: 2
            // Search for: Achyranthes calea OR Anemia Infecciosa Equina | No results found

            // teste
            // $query = 'ths_termall:' . '(' . $tquery . ' AND django_ct:"thesaurus.identifierdesc")';
            // Search for: fisiol | No results found
            // Search for: Arterivirus Aedes | No results found
            // Search for: Arterivirus OR Aedes | Results: 2 
            // Search for: Achyranthes calea OR Anemia Infecciosa Equina | No results found

            // teste
            // $query = 'ths_termall:' . '((*' . $tquery . '*) AND django_ct:"thesaurus.identifierdesc")';
            // Search for: fisiol | Results: 76 
            // Search for: Arterivirus Aedes | No results found
            // Search for: Arterivirus OR Aedes | Results: 4
            // Search for: Achyranthes calea OR Anemia Infecciosa Equina | No results found 
            // Search for: "'Achyranthes calea" OR "Anemia Infecciosa Equina" | Results: 34041
            // Search for: Achyranthes calea Anemia Infecciosa Equina | No results found 
            // Search for: Achyranthes OR calea OR Anemia OR Infecciosa OR Equina | Results: 110

            break;

        case 'ths_regid':
            $query = 'ths_regid:' . '"' . $tquery . '" AND django_ct:"thesaurus.identifierdesc"';
            break;


        // Qualifiers
        case 'ths_qualifall':
            $query = 'ths_termall:' . '((' . $tquery . ') AND django_ct:"thesaurus.identifierqualif")';
            // Search for: fisiol | No results found 
            // Search for: fisiol* | Results: 1
            // Search for: fisiol$ | Results: 1
            // Search for: $fisiol$ | Results: 2 

            // BUG - mostra 2 resutados porém não mostra descritores
            // Search for: *fisiol* | Results: 2
            // Search for: *fisiol$ | Results: 2 

            // Search for: efectos adversos OR líquido cefalorraquídeo | No results found 
            // Search for: "efectos adversos" OR "líquido cefalorraquídeo" | Results: 2 
            // Search for: "administración & dosificación" OR "líquido cefalorraquídeo" | Results: 2 

            // Search for: efectos adversos AND líquido cefalorraquídeo | No results found 
            // Search for: "efectos adversos" AND "líquido cefalorraquídeo" | No results found 
            // Search for: "administración & dosificación" AND "líquido cefalorraquídeo" | No results found

            // teste
            // $query = 'ths_termall:' . '(*' . $tquery . '* AND django_ct:"thesaurus.identifierqualif")';
            // Search for: fisiol | Results: 2 
            // Search for: "administración & dosificación" AND "líquido cefalorraquídeo" | No results found
            // Search for: administración & dosificación | Results: 1


            break;

        case 'ths_exact_term':
            $query = 'ths_exact_term:' . '"' . $tquery . '" AND django_ct:"thesaurus.identifierdesc"';
            break;

        case 'ths_treenumber':
            $query = 'ths_treenumber:' . '(' . $tquery . '* AND django_ct:"thesaurus.identifierdesc")';
            break;

    }
}


// Aplica pesquisa na API e armazena resultado
if ($tquery){
    $ths_service_request = $ths_service_url . 'api/desc/thesaurus/search/?q=' . urlencode($query) . '&count=' . $count;
}

// URL chamada
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
if (empty($lang_another)) {
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
} else {
    switch ($lang_another) {
        case 'en':
        uasort($arr_result,"SortMHResultEN");
        break;
        case 'es':
        uasort($arr_result,"SortMHResultES");
        break;
        case 'pt-br':
        uasort($arr_result,"SortMHResultPT");
        break;
        case 'fr':
        uasort($arr_result,"SortMHResultFR");
        break;
        default:
        uasort($arr_result,"SortMHResultEN");
        break;
    }
}









// TESTE =====================================================================

// DEBUG
// echo "<pre>"; print_r($arr_result); echo "</pre>";

// TESTE =====================================================================


function selectedLanguage($lang_another){
    if ($lang_another == 'en'){
        $Language=pll_e('English');
    } elseif ($lang_another == 'es') {
        $Language=pll_e('Spanish');
    } elseif ($lang_another == 'pt-br') {
        $Language=pll_e('Portuguese');
    } elseif ($lang_another == 'fr') {
        $Language=pll_e('French');
    }

    return $Language;
}


?>



<?php
if ( $lang_another) {
?>
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        <?php pll_e('You have selected the view in'); ?>
        <?php
            $Language = selectedLanguage($lang_another);
            echo "$Language";
        ?>
       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
       </button>
    </div>
<?php
}
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

        <?php
        if ( !empty($pmt) and $filter == 'ths_termall' ) {
        ?>
            
            <!-- Permutado -->

            <a href="<?php echo real_site_url($ths_plugin_slug); ?>?filter=<?php echo $filter; ?>&q=<?php echo stripslashes($q); ?>" class="btn btn-success btn-sm"><?php pll_e('View in more languages'); ?></a>

                <a class="btn btn-success btn-sm" data-aos="fade-right" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php pll_e('See in another language'); ?>
                    <i class="fas fa-globe-americas"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="<?php echo real_site_url($ths_plugin_slug); ?>?pmt=swapped&filter=<?php echo $filter; ?>&q=<?php echo stripslashes($q); ?>&lang_another=en"><?php pll_e('English'); ?></a>
                    <a class="dropdown-item" href="<?php echo real_site_url($ths_plugin_slug); ?>?pmt=swapped&filter=<?php echo $filter; ?>&q=<?php echo stripslashes($q); ?>&lang_another=es"><?php pll_e('Spanish'); ?></a>
                    <a class="dropdown-item" href="<?php echo real_site_url($ths_plugin_slug); ?>?pmt=swapped&filter=<?php echo $filter; ?>&q=<?php echo stripslashes($q); ?>&lang_another=pt-br"><?php pll_e('Portuguese'); ?></a>
                    <a class="dropdown-item" href="<?php echo real_site_url($ths_plugin_slug); ?>?pmt=swapped&filter=<?php echo $filter; ?>&q=<?php echo stripslashes($q); ?>&lang_another=fr"><?php pll_e('French');?></a>

                </div>

        <?php
        } elseif ( empty($pmt) and $filter == 'ths_termall' ) {
        ?>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="<?php echo real_site_url($ths_plugin_slug); ?>?pmt=swapped&filter=<?php echo $filter; ?>&q=<?php echo stripslashes($q); ?>" class="btn btn-success btn-sm btnSeeMore"><?php pll_e('View only in portal language');?></a>

        <?php
        }
        ?>

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

        <?php
        if ( empty($pmt) ) {
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
        } else {
            // Permutado
        ?>
            <article class="col-12">
                <div class="row">
                    <div class="col-12 col-md-10">

                        <!-- Prove id para collapse -->
                        <?php
                            // echo "--> pg atual [".$atual."]<br>";
                            if ($atual > 1 ){
                                // echo "--> key".$key."<br>";
                                $nkey = $key + ($qtd*($atual-1)) + 1;
                            } else {
                                $nkey = $key + 1;
                            }
                        ?>

                        <?php
                            // Acompanha o idioma escolhido no portal
                        if (empty($lang_another)) {
                            switch ($lang) {
                                case 'en':
                        ?>
                                    <div>
                                        <?php if ( !empty($ths_mh_en)){ echo highlight($ths_mh_en, $q); } else { echo pll_e('Without translation'); } ?>
                                        <?php if ( !empty($ths_sym_en) ) { ?>
                                            <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>en"><i class="fas fa-angle-down"></i></a>
                                            <div class="collapse setaCollapse" id="sym<?php echo $nkey;?>en">
                                                <div class="dropdown-divider"></div>
                                                <ul><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                <?php foreach ($ths_sym_en as $key => $value) { echo highlight($value, $q)."<br>"; } ?></ul>
                                            </div>
                                        <?php } ?>
                                    </div>
                        <?php
                                    break;
                                case 'es':
                        ?>
                                    <div>
                                        <?php if ( !empty($ths_mh_es)){ echo highlight($ths_mh_es, $q); } else { echo pll_e('Without translation'); } ?>
                                        <?php if ( !empty($ths_sym_es) ) { ?>
                                            <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>es"><i class="fas fa-angle-down"></i></a>
                                            <div class="collapse setaCollapse" id="sym<?php echo $nkey;?>es">
                                                <div class="dropdown-divider"></div>
                                                <ul><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                <?php foreach ($ths_sym_es as $key => $value) { echo highlight($value, $q)."<br>"; } ?></ul>
                                            </div>
                                        <?php } ?>
                                    </div>

                        <?php
                                    break;
                                case 'pt':
                        ?>
                                    <div>
                                        <?php if ( !empty($ths_mh_pt)){ echo highlight($ths_mh_pt, $q); } else { echo pll_e('Without translation'); } ?>
                                        <?php if ( !empty($ths_sym_pt) ) { ?>
                                            <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>pt"><i class="fas fa-angle-down"></i></a>
                                            <div class="collapse setaCollapse" id="sym<?php echo $nkey;?>pt">
                                                <div class="dropdown-divider"></div>
                                                <ul><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                <?php foreach ($ths_sym_pt as $key => $value) { echo highlight($value, $q)."<br>"; } ?></ul>
                                            </div>
                                        <?php } ?>
                                    </div>
                        <?php
                                    break;
                                case 'fr':
                        ?>
                                    <div>
                                        <b><?php if ( !empty($ths_mh_fr)){ echo highlight($ths_mh_fr, $q); } else { echo pll_e('Without translation'); } ?></b>
                                        <?php if ( !empty($ths_sym_fr) ) { ?>
                                            <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>fr"><i class="fas fa-angle-down"></i></a>
                                            <div class="collapse setaCollapse" id="sym<?php echo $nkey;?>fr">
                                                <div class="dropdown-divider"></div>
                                                <ul><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                <?php foreach ($ths_sym_fr as $key => $value) { echo highlight($value, $q)."<br>"; } ?></ul>
                                            </div>
                                        <?php } ?>
                                    </div>
                        <?php
                                    break;
                            }
                        } else {

                            switch ($lang_another) {
                                case 'en':
                        ?>
                                    <div>
                                        <?php
                                            if ( !empty($ths_mh_en)) {
                                                echo highlight($ths_mh_en, $q);
                                            } else {
                                                echo "&nbsp;**&nbsp;"; echo pll_e('Without translation');echo "&nbsp;-&nbsp;";
                                                $Language = selectedLanguage($lang_another);echo "$Language";
                                            }
                                        ?>

                                        <?php if ( !empty($ths_sym_en) ) { ?>
                                            <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>en"><i class="fas fa-angle-down"></i></a>
                                            <div class="collapse setaCollapse" id="sym<?php echo $nkey;?>en">
                                                <div class="dropdown-divider"></div>
                                                <ul><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                <?php foreach ($ths_sym_en as $key => $value) { echo highlight($value, $q)."<br>"; } ?></ul>
                                            </div>
                                        <?php } ?>
                                    </div>
                        <?php
                                    break;
                                case 'es':
                        ?>
                                    <div>
                                        <?php
                                            if ( !empty($ths_mh_es)) {
                                                echo highlight($ths_mh_es, $q);
                                            } else {
                                                if ( !empty($ths_mh_en)){ echo highlight($ths_mh_en, $q); echo "[en]"; }
                                                echo "&nbsp;**&nbsp;"; echo pll_e('Without translation');echo "&nbsp;-&nbsp;";
                                                $Language = selectedLanguage($lang_another);echo "$Language";
                                            }
                                        ?>
                                        <?php if ( !empty($ths_sym_es) ) { ?>
                                            <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>es"><i class="fas fa-angle-down"></i></a>
                                            <div class="collapse setaCollapse" id="sym<?php echo $nkey;?>es">
                                                <div class="dropdown-divider"></div>
                                                <ul><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                <?php foreach ($ths_sym_es as $key => $value) { echo highlight($value, $q)."<br>"; } ?></ul>
                                            </div>
                                        <?php } ?>
                                    </div>
                        <?php
                                    break;
                                case 'pt-br':
                        ?>
                                    <div>
                                        <?php
                                            if ( !empty($ths_mh_pt)) {
                                                echo highlight($ths_mh_pt, $q);
                                            } else {
                                                if ( !empty($ths_mh_en)){ echo highlight($ths_mh_en, $q); echo "[en]"; }
                                                echo "&nbsp;**&nbsp;"; echo pll_e('Without translation');echo "&nbsp;-&nbsp;";
                                                $Language = selectedLanguage($lang_another);echo "$Language";
                                            }
                                        ?>
                                        <?php if ( !empty($ths_sym_pt) ) { ?>
                                            <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>pt"><i class="fas fa-angle-down"></i></a>
                                            <div class="collapse setaCollapse" id="sym<?php echo $nkey;?>pt">
                                                <div class="dropdown-divider"></div>
                                                <ul><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                <?php foreach ($ths_sym_pt as $key => $value) { echo highlight($value, $q)."<br>"; } ?></ul>
                                            </div>
                                        <?php } ?>
                                    </div>
                        <?php
                                    break;
                                case 'fr':
                        ?>
                                    <div>
                                        <?php
                                            if ( !empty($ths_mh_fr)) {
                                                echo highlight($ths_mh_fr, $q);
                                            } else {
                                                if ( !empty($ths_mh_en)){ echo highlight($ths_mh_en, $q); echo "[en]"; }
                                                echo "&nbsp;**&nbsp;"; echo pll_e('Without translation');echo "&nbsp;-&nbsp;";
                                                $Language = selectedLanguage($lang_another);echo "$Language";
                                            }
                                        ?>
                                        <?php if ( !empty($ths_sym_fr) ) { ?>
                                            <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>fr"><i class="fas fa-angle-down"></i></a>
                                            <div class="collapse setaCollapse" id="sym<?php echo $nkey;?>fr">
                                                <div class="dropdown-divider"></div>
                                                <ul><b><?php pll_e('Entry term(s)'); ?>:</b><br>
                                                <?php foreach ($ths_sym_fr as $key => $value) { echo highlight($value, $q)."<br>"; } ?></ul>
                                            </div>
                                        <?php } ?>
                                    </div>
                        <?php
                                    break;
                            }

                        }
                        ?>

                    </div>
                    <div class="col-12 col-md-2 boxBtnSeeMore">
                        <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code.'&filter='.$filter.'&q='.stripslashes($q); ?>" class="btn btn-success btn-sm btnSeeMore"><?php pll_e('See details'); ?></a>
                    </div>
                </div>
                <br>
            </article>

        <?php
        }
        ?>

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

                                if (empty($pmt)){

                                    if($i == $atual){
                                        printf('<font size="2"><b><a href="%s?filter=%s&q=%s">( %s )</a></b></font>', real_site_url($ths_plugin_slug), $filter, $q, $i);
                                    } else {
                                        printf('<font size="2"><a href="%s?filter=%s&q=%s&pg=%s"> %s </a></font>', real_site_url($ths_plugin_slug), $filter, $q, $i, $i);
                                    }

                                } else {

                                    if (empty($lang_another)) {

                                        if($i == $atual){
                                            printf('<font size="2"><b><a href="%s?pmt=swapped&filter=%s&q=%s">( %s )</a></b></font>', real_site_url($ths_plugin_slug), $filter, $q, $i);
                                        } else {
                                            printf('<font size="2"><a href="%s?pmt=swapped&filter=%s&q=%s&pg=%s"> %s </a></font>', real_site_url($ths_plugin_slug), $filter, $q, $i, $i);
                                        }

                                    } else {

                                        if($i == $atual){
                                            printf('<font size="2"><b><a href="%s?pmt=swapped&filter=%s&q=%s&lang_another=%s">( %s )</a></b></font>', real_site_url($ths_plugin_slug), $filter, $q, $lang_another, $i );
                                        } else {
                                            printf('<font size="2"><a href="%s?pmt=swapped&filter=%s&q=%s&lang_another=%s&pg=%s"> %s </a></font>', real_site_url($ths_plugin_slug), $filter, $q, $lang_another, $i, $i );
                                        }

                                    }

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
