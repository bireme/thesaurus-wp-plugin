<?php include 'plugin_thesaurus.php' ?>
<?php get_template_part('includes/topAcessibility') ?>
<?php get_header(); ?>
<?php get_template_part('includes/search') ?>

<!-- 
    Template Name: Thesaurus Home 
-->

<section class="container">
    <section class="padding1">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo get_option('siteurl'); ?>">Home</a></li>
                </ol>
            </nav>

            <?php

            if($has_descriptor or $has_qualifier){
                ?>

                <div id="main_container">
                    <div class="row">
                        <div class="col-md-8">      
                            <h6 class="titleMain">

                                <?php
                                foreach ($arr_PreferredDescriptors as $key => $value) {
                                    ?>
                                    <p>
                                        <?php echo $arr_PreferredDescriptors[$key]['term_string']; ?>
                                        <small class="badge badgeWarning">
                                            <?php echo $arr_PreferredDescriptors[$key]['language_code']; ?>
                                        </small>
                                    </p>
                                    <?php
                                }
                                ?>

                            </h6>
                        </div>
                        <div class="col-md-4">
                            <small>
                            <?php
                            if ($has_descriptor) {
                                ?>
                                Unique ID: <?php echo $arr_IdentifierDesc[0]['descriptor_ui']; ?> <br>
                                Date Established: <?php echo $arr_IdentifierDesc[0]['date_established']; ?> <br>
                                Date of Entry: <?php echo $arr_IdentifierDesc[0]['date_created']; ?> <br>
                                Revision Date: <?php echo $arr_IdentifierDesc[0]['date_revised']; ?>
                                <?php
                            } elseif ($has_qualifier) {
                                ?>
                                Unique ID: <?php echo $arr_IdentifierQualif[0]['qualifier_ui']; ?> <br>
                                Date Established: <?php echo $arr_IdentifierQualif[0]['date_established']; ?> <br>
                                Date of Entry: <?php echo $arr_IdentifierQualif[0]['date_created']; ?> <br>
                                Revision Date: <?php echo $arr_IdentifierQualif[0]['date_revised']; ?>
                                <?php
                            }
                            ?>
                            </small>
                        </div>
                    </div>
                    <div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="true">Details</a>
                                    </li>

                                    <?php
                                        if ($has_descriptor){ ?>

                                    <li class="nav-item">
                                        <a class="nav-link" id="qualifiers-tab" data-toggle="tab" href="#qualifiers" role="tab" aria-controls="qualifiers" aria-selected="false">Qualifiers</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="structures-tab" data-toggle="tab" href="#structures" role="tab" aria-controls="structures" aria-selected="false">Tree Structures</a>
                                    </li>

                                        <?php }
                                    ?>

                                    <li class="nav-item">
                                        <a class="nav-link" id="concepts-tab" data-toggle="tab" href="#concepts" role="tab" aria-controls="concepts" aria-selected="false">Concepts</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="details" role="tabpanel">

                                        <table class="table table-sm table-striped">

                                                <!-- Tree Number(s) -->
                                                <?php
                                                if(!empty($arr_TreeNumbersListDesc)){
                                                ?>
                                                    <tr>
                                                        <td width="150px" class="text-right"><small><b>Tree Number(s)</b></small></td>
                                                        <td>
                                                            <small>
                                                            <?php
                                                            foreach ($arr_TreeNumbersListDesc as $key => $value) {
                                                            ?>
                                                                <?php echo $arr_TreeNumbersListDesc[$key]['tree_number']; ?>
                                                                <br>
                                                            <?php
                                                            }
                                                            ?>
                                                            </small>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>

                                                <!-- Annotation -->
                                                <?php
                                                if (!empty($arr_Description)){
                                                    foreach ($arr_Description as $key => $value) {
                                                        if ($arr_Description[$key]['annotation'] and $arr_Description[$key]['language_code']){
                                                            ?>
                                                            <tr>
                                                                <td width="150px" class="text-right"><small><b>Annotation(s)</b></small></td>
                                                                <td>
                                                                    <small>
                                                                        <?php
                                                                        break;
                                                                    }
                                                                }
                                                                foreach ($arr_Description as $key => $value) {
                                                                    if ($arr_Description[$key]['annotation'] and $arr_Description[$key]['language_code']){
                                                                        ?>
                                                                        <p>
                                                                            <?php echo $arr_Description[$key]['annotation']; ?>
                                                                            <small class="badge badgeWarning">
                                                                                <?php echo $arr_Description[$key]['language_code']; ?>
                                                                            </small>
                                                                        </p>
                                                                        <?php
                                                                    }
                                                                }
                                                                foreach ($arr_Description as $key => $value) {
                                                                    if ($arr_Description[$key]['annotation'] and $arr_Description[$key]['language_code']){
                                                                        ?>
                                                                    </small>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            break;
                                                        }
                                                    }
                                                }
                                                ?>

                                                <!-- Scope Note -->
                                                <?php
                                                if(!empty($arr_PreferredScopeNote)){
                                                ?>
                                                    <tr>
                                                        <td width="150px" class="text-right"><small><b>Scope Note(s)</b></small></td>
                                                        <td>
                                                            <small>
                                                            <?php
                                                            foreach ($arr_PreferredScopeNote as $key => $value) {
                                                            ?>
                                                                <p>
                                                                    <?php echo $arr_PreferredScopeNote[$key]['scope_note']; ?>
                                                                    <small class="badge badgeWarning">
                                                                        <?php echo $arr_PreferredScopeNote[$key]['language_code']; ?>
                                                                    </small><br>
                                                                </p>
                                                                <?php
                                                            }
                                                            ?>
                                                            </small>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>

                                                <!-- Entry Version -->
                                                <?php
                                                if (!empty($arr_PreferredDescriptors[0]['entry_version'])){
                                                ?>
                                                    <tr>
                                                        <td width="150px" class="text-right"><small><b>Entry Version</b></small></td>
                                                        <td>
                                                            <small>
                                                                <?php echo $arr_PreferredDescriptors[0]['entry_version']; ?>
                                                            </small>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>

                                                <!-- Abbreviation -->
                                                <?php

                                                if (!empty($qualifier_abbreviation)){
                                                ?>
                                                    <tr>
                                                        <td width="150px" class="text-right"><small><b>Abbreviation</b></small></td>
                                                        <td>
                                                            <small>
                                                                <?php echo $qualifier_abbreviation; ?>
                                                            </small>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>

                                                <!-- Entry Term -->
                                                <?php
                                                if(!empty($arr_EntryTerms)){
                                                ?>
                                                    <tr>
                                                        <td width="150px" class="text-right"><small><b>Entry Term(s)</b></small></td>
                                                        <td>
                                                            <small>
                                                            <?php
                                                            $count=0;
                                                            foreach ($arr_EntryTerms as $key => $value) {
                                                                if ($count==0){
                                                            ?>
                                                                    <small class="badge badgeWarning">
                                                                        <?php
                                                                        echo $arr_EntryTerms[$key]['language_code']; 
                                                                        ?>
                                                                    </small><br>
                                                            <?php
                                                                }
                                                                if ($count>1 and $lang_old!=$arr_EntryTerms[$key]['language_code']){
                                                            ?>
                                                                    <hr>
                                                                    <small class="badge badgeWarning">
                                                                        <?php
                                                                        echo $arr_EntryTerms[$key]['language_code']; 
                                                                        ?>
                                                                    </small><br>
                                                            <?php
                                                                }
                                                            ?>
                                                                <?php echo $arr_EntryTerms[$key]['term_string']; ?>
                                                                <br>
                                                                <?php
                                                                $lang_old=$arr_EntryTerms[$key]['language_code'];
                                                                $count++;
                                                            }
                                                            ?>
                                                            </small>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>

                                                <!-- Registry number -->
                                                <?php
                                                if (!empty($arr_CASN1_PreferredRegistryNumber)){
                                                    foreach ($arr_CASN1_PreferredRegistryNumber as $key => $value) { 
                                                        if ($arr_CASN1_PreferredRegistryNumber[$key]['registry_number'] != ''){
                                                            ?>
                                                            <tr>
                                                                <td width="150px" class="text-right"><small><b>Registry Number(s)</b></small></td>
                                                                <td>
                                                                    <small>
                                                                        <?php 
                                                                        break;
                                                                    }
                                                                } 
                                                                foreach ($arr_CASN1_PreferredRegistryNumber as $key => $value) {
                                                                    echo $arr_CASN1_PreferredRegistryNumber[$key]['registry_number'];
                                                                }
                                                                foreach ($arr_CASN1_PreferredRegistryNumber as $key => $value) {
                                                                    if ($arr_CASN1_PreferredRegistryNumber[$key]['registry_number']){
                                                                        ?>
                                                                    </small>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            break;
                                                        }
                                                    }
                                                }
                                                ?>

                                                <!-- Pharm Action -->
                                                <?php
                                                if(!empty($arr_PharmacologicalAction)){
                                                ?>
                                                    <tr>
                                                        <td width="150px" class="text-right"><small><b>Pharm Action(s)</b></small></td>
                                                        <td>
                                                            <small>
                                                            <?php
                                                            foreach ($arr_PharmacologicalAction as $key => $value) {
                                                            ?>
                                                                <?php echo $arr_PharmacologicalAction[$key]['term_string']; ?>
                                                                <small class="badge badgeWarning">
                                                                    <?php echo $arr_PharmacologicalAction[$key]['language_code']; ?>
                                                                </small><br>
                                                            <?php
                                                            }
                                                            ?>
                                                            </small>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>

                                                <!-- CAS Type 1 Name -->
                                                <?php
                                                if (!empty($arr_CASN1_PreferredRegistryNumber)){
                                                    foreach ($arr_CASN1_PreferredRegistryNumber as $key => $value) {
                                                        if (!empty($arr_CASN1_PreferredRegistryNumber[$key]['casn1_name'])){
                                                            ?>
                                                            <tr>
                                                                <td width="150px" class="text-right"><small><b>CAS Type 1 Name(s)</b></small></td>
                                                                <td>
                                                                    <small>
                                                                        <?php
                                                                        break;
                                                                    }
                                                                }
                                                                foreach ($arr_CASN1_PreferredRegistryNumber as $key => $value) {
                                                                    if(!empty($arr_CASN1_PreferredRegistryNumber[$key]['casn1_name'])){
                                                                        echo $arr_CASN1_PreferredRegistryNumber[$key]['casn1_name'];
                                                                    }

                                                                }
                                                                foreach ($arr_CASN1_PreferredRegistryNumber as $key => $value) {
                                                                    if (!empty($arr_CASN1_PreferredRegistryNumber[$key]['casn1_name'])){
                                                                        ?>
                                                                    </small>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            break;
                                                        }
                                                    }
                                                }
                                                ?>

                                                <!-- Previous Indexing -->
                                                <?php
                                                if(!empty($arr_PreviousIndexingList)){
                                                ?>
                                                    <tr>
                                                        <td width="150px" class="text-right"><small><b>Previous Indexing(s)</b></small></td>
                                                        <td>
                                                            <small>
                                                            <?php
                                                            foreach ($arr_PreviousIndexingList as $key => $value) {
                                                                ?>
                                                                <?php echo $arr_PreviousIndexingList[$key]['previous_indexing']; ?>
                                                                <?php
                                                            }
                                                            ?>
                                                            </small>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>

                                                <!-- Public MeSH Note -->
                                                <?php
                                                foreach ($arr_Description as $key => $value) {
                                                    if ($arr_Description[$key]['public_mesh_note'] and $arr_Description[$key]['language_code']){
                                                ?>
                                                        <tr>
                                                            <td width="150px" class="text-right"><small><b>Public MeSH Note(s)</b></small></td>
                                                            <td>
                                                                <small>
                                                <?php
                                                        break;
                                                    }
                                                }
                                                foreach ($arr_Description as $key => $value) {
                                                    if ($arr_Description[$key]['public_mesh_note'] and $arr_Description[$key]['language_code']){
                                                        echo $arr_Description[$key]['public_mesh_note'];
                                                ?>
                                                        <small class="badge badgeWarning">
                                                            <?php echo $arr_Description[$key]['language_code']; ?>
                                                        </small><br>
                                                        <?php
                                                    }
                                                }
                                                foreach ($arr_Description as $key => $value) {
                                                    if ($arr_Description[$key]['public_mesh_note'] and $arr_Description[$key]['language_code']){
                                                ?>
                                                                </small>
                                                            </td>
                                                        </tr>
                                                <?php
                                                        break;
                                                    }
                                                }
                                                ?>

                                                <!-- History Note -->
                                                <?php
                                                foreach ($arr_Description as $key => $value) {
                                                    if ($arr_Description[$key]['history_note'] and $arr_Description[$key]['language_code']){
                                                ?>
                                                        <tr>
                                                            <td width="150px" class="text-right"><small><b>History Note(s)</b></small></td>
                                                            <td>
                                                                <small>
                                                <?php
                                                        break;
                                                    }
                                                }
                                                foreach ($arr_Description as $key => $value) {
                                                    if ($arr_Description[$key]['history_note'] and $arr_Description[$key]['language_code']){
                                                        echo $arr_Description[$key]['history_note'];
                                                ?>
                                                        <small class="badge badgeWarning">
                                                            <?php echo $arr_Description[$key]['language_code']; ?>
                                                        </small><br>
                                                <?php
                                                    }
                                                }
                                                foreach ($arr_Description as $key => $value) {
                                                    if ($arr_Description[$key]['history_note'] and $arr_Description[$key]['language_code']){
                                                ?>
                                                                </small>
                                                            </td>
                                                        </tr>
                                                <?php
                                                        break;
                                                    }
                                                }
                                                ?>

                                                <!-- Consider Also -->
                                                <?php
                                                foreach ($arr_Description as $key => $value) {
                                                    if ($arr_Description[$key]['consider_also'] and $arr_Description[$key]['language_code']){
                                                ?>
                                                        <tr>
                                                            <td width="150px" class="text-right"><small><b>Consider Also</b></small></td>
                                                            <td>
                                                                <small>
                                                <?php
                                                        break;
                                                    }
                                                }
                                                foreach ($arr_Description as $key => $value) {
                                                    if ($arr_Description[$key]['consider_also'] and $arr_Description[$key]['language_code']){
                                                        echo $arr_Description[$key]['consider_also'];
                                                ?>
                                                        <small class="badge badgeWarning">
                                                            <?php echo $arr_Description[$key]['language_code']; ?>
                                                        </small><br>
                                                <?php
                                                    }
                                                }
                                                foreach ($arr_Description as $key => $value) { 
                                                    if ($arr_Description[$key]['consider_also'] and $arr_Description[$key]['language_code']){
                                                ?>
                                                                </small>
                                                            </td>
                                                        </tr>
                                                <?php
                                                        break;
                                                    }
                                                }
                                                ?>

                                                <!-- Entry Combination -->
                                                <?php
                                                if(!empty($arr_EntryCombinationList)){
                                                ?>
                                                    <tr>
                                                        <td width="150px" class="text-right"><small><b>Entry Combination</b></small></td>
                                                        <td>
                                                            <small>
                                                            <?php
                                                            foreach ($arr_EntryCombinationList as $key => $value) {
                                                                if ($arr_EntryCombinationList[$key]['ecin_qualif'] and $arr_EntryCombinationList[$key]['ecout_desc']){
                                                                    echo $arr_EntryCombinationList[$key]['ecin_qualif'].":";
                                                                    echo $arr_EntryCombinationList[$key]['ecout_desc'];
                                                                }
                                                                if ($arr_EntryCombinationList[$key]['ecout_qualif']) {
                                                                    echo " /".$arr_EntryCombinationList[$key]['ecout_qualif'];  
                                                                }
                                                                ?><br><?php

                                                            }
                                                            ?>
                                                            </small>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>

                                        </table>
                                </div>

                                <div class="tab-pane fade" id="qualifiers" role="tabpanel">
                                    <table class="table table-sm table-striped">

                                        <!-- Entry Combination -->
                                        <?php
                                        if(!empty($arr_EntryCombinationList)){
                                        ?>
                                            <tr>
                                                <td width="150px" class="text-right"><small><b>Entry Combination</b></small></td>
                                                <td>
                                                    <small>
                                                    <?php
                                                    foreach ($arr_EntryCombinationList as $key => $value) {

                                                        if ($arr_EntryCombinationList[$key]['ecin_qualif'] and $arr_EntryCombinationList[$key]['ecout_desc']){
                                                            echo $arr_EntryCombinationList[$key]['ecin_qualif'].":";
                                                            echo $arr_EntryCombinationList[$key]['ecout_desc'];
                                                        }

                                                        if ($arr_EntryCombinationList[$key]['ecout_qualif']){
                                                            echo " /".$arr_EntryCombinationList[$key]['ecout_qualif'];  
                                                        }
                                                    ?>
                                                        <br>
                                                    <?php
                                                    }
                                                    ?>
                                                    </small>
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
                                                    <td width="150px" class="text-right"><small><b>Allowable Qualifiers</b></small></td>
                                                    <td>
                                                        <small>
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
                                                        if ($arr_AllowableQualifiers[$key][$key1]['language_code']=='pt-br'){
                                                            echo $arr_AllowableQualifiers[$key][$key1]['term_string']." ";
                                                            echo " (".$arr_AllowableQualifiers[$key][$key1]['abbreviation'].")<br>";
                                                        }
                                                    }

                                                }
                                            }
                                        }
                                        foreach ($arr_AllowableQualifiers as $key => $value) {
                                            if ($arr_AllowableQualifiers[$key]['abbreviation']){
                                        ?>
                                                        </small>
                                                    </td>
                                                </tr>
                                        <?php
                                                break;
                                            }
                                        }
                                        ?>

                                    </table>
                                </div>


                                <div class="tab-pane fade" id="structures" role="tabpanel">
                                    <ul class="tree">

                                        <?php

                                        $count=0;
                                        foreach ($arr_HierarchicalTree as $key => $value) {
                                        ?>
                                            <li>
                                                <ul class="tree" id="1">

                                                    <?php

                                                        $tree_number=$arr_HierarchicalTree[$key]['tree_number'];

                                                        $tree_number_original=$arr_HierarchicalTree[$key]['tree_number_original'];

                                                        if ( $count > 0 and $tree_number_original != $tree_number_original_old){
                                                            echo "<hr>";

                                                        }

                                                        foreach ($arr_HierarchicalTree[$key]['term_string_translations'] as $key1 => $value1) {
                                                            if ($arr_HierarchicalTree[$key]['term_string_translations'][$key1]['language_code'] == 'pt-br' ){
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
                                    <div class="tab-pane fade" id="concepts" role="tabpanel">

                                        <?php
                                        foreach ($arr_Concept_and_Term as $key => $value) {
                                            foreach ($arr_Concept_and_Term[$key] as $key1 => $value1) {
                                                $id_concept_ui=$arr_Concept_and_Term[$key][$key1]['concept_ui'];
                                                // Determina se existe tradução para o idioma requerido - no caso pt-br está cravado mas poderá ser passado como paramentro pelo ambiente
                                                foreach ($arr_Concept_and_Term[$key][$key1]['TermListDesc'] as $key2 => $value2) {
                                                    if ($arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key2]['language_code']=='pt-br' and $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key2]['concept_preferred_term']=='Y') {
                                                        $has_term_in_language=True;
                                                    }
                                                }
                                                if ($has_term_in_language){
                                                    foreach ($arr_Concept_and_Term[$key][$key1]['TermListDesc'] as $key7 => $value7) {
                                                        if ($arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key7]['language_code']=='pt-br' and $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key7]['concept_preferred_term']=='Y') {
                                        ?>
                                                            <a href="#<?php echo $arr_Concept_and_Term[$key][$key1]['concept_ui']; ?>" data-toggle="collapse"><b>
                                        <?php
                                                            echo $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key7]['term_string']; 
                                        ?>
                                                        </b></a>
                                                        <small class="badge badgeWarning">
                                                            <?php echo $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key7]['language_code']; ?>
                                                        </small>
                                                        <?php 
                                                            $concept_relation_name=ConceptRelationName($arr_Concept_and_Term[$key][$key1]['concept_relation_name']);
                                                            echo "<i>".$concept_relation_name."</i>";
                                                        ?>
                                                        <br>
                                                    <?php
                                                        break;
                                                    }
                                                }
                                            }
                                            // Se não tem a tradução para a linguagem pega a primeira que houver
                                            if (!$has_term_in_language){
                                                foreach ($arr_Concept_and_Term[$key][$key1]['TermListDesc'] as $key6 => $value6) {
                                            ?>
                                                    <a href="#<?php echo $arr_Concept_and_Term[$key][$key1]['concept_ui']; ?>" data-toggle="collapse"><b>
                                            <?php
                                                    echo $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key6]['term_string']; 
                                            ?>
                                                </b></a>
                                                <small class="badge badgeWarning">
                                                    <?php echo $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key6]['language_code']; ?>
                                                </small>
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
                                                    <td width="150px" class="text-right"><small><b>Concept UI</b></small></td>
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
                                                    <td width="150px" class="text-right"><small><b>Scope Note</b></small></td>
                                                    <td>
                                                        <small>
                                                        <?php
                                                        // Scope Note
                                                        foreach ($arr_Concept_and_Term[$key][$key1]['ConceptListDesc'] as $key3 => $value3) {
                                                            if ($arr_Concept_and_Term[$key][$key1]['ConceptListDesc'][$key3]['language_code']!='es-es'){
                                                        ?>
                                                                <p>
                                                                    <?php
                                                                    echo $arr_Concept_and_Term[$key][$key1]['ConceptListDesc'][$key3]['scope_note'];
                                                                    ?>
                                                                    <small class="badge badgeWarning">
                                                                        <?php echo $arr_Concept_and_Term[$key][$key1]['ConceptListDesc'][$key3]['language_code']; ?>
                                                                    </small><br>
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
                                                    <td width="150px" class="text-right"><small><b>Terms (Preferred)</b></small></td>
                                                    <td>
                                                        <small>
                                                        <?php
                                                        foreach ($arr_Concept_and_Term[$key][$key1]['TermListDesc'] as $key4 => $value4) {
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
                                                                $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key4]['language_code']!='es-es'
                                                            ){
                                                                $arr_temp=array();
                                                                $arr_temp['term_string']=$arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key4]['term_string'];
                                                                $arr_temp['language_code']=$arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key4]['language_code'];
                                                                $arr_PreferredTerms[]=$arr_temp;
                                                            }
                                                        }
                                                        $arr_PreferredTerms = array_filter($arr_PreferredTerms); // Limpa array
                                                        usort($arr_PreferredTerms, "cmp"); 
                                                        foreach ($arr_PreferredTerms as $k1 => $value) {
                                                            echo $arr_PreferredTerms[$k1]['term_string'];
                                                            ?>
                                                            <small class="badge badgeWarning">
                                                                <?php echo $arr_PreferredTerms[$k1]['language_code']; ?>
                                                            </small><br>
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
                                                        $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['language_code']!='es-es'
                                                    ){
                                                        $has_synonymous=True;
                                                    }
                                                }
                                                if ($has_synonymous){
                                                ?>
                                                    <tr>
                                                        <td width="150px" class="text-right"><small><b>Entry Term(s)</b></small></td>
                                                        <td>
                                                            <small>
                                                            <?php
                                                            unset($arr_EntryTerms);
                                                            foreach ($arr_Concept_and_Term[$key][$key1]['TermListDesc'] as $key5 => $value5) {
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
                                                                    $arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['language_code']!='es-es'
                                                                ){

                                                                    $arr_temp=array();
                                                                    $arr_temp['term_string']=$arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['term_string'];
                                                                    $arr_temp['language_code']=$arr_Concept_and_Term[$key][$key1]['TermListDesc'][$key5]['language_code'];
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
                                                                        <small class="badge badgeWarning">
                                                                            <?php
                                                                            echo $arr_EntryTerms[$k5]['language_code'];
                                                                            ?>
                                                                        </small><br>
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
                                    <div class="tab-pane fade" id="concepts" role="tabpanel">

                                        <?php
                                        foreach ($arr_Concept_and_Term as $key => $value) {
                                            foreach ($arr_Concept_and_Term[$key] as $key1 => $value1) {
                                                $id_concept_ui=$arr_Concept_and_Term[$key][$key1]['concept_ui'];
                                                // Determina se existe tradução para o idioma requerido - no caso pt-br está cravado mas poderá ser passado como paramentro pelo ambiente
                                                foreach ($arr_Concept_and_Term[$key][$key1]['TermListQualif'] as $key2 => $value2) {
                                                    if ($arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key2]['language_code']=='pt-br' and $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key2]['concept_preferred_term']=='Y') {
                                                        $has_term_in_language=True;
                                                    }
                                                }
                                                if ($has_term_in_language){
                                                    foreach ($arr_Concept_and_Term[$key][$key1]['TermListQualif'] as $key7 => $value7) {
                                                        if ($arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key7]['language_code']=='pt-br' and $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key7]['concept_preferred_term']=='Y') {
                                        ?>
                                                            <a href="#<?php echo $arr_Concept_and_Term[$key][$key1]['concept_ui']; ?>" data-toggle="collapse"><b>
                                        <?php
                                                            echo $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key7]['term_string']; 
                                        ?>
                                                        </b></a>
                                                        <small class="badge badgeWarning">
                                                            <?php echo $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key7]['language_code']; ?>
                                                        </small>
                                                            <?php 
                                                                $concept_relation_name=ConceptRelationName($arr_Concept_and_Term[$key][$key1]['concept_relation_name']);
                                                                echo "<i>".$concept_relation_name."</i>";
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
                                                    <a href="#<?php echo $arr_Concept_and_Term[$key][$key1]['concept_ui']; ?>" data-toggle="collapse"><b>
                                            <?php
                                                    echo $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key6]['term_string']; 
                                            ?>
                                                </b></a>
                                                <small class="badge badgeWarning">
                                                    <?php echo $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key6]['language_code']; ?>
                                                </small>
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
                                                    <td width="150px" class="text-right"><small><b>Concept UI</b></small></td>
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
                                                    <td width="150px" class="text-right"><small><b>Scope Note</b></small></td>
                                                    <td>
                                                        <small>
                                                        <?php
                                                        // Scope Note
                                                        foreach ($arr_Concept_and_Term[$key][$key1]['ConceptListQualif'] as $key3 => $value3) {
                                                            if ($arr_Concept_and_Term[$key][$key1]['ConceptListQualif'][$key3]['language_code']!='es-es'){
                                                        ?>
                                                                <p>
                                                                    <?php
                                                                    echo $arr_Concept_and_Term[$key][$key1]['ConceptListQualif'][$key3]['scope_note'];
                                                                    ?>
                                                                    <small class="badge badgeWarning">
                                                                        <?php echo $arr_Concept_and_Term[$key][$key1]['ConceptListQualif'][$key3]['language_code']; ?>
                                                                    </small><br>
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
                                                    <td width="150px" class="text-right"><small><b>Terms (Preferred)</b></small></td>
                                                    <td>
                                                        <small>
                                                        <?php
                                                        foreach ($arr_Concept_and_Term[$key][$key1]['TermListQualif'] as $key4 => $value4) {
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
                                                                $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key4]['language_code']!='es-es'
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
                                                            <small class="badge badgeWarning">
                                                                <?php echo $arr_PreferredTerms[$k1]['language_code']; ?>
                                                            </small><br>
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
                                                        $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key5]['language_code']!='es-es'
                                                    ){
                                                        $has_synonymous=True;
                                                    }
                                                }
                                                if (!empty($has_synonymous)){
                                                ?>
                                                    <tr>
                                                        <td width="150px" class="text-right"><small><b>Entry Term(s)</b></small></td>
                                                        <td>
                                                            <small>
                                                            <?php
                                                            unset($arr_EntryTerms);
                                                            foreach ($arr_Concept_and_Term[$key][$key1]['TermListQualif'] as $key5 => $value5) {
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
                                                                    $arr_Concept_and_Term[$key][$key1]['TermListQualif'][$key5]['language_code']!='es-es'
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
                                                                        <small class="badge badgeWarning">
                                                                            <?php
                                                                            echo $arr_EntryTerms[$k5]['language_code'];
                                                                            ?>
                                                                        </small><br>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            } elseif ($no_results) {
                echo "SEM RESULTADO";
            }
            ?>

        </div>
    </section>
</section>

<?php get_footer(); ?>        