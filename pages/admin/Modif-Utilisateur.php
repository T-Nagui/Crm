<?php /** *   * User: NAGUI * Date: 10/11/2015 * Time: 14:43 */ /*Fonction Test de role*//*if(!getinfo($_SESSION['user']['id'],'roles','GestUser')){$_SESSION['msg']="Vous n'avez pas des droit pour visualiser cette page";        $_SESSION['type']="alert-danger";      redirect(WEBRoot);}*//*End Fonction Test de role*/    /* Inscription File */     $Pos = filter_input(INPUT_POST, 'AddBtn');    $algo = "PASSWORD_BCRYPT";   $options = [    'cost' => 12,];     // echo  $verified = password_verify($pass, $hash)        ? 'The hash matches the entered password'        : 'The hash does not match the entered password';$idModif=  filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);$USerToModif=get("*",'users',array('id='=>$idModif));$InfoUSer=$USerToModif['reponse'][0];$Roles=get('*','roles',array('id='=>getIdRoles($InfoUSer['id'])));$RolesInfo=$Roles['reponse'][0];     if (isset($Pos) && $Pos == 1 && $idModif!==FALSE) {        //echo password_hash("rasmuslerdorf", PASSWORD_BCRYPT)."\n";        $Civilite = filter_input(INPUT_POST, 'Civilite');        $Nom = filter_input(INPUT_POST, 'Nom', FILTER_SANITIZE_STRING);        $Prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);        $Email = filter_input(INPUT_POST, 'Email', FILTER_VALIDATE_EMAIL);       $Psswd = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING);         $Tel = filter_input(INPUT_POST, 'tel');        $datas = array(            'Civilite' => $Civilite,            'Nom' => $Nom,            'type'=>filter_input(INPUT_POST, 'user_type',FILTER_VALIDATE_INT),              'login'=>filter_input(INPUT_POST, 'login'),            'Prenom' => $Prenom,            'Email' => $Email,                       'Tel' => $Tel,             'active' => 1,             'SysDate' => date("Y-m-d H:i:s")        );         if($Psswd!=""){            $datas['password'] = password_hash($Psswd,PASSWORD_BCRYPT, $options);        }     if (update($idModif,$datas, 'users')) {           // ajouter ces role         $dataRole=  array(           'id'=>$RolesInfo['id'],             'user_id'=>$idModif,             'GestUser'=>  filter_input(INPUT_POST,'GestUser',FILTER_VALIDATE_INT) ,              'vueDM'=>  filter_input(INPUT_POST,'vueDM',FILTER_VALIDATE_INT) ,              'vuePros'=>  filter_input(INPUT_POST,'vuePros',FILTER_VALIDATE_INT) ,              'SupPros'=>  filter_input(INPUT_POST,'SupPros',FILTER_VALIDATE_INT) ,              'ModPros'=>  filter_input(INPUT_POST,'ModPros',FILTER_VALIDATE_INT) ,              'Moddemande'=>  filter_input(INPUT_POST,'Moddemande',FILTER_VALIDATE_INT) ,              'ModVisite'=>  filter_input(INPUT_POST,'ModVisite',FILTER_VALIDATE_INT) ,              'cree_par'=>$_SESSION['user']['id'],             'modifier_par'=>'',             'created_at'=>date("Y-m-d H:i:s")                      );        update(getIdRoles($InfoUSer['id']), $dataRole,'roles');             $_SESSION['msg'] = "Délégué modifier avec success";              $_SESSION['type'] ="alert-success";         redirect('liste');        } else        {  $_SESSION['msg']="Une Erreur c'est produite";        $_SESSION['type']="alert-danger";        redirect('liste');        }     }    ?><section class="content-header">    <h1> Modifier l'utilisateur <?=$InfoUSer['Nom']?>        <small> <?= getIdRoles($InfoUSer['id']); ?></small>    </h1> </section><!-- Main content --><section class="content">       <div class="row">   <form role="form" method="post" class="">        <div class="col-md-4">            <div class="box box-primary">                <div class="box-header with-border"><h3 class="box-title">Modifier information personnels</h3></div>                <!-- /.box-header -->                <!-- form start -->                 <input type="hidden" class="form-control" id="" name="type" value="3" placeholder="le nom du délégué">                    <div class="box-body">                        <div class="form-group"><label for="civi">Civilité</label>                            <select name="Civilite"  class="form-control"  id="civi">        <option value="M" <? if($InfoUSer['Civilite']=="M") {echo 'selected="selected"'; }?>  >M</option>        <option value="Mme" <? if($InfoUSer['Civilite']=="Mme") {echo 'selected="selected"'; }?>>Mme</option>        <option value="Mlle" <? if($InfoUSer['Civilite']=="Mlle") {echo 'selected="selected"'; }?>>Mlle</option>                            </select></div>                        <div class="form-group">                            <label for="name">Nom</label>                            <input type="text" class="form-control" value="<?=$InfoUSer['Nom']?>"    id="name" name="Nom" placeholder="le nom du délégué">                        </div>                        <div class="form-group">                            <label for="lastname">Prénom</label>     <input type="text"  class="form-control" id="lastname" value="<?=$InfoUSer['Prenom']?>" name="prenom" placeholder="le prénom du délégué">                        </div>                        <div class="form-group">                            <label for="login">Login</label>                            <input type="text" class="form-control" value="<?=$InfoUSer['login']?>" id="login" name="login" placeholder="Unique login">                        </div>                        <div class="form-group">                            <label for="exampleInputEmail1">Email address</label>                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" name="Email" autocomplete="off" value="<?=$InfoUSer['Email']?>">                        </div>                        <div class="form-group">                            <label for="exampleInputPassword1">Mot de passe</label>                            <input type="password" class="form-control" id="exampleInputPassword1" name="mdp" placeholder="Password" autocomplete="off" value="">                            <span class="help-block text-red">Pour ne pas modifier le mot de passe laisser ce champ vide</span>                        </div>                        <div class="form-group">                            <label for="telid">Tel.</label>                            <input type="text" class="form-control" value="<?=$InfoUSer['Tel']?>"  id="telid" name="tel" placeholder="Tel"></div>                     </div><!-- /.box-body -->                                             </div>        </div>           <div class="col-sm-8 col-md-8">            <div class="box"><div class="box-header with-border"><h3 class="box-title">Prévilège</h3></div><div class="box-body">        <div class="form-group">        <label>Type d'utilisateur</label>        <select name="user_type" class="form-control" required>            <option value="">Choix</option>            <? $Types=get("*",'user_type'); foreach ($Types['reponse'] as $USerT):            ?>            <option value="<?=$USerT['id']?>" <?if($USerT['id']==$InfoUSer['type']) {  echo 'selected="selected"';}?> ><?=$USerT['name']?></option>            <?  endforeach;?>        </select>    </div>    <div class="form-group">        <label class="fixed-width-label">           Gestion des utilisateurs </label>        <input type="checkbox" name="GestUser" value="1" class="previlege" <? if($RolesInfo['GestUser']){echo 'checked';} ?>>     </div>    <div class="form-group">        <label class="fixed-width-label">            Voir Liste des délégués </label>            <input type="checkbox" name="vueDM" value="1" class="previlege" <? if($RolesInfo['vueDM']){echo 'checked';} ?>>     </div>    <div class="form-group">        <label class="fixed-width-label">            Voir Liste des prospects </label>              <input type="checkbox" name="vuePros" value="1" class="previlege" <? if($RolesInfo['vuePros']){echo 'checked';} ?>>            </div>    <div class="form-group">        <label class="fixed-width-label">            Supprimer les prospects </label>              <input type="checkbox" name="SupPros" value="1" class="previlege" <? if($RolesInfo['SupPros']){echo 'checked';} ?>>           </div>    <div class="form-group">        <label class="fixed-width-label">            Modifier les prospects </label>              <input type="checkbox" name="ModPros" value="1" class="previlege" <? if($RolesInfo['ModPros']){echo 'checked';} ?>>            </div>    <div class="form-group">        <label class="fixed-width-label">            Modifier ces demande </label>              <input type="checkbox" name="Moddemande" value="1" class="previlege" <? if($RolesInfo['Moddemande']){echo 'checked';} ?>>            </div>    <div class="form-group">        <label class="fixed-width-label">            Modifier ces visite </label>              <input type="checkbox" name="ModVisite" value="1" class="previlege" <? if($RolesInfo['ModVisite']){echo 'checked';} ?>>            </div>    <button type="submit" class="btn btn-danger pull-right" name="AddBtn" value="1">Modifier</button>    <div class="clearfix"></div></div><div class="box-footer">                                          </div>            </div>        </div>   </form>            </div></section><!-- /.content -->