<?$id=  filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);$user=get("*",'users',array('id='=>$id));$profile=$user['reponse'][0];$fil=filter_input(INPUT_POST,'Filter',FILTER_VALIDATE_INT); if($fil!==null){    $secteur=  filter_input(INPUT_POST,'secteur',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);      $delegation=  filter_input(INPUT_POST,'delegation',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);    $Spec=  filter_input(INPUT_POST,'Spec',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);    $EtabFilter=  filter_input(INPUT_POST,'Etab',FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);     $Superid=  filter_input(INPUT_POST,'Superid',FILTER_VALIDATE_INT);    $user_id=  filter_input(INPUT_POST,'user_id',FILTER_VALIDATE_INT);    $idM=  filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);     $SpecFi=  implode("@_@",$Spec);    $EtabFi=  implode("@_@",$EtabFilter );    $sectiFi=  implode("@_@",$secteur);    $deliFi=  implode("@_@",$delegation);     if($idM!=""){        $data=array(          'supID'=>$Superid,        'secteur'=>$sectiFi,        'delegation'=>$deliFi,        'spec'=>$SpecFi,         'etab'=>$EtabFi,         "modifier_par"=>$_SESSION['user']['id'],        "created_at"=>date('Y-m-d H:i:s'),    );    update($idM, $data,'liste');     $_SESSION['msg'] = "Filter modifier avec success";     $_SESSION['type'] = "alert-success";     redirect('liste');    }else{       $data=array(        'id'=>'',        'user_id'=>$id,        'supID'=>$Superid,        'secteur'=>$sectiFi,        'delegation'=>$deliFi,        'spec'=>$SpecFi,         'etab'=>$EtabFi,           "cree_par"=>$_SESSION['user']['id'],    "modifier_par"=>0,    "created_at"=>date('Y-m-d H:i:s'),    );    add($data,'liste');       $_SESSION['msg'] = "Filter ajouter avec success";     $_SESSION['type'] = "alert-success";     redirect('liste');    }    }$FilterListe=get('*','liste',array('user_id='=>$id));  $FilterInf=$FilterListe['reponse'][0]; $SectFilter=  explode('@_@',$FilterInf['secteur']);  $DelFilter=  explode('@_@',$FilterInf['delegation']);   $SpecFilter=  explode('@_@',$FilterInf['spec']);   $EtabliFilter=  explode('@_@',$FilterInf['etab']);   ?><section class="content-header">    <h1 class="pull-left"> Profile Utilisateur :    </h1> <a href="liste" class="btn bg-maroon pull-right"><i class="glyphicon glyphicon-backward"></i>  retour </a>    <div class="clearfix"></div> </section><!-- Main content --><section class="content">    <div class="row">        <div class="col-md-4">             <div class="box box-primary">                                 <div class="box-body box-profile">   <h3 class="profile-username text-center"><?=$profile['Civilite'].' '.$profile['Nom']." ".$profile['Prenom']?> </h3>                    <p class="text-muted text-center"><?=$profile['Email'] ?></p>                    <p class="text-muted text-center"><?=$profile['Tel'] ?></p>                    <p class="text-muted text-center"><?=getinfo($profile['type'],'user_type','name')?></p>                                       </div>                 </div>        </div>         <form class="" method="post">             <input type="hidden" name="user_id" value="<?=$FilterInf['user_id']?>">             <input type="hidden" name="id" value="<?=$FilterInf['id']?>">        <div class="col-md-8">             <div class="box box-danger">                 <div class="box-header">                     <h3 class="box-title">Liste affecter</h3>                 </div>                    <div class="box-body">                     <div class="form-group">                         <label>Choix de superviseur</label>                         <select class="form-control" name="Superid">                             <option>----</option>                             <?                             $ListeSuper=get("*",'users',array('type='=>2));                             foreach ($ListeSuper['reponse'] as $Super):                             ?>                             <option value="<?=$Super['id']?>" <? if($Super['id']==$FilterInf['supID']){                                 echo 'selected="selected"'; } ?> ><?=$Super['Nom'].' '.$Super['Prenom']?></option>                             <?  endforeach;?>                         </select>                     </div>                        <div class="form-group">                             <label>Choix du Secteur</label>                            <select id="Secteur" name="secteur[]" class="form-control select2" onchange="FindDel()" multiple="multiple">                                                             <?php                                $ListeSecteur=get("*",'gouvernerat',array('1='=>1),'AND',array('nom'=>'ASC'));                                                               foreach($ListeSecteur['reponse'] as $sect):                                ?>                     <option value="<?=$sect['id']?>" <? if(in_array($sect['id'], $SectFilter)) {echo 'selected="selected"';} ?> ><?=$sect['nom']?></option>                                <?endforeach?>                            </select>                        </div>                     <div id="DelListe">                        <div class="form-group">                                                   <?if($SectFilter):                           $DelListe=array();    foreach ($SectFilter as $FF){                            $Listedd=get("*",'delegation',array('gouv_id='=>$FF),"AND",array('id' => 'ASC'));                           array_push($DelListe,$Listedd['reponse']);    }?>                             <label>Délégations</label><select id="delegationListe" name="delegation[]" class="form-control select2" multiple="multiple">    <? foreach ($DelListe as $LIsteofDel): foreach ($LIsteofDel as $peos):?>    <option value="<?=$peos['id']?>" <? if(in_array($peos['id'],$DelFilter)) {echo 'selected="selected"';} ?>><?=$peos['nom']?></option>                               <?  endforeach;endforeach;?>                          </select>                       <?endif;?>                                                                                                   </div><div class="form-group">  <?if($SectFilter):                           $EtabListe=array();    foreach ($SectFilter as $FF){                            $Listeee=get("*",'etablissement',array('gouv_id='=>$FF),"AND",array('id' => 'ASC'));                           array_push($EtabListe,$Listeee['reponse']);    }  ?>                              <label>Etablissement</label>                            <select class="form-control select2" name="Etab[]" multiple="multiple">                                <?                                                               foreach ($EtabListe as $Etab): foreach ($Etab as $Eta):                                ?>                                <option value="<?=$Eta['id']?>" <? if(in_array($Eta['id'],$EtabliFilter))         {     echo 'selected="selected"';        } ?>                                        ><?=$Eta['nom']?></option>                                <?  endforeach;endforeach;?>                            </select><?endif;?>                        </div>                         </div>                        <div class="form-group">                             <label>Choix du Spécialité</label>                            <select id="Spec" name="Spec[]" class="form-control select2" multiple="multiple">                                                                <?php                                $ListeSpec=get("*",'specialite');                                foreach($ListeSpec['reponse'] as $spec):                                    ?>                                <option value="<?=$spec['id']?>" <? if(in_array($spec['id'],$SpecFilter)) {echo 'selected="selected"';} ?>><?=$spec['nom']?></option>                                <?endforeach?>                            </select>                        </div>                                                                                                <button type="submit" name="Filter" value="1" class="btn btn-warning">Filtrer</button>                        <a href="liste" class="btn btn-success">Annuler</a>                                    </div>                  </div>        </div></form>    </div>    </section>