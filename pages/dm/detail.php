<?php
$id=  filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
if($id){


if(filter_input(INPUT_POST,'Commadd')){
// ajouter 1er commentaire  : 
    $com=array(
        'id'=>"",
        'demande_id'=>$id,
        'cree_par'=>$_SESSION['user']['id'],
        'com'=>  filter_input(INPUT_POST,'message',FILTER_SANITIZE_STRING),
        'created_at'=>date("Y-m-d H:i:s")
    );
   if(add($com,'commentaire')){
             $_SESSION['msg'] = "Commentaire ajouter";

              $_SESSION['type'] ="alert-success";
 
   }else{

        $_SESSION['msg']="Une Erreur c'est produite"; 

        $_SESSION['type']="alert-danger";

       // redirect('Liste-demandes');

}
}
    
    $Detail=  get('*','demande',array('id='=>$id));
    $DetailInfo=$Detail['reponse'][0]; 
    $Com=get("*",'commentaire',array('demande_id='=>$id),'AND',array('created_at'=>"ASC"));
    $ListeCom=$Com['reponse'];
    $user=get("*",'users',array('id='=>$DetailInfo['id_user']));
    $profile=$user['reponse'][0];
   }else{
    $_SESSION['msg']="Une Erreur c'est produite"; 

        $_SESSION['type']="alert-danger";

       redirect('Liste-demandes');
}
?>

<section class="content-header">
    <h1>Demande Détail
        <small></small>
    </h1>
</section><!-- Main content -->
<section class="content">

    <div class="row">
    <div class="col-md-3">
        
        <div class="box box-success">
              <div class="box-body box-profile">

   <h3 class="profile-username text-center"><?=$profile['Civilite'].' '.$profile['Nom']." ".$profile['Prenom']?> </h3>

                    <p class="text-muted text-center"><?=$profile['Email'] ?></p>

                    <p class="text-muted text-center"><?=$profile['Tel'] ?></p>
                    <p class="text-muted text-center"><?=getinfo($profile['type'],'user_type','name')?></p>
 
                     
                 </div>
        </div>
               
    </div>
    <div class="col-md-5">
        
        <div class="box box-info">
        <div class="box-body">
            <ul>
                <li>Type : <?= getinfo($DetailInfo['type'],'type_demande','name') ?></li>
                <li>Objectif : <?=$DetailInfo['objectif']?></li>
                <li>Budget demandé : <?=$DetailInfo['budget_demander']?></li>
                <li>Budget Investi : <?=$DetailInfo['budget_investi']?></li>
                <li>Lieu : <?=$DetailInfo['lieu']?></li>
                <li>Date : <?=$DetailInfo['date']?></li>
                <li>Filter pour les prospect invoquer
                    <ul>
                        <li>Spécialité : <?$SpecInfo=  explode("@_@",$DetailInfo['Spec']);
                        foreach ($SpecInfo as $Spec):
                            echo getinfo($Spec,'specialite','nom').' - ';
                        endforeach;
                        ?></li>
                        <li>Gouvernorat : <?$GouvInfo=  explode("@_@",$DetailInfo['secteur']);
                        foreach ($GouvInfo as $Gouv):
                            echo getinfo($Gouv,'gouvernerat','nom').' - ';
                        endforeach;
                        ?></li>
                        <li>Délégation : <?$DeleInfo=  explode("@_@",$DetailInfo['delegation']);
                        foreach ($DeleInfo as $Dele):
                            echo getinfo($Dele,'delegation','nom').' - ';
                        endforeach;
                        ?></li>
                    </ul>
                    </li>
              
            </ul>
            <h4>Liste final des prospects invoquer (<?=$DetailInfo['all_pros']?>): </h4>
            <?
            if($DetailInfo['prospects']){
                $ListePro=  explode('_@_',$DetailInfo['prospects']);
                echo '<ul>';
                foreach ($ListePro as $pro):
                  if($pro){
                      echo '<li><a href="'.WEBRoot.'/prospects/profile?id='.$pro.'" class="">'.  getinfo($pro,'prospect','Nom').' '.getinfo($pro,'prospect','Prenom').'</a></li>';
                  }
                endforeach;
                  echo '</ul>';
            }else{
                echo '<p>Tous les prospect ('.$DetailInfo['all_pros'].') sont inviter</p>'; 
            }
            
            ?>
            
            
            
        </div>
            
        </div>
               
    </div>
       
        <div class="col-md-4">
        
        <div class="box box-warning direct-chat direct-chat-warning">
                    <div class="box-header with-border">
                      <h3 class="box-title">Commentaires</h3>
                       
                    </div><!-- /.box-header -->
                    <div class="box-body">
                      <!-- Conversations are loaded here -->
                      <div class="direct-chat-messages">
                      <?
                                  foreach ($ListeCom as $UserCom):
                                      if($_SESSION['user']['id']!=$UserCom['cree_par']):
                                     ?>
                          
                          <!-- Message. Default to the left -->
                        <div class="direct-chat-msg">
                          <div class="direct-chat-info clearfix">
                              <span class="direct-chat-name pull-left"><?=  getinfo($UserCom['cree_par'],'users','Nom').' '.getinfo($UserCom['cree_par'],'users','Prenom')?></span>
                            <span class="direct-chat-timestamp pull-right"><?=$StdFunctions->AfficheDateFr($UserCom['created_at'])?></span>
                          </div><!-- /.direct-chat-info -->
                          <img class="direct-chat-img" src="<?=WEBRoot?>/dist/img/user1-128x128.jpg" alt="message user image"><!-- /.direct-chat-img -->
                          <div class="direct-chat-text">
                            <?=$UserCom['com']?>
                          </div><!-- /.direct-chat-text -->
                        </div><!-- /.direct-chat-msg -->
                          
                          <?
                                      else:
                            ?>
                        <div class="direct-chat-msg right">
                          <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name pull-right"><?=  getinfo($UserCom['cree_par'],'users','Nom').' '.getinfo($UserCom['cree_par'],'users','Prenom')?></span>
                            <span class="direct-chat-timestamp pull-left"><?=$StdFunctions->AfficheDateFr($UserCom['created_at'])?></span>
                          </div><!-- /.direct-chat-info -->
                          <img class="direct-chat-img" src="<?=WEBRoot?>/dist/img/user6-128x128.jpg" alt="message user image"><!-- /.direct-chat-img -->
                          <div class="direct-chat-text">
                             <?=$UserCom['com']?>
                          </div><!-- /.direct-chat-text -->
                        </div><!-- /.direct-chat-msg -->
                          <?endif;endforeach;?>                         
                        <!-- Message to the right -->
                       </div><!--/.direct-chat-messages-->

                      <!-- Contacts are loaded here -->
                    
                    </div><!-- /.box-body -->
                    <?if($DetailInfo['validation']<=0):?>
                    <div class="box-footer">
                      <form action="" method="post">
                        <div class="input-group">
                          <input type="text" name="message" placeholder="Ajouter un commentaire" class="form-control">
                          <span class="input-group-btn">
                              <button type="submit" class="btn btn-warning btn-flat" name="Commadd" value="1">Envoyer</button>
                          </span>
                        </div>
                      </form>
                    </div><!-- /.box-footer-->
                     <?endif?>
                  </div>
               
    </div>
         
    </div>
</section>