<?php get_template_part('includes/topAcessibility') ?>
<?php get_header(); ?>
<?php get_template_part('includes/search') ?>

<?php
/*
Template Name: Thesaurus Home
*/
global $ths_service_url, $ths_plugin_slug;

$ths_config = get_option('ths_config');

$site_language = strtolower(get_bloginfo('language'));
$lang = substr($site_language,0,2);

// set query using default param q (query) or s (wordpress search) or newexpr (metaiah)
$q = $_GET['s'] . $_GET['q'];
$tquery = stripslashes( trim($q) );
$filter = $_GET['filter'];
$count=300;

// ths_termall - All Descriptor Terms
// ths_preferredterm - Main Heading (Descriptor) Terms
// ths_regid - Unique ID
// ths_conceptui - Concept ID
// ths_decs_code - Thesaurus ID
// ths_treenumber - Tree number ID
// ths_qualifall --> django_ct:"thesaurus.identifierqualif"

if ($tquery){
    switch ($filter) {
        case 'ths_termall':
            $query = '(ths_termall:' . '"' . $tquery . '" AND django_ct:"thesaurus.identifierdesc")';
            break;

        case 'ths_preferredterm':
            $query = 'ths_preferredterm:' . '"' . $tquery . '" AND django_ct:"thesaurus.identifierdesc"';
            break;

        case 'ths_regid':
            $query = 'ths_regid:' . '"' . $tquery . '" AND django_ct:"thesaurus.identifierdesc"';
            break;

        case 'ths_conceptui':
            $query = 'ths_conceptui:' . '"' . $tquery . '" AND django_ct:"thesaurus.identifierdesc"';
            break;

        case 'ths_decs_code':
            $query = 'ths_decs_code:' . '"' . $tquery . '" AND django_ct:"thesaurus.identifierdesc"';
            break;

        case 'ths_treenumber':
            $query = 'ths_treenumber:' . '"' . $tquery . '" AND django_ct:"thesaurus.identifierdesc"';
            break;

        // Qualifiers
        case 'ths_qualifall':
            $query = 'ths_termall:' . '"' . $tquery . '" AND django_ct:"thesaurus.identifierqualif"';
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
                $arr_temp['ths_decs_code']=$docs->ths_decs_code;

                if ($docs->ths_preferredterm_en[0]) {
                    $arr_temp['ths_preferredterm_en']=utf8_decode($docs->ths_preferredterm_en[0]);
                }

                if ($docs->ths_preferredterm_es[0]) {
                    $arr_temp['ths_preferredterm_es']=utf8_decode($docs->ths_preferredterm_es[0]);
                }

                if ($docs->ths_preferredterm_pt[0]) {
                    $arr_temp['ths_preferredterm_pt']=utf8_decode($docs->ths_preferredterm_pt[0]);
                }

                if ($docs->ths_preferredterm_fr[0]) {
                    $arr_temp['ths_preferredterm_fr']=utf8_decode($docs->ths_preferredterm_fr[0]);
                }

                $arr_result[]=$arr_temp;
                unset($arr_temp);

            }
        }

    // Ordena o array por language_code
        function cmp_en($a, $b){
            return strcmp($a["ths_preferredterm_en"], $b["ths_preferredterm_en"]);
        }

        function cmp_es($a, $b){
            return strcmp($a["ths_preferredterm_es"], $b["ths_preferredterm_es"]);
        }

        function cmp_pt($a, $b){
            return strcmp($a["ths_preferredterm_pt"], $b["ths_preferredterm_pt"]);
        }

        function cmp_fr($a, $b){
            return strcmp($a["ths_preferredterm_fr"], $b["ths_preferredterm_fr"]);
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

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo get_option('siteurl'); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                <?php
                if ($filter == 'ths_qualifall'){
                    pll_e('Qualifiers results');
                } else {
                    pll_e('Descriptors results');                    
                }
                ?>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?php
                    pll_e('Search for:');
                    echo " $q";
                    ?>
                </li>
            </ol>
        </nav>

        <?php if ( isset($total) && strval($total) == 0 ) :?>
        <h3 class="h1-header"><?php _e('No results found','ths'); ?></h3>
        <?php else :?>

            <?php if ( ( $query != '' || $user_filter != '' ) && strval($total) > 0) :?>
            <font size="2"><?php _e('Results', 'ths'); echo ': ' . $total ?></font>
            <?php else: ?>
                <font size="2"><?php _e('Total', 'ths'); echo ': ' . $total ?></font>
            <?php endif; ?>

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
                        $ths_preferredterm_en=$resultado[$key]['ths_preferredterm_en'];
                        $ths_preferredterm_es=$resultado[$key]['ths_preferredterm_es'];
                        $ths_preferredterm_pt=$resultado[$key]['ths_preferredterm_pt'];
                        $ths_preferredterm_fr=$resultado[$key]['ths_preferredterm_fr'];
                        ?>

                        <div style="border-bottom: 1px solid #ddd; padding: 12px 0;">
                            <?php
                            switch ($lang) {
                                case 'en':
                                ?>
                                <small class="badge badgeWarning">En</small>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>"><?php echo $ths_preferredterm_en; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <small class="badge badgeWarning">Es</small>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>"><?php echo $ths_preferredterm_es; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <small class="badge badgeWarning">Pt</small>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>"><?php echo $ths_preferredterm_pt; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <small class="badge badgeWarning">Fr</small>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>"><?php echo $ths_preferredterm_fr; ?></a>
                                <?php
                                break;

                                case 'es':
                                ?>
                                <small class="badge badgeWarning">Es</small>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>"><?php echo $ths_preferredterm_es; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <small class="badge badgeWarning">En</small>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>"><?php echo $ths_preferredterm_en; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <small class="badge badgeWarning">Pt</small>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>"><?php echo $ths_preferredterm_pt; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <small class="badge badgeWarning">Fr</small>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>"><?php echo $ths_preferredterm_fr; ?></a>
                                <?php
                                break;

                                case 'pt':
                                ?>
                                <small class="badge badgeWarning">Pt</small>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>"><?php echo $ths_preferredterm_pt; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <small class="badge badgeWarning">En</small>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>"><?php echo $ths_preferredterm_en; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <small class="badge badgeWarning">Es</small>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>"><?php echo $ths_preferredterm_es; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <small class="badge badgeWarning">Fr</small>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>"><?php echo $ths_preferredterm_fr; ?></a>
                                <?php
                                break;

                                case 'fr':
                                ?>
                                <small class="badge badgeWarning">Fr</small>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>"><?php echo $ths_preferredterm_fr; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <small class="badge badgeWarning">En</small>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>"><?php echo $ths_preferredterm_en; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <small class="badge badgeWarning">Es</small>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>"><?php echo $ths_preferredterm_es; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <small class="badge badgeWarning">Pt</small>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>"><?php echo $ths_preferredterm_pt; ?></a>
                                <?php
                                break;

                                default:
                                ?>
                                <small class="badge badgeWarning">En</small>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>"><?php echo $ths_preferredterm_en; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <small class="badge badgeWarning">Es</small>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>"><?php echo $ths_preferredterm_es; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <small class="badge badgeWarning">Pt</small>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>"><?php echo $ths_preferredterm_pt; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <small class="badge badgeWarning">Fr</small>
                                <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $ths_decs_code; ?>"><?php echo $ths_preferredterm_fr; ?></a>
                                <?php
                                break;

                            }
                            ?>

                        </div>

                    <?php } ?>

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
                } else {
                    printf('No results found');
                }
                ?>

                </div>

        <?php endif; ?> <!-- END if ( isset($total) && strval($total) == 0 ) -->

    </div> 
</section>

<?php get_footer(); ?>
