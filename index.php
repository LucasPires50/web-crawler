<?php

//Configaração proxy senai
$proxy = "10.1.21.254:3128";

$arratConfig = array(
    'http' => array(
        'proxy' => $proxy,
        'request_fulluri' => true),
    'https' => array(
        'proxy' => $proxy,
        'request_fulluri' => true)
);

$context = stream_context_create($arratConfig);
//---------------- Configuração da proxy termina aqui


$url = "http://www.gutenberg.org/";
$html = file_get_contents($url, false, $context);

$dom = new DOMDocument();
libxml_use_internal_errors(true);

//transformando o html em objeto
$dom->loadHTML($html);
libxml_clear_errors();

//Capturar as tags p
//$tagsP = $dom->getElementsByTagName('p');
//
//foreach ($tagsP as $p) {
//    echo $p->nodeValue;
//    echo "<br/></br>";
//}

$tagsDiv = $dom->getElementsByTagName('div');

foreach ($tagsDiv as $div) {
    $classe = $div->getAttribute('class');

    if ($classe == 'page_content') {
        $divInternas = $div->getElementsByTagName('div');

        foreach ($divInternas as $divInterna) {
            $classeInterna = $divInterna->getAttribute('class');
            if ($classeInterna == 'box_announce') {
                $tagsPInternas = $divInterna->getElementsByTagName('p');
                foreach ($tagsPInternas as $p) {
//                    print_r($p);
//                    echo $p->nodeValue;
                    $arrayTagP[] = $p->nodeValue;
                }
            }
        }
    }
}
print_r($arrayTagP);
?>