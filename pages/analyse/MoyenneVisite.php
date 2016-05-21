<?php
/**
 * Created by PhpStorm.
 * User: T-Yazen
 * Date: 14/04/2016
 * Time: 17:53
 */
?>
<section class="content-header">
    <h1 class=""> Activité global</h1>
</section><!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">

                <div class="box-header">
            <form method="get" class="form-inline">
                <div class="form-group">
                    <div class="form-group"><label>De </label><input type="date" name="de" class="form-control" required value="<?=$de?>"></div>
                    <div class="form-group"><label>A </label><input type="date" name="a" class="form-control" required value="<?=$a;?>"></div>
                </div>
            </form>



        </div>
        <div class="clearfix"></div>
        <br/>
        <table class="table table-bordered">
            <thead>
            <td>DM </td>
            <td>Nbre de visite "Medecins" </td>
            <td>Nbre de visite "Pharmacie" </td>
            <td>Nbre de visite "Pharmacien grossiste"</td>
            <td>Total</td>
            </thead>
            <tbody>
            <?
            $ListeUser=get('*','users',array('type>'=>2,'type<='=>4));
            foreach($ListeUser['reponse'] as $user):
                ?>
                <tr>
                    <td><?=$user['Nom'].' '.$user['Prenom'] ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>


            <?endforeach;?>
            </tbody>
        </table>
        </div>
        </div>
        </div>
    </section>
