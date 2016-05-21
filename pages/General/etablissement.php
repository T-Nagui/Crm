<?php
$Bread="etablissement";
$Suppid=  filter_input(INPUT_GET,'SuppID',FILTER_VALIDATE_INT);
if($Suppid!=""){
   // Test avant la suppréssion
$Ls=get('*','prospect',array('etablissement='=>$Suppid));
if($Ls['total']>0){
    $_SESSION['msg']="Immpossible de supprimer ce Etablissement, est utiliser ";
    $_SESSION['type']="alert-danger";
}else{
     delete($Suppid,'etablissement');
     $_SESSION['msg'] = "La suppresion est bien éffectuer";
     $_SESSION['type'] ="alert-success";
      header('Location:etablissement');
}
 
}
$id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
$SpecFormBModi=  filter_input(INPUT_POST,'SpecFormBModi',FILTER_VALIDATE_INT); 
if($SpecFormBModi){
    //modification
     update(filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT),array(
         'nom'=>  filter_input(INPUT_POST,'SpecInp',FILTER_DEFAULT),
         'gouv_id'=>  filter_input(INPUT_POST,'secteur',FILTER_VALIDATE_INT)
         ),'etablissement');
     $_SESSION['msg'] = "La modification est bien passer";
     $_SESSION['type'] ="alert-success";
}
$SpecFormB=  filter_input(INPUT_POST,'SpecFormB',FILTER_VALIDATE_INT); 
if($SpecFormB){
    //ajout
    add(array('id'=>"",'nom'=>filter_input(INPUT_POST,'SpecInp',FILTER_DEFAULT),
         'gouv_id'=>  filter_input(INPUT_POST,'secteur',FILTER_VALIDATE_INT)),'etablissement');
     $_SESSION['msg'] = "L'ajout est bien passer";
     $_SESSION['type'] ="alert-success";
}
$ListeOfSpec=get("*",'etablissement')
?>
<section class="content-header">
  <h1> Gestion des établissements
 <small></small>
 </h1> 
</section><!-- Main content -->
<section class="content">   
    <div class="row">
        <form method="post" action="etablissement" class=""> <div class="col-md-4">
        
            <div class="box box-danger pad">
                <input type="hidden" name="id" value="<?=$id?>">
                <div class="form-group">
                    <label>Etablissement</label>
                    <input type="text" name="SpecInp" value="<?=getGenInfo($id,'etablissement','id','nom')?>" class="form-control">
                </div>
                <div class="form-group"> 
                      <label for="Secteur">Secteur</label>

                      <select id="Secteur" name="secteur" class="form-control" required>

                                <option value="">Choix du secteur</option>

                                <?php
                   if($id){
                       $idSect=getGenInfo($id,'delegation','id','gouv_id');
                   }
                                $ListeSecteur=get("*",'gouvernerat');

                                foreach($ListeSecteur['reponse'] as $sect):

                                ?>

                     <option value="<?=$sect['id']?>" <? if($idSect==$sect['id']){   echo 'selected="selected"';} ?> ><?=$sect['nom']?></option>

                                <?endforeach?>

                            </select>
                </div>
                <? if($id): ?>
                 <button class="btn btn-warning btn-block" value="1" name="SpecFormBModi">Modifier un établissement</button>
                    <?else:?>
                  <button class="btn btn-primary btn-block" value="1" name="SpecFormB">Ajouter un établissement</button>
                <?  endif;?>
              
               
           
        </div>
         
        </div></form>
        <div class="col-md-8">
            <div class="box box-success table-responsive">
                <table class="table table-condensed table-hover">
                    <thead>
                    <th>#id</th>
                    <th>Texte</th>
                    <th>Gouvernorat</th>
                    <th>Action</th>
                    </thead>
                    <tbody>
                        <? foreach ($ListeOfSpec['reponse'] as $Spec): ?>
                        <tr>
                            <td><?=$Spec['id']?></td>
                            <td><?=$Spec['nom']?></td>
                            <td><?=  getinfo($Spec['gouv_id'],'gouvernerat','nom')?></td>
                            <td>
                                <a href="etablissement?id=<?=$Spec['id']?>" class="btn btn-warning">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                                  <a data-id="<?=$Spec['id']?>" data-title="Suppresion d'un etablissement" href="#" class="btn btn-danger confirm-delete">                                <i class="glyphicon glyphicon-trash"></i>

                            </a>  
                            </td>
                        </tr>
                        <?  endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
