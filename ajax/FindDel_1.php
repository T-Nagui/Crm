<?php
/**
 * Created by PhpStorm.
 * User: NAGUI
 * Date: 17/11/2015
 * Time: 22:34
 */
require '../Connextion.php';
require '../librairie/loadall.php';
$SectFilter=filter_input(INPUT_POST,'secteur',FILTER_DEFAULT);
$liste=get("*",'delegation',array('gouv_id ='=>$SectFilter),"AND",array('id' => 'ASC'));
$listeEtab=get("*",'etablissement',array('gouv_id ='=>$SectFilter),"AND",array('id' => 'ASC'));

?>
<label>Choix de délégation</label>
<select id="delegationListe" name="delegation" class="form-control" >
<? 

    foreach ($liste['reponse'] as $peos): ?>
    <option value="<?=$peos['id']?>"><?=$peos['nom']?></option>
                               <?  endforeach;?>
                           
                          </select>
<br/>
<label for="etablissement">Etablissement</label>

                            <select class="form-control" name="Etab">
                                <option value="">----</option>
<? 
foreach ($listeEtab['reponse'] as $Eta):
    ?>
                                <option value="<?= $Eta['id'] ?>" <?if($Eta['id']==$ProsInfo['etablissement']){ echo 'selected="selected"';}?> ><?= $Eta['nom'] ?></option>
<? endforeach; ?>
                            </select>