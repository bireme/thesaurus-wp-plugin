<?php

if ( !function_exists('print_lang_value') ) {
    function print_lang_value($value, $lang_code){
        $lang_code = substr($lang_code,0,2);
        if ( is_array($value) ){
            foreach($value as $current_value){
                $print_values[] = get_lang_value($current_value, $lang_code);
            }
            echo implode(', ', $print_values);
        }else{
            echo get_lang_value($value, $lang_code);
        }
        return;
    }
}

if ( !function_exists('get_lang_value') ) {
    function get_lang_value($string, $lang_code, $default_lang_code = 'en'){
        $lang_value = array();
        $occs = preg_split('/\|/', $string);

        foreach ($occs as $occ){
            $re_sep = (strpos($occ, '~') !== false ? '/\~/' : '/\^/');
            $lv = preg_split($re_sep, $occ);
            $lang = substr($lv[0],0,2);
            $value = $lv[1];
            $lang_value[$lang] = $value;
        }
        if ( isset($lang_value[$lang_code]) ){
            $translated = $lang_value[$lang_code];
        }else{
            $translated = $lang_value[$default_lang_code];
        }

        return $translated;
    }
}


if ( !function_exists('print_formated_date') ) {
    function print_formated_date($string){
        echo substr($string,6,2)  . '/' . substr($string,4,2) . '/' . substr($string,0,4);
    }
}

if ( !function_exists('isUTF8') ) {
    function isUTF8($string){
        return (utf8_encode(utf8_decode($string)) == $string);
    }
}

if ( !function_exists('translate_label') ) {
    function translate_label($texts, $label, $group=NULL) {
        // labels on texts.ini must be array key without spaces
        $label_norm = preg_replace('/[&,\'\s]+/', '_', $label);
        if($group == NULL) {
            if(isset($texts[$label_norm]) and $texts[$label_norm] != "") {
                return $texts[$label_norm];
            }
        } else {
            if(isset($texts[$group][$label_norm]) and $texts[$group][$label_norm] != "") {
                return $texts[$group][$label_norm];
            }
        }
        // case translation not found return original label ucfirst
        return ucfirst($label);
    }
}

if ( !function_exists('real_site_url') ) {
    function real_site_url($path = ''){

        $site_url = get_site_url();

        // check for multi-language-framework plugin
        if ( function_exists('mlf_parseURL') ) {
            global $mlf_config;

            $current_language = substr( strtolower(get_bloginfo('language')),0,2 );

            if ( $mlf_config['default_language'] != $current_language ){
                $site_url .= '/' . $current_language;
            }
        }
        // check for polylang plugin
        elseif ( defined('POLYLANG_VERSION') ) {
            $defLang = pll_default_language();
            $curLang = pll_current_language();

            if ($defLang != $curLang) {
                $site_url .= '/' . $curLang;
            }
        }

        if ($path != ''){
            $site_url .= '/' . $path;
        }
        $site_url .= '/';


        return $site_url;
    }
}




// Função para ordenar corretamente o MH de acordo com o idioma escolhido
function SortMHResultEN($name1,$name2){
    $patterns = array(
        'a' => '(á|à|â|ä|Á|À|Â|Ä)',
        'e' => '(é|è|ê|ë|É|È|Ê|Ë)',
        'i' => '(í|ì|î|ï|Í|Ì|Î|Ï)',
        'o' => '(ó|ò|ô|ö|Ó|Ò|Ô|Ö)',
        'u' => '(ú|ù|û|ü|Ú|Ù|Û|Ü)'
    );
    $name1 = preg_replace(array_values($patterns), array_keys($patterns), $name1["ths_mh_en"]);
    $name2 = preg_replace(array_values($patterns), array_keys($patterns), $name2["ths_mh_en"]);
    return strcasecmp($name1, $name2);
}

function SortMHResultES($name1,$name2){
    $patterns = array(
        'a' => '(á|à|â|ä|Á|À|Â|Ä)',
        'e' => '(é|è|ê|ë|É|È|Ê|Ë)',
        'i' => '(í|ì|î|ï|Í|Ì|Î|Ï)',
        'o' => '(ó|ò|ô|ö|Ó|Ò|Ô|Ö)',
        'u' => '(ú|ù|û|ü|Ú|Ù|Û|Ü)'
    );
    $name1 = preg_replace(array_values($patterns), array_keys($patterns), $name1["ths_mh_es"]);
    $name2 = preg_replace(array_values($patterns), array_keys($patterns), $name2["ths_mh_es"]);
    return strcasecmp($name1, $name2);
}

function SortMHResultPT($name1,$name2){
    $patterns = array(
        'a' => '(á|à|â|ä|Á|À|Â|Ä)',
        'e' => '(é|è|ê|ë|É|È|Ê|Ë)',
        'i' => '(í|ì|î|ï|Í|Ì|Î|Ï)',
        'o' => '(ó|ò|ô|ö|Ó|Ò|Ô|Ö)',
        'u' => '(ú|ù|û|ü|Ú|Ù|Û|Ü)'
    );
    $name1 = preg_replace(array_values($patterns), array_keys($patterns), $name1["ths_mh_pt"]);
    $name2 = preg_replace(array_values($patterns), array_keys($patterns), $name2["ths_mh_pt"]);
    return strcasecmp($name1, $name2);
}

function SortMHResultFR($name1,$name2){
    $patterns = array(
        'a' => '(á|à|â|ä|Á|À|Â|Ä)',
        'e' => '(é|è|ê|ë|É|È|Ê|Ë)',
        'i' => '(í|ì|î|ï|Í|Ì|Î|Ï)',
        'o' => '(ó|ò|ô|ö|Ó|Ò|Ô|Ö)',
        'u' => '(ú|ù|û|ü|Ú|Ù|Û|Ü)'
    );
    $name1 = preg_replace(array_values($patterns), array_keys($patterns), $name1["ths_mh_fr"]);
    $name2 = preg_replace(array_values($patterns), array_keys($patterns), $name2["ths_mh_fr"]);
    return strcasecmp($name1, $name2);
}


// Função para ordenar corretamente Entry Terms que tenham acento
function SortET($name1,$name2){
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

// Função para verificar se o valor de um array tem determinado texto
function containsString($arr, $q){
    foreach ($arr as $key => $value) {
        $has=(FALSE === \stripos($value, $q)) ? FALSE : TRUE;
        if ( $has == '1' ){
            $open=$has;
            // echo "$value: --> ".$open."<br>";
        }
    }   
    return $open;
}


// Função de highlight
function highlight($text, $words) {
    $words = str_replace("$","",$words);
    $words = str_replace("*","",$words);
    $text = preg_replace("|($words)|Uui", "<span style=\"background-color: yellow\">$1</span>", $text);
    return $text;
}



// Categorias
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


Function convLang($language_code){
    $language_code = htmlentities($language_code, null, 'utf-8');
    $language_code = str_replace("&lt;br&gt;","",$language_code);

    return $language_code;
}


?>
