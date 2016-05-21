<?php
/**
 * Created by PhpStorm.
 * User: T-Yazen
 * Date: 01/05/2016
 * Time: 21:19
 */

$id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
$ids=filter_input(INPUT_POST,'Prog',FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
if($id){
    $ids=array();
    $ids=array_push($ids,$id);
}
$CurrentWeekNumber = date("W");
$Weeks[1]= $StdFunctions->getWeek($CurrentWeekNumber,2016);
$Weeks[0]= $StdFunctions->getWeek($CurrentWeekNumber-1,2016);
$Weeks[2]= $StdFunctions->getWeek($CurrentWeekNumber+1,2016);
$Weeks[3]= $StdFunctions->getWeek($CurrentWeekNumber+2,2016);
$Weeks[4]= $StdFunctions->getWeek($CurrentWeekNumber+3,2016);
ksort($Weeks);
if(filter_input(INPUT_POST,'ProgV',FILTER_VALIDATE_INT )){
    //ajout des prospect avec multiple si choix multiple
    $idsPro=filter_input(INPUT_POST,'ProId');
    $dateRange=filter_input(INPUT_POST,'dateRange');
    foreach (explode(',',$idsPro) as $Pros){
       add(array(
           'id'=>'',
           'pros_id'=>$Pros,
           'user_id'=>$_SESSION['user']['id'],
           'date_prog_visite'=>$dateRange
       ), 'prog_visite');
        $_SESSION['msg'] = "Programe Ajouter";

        $_SESSION['type'] = "alert-success";
        unset($_Post);
    }
}
if($_SESSION['user']['type']<=2){
    //si admin
   $userID=filter_input(INPUT_GET,'idDel',FILTER_VALIDATE_INT);
    if(!$userID){
        $userID=  $_SESSION['user']['id'];
    }

}else{
    $userID=$_SESSION['user']['id'];
}

?>
<section class="content-header">
    <h1 class="pull-left">Programme de la semaine  </h1>
    <a href="liste" class="btn bg-maroon pull-right">Retour à la liste</a>
    <div class="clearfix"></div>
</section><!-- Main content -->
<section class="content">

    <div class="row">


        <div class="col-md-12">

            <div class="box box-primary table-responsive">
                <div class="clearfix"></div>
                <? if($_SESSION['user']['type']<2 || $_SESSION['user']['type']==5): ?>
                <form class="form-inline pull-left" method="get">
                    <br/>
                    <div class="form-group">
                        <label for="TypeClient"> Programme de : </label>
                        <select class="form-control" name="user" onchange="GetPage('MyProgramme')" id="TypeClient">
                            <option value=""> Par utilisateur</option>
                            <?
                            $ListeUser=get('*','users');
                            foreach($ListeUser['reponse'] as $user):
                                ?>
                                <option value="<?=$user['id']?>" <?if($user['id']==$userID){
                                    echo "selected=selected";
                                }?>><?=$user['Nom'].' '.$user['Prenom'] ?></option>
                            <?endforeach;?>

                        </select>
                    </div>
                </form>
                <?endif?>





                <div class="clearfix"></div>

                <?if($ids):?>
                    <br/>
                    <form class="form-inline pull-right" method="post" style="margin: 10px">
                        <input type="hidden" name="ProId" value="<?=implode($ids,',')?>">
                        <? if($_SESSION['user']['type']<2 || $_SESSION['user']['type']==5): ?>
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
                        <?endif?>
                        <div class="form-group">
                            <label>Choix du jour</label>
                            <select class="form-control" name="dateRange">

                     <? foreach ($Weeks as $key=>$week): if($key>0): ?>
                                    <option value="<?=$week['start'].'_'.$week['end']?>">De <?=$week['start'] ?> A <?=$week['end'] ?></option>
                                <?endif;endforeach;?>

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Prospect</label>
                            <ul>
                            <?
                            foreach ($ids as $id){
                                echo '<li>'.getinfo($id,'prospect','nom').' '.getinfo($id,'prospect','prenom');
                                echo '</li>';
                                $names.=getinfo($id,'prospect','nom').' '.getinfo($id,'prospect','prenom').' ';
                            }
                            ?>
                            </ul>

                        </div>
                        <button type="submit" name="ProgV" value="1" class="btn btn-flat btn-microsoft">Programmer la visite</button>

                    </form>

                    <div class="clearfix"></div>
                    <hr/>
                <?endif?>
                    <br/>
                    <?
                   


                    ?>
                    <br/>

                <table class="table table-bordered">
                    <thead>
                    <tr> 
                    <th>Semaine Du - A</th> 
                    <th>Prospect à visiter</th>
                    <th></th>
                    </tr>
                    </thead>
                    <?


                   // $period = new DatePeriod(date("Y-m-d",strtotime($weekTable['start'])), $interval,date("Y-m-d",strtotime($weekTable['end'])));
                    ?>
                    <tbody> <? foreach ($Weeks as $week):
                    $period=$StdFunctions->createDateRangeArray($week['start'],$week['end']);
                  //  foreach ($period as $jour):
                    ?>
                    <tr>
                          
                            <td>De <?=$week['start'] ?> A  <?=$week['end'] ?></td>
                            <td><? // test with range and db
                                $Liste=get("*",'prog_visite',array(
                                    'user_id='=>$userID,
                                    'date_prog_visite='=>$week['start'].'_'.$week['end']
                                ));
                          foreach ($Liste['reponse'] as $ProsInfo):
                            //  print_r($ProsInfo); ?>
                          <a href="profile?id=<?=$ProsInfo['id']?>" class="btn <?=$StdFunctions->CheckDate($week['start'],$week['end'] , $ProsInfo['id'],$userID)?> btn-block">
                          <?=getinfo($ProsInfo['id'],'prospect','nom').' '.getinfo($ProsInfo['id'],'prospect','prenom')?>
                          </a>
                           <?endforeach;?></td>
                            <td></td>

                    </tr>   <?endforeach; ?>
                    </tbody>
                </table>
            </div>
            </div>
            </div>
            </section>
