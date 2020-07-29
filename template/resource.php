<?php include 'plugin_thesaurus.php' ?>

<!-- Garante que o valor pequisado passe adiante -->
<?php
    $id = $_GET['id'];
    $q = $_GET['q'];
    $filter = $_GET['filter'];
?>

<?php get_header(); ?>

<?php get_template_part('includes/navInter') ?>

<?php $lang = pll_current_language();
// echo "[".$lang."]";
$lang_another = $_GET[lang_another];
// echo "lang_another [".$lang_another."]<br>";
// echo "lang_another 2ltr[".substr($lang_another,0,2)."]<br>";
// echo "<pre>"; print_r($arr_SeeRelatedListDesc); echo "</pre>";
?>

<?php
switch ($lang) {
    case 'en':
    $lang_ths='en';
    break;
    case 'es':
    $lang_ths='es';
    break;
    case 'pt':
    $lang_ths='pt-br';
    break;
    case 'fr':
    $lang_ths='fr';
    break;

}

if($has_descriptor or $has_qualifier){
?>

    <section class="container containerAos" id="main_container">

    <?php
    if ( $lang_another) {
    ?>
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <?php pll_e('You have selected the view in'); ?>
            <?php
                if ($lang_another == 'en'){
                    pll_e('English');
                } elseif ($lang_another == 'es') {
                    pll_e('Spanish');
                } elseif ($lang_another == 'pt-br') {
                    pll_e('Portuguese');
                } elseif ($lang_another == 'fr') {
                    pll_e('French');
                }
            ?>
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
           </button>
        </div>
    <?php
    }
    ?>

        <div class="row padding1">
            <div class="col-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist" style="position: relative;">


                    <li class="nav-item" data-aos="fade-left" data-aos-delay="300">
                        <a class="nav-link active" id="Details-tab" data-toggle="tab" href="#Details" role="tab" aria-controls="Details" aria-selected="true"><?php pll_e('Details'); ?></a>
                    </li>


                    <?php
                    if ($has_descriptor){
                    ?>

                        <li class="nav-item" data-aos="fade-left" data-aos-delay="400">
                            <a class="nav-link" id="Tree_Structures-tab" data-toggle="tab" href="#Tree_Structures" role="tab" aria-controls="Tree Structures" aria-selected="false"><?php pll_e('Tree Structures'); ?></a>
                        </li>

                    <?php
                    }
                    ?>


                    <li class="nav-item" data-aos="fade-left" data-aos-delay="500">
                        <a class="nav-link" id="Concepts-tab" data-toggle="tab" href="#Concepts" role="tab" aria-controls="Concepts" aria-selected="false"><?php pll_e('Concepts'); ?></a>
                    </li>


                    <li class="nav-item dropdownLang" data-aos="fade-right" data-aos-delay="600">
                        <a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php pll_e('See in another language'); ?>
                            <i class="fas fa-globe-americas"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?filter=ths_qualifall&q=<?php echo $q; ?>&id=<?php if ( $arr_IdentifierDesc[0]['decs_code']) { echo $arr_IdentifierDesc[0]['decs_code'].'&filter='.$filter.'&q='.stripslashes($q); } elseif ( $arr_IdentifierQualif[0]['decs_code'] ) { echo $arr_IdentifierQualif[0]['decs_code']; } ?>&lang_another=en"><?php pll_e('English'); ?></a>
                            <a class="dropdown-item" href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?filter=ths_qualifall&q=<?php echo $q; ?>&id=<?php if ( $arr_IdentifierDesc[0]['decs_code']) { echo $arr_IdentifierDesc[0]['decs_code'].'&filter='.$filter.'&q='.stripslashes($q); } elseif ( $arr_IdentifierQualif[0]['decs_code'] ) { echo $arr_IdentifierQualif[0]['decs_code']; } ?>&lang_another=es"><?php pll_e('Spanish'); ?></a>
                            <a class="dropdown-item" href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?filter=ths_qualifall&q=<?php echo $q; ?>&id=<?php if ( $arr_IdentifierDesc[0]['decs_code']) { echo $arr_IdentifierDesc[0]['decs_code'].'&filter='.$filter.'&q='.stripslashes($q); } elseif ( $arr_IdentifierQualif[0]['decs_code'] ) { echo $arr_IdentifierQualif[0]['decs_code']; } ?>&lang_another=pt-br"><?php pll_e('Portuguese'); ?></a>
                            <a class="dropdown-item" href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?filter=ths_qualifall&q=<?php echo $q; ?>&id=<?php if ( $arr_IdentifierDesc[0]['decs_code']) { echo $arr_IdentifierDesc[0]['decs_code'].'&filter='.$filter.'&q='.stripslashes($q); } elseif ( $arr_IdentifierQualif[0]['decs_code'] ) { echo $arr_IdentifierQualif[0]['decs_code']; } ?>&lang_another=fr"><?php pll_e('French'); ?></a>
                        </div>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent" data-aos="fade-up">

                    <div class="tab-pane fade active show" id="Details" role="tabpanel" aria-labelledby="Details-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm font12">

                                <?php
                                // Acompanha o idioma escolhido no portal
                                switch ($lang) {
                                    case 'en':
                                ?>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ pll_e('Qualifier English'); } else { pll_e('Descriptor English'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'en' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo pll_e('Without translation');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ pll_e('Qualifier Spanish'); } else { pll_e('Descriptor Spanish'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'es' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo pll_e('Without translation');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ pll_e('Qualifier Portuguese'); } else { pll_e('Descriptor Portuguese'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'pt-br' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo pll_e('Without translation');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ pll_e('Qualifier French'); } else { pll_e('Descriptor French'); } ?>:
                                        </td><td><b>

                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'fr' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo pll_e('Without translation');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                <?php
                                        break;

                                    case 'es':
                                ?>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ pll_e('Qualifier Spanish'); } else { pll_e('Descriptor Spanish'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'es' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo pll_e('Without translation');}; unset($has_mh);

                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ pll_e('Qualifier English'); } else { pll_e('Descriptor English'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'en' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo pll_e('Without translation');}; unset($has_mh);

                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ pll_e('Qualifier Portuguese'); } else { pll_e('Descriptor Portuguese'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'pt-br' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo pll_e('Without translation');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ pll_e('Qualifier French'); } else { pll_e('Descriptor French'); } ?>:
                                        </td><td><b>

                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'fr' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo pll_e('Without translation');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                <?php
                                        break;

                                    case 'pt':
                                ?>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ pll_e('Qualifier Portuguese'); } else { pll_e('Descriptor Portuguese'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'pt-br' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo pll_e('Without translation');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ pll_e('Qualifier English'); } else { pll_e('Descriptor English'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'en' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo pll_e('Without translation');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ pll_e('Qualifier Spanish'); } else { pll_e('Descriptor Spanish'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'es' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo pll_e('Without translation');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ pll_e('Qualifier French'); } else { pll_e('Descriptor French'); } ?>:
                                        </td><td><b>

                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'fr' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo pll_e('Without translation');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                <?php
                                        break;

                                    case 'fr':
                                ?>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ pll_e('Qualifier French'); } else { pll_e('Descriptor French'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'fr' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo pll_e('Without translation');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ pll_e('Qualifier English'); } else { pll_e('Descriptor English'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'en' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo pll_e('Without translation');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ pll_e('Qualifier Spanish'); } else { pll_e('Descriptor Spanish'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'es' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo pll_e('Without translation');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ pll_e('Qualifier Portuguese'); } else { pll_e('Descriptor Portuguese'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'pt-br' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo pll_e('Without translation');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                <?php
                                        break;

                                    }
                                ?>

                                <!-- Entry Term -->
                                <?php
                                if(!empty($arr_EntryTerms)){
                                    $arr_HasEntryTerms = array();
                                    foreach ($arr_EntryTerms as $key => $value) {
                                        $language_code=convLang($value['language_code']);
                                        if ( $lang_another ) {
                                            if ( $language_code == $lang_another ) {
                                                array_push($arr_HasEntryTerms, $value['term_string']);
                                            }
                                        } elseif ( $language_code == $lang_ths ){
                                            array_push($arr_HasEntryTerms, $value['term_string']);
                                        }
                                    }

                                }
                                if (!empty($arr_HasEntryTerms)) {
                                ?>
                                        <tr>
                                            <td class="text-right badge-light align-middle"><?php pll_e('Entry term(s)'); ?>:</td>
                                            <td>
                                <?php
                                        foreach ($arr_HasEntryTerms as $key => $value) {
                                            echo $value."<br>";
                                        }
                                ?>
                                            </td>   
                                        </tr>
                                <?php
                                }
                                unset($arr_HasEntryTerms);
                                ?>


                                <!-- Tree Number(s) -->
                                <?php
                                if(!empty($arr_TreeNumbersListDesc)){
                                ?>
                                <tr>
                                    <td class="text-right badge-light align-middle"><?php pll_e('Tree number(s)'); ?>:</td>
                                    <td>
                                        <?php
                                        foreach ($arr_TreeNumbersListDesc as $key => $value) {
                                            echo $value['tree_number'].'<br>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>

                                <!-- Scope Note -->
                                <!-- Definição -->
                                <?php
                                if(!empty($arr_PreferredScopeNote)){
                                    foreach ($arr_PreferredScopeNote as $key => $value) {
                                        $language_code=convLang($value['language_code']);
                                        if ( $lang_another and $value['scope_note'] ) {
                                            if ( $language_code == $lang_another ) {
                                ?>
                                                <tr>
                                                    <td class="text-right badge-light align-middle"><?php pll_e('Scope note'); ?>:</td>
                                                    <td><?php echo $value['scope_note'].'<br>'; ?></td>
                                                </tr>
                                <?php
                                            }
                                        } elseif ( ($language_code == $lang_ths) and $value['scope_note'] ){
                                ?>
                                                <tr>
                                                    <td class="text-right badge-light align-middle"><?php pll_e('Scope note'); ?>:</td>
                                                    <td><?php echo $value['scope_note'].'<br>'; ?></td>
                                                </tr>
                                <?php
                                        }
                                    } // foreach
                                } // if
                                ?>

                                <!-- Annotation -->
                                <!-- Nota de Indexação -->
                                <?php
                                if(!empty($arr_Description)){
                                    foreach ($arr_Description as $key => $value) {
                                        $language_code=convLang($value['language_code']);
                                        if ( $lang_another and $value['annotation'] ) {
                                            if ( $language_code == $lang_another ) {
                                ?>
                                                <tr>
                                                    <td class="text-right badge-light align-middle"><?php pll_e('Annotation'); ?>:</td>
                                                    <td><?php echo $value['annotation'].'<br>'; ?></td>
                                                </tr>
                                <?php
                                            }
                                        } elseif ( ($language_code == $lang_ths) and $value['annotation'] ){
                                ?>
                                                <tr>
                                                    <td class="text-right badge-light align-middle"><?php pll_e('Annotation'); ?>:</td>
                                                    <td><?php echo $value['annotation'].'<br>'; ?></td>
                                                </tr>
                                <?php
                                        }
                                    } // foreach
                                } // if
                                ?>


                                <!-- Allowable Qualifiers -->
                                <?php
                                if (!empty($arr_AllowableQualifiers)){
                                    foreach ($arr_AllowableQualifiers as $key => $value) {
                                        if ($arr_AllowableQualifiers[$key]['abbreviation']){
                                    ?>
                                            <tr>
                                                <td class="text-right badge-light align-middle"><?php pll_e('Allowable Qualifiers'); ?>:</td>
                                                <td>
                                    <?php
                                            break;
                                        }
                                    }
                                    foreach ($arr_AllowableQualifiers as $key => $value) {
                                        if ($arr_AllowableQualifiers[$key]['abbreviation']){
                                    ?>
                                    <?php
                                            foreach ($arr_AllowableQualifiers[$key] as $key1 => $value1) {
                                                if (is_array($arr_AllowableQualifiers[$key][$key1])){
                                                    $language_code=convLang($arr_AllowableQualifiers[$key][$key1]['language_code']);
                                                    if ( $lang_another ) {
                                                        if ( $language_code == $lang_another ) {
                                                            echo $arr_AllowableQualifiers[$key][$key1]['abbreviation'];
                                                            ?>
                                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?filter=ths_qualifall&q=<?php echo $q; ?>&id=<?php echo $arr_AllowableQualifiers[$key][$key1]['decs_code'];?>" target="_blank"><?php echo $arr_AllowableQualifiers[$key][$key1]['term_string']; ?></a><br>
                                                            <?php
                                                        }
                                                    } elseif ( $language_code == $lang_ths ){
                                                        echo $arr_AllowableQualifiers[$key][$key1]['abbreviation'];
                                                        ?>
                                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?filter=ths_qualifall&q=<?php echo $q; ?>&id=<?php echo $arr_AllowableQualifiers[$key][$key1]['decs_code'];?>" target="_blank"><?php echo $arr_AllowableQualifiers[$key][$key1]['term_string']; ?></a><br>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    foreach ($arr_AllowableQualifiers as $key => $value) {
                                        if ($arr_AllowableQualifiers[$key]['abbreviation']){
                                    ?>
                                                </td>
                                            </tr>
                                    <?php
                                            break;
                                        }
                                    }
                                }
                                ?>

                                <!-- Online Note -->
                                <?php
                                if(!empty($arr_Description)){
                                    foreach ($arr_Description as $key => $value) {
                                        $language_code=convLang($value['language_code']);
                                        if ( $lang_another and $value['online_note'] ) {
                                            if ( $language_code == $lang_another ) {
                                ?>
                                                <tr>
                                                    <td class="text-right badge-light align-middle"><?php pll_e('Online Note'); ?>:</td>
                                                    <td><?php echo $value['online_note'].'<br>'; ?></td>
                                                </tr>
                                <?php
                                            }
                                        } elseif ( ( $language_code == $lang_ths ) and $value['online_note'] ){
                                ?>
                                                <tr>
                                                    <td class="text-right badge-light align-middle"><?php pll_e('Online Note'); ?>:</td>
                                                    <td><?php echo $value['online_note'].'<br>'; ?></td>
                                                </tr>
                                <?php
                                        }
                                    } // foreach
                                } // if
                                ?>


                                <!-- History Note -->
                                <?php
                                if(!empty($arr_Description)){
                                    foreach ($arr_Description as $key => $value) {
                                        $language_code=convLang($value['language_code']);
                                        if ( $lang_another  and $value['history_note'] ) {
                                            if ( $language_code == $lang_another ) {
                                ?>
                                                <tr>
                                                    <td class="text-right badge-light align-middle"><?php pll_e('History Note'); ?>:</td>
                                                    <td><?php echo $value['history_note'].'<br>'; ?></td>
                                                </tr>
                                <?php
                                            }
                                        } elseif ( ($language_code == $lang_ths) and $value['history_note'] ){
                                ?>
                                                <tr>
                                                    <td class="text-right badge-light align-middle"><?php pll_e('History Note'); ?>:</td>
                                                    <td><?php echo $value['history_note'].'<br>'; ?></td>
                                                </tr>
                                <?php
                                        }
                                    } // foreach
                                } // if
                                ?>


                                <!-- Entry Version - campo do qualificador -->
                                <?php
                                if ($has_qualifier){ 

                                    if (!empty($arr_PreferredDescriptors[0])) {
                                        ?>
                                            <tr><td class="text-right badge-light align-middle"><?php pll_e('Entry Version'); ?>:</td><td>
                                        <?php
                                            // Acompanha o idioma escolhido no portal
                                                    foreach ($arr_PreferredDescriptors as $key => $value) {
                                                        $language_code=convLang($value['language_code']);
                                                        if ( $lang_another and $value['entry_version'] ) {
                                                            if ( $language_code == $lang_another ) {
                                                                echo $value['entry_version'].'<br>';
                                                            }
                                                        } elseif ( ($language_code == $lang_ths) and $value['entry_version'] ){
                                                            echo $value['entry_version'].'<br>';
                                                        }
                                                    }
                                        ?>
                                            </td></tr>
                                        <?php
                                    }
                                }
                                ?>

                                <!-- Abbreviation - campo do qualificador -->
                                <?php
                                if(!empty($qualifier_abbreviation)){
                                ?>
                                <tr>
                                    <td class="text-right badge-light align-middle"><?php pll_e('Abbreviation'); ?>:</td>
                                    <td>
                                        <?php
                                        echo $qualifier_abbreviation;
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>

                                <!-- SeeRelated -->
                                <?php
                                if ( !empty($arr_SeeRelatedListDesc[0])) {
                                    $arr_TR = array();
                                    $arr_temp=array();
                                    foreach ($arr_SeeRelatedListDesc as $key => $value) {
                                        foreach ($value['terms'] as $key => $tr) {
                                            if ( $lang_another ) {
                                                if ( $tr['language_code'] == $lang_another ) {
                                                    $arr_temp['term_string']=$tr['term_string'];
                                                    $arr_temp['descriptor_ui']=$value['descriptor_ui'];
                                                    $arr_temp['decs_code']=$value['decs_code'];
                                                    }
                                            } elseif ( ( $tr['language_code'] == $lang_ths) ){
                                                $arr_temp['term_string']=$tr['term_string'];
                                                $arr_temp['descriptor_ui']=$value['descriptor_ui'];
                                                $arr_temp['decs_code']=$value['decs_code'];
                                            }
                                        }
                                        $arr_TR[]=$arr_temp;
                                        unset($arr_temp);
                                    }
                                    sort($arr_TR);

                                ?>
                                    <tr><td class="text-right badge-light align-middle"><?php pll_e('Related'); ?>:</td><td>
                                <?php
                                        foreach ($arr_TR as $key => $value) {
                                ?>
                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $value['decs_code']; ?>"><?php echo $value['term_string']; ?></a>
                                <?php
                                            if ( substr($value['descriptor_ui'], 0, 2) == 'D0'){
                                                echo "<i>MeSH</i>";
                                            } elseif ( substr($value['descriptor_ui'], 0, 4) == 'DDCS') {
                                                echo "<i>DeCS</i>";
                                            }
                                ?>
                                            <br>
                                <?php
                                        }
                                ?>
                                    </td></tr>
                                <?php
                                }
                                ?>


                                <!-- Decs ID -->
                                <tr>
                                    <td class="text-right badge-light align-middle"><?php pll_e('DeCS ID'); ?>:</td>
                                    <td>
                                        <?php
                                        if ( !empty($arr_IdentifierDesc[0]['decs_code']) ){
                                            echo $arr_IdentifierDesc[0]['decs_code'];
                                        } elseif ( !empty($arr_IdentifierQualif[0]['decs_code']) ){
                                            echo $arr_IdentifierQualif[0]['decs_code'];
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <!-- DescriptorUI / QualifierUI-->
                                <tr>
                                    <td class="text-right badge-light align-middle"><?php pll_e('Unique ID'); ?>:</td>
                                    <td>
                                        <?php
                                        if ( !empty($arr_IdentifierDesc[0]['descriptor_ui']) ){
                                            echo $arr_IdentifierDesc[0]['descriptor_ui'];
                                        } elseif ( !empty($arr_IdentifierQualif[0]['qualifier_ui']) ){
                                            echo $arr_IdentifierQualif[0]['qualifier_ui'];
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <!-- Date Established -->
                                <?php
                                if ($has_descriptor){
                                    if ( !empty($arr_IdentifierDesc[0]['date_established']) ){
                                ?>
                                        <tr>
                                            <td class="text-right badge-light align-middle"><?php pll_e('Date Established'); ?>:</td>
                                            <td>
                                            <?php
                                            if ( !empty($arr_IdentifierDesc[0]['date_established']) ){
                                                $ndate=DateAdjust($arr_IdentifierDesc[0]['date_established'], $lang_ths );
                                            }
                                            echo $ndate; unset($ndate);
                                            ?>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }

                                if ($has_qualifier){
                                    if ( !empty($arr_IdentifierQualif[0]['date_established']) ){
                                ?>
                                        <tr>
                                            <td class="text-right badge-light align-middle"><?php pll_e('Date Established'); ?>:</td>
                                            <td>
                                            <?php
                                            if ( !empty($arr_IdentifierQualif[0]['date_established']) ){
                                                $ndate=DateAdjust($arr_IdentifierQualif[0]['date_established'], $lang_ths );
                                            }
                                            echo $ndate; unset($ndate);
                                            ?>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>


                                <!-- Date of Entry -->
                                <?php
                                if ($has_descriptor){
                                    if ( !empty($arr_IdentifierDesc[0]['date_created']) ){
                                ?>
                                        <tr>
                                            <td class="text-right badge-light align-middle"><?php pll_e('Date of Entry'); ?>:</td>
                                            <td>
                                            <?php
                                            if ( !empty($arr_IdentifierDesc[0]['date_created']) ){
                                                $ndate=DateAdjust($arr_IdentifierDesc[0]['date_created'], $lang_ths );
                                            }
                                            echo $ndate; unset($ndate);
                                            ?>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }

                                if ($has_qualifier){
                                    if ( !empty($arr_IdentifierQualif[0]['date_created']) ){
                                ?>
                                        <tr>
                                            <td class="text-right badge-light align-middle"><?php pll_e('Date of Entry'); ?>:</td>
                                            <td>
                                            <?php
                                            if ( !empty($arr_IdentifierQualif[0]['date_created']) ){
                                                $ndate=DateAdjust($arr_IdentifierQualif[0]['date_created'], $lang_ths );
                                            }
                                            echo $ndate; unset($ndate);
                                            ?>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>

                                <!-- Revision Date -->
                                <?php
                                if ($has_descriptor){
                                    if ( !empty($arr_IdentifierDesc[0]['date_revised']) ){
                                ?>
                                        <tr>
                                            <td class="text-right badge-light align-middle"><?php pll_e('Revision Date'); ?>:</td>
                                            <td>
                                            <?php
                                            if ( !empty($arr_IdentifierDesc[0]['date_revised']) ){
                                                $ndate=DateAdjust($arr_IdentifierDesc[0]['date_revised'], $lang_ths );
                                            }
                                            echo $ndate; unset($ndate);
                                            ?>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }

                                if ($has_qualifier){
                                    if ( !empty($arr_IdentifierQualif[0]['date_revised']) ){
                                ?>
                                        <tr>
                                            <td class="text-right badge-light align-middle"><?php pll_e('Revision Date'); ?>:</td>
                                            <td>
                                            <?php
                                            if ( !empty($arr_IdentifierQualif[0]['date_revised']) ){
                                                $ndate=DateAdjust($arr_IdentifierQualif[0]['date_revised'], $lang_ths );
                                            }
                                            echo $ndate; unset($ndate);
                                            ?>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>

                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade boxTree" id="Tree_Structures" role="tabpanel" aria-labelledby="Tree_Structures-tab">
                        <ul class="listTree">

                            <table width="1024px">
                                <tr>
                                    <td>
                                        
                            <?php

                            // echo "<pre>"; print_r($arr_HierarchicalTree); echo "</pre>";

                            $count=0;
                            foreach ($arr_HierarchicalTree as $key => $value) {
                            ?>
                                <li>
                                    <ul class="tree" id="1">

                                        <?php

                                            $tree_number=$arr_HierarchicalTree[$key]['tree_number'];
                                            $char1 = substr($tree_number, 0, 1);
                                            $char2 = substr($tree_number, 1, 1);
                                            if (preg_match("/[0-9]/", $char2) == 1 ) {
                                                // echo 'NLM';
                                                $categ=$char1;
                                            } else {
                                                // echo 'DeCs';
                                                $categ=$char1.$char2;
                                            }

                                            $categ_string=choice_category($categ,$lang);

                                            if ( strlen($tree_number) == 3 and $count == 0 ) {
                                                echo "<b>".$categ_string."</b><br>";
                                            }

                                            $tree_number_original=$arr_HierarchicalTree[$key]['tree_number_original'];

                                            if ( $count > 0 and $tree_number_original != $tree_number_original_old and strlen($tree_number) == 3){
                                                echo "<hr>";
                                                echo "<b>".$categ_string."</b><br>";
                                            }

                                            foreach ($arr_HierarchicalTree[$key]['term_string_translations'] as $key1 => $value1) {
                                                $language_code=convLang($arr_HierarchicalTree[$key]['term_string_translations'][$key1]['language_code']);

                                                if ( $language_code == 'en' ){
                                                    // $coringa=pll_e('Without translation').'['.$term_string=$arr_HierarchicalTree[$key]['term_string_translations'][$key1]['term_string'].']';
                                                    $coringa=$term_string=$arr_HierarchicalTree[$key]['term_string_translations'][$key1]['term_string'];
                                                }

                                                if ( $lang_another ) {
                                                    if ( $language_code == $lang_another ) {
                                                        if( !empty($arr_HierarchicalTree[$key]['term_string_translations'][$key1]['term_string']) ){
                                                            $term_string=$arr_HierarchicalTree[$key]['term_string_translations'][$key1]['term_string'];
                                                            unset($coringa);
                                                            break;
                                                        }
                                                    }
                                                } elseif ( $language_code == $lang_ths ){
                                                    if( !empty($arr_HierarchicalTree[$key]['term_string_translations'][$key1]['term_string']) ){
                                                        $term_string=$arr_HierarchicalTree[$key]['term_string_translations'][$key1]['term_string'];
                                                        unset($coringa);
                                                        break;
                                                    }
                                                }
                                            }


                                            if (!empty($term_string) and !empty($tree_number)) {

                                            ?>
                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $arr_HierarchicalTree[$key]['id'];?>">
                                            

                                            <?php 
                                            // Concatena string
                                            if (!empty($coringa)){
                                                $string=' ** ' . $term_string .' ( in English ) ** [' . $tree_number . ']';
                                            } else {
                                                $string= $term_string . ' [' . $tree_number . ']';
                                            }


                                            if (!empty($coringa)){
                                                $string2=' ** ' . $term_string .' ( in English ) **';
                                            } else {
                                                $string2= $term_string;
                                            }


                                            $tam_string=strlen($string);
                                            $tam=(intval($arr_HierarchicalTree[$key]['level'])*5)+$tam_string;

                                            $tam_string2=strlen($string2);
                                            $tam2=(intval($arr_HierarchicalTree[$key]['level'])*5)+$tam_string2;


                                            if (!empty($arr_HierarchicalTree[$key]['tree_number_registry'])){

                                            // Esconde em telas menores que lg
                                            // d-none d-sm-block

                                            // Esconde em telas maiores que lg
                                            // d-sm-none

                                            ?>
                                                <font color="red">
                                                    <div class="d-none d-sm-block">
                                                        <?php echo str_replace("-", "&nbsp;",str_pad($string,$tam,"-",STR_PAD_LEFT)); ?>
                                                        <?php if (!empty($arr_HierarchicalTree[$key]['leaf'])) { echo " +"; } ?>
                                                    </div>
                                                    <div class="d-sm-none">
                                                        <?php echo str_replace("-", "&nbsp;",str_pad($string2,$tam2,"-",STR_PAD_LEFT)); ?>
                                                        <?php if (!empty($arr_HierarchicalTree[$key]['leaf'])) { echo " +"; } ?>
                                                    </div>
                                                </font>

                                            <?php
                                            } else {
                                            ?>
                                                <div class="d-none d-sm-block">
                                                    <?php echo str_replace("-", "&nbsp;",str_pad($string,$tam,"-",STR_PAD_LEFT)); ?>
                                                    <?php if (!empty($arr_HierarchicalTree[$key]['leaf'])) { echo " +"; } ?>
                                                </div>
                                                <div class="d-sm-none">
                                                    <?php echo str_replace("-", "&nbsp;",str_pad($string2,$tam2,"-",STR_PAD_LEFT)); ?>
                                                    <?php if (!empty($arr_HierarchicalTree[$key]['leaf'])) { echo " +"; } ?>
                                                </div>
                                            <?php
                                            }
                                            ?>

                                            </a>

                                            <?php 

                                            }


                                        ?>

                                    </ul>
                                </li>
                            <?php

                                $tree_number_original_old=$tree_number_original;
                                $count++;

                            unset($term_string);
                            unset($tree_number);

                            }
                            ?>

                                    </td>
                                </tr>
                            </table>



                        </ul>
                    </div>

                    <?php                               
                    if ($has_descriptor){

                        // Cria array do conceito preferido e dos conceitos não preferidos
                        foreach ($arr_Concept_and_Term as $key => $value) { // Abre foreach teste
                            foreach ($arr_Concept_and_Term[$key] as $key1 => $value1) {
                                if ( $arr_Concept_and_Term[$key][$key1]['preferred_concept'] == 'Y' ) {
                                    // Armazena info somente do registro principal
                                    $arr_Principal[]=$arr_Concept_and_Term[$key][$key1];
                                } else {
                                    // Armazena info dos registros não principais
                                    $arr_NPrincipal[]=$arr_Concept_and_Term[$key][$key1];
                                }
                            }
                        }
                   ?>

                    <div class="tab-pane fade boxTree" id="Concepts" role="tabpanel" aria-labelledby="Concepts-tab">

                        <!-- PRINCIPAL Descritor -------------------------------------------------- -->
                        <?php
                        foreach ($arr_Principal as $key => $value) {

                            $id_concept_ui=$arr_Principal[$key]['concept_ui'];

                                foreach ($arr_Principal[$key]['TermListDesc'] as $key2 => $value2) {

                                    $language_code=convLang($arr_Principal[$key]['TermListDesc'][$key2]['language_code']);

                                    if ( $lang_another ) {
                                        $lang_another=convLang($lang_another);
                                        if ( $language_code == $lang_another and $arr_Principal[$key]['TermListDesc'][$key2]['concept_preferred_term']=='Y') {
                                            $has_term_in_language=True;
                                        }
                                    } elseif ( $language_code == $lang_ths and $arr_Principal[$key]['TermListDesc'][$key2]['concept_preferred_term']=='Y') {
                                        $has_term_in_language=True;
                                    }

                                }

                                if ($has_term_in_language){
                                    foreach ($arr_Principal[$key]['TermListDesc'] as $key7 => $value7) {
                                        $language_code=convLang($arr_Principal[$key]['TermListDesc'][$key7]['language_code']);
                                        $lang_another=convLang($lang_another);

                                    if ( $lang_another ) {
                                        if ( $language_code == $lang_another and $arr_Principal[$key]['TermListDesc'][$key7]['concept_preferred_term']=='Y') {

                        ?>
                                            <a href="#<?php echo $arr_Principal[$key]['concept_ui']; ?>" data-toggle="collapse">
                        <?php
                                            echo $arr_Principal[$key]['TermListDesc'][$key7]['term_string']; 
                        ?>
                                            </a>

                                        <?php 
                                        $concept_relation_name=ConceptRelationName($arr_Principal[$key]['concept_relation_name'], $lang_ths);
                                            echo "- <i>".$concept_relation_name."</i>";
                                        ?>
                                        <br>
                                    <?php
                                        break;
                                        }
                                    } else {

                                        if ( $language_code == $lang_ths and $arr_Principal[$key]['TermListDesc'][$key7]['concept_preferred_term']=='Y') {
                        ?>
                                            <a href="#<?php echo $arr_Principal[$key]['concept_ui']; ?>" data-toggle="collapse">
                        <?php
                                            echo $arr_Principal[$key]['TermListDesc'][$key7]['term_string']; 
                        ?>
                                            </a>

                                        <?php 
                                            $concept_relation_name=ConceptRelationName($arr_Principal[$key]['concept_relation_name'], $lang_ths);
                                            echo "- <i>".$concept_relation_name."</i>";
                                        ?>
                                        <br>
                                    <?php
                                        break;
                                        }
                                    }
                                }

                            // Se não tem a tradução para a linguagem informa "Without translation"
                            if (!$has_term_in_language){
                                foreach ($arr_Principal[$key]['TermListDesc'] as $key6 => $value6) {
                            ?>
                                    <a href="#<?php echo $arr_Principal[$key]['concept_ui']; ?>" data-toggle="collapse"><b>
                            <?php
                                    echo pll_e('Without translation');
                            ?>
                                </b></a>

                                    <?php 
                                        $concept_relation_name=ConceptRelationName($arr_Principal[$key]['concept_relation_name'], $lang_ths);
                                        echo "<i>".$concept_relation_name."</i>";
                                    ?>
                                <br>
                            <?php
                                break;
                            }
                        } // foreach

                        
                        foreach ($arr_Principal[$key]['TermListDesc'] as $key2 => $value2) {
                        ?>
                            <table id="<?php echo $id_concept_ui; ?>" class="table tabel-sm table-striped collapse">
                                <tr>
                                    <td width="25%" class="text-right"><small><b><?php pll_e('Concept UI'); ?></b></small></td>
                                    <td>
                                        <small>
                                        <?php
                                        echo $arr_Principal[$key]['concept_ui']."<br>";
                                        ?>
                                        </small>
                                    </td>
                                </tr>
                        <?php
                        // Verifica a existência de Scope Note

                            foreach ($arr_Principal[$key]['ConceptListDesc'] as $key3 => $value3) {
                                if($arr_Principal[$key]['ConceptListDesc'][$key3]['scope_note']) {
                                    $has_scope_note=True;
                                    break;
                                }
                            }
                                if ($has_scope_note){
                                    // Scope Note
                                    foreach ($arr_Principal[$key]['ConceptListDesc'] as $key3 => $value3) {
                                    $language_code=convLang($arr_Principal[$key]['ConceptListDesc'][$key3]['language_code']);
                                        if ( $lang_another ) {
                                            $lang_another=convLang($lang_another);
                                            if ($language_code == $lang_another){
                        ?>
                                                <tr>
                                                    <td width="25%" class="text-right"><small><b><?php pll_e('Scope note'); ?></b></small></td>
                                                    <td>
                                                        <small>
                                                        <?php
                                                        echo $arr_Principal[$key]['ConceptListDesc'][$key3]['scope_note'];
                                                        ?>
                                                        </small>
                                                    </td>
                                                </tr>
                        <?php
                                            }
                                        } elseif ($language_code == $lang_ths){
                        ?>
                                            <tr>
                                                <td width="25%" class="text-right"><small><b><?php pll_e('Scope note'); ?></b></small></td>
                                                <td>
                                                    <small>
                                                    <?php
                                                    echo $arr_Principal[$key]['ConceptListDesc'][$key3]['scope_note'];
                                                    ?>
                                                    </small>
                                                </td>
                                            </tr>
                        <?php
                                        }
                                    }
                                    unset($has_scope_note);
                                }

                            foreach ($arr_Principal[$key]['TermListDesc'] as $key4 => $value4) {

                                $language_code=convLang($arr_Principal[$key]['TermListDesc'][$key4]['language_code']);

                                if ( $lang_another ) {
                                    $lang_another=convLang($lang_another);
                                    if ($language_code == $lang_another){

                                        if (
                                            ((
                                                $arr_Principal[$key]['preferred_concept']=='Y' and 
                                                $arr_Principal[$key]['TermListDesc'][$key4]['concept_preferred_term']=='Y' and 
                                                $arr_Principal[$key]['TermListDesc'][$key4]['record_preferred_term']=='Y' 
                                            )
                                            or 
                                            (
                                                $arr_Principal[$key]['preferred_concept']=='N' and 
                                                $arr_Principal[$key]['TermListDesc'][$key4]['concept_preferred_term']=='Y' and 
                                                $arr_Principal[$key]['TermListDesc'][$key4]['record_preferred_term']=='N' 
                                            )) 
                                            and
                                            ( $language_code == $lang_another )
                                        ){
                                            $arr_temp=array();
                                            $arr_temp['term_string']=$arr_Principal[$key]['TermListDesc'][$key4]['term_string'];
                                            $arr_temp['language_code']=$arr_Principal[$key]['TermListDesc'][$key4]['language_code'];
                                            $arr_PreferredTerms[]=$arr_temp;
                                        }
                                    }

                                } else {

                                    if (
                                        ((
                                            $arr_Principal[$key]['preferred_concept']=='Y' and 
                                            $arr_Principal[$key]['TermListDesc'][$key4]['concept_preferred_term']=='Y' and 
                                            $arr_Principal[$key]['TermListDesc'][$key4]['record_preferred_term']=='Y' 
                                        )
                                        or 
                                        (
                                            $arr_Principal[$key]['preferred_concept']=='N' and 
                                            $arr_Principal[$key]['TermListDesc'][$key4]['concept_preferred_term']=='Y' and 
                                            $arr_Principal[$key]['TermListDesc'][$key4]['record_preferred_term']=='N' 
                                        )) 
                                        and
                                        ( $language_code == $lang_ths )
                                    ){
                                        $arr_temp=array();
                                        $arr_temp['term_string']=$arr_Principal[$key]['TermListDesc'][$key4]['term_string'];
                                        $arr_temp['language_code']=$arr_Principal[$key]['TermListDesc'][$key4]['language_code'];
                                        $arr_PreferredTerms[]=$arr_temp;
                                    }
                                }

                            }

                            $arr_PreferredTerms = array_filter($arr_PreferredTerms); // Limpa array
                            usort($arr_PreferredTerms, "cmp"); 

                            foreach ($arr_PreferredTerms as $k1 => $value) {
                        ?>
                                <tr>
                                    <td width="25%" class="text-right"><small><b><?php pll_e('Preferred term'); ?></b></small></td>
                                    <td>
                                        <small>
                        <?php
                                            echo $arr_PreferredTerms[$k1]['term_string'];
                        ?>
                                        </small>
                                    </td>
                                </tr>
                        <?php
                            }
                            unset($arr_PreferredTerms);
                        ?>

                        <?php

                            // Verifica a existência de Sinônimo
                            foreach ($arr_Principal[$key]['TermListDesc'] as $key5 => $value5) {
                                $language_code=convLang($arr_Principal[$key]['TermListDesc'][$key5]['language_code']);

                                if ( $lang_another ) {
                                    $lang_another=convLang($lang_another);
                                    if ($language_code == $lang_another){

                                        if (
                                            ((
                                                $arr_Principal[$key]['preferred_concept']=='Y' and 
                                                $arr_Principal[$key]['TermListDesc'][$key5]['concept_preferred_term']=='N' and 
                                                $arr_Principal[$key]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                            )
                                            or 
                                            (
                                                $arr_Principal[$key]['preferred_concept']=='N' and 
                                                $arr_Principal[$key]['TermListDesc'][$key5]['concept_preferred_term']=='N' and 
                                                $arr_Principal[$key]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                            )) 
                                            and
                                            $language_code == $lang_another
                                        ){
                                            $has_synonymous=True;
                                        }

                                    }
                                } elseif (
                                    ((
                                        $arr_Principal[$key]['preferred_concept']=='Y' and 
                                        $arr_Principal[$key]['TermListDesc'][$key5]['concept_preferred_term']=='N' and 
                                        $arr_Principal[$key]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                    )
                                    or 
                                    (
                                        $arr_Principal[$key]['preferred_concept']=='N' and 
                                        $arr_Principal[$key]['TermListDesc'][$key5]['concept_preferred_term']=='N' and 
                                        $arr_Principal[$key]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                    )) 
                                    and
                                    $language_code == $lang_ths
                                ){
                                    $has_synonymous=True;
                                }

                            } // foreach

                            if ($has_synonymous){
                        ?>
                                <tr>
                                    <td width="25%" class="text-right"><small><b><?php pll_e('Entry term(s)'); ?></b></small></td>
                                    <td>
                                        <small>
                                        <?php
                                        unset($arr_EntryTerms);
                                        foreach ($arr_Principal[$key]['TermListDesc'] as $key5 => $value5) {
                                            $language_code=convLang($arr_Principal[$key]['TermListDesc'][$key5]['language_code']);

                                            if ( $lang_another ) {
                                                $lang_another=convLang($lang_another);
                                                if ($language_code == $lang_another){

                                                    if (
                                                        ((
                                                            $arr_Principal[$key]['preferred_concept']=='Y' and 
                                                            $arr_Principal[$key]['TermListDesc'][$key5]['record_preferred_term']=='N' and 
                                                            $arr_Principal[$key]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                                        )
                                                        or 
                                                        (
                                                            $arr_Principal[$key]['preferred_concept']=='N' and 
                                                            $arr_Principal[$key]['TermListDesc'][$key5]['concept_preferred_term']=='N' and 
                                                            $arr_Principal[$key]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                                        )) 
                                                        and
                                                            $language_code == $lang_another
                                                    ){

                                                        $arr_temp=array();
                                                        $arr_temp['term_string']=$arr_Principal[$key]['TermListDesc'][$key5]['term_string'];
                                                        $arr_temp['language_code']=$arr_Principal[$key]['TermListDesc'][$key5]['language_code'];
                                                        $arr_EntryTerms[]=$arr_temp;

                                                    }

                                                }
                                            } elseif (
                                                ((
                                                    $arr_Principal[$key]['preferred_concept']=='Y' and 
                                                    $arr_Principal[$key]['TermListDesc'][$key5]['record_preferred_term']=='N' and 
                                                    $arr_Principal[$key]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                                )
                                                or 
                                                (
                                                    $arr_Principal[$key]['preferred_concept']=='N' and 
                                                    $arr_Principal[$key]['TermListDesc'][$key5]['concept_preferred_term']=='N' and 
                                                    $arr_Principal[$key]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                                )) 
                                                and
                                                    $language_code == $lang_ths
                                            ){

                                                $arr_temp=array();
                                                $arr_temp['term_string']=$arr_Principal[$key]['TermListDesc'][$key5]['term_string'];
                                                $arr_temp['language_code']=$arr_Principal[$key]['TermListDesc'][$key5]['language_code'];
                                                $arr_EntryTerms[]=$arr_temp;

                                            }

                                        } // foreach

                                        $arr_EntryTerms = array_filter($arr_EntryTerms); // Limpa array
                                        $arr_EntryTerms = phparraysort($arr_EntryTerms, array('language_code','term_string'));

                                        $count=1;
                                        foreach ($arr_EntryTerms as $k5 => $v5) {

                                                if ($count==1){
                                                    ?>
                                                    <?php
                                                }

                                                echo $arr_EntryTerms[$k5]['term_string'];
                                                ?>
                                                <br>
                                                <?php
                                                $count++;
                                        }
                                        unset($arr_temp);
                                        unset($arr_EntryTerms);

                                        ?>
                                        </small>
                                    </td>
                                </tr>
                        <?php
                            }
                            unset($has_synonymous);
                        ?>

                            </table>
                        <?php

                            break;
                                }
                                unset($has_term_in_language);
                                }
                        } // fecha foreach ($arr_Principal[$key]['TermListDesc'] as $key2 => $value2) {
                        ?>

                        <!-- PRINCIPAL Descritor -------------------------------------------------- -->

                        <!-- NÃO PRINCIPAL Descritor ---------------------------------------------- -->

                        <?php
                        foreach ($arr_NPrincipal as $key => $value) {

                            $id_concept_ui=$arr_NPrincipal[$key]['concept_ui'];

                                foreach ($arr_NPrincipal[$key]['TermListDesc'] as $key2 => $value2) {

                                    $language_code=convLang($arr_NPrincipal[$key]['TermListDesc'][$key2]['language_code']);

                                    if ( $lang_another ) {
                                        $lang_another=convLang($lang_another);
                                        if ( $language_code == $lang_another and $arr_NPrincipal[$key]['TermListDesc'][$key2]['concept_preferred_term']=='Y') {
                                            $has_term_in_language=True;
                                        }
                                    } elseif ( $language_code == $lang_ths and $arr_NPrincipal[$key]['TermListDesc'][$key2]['concept_preferred_term']=='Y') {
                                        $has_term_in_language=True;
                                    }

                                }

                                if ($has_term_in_language){
                                    foreach ($arr_NPrincipal[$key]['TermListDesc'] as $key7 => $value7) {
                                        $language_code=convLang($arr_NPrincipal[$key]['TermListDesc'][$key7]['language_code']);
                                        $lang_another=convLang($lang_another);

                                    if ( $lang_another ) {
                                        if ( $language_code == $lang_another and $arr_NPrincipal[$key]['TermListDesc'][$key7]['concept_preferred_term']=='Y') {

                        ?>
                                            <a href="#<?php echo $arr_NPrincipal[$key]['concept_ui']; ?>" data-toggle="collapse">
                        <?php
                                            echo $arr_NPrincipal[$key]['TermListDesc'][$key7]['term_string']; 
                        ?>
                                            </a>

                                        <?php 
                                        $concept_relation_name=ConceptRelationName($arr_NPrincipal[$key]['concept_relation_name'], $lang_ths);
                                            echo "- <i>".$concept_relation_name."</i>";
                                        ?>
                                        <br>
                                    <?php
                                        break;
                                        }
                                    } else {

                                        if ( $language_code == $lang_ths and $arr_NPrincipal[$key]['TermListDesc'][$key7]['concept_preferred_term']=='Y') {
                        ?>
                                            <a href="#<?php echo $arr_NPrincipal[$key]['concept_ui']; ?>" data-toggle="collapse">
                        <?php
                                            echo $arr_NPrincipal[$key]['TermListDesc'][$key7]['term_string']; 
                        ?>
                                            </a>

                                        <?php 
                                            $concept_relation_name=ConceptRelationName($arr_NPrincipal[$key]['concept_relation_name'], $lang_ths);
                                            echo "- <i>".$concept_relation_name."</i>";
                                        ?>
                                        <br>
                                    <?php
                                        break;
                                        }
                                    }
                                }

                            // Se não tem a tradução para a linguagem informa "Without translation"
                            if (!$has_term_in_language){
                                foreach ($arr_NPrincipal[$key]['TermListDesc'] as $key6 => $value6) {
                            ?>
                                    <a href="#<?php echo $arr_NPrincipal[$key]['concept_ui']; ?>" data-toggle="collapse"><b>
                            <?php
                                    echo pll_e('Without translation');
                            ?>
                                </b></a>

                                    <?php 
                                        $concept_relation_name=ConceptRelationName($arr_NPrincipal[$key]['concept_relation_name'], $lang_ths);
                                        echo "<i>".$concept_relation_name."</i>";
                                    ?>
                                <br>
                            <?php
                                break;
                            }
                        } // foreach

                        
                        foreach ($arr_NPrincipal[$key]['TermListDesc'] as $key2 => $value2) {
                        ?>
                            <table id="<?php echo $id_concept_ui; ?>" class="table tabel-sm table-striped collapse">
                                <tr>
                                    <td width="25%" class="text-right"><small><b><?php pll_e('Concept UI'); ?></b></small></td>
                                    <td>
                                        <small>
                                        <?php
                                        echo $arr_NPrincipal[$key]['concept_ui']."<br>";
                                        ?>
                                        </small>
                                    </td>
                                </tr>
                        <?php
                        // Verifica a existência de Scope Note

                            foreach ($arr_NPrincipal[$key]['ConceptListDesc'] as $key3 => $value3) {
                                if($arr_NPrincipal[$key]['ConceptListDesc'][$key3]['scope_note']) {
                                    $has_scope_note=True;
                                    break;
                                }
                            }
                                if ($has_scope_note){
                                    // Scope Note
                                    foreach ($arr_NPrincipal[$key]['ConceptListDesc'] as $key3 => $value3) {
                                    $language_code=convLang($arr_NPrincipal[$key]['ConceptListDesc'][$key3]['language_code']);
                                        if ( $lang_another ) {
                                            $lang_another=convLang($lang_another);
                                            if ($language_code == $lang_another){
                        ?>
                                                <tr>
                                                    <td width="25%" class="text-right"><small><b><?php pll_e('Scope note'); ?></b></small></td>
                                                    <td>
                                                        <small>
                                                        <?php
                                                        echo $arr_NPrincipal[$key]['ConceptListDesc'][$key3]['scope_note'];
                                                        ?>
                                                        </small>
                                                    </td>
                                                </tr>
                        <?php
                                            }
                                        } elseif ($language_code == $lang_ths){
                        ?>
                                            <tr>
                                                <td width="25%" class="text-right"><small><b><?php pll_e('Scope note'); ?></b></small></td>
                                                <td>
                                                    <small>
                                                    <?php
                                                    echo $arr_NPrincipal[$key]['ConceptListDesc'][$key3]['scope_note'];
                                                    ?>
                                                    </small>
                                                </td>
                                            </tr>
                        <?php
                                        }
                                    }
                                    unset($has_scope_note);
                                }

                            foreach ($arr_NPrincipal[$key]['TermListDesc'] as $key4 => $value4) {

                                $language_code=convLang($arr_NPrincipal[$key]['TermListDesc'][$key4]['language_code']);

                                if ( $lang_another ) {
                                    $lang_another=convLang($lang_another);
                                    if ($language_code == $lang_another){

                                        if (
                                            ((
                                                $arr_NPrincipal[$key]['preferred_concept']=='Y' and 
                                                $arr_NPrincipal[$key]['TermListDesc'][$key4]['concept_preferred_term']=='Y' and 
                                                $arr_NPrincipal[$key]['TermListDesc'][$key4]['record_preferred_term']=='Y' 
                                            )
                                            or 
                                            (
                                                $arr_NPrincipal[$key]['preferred_concept']=='N' and 
                                                $arr_NPrincipal[$key]['TermListDesc'][$key4]['concept_preferred_term']=='Y' and 
                                                $arr_NPrincipal[$key]['TermListDesc'][$key4]['record_preferred_term']=='N' 
                                            )) 
                                            and
                                            ( $language_code == $lang_another )
                                        ){
                                            $arr_temp=array();
                                            $arr_temp['term_string']=$arr_NPrincipal[$key]['TermListDesc'][$key4]['term_string'];
                                            $arr_temp['language_code']=$arr_NPrincipal[$key]['TermListDesc'][$key4]['language_code'];
                                            $arr_PreferredTerms[]=$arr_temp;
                                        }
                                    }

                                } else {

                                    if (
                                        ((
                                            $arr_NPrincipal[$key]['preferred_concept']=='Y' and 
                                            $arr_NPrincipal[$key]['TermListDesc'][$key4]['concept_preferred_term']=='Y' and 
                                            $arr_NPrincipal[$key]['TermListDesc'][$key4]['record_preferred_term']=='Y' 
                                        )
                                        or 
                                        (
                                            $arr_NPrincipal[$key]['preferred_concept']=='N' and 
                                            $arr_NPrincipal[$key]['TermListDesc'][$key4]['concept_preferred_term']=='Y' and 
                                            $arr_NPrincipal[$key]['TermListDesc'][$key4]['record_preferred_term']=='N' 
                                        )) 
                                        and
                                        ( $language_code == $lang_ths )
                                    ){
                                        $arr_temp=array();
                                        $arr_temp['term_string']=$arr_NPrincipal[$key]['TermListDesc'][$key4]['term_string'];
                                        $arr_temp['language_code']=$arr_NPrincipal[$key]['TermListDesc'][$key4]['language_code'];
                                        $arr_PreferredTerms[]=$arr_temp;
                                    }
                                }

                            }

                            $arr_PreferredTerms = array_filter($arr_PreferredTerms); // Limpa array
                            usort($arr_PreferredTerms, "cmp"); 

                            foreach ($arr_PreferredTerms as $k1 => $value) {
                        ?>
                                <tr>
                                    <td width="25%" class="text-right"><small><b><?php pll_e('Preferred term'); ?></b></small></td>
                                    <td>
                                        <small>
                        <?php
                                            echo $arr_PreferredTerms[$k1]['term_string'];
                        ?>
                                        </small>
                                    </td>
                                </tr>
                        <?php
                            }
                            unset($arr_PreferredTerms);
                        ?>

                        <?php

                            // Verifica a existência de Sinônimo
                            foreach ($arr_NPrincipal[$key]['TermListDesc'] as $key5 => $value5) {
                                $language_code=convLang($arr_NPrincipal[$key]['TermListDesc'][$key5]['language_code']);

                                if ( $lang_another ) {
                                    $lang_another=convLang($lang_another);
                                    if ($language_code == $lang_another){

                                        if (
                                            ((
                                                $arr_NPrincipal[$key]['preferred_concept']=='Y' and 
                                                $arr_NPrincipal[$key]['TermListDesc'][$key5]['concept_preferred_term']=='N' and 
                                                $arr_NPrincipal[$key]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                            )
                                            or 
                                            (
                                                $arr_NPrincipal[$key]['preferred_concept']=='N' and 
                                                $arr_NPrincipal[$key]['TermListDesc'][$key5]['concept_preferred_term']=='N' and 
                                                $arr_NPrincipal[$key]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                            )) 
                                            and
                                            $language_code == $lang_another
                                        ){
                                            $has_synonymous=True;
                                        }

                                    }
                                } elseif (
                                    ((
                                        $arr_NPrincipal[$key]['preferred_concept']=='Y' and 
                                        $arr_NPrincipal[$key]['TermListDesc'][$key5]['concept_preferred_term']=='N' and 
                                        $arr_NPrincipal[$key]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                    )
                                    or 
                                    (
                                        $arr_NPrincipal[$key]['preferred_concept']=='N' and 
                                        $arr_NPrincipal[$key]['TermListDesc'][$key5]['concept_preferred_term']=='N' and 
                                        $arr_NPrincipal[$key]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                    )) 
                                    and
                                    $language_code == $lang_ths
                                ){
                                    $has_synonymous=True;
                                }

                            } // foreach

                            if ($has_synonymous){
                        ?>
                                <tr>
                                    <td width="25%" class="text-right"><small><b><?php pll_e('Entry term(s)'); ?></b></small></td>
                                    <td>
                                        <small>
                                        <?php
                                        unset($arr_EntryTerms);
                                        foreach ($arr_NPrincipal[$key]['TermListDesc'] as $key5 => $value5) {
                                            $language_code=convLang($arr_NPrincipal[$key]['TermListDesc'][$key5]['language_code']);

                                            if ( $lang_another ) {
                                                $lang_another=convLang($lang_another);
                                                if ($language_code == $lang_another){

                                                    if (
                                                        ((
                                                            $arr_NPrincipal[$key]['preferred_concept']=='Y' and 
                                                            $arr_NPrincipal[$key]['TermListDesc'][$key5]['record_preferred_term']=='N' and 
                                                            $arr_NPrincipal[$key]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                                        )
                                                        or 
                                                        (
                                                            $arr_NPrincipal[$key]['preferred_concept']=='N' and 
                                                            $arr_NPrincipal[$key]['TermListDesc'][$key5]['concept_preferred_term']=='N' and 
                                                            $arr_NPrincipal[$key]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                                        )) 
                                                        and
                                                            $language_code == $lang_another
                                                    ){

                                                        $arr_temp=array();
                                                        $arr_temp['term_string']=$arr_NPrincipal[$key]['TermListDesc'][$key5]['term_string'];
                                                        $arr_temp['language_code']=$arr_NPrincipal[$key]['TermListDesc'][$key5]['language_code'];
                                                        $arr_EntryTerms[]=$arr_temp;

                                                    }

                                                }
                                            } elseif (
                                                ((
                                                    $arr_NPrincipal[$key]['preferred_concept']=='Y' and 
                                                    $arr_NPrincipal[$key]['TermListDesc'][$key5]['record_preferred_term']=='N' and 
                                                    $arr_NPrincipal[$key]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                                )
                                                or 
                                                (
                                                    $arr_NPrincipal[$key]['preferred_concept']=='N' and 
                                                    $arr_NPrincipal[$key]['TermListDesc'][$key5]['concept_preferred_term']=='N' and 
                                                    $arr_NPrincipal[$key]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                                )) 
                                                and
                                                    $language_code == $lang_ths
                                            ){

                                                $arr_temp=array();
                                                $arr_temp['term_string']=$arr_NPrincipal[$key]['TermListDesc'][$key5]['term_string'];
                                                $arr_temp['language_code']=$arr_NPrincipal[$key]['TermListDesc'][$key5]['language_code'];
                                                $arr_EntryTerms[]=$arr_temp;

                                            }

                                        } // foreach

                                        $arr_EntryTerms = array_filter($arr_EntryTerms); // Limpa array
                                        $arr_EntryTerms = phparraysort($arr_EntryTerms, array('language_code','term_string'));

                                        $count=1;
                                        foreach ($arr_EntryTerms as $k5 => $v5) {

                                                if ($count==1){
                                                    ?>
                                                    <?php
                                                }

                                                echo $arr_EntryTerms[$k5]['term_string'];
                                                ?>
                                                <br>
                                                <?php
                                                $count++;
                                        }
                                        unset($arr_temp);
                                        unset($arr_EntryTerms);

                                        ?>
                                        </small>
                                    </td>
                                </tr>
                        <?php
                            }
                            unset($has_synonymous);
                        ?>

                            </table>
                        <?php

                            break;
                                }
                                unset($has_term_in_language);
                                }
                        } // fecha foreach ($arr_NPrincipal[$key]['TermListDesc'] as $key2 => $value2) {
                        ?>

                        <!-- NÃO PRINCIPAL Descritor ---------------------------------------------- -->

                    <?php
                    } // fecha if (!empty($has_descriptor)){
                    ?>


                    <?php                               
                    if (!empty($has_qualifier)){
                        // Cria array do conceito preferido e dos conceitos não preferidos
                        foreach ($arr_Concept_and_Term as $key => $value) { // Abre foreach teste
                            foreach ($arr_Concept_and_Term[$key] as $key1 => $value1) {
                                if ( $arr_Concept_and_Term[$key][$key1]['preferred_concept'] == 'Y' ) {
                                    // Armazena info somente do registro principal
                                    $arr_Principal[]=$arr_Concept_and_Term[$key][$key1];
                                } else {
                                    // Armazena info dos registros não principais
                                    $arr_NPrincipal[]=$arr_Concept_and_Term[$key][$key1];
                                }
                            }
                        }
                   ?>

                    <div class="tab-pane fade boxTree" id="Concepts" role="tabpanel" aria-labelledby="Concepts-tab">

                        <!-- PRINCIPAL qualificador -------------------------------------------------- -->

                        <?php
                        foreach ($arr_Principal as $key => $value) {

                            $id_concept_ui=$arr_Principal[$key]['concept_ui'];

                                foreach ($arr_Principal[$key]['TermListQualif'] as $key2 => $value2) {

                                    $language_code=convLang($arr_Principal[$key]['TermListQualif'][$key2]['language_code']);

                                    if ( $lang_another ) {
                                        $lang_another=convLang($lang_another);
                                        if ( $language_code == $lang_another and $arr_Principal[$key]['TermListQualif'][$key2]['concept_preferred_term']=='Y') {
                                            $has_term_in_language=True;
                                        }
                                    } elseif ( $language_code == $lang_ths and $arr_Principal[$key]['TermListQualif'][$key2]['concept_preferred_term']=='Y') {
                                        $has_term_in_language=True;
                                    }

                                }

                                if ($has_term_in_language){
                                    foreach ($arr_Principal[$key]['TermListQualif'] as $key7 => $value7) {
                                        $language_code=convLang($arr_Principal[$key]['TermListQualif'][$key7]['language_code']);
                                        $lang_another=convLang($lang_another);

                                    if ( $lang_another ) {
                                        if ( $language_code == $lang_another and $arr_Principal[$key]['TermListQualif'][$key7]['concept_preferred_term']=='Y') {

                        ?>
                                            <a href="#<?php echo $arr_Principal[$key]['concept_ui']; ?>" data-toggle="collapse">
                        <?php
                                            echo $arr_Principal[$key]['TermListQualif'][$key7]['term_string']; 
                        ?>
                                            </a>

                                        <?php 
                                        $concept_relation_name=ConceptRelationName($arr_Principal[$key]['concept_relation_name'], $lang_ths);
                                            echo "- <i>".$concept_relation_name."</i>";
                                        ?>
                                        <br>
                                    <?php
                                        break;
                                        }
                                    } else {

                                        if ( $language_code == $lang_ths and $arr_Principal[$key]['TermListQualif'][$key7]['concept_preferred_term']=='Y') {
                        ?>
                                            <a href="#<?php echo $arr_Principal[$key]['concept_ui']; ?>" data-toggle="collapse">
                        <?php
                                            echo $arr_Principal[$key]['TermListQualif'][$key7]['term_string']; 
                        ?>
                                            </a>

                                        <?php 
                                            $concept_relation_name=ConceptRelationName($arr_Principal[$key]['concept_relation_name'], $lang_ths);
                                            echo "- <i>".$concept_relation_name."</i>";
                                        ?>
                                        <br>
                                    <?php
                                        break;
                                        }
                                    }
                                }

                            // Se não tem a tradução para a linguagem informa "Without translation"
                            if (!$has_term_in_language){
                                foreach ($arr_Principal[$key]['TermListQualif'] as $key6 => $value6) {
                            ?>
                                    <a href="#<?php echo $arr_Principal[$key]['concept_ui']; ?>" data-toggle="collapse"><b>
                            <?php
                                    echo pll_e('Without translation');
                            ?>
                                </b></a>

                                    <?php 
                                        $concept_relation_name=ConceptRelationName($arr_Principal[$key]['concept_relation_name'], $lang_ths);
                                        echo "<i>".$concept_relation_name."</i>";
                                    ?>
                                <br>
                            <?php
                                break;
                            }
                        } // foreach

                        
                        foreach ($arr_Principal[$key]['TermListQualif'] as $key2 => $value2) {
                        ?>
                            <table id="<?php echo $id_concept_ui; ?>" class="table tabel-sm table-striped collapse">
                                <tr>
                                    <td width="25%" class="text-right"><small><b><?php pll_e('Concept UI'); ?></b></small></td>
                                    <td>
                                        <small>
                                        <?php
                                        echo $arr_Principal[$key]['concept_ui']."<br>";
                                        ?>
                                        </small>
                                    </td>
                                </tr>
                        <?php
                        // Verifica a existência de Scope Note

                            foreach ($arr_Principal[$key]['ConceptListQualif'] as $key3 => $value3) {
                                if($arr_Principal[$key]['ConceptListQualif'][$key3]['scope_note']) {
                                    $has_scope_note=True;
                                    break;
                                }
                            }
                                if ($has_scope_note){
                                    // Scope Note
                                    foreach ($arr_Principal[$key]['ConceptListQualif'] as $key3 => $value3) {
                                    $language_code=convLang($arr_Principal[$key]['ConceptListQualif'][$key3]['language_code']);
                                        if ( $lang_another ) {
                                            $lang_another=convLang($lang_another);
                                            if ($language_code == $lang_another){
                        ?>
                                                <tr>
                                                    <td width="25%" class="text-right"><small><b><?php pll_e('Scope note'); ?></b></small></td>
                                                    <td>
                                                        <small>
                                                        <?php
                                                        echo $arr_Principal[$key]['ConceptListQualif'][$key3]['scope_note'];
                                                        ?>
                                                        </small>
                                                    </td>
                                                </tr>
                        <?php
                                            }
                                        } elseif ($language_code == $lang_ths){
                        ?>
                                            <tr>
                                                <td width="25%" class="text-right"><small><b><?php pll_e('Scope note'); ?></b></small></td>
                                                <td>
                                                    <small>
                                                    <?php
                                                    echo $arr_Principal[$key]['ConceptListQualif'][$key3]['scope_note'];
                                                    ?>
                                                    </small>
                                                </td>
                                            </tr>
                        <?php
                                        }
                                    }
                                    unset($has_scope_note);
                                }

                            foreach ($arr_Principal[$key]['TermListQualif'] as $key4 => $value4) {

                                $language_code=convLang($arr_Principal[$key]['TermListQualif'][$key4]['language_code']);

                                if ( $lang_another ) {
                                    $lang_another=convLang($lang_another);
                                    if ($language_code == $lang_another){

                                        if (
                                            ((
                                                $arr_Principal[$key]['preferred_concept']=='Y' and 
                                                $arr_Principal[$key]['TermListQualif'][$key4]['concept_preferred_term']=='Y' and 
                                                $arr_Principal[$key]['TermListQualif'][$key4]['record_preferred_term']=='Y' 
                                            )
                                            or 
                                            (
                                                $arr_Principal[$key]['preferred_concept']=='N' and 
                                                $arr_Principal[$key]['TermListQualif'][$key4]['concept_preferred_term']=='Y' and 
                                                $arr_Principal[$key]['TermListQualif'][$key4]['record_preferred_term']=='N' 
                                            )) 
                                            and
                                            ( $language_code == $lang_another )
                                        ){
                                            $arr_temp=array();
                                            $arr_temp['term_string']=$arr_Principal[$key]['TermListQualif'][$key4]['term_string'];
                                            $arr_temp['language_code']=$arr_Principal[$key]['TermListQualif'][$key4]['language_code'];
                                            $arr_PreferredTerms[]=$arr_temp;
                                        }
                                    }

                                } else {

                                    if (
                                        ((
                                            $arr_Principal[$key]['preferred_concept']=='Y' and 
                                            $arr_Principal[$key]['TermListQualif'][$key4]['concept_preferred_term']=='Y' and 
                                            $arr_Principal[$key]['TermListQualif'][$key4]['record_preferred_term']=='Y' 
                                        )
                                        or 
                                        (
                                            $arr_Principal[$key]['preferred_concept']=='N' and 
                                            $arr_Principal[$key]['TermListQualif'][$key4]['concept_preferred_term']=='Y' and 
                                            $arr_Principal[$key]['TermListQualif'][$key4]['record_preferred_term']=='N' 
                                        )) 
                                        and
                                        ( $language_code == $lang_ths )
                                    ){
                                        $arr_temp=array();
                                        $arr_temp['term_string']=$arr_Principal[$key]['TermListQualif'][$key4]['term_string'];
                                        $arr_temp['language_code']=$arr_Principal[$key]['TermListQualif'][$key4]['language_code'];
                                        $arr_PreferredTerms[]=$arr_temp;
                                    }
                                }

                            }

                            $arr_PreferredTerms = array_filter($arr_PreferredTerms); // Limpa array
                            usort($arr_PreferredTerms, "cmp"); 

                            foreach ($arr_PreferredTerms as $k1 => $value) {
                        ?>
                                <tr>
                                    <td width="25%" class="text-right"><small><b><?php pll_e('Preferred term'); ?></b></small></td>
                                    <td>
                                        <small>
                        <?php
                                            echo $arr_PreferredTerms[$k1]['term_string'];
                        ?>
                                        </small>
                                    </td>
                                </tr>
                        <?php
                            }
                            unset($arr_PreferredTerms);
                        ?>

                        <?php

                            // Verifica a existência de Sinônimo
                            foreach ($arr_Principal[$key]['TermListQualif'] as $key5 => $value5) {
                                $language_code=convLang($arr_Principal[$key]['TermListQualif'][$key5]['language_code']);

                                if ( $lang_another ) {
                                    $lang_another=convLang($lang_another);
                                    if ($language_code == $lang_another){

                                        if (
                                            ((
                                                $arr_Principal[$key]['preferred_concept']=='Y' and 
                                                $arr_Principal[$key]['TermListQualif'][$key5]['concept_preferred_term']=='N' and 
                                                $arr_Principal[$key]['TermListQualif'][$key5]['record_preferred_term']=='N' 
                                            )
                                            or 
                                            (
                                                $arr_Principal[$key]['preferred_concept']=='N' and 
                                                $arr_Principal[$key]['TermListQualif'][$key5]['concept_preferred_term']=='N' and 
                                                $arr_Principal[$key]['TermListQualif'][$key5]['record_preferred_term']=='N' 
                                            )) 
                                            and
                                            $language_code == $lang_another
                                        ){
                                            $has_synonymous=True;
                                        }

                                    }
                                } elseif (
                                    ((
                                        $arr_Principal[$key]['preferred_concept']=='Y' and 
                                        $arr_Principal[$key]['TermListQualif'][$key5]['concept_preferred_term']=='N' and 
                                        $arr_Principal[$key]['TermListQualif'][$key5]['record_preferred_term']=='N' 
                                    )
                                    or 
                                    (
                                        $arr_Principal[$key]['preferred_concept']=='N' and 
                                        $arr_Principal[$key]['TermListQualif'][$key5]['concept_preferred_term']=='N' and 
                                        $arr_Principal[$key]['TermListQualif'][$key5]['record_preferred_term']=='N' 
                                    )) 
                                    and
                                    $language_code == $lang_ths
                                ){
                                    $has_synonymous=True;
                                }

                            } // foreach

                            if ($has_synonymous){
                        ?>
                                <tr>
                                    <td width="25%" class="text-right"><small><b><?php pll_e('Entry term(s)'); ?></b></small></td>
                                    <td>
                                        <small>
                                        <?php
                                        unset($arr_EntryTerms);
                                        foreach ($arr_Principal[$key]['TermListQualif'] as $key5 => $value5) {
                                            $language_code=convLang($arr_Principal[$key]['TermListQualif'][$key5]['language_code']);

                                            if ( $lang_another ) {
                                                $lang_another=convLang($lang_another);
                                                if ($language_code == $lang_another){

                                                    if (
                                                        ((
                                                            $arr_Principal[$key]['preferred_concept']=='Y' and 
                                                            $arr_Principal[$key]['TermListQualif'][$key5]['record_preferred_term']=='N' and 
                                                            $arr_Principal[$key]['TermListQualif'][$key5]['record_preferred_term']=='N' 
                                                        )
                                                        or 
                                                        (
                                                            $arr_Principal[$key]['preferred_concept']=='N' and 
                                                            $arr_Principal[$key]['TermListQualif'][$key5]['concept_preferred_term']=='N' and 
                                                            $arr_Principal[$key]['TermListQualif'][$key5]['record_preferred_term']=='N' 
                                                        )) 
                                                        and
                                                            $language_code == $lang_another
                                                    ){

                                                        $arr_temp=array();
                                                        $arr_temp['term_string']=$arr_Principal[$key]['TermListQualif'][$key5]['term_string'];
                                                        $arr_temp['language_code']=$arr_Principal[$key]['TermListQualif'][$key5]['language_code'];
                                                        $arr_EntryTerms[]=$arr_temp;

                                                    }

                                                }
                                            } elseif (
                                                ((
                                                    $arr_Principal[$key]['preferred_concept']=='Y' and 
                                                    $arr_Principal[$key]['TermListQualif'][$key5]['record_preferred_term']=='N' and 
                                                    $arr_Principal[$key]['TermListQualif'][$key5]['record_preferred_term']=='N' 
                                                )
                                                or 
                                                (
                                                    $arr_Principal[$key]['preferred_concept']=='N' and 
                                                    $arr_Principal[$key]['TermListQualif'][$key5]['concept_preferred_term']=='N' and 
                                                    $arr_Principal[$key]['TermListQualif'][$key5]['record_preferred_term']=='N' 
                                                )) 
                                                and
                                                    $language_code == $lang_ths
                                            ){

                                                $arr_temp=array();
                                                $arr_temp['term_string']=$arr_Principal[$key]['TermListQualif'][$key5]['term_string'];
                                                $arr_temp['language_code']=$arr_Principal[$key]['TermListQualif'][$key5]['language_code'];
                                                $arr_EntryTerms[]=$arr_temp;

                                            }

                                        } // foreach

                                        $arr_EntryTerms = array_filter($arr_EntryTerms); // Limpa array
                                        $arr_EntryTerms = phparraysort($arr_EntryTerms, array('language_code','term_string'));

                                        $count=1;
                                        foreach ($arr_EntryTerms as $k5 => $v5) {

                                                if ($count==1){
                                                    ?>
                                                    <?php
                                                }

                                                echo $arr_EntryTerms[$k5]['term_string'];
                                                ?>
                                                <br>
                                                <?php
                                                $count++;
                                        }
                                        unset($arr_temp);
                                        unset($arr_EntryTerms);

                                        ?>
                                        </small>
                                    </td>
                                </tr>
                        <?php
                            }
                            unset($has_synonymous);
                        ?>

                            </table>
                        <?php

                            break;
                                }
                                unset($has_term_in_language);
                                }
                        } // fecha foreach ($arr_Principal[$key]['TermListQualif'] as $key2 => $value2) {
                        ?>

                        <!-- PRINCIPAL qualificador -------------------------------------------------- -->

                        <!-- NÃO PRINCIPAL qualificador ---------------------------------------------- -->

                        <?php
                        foreach ($arr_NPrincipal as $key => $value) {

                            $id_concept_ui=$arr_NPrincipal[$key]['concept_ui'];

                                foreach ($arr_NPrincipal[$key]['TermListQualif'] as $key2 => $value2) {

                                    $language_code=convLang($arr_NPrincipal[$key]['TermListQualif'][$key2]['language_code']);

                                    if ( $lang_another ) {
                                        $lang_another=convLang($lang_another);
                                        if ( $language_code == $lang_another and $arr_NPrincipal[$key]['TermListQualif'][$key2]['concept_preferred_term']=='Y') {
                                            $has_term_in_language=True;
                                        }
                                    } elseif ( $language_code == $lang_ths and $arr_NPrincipal[$key]['TermListQualif'][$key2]['concept_preferred_term']=='Y') {
                                        $has_term_in_language=True;
                                    }

                                }

                                if ($has_term_in_language){
                                    foreach ($arr_NPrincipal[$key]['TermListQualif'] as $key7 => $value7) {
                                        $language_code=convLang($arr_NPrincipal[$key]['TermListQualif'][$key7]['language_code']);
                                        $lang_another=convLang($lang_another);

                                    if ( $lang_another ) {
                                        if ( $language_code == $lang_another and $arr_NPrincipal[$key]['TermListQualif'][$key7]['concept_preferred_term']=='Y') {

                        ?>
                                            <a href="#<?php echo $arr_NPrincipal[$key]['concept_ui']; ?>" data-toggle="collapse">
                        <?php
                                            echo $arr_NPrincipal[$key]['TermListQualif'][$key7]['term_string']; 
                        ?>
                                            </a>

                                        <?php 
                                        $concept_relation_name=ConceptRelationName($arr_NPrincipal[$key]['concept_relation_name'], $lang_ths);
                                            echo "- <i>".$concept_relation_name."</i>";
                                        ?>
                                        <br>
                                    <?php
                                        break;
                                        }
                                    } else {

                                        if ( $language_code == $lang_ths and $arr_NPrincipal[$key]['TermListQualif'][$key7]['concept_preferred_term']=='Y') {
                        ?>
                                            <a href="#<?php echo $arr_NPrincipal[$key]['concept_ui']; ?>" data-toggle="collapse">
                        <?php
                                            echo $arr_NPrincipal[$key]['TermListQualif'][$key7]['term_string']; 
                        ?>
                                            </a>

                                        <?php 
                                            $concept_relation_name=ConceptRelationName($arr_NPrincipal[$key]['concept_relation_name'], $lang_ths);
                                            echo "- <i>".$concept_relation_name."</i>";
                                        ?>
                                        <br>
                                    <?php
                                        break;
                                        }
                                    }
                                }

                            // Se não tem a tradução para a linguagem informa "Without translation"
                            if (!$has_term_in_language){
                                foreach ($arr_NPrincipal[$key]['TermListQualif'] as $key6 => $value6) {
                            ?>
                                    <a href="#<?php echo $arr_NPrincipal[$key]['concept_ui']; ?>" data-toggle="collapse"><b>
                            <?php
                                    echo pll_e('Without translation');
                            ?>
                                </b></a>

                                    <?php 
                                        $concept_relation_name=ConceptRelationName($arr_NPrincipal[$key]['concept_relation_name'], $lang_ths);
                                        echo "<i>".$concept_relation_name."</i>";
                                    ?>
                                <br>
                            <?php
                                break;
                            }
                        } // foreach

                        
                        foreach ($arr_NPrincipal[$key]['TermListQualif'] as $key2 => $value2) {
                        ?>
                            <table id="<?php echo $id_concept_ui; ?>" class="table tabel-sm table-striped collapse">
                                <tr>
                                    <td width="25%" class="text-right"><small><b><?php pll_e('Concept UI'); ?></b></small></td>
                                    <td>
                                        <small>
                                        <?php
                                        echo $arr_NPrincipal[$key]['concept_ui']."<br>";
                                        ?>
                                        </small>
                                    </td>
                                </tr>
                        <?php
                        // Verifica a existência de Scope Note

                            foreach ($arr_NPrincipal[$key]['ConceptListQualif'] as $key3 => $value3) {
                                if($arr_NPrincipal[$key]['ConceptListQualif'][$key3]['scope_note']) {
                                    $has_scope_note=True;
                                    break;
                                }
                            }
                                if ($has_scope_note){
                                    // Scope Note
                                    foreach ($arr_NPrincipal[$key]['ConceptListQualif'] as $key3 => $value3) {
                                    $language_code=convLang($arr_NPrincipal[$key]['ConceptListQualif'][$key3]['language_code']);
                                        if ( $lang_another ) {
                                            $lang_another=convLang($lang_another);
                                            if ($language_code == $lang_another){
                        ?>
                                                <tr>
                                                    <td width="25%" class="text-right"><small><b><?php pll_e('Scope note'); ?></b></small></td>
                                                    <td>
                                                        <small>
                                                        <?php
                                                        echo $arr_NPrincipal[$key]['ConceptListQualif'][$key3]['scope_note'];
                                                        ?>
                                                        </small>
                                                    </td>
                                                </tr>
                        <?php
                                            }
                                        } elseif ($language_code == $lang_ths){
                        ?>
                                            <tr>
                                                <td width="25%" class="text-right"><small><b><?php pll_e('Scope note'); ?></b></small></td>
                                                <td>
                                                    <small>
                                                    <?php
                                                    echo $arr_NPrincipal[$key]['ConceptListQualif'][$key3]['scope_note'];
                                                    ?>
                                                    </small>
                                                </td>
                                            </tr>
                        <?php
                                        }
                                    }
                                    unset($has_scope_note);
                                }

                            foreach ($arr_NPrincipal[$key]['TermListQualif'] as $key4 => $value4) {

                                $language_code=convLang($arr_NPrincipal[$key]['TermListQualif'][$key4]['language_code']);

                                if ( $lang_another ) {
                                    $lang_another=convLang($lang_another);
                                    if ($language_code == $lang_another){

                                        if (
                                            ((
                                                $arr_NPrincipal[$key]['preferred_concept']=='Y' and 
                                                $arr_NPrincipal[$key]['TermListQualif'][$key4]['concept_preferred_term']=='Y' and 
                                                $arr_NPrincipal[$key]['TermListQualif'][$key4]['record_preferred_term']=='Y' 
                                            )
                                            or 
                                            (
                                                $arr_NPrincipal[$key]['preferred_concept']=='N' and 
                                                $arr_NPrincipal[$key]['TermListQualif'][$key4]['concept_preferred_term']=='Y' and 
                                                $arr_NPrincipal[$key]['TermListQualif'][$key4]['record_preferred_term']=='N' 
                                            )) 
                                            and
                                            ( $language_code == $lang_another )
                                        ){
                                            $arr_temp=array();
                                            $arr_temp['term_string']=$arr_NPrincipal[$key]['TermListQualif'][$key4]['term_string'];
                                            $arr_temp['language_code']=$arr_NPrincipal[$key]['TermListQualif'][$key4]['language_code'];
                                            $arr_PreferredTerms[]=$arr_temp;
                                        }
                                    }

                                } else {

                                    if (
                                        ((
                                            $arr_NPrincipal[$key]['preferred_concept']=='Y' and 
                                            $arr_NPrincipal[$key]['TermListQualif'][$key4]['concept_preferred_term']=='Y' and 
                                            $arr_NPrincipal[$key]['TermListQualif'][$key4]['record_preferred_term']=='Y' 
                                        )
                                        or 
                                        (
                                            $arr_NPrincipal[$key]['preferred_concept']=='N' and 
                                            $arr_NPrincipal[$key]['TermListQualif'][$key4]['concept_preferred_term']=='Y' and 
                                            $arr_NPrincipal[$key]['TermListQualif'][$key4]['record_preferred_term']=='N' 
                                        )) 
                                        and
                                        ( $language_code == $lang_ths )
                                    ){
                                        $arr_temp=array();
                                        $arr_temp['term_string']=$arr_NPrincipal[$key]['TermListQualif'][$key4]['term_string'];
                                        $arr_temp['language_code']=$arr_NPrincipal[$key]['TermListQualif'][$key4]['language_code'];
                                        $arr_PreferredTerms[]=$arr_temp;
                                    }
                                }

                            }

                            $arr_PreferredTerms = array_filter($arr_PreferredTerms); // Limpa array
                            usort($arr_PreferredTerms, "cmp"); 

                            foreach ($arr_PreferredTerms as $k1 => $value) {
                        ?>
                                <tr>
                                    <td width="25%" class="text-right"><small><b><?php pll_e('Preferred term'); ?></b></small></td>
                                    <td>
                                        <small>
                        <?php
                                            echo $arr_PreferredTerms[$k1]['term_string'];
                        ?>
                                        </small>
                                    </td>
                                </tr>
                        <?php
                            }
                            unset($arr_PreferredTerms);
                        ?>

                        <?php

                            // Verifica a existência de Sinônimo
                            foreach ($arr_NPrincipal[$key]['TermListQualif'] as $key5 => $value5) {
                                $language_code=convLang($arr_NPrincipal[$key]['TermListQualif'][$key5]['language_code']);

                                if ( $lang_another ) {
                                    $lang_another=convLang($lang_another);
                                    if ($language_code == $lang_another){

                                        if (
                                            ((
                                                $arr_NPrincipal[$key]['preferred_concept']=='Y' and 
                                                $arr_NPrincipal[$key]['TermListQualif'][$key5]['concept_preferred_term']=='N' and 
                                                $arr_NPrincipal[$key]['TermListQualif'][$key5]['record_preferred_term']=='N' 
                                            )
                                            or 
                                            (
                                                $arr_NPrincipal[$key]['preferred_concept']=='N' and 
                                                $arr_NPrincipal[$key]['TermListQualif'][$key5]['concept_preferred_term']=='N' and 
                                                $arr_NPrincipal[$key]['TermListQualif'][$key5]['record_preferred_term']=='N' 
                                            )) 
                                            and
                                            $language_code == $lang_another
                                        ){
                                            $has_synonymous=True;
                                        }

                                    }
                                } elseif (
                                    ((
                                        $arr_NPrincipal[$key]['preferred_concept']=='Y' and 
                                        $arr_NPrincipal[$key]['TermListQualif'][$key5]['concept_preferred_term']=='N' and 
                                        $arr_NPrincipal[$key]['TermListQualif'][$key5]['record_preferred_term']=='N' 
                                    )
                                    or 
                                    (
                                        $arr_NPrincipal[$key]['preferred_concept']=='N' and 
                                        $arr_NPrincipal[$key]['TermListQualif'][$key5]['concept_preferred_term']=='N' and 
                                        $arr_NPrincipal[$key]['TermListQualif'][$key5]['record_preferred_term']=='N' 
                                    )) 
                                    and
                                    $language_code == $lang_ths
                                ){
                                    $has_synonymous=True;
                                }

                            } // foreach

                            if ($has_synonymous){
                        ?>
                                <tr>
                                    <td width="25%" class="text-right"><small><b><?php pll_e('Entry term(s)'); ?></b></small></td>
                                    <td>
                                        <small>
                                        <?php
                                        unset($arr_EntryTerms);
                                        foreach ($arr_NPrincipal[$key]['TermListQualif'] as $key5 => $value5) {
                                            $language_code=convLang($arr_NPrincipal[$key]['TermListQualif'][$key5]['language_code']);

                                            if ( $lang_another ) {
                                                $lang_another=convLang($lang_another);
                                                if ($language_code == $lang_another){

                                                    if (
                                                        ((
                                                            $arr_NPrincipal[$key]['preferred_concept']=='Y' and 
                                                            $arr_NPrincipal[$key]['TermListQualif'][$key5]['record_preferred_term']=='N' and 
                                                            $arr_NPrincipal[$key]['TermListQualif'][$key5]['record_preferred_term']=='N' 
                                                        )
                                                        or 
                                                        (
                                                            $arr_NPrincipal[$key]['preferred_concept']=='N' and 
                                                            $arr_NPrincipal[$key]['TermListQualif'][$key5]['concept_preferred_term']=='N' and 
                                                            $arr_NPrincipal[$key]['TermListQualif'][$key5]['record_preferred_term']=='N' 
                                                        )) 
                                                        and
                                                            $language_code == $lang_another
                                                    ){

                                                        $arr_temp=array();
                                                        $arr_temp['term_string']=$arr_NPrincipal[$key]['TermListQualif'][$key5]['term_string'];
                                                        $arr_temp['language_code']=$arr_NPrincipal[$key]['TermListQualif'][$key5]['language_code'];
                                                        $arr_EntryTerms[]=$arr_temp;

                                                    }

                                                }
                                            } elseif (
                                                ((
                                                    $arr_NPrincipal[$key]['preferred_concept']=='Y' and 
                                                    $arr_NPrincipal[$key]['TermListQualif'][$key5]['record_preferred_term']=='N' and 
                                                    $arr_NPrincipal[$key]['TermListQualif'][$key5]['record_preferred_term']=='N' 
                                                )
                                                or 
                                                (
                                                    $arr_NPrincipal[$key]['preferred_concept']=='N' and 
                                                    $arr_NPrincipal[$key]['TermListQualif'][$key5]['concept_preferred_term']=='N' and 
                                                    $arr_NPrincipal[$key]['TermListQualif'][$key5]['record_preferred_term']=='N' 
                                                )) 
                                                and
                                                    $language_code == $lang_ths
                                            ){

                                                $arr_temp=array();
                                                $arr_temp['term_string']=$arr_NPrincipal[$key]['TermListQualif'][$key5]['term_string'];
                                                $arr_temp['language_code']=$arr_NPrincipal[$key]['TermListQualif'][$key5]['language_code'];
                                                $arr_EntryTerms[]=$arr_temp;

                                            }

                                        } // foreach

                                        $arr_EntryTerms = array_filter($arr_EntryTerms); // Limpa array
                                        $arr_EntryTerms = phparraysort($arr_EntryTerms, array('language_code','term_string'));

                                        $count=1;
                                        foreach ($arr_EntryTerms as $k5 => $v5) {

                                                if ($count==1){
                                                    ?>
                                                    <?php
                                                }

                                                echo $arr_EntryTerms[$k5]['term_string'];
                                                ?>
                                                <br>
                                                <?php
                                                $count++;
                                        }
                                        unset($arr_temp);
                                        unset($arr_EntryTerms);

                                        ?>
                                        </small>
                                    </td>
                                </tr>
                        <?php
                            }
                            unset($has_synonymous);
                        ?>

                            </table>
                        <?php

                            break;
                                }
                                unset($has_term_in_language);
                                }
                        } // fecha foreach ($arr_NPrincipal[$key]['TermListQualif'] as $key2 => $value2) {
                        ?>

                        <!-- NÃO PRINCIPAL qualificador ---------------------------------------------- -->

                    <?php
                    } // fecha if (!empty($has_qualifier)){
                    ?>

                </div>
                <br>
            </div>
        </div>
        <div><br><br></div>

    </section>

<?php
} // fecha if($has_descriptor or $has_qualifier){
?>


<?php get_footer(); ?>


