<?php

ini_set('display_errors', '0');

$lang = $_POST['lang'];
$q = $_POST['q'];
$ancestor = $_POST['ancestor'];
$tquery = stripslashes( trim($q) );
$tquery_tokens = explode(' ', $tquery);

// Quantidade máxima de documentos que retornarão
$count = 2000;

// Aplica pesquisa na API e armazena resultado
if ($tquery){
    if ( preg_match("/[A-Z][A-Z?]\?/", $tquery_tokens[0]) ) {
        $query = 'ths_treenumber:' . '(' . $tquery . ') AND django_ct:"thesaurus.identifierdesc"';
        $ths_service_request = $ths_service_url . '/api/desc/thesaurus/search/?q=' . urlencode($query) . '&count=' . $count;
    } else {
        $ths_service_request = $ths_service_url."/api/desc/thesaurus/?format=json&ths=1&decs_code=$tquery";
    }
    
    // echo "<pre>"; print_r($ths_plugin_slug); echo "</pre>"; die();
}

$urlx = real_site_url($ths_plugin_slug) . 'treeView/?q=';

$documents = array();

$response = @file_get_contents($ths_service_request);
if ($response){
    if ( preg_match("/[A-Z][A-Z?]\?/", $tquery_tokens[0]) ) {
        $response_json = json_decode($response);
        $total = $response_json->diaServerResponse[0]->response->numFound;
        $response_docs = $response_json->diaServerResponse[0]->response->docs;
        
        $documents = array_map(function($doc) use ($tquery) {
            $regex = ( '?' == $tquery[1] ) ? '/^('.$tquery[0].'[0-9][0-9])$/' : '/^('.$tquery[0].'[A-Z][0-9])$/';
            $tn = array_values(preg_grep($regex, $doc->ths_treenumber));
            $doc->ths_tn = $tn;
            return $doc;
        }, $response_docs);

        usort($documents, function ($a, $b) { return strcmp($a->ths_tn[0], $b->ths_tn[0]); });
        
        // echo "<pre>"; print_r($documents); echo "</pre>"; die();
    } else {
        $response_json = json_decode($response, true);
        $hierarchical_tree = $response_json['objects'][0]['HierarchicalTree'];
        $hierarchical_tree = phparraysort($hierarchical_tree, array('tree_number_original','tree_number'));
        
        // echo "<pre>"; print_r($hierarchical_tree); echo "</pre>"; die();
    }
}

?>

<ul class="tree-nodes">
<?php if ( preg_match("/[A-Z][A-Z?]\?/", $tquery_tokens[0]) ) : ?>
    <?php foreach ($documents as $k => $v) : $v = (array) $v; ?>
        <?php $xurl = real_site_url($ths_plugin_slug) . 'resource/?id=' . $v['ths_decs_code']; ?>
        <li class="pl-5"><a href="<?php echo $xurl; ?>"><?php echo $v['ths_mh_'.$lang][0] ?> [<?php echo $v['ths_tn'][0]; ?>]</a> <a href="#" class="btn-ajax" data-query="<?php echo $v['ths_decs_code']; ?>" data-ancestor="<?php echo $v['ths_tn'][0]; ?>"><i class="fas fa-plus-circle"></i></a></li>
    <?php endforeach; ?>
<?php else : ?>
    <?php $term_lang = ( 'pt' == $lang ) ? 'pt-br' : $lang; ?>
    <?php foreach ($hierarchical_tree as $k => $v) : ?>
        <?php if ( 'filho' == $v['tipo'] and $v['tree_number_original'] == $ancestor ) : ?>
            <?php
                $xurl = real_site_url($ths_plugin_slug) . 'resource/?id=' . $v['id'];
                $term_string = wp_list_pluck( $v['term_string_translations'], 'term_string', 'language_code' );
                $offset = count(explode('.', $v['tree_number'])) * 3;
            ?>
            <li style="padding-left: <?php echo $offset; ?>em">
                <a href="<?php echo $xurl; ?>"><?php echo $term_string[$term_lang]; ?> [<?php echo $v['tree_number']; ?>]</a>
                <?php if ( $v['leaf'] ) : ?>
                <a href="#" class="btn-ajax" data-query="<?php echo $v['id']; ?>" data-ancestor="<?php echo $v['tree_number']; ?>"><i class="fas fa-plus-circle"></i></a>
                <?php endif; ?>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>
</ul>
