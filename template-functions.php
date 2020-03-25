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
    $text = preg_replace("|($words)|Uui", "<span style=\"background-color: yellow\">$1</span>", $text);
    return $text;
}


?>
