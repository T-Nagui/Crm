<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$Bread="Spec";
$Suppid=  filter_input(INPUT_GET,'SuppID',FILTER_VALIDATE_INT);
if($Suppid!=""){
   // Test avant la suppréssion
$Ls=get('*','prospect',array('spec='=>$Suppid));
if($Ls['total']>0){
    $_SESSION['msg']="Immpossible de supprimer cette Spécialité est utiliser ";
    $_SESSION['type']="alert-danger";
}else{
     delete($Suppid,'specialite');
     $_SESSION['msg'] = "La suppresion est bien éffectuer";
     $_SESSION['type'] ="alert-success";
      header('Location:Spec');
}
 
}
$id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
$SpecFormBModi=  filter_input(INPUT_POST,'SpecFormBModi',FILTER_VALIDATE_INT); 
if($SpecFormBModi){
    //modification
     update(filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT),array('nom'=>  filter_input(INPUT_POST,'SpecInp',FILTER_DEFAULT)),'specialite');
     $_SESSION['msg'] = "La modification est bien passer";
     $_SESSION['type'] ="alert-success";
}
$SpecFormB=  filter_input(INPUT_POST,'SpecFormB',FILTER_VALIDATE_INT); 
if($SpecFormB){
    //ajout
    add(array('id'=>"",'nom'=>filter_input(INPUT_POST,'SpecInp',FILTER_DEFAULT)),'specialite');
     $_SESSION['msg'] = "L'ajout est bien passer";
     $_SESSION['type'] ="alert-success";
}
$ListeOfSpec=get("*",'specialite')
?>
<section class="content-header">
  <h1> Gestion des Spécialités
 <small></small>
 </h1> 
</section><!-- Main content -->
<section class="content">   
    <div class="row">
        <form method="post" action="Spec" class=""> <div class="col-md-4">
        
            <div class="box box-danger pad">
                <input type="hidden" name="id" value="<?=$id?>">
                <div class="form-group">
                    <label>Spécialité</label>
                    <input type="text" name="SpecInp" value="<?=getGenInfo($id,'specialite','id','nom')?>" class="form-control">
                </div>
                <? if($id): ?>
                 <button class="btn btn-warning btn-block" value="1" name="SpecFormBModi">Modifier une spécialité</button>
                    <?else:?>
                  <button class="btn btn-primary btn-block" value="1" name="SpecFormB">Ajouter une spécialité</button>
                <?  endif;?>
              
               
           
        </div>
         
        </div></form>
        <div class="col-md-8">
            <div class="box box-success table-responsive">
                <table class="table table-condensed table-hover">
                    <thead>
                    <th>#id</th>
                    <th>Texte</th>
                    <th>Action</th>
                    </thead>
                    <tbody>
                        <? foreach ($ListeOfSpec['reponse'] as $Spec): ?>
                        <tr>
                            <td><?=$Spec['id']?></td>
                            <td><?=$Spec['nom']?></td>
                            <td>
                                <a href="Spec?id=<?=$Spec['id']?>" class="btn btn-warning">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                                  <a data-id="<?=$Spec['id']?>" data-title="Suppresion d'une spécialité" href="#" class="btn btn-danger confirm-delete">                                <i class="glyphicon glyphicon-trash"></i>

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
