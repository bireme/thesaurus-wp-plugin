<?php include 'plugin_thesaurus.php' ?>

<!-- Garante que o valor pequisado passe adiante -->
<?php
    $id = $_GET['id'];
    $q = $_GET['q'];
    $filter = $_GET['filter'];
?>

<?php get_header(); ?>

<?php get_template_part('includes/navInter') ?>

<?php $lang = pll_current_language(); ?>

<?php


$lang_another = $_GET[lang_another];
// echo "lang_another [".$lang_another."]<br>";
// echo "lang_another 2ltr[".substr($lang_another,0,2)."]<br>";
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

Function convLang($language_code){
    $language_code = htmlentities($language_code, null, 'utf-8');
    $language_code = str_replace("&lt;br&gt;","",$language_code);

    return $language_code;
}


function choice_category($categ,$lang){

    if ($lang=='en'){

        switch ($categ) {
            case 'A':
                $categ_string='ANATOMY';
                break;
            case 'B':
                $categ_string='ORGANISMS';
                break;
            case 'C':
                $categ_string='DISEASES';
                break;
            case 'D':
                $categ_string='CHEMICALS AND DRUGS';
                break;
            case 'E':
                $categ_string='ANALYTICAL, DIAGNOSTIC AND THERAPEUTIC TECHNIQUES, AND EQUIPMENT';
                break;
            case 'F':
                $categ_string='PSYCHIATRY AND PSYCHOLOGY';
                break;
            case 'G':
                $categ_string='PHENOMENA AND PROCESSES';
                break;
            case 'H':
                $categ_string='DISCIPLINES AND OCCUPATIONS';
                break;
            case 'I':
                $categ_string='ANTHROPOLOGY, EDUCATION, SOCIOLOGY, AND SOCIAL PHENOMENA';
                break;
            case 'J':
                $categ_string='TECHNOLOGY, INDUSTRY, AND AGRICULTURE';
                break;
            case 'K':
                $categ_string='HUMANITIES';
                break;
            case 'L':
                $categ_string='INFORMATION SCIENCE';
                break;
            case 'M':
                $categ_string='NAMED GROUPS';
                break;
            case 'N':
                $categ_string='HEALTH CARE';
                break;
            case 'V':
                $categ_string='PUBLICATION CHARACTERISTICS';
                break;
            case 'Z':
                $categ_string='GEOGRAPHICALS';
                break;

            case 'HP':
                $categ_string='HOMEOPATHY';
                break;
            case 'SP':
                $categ_string='PUBLIC HEALTH';
                break;
            case 'SH':
                $categ_string='SCIENCE AND HEALTH';
                break;
            case 'VS':
                $categ_string='HEALTH SURVEILLANCE';
                break;
            }

    } elseif ($lang=='es'){
        switch ($categ) {
            case 'A':
                $categ_string='ANATOMÍA';
                break;
            case 'B':
                $categ_string='ORGANISMOS';
                break;
            case 'C':
                $categ_string='ENFERMEDADES';
                break;
            case 'D':
                $categ_string='COMPUESTOS QUÍMICOS Y DROGAS';
                break;
            case 'E':
                $categ_string='TÉCNICAS Y EQUIPOS ANALÍTICOS, DIAGNÓSTICOS Y TERAPÉUTICOS';
                break;
            case 'F':
                $categ_string='PSIQUIATRÍA Y PSICOLOGÍA';
                break;
            case 'G':
                $categ_string='FENÓMENOS Y PROCESOS';
                break;
            case 'H':
                $categ_string='DISCIPLINAS Y OCUPACIONES';
                break;
            case 'I':
                $categ_string='ANTROPOLOGÍA, EDUCACIÓN, SOCIOLOGÍA Y FENÓMENOS SOCIALES';
                break;
            case 'J':
                $categ_string='TECNOLOGÍA, INDUSTRIA Y AGRICULTURA';
                break;
            case 'K':
                $categ_string='HUMANIDADES';
                break;
            case 'L':
                $categ_string='CIENCIA DE LA INFORMACIÓN';
                break;
            case 'M':
                $categ_string='DENOMINACIONES DE GRUPOS';
                break;
            case 'N':
                $categ_string='ATENCIÓN DE SALUD';
                break;
            case 'V':
                $categ_string='CARACTERÍSTICAS DE PUBLICACIONES';
                break;
            case 'Z':
                $categ_string='DENOMINACIONES GEOGRÁFICAS';
                break;

            case 'HP':
                $categ_string='HOMEOPATÍA';
                break;
            case 'SP':
                $categ_string='SALUD PÚBLICA';
                break;
            case 'SH':
                $categ_string='CIENCIA Y SALUD';
                break;
            case 'VS':
                $categ_string='VIGILANCIA SANITARIA';
                break;
            }
    } elseif ($lang=='pt'){

        switch ($categ) {
            case 'A':
                $categ_string='ANATOMIA';
                break;
            case 'B':
                $categ_string='ORGANISMOS';
                break;
            case 'C':
                $categ_string='DOENÇAS';
                break;
            case 'D':
                $categ_string='COMPOSTOS QUÍMICOS E DROGAS';
                break;
            case 'E':
                $categ_string='TÉCNICAS E EQUIPAMENTOS ANALÍTICOS, DIAGNÓSTICOS E TERAPÊUTICOS';
                break;
            case 'F':
                $categ_string='PSIQUIATRIA E PSICOLOGIA';
                break;
            case 'G':
                $categ_string='FENÔMENOS E PROCESSOS';
                break;
            case 'H':
                $categ_string='DISCIPLINAS E OCUPAÇÕES';
                break;
            case 'I':
                $categ_string='ANTROPOLOGIA, EDUCAÇÃO, SOCIOLOGIA E FENÔMENOS SOCIAIS';
                break;
            case 'J':
                $categ_string='TECNOLOGIA, INDÚSTRIA E AGRICULTURA';
                break;
            case 'K':
                $categ_string='HUMANITIES';
                break;
            case 'L':
                $categ_string='CIÊNCIA DA INFORMAÇÃO';
                break;
            case 'M':
                $categ_string='DENOMINAÇÕES DE GRUPOS';
                break;
            case 'N':
                $categ_string='ASSISTÊNCIA À SAÚDE';
                break;
            case 'V':
                $categ_string='CARACTERÍSTICAS DE PUBLICAÇÕES';
                break;
            case 'Z':
                $categ_string='DENOMINAÇÕES GEOGRÁFICAS';
                break;

            case 'HP':
                $categ_string='HOMEOPATIA';
                break;
            case 'SP':
                $categ_string='SAÚDE PÚBLICA';
                break;
            case 'SH':
                $categ_string='CIÊNCIA E SAÚDE';
                break;
            case 'VS':
                $categ_string='VIGILÂNCIA SANITÁRIA';
                break;
            }

    } elseif ($lang=='fr') {

        switch ($categ) {
            case 'A':
                $categ_string='ANATOMIE';
                break;
            case 'B':
                $categ_string='ORGANISMES';
                break;
            case 'C':
                $categ_string='MALADIES';
                break;
            case 'D':
                $categ_string='PRODUITS CHIMIQUES ET PHARMACEUTIQUES';
                break;
            case 'E':
                $categ_string='TECHNIQUES ET ÉQUIPEMENTS ANALYTIQUES, DIAGNOSTIQUES ET THÉRAPEUTIQUES';
                break;
            case 'F':
                $categ_string='PSYCHIATRIE ET PSYCHOLOGIE';
                break;
            case 'G':
                $categ_string='PHÉNOMÈNES ET PROCESSUS';
                break;
            case 'H':
                $categ_string='DISCIPLINES ET PROFESSIONS';
                break;
            case 'I':
                $categ_string='ANTHROPOLOGIE, ENSEIGNEMENT, SOCIOLOGIE ET PHÉNOMÉNES SOCIAUX';
                break;
            case 'J':
                $categ_string='TECHNOLOGIE, INDUSTRIE ET AGRICULTURE';
                break;
            case 'K':
                $categ_string='SCIENCES HUMAINES';
                break;
            case 'L':
                $categ_string='SCIENCES DE L’INFORMATION ';
                break;
            case 'M':
                $categ_string='INDIVIDUS';
                break;
            case 'N':
                $categ_string='SANTÉ';
                break;
            case 'V':
                $categ_string='CARACTÉRISTIQUES D’UNE PUBLICATION';
                break;
            case 'Z':
                $categ_string='LIEUX GÉOGRAPHIQUES';
                break;

            case 'HP':
                $categ_string='HOMÉOPATHIE';
                break;
            case 'SP':
                $categ_string='SANTÉ PUBLIQUE';
                break;
            case 'SH':
                $categ_string='SCIENCE ET SANTÉ';
                break;
            case 'VS':
                $categ_string='SURVEILLANCE DE LA SANTÉ';
                break;
        }
    }

    return $categ_string;

}


// echo "<pre>"; print_r($arr_sym); echo "</pre>";

?>

<!-- 
    Template Name: Thesaurus Home 
-->

            <?php
            if($has_descriptor or $has_qualifier){
                ?>


    <section class="container containerAos">

    <?php
    if ( $lang_another) {
    ?>
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <?php pll_e('You have selected the view in'); ?>:
            <?php echo $lang_another ?>
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
                    if ($has_descriptor){ ?>

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

                            <a class="dropdown-item" href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $arr_IdentifierDesc[0]['decs_code'].'&filter='.$filter.'&q='.str_replace('\\', '', $q); ?>&lang_another=en"><?php pll_e('English'); ?></a>
                            <a class="dropdown-item" href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $arr_IdentifierDesc[0]['decs_code'].'&filter='.$filter.'&q='.str_replace('\\', '', $q); ?>&lang_another=es"><?php pll_e('Spanish'); ?></a>
                            <a class="dropdown-item" href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $arr_IdentifierDesc[0]['decs_code'].'&filter='.$filter.'&q='.str_replace('\\', '', $q); ?>&lang_another=pt-br"><?php pll_e('Portuguese'); ?></a>
                            <a class="dropdown-item" href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $arr_IdentifierDesc[0]['decs_code'].'&filter='.$filter.'&q='.str_replace('\\', '', $q); ?>&lang_another=fr"><?php pll_e('French'); ?></a>

                        </div>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent" data-aos="fade-up">
                    <div class="tab-pane fade show active" id="Details" role="tabpanel" aria-labelledby="Details-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm font12">

                                <?php
                                foreach ($arr_PreferredDescriptors as $key => $value) {
                                    if ( $arr_PreferredDescriptors[$key]['language_code'] == 'en' ){
                                    ?>
                                    <tr>
                                        <td class="text-right badge-descriptor tableWidth"><?php pll_e('Descriptor English'); ?>:</td>
                                        <td><b><?php echo $arr_PreferredDescriptors[$key]['term_string']; ?></b></td>
                                    </tr>
                                    <?php
                                    }
                                }

                                foreach ($arr_PreferredDescriptors as $key => $value) {
                                    if ( $arr_PreferredDescriptors[$key]['language_code'] == 'es' ){
                                    ?>
                                    <tr>
                                        <td class="text-right badge-descriptor tableWidth"><?php pll_e('Descriptor Spanish'); ?>:</td>
                                        <td><b><?php echo $arr_PreferredDescriptors[$key]['term_string']; ?></b></td>
                                    </tr>
                                    <?php
                                    }
                                }

                                foreach ($arr_PreferredDescriptors as $key => $value) {
                                    if ( $arr_PreferredDescriptors[$key]['language_code'] == 'pt-br' ){
                                    ?>
                                    <tr>
                                        <td class="text-right badge-descriptor tableWidth"><?php pll_e('Descriptor Portuguese'); ?>:</td>
                                        <td><b><?php echo $arr_PreferredDescriptors[$key]['term_string']; ?></b></td>
                                    </tr>
                                    <?php
                                    }
                                }

                                foreach ($arr_PreferredDescriptors as $key => $value) {
                                    if ( $arr_PreferredDescriptors[$key]['language_code'] == 'fr' ){
                                    ?>
                                    <tr>
                                        <td class="text-right badge-descriptor tableWidth"><?php pll_e('Descriptor French'); ?>:</td>
                                        <td><b><?php echo $arr_PreferredDescriptors[$key]['term_string']; ?></b></td>
                                    </tr>
                                    <?php
                                    }
                                }
                                ?>

                                <!-- Entry Term -->
                                <?php
                                if(!empty($arr_EntryTerms)){
                                ?>
                                <tr>
                                    <td class="text-right badge-light align-middle"><?php pll_e('Entry term(s)'); ?>:</td>
                                    <td>
                                        <?php
                                            foreach ($arr_EntryTerms as $key => $value) {
                                                $language_code=convLang($value['language_code']);
                                                if ( $lang_another ) {
                                                    if ( $language_code == $lang_another ) {
                                                        echo $value['term_string'].'<br>';
                                                    }
                                                } elseif ( $language_code == $lang_ths ){
                                                    echo $value['term_string'].'<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                }
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
                                ?>
                                <tr>
                                    <td class="text-right badge-light align-middle"><?php pll_e('Scope note'); ?>:</td>
                                    <td>
                                        <?php
                                            foreach ($arr_PreferredScopeNote as $key => $value) {
                                                $language_code=convLang($value['language_code']);
                                                if ( $lang_another ) {
                                                    if ( $language_code == $lang_another ) {
                                                        echo $value['scope_note'].'<br>';
                                                    }
                                                } elseif ( $language_code == $lang_ths ){
                                                    echo $value['scope_note'].'<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>

                                <!-- Annotation -->
                                <!-- Nota de Indexação -->
                                <?php
                                if(!empty($arr_Description)){
                                ?>
                                <tr>
                                    <td class="text-right badge-light align-middle"><?php pll_e('Annotation'); ?>:</td>
                                    <td>
                                        <?php
                                            foreach ($arr_Description as $key => $value) {
                                                $language_code=convLang($value['language_code']);
                                                if ( $lang_another ) {
                                                    if ( $language_code == $lang_another ) {
                                                        echo $value['annotation'].'<br>';
                                                    }
                                                } elseif ( $language_code == $lang_ths ){
                                                    echo $value['annotation'].'<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>

                                <!-- Allowable Qualifiers -->
                                <?php
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
                                                        <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $arr_AllowableQualifiers[$key][$key1]['decs_code'];?>" target="_blank"><?php echo $arr_AllowableQualifiers[$key][$key1]['term_string']; ?></a><br>
                                                        <?php
                                                    }
                                                } elseif ( $language_code == $lang_ths ){
                                                    echo $arr_AllowableQualifiers[$key][$key1]['abbreviation'];
                                                    ?>
                                                    <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $arr_AllowableQualifiers[$key][$key1]['decs_code'];?>" target="_blank"><?php echo $arr_AllowableQualifiers[$key][$key1]['term_string']; ?></a><br>
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
                                ?>


                                <?php
                                if ( $arr_IdentifierDesc[0]['decs_code'] ){
                                ?>
                                    <tr>
                                        <td class="text-right"><?php pll_e('DeCS ID'); ?>:</td>
                                        <td><?php echo $arr_IdentifierDesc[0]['decs_code']; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>



                                <?php
                                if ( $arr_IdentifierDesc[0]['descriptor_ui'] ){
                                ?>
                                    <tr>
                                        <td class="text-right">Identificador Único:</td>
                                        <td><?php echo $arr_IdentifierDesc[0]['descriptor_ui']; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                

                                <?php
                                if ( $arr_IdentifierDesc[0]['date_created'] ){
                                ?>
                                    <tr>
                                        <td class="text-right"><?php pll_e('Date of Entry'); ?>:</td>
                                        <td><?php echo $arr_IdentifierDesc[0]['date_created']; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>


                                <?php
                                if ( $arr_IdentifierDesc[0]['date_revised'] ){
                                ?>
                                    <tr>
                                        <td class="text-right"><?php pll_e('Revision Date'); ?>:</td>
                                        <td><?php echo $arr_IdentifierDesc[0]['date_revised']; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>


                            </table>
                        </div>
                    </div>


                    <div class="tab-pane fade boxTree" id="Tree_Structures" role="tabpanel" aria-labelledby="Tree_Structures-tab">
                        <ul class="listTree">


                                        <?php

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

                                                            if ( $lang_another ) {
                                                                if ( $language_code == $lang_another ) {
                                                                $term_string=$arr_HierarchicalTree[$key]['term_string_translations'][$key1]['term_string'];
                                                                }
                                                            } elseif ( $language_code == $lang_ths ){
                                                                $term_string=$arr_HierarchicalTree[$key]['term_string_translations'][$key1]['term_string'];
                                                            }

                                                        }

                                                        ?>
                                                        <a href="<?php echo real_site_url($ths_plugin_slug); ?>resource/?id=<?php echo $arr_HierarchicalTree[$key]['id'];?>">
                                                        

                                                        <?php 
                                                        // Concatena string
                                                        $string= $term_string . ' [' . $tree_number . ']';

                                                        $tam_string=strlen($string);
                                                        $tam=(intval($arr_HierarchicalTree[$key]['level'])*10)+$tam_string;

                                                        if (!empty($arr_HierarchicalTree[$key]['tree_number_registry'])){

                                                        ?>
                                                            <font color="red">
                                                            <?php echo str_replace("-", "&nbsp;",str_pad($string,$tam,"-",STR_PAD_LEFT)); ?>
                                                            </font>

                                                        <?php
                                                        } else {
                                                        ?>
                                                            <?php echo str_replace("-", "&nbsp;",str_pad($string,$tam,"-",STR_PAD_LEFT)); ?>
                                                        <?php
                                                        }
                                                        if (!empty($arr_HierarchicalTree[$key]['leaf'])) {
                                                            echo " +";
                                                        }
                                                        ?>

                                                        </a>

                                                        <?php 


                                                    ?>

                                                </ul>
                                            </li>
                                        <?php

                                            $tree_number_original_old=$tree_number_original;
                                            $count++;

                                        }
                                        ?>



                        </ul>
                    </div>

                <?php                               
                if ($has_descriptor){
                ?>
                    <div class="tab-pane fade boxTree" id="Concepts" role="tabpanel" aria-labelledby="Concepts-tab">

                        <?php
                        foreach ($arr_Concept_and_Term as $key => $value) {
                            foreach ($arr_Concept_and_Term[$key] as $key1 => $value1) {
                                $id_concept_ui=$arr_Concept_and_Term[$key][$key1]['concept_ui'];

                                foreach ($arr_Concept_and_Term[$key][$key1]['TermListDesc'] as $key2 => $value2) {

                                    $language_code=convLang($arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key2]['language_code']);

                                    if ( $lang_another ) {
                                        $lang_another=convLang($lang_another);
                                        if ( $language_code == $lang_another and $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key2]['concept_preferred_term']=='Y') {
                                            $has_term_in_language=True;
                                        }
                                    } elseif ( $language_code == $lang_ths and $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key2]['concept_preferred_term']=='Y') {
                                        $has_term_in_language=True;
                                    }

                                }

                                if ($has_term_in_language){
                                    foreach ($arr_Concept_and_Term[$key][$key1]['TermListDesc'] as $key7 => $value7) {
                                        $language_code=convLang($arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key7]['language_code']);
                                        $lang_another=convLang($lang_another);

                                    if ( $lang_another ) {
                                        if ( $language_code == $lang_another and $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key7]['concept_preferred_term']=='Y') {

                        ?>
                                            <a href="#<?php echo $arr_Concept_and_Term[$key][$key1]['concept_ui']; ?>" data-toggle="collapse">
                        <?php
                                            echo $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key7]['term_string']; 
                        ?>
                                            </a>

                                        <?php 
                                            $concept_relation_name=ConceptRelationName($arr_Concept_and_Term[$key][$key1]['concept_relation_name']);
                                            echo "- <i>".$concept_relation_name."</i>";
                                        ?>
                                        <br>
                                    <?php
                                        break;
                                        }
                                    } else {

                                        if ( $language_code == $lang_ths and $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key7]['concept_preferred_term']=='Y') {
                        ?>
                                            <a href="#<?php echo $arr_Concept_and_Term[$key][$key1]['concept_ui']; ?>" data-toggle="collapse">
                        <?php
                                            echo $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key7]['term_string']; 
                        ?>
                                            </a>

                                        <?php 
                                            $concept_relation_name=ConceptRelationName($arr_Concept_and_Term[$key][$key1]['concept_relation_name']);
                                            echo "- <i>".$concept_relation_name."</i>";
                                        ?>
                                        <br>
                                    <?php
                                        break;
                                        }
                                    }
                                }

                            }
                            // Se não tem a tradução para a linguagem pega a primeira que houver
                            if (!$has_term_in_language){
                                foreach ($arr_Concept_and_Term[$key][$key1]['TermListDesc'] as $key6 => $value6) {
                            ?>
                                    <a href="#<?php echo $arr_Concept_and_Term[$key][$key1]['concept_ui']; ?>" data-toggle="collapse"><b>
                            <?php
                                    echo "Without translation";
                                    // echo $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key6]['term_string']; 
                            ?>
                                </b></a>

<!--                                 <small class="badge badgeWarning">
                                    <?php echo $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key6]['language_code']; ?>
                                </small> -->

                                    <?php 
                                        $concept_relation_name=ConceptRelationName($arr_Concept_and_Term[$key][$key1]['concept_relation_name']);
                                        echo "<i>".$concept_relation_name."</i>";
                                    ?>
                                <br>
                            <?php
                                break;
                            }
                        }
                        foreach ($arr_Concept_and_Term[$key][$key1]['TermListDesc'] as $key2 => $value2) {
                        ?>
                            <table id="<?php echo $id_concept_ui; ?>" class="table tabel-sm table-striped collapse">
                                <tr>
                                    <td width="25%" class="text-right"><small><b><?php pll_e('Concept UI'); ?></b></small></td>
                                    <td>
                                        <small>
                                        <?php
                                        echo $arr_Concept_and_Term[$key][$key1]['concept_ui']."<br>";
                                        ?>
                                        </small>
                                    </td>
                                </tr>
                        <?php
                        // Verifica a existência de Scope Note
                        foreach ($arr_Concept_and_Term[$key][$key1]['ConceptListDesc'] as $key3 => $value3) {
                            if($arr_Concept_and_Term[$key][$key1]['ConceptListDesc'][$key3]['scope_note']) {
                                $has_scope_note=True;
                                break;
                            }
                        }
                            if ($has_scope_note){
                        ?>
                                <tr>
                                    <td width="25%" class="text-right"><small><b><?php pll_e('Scope note'); ?></b></small></td>
                                    <td>
                                        <small>
                                        <?php
                                        // Scope Note
                                        foreach ($arr_Concept_and_Term[$key][$key1]['ConceptListDesc'] as $key3 => $value3) {
                                        $language_code=convLang($arr_Concept_and_Term[$key][$key1]['ConceptListDesc'][$key3]['language_code']);

                                            if ( $lang_another ) {
                                                $lang_another=convLang($lang_another);
                                                if ($language_code == $lang_another){
                                                ?>
                                                    <p>
                                                        <?php
                                                        echo $arr_Concept_and_Term[$key][$key1]['ConceptListDesc'][$key3]['scope_note'];
                                                        ?>
                                                    </p>
                                                <?php
                                                }
                                            } elseif ($language_code == $lang_ths){
                                            ?>
                                                <p>
                                                    <?php
                                                    echo $arr_Concept_and_Term[$key][$key1]['ConceptListDesc'][$key3]['scope_note'];
                                                    ?>
                                                </p>
                                            <?php
                                            }
                                        }
                                        ?>
                                        </small>
                                    </td>
                                </tr>
                            <?php
                                unset($has_scope_note);
                            }
                            ?>
                                <tr>
                                    <td width="25%" class="text-right"><small><b><?php pll_e('Preferred term'); ?></b></small></td>
                                    <td>
                                        <small>
                                        <?php
                                        foreach ($arr_Concept_and_Term[$key][$key1]['TermListDesc'] as $key4 => $value4) {

                                            $language_code=convLang($arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key4]['language_code']);

                                            if ( $lang_another ) {
                                                $lang_another=convLang($lang_another);
                                                if ($language_code == $lang_another){

                                                    if (
                                                        ((
                                                            $arr_Concept_and_Term[$key][$key1]['preferred_concept']=='Y' and 
                                                            $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key4]['concept_preferred_term']=='Y' and 
                                                            $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key4]['record_preferred_term']=='Y' 
                                                        )
                                                        or 
                                                        (
                                                            $arr_Concept_and_Term[$key][$key1]['preferred_concept']=='N' and 
                                                            $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key4]['concept_preferred_term']=='Y' and 
                                                            $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key4]['record_preferred_term']=='N' 
                                                        )) 
                                                        and
                                                        ( $language_code == $lang_another )
                                                    ){
                                                        $arr_temp=array();
                                                        $arr_temp['term_string']=$arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key4]['term_string'];
                                                        $arr_temp['language_code']=$arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key4]['language_code'];
                                                        $arr_PreferredTerms[]=$arr_temp;
                                                    }
                                                }

                                            } else {

                                                if (
                                                    ((
                                                        $arr_Concept_and_Term[$key][$key1]['preferred_concept']=='Y' and 
                                                        $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key4]['concept_preferred_term']=='Y' and 
                                                        $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key4]['record_preferred_term']=='Y' 
                                                    )
                                                    or 
                                                    (
                                                        $arr_Concept_and_Term[$key][$key1]['preferred_concept']=='N' and 
                                                        $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key4]['concept_preferred_term']=='Y' and 
                                                        $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key4]['record_preferred_term']=='N' 
                                                    )) 
                                                    and
                                                    ( $language_code == $lang_ths )
                                                ){
                                                    $arr_temp=array();
                                                    $arr_temp['term_string']=$arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key4]['term_string'];
                                                    $arr_temp['language_code']=$arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key4]['language_code'];
                                                    $arr_PreferredTerms[]=$arr_temp;
                                                }
                                            }

                                        }


                                        $arr_PreferredTerms = array_filter($arr_PreferredTerms); // Limpa array
                                        usort($arr_PreferredTerms, "cmp"); 
                                        foreach ($arr_PreferredTerms as $k1 => $value) {
                                            echo $arr_PreferredTerms[$k1]['term_string'];
                                            ?>
                                            <?php
                                        }
                                        unset($arr_PreferredTerms);
                                        ?>
                                        </small>
                                    </td>
                                </tr>
                                <?php

                                // Verifica a existência de Sinônimo
                                foreach ($arr_Concept_and_Term[$key][$key1]['TermListDesc'] as $key5 => $value5) {
                                    $language_code=convLang($arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['language_code']);

                                    if ( $lang_another ) {
                                        $lang_another=convLang($lang_another);
                                        if ($language_code == $lang_another){

                                            if (
                                                ((
                                                    $arr_Concept_and_Term[$key][$key1]['preferred_concept']=='Y' and 
                                                    $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['concept_preferred_term']=='N' and 
                                                    $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                                )
                                                or 
                                                (
                                                    $arr_Concept_and_Term[$key][$key1]['preferred_concept']=='N' and 
                                                    $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['concept_preferred_term']=='N' and 
                                                    $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                                )) 
                                                and
                                                $language_code == $lang_another
                                            ){
                                                $has_synonymous=True;
                                            }

                                        }
                                    } elseif (
                                        ((
                                            $arr_Concept_and_Term[$key][$key1]['preferred_concept']=='Y' and 
                                            $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['concept_preferred_term']=='N' and 
                                            $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                        )
                                        or 
                                        (
                                            $arr_Concept_and_Term[$key][$key1]['preferred_concept']=='N' and 
                                            $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['concept_preferred_term']=='N' and 
                                            $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['record_preferred_term']=='N' 
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
                                            foreach ($arr_Concept_and_Term[$key][$key1]['TermListDesc'] as $key5 => $value5) {
                                                $language_code=convLang($arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['language_code']);


                                                if ( $lang_another ) {
                                                    $lang_another=convLang($lang_another);
                                                    if ($language_code == $lang_another){

                                                        if (
                                                            ((
                                                                $arr_Concept_and_Term[$key][$key1]['preferred_concept']=='Y' and 
                                                                $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['record_preferred_term']=='N' and 
                                                                $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                                            )
                                                            or 
                                                            (
                                                                $arr_Concept_and_Term[$key][$key1]['preferred_concept']=='N' and 
                                                                $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['concept_preferred_term']=='N' and 
                                                                $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                                            )) 
                                                            and
                                                                $language_code == $lang_another
                                                        ){

                                                            $arr_temp=array();
                                                            $arr_temp['term_string']=$arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['term_string'];
                                                            $arr_temp['language_code']=$arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['language_code'];
                                                            $arr_EntryTerms[]=$arr_temp;

                                                        }

                                                    }
                                                } elseif (
                                                    ((
                                                        $arr_Concept_and_Term[$key][$key1]['preferred_concept']=='Y' and 
                                                        $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['record_preferred_term']=='N' and 
                                                        $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                                    )
                                                    or 
                                                    (
                                                        $arr_Concept_and_Term[$key][$key1]['preferred_concept']=='N' and 
                                                        $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['concept_preferred_term']=='N' and 
                                                        $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['record_preferred_term']=='N' 
                                                    )) 
                                                    and
                                                        $language_code == $lang_ths
                                                ){

                                                    $arr_temp=array();
                                                    $arr_temp['term_string']=$arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['term_string'];
                                                    $arr_temp['language_code']=$arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['language_code'];
                                                    $arr_EntryTerms[]=$arr_temp;

                                                }

                                            } // foreach

                                            $arr_EntryTerms = array_filter($arr_EntryTerms); // Limpa array
                                            $arr_EntryTerms = phparraysort($arr_EntryTerms, array('language_code','term_string'));
                                            // usort($arr_EntryTerms, "cmp"); 

                                            $count=1;
                                            foreach ($arr_EntryTerms as $k5 => $v5) {

                                                    if ($count==1){
                                                        ?>
                                                        <?php
                                                    }

                                                    if ($count>1 and $lang_old!=$arr_EntryTerms[$k5]['language_code']){
                                                        ?>
                                                        <hr>
                                                        <small class="badge badgeWarning">
                                                            <?php
                                                            echo $arr_EntryTerms[$k5]['language_code']; 
                                                            ?>
                                                        </small><br>
                                                        <?php
                                                    }

                                                    echo $arr_EntryTerms[$k5]['term_string'];
                                                    ?>
                                                    <br>
                                                    <?php
                                                    $lang_old=$arr_EntryTerms[$k5]['language_code'];
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
                        }
                        ?>
                <?php
                }
                ?>

                <?php                               
                if (!empty($has_qualifier)){
                ?>
                    <div class="tab-pane fade boxTree" id="Concepts" role="tabpanel" aria-labelledby="Concepts-tab">

                        <?php
                        foreach ($arr_Concept_and_Term as $key => $value) {
                            foreach ($arr_Concept_and_Term[$key] as $key1 => $value1) {
                                $id_concept_ui=$arr_Concept_and_Term[$key][$key1]['concept_ui'];
                                // Determina se existe tradução para o idioma requerido - no caso pt-br está cravado mas poderá ser passado como paramentro pelo ambiente
                                foreach ($arr_Concept_and_Term[$key][$key1]['TermListQualif'] as $key2 => $value2) {
                                    $language_code=convLang($arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key2]['language_code']);

                                    if ($language_code == $lang_ths and $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key2]['concept_preferred_term']=='Y') {
                                        $has_term_in_language=True;
                                    }
                                }
                                if ($has_term_in_language){
                                    foreach ($arr_Concept_and_Term[$key][$key1]['TermListQualif'] as $key7 => $value7) {
                                        $language_code=convLang($arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key7]['language_code']);
                                        if ($language_code == $lang_ths and $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key7]['concept_preferred_term']=='Y') {
                        ?>
                                            <a href="#<?php echo $arr_Concept_and_Term[$key][$key1]['concept_ui']; ?>" data-toggle="collapse">
                        <?php
                                            echo $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key7]['term_string']; 
                        ?>
                                            </a>
                                            <?php 
                                                $concept_relation_name=ConceptRelationName($arr_Concept_and_Term[$key][$key1]['concept_relation_name']);
                                                echo "- <i>".$concept_relation_name."</i>";
                                            ?>
                                        <br>
                            <?php
                                        break;
                                    }
                                }
                            }
                            // Se não tem a tradução para a linguagem pega a primeira que houver
                            if (!$has_term_in_language){
                                foreach ($arr_Concept_and_Term[$key][$key1]['TermListQualif'] as $key6 => $value6) {
                            ?>
                                    <a href="#<?php echo $arr_Concept_and_Term[$key][$key1]['concept_ui']; ?>" data-toggle="collapse">
                            <?php
                                    echo $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key6]['term_string']; 
                            ?>
                                    </a>
                                    <?php 
                                        $concept_relation_name=ConceptRelationName($arr_Concept_and_Term[$key][$key1]['concept_relation_name']);
                                        echo "<i>".$concept_relation_name."</i>";
                                    ?>
                                <br>
                            <?php
                                break;
                            }
                        }
                        foreach ($arr_Concept_and_Term[$key][$key1]['TermListQualif'] as $key2 => $value2) {
                        ?>
                            <table id="<?php echo $id_concept_ui; ?>" class="table tabel-sm table-striped collapse">
                                <tr>
                                    <td width="25%" class="text-right"><small><b><?php pll_e('Concept UI'); ?></b></small></td>
                                    <td>
                                        <small>
                                        <?php
                                        echo $arr_Concept_and_Term[$key][$key1]['concept_ui']."<br>";
                                        ?>
                                        </small>
                                    </td>
                                </tr>
                        <?php
                        // Verifica a existência de Scope Note
                        foreach ($arr_Concept_and_Term[$key][$key1]['ConceptListQualif'] as $key3 => $value3) {
                            if($arr_Concept_and_Term[$key][$key1]['ConceptListQualif'][$key3]['scope_note']) {
                                $has_scope_note=True;
                                break;
                            }
                        }
                            if ($has_scope_note){
                        ?>
                                <tr>
                                    <td width="25%" class="text-right"><small><b><?php pll_e('Scope note'); ?></b></small></td>
                                    <td>
                                        <small>
                                        <?php
                                        // Scope Note
                                        foreach ($arr_Concept_and_Term[$key][$key1]['ConceptListQualif'] as $key3 => $value3) {
                                            $language_code=convLang($arr_Concept_and_Term[$key][$key1]['ConceptListQualif'][$key3]['language_code']);
                                            if ($language_code == $lang_ths){
                                        ?>
                                                <p>
                                                    <?php
                                                    echo $arr_Concept_and_Term[$key][$key1]['ConceptListQualif'][$key3]['scope_note'];
                                                    ?>
                                                </p>
                                        <?php
                                            }
                                        }
                                        ?>
                                        </small>
                                    </td>
                                </tr>
                            <?php
                                unset($has_scope_note);
                            }
                            ?>
                                <tr>
                                    <td width="25%" class="text-right"><small><b><?php pll_e('Preferred term'); ?></b></small></td>
                                    <td>
                                        <small>
                                        <?php
                                        foreach ($arr_Concept_and_Term[$key][$key1]['TermListQualif'] as $key4 => $value4) {
                                            $language_code=convLang($arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key4]['language_code']);
                                            if (
                                                ((
                                                    $arr_Concept_and_Term[$key][$key1]['preferred_concept']=='Y' and 
                                                    $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key4]['concept_preferred_term']=='Y' and 
                                                    $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key4]['record_preferred_term']=='Y' 
                                                )
                                                or 
                                                (
                                                    $arr_Concept_and_Term[$key][$key1]['preferred_concept']=='N' and 
                                                    $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key4]['concept_preferred_term']=='Y' and 
                                                    $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key4]['record_preferred_term']=='N' 
                                                )) 
                                                and 
                                                    $language_code == $lang_ths
                                            ){
                                                $arr_temp=array();
                                                $arr_temp['term_string']=$arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key4]['term_string'];
                                                $arr_temp['language_code']=$arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key4]['language_code'];
                                                $arr_PreferredTerms[]=$arr_temp;
                                            }
                                        }
                                        $arr_PreferredTerms = array_filter($arr_PreferredTerms); // Limpa array
                                        usort($arr_PreferredTerms, "cmp"); 
                                        foreach ($arr_PreferredTerms as $k1 => $value) {
                                            echo $arr_PreferredTerms[$k1]['term_string'];
                                            ?>
                                            <?php
                                        }
                                        unset($arr_PreferredTerms);
                                        ?>
                                        </small>
                                    </td>
                                </tr>
                                <?php
                                // Verifica a existência de Sinônimo
                                foreach ($arr_Concept_and_Term[$key][$key1]['TermListQualif'] as $key5 => $value5) {
                                    $language_code=convLang($arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key5]['language_code']);
                                    if (
                                        ((
                                            $arr_Concept_and_Term[$key][$key1]['preferred_concept']=='Y' and 
                                            $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key5]['concept_preferred_term']=='N' and 
                                            $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key5]['record_preferred_term']=='N' 
                                        )
                                        or 
                                        (
                                            $arr_Concept_and_Term[$key][$key1]['preferred_concept']=='N' and 
                                            $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key5]['concept_preferred_term']=='N' and 
                                            $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key5]['record_preferred_term']=='N' 
                                        )) 
                                        and 
                                            $language_code == $lang_ths
                                    ){
                                        $has_synonymous=True;
                                    }
                                }
                                if (!empty($has_synonymous)){
                                ?>
                                    <tr>
                                        <td width="25%" class="text-right"><small><b><?php pll_e('Entry term(s)'); ?></b></small></td>
                                        <td>
                                            <small>
                                            <?php
                                            unset($arr_EntryTerms);
                                            foreach ($arr_Concept_and_Term[$key][$key1]['TermListQualif'] as $key5 => $value5) {
                                                $language_code=convLang($arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key5]['language_code']);
                                                if (
                                                    ((
                                                        $arr_Concept_and_Term[$key][$key1]['preferred_concept']=='Y' and 
                                                        $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key5]['record_preferred_term']=='N' and 
                                                        $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key5]['record_preferred_term']=='N' 
                                                    )
                                                    or 
                                                    (
                                                        $arr_Concept_and_Term[$key][$key1]['preferred_concept']=='N' and 
                                                        $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key5]['concept_preferred_term']=='N' and 
                                                        $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key5]['record_preferred_term']=='N' 
                                                    )) 
                                                    and 
                                                        $language_code == $lang_ths
                                                ){

                                                    $arr_temp=array();
                                                    $arr_temp['term_string']=$arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key5]['term_string'];
                                                    $arr_temp['language_code']=$arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key5]['language_code'];
                                                    $arr_EntryTerms[]=$arr_temp;

                                                }
                                            }

                                            $arr_EntryTerms = array_filter($arr_EntryTerms); // Limpa array
                                            $arr_EntryTerms = phparraysort($arr_EntryTerms, array('language_code','term_string'));
                                            // usort($arr_EntryTerms, "cmp"); 

                                            $count=0;
                                            foreach ($arr_EntryTerms as $k5 => $v5) {

                                                    if ($count==0){
                                                        ?>
                                                        <?php
                                                    }

                                                    if ($count>1 and $lang_old!=$arr_EntryTerms[$k5]['language_code']){
                                                        ?>
                                                        <hr>
                                                        <small class="badge badgeWarning">
                                                            <?php
                                                            echo $arr_EntryTerms[$k5]['language_code']; 
                                                            ?>
                                                        </small><br>
                                                        <?php
                                                    }

                                                    echo $arr_EntryTerms[$k5]['term_string'];
                                                    ?>
                                                    <br>
                                                    <?php
                                                    $lang_old=$arr_EntryTerms[$k5]['language_code'];
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
                        }
                        ?>
                <?php
                }
                ?>

                </div>
                <br>
            </div>
        </div>
    </section>

            <?php
            }
            ?>


<?php get_footer(); ?>        