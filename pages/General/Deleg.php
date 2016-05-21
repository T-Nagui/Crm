<?php
$Bread="Deleg";
$Suppid=  filter_input(INPUT_GET,'SuppID',FILTER_VALIDATE_INT);
if($Suppid!=""){
   // Test avant la suppréssion
$Ls=get('*','prospect',array('delegation='=>$Suppid));
if($Ls['total']>0){
    $_SESSION['msg']="Immpossible de supprimer cette Délégation, est utiliser ";
    $_SESSION['type']="alert-danger";
}else{
     delete($Suppid,'delegation');
     $_SESSION['msg'] = "La suppresion est bien éffectuer";
     $_SESSION['type'] ="alert-success";
      header('Location:Deleg');
}
 
}
$id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
$SpecFormBModi=  filter_input(INPUT_POST,'SpecFormBModi',FILTER_VALIDATE_INT); 
if($SpecFormBModi){
    //modification
     update(filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT),array(
         'nom'=>  filter_input(INPUT_POST,'SpecInp',FILTER_DEFAULT),
         'gouv_id'=>  filter_input(INPUT_POST,'secteur',FILTER_VALIDATE_INT)
         ),'delegation');
     $_SESSION['msg'] = "La modification est bien passer";
     $_SESSION['type'] ="alert-success";
}
$SpecFormB=  filter_input(INPUT_POST,'SpecFormB',FILTER_VALIDATE_INT); 
if($SpecFormB){
    //ajout
    add(array(
        'id'=>"",
        'nom'=>filter_input(INPUT_POST,'SpecInp',FILTER_DEFAULT),
        'gouv_id'=>  filter_input(INPUT_POST,'secteur',FILTER_VALIDATE_INT)),
       'delegation');
     $_SESSION['msg'] = "L'ajout est bien passer";
     $_SESSION['type'] ="alert-success";
}
$ListeOfSpec=get("*",'delegation')
?>
<section class="content-header">
  <h1> Gestion des délégations
 <small></small>
 </h1> 
</section><!-- Main content -->
<section class="content">   
    <div class="row">
        <form method="post" action="Deleg" class=""> <div class="col-md-4">
        
            <div class="box box-danger pad">
                <input type="hidden" name="id" value="<?=$id?>">
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
                <div class="form-group">
                    <label>Délégations</label>
                    <input type="text" name="SpecInp" value="<?=getGenInfo($id,'delegation','id','nom')?>" class="form-control">
                </div> 
                <? if($id): ?>
                 <button class="btn btn-warning btn-block" value="1" name="SpecFormBModi">Modifier une délégation</button>
                    <?else:?>
                  <button class="btn btn-primary btn-block" value="1" name="SpecFormB">Ajouter une délégation</button>
                <?  endif;?>
              
               
           
        </div>
         
        </div></form>
        <div class="col-md-8">
            <div class="box box-success table-responsive">
                <table class="table table-condensed table-hover">
                    <thead>
                    <th>#id</th>
                    <th>Texte</th>
                    <th>Gouvernerat</th>
                    <th>Action</th>
                    </thead>
                    <tbody>
                        <? foreach ($ListeOfSpec['reponse'] as $Spec): ?>
                        <tr>
                            <td><?=$Spec['id']?></td>
                            <td><?=$Spec['nom']?></td>
                            <td><?=  getinfo($Spec['gouv_id'],'gouvernerat','nom')?></td>
                            <td>
                                <a href="Deleg?id=<?=$Spec['id']?>" class="btn btn-warning">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                                  <a data-id="<?=$Spec['id']?>" data-title="Suppresion d'une delegation" href="#" class="btn btn-danger confirm-delete">                                <i class="glyphicon glyphicon-trash"></i>

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
