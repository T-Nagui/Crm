<?php
/**
 * Created by PhpStorm.
 * User: NAGUI
 * Date: 17/11/2015
 * Time: 22:34
 */
session_start();
require '../Connextion.php';
require '../librairie/loadall.php';
$SectFilter=filter_input(INPUT_POST,'secteur',FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
foreach ($SectFilter as $filter) {
    $where['gouv_id =']=$SectFilter; 
    $ListeProspect[]=get("*",'delegation',array('gouv_id ='=>$filter),"AND",array('id' => 'ASC'));
   // $ListeEtab[]=get("*",'etablissement',array('gouv_id ='=>$filter),"AND",array('id' => 'ASC'));
} 
 if($_SESSION['user']['type']>=3){
$FilterListe=get('*','liste',array('user_id='=>$_SESSION['user']['id']));  
$FilterInf=$FilterListe['reponse'][0];
 if($FilterInf['delegation']!=""){$DelFilter=explode('@_@',$FilterInf['delegation']);  }else{
     $DelFilter=0;
 }   
 } 
?>
<select id="delegationListe" name="delegation[]" class="form-control select2" multiple>
<? 
foreach ($ListeProspect as $liste):
    foreach ($liste['reponse'] as $peos):
           if($_SESSION['user']['type']<3): ?>
    <option value="<?=$peos['id']?>"><?=$peos['nom']?></option>
    <?else:
        if(in_array($peos['id'], $DelFilter) || $DelFilter==0):?>
     <option value="<?=$peos['id']?>"><?=$peos['nom']?></option>
                               <?  endif;endif;
                               endforeach;?>
                               <?  endforeach;?>
                          </select>
<!--
<div class="col-md-12">
    <div class="form-group">
         <label>Choix de délégation</label> 

</div>
    </div>
<div class="col-md-12">
    <div class="form-group">
<label>Etablissement</label>
<select id="EtablissementListe" name="Etab[]" class="form-control select2" multiple>
<? 
//foreach ($ListeEtab as $listes):
   // foreach ($listes['reponse'] as $ett):
      // if($StdFunctions->getListe('delegation',$peos['id'])): ?>
    <option value="<?//=$ett['id']?>"><?//=$ett['nom']?></option>
                               <? // endif;
                             //  endforeach;?>
                               <?  //endforeach;?>
                          </select>
</div>
</div>
-->