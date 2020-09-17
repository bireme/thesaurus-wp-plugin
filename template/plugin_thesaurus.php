<?php

ini_set('display_errors', '0');

function ConceptRelationName($concept_relation_name, $lang_ths){
	switch ($concept_relation_name) {
		case 'NRW':
			if ($lang_ths == 'en'){
				$concept_relation_name="Narrower";
			} elseif ($lang_ths == 'es') {
				$concept_relation_name="Más estrecho";
			} elseif ($lang_ths == 'pt-br') {
				$concept_relation_name="Mais específico";
			} elseif ($lang_ths == 'fr') {
				$concept_relation_name="Plus spécifique";
			}
			break;

		case 'BRD':
			if ($lang_ths == 'en'){
				$concept_relation_name="Broader";
			} elseif ($lang_ths == 'es') {
				$concept_relation_name="Más amplio";
			} elseif ($lang_ths == 'pt-br') {
				$concept_relation_name="Mais amplo";
			} elseif ($lang_ths == 'fr') {
				$concept_relation_name="Plus large";
			}
			break;

		case 'REL':
			if ($lang_ths == 'en'){
				$concept_relation_name="Related but not broader or narrower";
			} elseif ($lang_ths == 'es') {
				$concept_relation_name="Relacionado pero no más amplio ni más estrecho";
			} elseif ($lang_ths == 'pt-br') {
				$concept_relation_name="Relacionado, mas não mais amplo ou mais específico";
			} elseif ($lang_ths == 'fr') {
				$concept_relation_name="Connexes mais pas plus larges ou plus étroites";
			}
			break;


		default:
			if ($lang_ths == 'en'){
				$concept_relation_name="Preferred";
			} elseif ($lang_ths == 'es') {
				$concept_relation_name="Concepto preferido";
			} elseif ($lang_ths == 'pt-br') {
				$concept_relation_name="Conceito preferido";
			} elseif ($lang_ths == 'fr') {
				$concept_relation_name="Concept préféré";
			}
			break;

		}
	
	return $concept_relation_name;
}


function DateAdjust($date, $lang_ths){
	if ($lang_ths == 'en'){
		$ndate=date('Y/m/d', strtotime($date));
	} else {
		$ndate=date('d/m/Y', strtotime($date));
	}
	return $ndate;

}



// Ordena por mais de um campo
function phparraysort($Array, $SortBy=array(), $Sort = SORT_REGULAR) {
	if (is_array($Array) && count($Array) > 0 && !empty($SortBy)) {
		$Map = array();
		foreach ($Array as $Key => $Val) {
			$Sort_key = '';
			foreach ($SortBy as $Key_key) {
				if(!empty($Val[$Key_key])){
					$Sort_key .= $Val[$Key_key];
				}
			}                
			$Map[$Key] = $Sort_key;
		}
		asort($Map, $Sort);
		$Sorted = array();
		foreach ($Map as $Key => $Val) {
			$Sorted[] = $Array[$Key];
		}
		// return array_reverse($Sorted);
		return $Sorted;
	}
	return $Array;
}
// Chamada
// $arr_EntryTerms = phparraysort($arr_EntryTerms, array('language_code','term_string'));


// Ordena o array por language_code
function cmp($a, $b)
{
    return strcmp($a["language_code"], $b["language_code"]);
} 
// Chamada
// usort($arr_PreferredScopeNote, "cmp"); 

// $URL="http://fi-admin-api.bvsalud.org/api/";
$URL="http://fi-admin.beta.bvsalud.org/api/";

$decs_code = $_GET['id'];
$ths = (isset($_GET['thesaurus'])) ? intval($_GET['thesaurus']) : 1;

$json = file_get_contents($URL."desc/thesaurus/?format=json&ths=$ths&decs_code=$decs_code");
$json_data = json_decode($json, true);


// Verifica se existe elemento para descritor
$has_descriptor=$json_data["objects"][0]["IdentifierDesc"][0]["decs_code"];

if ($has_descriptor){

	// DESCRIPTOR
	foreach( $json_data["objects"] as $key => $value ){
		$arr_0=$value;
		foreach ($arr_0 as $key1 => $value1) {

			switch ($key1) {
				case 'DescriptionDesc':
				$arr_DescriptionDesc=$value1;
				break;

				case 'EntryCombinationListDesc':
				$arr_EntryCombinationListDesc=$value1;
				break;

				case 'IdentifierConceptListDesc':
				$arr_IdentifierConceptListDesc=$value1;
				break;

				case 'IdentifierDesc':
				$arr_IdentifierDesc=$value1;
				break;

				case 'PharmacologicalActionList':
				$arr_PharmacologicalActionList=$value1;
				break;

				case 'PreviousIndexingListDesc':
				$arr_PreviousIndexingListDesc=$value1;
				break;

				case 'SeeRelatedListDesc':
				$arr_SeeRelatedListDesc=$value1;
				break;

				case 'TreeNumbersListDesc':
				$arr_TreeNumbersListDesc=$value1;
                $arr_TreeNumbersListDesc = phparraysort($arr_TreeNumbersListDesc, array('tree_number','id'));
				// asort($arr_TreeNumbersListDesc);
				break;

				case 'HierarchicalTree':
				$arr_HierarchicalTree=$value1;
				// $arr_HierarchicalTree = phparraysort($arr_HierarchicalTree, array('tree_number'));
				$arr_HierarchicalTree = phparraysort($arr_HierarchicalTree, array('tree_number_original','tree_number'));
				// $arr_HierarchicalTree = array_unique($arr_HierarchicalTree);
				break;

				default:
				break;

			}
		}
		unset($arr_0);
	}

	// ---------------------------------------------------------------------------------------------------------------------------------------
	// Termos preferidos 
	foreach ($arr_IdentifierConceptListDesc as $key => $value) {
		if ($arr_IdentifierConceptListDesc[$key]['preferred_concept']=='Y') {
			$arr_TermListDesc=$arr_IdentifierConceptListDesc[$key]['TermListDesc'];
			$arr_PreferredDescriptors = array();
			foreach ($arr_TermListDesc as $key => $value) {
				if ($arr_TermListDesc[$key]['concept_preferred_term']=='Y' and $arr_TermListDesc[$key]['record_preferred_term']=='Y' and $arr_TermListDesc[$key]['term_string']!='' and $arr_TermListDesc[$key]['language_code']!='') {
					$arr_temp=array();
					$arr_temp['term_string']=$arr_TermListDesc[$key]['term_string'];
					$arr_temp['language_code']=$arr_TermListDesc[$key]['language_code'];
					$arr_PreferredDescriptors[]=$arr_temp;
				}
			}
		}
		unset($arr_temp);
	}
	usort($arr_PreferredDescriptors, "cmp"); 

	// ---------------------------------------------------------------------------------------------------------------------------------------
	// Description
	$arr_Description = array();
	foreach ($arr_DescriptionDesc as $key => $value) {
		$arr_temp=array();
		$arr_temp['annotation']=$arr_DescriptionDesc[$key]['annotation'];
		$arr_temp['consider_also']=$arr_DescriptionDesc[$key]['consider_also'];
		$arr_temp['history_note']=$arr_DescriptionDesc[$key]['history_note'];
		$arr_temp['online_note']=$arr_DescriptionDesc[$key]['online_note'];
		$arr_temp['public_mesh_note']=$arr_DescriptionDesc[$key]['public_mesh_note'];
		$arr_temp['language_code']=$arr_DescriptionDesc[$key]['language_code'];
		$arr_Description[]=$arr_temp;
	}
	$arr_Description = array_filter($arr_Description); // Limpa array
	usort($arr_Description, "cmp"); 

	// ---------------------------------------------------------------------------------------------------------------------------------------
	// Definição (scope_note)
	foreach ($arr_IdentifierConceptListDesc as $key => $value) {
		if ($arr_IdentifierConceptListDesc[$key]['preferred_concept']=='Y') {
			// Definição para termo preferido
			$arr_ConceptList=$arr_IdentifierConceptListDesc[$key]['ConceptListDesc'];
			$arr_PreferredScopeNote = array();
			foreach ($arr_ConceptList as $key => $value) {
				if ($arr_ConceptList[$key]['scope_note']!='' and $arr_ConceptList[$key]['language_code']!='') {
					$arr_temp=array();
					$arr_temp['scope_note']=$arr_ConceptList[$key]['scope_note'];
					$arr_temp['language_code']=$arr_ConceptList[$key]['language_code'];
					$arr_PreferredScopeNote[]=$arr_temp;
				}
			}
		}
		unset($arr_temp);
	}
	usort($arr_PreferredScopeNote, "cmp"); 

	// ---------------------------------------------------------------------------------------------------------------------------------------
	// Definição (scope_note)
	$arr_PharmacologicalAction = array();
	foreach ($arr_PharmacologicalActionList as $key => $value) {
		if ($arr_PharmacologicalActionList[$key]['term_string']!='' and $arr_PharmacologicalActionList[$key]['language_code']!=''){
			$arr_temp=array();
			$arr_temp['term_string']=$arr_PharmacologicalActionList[$key]['term_string'];
			$arr_temp['language_code']=$arr_PharmacologicalActionList[$key]['language_code'];
			$arr_PharmacologicalAction[]=$arr_temp;
		}
		unset($arr_temp);
	}
	usort($arr_PharmacologicalAction, "cmp"); 

	// ---------------------------------------------------------------------------------------------------------------------------------------
	// Registry number
	$arr_PreferredRegistryNumber = array();
	foreach ($arr_IdentifierConceptListDesc as $key => $value) {
		if ($arr_IdentifierConceptListDesc[$key]['preferred_concept']=='Y' and ($arr_IdentifierConceptListDesc[$key]['registry_number']!='' || $arr_IdentifierConceptListDesc[$key]['registry_number']!='0')) {
			$arr_temp=array();
			$arr_temp['registry_number']=$arr_IdentifierConceptListDesc[$key]['registry_number'];
			$arr_PreferredRegistryNumber[]=$arr_temp;
		}
		unset($arr_temp);
	}

	// ---------------------------------------------------------------------------------------------------------------------------------------
	// CASN1 e Registry number
	$arr_CASN1_PreferredRegistryNumber = array();
	foreach ($arr_IdentifierConceptListDesc as $key => $value) {
		$arr_temp=array();
		if ($arr_IdentifierConceptListDesc[$key]['preferred_concept']=='Y' and ($arr_IdentifierConceptListDesc[$key]['registry_number']!='' || $arr_IdentifierConceptListDesc[$key]['registry_number']!='0')) {
			$arr_temp['registry_number']=$arr_IdentifierConceptListDesc[$key]['registry_number'];
		}
		if ($arr_IdentifierConceptListDesc[$key]['preferred_concept']=='Y' and $arr_IdentifierConceptListDesc[$key]['casn1_name']!='') {
			$arr_temp['casn1_name']=$arr_IdentifierConceptListDesc[$key]['casn1_name'];
		}
		$arr_CASN1_PreferredRegistryNumber[]=$arr_temp;
		unset($arr_temp);
	}
	$arr_CASN1_PreferredRegistryNumber = array_filter($arr_CASN1_PreferredRegistryNumber); // Limpa array

	// ---------------------------------------------------------------------------------------------------------------------------------------
	// Previous Indexing
	$arr_PreviousIndexingList = array();
	foreach ($arr_PreviousIndexingListDesc as $key => $value) {
		if ($arr_PreviousIndexingListDesc[$key]['previous_indexing']!='' and $arr_PreviousIndexingListDesc[$key]['language_code']!='') {
			$arr_temp=array();
			$arr_temp['previous_indexing']=$arr_PreviousIndexingListDesc[$key]['previous_indexing'];
			$arr_temp['language_code']=$arr_PreviousIndexingListDesc[$key]['language_code'];
		}
		$arr_PreviousIndexingList[]=$arr_temp;
		unset($arr_temp);
	}
	sort($arr_PreviousIndexingList); 

	// ---------------------------------------------------------------------------------------------------------------------------------------
	// EntryCombinationList
	$arr_EntryCombinationList = array();
	foreach ($arr_EntryCombinationListDesc as $key => $value) {
		$arr_temp=array();
		$arr_temp['ecin_qualif']=$arr_EntryCombinationListDesc[$key]['ecin_qualif'];
		$arr_temp['ecin_id']=$arr_EntryCombinationListDesc[$key]['ecin_id'];
		$arr_temp['ecout_desc']=$arr_EntryCombinationListDesc[$key]['ecout_desc'];
		$arr_temp['ecout_desc_id']=$arr_EntryCombinationListDesc[$key]['ecout_desc_id'];
		$arr_temp['identifier_id']=$arr_EntryCombinationListDesc[$key]['identifier_id'];
		$arr_temp['ecout_qualif']=$arr_EntryCombinationListDesc[$key]['ecout_qualif'];
		$arr_temp['ecout_qualif_id']=$arr_EntryCombinationListDesc[$key]['ecout_qualif_id'];
		$arr_EntryCombinationList[]=$arr_temp;
		unset($arr_temp);
	}
	$arr_EntryCombinationList = array_filter($arr_EntryCombinationList); // Limpa array
	sort($arr_EntryCombinationList); 

	// ---------------------------------------------------------------------------------------------------------------------------------------
	// Entry Term
	$arr_EntryTerms = array();
	foreach ($arr_IdentifierConceptListDesc as $key => $value) {
		foreach ($arr_IdentifierConceptListDesc[$key]['TermListDesc'] as $key1 => $value1) {
			if ($arr_IdentifierConceptListDesc[$key]['TermListDesc'][$key1]['record_preferred_term'] == 'N'){
				$arr_temp=array();
				$arr_temp['term_string']=$arr_IdentifierConceptListDesc[$key]['TermListDesc'][$key1]['term_string'];
				$arr_temp['language_code']=$arr_IdentifierConceptListDesc[$key]['TermListDesc'][$key1]['language_code']."<br>";
				$arr_EntryTerms[]=$arr_temp;
				unset($arr_temp);
			}
		}
	}
	$arr_EntryTerms = phparraysort($arr_EntryTerms, array('language_code','term_string'));

	// ---------------------------------------------------------------------------------------------------------------------------------------
	// Allowable Qualifiers
	$arr_AllowableQualifiers = array();
	foreach ($arr_IdentifierDesc as $key => $value) {
		foreach ($arr_IdentifierDesc[$key]['Abbreviations'] as $key1 => $value1) {
			$arr_temp=array();
			$arr_temp['abbreviation']=$arr_IdentifierDesc[$key]['Abbreviations'][$key1]['abbreviation'];
			foreach ($arr_IdentifierDesc[$key]['Abbreviations'][$key1] as $key2 => $value2) {
				// foreach ($arr_IdentifierDesc[$key]['Abbreviations'][$key1][$key2] as $key3 => $value3) {
				if (is_array($arr_IdentifierDesc[$key]['Abbreviations'][$key1][$key2])){
					foreach ($arr_IdentifierDesc[$key]['Abbreviations'][$key1][$key2] as $key3 => $value3) {
						$arr_term_string_translations=array();
						$arr_term_string_translations['abbreviation']=$arr_IdentifierDesc[$key]['Abbreviations'][$key1]['abbreviation'];
						$arr_term_string_translations['decs_code']=$arr_IdentifierDesc[$key]['Abbreviations'][$key1]['decs_code'];
						$arr_term_string_translations['term_string']=$arr_IdentifierDesc[$key]['Abbreviations'][$key1][$key2][$key3]['term_string'];
						$arr_term_string_translations['language_code']=$arr_IdentifierDesc[$key]['Abbreviations'][$key1][$key2][$key3]['language_code'];
						$arr_temp[]=$arr_term_string_translations;
						unset($arr_term_string_translations);
					}
				}
			}
			$arr_AllowableQualifiers[]=$arr_temp;
			unset($arr_temp);
		}
	}
	sort($arr_AllowableQualifiers); 

// echo '<pre>' . print_r($arr_AllowableQualifiers, true) . '</pre><hr>';

	// ---------------------------------------------------------------------------------------------------------------------------------------
	// Para aba Conceito ordena por language_code
	$arr_Concept_and_Term[]=$arr_IdentifierConceptListDesc;
	$arr_Concept_and_Term = phparraysort($arr_Concept_and_Term, array('language_code','term_string'));
	// usort($arr_Concept_and_Term, "cmp"); 


} else {

	// QUALIFIER
	$json = file_get_contents($URL."qualif/thesaurus/?format=json&ths=$ths&decs_code=$decs_code");
	$json_data = json_decode($json, true);
	$has_qualifier=$json_data["objects"][0]["IdentifierQualif"][0]["decs_code"];
	if ($has_qualifier){

		foreach( $json_data["objects"] as $key => $value ){
			$arr_0=$value;
			foreach ($arr_0 as $key1 => $value1) {

				switch ($key1) {
					case 'DescriptionQualif':
						$arr_DescriptionQualif=$value1;
						break;

					case 'IdentifierConceptListQualif':
						$arr_IdentifierConceptListQualif=$value1;
						break;

					case 'IdentifierQualif':
						$arr_IdentifierQualif=$value1;
						break;

					case 'TreeNumbersListQualif':
						$arr_TreeNumbersListQualif=$value1;
						asort($arr_TreeNumbersListQualif);
						break;

					case 'abbreviation':
						$qualifier_abbreviation=$value1;
						break;

					default:
						break;

				}
			}
		}

		// ---------------------------------------------------------------------------------------------------------------------------------------
		// Termos preferidos 
		foreach ($arr_IdentifierConceptListQualif as $key => $value) {
			if ($arr_IdentifierConceptListQualif[$key]['preferred_concept']=='Y') {
				// Termo preferido
				$arr_TermListQualif=$arr_IdentifierConceptListQualif[$key]['TermListQualif'];
				$arr_PreferredDescriptors = array();
				foreach ($arr_TermListQualif as $key => $value) {
					if ($arr_TermListQualif[$key]['concept_preferred_term']=='Y' and $arr_TermListQualif[$key]['record_preferred_term']=='Y' and $arr_TermListQualif[$key]['term_string']!='' and $arr_TermListQualif[$key]['language_code']!='') {
						$arr_temp=array();
						$arr_temp['term_string']=$arr_TermListQualif[$key]['term_string'];
						$arr_temp['language_code']=$arr_TermListQualif[$key]['language_code'];
						$arr_temp['entry_version']=$arr_TermListQualif[$key]['entry_version'];
						$arr_PreferredDescriptors[]=$arr_temp;
					}
				}
			}
		}
		usort($arr_PreferredDescriptors, "cmp"); 


		// ---------------------------------------------------------------------------------------------------------------------------------------
		// Description
		$arr_Description = array();
		foreach ($arr_DescriptionQualif as $key => $value) {
			$arr_temp=array();
			$arr_temp['annotation']=$arr_DescriptionQualif[$key]['annotation'];
			$arr_temp['consider_also']=$arr_DescriptionQualif[$key]['consider_also'];
			$arr_temp['history_note']=$arr_DescriptionQualif[$key]['history_note'];
			$arr_temp['online_note']=$arr_DescriptionQualif[$key]['online_note'];
			$arr_temp['public_mesh_note']=$arr_DescriptionQualif[$key]['public_mesh_note'];
			$arr_temp['language_code']=$arr_DescriptionQualif[$key]['language_code'];
			$arr_Description[]=$arr_temp;
		}
		$arr_Description = array_filter($arr_Description); // Limpa array
		usort($arr_Description, "cmp"); 

		// ---------------------------------------------------------------------------------------------------------------------------------------
		// Definição (scope_note)
		foreach ($arr_IdentifierConceptListQualif as $key => $value) {
			if ($arr_IdentifierConceptListQualif[$key]['preferred_concept']=='Y') {
				// Definição para termo preferido
				$arr_ConceptList=$arr_IdentifierConceptListQualif[$key]['ConceptListQualif'];
				$arr_PreferredScopeNote = array();
				foreach ($arr_ConceptList as $key => $value) {
					if ($arr_ConceptList[$key]['scope_note']!='' and $arr_ConceptList[$key]['language_code']!='') {
						$arr_temp=array();
						$arr_temp['scope_note']=$arr_ConceptList[$key]['scope_note'];
						$arr_temp['language_code']=$arr_ConceptList[$key]['language_code'];
						$arr_PreferredScopeNote[]=$arr_temp;
					}
				}
			}
		}
		usort($arr_PreferredScopeNote, "cmp"); 

		// ---------------------------------------------------------------------------------------------------------------------------------------
		// Entry Term
		$arr_EntryTerms = array();
		foreach ($arr_IdentifierConceptListQualif as $key => $value) {
			foreach ($arr_IdentifierConceptListQualif[$key]['TermListQualif'] as $key1 => $value1) {
				if ($arr_IdentifierConceptListQualif[$key]['TermListQualif'][$key1]['record_preferred_term'] == 'N'){
					$arr_temp=array();
					$arr_temp['term_string']=$arr_IdentifierConceptListQualif[$key]['TermListQualif'][$key1]['term_string'];
					$arr_temp['language_code']=$arr_IdentifierConceptListQualif[$key]['TermListQualif'][$key1]['language_code']."<br>";
					$arr_EntryTerms[]=$arr_temp;
					unset($arr_temp);
				}
			}
		}
		// usort($arr_EntryTerms, "cmp"); 
		$arr_EntryTerms = phparraysort($arr_EntryTerms, array('language_code','term_string'));

		// ---------------------------------------------------------------------------------------------------------------------------------------
		// Para aba Conceito ordena por language_code
		$arr_Concept_and_Term[]=$arr_IdentifierConceptListQualif;
		$arr_Concept_and_Term = phparraysort($arr_Concept_and_Term, array('language_code','term_string'));



	} else {
		$no_results=True;
	}
}




?>