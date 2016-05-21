<?
if(filter_input(INPUT_POST,'addFile')){ 
  $data=array(
      'id'=>'',
      'name'=>UppImg('doc/'),
      'titre'=>  filter_input(INPUT_POST,'titre'),
      'type'=>  filter_input(INPUT_POST,'prev'),
      'public'=>  1,
      'cree_par'=>$_SESSION['user']['id'],
      'created_at'=>date("Y-m-d H:i:s")
  );
    if(add($data,'doc')){
      $_SESSION['msg'] = "L'ajout du doc est bien passer";

              $_SESSION['type'] ="alert-success";
 

     } else

        {  $_SESSION['msg']="Une Erreur c'est produite";



        $_SESSION['type']="alert-danger";
 

        } 
    
 
  
}
$Bread="GestDoc";

$Suppid=  filter_input(INPUT_GET,'SuppID',FILTER_VALIDATE_INT);

if($Suppid!=""){

   // update($Suppid,array('public'=>0,'modifier_par'=>$_SESSION['user']['id']),'prospect');

   update($Suppid,array('public'=>'0'),'doc');

    header('Location:GestDoc');



}
?>
<section class="content-header">
    <h1>Documents partagés
        <small></small>
    </h1>
</section><!-- Main content -->
<section class="content">

    <div class="row">
    <div class="col-md-12">
        
        <div class="box box-success">
            <?if($_SESSION['user']['type']==1):?>
            <form class="" method="post" enctype="multipart/form-data">
                <div class="col-md-4">
                <div class="form-group">
                    <label>Titre du document</label>
                    <input type="text" name="titre" value="" class="form-control">
                </div>
                <div class="form-group">
                    <label>
                        <input type="radio" name="prev" value="1" checked> Pour Admin 
                    </label>
                    <label>
                        <input type="radio" name="prev" value="0" > Pour tous 
                    </label>
                </div>
                <div class="form-group">
                    <input type="file" name="fichier">
                </div>
                <button type="submit" name="addFile" value="1" class="btn btn-pinterest">Ajouter le doc</button>
                <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </form>
            <?  endif;?>
              <div class="clearfix"></div><br/>
            <?php
            $Docx=get("*",'doc',array('public='=>1));
            foreach ($Docx['reponse'] as $docs): if($docs['type']==0): ?>
            <a class="btn btn-app" href="<?=WEBRoot?>/doc/<?=$docs['name']?>" target="_blank">
                    <i class="fa fa-save"></i>  <?=$docs['titre']?>
                  </a>  
               <?if($_SESSION['user']['type']==1):?>
             <a data-id="<?=$docs['id']?>" data-title="Suppresion d'un document" href="#" class="btn btn-danger confirm-delete">

                                <i class="glyphicon glyphicon-trash"></i>

                            </a> 
              <?endif;?>
            <?else:
                if($_SESSION['user']['type']==1){
                    ?>
                <a class="btn btn-app" href="<?=WEBRoot?>/doc/<?=$docs['name']?>" target="_blank">
                    <i class="fa fa-save"></i>  <?=$docs['titre']?>
                  </a>  
                   <?if($_SESSION['user']['type']==1):?>
             <a data-id="<?=$docs['id']?>" data-title="Suppresion d'un document" href="#" class="btn btn-danger confirm-delete">

                                <i class="glyphicon glyphicon-trash"></i>

                            </a> 
              <?endif;?>
              <?
                }
endif;
                endforeach;
            ?>
            
        </div>
    </div>
    </div>
</section>

