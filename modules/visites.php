<?php
/**
 * Created by PhpStorm.
 * User: T-Yazen
 * Date: 23/03/2016
 * Time: 19:32
 */
$de=date('Y-m-d',strtotime('-1 month',strtotime(date('Y-m-d'))));
$a=date('Y-m-d');
$where=array('public='=>1);
if(filter_input(INPUT_POST,'Filterdate')){
    $de=filter_input(INPUT_POST,'de');
    $a=filter_input(INPUT_POST,'a');
    $where['date_visite >= ' ]=$de;
    $where['date_visite <= ' ]=$a;
    $usr=filter_input(INPUT_POST,'user');
    if($usr)$where['id_visiteur=']=$usr;
}
// récupération des tous visite des prospects :
$ListeVisite=get('*','visite',$where);
?>

<div>
    <form class="form-inline" method="post">
        <div class="form-group">
            <select class="form-control" name="user">
                <option value="">Par utilisateur</option>
                <?
                $ListeUser=get('*','users',array('type>'=>2));
                foreach($ListeUser['reponse'] as $user):
                    ?>
                    <option value="<?=$user['id']?>" <?if($user['id']==$usr){
                        echo "selected=selected";
                    }?>><?=$user['Nom'].' '.$user['Prenom'] ?></option>
                <?endforeach;?>

            </select>
        </div>
        <div class="form-group"><label>De </label><input type="date" name="de" class="form-control" required value="<?=$de?>"></div>
        <div class="form-group"><label>A </label><input type="date" name="a" class="form-control" required value="<?=$a;?>"></div>
        <button type="submit" name="Filterdate" value="1" class="btn btn-primary">Filter</button>
        <a href="<?=WEBRoot?>" class="btn btn-warning">Annuler</a>
    </form>
</div>
<br/><br/>
<table class="table table-bordered highchart" data-graph-container-before="1" data-graph-type="column">
    <thead>
    <tr>
        <th width="20%">Activité</th>
        <th>Médecin</th>
        <th>Pharmaci</th>
        <th>Autre</th>
    </tr>
    </thead>
    <tbody>
    <?
    //get Liste of activite :
    $Activite=get("*",'activite');
    foreach($Activite['reponse'] as $act):

        ?>
        <tr>
            <td style="text-transform: uppercase"><?=strtoupper($act['nom'])?></td>
            <td>
                <?=count($StdFunctions->countVisite($usr,$de,$a,$act['id'],array(1,6,10,11,23,28,35,34),true));?>
            </td>
            <td>
                <?=count($StdFunctions->countVisite($usr,$de,$a,$act['id'],array(57,52,27,4),true));?>
            </td>
            <td>
                <?=count($StdFunctions->countVisite($usr,$de,$a,$act['id'],array(1,6,10,11,23,28,35,34,57,52,27,4),false));?>
            </td>
        </tr>
    <?endforeach;?>

    </tbody>
</table>