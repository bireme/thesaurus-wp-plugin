<?php

require_once(ABSPATH . 'wp-admin/includes/file.php');
$home_path = get_home_path();

# Recupera url solicitada
$url = $_SERVER['REQUEST_URI'];

# idioma da ferramenta
$i1= Explode('/', $url);

# https://decs.teste.bvs.br/ths/resource/?id=16792&filter=ths_termall&q=bireme
# https:  /  /decs.teste.bvs.br  /ths  /resource  /?id=16792&filter=ths_termall&q=bireme

# https://decs.teste.bvs.br/en/ths/resource/?id=16792&filter=ths_termall&q=bireme

if ($i1[3] == 'ths' and ( $i1[2] == 'es' or $i1[2] == 'en' or $i1[2] == 'pt' or $i1[2] == 'fr' )) {
	$idioma = $i1[2];
} elseif ( $i1[2] == 'ths' ) {
	# A interface padrão é a pt então não crava idioma
	$idioma = '';
}

# id decs_code e visualização outro idioma
$b1= Explode('?', $url);
$b2 = Explode('&', $b1[1]);

foreach ($b2 as $key => $value) {

	# id decs_code
	if ( substr($value, 0, 3) == 'id=' ){
		$id=str_replace("id=", "", $value);
	}

	# visualização outro idioma
	if ( substr($value, 0, 13 ) == 'lang_another=' ) {
		$lang_another=str_replace("lang_another=", "", $value);
	}

}

# Monta nome do arquivo
if ( $lang_another ){
	$file = $id . '_' . $idioma . '_' . $lang_another ;
} else {
	$file = $id . '_' . $idioma;	
}
# Diretorio de armazenamento
// $TMP_DIR="/tmp/ths_cache";
$TMP_DIR = $home_path . 'ths_cache';
$cachefile = $TMP_DIR . '/' . 'cached-'. $file .'.html';

// echo "PATH ",$home_path;
// echo "<br>ARQ. ",$cachefile;

# Tempo de armazenamento
$cachetime = 3600 * 168; # Uma semana de armazenamento

// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
    echo "<!-- Cached copy, generated ".date('H:i', filemtime($cachefile))." -->\n";
    readfile($cachefile);
    exit;
}
ob_start(); // Start the output buffer
?>