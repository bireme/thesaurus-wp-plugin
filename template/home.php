<?php get_header(); ?>
<?php get_template_part('includes/search') ?>
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

// set query using default param q (query) or s (wordpress search) or newexpr (metaiah)
$q = $_GET['q'];
// $q = $_GET['s'] . $_GET['q'];
$tquery = stripslashes( trim($q) );
$filter = $_GET['filter'];
$count=300;


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
            // *** Não pesquisa:
            // Réforme d'animaux

            $query = 'ths_exact_term:' . '"' . $tquery . '" AND django_ct:"thesaurus.identifierdesc"';
            break;

        case 'ths_treenumber':
            // $query = 'ths_treenumber:' . '"' . $tquery . '" AND django_ct:"thesaurus.identifierdesc"';
            $query = 'ths_treenumber:' . '"' . $tquery . '" AND django_ct:"thesaurus.identifierdesc"';
            break;

        default:
            $query = 'ths_termall:' . '"' . $tquery . '" AND django_ct:"thesaurus.identifierdesc"';
            break;
    }
}


if ($tquery){
    // Utilizado apenas em teste
    $TMP_URL= "http://fi-admin.beta.bvsalud.org/";
    $ths_service_request = $TMP_URL . 'api/desc/thesaurus/search/?q=' . urlencode($query) . '&count=' . $count;
    // echo "---> ".$ths_service_request."<br>";

    // Quando estiver OK a banco de dados
    // $ths_service_request = $ths_service_url . 'api/desc/thesaurus/search/?q=' . urlencode($query) . '&count=' . $count;
}

// echo "---> ".$ths_service_request."<br>";


// Função para ordenar palavras que tenham acento
function callback($name1,$name2){
    $patterns = array(
        'a' => '(á|à|â|ä|Á|À|Â|Ä)',
        'e' => '(é|è|ê|ë|É|È|Ê|Ë)',
        'i' => '(í|ì|î|ï|Í|Ì|Î|Ï)',
        'o' => '(ó|ò|ô|ö|Ó|Ò|Ô|Ö)',
        'u' => '(ú|ù|û|ü|Ú|Ù|Û|Ü)'
    );          
    $name1 = preg_replace(array_values($patterns), array_keys($patterns), $name1);
    $name2 = preg_replace(array_values($patterns), array_keys($patterns), $name2);          
    return strcasecmp($name1, $name2);
}


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
                $arr_sym = array();

                $arr_temp['ths_decs_code']=$docs->ths_decs_code;

                if ($docs->ths_mh_en[0]) {
                    $arr_temp['ths_mh_en']=utf8_decode($docs->ths_mh_en[0]);
                }

                if ($docs->ths_mh_es[0]) {
                    $arr_temp['ths_mh_es']=utf8_decode($docs->ths_mh_es[0]);
                }

                if ($docs->ths_mh_pt[0]) {
                    $arr_temp['ths_mh_pt']=utf8_decode($docs->ths_mh_pt[0]);
                }

                if ($docs->ths_mh_fr[0]) {
                    $arr_temp['ths_mh_fr']=utf8_decode($docs->ths_mh_fr[0]);
                }


                switch ($lang) {
                    case 'en':

                        // EN
                        if ($docs->ths_mh_et_en) {
                            foreach ($docs->ths_mh_et_en as $key => $value) {
                                array_push($arr_sym, utf8_decode($value));
                            }
                        }
                        if ($docs->ths_pep_en) {
                            foreach ($docs->ths_pep_en as $key => $value) {
                                array_push($arr_sym, utf8_decode($value));
                            }
                        }
                        if ($docs->ths_pep_et_en) {
                            foreach ($docs->ths_pep_et_en as $key => $value) {
                                array_push($arr_sym, utf8_decode($value));
                            }
                        }

                    break;

                    case 'es':
                        // ES
                        if ($docs->ths_mh_et_es) {
                            foreach ($docs->ths_mh_et_es as $key => $value) {
                                array_push($arr_sym, utf8_decode($value));
                            }
                        }
                        if ($docs->ths_pep_es) {
                            foreach ($docs->ths_pep_es as $key => $value) {
                                array_push($arr_sym, utf8_decode($value));
                            }
                        }
                        if ($docs->ths_pep_et_es) {
                            foreach ($docs->ths_pep_et_es as $key => $value) {
                                array_push($arr_sym, utf8_decode($value));
                            }
                        }

                    break;

                    case 'pt':
                        // PT
                        if ($docs->ths_mh_et_pt) {
                            foreach ($docs->ths_mh_et_pt as $key => $value) {
                                array_push($arr_sym, utf8_decode($value));
                            }
                        }
                        if ($docs->ths_pep_es) {
                            foreach ($docs->ths_pep_pt as $key => $value) {
                                array_push($arr_sym, utf8_decode($value));
                            }
                        }
                        if ($docs->ths_pep_et_pt) {
                            foreach ($docs->ths_pep_et_pt as $key => $value) {
                                array_push($arr_sym, utf8_decode($value));
                            }
                        }

                    break;

                    case 'fr':
                        // FR
                        if ($docs->ths_mh_et_fr) {
                            foreach ($docs->ths_mh_et_fr as $key => $value) {
                                array_push($arr_sym, utf8_decode($value));
                            }
                        }
                        if ($docs->ths_pep_fr) {
                            foreach ($docs->ths_pep_fr as $key => $value) {
                                array_push($arr_sym, utf8_decode($value));
                            }
                        }
                        if ($docs->ths_pep_et_fr) {
                            foreach ($docs->ths_pep_et_fr as $key => $value) {
                                array_push($arr_sym, utf8_decode($value));
                            }
                        }


                    break;

                    // default:
                    // usort($arr_result, "cmp_en"); 
                    // break;
                }

                uasort($arr_sym,"callback");
                array_push($arr_temp, $arr_sym);
                unset($arr_sym);

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

// echo "<pre>"; print_r($arr_result); echo "</pre>";


?>

<section class="container">
    <div class="padding1">

        <div class="col-12 text-center">
            <div class="alert alert-success" role="alert">
                <?php
                pll_e('Search for:');
                echo "<b> $q </b>";
                ?>
                |
                <?php if ( isset($total) && strval($total) == 0 ) :?>
                <?php _e('No results found','ths'); ?>
                <?php else :?>
                    <?php if ( ( $query != '' || $user_filter != '' ) && strval($total) > 0) :?>
                    <?php _e('Results', 'ths'); echo ': ' . $total ?>
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

                        $ths_sym=$resultado[$key][0];

                        // print_r($resultado[$key]);
                        // print_r($resultado[$key][0]);
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
                                    echo $nkey.'/'.$total; ?>
                                    
                            </span>
                            <table class="table table-bordered table-sm font12">
                                <tr>
                                    <td class="text-right badge-descriptor tableWidth"><?php pll_e('Descriptor English'); ?>:</td>
                                    <td><b><?php echo $ths_mh_en; ?></b></td>
                                </tr>
                                <tr>
                                    <td class="text-right badge-descriptor tableWidth"><?php pll_e('Descriptor Spanish'); ?>:</td>
                                    <td><b><?php echo $ths_mh_es; ?></b></td>
                                </tr>
                                <tr>
                                    <td class="text-right badge-descriptor tableWidth"><?php pll_e('Descriptor Portuguese'); ?>:</td>
                                    <td><b><?php echo $ths_mh_pt; ?></b></td>
                                </tr>
                                <tr>
                                    <td class="text-right badge-descriptor tableWidth"><?php pll_e('Descriptor French'); ?>:</td>
                                    <td><b><?php echo $ths_mh_fr; ?></b></td>
                                </tr>

                                <?php if ($ths_sym) { ?>
                                <tr>
                                    <td class="text-right badge-light align-middle"><?php pll_e('Synonyms English'); ?>:</td>
                                    <td>
                                        <?php
                                            foreach ($ths_sym as $key => $value) {
                                                print $value;?><br><?php
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <?php } ?>

                            </table>
                        </div>
                    </div>
                    <div class="col-12 col-md-2 boxBtnSeeMore">
                        <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>" class="btn btn-success btn-sm btnSeeMore"><?php pll_e('See details'); ?></a>
                        <!-- <a href="resource.php" class="btn btn-success btn-sm btnSeeMore">Ver Detalhes</a> -->
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
                            <font size="2"><?php pll_e('Page:'); ?></font>
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
