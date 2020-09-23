<?php

require_once(ABSPATH . 'wp-admin/includes/file.php');
$home_path = get_home_path();

# Recupera url solicitada
$url = $_SERVER['REQUEST_URI'];

# idioma da ferramenta
$i1= Explode('/', $url);
foreach ($i1 as $key => $value) {
	if ( substr($value, 0, 2) == 'es' or substr($value, 0, 2) == 'en' or substr($value, 0, 2) == 'fr' ){
		$idioma=$value;
	}
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
// $cachetime = 3600 * 168; # Uma semana de armazenamento - 24 x 7 = 168
$cachetime = 3600 * 720; # Um mes de armazenamento - 24 x 30 = 720

# Apaga arquivo que supostamente foi gravado com erro
if (file_exists($cachefile)){
	$TAM=filesize($cachefile);
	# 5000 bytes tamanho medio de um arquivo com problema
	if ($TAM < 5000 ){
		unlink($cachefile);
	}
}

// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
    echo "<!-- Cached copy, generated ".date('H:i', filemtime($cachefile))." -->\n";
    readfile($cachefile);
    exit;
}
ob_start(); // Start the output buffer
?>