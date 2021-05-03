<?php
/*
Template Name: Thesaurus Home
*/

ini_set('display_errors', '0');

global $ths_service_url, $ths_plugin_slug;

$ths_config = get_option('ths_config');

$site_language = strtolower(get_bloginfo('language'));
$lang = substr($site_language,0,2);
$lang_another = sanitize_text_field($_GET['lang_another']);

$q = sanitize_text_field($_GET['q']);
$tquery = stripslashes(trim($q));
$filter = sanitize_text_field($_GET['filter']);
$pmt = sanitize_text_field($_GET['pmt']);


// Quantidade máxima de documentos que retornarão
$count=2000;


if ($tquery){
    switch ($filter) {
        case 'ths_termall':
            $query = 'ths_termall:' . '(' . $tquery . ') AND django_ct:"thesaurus.identifierdesc"';
            break;

        case 'ths_regid':
            $query = 'ths_regid:' . '"' . $tquery . '" AND django_ct:"thesaurus.identifierdesc"';
            break;

        // Qualifiers
        case 'ths_qualifall':
            $query = 'ths_termall:' . '(' . $tquery . ') AND django_ct:"thesaurus.identifierqualif"';
            break;

        case 'ths_exact_term':
            $query = 'ths_exact_term:' . '"' . $tquery . '" AND django_ct:"thesaurus.identifierdesc"';
            break;

        case 'ths_treenumber':
            $query = 'ths_treenumber:' . '(' . $tquery . ') AND django_ct:"thesaurus.identifierdesc"';
            break;

        // Em testes - utilizado para trazer resultado para a interface FI-Admin
        // http://localhost/wordpress/pt/ths?filter=ths_exact_term_bool&q="Relatos de Casos" OR "Revisão Sistemática"
        case 'ths_exact_term_bool':
            $query = 'ths_exact_term:' . '(' . $tquery . ') AND django_ct:"thesaurus.identifierdesc"';
            break;
    }
}

// Aplica pesquisa na API e armazena resultado
if ($tquery){
    $ths_service_request = $ths_service_url . '/api/desc/thesaurus/search/?q=' . urlencode($query) . '&count=' . $count;
}

// URL chamada
// echo "---> ".$ths_service_request."<br>";

$arr_docs_all = array();

$response = @file_get_contents($ths_service_request);
if ($response){
    $response_json = json_decode($response);

    // echo "<pre>"; print_r($response_json); echo "</pre>"; die();

    // Se o Lucene estiver sendo atualizado no momento não enviará dados para a interface
    // Envia mensagem informativa
    $nolinks = $response_json->diaServerResponse[1];
    if ( empty($nolinks)) {
        echo "<center>We are sorry, we are performing preventive maintenance at this moment. In a few moments we will be back, Thanks for that Greetings!</center>";
    }

    $total = $response_json->diaServerResponse[0]->response->numFound;
    $documents = $response_json->diaServerResponse[0]->response->docs;

    // echo "<pre>"; print_r($documents); echo "</pre>"; die();

    if ($total>0){
        $arr_result = array();
        
        foreach ( $documents as $position => $docs){
            if ($docs->ths_decs_code[0]) {
                $arr_temp=array();
                $arr_sym_en = array();
                $arr_sym_es = array();
                $arr_sym_pt = array();
                $arr_sym_fr = array();

                $arr_temp['ths_decs_code']=$docs->ths_decs_code;

                $arr_temp['ths_treenumber']=$docs->ths_treenumber;

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
        $Language=__('English','ths');
    } elseif ($lang_another == 'es') {
        $Language=__('Spanish','ths');
    } elseif ($lang_another == 'pt-br') {
        $Language=__('Portuguese','ths');
    } elseif ($lang_another == 'fr') {
        $Language=__('French','ths');
    }

    return $Language;
}


?>


<?php

if ( strval($total) == 1) {
    // Redirects the page when only one result
    foreach ( $arr_result as $key => $value) { $ths_decs_code=$arr_result[$key]['ths_decs_code']; }
    $urlx = real_site_url($ths_plugin_slug) . 'resource/?id=' . $ths_decs_code .'&filter=' . $filter . '&q=' . $q;
    header('Location: '.$urlx);
    die();

} else {

?>

<?php get_header(); ?>

<section class="container containerAos" id="main_container">

    <?php
    if ( $lang_another) {
    ?>
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <?php _e('You have selected the view in','ths'); ?>
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

    <div class="padding1">

            <div class="col-12">
                <div class="alert alert-success" role="alert">
                    <div class="row">
                        <div class="col-md-6">

                            <?php
                            _e('Search for','ths');
                            echo ":<b> ".$q." </b>";
                            ?>
                            |
                            <?php
                                if ( !$total || strval($total) == 0 ){
                                    _e('No results found','ths');
                                } elseif (  ( $query != '' || $user_filter != '' ) && strval($total) > 0  ) {
                                    _e('Results','ths'); echo ': ' . $total;
                                }
                            ?>

                        </div>

                        <?php
                            if (strval($total) > 0) {
                                if ( !empty($pmt) ) {
                        ?>
                                    <div class="col-md-6 text-right alignM1">

                                        <span class="">
                                            <a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php _e('See in another language','ths'); ?>&nbsp;<i class="fas fa-globe-americas"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="<?php echo real_site_url($ths_plugin_slug); ?>?pmt=swapped&filter=<?php echo $filter; ?>&q=<?php echo $q; ?>&lang_another=en"><?php _e('English','ths'); ?></a>
                                                <a class="dropdown-item" href="<?php echo real_site_url($ths_plugin_slug); ?>?pmt=swapped&filter=<?php echo $filter; ?>&q=<?php echo $q; ?>&lang_another=es"><?php _e('Spanish','ths'); ?></a>
                                                <a class="dropdown-item" href="<?php echo real_site_url($ths_plugin_slug); ?>?pmt=swapped&filter=<?php echo $filter; ?>&q=<?php echo $q; ?>&lang_another=pt-br"><?php _e('Portuguese','ths'); ?></a>
                                                <a class="dropdown-item" href="<?php echo real_site_url($ths_plugin_slug); ?>?pmt=swapped&filter=<?php echo $filter; ?>&q=<?php echo $q; ?>&lang_another=fr"><?php _e('French','ths');?></a>

                                            </div>
                                        </span>
                                         | 
                                        <span class="custom-switch">

                                            <script type="text/javascript">
                                                function redirect(url) {
                                                    window.location.href = url;
                                                }
                                            </script>
                                            <?php
                                                $u=real_site_url($ths_plugin_slug) . '?filter=' . $filter . '&q=' . $q;
                                                // echo "URL -->".$u ."<br>";
                                            ?>
                                            <input type="checkbox" class="custom-control-input" id="customSwitch1" onClick="redirect('<?php echo $u; ?>')" checked>
                                            <label class="custom-control-label" for="customSwitch1"><?php _e('List format','ths');?></label>

                                        </span>

                                    </div>
                        <?php
                                } elseif ( empty($pmt) ) {
                        ?>
                                    <div class="col-md-6 text-right alignM1">
                                        <div class="custom-control custom-switch">
                        <?php
                                            // Quando ths_exact_term_bool o formato de lista não funciona
                                            if ( $filter != "ths_exact_term_bool" ) {
                        ?>
                                                <script type="text/javascript">
                                                    function redirect(url) {
                                                        window.location.href = url;
                                                    }
                                                </script>
                                                <?php
                                                    $u=real_site_url($ths_plugin_slug) . '?pmt=swapped&filter=' . $filter . '&q=' . $q;
                                                    // echo "URL -->".$u ."<br>";
                                                ?>
                                                <input type="checkbox" class="custom-control-input" id="customSwitch1" onClick="redirect('<?php echo $u; ?>')">
                                                <label class="custom-control-label" for="customSwitch1"><?php _e('List format','ths');?></label>
                        <?php

                                            }
                        ?>

                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        ?>

                    </div>
                </div>
            </div>


        <?php if ( ( isset($total) && strval($total) == 0 ) || empty($arr_result) ) : ?>

            <?php include 'treeview.php'; ?>

        <?php else : ?>

            <?php

                // Quantidade de linhas para mostrar
                if ( empty($pmt) ){
                    $qtd = 10;
                } else {
                    $qtd = 200;
                }



                $atual = (isset($_GET['pg'])) ? intval($_GET['pg']) : 1;
                $Previous = $atual - 1;
                $Next = $atual + 1;

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

                        $arr_treenumber = $resultado[$key]['ths_treenumber'];
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
                                                    <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier English','ths'); } else { _e('Descriptor English','ths'); } ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_en)){ echo highlight($ths_mh_en, $q); } else { _e('Without translation','ths'); } ?></b>
                                                    <?php if ( !empty($ths_sym_en) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>en"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse show setaCollapse" id="sym<?php echo $nkey;?>en">
                                                            <div class="dropdown-divider"></div><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_en as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier Spanish','ths'); } else { _e('Descriptor Spanish','ths'); } ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_es)){ echo highlight($ths_mh_es, $q); } else { _e('Without translation','ths'); } ?></b>
                                                    <?php if ( !empty($ths_sym_es) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>es"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownES == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>es">
                                                            <div class="dropdown-divider"></div><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_es as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier Portuguese','ths'); } else { _e('Descriptor Portuguese','ths'); } ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_pt)){ echo highlight($ths_mh_pt, $q); } else { _e('Without translation','ths'); } ?></b>
                                                    <?php if ( !empty($ths_sym_pt) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>pt"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownPT == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>pt">
                                                            <div class="dropdown-divider"></div><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_pt as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier French','ths'); } else { _e('Descriptor French','ths'); } ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_fr)){ echo highlight($ths_mh_fr, $q); } else { _e('Without translation','ths'); } ?></b>
                                                    <?php if ( !empty($ths_sym_fr) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>fr"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownFR == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>fr">
                                                            <div class="dropdown-divider"></div><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
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
                                                    <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier Spanish','ths'); } else { _e('Descriptor Spanish','ths'); } ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_es)){ echo highlight($ths_mh_es, $q); } else { _e('Without translation','ths'); } ?></b>
                                                    <?php if ( !empty($ths_sym_es) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>es"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse show setaCollapse" id="sym<?php echo $nkey;?>es">
                                                            <div class="dropdown-divider"></div><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_es as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier English','ths'); } else { _e('Descriptor English','ths'); } ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_en)){ echo highlight($ths_mh_en, $q); } else { _e('Without translation','ths'); } ?></b>
                                                    <?php if ( !empty($ths_sym_en) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>en"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownEN == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>en">
                                                            <div class="dropdown-divider"></div><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_en as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier Portuguese','ths'); } else { _e('Descriptor Portuguese','ths'); } ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_pt)){ echo highlight($ths_mh_pt, $q); } else { _e('Without translation','ths'); } ?></b>
                                                    <?php if ( !empty($ths_sym_pt) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>pt"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownPT == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>pt">
                                                            <div class="dropdown-divider"></div><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_pt as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier French','ths'); } else { _e('Descriptor French','ths'); } ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_fr)){ echo highlight($ths_mh_fr, $q); } else { _e('Without translation','ths'); } ?></b>
                                                    <?php if ( !empty($ths_sym_fr) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>fr"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownFR == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>fr">
                                                            <div class="dropdown-divider"></div><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
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
                                                    <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier Portuguese','ths'); } else { _e('Descriptor Portuguese','ths'); } ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_pt)){ echo highlight($ths_mh_pt, $q); } else { _e('Without translation','ths'); } ?></b>
                                                    <?php if ( !empty($ths_sym_pt) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>pt"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse show setaCollapse" id="sym<?php echo $nkey;?>pt">
                                                            <div class="dropdown-divider"></div><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_pt as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier English','ths'); } else { _e('Descriptor English','ths'); } ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_en)){ echo highlight($ths_mh_en, $q); } else { _e('Without translation','ths'); } ?></b>
                                                    <?php if ( !empty($ths_sym_en) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>en"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownEN == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>en">
                                                            <div class="dropdown-divider"></div><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_en as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier Spanish','ths'); } else { _e('Descriptor Spanish','ths'); } ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_es)){ echo highlight($ths_mh_es, $q); } else { _e('Without translation','ths'); } ?></b>
                                                    <?php if ( !empty($ths_sym_es) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>es"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownES == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>es">
                                                            <div class="dropdown-divider"></div><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_es as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier French','ths'); } else { _e('Descriptor French','ths'); } ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_fr)){ echo highlight($ths_mh_fr, $q); } else { _e('Without translation','ths'); } ?></b>
                                                    <?php if ( !empty($ths_sym_fr) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>fr"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownFR == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>fr">
                                                            <div class="dropdown-divider"></div><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
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
                                                    <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier French','ths'); } else { _e('Descriptor French','ths'); } ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_fr)){ echo highlight($ths_mh_fr, $q); } else { _e('Without translation','ths'); } ?></b>
                                                    <?php if ( !empty($ths_sym_fr) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>fr"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse show setaCollapse" id="sym<?php echo $nkey;?>fr">
                                                            <div class="dropdown-divider"></div><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_fr as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier English','ths'); } else { _e('Descriptor English','ths'); } ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_en)){ echo highlight($ths_mh_en, $q); } else { _e('Without translation','ths'); } ?></b>
                                                    <?php if ( !empty($ths_sym_en) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>en"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownEN == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>en">
                                                            <div class="dropdown-divider"></div><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_en as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier Spanish','ths'); } else { _e('Descriptor Spanish','ths'); } ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_es)){ echo highlight($ths_mh_es, $q); } else { _e('Without translation','ths'); } ?></b>
                                                    <?php if ( !empty($ths_sym_es) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>es"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownES == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>es">
                                                            <div class="dropdown-divider"></div><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_es as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-right badge-descriptor tableWidth">
                                                    <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier Portuguese','ths'); } else { _e('Descriptor Portuguese','ths'); } ?>:
                                                </td>
                                                <td>
                                                    <b><?php if ( !empty($ths_mh_pt)){ echo highlight($ths_mh_pt, $q); } else { _e('Without translation','ths'); } ?></b>
                                                    <?php if ( !empty($ths_sym_pt) ) { ?>
                                                        <a class="float-right" data-toggle="collapse" href="#sym<?php echo $nkey;?>pt"><i class="fas fa-angle-down"></i></a>
                                                        <div class="collapse <?php if ($openDropdownPT == '1' ){ echo "show";} ?> setaCollapse" id="sym<?php echo $nkey;?>pt">
                                                            <div class="dropdown-divider"></div><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
                                                            <?php foreach ($ths_sym_pt as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                <?php
                                            break;
                                    }
                                ?>

                                <?php
                                if ( !empty($arr_treenumber) and $filter == 'ths_treenumber'){
                                ?>
                                    <tr>
                                        <td class="text-right badge-descriptor tableWidth">
                                            <?php _e('Tree number(s)','ths'); ?>:
                                        </td>
                                        <td>
                                            <?php foreach ($arr_treenumber as $key => $value) { echo highlight($value, $q)."<br>"; } ?>
                                        </td>
                                    </tr>
                                    
                                <?php
                                }
                                ?>

                            </table>
                        </div>
                    </div>
                    <div class="col-12 col-md-2 boxBtnSeeMore">
                        <?php
                            if ( $filter != "ths_exact_term_bool" ) {
                        ?>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code.'&filter='.$filter.'&q='.$q; ?>" class="btn btn-success btn-sm btnSeeMore"><?php _e('See details','ths'); ?></a>
                        <?php
                            } else {
                        ?>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>" class="btn btn-success btn-sm btnSeeMore"><?php _e('See details','ths'); ?></a>


                        <?php
                            }
                        ?>


                    </div>
                </div>
                <br>
            </article>

        <?php
        } else {
            // FORMATO LISTA
        ?>

            <article class="col-12">
                <div class="bgpermutado">
                    <div class="row">

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
                                <div class="col-12 col-md-12 font12">
                                    <?php if ( !empty($ths_mh_en)){ echo highlight($ths_mh_en, $q); } else { _e('Without translation','ths'); } ?>
                                    <?php if ( !empty($ths_sym_en) ) { ?>
                                        <div class="float-right btn-group" data-toggle="collapse" role="group" aria-label="Basic example">
                                            <a class="btn btn-sm btn-outline-success" data-toggle="collapse" href="#sym<?php echo $nkey;?>en"><i class="fas fa-angle-down"></i></a>
                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code.'&filter='.$filter.'&q='.$q; ?>" class="btn btn-sm btn-success"><i class="fas fa-search"></i></a>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="collapse setaCollapse" style="padding-left: 15px;" id="sym<?php echo $nkey;?>en">
                                                <ul><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
                                                <?php foreach ($ths_sym_en as $key => $value) { echo highlight($value, $q)."<br>"; } ?></ul>
                                        </div>
                                    <?php } else { ?>
                                        <div class="float-right" aria-label="Basic example">
                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code.'&filter='.$filter.'&q='.$q; ?>" class="btn btn-sm btn-success"><i class="fas fa-search"></i></a>
                                        </div>
                                    <?php
                                    } ?>
                                </div>
                    <?php
                                break;
                            case 'es':
                    ?>
                                <div class="col-12 col-md-12 font12">
                                    <?php if ( !empty($ths_mh_es)){ echo highlight($ths_mh_es, $q); } else { _e('Without translation','ths'); } ?>
                                    <?php if ( !empty($ths_sym_es) ) { ?>
                                        <div class="float-right btn-group" data-toggle="collapse" role="group" aria-label="Basic example">
                                            <a class="btn btn-sm btn-outline-success" data-toggle="collapse" href="#sym<?php echo $nkey;?>es"><i class="fas fa-angle-down"></i></a>
                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code.'&filter='.$filter.'&q='.$q; ?>" class="btn btn-sm btn-success"><i class="fas fa-search"></i></a>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="collapse setaCollapse" style="padding-left: 15px;" id="sym<?php echo $nkey;?>es">
                                                <ul><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
                                                <?php foreach ($ths_sym_es as $key => $value) { echo highlight($value, $q)."<br>"; } ?></ul>
                                        </div>
                                    <?php } else { ?>
                                        <div class="float-right" aria-label="Basic example">
                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code.'&filter='.$filter.'&q='.$q; ?>" class="btn btn-sm btn-success"><i class="fas fa-search"></i></a>
                                        </div>
                                    <?php
                                    } ?>
                                </div>
                    <?php
                                break;
                            case 'pt':
                    ?>
                                <div class="col-12 col-md-12 font12">
                                    <?php if ( !empty($ths_mh_pt)){ echo highlight($ths_mh_pt, $q); } else { _e('Without translation','ths'); } ?>
                                    <?php if ( !empty($ths_sym_pt) ) { ?>
                                        <div class="float-right btn-group" data-toggle="collapse" role="group" aria-label="Basic example">
                                            <a class="btn btn-sm btn-outline-success" data-toggle="collapse" href="#sym<?php echo $nkey;?>pt"><i class="fas fa-angle-down"></i></a>
                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code.'&filter='.$filter.'&q='.$q; ?>" class="btn btn-sm btn-success"><i class="fas fa-search"></i></a>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="collapse setaCollapse" style="padding-left: 15px;" id="sym<?php echo $nkey;?>pt">
                                                <ul><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
                                                <?php foreach ($ths_sym_pt as $key => $value) { echo highlight($value, $q)."<br>"; } ?></ul>
                                        </div>
                                    <?php } else { ?>
                                        <div class="float-right" aria-label="Basic example">
                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code.'&filter='.$filter.'&q='.$q; ?>" class="btn btn-sm btn-success"><i class="fas fa-search"></i></a>
                                        </div>
                                    <?php
                                    } ?>
                                </div>
                    <?php
                                break;
                            case 'fr':
                    ?>
                                <div class="col-12 col-md-12 font12">
                                    <?php if ( !empty($ths_mh_fr)){ echo highlight($ths_mh_fr, $q); } else { _e('Without translation','ths'); } ?>
                                    <?php if ( !empty($ths_sym_fr) ) { ?>
                                        <div class="float-right btn-group" data-toggle="collapse" role="group" aria-label="Basic example">
                                            <a class="btn btn-sm btn-outline-success" data-toggle="collapse" href="#sym<?php echo $nkey;?>fr"><i class="fas fa-angle-down"></i></a>
                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code.'&filter='.$filter.'&q='.$q; ?>" class="btn btn-sm btn-success"><i class="fas fa-search"></i></a>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="collapse setaCollapse" style="padding-left: 15px;" id="sym<?php echo $nkey;?>fr">
                                                <ul><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
                                                <?php foreach ($ths_sym_fr as $key => $value) { echo highlight($value, $q)."<br>"; } ?></ul>
                                        </div>
                                    <?php } else { ?>
                                        <div class="float-right" aria-label="Basic example">
                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code.'&filter='.$filter.'&q='.$q; ?>" class="btn btn-sm btn-success"><i class="fas fa-search"></i></a>
                                        </div>
                                    <?php
                                    } ?>
                                </div>
                    <?php
                                break;
                        }
                    } else {

                        switch ($lang_another) {
                            case 'en':
                    ?>
                                <div class="col-12 col-md-12 font12">
                                    <?php
                                        if ( !empty($ths_mh_en)) {
                                            echo highlight($ths_mh_en, $q);
                                        } else {
                                            echo "&nbsp;**&nbsp;"; _e('Without translation','ths');echo "&nbsp;-&nbsp;";
                                            $Language = selectedLanguage($lang_another);echo "$Language";
                                        }
                                    ?>

                                    <?php if ( !empty($ths_sym_en) ) { ?>
                                        <div class="float-right btn-group" data-toggle="collapse" role="group" aria-label="Basic example">
                                            <a class="btn btn-sm btn-outline-success" data-toggle="collapse" href="#sym<?php echo $nkey;?>en"><i class="fas fa-angle-down"></i></a>
                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code.'&filter='.$filter.'&q='.$q; ?>" class="btn btn-sm btn-success"><i class="fas fa-search"></i></a>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="collapse setaCollapse" style="padding-left: 15px;" id="sym<?php echo $nkey;?>en">
                                            <ul><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
                                            <?php foreach ($ths_sym_en as $key => $value) { echo highlight($value, $q)."<br>"; } ?></ul>
                                        </div>
                                    <?php } else { ?>

                                        <div class="float-right" aria-label="Basic example">
                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code.'&filter='.$filter.'&q='.$q; ?>" class="btn btn-sm btn-success"><i class="fas fa-search"></i></a>
                                        </div>

                                    <?php
                                    } ?>

                                </div>
                    <?php
                                break;
                            case 'es':
                    ?>
                                <div class="col-12 col-md-12 font12">
                                    <?php
                                        if ( !empty($ths_mh_es)) {
                                            echo highlight($ths_mh_es, $q);
                                        } else {
                                            if ( !empty($ths_mh_en)){ echo highlight($ths_mh_en, $q); echo "[en]"; }
                                            echo "&nbsp;**&nbsp;"; _e('Without translation','ths');echo "&nbsp;-&nbsp;";
                                            $Language = selectedLanguage($lang_another);echo "$Language";
                                        }
                                    ?>
                                    <?php if ( !empty($ths_sym_es) ) { ?>
                                        <div class="float-right btn-group" data-toggle="collapse" role="group" aria-label="Basic example">
                                            <a class="btn btn-sm btn-outline-success" data-toggle="collapse" href="#sym<?php echo $nkey;?>es"><i class="fas fa-angle-down"></i></a>
                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code.'&filter='.$filter.'&q='.$q; ?>" class="btn btn-sm btn-success"><i class="fas fa-search"></i></a>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="collapse setaCollapse" style="padding-left: 15px;" id="sym<?php echo $nkey;?>es">
                                            <ul><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
                                            <?php foreach ($ths_sym_es as $key => $value) { echo highlight($value, $q)."<br>"; } ?></ul>
                                        </div>
                                    <?php } else { ?>

                                        <div class="float-right" aria-label="Basic example">
                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code.'&filter='.$filter.'&q='.$q; ?>" class="btn btn-sm btn-success"><i class="fas fa-search"></i></a>
                                        </div>

                                    <?php
                                    } ?>

                                </div>
                    <?php
                                break;
                            case 'pt-br':
                    ?>
                                <div class="col-12 col-md-12 font12">
                                    <?php
                                        if ( !empty($ths_mh_pt)) {
                                            echo highlight($ths_mh_pt, $q);
                                        } else {
                                            if ( !empty($ths_mh_en)){ echo highlight($ths_mh_en, $q); echo "[en]"; }
                                            echo "&nbsp;**&nbsp;"; _e('Without translation','ths');echo "&nbsp;-&nbsp;";
                                            $Language = selectedLanguage($lang_another);echo "$Language";
                                        }
                                    ?>
                                    <?php if ( !empty($ths_sym_pt) ) { ?>
                                        <div class="float-right btn-group" data-toggle="collapse" role="group" aria-label="Basic example">
                                            <a class="btn btn-sm btn-outline-success" data-toggle="collapse" href="#sym<?php echo $nkey;?>pt"><i class="fas fa-angle-down"></i></a>
                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code.'&filter='.$filter.'&q='.$q; ?>" class="btn btn-sm btn-success"><i class="fas fa-search"></i></a>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="collapse setaCollapse" style="padding-left: 15px;" id="sym<?php echo $nkey;?>pt">
                                            <ul><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
                                            <?php foreach ($ths_sym_pt as $key => $value) { echo highlight($value, $q)."<br>"; } ?></ul>
                                        </div>
                                    <?php } else { ?>

                                        <div class="float-right" aria-label="Basic example">
                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code.'&filter='.$filter.'&q='.$q; ?>" class="btn btn-sm btn-success"><i class="fas fa-search"></i></a>
                                        </div>

                                    <?php
                                    } ?>

                                </div>
                    <?php
                                break;
                            case 'fr':
                    ?>
                                <div class="col-12 col-md-12 font12">
                                    <?php
                                        if ( !empty($ths_mh_fr)) {
                                            echo highlight($ths_mh_fr, $q);
                                        } else {
                                            if ( !empty($ths_mh_en)){ echo highlight($ths_mh_en, $q); echo "[en]"; }
                                            echo "&nbsp;**&nbsp;"; _e('Without translation','ths');echo "&nbsp;-&nbsp;";
                                            $Language = selectedLanguage($lang_another);echo "$Language";
                                        }
                                    ?>
                                    <?php if ( !empty($ths_sym_fr) ) { ?>
                                        <div class="float-right btn-group" data-toggle="collapse" role="group" aria-label="Basic example">
                                            <a class="btn btn-sm btn-outline-success" data-toggle="collapse" href="#sym<?php echo $nkey;?>fr"><i class="fas fa-angle-down"></i></a>
                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code.'&filter='.$filter.'&q='.$q; ?>" class="btn btn-sm btn-success"><i class="fas fa-search"></i></a>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="collapse setaCollapse" style="padding-left: 15px;" id="sym<?php echo $nkey;?>fr">
                                            <ul><b><?php _e('Entry term(s)','ths'); ?>:</b><br>
                                            <?php foreach ($ths_sym_fr as $key => $value) { echo highlight($value, $q)."<br>"; } ?></ul>
                                        </div>
                                    <?php } else { ?>

                                        <div class="float-right" aria-label="Basic example">
                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code.'&filter='.$filter.'&q='.$q; ?>" class="btn btn-sm btn-success"><i class="fas fa-search"></i></a>
                                        </div>

                                    <?php
                                    } ?>
                                </div>
                    <?php
                                break;
                        }

                    }
                    ?>

                    </div> <!-- <div class="row"> -->
                </div> <!-- <div class="bgpermutado"> -->

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

                        // Estabelece valores para o loop - proporcionando páginas antes e depois
                        if ($atual <= 5){
                         $limite_inferior=$atual-($atual-1);
                        } else {
                         $limite_inferior=$atual-5;
                        }
                        if( $atual < ($contar - 5) ){
                            $limite_superior=$atual+5;
                        } else {
                            $limite_superior=$atual+($contar-$atual);
                        }

                ?>
                        <div class="row-fluid">

                            <br>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <?php
                                        if ($Previous != 0){
                                    ?>
                                            <li class="page-item">
                                                <a class="page-link" href="<?php echo real_site_url($ths_plugin_slug); ?>?filter=<?php echo $filter; ?>&q=<?php echo $q; ?><?php if (!empty($pmt)) { echo "&pmt=swapped"; } ?><?php if (!empty($lang_another)) { echo "&lang_another=$lang_another"; } ?>&pg=1">&lt;</a>
                                            </li>

                                            <li class="page-item">
                                                <a class="page-link" aria-label="Previous" href="<?php echo real_site_url($ths_plugin_slug); ?>?filter=<?php echo $filter; ?>&q=<?php echo $q; ?><?php if (!empty($pmt)) { echo "&pmt=swapped"; } ?><?php if (!empty($lang_another)) { echo "&lang_another=$lang_another"; } ?>&pg=<?php if ($Previous) { echo $Previous; } ?>">
                                                    <span aria-hidden="true">&lt;&lt;</span>
                                                    <span class="sr-only">&lt;&lt;</span>
                                                </a>
                                            </li>
                                    <?php
                                        } else {
                                    ?>
                                            <li class="page-item disabled">
                                                <a class="page-link">&lt;</a>
                                            </li>
                                            <li class="page-item disabled">
                                                <a class="page-link" aria-label="Previous">
                                                    <span aria-hidden="true">&lt;&lt;</span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                            </li>
                                    <?php
                                        }
                                    ?>


                            <?php 

                            for($i = $limite_inferior; $i <= $limite_superior; $i++){


                                if($i == $atual){
                            ?>
                                    <li class="page-item active">
                                        <a class="page-link" href="<?php echo real_site_url($ths_plugin_slug); ?>?filter=<?php echo $filter; ?>&q=<?php echo $q; ?><?php if (!empty($pmt)) { echo "&pmt=swapped"; } ?><?php if (!empty($lang_another)) { echo "&lang_another=$lang_another"; } ?>&pg=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                            <?php

                                } else {
                            ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo real_site_url($ths_plugin_slug); ?>?filter=<?php echo $filter; ?>&q=<?php echo $q; ?><?php if (!empty($pmt)) { echo "&pmt=swapped"; } ?><?php if (!empty($lang_another)) { echo "&lang_another=$lang_another"; } ?>&pg=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                            <?php
                                }
                            ?>


                            <?php 
                            }
                            ?>

                                <?php
                                if ( $Next < $contar ){
                                ?>
                                    <li class="page-item">
                                        <a class="page-link" aria-label="Next" href="<?php echo real_site_url($ths_plugin_slug); ?>?filter=<?php echo $filter; ?>&q=<?php echo $q; ?><?php if (!empty($pmt)) { echo "&pmt=swapped"; } ?><?php if (!empty($lang_another)) { echo "&lang_another=$lang_another"; } ?>&pg=<?php if ($Next) { echo $Next; } ?>">
                                            <span aria-hidden="true">&gt;&gt;</span>
                                            <span class="sr-only">&gt;&gt;</span>
                                        </a>
                                    </li>

                                <?php
                                } else {
                                ?>
                                    <li class="page-item disabled">
                                        <a class="page-link" aria-label="Next">
                                            <span aria-hidden="true">&gt;&gt;</span>
                                            <span class="sr-only">&gt;&gt;</span>
                                        </a>
                                    </li>
                                <?php
                                }

                                if ( $Next < $contar ){
                                ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo real_site_url($ths_plugin_slug); ?>?filter=<?php echo $filter; ?>&q=<?php echo $q; ?><?php if (!empty($pmt)) { echo "&pmt=swapped"; } ?><?php if (!empty($lang_another)) { echo "&lang_another=$lang_another"; } ?>&pg=<?php if ($contar) { echo $contar; } ?>">&gt;</a>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <li class="page-item disabled"><a class="page-link">&gt;</a></li>
                                <?php
                                }

                                ?>

                                </ul>
                            </nav>

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
    <div><br><br></div>
</section>

<?php get_footer(); ?>

<?php
} // if ( strval($total) == 1) {
?>

