<?php/** * Created by PhpStorm. * User: NAGUI * Date: 18/11/2015 * Time: 15:25 */$id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);if($id){    $profileInf=   get("*",'prospect',array('id='=>$id));    $profile=$profileInf['reponse'][0];}$AddPro=filter_input(INPUT_POST,'AddPro',FILTER_SANITIZE_NUMBER_INT);if($AddPro==1 && $id!==false):$data=array(    "id_pros"=>$id,    "commentaire"=>filter_input(INPUT_POST,'commentaire'),    "date_visite"=>filter_input(INPUT_POST,'date_visite'),    "type"=>filter_input(INPUT_POST,'type_viste'),    "vad"=>filter_input(INPUT_POST,'vad') ? 1 : 0,    "id_visiteur"=>$_SESSION['user']['id'],    "public"=>1,    "created_at"=>date('Y-m-d H:i:s'),);if(add($data,'visite')){            $_SESSION['msg'] = "Visite ajouter avec success";            $_SESSION['type'] = "alert-success";            redirect('liste');}endif;?><section class="content-header">    <h1 class="pull-left"> Ajout d'une visite pour        <small> <?=$profile['nom'].' '.$profile['prenom']?></small>    </h1>    <a href="liste" class="btn bg-maroon pull-right"><i class="glyphicon glyphicon-backward"></i>  retour </a>    <div class="clearfix"></div></section><!-- Main content --><section class="content"><div class="row">    <div class="col-md-3">        <div class="box box-primary">            <div class="box-body box-profile">                <h3 class="profile-username text-center"><?=$profile['nom']." ".$profile['prenom']?> </h3>                <p class="text-muted text-center"><?=getinfo($profile['spec'],'specialite','nom'); ?></p>                <p class="text-muted text-center"><?=$profile['titre'] ?></p><ul class="list-group list-group-unbordered">                        <li class="list-group-item">                            <b>Tel.</b> <?=$profile['tel']?>                        </li>                        <li class="list-group-item">                            <b>GSM</b> <?=$profile['gsm']?>                        </li>                        <li class="list-group-item">                            <b>E-mail</b> <?=$profile['email']?>                        </li>                        <li class="list-group-item">                            <b>Gouvernorat</b> <?=  getinfo($profile['gouvernorat'],'gouvernerat','nom')?>                        </li>                        <li class="list-group-item">                            <b>Delegation</b> <?=  getinfo($profile['delegation'],'delegation','nom')?>                        </li>                        <li class="list-group-item">                            <b>Adresse</b> <?=$profile['adresse']?>                        </li>                        <li class="list-group-item">                            <b>CP</b> <?=$profile['code_postal']?>                        </li>                    </ul>            </div><!-- /.box-body -->        </div>    </div>    <div class="col-md-9">        <div class="box box-success">            <div class="box-body box-visite">                <form class="" method="post" action="">                    <div class="form-group">                        <label>Type de la visite</label>                        <select name="type_viste" class="form-control" required>                        <?                        $typeVisite=get('*','type_visite');                        foreach($typeVisite['reponse'] as $Tvi):                        ?>                        <option value="<?=$Tvi['id']?>"><?=$Tvi['nom']?></option>                        <?endforeach;?>                        </select>                    </div>                    <div class="form-group">                        <label>                            <input type="checkbox" name="vad" value="1" class=""> VAD                        </label>                    </div>            <div class="form-group">                <label for="date_visite">Date de la visite</label>                <input type="date" name="date_visite" value="" id="date_visite" class="form-control date" required>            </div>                    <label>Commentaire</label>                    <textarea class="textarea" required placeholder="" name="commentaire"                              style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>                    <button type="submit" name="AddPro" value="1" class="btn btn-primary pull-right">Confirmer la visite</button>                    <div class="clearfix"></div>                </form>            </div>        </div>    </div></div></section>