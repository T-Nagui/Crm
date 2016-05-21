<?
// récupération des produits 
$Prodc=get("*",'products');
$cible_val=get("*",'cible_val');
$id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);

if($id){
    $profileInf=   get("*",'prospect',array('id='=>$id));
    $profile=$profileInf['reponse'][0];
}
if(filter_input(INPUT_POST,'AffecterProd')):
$Yes=  filter_input(INPUT_POST,'Yes',FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
$CibV=  filter_input(INPUT_POST,"CibV",FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
//boocler tous product
foreach ($Prodc['reponse'] as $PRodL): 
// ajout d'un test si le produit déjà affecter : 
 $CiBleInfo=$StdFunctions->testAffectation($PRodL['id'],$id);
    if($Yes[$PRodL['id']]):

    if($CiBleInfo){ // déja affecter donc update
        $datas=array( 
            'valeur'=>$CibV[$PRodL['id']], 
            "modifier_par"=>$_SESSION['user']['id'],
            "created_at"=>date('Y-m-d H:i:s'),
        );
        update($CiBleInfo['id'], $datas,'cible');
    }else{ // non affecter donc ajouter 
        $data=array(
            'id'=>"",
            'prospect'=>$id,
            'prod_id'=>$PRodL['id'],
            'valeur'=>$CibV[$PRodL['id']],
            "cree_par"=>$_SESSION['user']['id'],
            "modifier_par"=>0,
            "created_at"=>date('Y-m-d H:i:s'),
        );
        add($data, 'cible');
    }
    else:
        
    if(count($CiBleInfo)){ 
        delete($CiBleInfo['id'],'cible');
    }
endif;    
endforeach;    

endif;
?>
<section class="content-header">

    <h1 class="pull-left">Ciblage Prospect - Produits </h1> 

 
    <a href="liste" class="btn bg-maroon pull-right"><i class="glyphicon glyphicon-backward"></i>  retour </a>

    <div class="clearfix"></div>
</section>



<!-- Main content -->

<section class="content">

    <div class="row">
        <div class="col-md-3">

        <div class="box box-primary">

            <div class="box-body box-profile">



                <h3 class="profile-username text-center"><?=$profile['nom']." ".$profile['prenom']?> </h3>

                <p class="text-muted text-center"><?=getinfo($profile['spec'],'specialite','nom'); ?></p>

                <p class="text-muted text-center"><?=$profile['titre'] ?></p>



                <ul class="list-group list-group-unbordered">

                        <li class="list-group-item">

                            <b>Tel.</b> <?=$profile['tel']?>

                        </li>

                        <li class="list-group-item">

                            <b>GSM</b> <?=$profile['gsm']?>

                        </li>

                        <li class="list-group-item">

                            <b>E-mail</b> <?=$profile['email']?>

                        </li>

                        <li class="list-group-item">

                            <b>Gouvernorat</b> <?=  getinfo($profile['gouvernorat'],'gouvernerat','nom')?>

                        </li>

                        <li class="list-group-item">

                            <b>Delegation</b> <?=  getinfo($profile['delegation'],'delegation','nom')?>

                        </li>

                        <li class="list-group-item">

                            <b>Adresse</b> <?=$profile['adresse']?>

                        </li>

                        <li class="list-group-item">

                            <b>CP</b> <?=$profile['code_postal']?>

                        </li>



                    </ul>



            </div><!-- /.box-body -->
    </div>
    </div>
        <div class="col-md-9">
              <div class="box box-primary">
                  <div class="box-header box-title">
                      Les produits
                  </div>
                  <div class="box-body box-profile">
                      <form method="post" action="">
                          <? foreach ($Prodc['reponse'] as $Product): 
                               $CiBleInfo=$StdFunctions->testAffectation($Product['id'],$id); 
                              ?>
                          <div class="col-md-4">
                              <h2><?=$Product['name']?> <small><?=$Product['categorie']?></small></h2>
                              <div class="form-group">
                                  <input type="checkbox" name="Yes[<?=$Product['id']?>]" class="switcher" <?if(!$CiBleInfo):
    echo 'checked="false"';
                            endif;?>>
                              </div>
                              <div class="form-group">
                                  <select class="form-control" name="CibV[<?=$Product['id']?>]">
                                      <? foreach ($cible_val['reponse'] as $CibVal): ?>
                                      <option value="<?=$CibVal['id']?>" <?if($CiBleInfo['valeur']==$CibVal['id']):
    echo 'selected="selected"';
                                      endif;?> ><?=$CibVal['valeur']?></option>
                                      <?  endforeach;?>
                                  </select>
                              </div>
                          </div>
                          <?  endforeach;?>
                          <div class="clearfix"></div>
                          <button type="submit" class="btn btn-primary pull-right" name="AffecterProd" value="1">Affecter Produits</button>
                           <div class="clearfix"></div>
                      </form>
                     
                  </div>
                  </div>
        </div>
    </div>
</section>

