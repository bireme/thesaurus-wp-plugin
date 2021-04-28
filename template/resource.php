<?php
/*
Template Name: Thesaurus Home
*/
?>

<!-- Garante que o valor pequisado passe adiante -->
<?php
    $id = $_GET['id'];
    $q = $_GET['q'];
    $filter = $_GET['filter'];
?>

<?php get_header(); ?>

<?php
    $site_language = strtolower(get_bloginfo('language'));
    $lang = substr($site_language,0,2);
    $lang_another = $_GET['lang_another'];
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
?>

<?php include 'cachestart.php'; ?>

<?php include 'plugin_thesaurus.php'; ?>

<?php
if($has_descriptor or $has_qualifier){
?>

    <section class="container containerAos" id="main_container">

    <?php
    if ( $lang_another ) {
    ?>
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <?php _e('You have selected the view in','ths'); ?>
            <?php
                if ($lang_another == 'en'){
                    _e('English','ths');
                } elseif ($lang_another == 'es') {
                    _e('Spanish','ths');
                } elseif ($lang_another == 'pt-br') {
                    _e('Portuguese','ths');
                } elseif ($lang_another == 'fr') {
                    _e('French','ths');
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
                        <a class="nav-link active" id="Details-tab" data-toggle="tab" href="#Details" role="tab" aria-controls="Details" aria-selected="true"><?php _e('Details','ths'); ?></a>
                    </li>

                    <?php
                    if ($has_descriptor){
                    ?>

                        <li class="nav-item" data-aos="fade-left" data-aos-delay="400">
                            <a class="nav-link" id="Tree_Structures-tab" data-toggle="tab" href="#Tree_Structures" role="tab" aria-controls="Tree Structures" aria-selected="false"><?php _e('Tree Structures','ths'); ?></a>
                        </li>

                    <?php
                    }
                    ?>

                    <li class="nav-item" data-aos="fade-left" data-aos-delay="500">
                        <a class="nav-link" id="Concepts-tab" data-toggle="tab" href="#Concepts" role="tab" aria-controls="Concepts" aria-selected="false"><?php _e('Concepts','ths'); ?></a>
                    </li>


                    <li class="nav-item dropdownLang" data-aos="fade-right" data-aos-delay="600">
                        <a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php _e('See in another language','ths'); ?>
                            <i class="fas fa-globe-americas"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                            <a class="dropdown-item" href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php if ( $arr_IdentifierDesc[0]['decs_code']) { echo $arr_IdentifierDesc[0]['decs_code']; } elseif ( $arr_IdentifierQualif[0]['decs_code'] ) { echo $arr_IdentifierQualif[0]['decs_code']; } ?>&filter=<?php echo $filter; ?>&q=<?php echo stripslashes($q); ?>&lang_another=en"><?php _e('English','ths'); ?></a>

                            <a class="dropdown-item" href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php if ( $arr_IdentifierDesc[0]['decs_code']) { echo $arr_IdentifierDesc[0]['decs_code']; } elseif ( $arr_IdentifierQualif[0]['decs_code'] ) { echo $arr_IdentifierQualif[0]['decs_code']; } ?>&filter=<?php echo $filter; ?>&q=<?php echo stripslashes($q); ?>&lang_another=es"><?php _e('Spanish','ths'); ?></a>

                            <a class="dropdown-item" href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php if ( $arr_IdentifierDesc[0]['decs_code']) { echo $arr_IdentifierDesc[0]['decs_code']; } elseif ( $arr_IdentifierQualif[0]['decs_code'] ) { echo $arr_IdentifierQualif[0]['decs_code']; } ?>&filter=<?php echo $filter; ?>&q=<?php echo stripslashes($q); ?>&lang_another=pt-br"><?php _e('Portuguese','ths'); ?></a>

                            <a class="dropdown-item" href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php if ( $arr_IdentifierDesc[0]['decs_code']) { echo $arr_IdentifierDesc[0]['decs_code']; } elseif ( $arr_IdentifierQualif[0]['decs_code'] ) { echo $arr_IdentifierQualif[0]['decs_code']; } ?>&filter=<?php echo $filter; ?>&q=<?php echo stripslashes($q); ?>&lang_another=fr"><?php _e('French','ths'); ?></a>

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
                                            <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier English','ths'); } else { _e('Descriptor English','ths'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'en' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo _e('Without translation','ths');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier Spanish','ths'); } else { _e('Descriptor Spanish','ths'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'es' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo _e('Without translation','ths');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier Portuguese','ths'); } else { _e('Descriptor Portuguese','ths'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'pt-br' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo _e('Without translation','ths');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier French','ths'); } else { _e('Descriptor French','ths'); } ?>:
                                        </td><td><b>

                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'fr' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo _e('Without translation','ths');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                <?php
                                        break;

                                    case 'es':
                                ?>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier Spanish','ths'); } else { _e('Descriptor Spanish','ths'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'es' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo _e('Without translation','ths');}; unset($has_mh);

                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier English','ths'); } else { _e('Descriptor English','ths'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'en' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo _e('Without translation','ths');}; unset($has_mh);

                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier Portuguese','ths'); } else { _e('Descriptor Portuguese','ths'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'pt-br' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo _e('Without translation','ths');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier French','ths'); } else { _e('Descriptor French','ths'); } ?>:
                                        </td><td><b>

                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'fr' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo _e('Without translation','ths');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                <?php
                                        break;

                                    case 'pt':
                                ?>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier Portuguese','ths'); } else { _e('Descriptor Portuguese','ths'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'pt-br' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo _e('Without translation','ths');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier English','ths'); } else { _e('Descriptor English','ths'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'en' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo _e('Without translation','ths');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier Spanish','ths'); } else { _e('Descriptor Spanish','ths'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'es' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo _e('Without translation','ths');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier French','ths'); } else { _e('Descriptor French','ths'); } ?>:
                                        </td><td><b>

                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'fr' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo _e('Without translation','ths');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                <?php
                                        break;

                                    case 'fr':
                                ?>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier French','ths'); } else { _e('Descriptor French','ths'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'fr' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo _e('Without translation','ths');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier English','ths'); } else { _e('Descriptor English','ths'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'en' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo _e('Without translation','ths');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier Spanish','ths'); } else { _e('Descriptor Spanish','ths'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'es' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo _e('Without translation','ths');}; unset($has_mh);
                                ?>
                                        </b></td></tr>
                                        <tr><td class="text-right badge-descriptor tableWidth">
                                            <?php if ( $filter == 'ths_qualifall'){ _e('Qualifier Portuguese','ths'); } else { _e('Descriptor Portuguese','ths'); } ?>:
                                        </td><td><b>
                                <?php
                                    foreach ($arr_PreferredDescriptors as $key => $value) { if ( $arr_PreferredDescriptors[$key]['language_code'] == 'pt-br' ){ echo $arr_PreferredDescriptors[$key]['term_string']; $has_mh=TRUE; break; }}
                                    if (!$has_mh){ echo _e('Without translation','ths');}; unset($has_mh);
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
                                            <td class="text-right badge-light align-middle"><?php _e('Entry term(s)','ths'); ?>:</td>
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
                                    <td class="text-right badge-light align-middle"><?php _e('Tree number(s)','ths'); ?>:</td>
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

                                <!-- RDF Unique Identifier -->
                                <tr>
                                    <td class="text-right badge-light align-middle"><?php _e('RDF Unique Identifier','ths'); ?>:</td>
                                    <td>
                                        <?php
                                        $uid = '';
                                        if ( !empty($arr_IdentifierDesc[0]['descriptor_ui']) and substr( $arr_IdentifierDesc[0]['descriptor_ui'], 0, 4 ) !== "DDCS" ){
                                            $uid = $arr_IdentifierDesc[0]['descriptor_ui'];
                                        } elseif ( !empty($arr_IdentifierQualif[0]['qualifier_ui']) ){
                                            $uid = $arr_IdentifierQualif[0]['qualifier_ui'];
                                        }
                                        ?>
                                        <?php if ( !empty($uid) ) { ?>
                                        <a href="https://id.nlm.nih.gov/mesh/<?php echo $uid; ?>.html" target="_blank">https://id.nlm.nih.gov/mesh/<?php echo $uid; ?></a>
                                        <?php } ?>
                                    </td>
                                </tr>

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
                                                    <td class="text-right badge-light align-middle"><?php _e('Scope note','ths'); ?>:</td>
                                                    <td><?php echo $value['scope_note'].'<br>'; ?></td>
                                                </tr>
                                <?php
                                            }
                                        } elseif ( ($language_code == $lang_ths) and $value['scope_note'] ){
                                ?>
                                                <tr>
                                                    <td class="text-right badge-light align-middle"><?php _e('Scope note','ths'); ?>:</td>
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
                                                    <td class="text-right badge-light align-middle"><?php _e('Annotation','ths'); ?>:</td>
                                                    <td><?php echo $value['annotation'].'<br>'; ?></td>
                                                </tr>
                                <?php
                                            }
                                        } elseif ( ($language_code == $lang_ths) and $value['annotation'] ){
                                ?>
                                                <tr>
                                                    <td class="text-right badge-light align-middle"><?php _e('Annotation','ths'); ?>:</td>
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
                                                <td class="text-right badge-light align-middle"><?php _e('Allowable Qualifiers','ths'); ?>:</td>
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

                                <!-- Entry Combination -->
                                <?php
                                if (!empty($arr_EntryCombinationListDesc)){
                                    ?>
                                        <tr>
                                            <td class="text-right badge-light align-middle"><?php _e('Entry Combination','ths'); ?>:</td>
                                            <td>
                                    <?php
                                    foreach ($arr_EntryCombinationListDesc as $key => $value) {
                                        ?>
                                        <a href="<?php echo real_site_url($ths_plugin_slug); ?>?filter=ths_regid&q=<?php echo $value['ecout_desc_id']; ?>" target="_blank"><?php echo $value['ecin_qualif'].':'.$value['ecout_desc']; ?></a>
                                        <?php if ( $value['ecout_qualif'] ) { ?>
                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>?filter=ths_qualifall&q=<?php echo $value['ecout_qualif']; ?>" target="_blank"><?php echo '/'.$value['ecout_qualif']; ?></a>
                                        <?php } ?>
                                        <br />
                                        <?php
                                    }
                                    ?>
                                            </td>
                                        </tr>
                                    <?php
                                }
                                ?>

                                <!-- Pharmacological Action List -->
                                <?php
                                if(!empty($arr_PharmacologicalActionList)){
                                    $language_code=convLang($arr_PharmacologicalActionList[0]['language_code']);
                                    if ( $lang_another and $arr_PharmacologicalActionList[0]['term_string'] ) {
                                        if ( $language_code == $lang_another ) {
                                ?>
                                            <tr>
                                                <td class="text-right badge-light align-middle"><?php _e('Pharm Action','ths'); ?>:</td>
                                                <td>
                                                    <?php
                                                        foreach ($arr_PharmacologicalActionList as $key => $value) {
                                                            ?>
                                                            <a href="<?php echo real_site_url($ths_plugin_slug); ?>?filter=ths_termall&q=<?php echo $value['term_string']; ?>" target="_blank"><?php echo $value['term_string']; ?></a><br />
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                <?php
                                        }
                                    } elseif ( ($language_code == $lang_ths) and $arr_PharmacologicalActionList[0]['term_string'] ){
                                ?>
                                        <tr>
                                            <td class="text-right badge-light align-middle"><?php _e('Pharm Action','ths'); ?>:</td>
                                            <td>
                                                <?php
                                                    foreach ($arr_PharmacologicalActionList as $key => $value) {
                                                        ?>
                                                        <a href="<?php echo real_site_url($ths_plugin_slug); ?>?filter=ths_termall&q=<?php echo $value['term_string']; ?>" target="_blank"><?php echo $value['term_string']; ?></a><br />
                                                        <?php
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } // if
                                ?>

                                <!-- Registry Number -->
                                <?php
                                if(!empty($arr_PreferredRegistryNumber)){
                                ?>
                                <tr>
                                    <td class="text-right badge-light align-middle"><?php _e('Registry Number','ths'); ?>:</td>
                                    <td>
                                        <?php
                                        echo $arr_PreferredRegistryNumber[0]['registry_number'];
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>

                                <!-- CAS Type 1 Name -->
                                <?php
                                if(!empty($arr_CASN1_PreferredRegistryNumber)){
                                ?>
                                <tr>
                                    <td class="text-right badge-light align-middle"><?php _e('CAS Type 1 Name','ths'); ?>:</td>
                                    <td>
                                        <?php
                                        echo $arr_CASN1_PreferredRegistryNumber[0]['casn1_name'];
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>

                                <!-- Previous Indexing -->
                                <?php
                                if(!empty($arr_PreviousIndexingList)){
                                    $language_code=convLang($arr_PreviousIndexingList[0]['language_code']);
                                    if ( $lang_another and $arr_PreviousIndexingList[0]['previous_indexing'] ) {
                                        if ( $language_code == $lang_another ) {
                                ?>
                                            <tr>
                                                <td class="text-right badge-light align-middle"><?php _e('Previous Indexing','ths'); ?>:</td>
                                                <td>
                                                    <?php
                                                        foreach ($arr_PreviousIndexingList as $key => $value) {
                                                            echo $value['previous_indexing'].'<br />';
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                <?php
                                        }
                                    } elseif ( ($language_code == $lang_ths) and $arr_PreviousIndexingList[0]['previous_indexing'] ){
                                ?>
                                        <tr>
                                            <td class="text-right badge-light align-middle"><?php _e('Previous Indexing','ths'); ?>:</td>
                                            <td>
                                                <?php
                                                    foreach ($arr_PreviousIndexingList as $key => $value) {
                                                        echo $value['previous_indexing'].'<br />';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } // if
                                ?>

                                <!-- Public MeSH Note -->
                                <?php
                                if(!empty($arr_Description)){
                                    foreach ($arr_Description as $key => $value) {
                                        $language_code=convLang($value['language_code']);
                                        if ( $lang_another and $value['public_mesh_note'] ) {
                                            if ( $language_code == $lang_another ) {
                                ?>
                                                <tr>
                                                    <td class="text-right badge-light align-middle"><?php _e('Public MeSH Note','ths'); ?>:</td>
                                                    <td><?php echo $value['public_mesh_note'].'<br>'; ?></td>
                                                </tr>
                                <?php
                                            }
                                        } elseif ( ( $language_code == $lang_ths ) and $value['public_mesh_note'] ){
                                ?>
                                                <tr>
                                                    <td class="text-right badge-light align-middle"><?php _e('Public MeSH Note','ths'); ?>:</td>
                                                    <td><?php echo $value['public_mesh_note'].'<br>'; ?></td>
                                                </tr>
                                <?php
                                        }
                                    } // foreach
                                } // if
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
                                                    <td class="text-right badge-light align-middle"><?php _e('Online Note','ths'); ?>:</td>
                                                    <td><?php echo $value['online_note'].'<br>'; ?></td>
                                                </tr>
                                <?php
                                            }
                                        } elseif ( ( $language_code == $lang_ths ) and $value['online_note'] ){
                                ?>
                                                <tr>
                                                    <td class="text-right badge-light align-middle"><?php _e('Online Note','ths'); ?>:</td>
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
                                        if ( $lang_another and $value['history_note'] ) {
                                            if ( $language_code == $lang_another ) {
                                ?>
                                                <tr>
                                                    <td class="text-right badge-light align-middle"><?php _e('History Note','ths'); ?>:</td>
                                                    <td><?php echo $value['history_note'].'<br>'; ?></td>
                                                </tr>
                                <?php
                                            }
                                        } elseif ( ($language_code == $lang_ths) and $value['history_note'] ){
                                ?>
                                                <tr>
                                                    <td class="text-right badge-light align-middle"><?php _e('History Note','ths'); ?>:</td>
                                                    <td><?php echo $value['history_note'].'<br>'; ?></td>
                                                </tr>
                                <?php
                                        }
                                    } // foreach
                                } // if
                                ?>

                                <!-- Consider Also -->
                                <?php
                                if(!empty($arr_Description)){
                                    foreach ($arr_Description as $key => $value) {
                                        $language_code=convLang($value['language_code']);
                                        if ( $lang_another and $value['consider_also'] ) {
                                            if ( $language_code == $lang_another ) {
                                ?>
                                                <tr>
                                                    <td class="text-right badge-light align-middle"><?php _e('Consider Also','ths'); ?>:</td>
                                                    <td><?php echo $value['consider_also'].'<br>'; ?></td>
                                                </tr>
                                <?php
                                            }
                                        } elseif ( ($language_code == $lang_ths) and $value['consider_also'] ){
                                ?>
                                                <tr>
                                                    <td class="text-right badge-light align-middle"><?php _e('Consider Also','ths'); ?>:</td>
                                                    <td><?php echo $value['consider_also'].'<br>'; ?></td>
                                                </tr>
                                <?php
                                        }
                                    } // foreach
                                } // if
                                ?>

                                <!-- Entry Version - campo do qualificador -->
                                <?php
                                if(!empty($arr_PreferredDescriptors[0])){
                                    foreach ($arr_PreferredDescriptors as $key => $value) {
                                        $language_code=convLang($value['language_code']);
                                        if ( $lang_another and $value['entry_version'] ) {
                                            if ( $language_code == $lang_another ) {
                                ?>
                                                <tr>
                                                    <td class="text-right badge-light align-middle"><?php _e('Entry Version','ths'); ?>:</td>
                                                    <td><?php echo $value['entry_version'].'<br>'; ?></td>
                                                </tr>
                                <?php
                                            }
                                        } elseif ( ($language_code == $lang_ths) and $value['entry_version'] ){
                                ?>
                                                <tr>
                                                    <td class="text-right badge-light align-middle"><?php _e('Entry Version','ths'); ?>:</td>
                                                    <td><?php echo $value['entry_version'].'<br>'; ?></td>
                                                </tr>
                                <?php
                                        }
                                    } // foreach
                                } // if
                                ?>

                                <!-- Abbreviation - campo do qualificador -->
                                <?php
                                if(!empty($qualifier_abbreviation)){
                                ?>
                                <tr>
                                    <td class="text-right badge-light align-middle"><?php _e('Abbreviation','ths'); ?>:</td>
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
                                    <tr><td class="text-right badge-light align-middle"><?php _e('Related','ths'); ?>:</td><td>
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
                                    <td class="text-right badge-light align-middle"><?php _e('DeCS ID','ths'); ?>:</td>
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

                                <!-- DescriptorUI / QualifierUI -->
                                <tr>
                                    <td class="text-right badge-light align-middle"><?php _e('Unique ID','ths'); ?>:</td>
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

                                <!-- Documents indexed in the Virtual Health Library (VHL) -->
                                <?php $descriptors = wp_list_pluck( $arr_PreferredDescriptors, 'term_string', 'language_code' ); ?>
                                <tr>
                                    <td class="text-right badge-light align-middle"><?php _e('Documents indexed in the Virtual Health Library (VHL)','ths'); ?>:</td>
                                    <td style="vertical-align: middle;">
                                        <a href='<?php echo $vhl_portal_url; ?>/?q=mh:("<?php echo $descriptors[$lang_ths]; ?>")' target="_blank"><?php _e('Click here to access the VHL documents','ths'); ?></a>
                                    </td>
                                </tr>

                                <!-- Date Established -->
                                <?php
                                if ($has_descriptor){
                                    if ( !empty($arr_IdentifierDesc[0]['date_established']) ){
                                ?>
                                        <tr>
                                            <td class="text-right badge-light align-middle"><?php _e('Date Established','ths'); ?>:</td>
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
                                            <td class="text-right badge-light align-middle"><?php _e('Date Established','ths'); ?>:</td>
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
                                            <td class="text-right badge-light align-middle"><?php _e('Date of Entry','ths'); ?>:</td>
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
                                            <td class="text-right badge-light align-middle"><?php _e('Date of Entry','ths'); ?>:</td>
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
                                            <td class="text-right badge-light align-middle"><?php _e('Revision Date','ths'); ?>:</td>
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
                                            <td class="text-right badge-light align-middle"><?php _e('Revision Date','ths'); ?>:</td>
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

                            // echo "<pre>"; print_r($arr_HierarchicalTree); echo "</pre>"; die();

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

                                            if ( $lang_another ) { $lang = substr($lang_another,0,2); }
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
                                                    // $coringa=__('Without translation','ths').'['.$term_string=$arr_HierarchicalTree[$key]['term_string_translations'][$key1]['term_string'].']';
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
                                    echo _e('Without translation','ths');
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
                                    <td width="25%" class="text-right"><small><b><?php _e('Concept UI','ths'); ?></b></small></td>
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
                                                    <td width="25%" class="text-right"><small><b><?php _e('Scope note','ths'); ?></b></small></td>
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
                                                <td width="25%" class="text-right"><small><b><?php _e('Scope note','ths'); ?></b></small></td>
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
                                    <td width="25%" class="text-right"><small><b><?php _e('Preferred term','ths'); ?></b></small></td>
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
                                    <td width="25%" class="text-right"><small><b><?php _e('Entry term(s)','ths'); ?></b></small></td>
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
                                    echo _e('Without translation','ths');
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
                                    <td width="25%" class="text-right"><small><b><?php _e('Concept UI','ths'); ?></b></small></td>
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
                                                    <td width="25%" class="text-right"><small><b><?php _e('Scope note','ths'); ?></b></small></td>
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
                                                <td width="25%" class="text-right"><small><b><?php _e('Scope note','ths'); ?></b></small></td>
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
                                    <td width="25%" class="text-right"><small><b><?php _e('Preferred term','ths'); ?></b></small></td>
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
                                    <td width="25%" class="text-right"><small><b><?php _e('Entry term(s)','ths'); ?></b></small></td>
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
                                    echo _e('Without translation','ths');
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
                                    <td width="25%" class="text-right"><small><b><?php _e('Concept UI','ths'); ?></b></small></td>
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
                                                    <td width="25%" class="text-right"><small><b><?php _e('Scope note','ths'); ?></b></small></td>
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
                                                <td width="25%" class="text-right"><small><b><?php _e('Scope note','ths'); ?></b></small></td>
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
                                    <td width="25%" class="text-right"><small><b><?php _e('Preferred term','ths'); ?></b></small></td>
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
                                    <td width="25%" class="text-right"><small><b><?php _e('Entry term(s)','ths'); ?></b></small></td>
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
                                    echo _e('Without translation','ths');
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
                                    <td width="25%" class="text-right"><small><b><?php _e('Concept UI','ths'); ?></b></small></td>
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
                                                    <td width="25%" class="text-right"><small><b><?php _e('Scope note','ths'); ?></b></small></td>
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
                                                <td width="25%" class="text-right"><small><b><?php _e('Scope note','ths'); ?></b></small></td>
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
                                    <td width="25%" class="text-right"><small><b><?php _e('Preferred term','ths'); ?></b></small></td>
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
                                    <td width="25%" class="text-right"><small><b><?php _e('Entry term(s)','ths'); ?></b></small></td>
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

<?php include 'cacheend.php'; ?>