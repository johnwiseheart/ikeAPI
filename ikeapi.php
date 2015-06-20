<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
error_reporting(0);
include("simple_html_dom.php");
$loc = $_GET['loc']; 
if (!$loc) {
  $loc = 'au';
}


$url = 'http://www.ikea.com/'.$loc.'/en/catalog/products/'.$_GET["id"].'/';

$html = file_get_html($url);
$tags = get_meta_tags($url);

if ($tags['product_name']!='') {
        $data = array(
                'name'          => $tags['product_name'],
                'type'          => substr($tags['keywords'], (strlen($tags['product_name'])+2)),
                'familyPrice'   => $tags['changed_family_price'],
                'price'         => $tags['price'],
                'description'   => preg_replace('/\s+/', ' ',$html->find('div[id=salesArg] cbs cb t', 0)->innertext),
                'metric'        => preg_replace('/\s+/', ' ', $html->find('div[id=metric]', 0)->innertext),
                'keyFeatures'   => preg_replace('/\s+/', ' ', $html->find('div[id=custBenefit]', 0)->innertext),
                'goodToKnow'    => preg_replace('/\s+/', ' ', strip_tags($html->find('div[id=goodToKnow]', 0)->innertext)),
                'care'          => preg_replace('/\s+/', ' ', $html->find('div[id=careInst]', 0)->innertext),
                'materials'     => preg_replace('/\s+/', ' ', $html->find('div[id=custMaterials]', 0)->innertext),
                'packInfo'      => preg_replace('/\s+/', ' ', $html->find('div[id=packageInfo]', 0)->innertext),
                'image'         => $html->find('link[rel=image_src]', 0)->href
        );
} else {
        $data = array();
}
echo "[".json_encode($data)."]";


?>

 
