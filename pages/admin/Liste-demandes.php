<?php/** * Created by PhpStorm. * User: NAGUI * Date: 10/11/2015 * Time: 14:41 */$Bread="Liste-demandes";$Suppid=  filter_input(INPUT_GET,'SuppID',FILTER_VALIDATE_INT);if($Suppid!=""){    update($Suppid,array('public'=>0,'modifier_par'=>$_SESSION['user']['id']),'demande');    header('Location:Liste-demandes');}$ListeDemandes = get('*', 'demande',array('public='=>0));?><section class="content-header">    <h1 class=""> Liste des demandes supprimer     </h1> </section><!-- Main content --><section class="content">    <div class="row">        <div class="col-md-12">            <div class="box box-primary table-responsive">                <table class="table table-bordered table-condensed table-hover">                    <thead>                        <tr>                            <th>Objectif</th>                            <th>Lieu</th>                            <th>Date</th>                            <th>Action</th>                        </tr>                    </thead>                    <tbody><? foreach ($ListeDemandes['reponse'] as $demande):           ?>                            <tr>                                <td><?= $demande['objectif'] ?></td>                                <td><?= $demande['lieu'] ?></td>                                <td><?= $demande['date'] ?></td>                                <td>                                </td>                            </tr><?  endforeach; ?>                    </tbody>                </table>            </div>        </div>    </div></section>