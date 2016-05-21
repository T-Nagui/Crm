<?
require '../Connextion.php';
require '../librairie/loadall.php';
$id=  filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
$etat=  filter_input(INPUT_GET,'etat',FILTER_VALIDATE_INT);
if($etat==1){
    $change=0;
}else{
    $change=1;
}
update($id,array('etat'=>$change),'onix_articles');