<?php
/**
 * Created by PhpStorm.
 * User: NAGUI
 * Date: 03/03/2016
 * Time: 13:57
 */
if($_SESSION['user']['type']>2):
    $_SESSION['msg'] = "Vous n'avez pas le droit de visualiser cette partie. Merci";

    $_SESSION['type'] = "alert-danger";

    redirect(WEBRoot);
endif;
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
<section class="content-header">

    <h1>

        Analyse des visites (<?=$ListeVisite['total']?>)

    </h1>



</section>



<!-- Main content -->

<section class="content">

    <div class="row">
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-body box-profile">
                <div>
                    <form class="form-inline" method="post">
                        <div class="form-group">
                            <label>Par utilisateur</label>
                            <select class="form-control" name="user">
                                <option value=""></option>
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
                        <a href="visite" class="btn btn-warning">Annuler</a>
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
                <a href="#" class="btn btn-success" id="linkTable">Détail</a>
                <br/><br/>
        <table class="table table-bordered" id="Tdetail">
            <thead>
            <tr>
                <th>Prospect visité</th>
                <th>Par</th>
                <th>Date</th>
                <th>Commentaire</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($ListeVisite['reponse'] as $visite):?>
                <tr>
                    <td>
                        <a href="<?=WEBRoot?>/prospects/profile?id=<?=$visite['id_pros']?>" class="btn btn-facebook btn-block">
                            <?=getinfo($visite['id_pros'],'prospect','Nom').' '.getinfo($visite['id_pros'],'prospect','Prenom')?>

                        </a>
                        <p>Spécialité : <?=getinfo(getinfo($visite['id_pros'],'prospect','spec'),'specialite','nom');?>
                        <br/>Activité : <?=getinfo(getinfo($visite['id_pros'],'prospect','activite'),'activite','nom');?></p>
                    </td>
                    <td><?=getinfo($visite['id_visiteur'],'users','Nom').' '.getinfo($visite['id_visiteur'],'users','prenom')?></td>


                    <td><?=$visite['date_visite']?></td>
                    <td><?=$visite['commentaire']?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        </div>
        </div>
        </div>
        </div>
</section>
