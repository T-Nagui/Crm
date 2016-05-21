<?php
/**
 * Created by PhpStorm.
 * User: NAGUI
 * Date: 17/11/2015
 * Time: 22:34
 */
require '../Connextion.php'; 
$SpecFilter=filter_input(INPUT_POST,'spec',FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
$SectFilter=filter_input(INPUT_POST,'secteur',FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
$DelFilter=filter_input(INPUT_POST,'del',FILTER_DEFAULT,FILTER_REQUIRE_ARRAY); 
if($SectFilter) {
       $inSect = implode(',', $SectFilter ); 
        $strSQLFilter.= " AND gouvernorat IN($inSect) ";
}
if($SpecFilter){ 
     $inSpec = implode(',', $SpecFilter ); 
     $strSQLFilter.= " AND spec IN($inSpec) ";
}
if($DelFilter){
    $inDel = implode(',', $DelFilter ); 
        $strSQLFilter.= " AND delegation IN($inDel) ";
}
 $strSQL =  'SELECT * FROM prospect WHERE public > 0';
      //  echo $strSQL.$strSQLFilter;
        $stmt = $PDO->prepare($strSQL.$strSQLFilter." ORDER BY id ASC ".$limitStr);
// bindvalue is 1-indexed, so $k+1
/*foreach ($SpecFilter as $k => $spec)
{  $stmt->bindValue(($k+1), $spec);}*/

$stmt->execute();
$ListeProspect['reponse']=$stmt->fetchAll(PDO::FETCH_ASSOC);
$sqlTotal = "SELECT COUNT(*) as total FROM ".'prospect WHERE public > 0 '.$strSQLFilter;
            $q = $PDO->prepare($sqlTotal);
            $q->execute(@$values);
            $tot = $q->fetchAll(PDO::FETCH_ASSOC);
            $TotValue = $tot[0]['total'];
?>
<div class="checkbox">
<label>
    <input type="checkbox" id="AllLink" name="AllPros" value="<?=$TotValue?>"/>Tous
</label> 
    </div>

    <? foreach ($ListeProspect['reponse'] as $peos): ?><div class="checkbox">
<label>
    <input type="checkbox" value="<?=$peos['id']?>" name="ProListe[]" id="PRosSel_<?=$peos['id']?>" class="checkbox1"><?=$peos['nom']?> <?=$peos['prenom']?> </label> </div>
                               <?  endforeach;?>
                          
