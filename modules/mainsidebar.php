<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

       

         

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Menu</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="<?=WEBRoot?>"><i class="fa fa-dashboard"></i> <span>Tableau de Bord</span></a></li>

            <li class="treeview">
                <a href="#"><i class="fa fa-users"></i> <span>Prospect</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="<?=WEBRoot?>/prospects/liste">Liste</a></li>
                    <li><a href="<?=WEBRoot?>/prospects/ajouter">Ajouter</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-paperclip"></i> <span>Demandes</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu"> 
                    <li><a href="<?=WEBRoot?>/dm/demande">Ajouter une demande</a></li>
                    <li><a href="<?=WEBRoot?>/dm/Liste-demandes">Liste des demande</a></li>
                </ul>
            </li>
            <? if($_SESSION['user']['type']==1): ?>
            <li class="treeview">
                <a href="#"><i class="fa fa-adn"></i> <span>Administrateur</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="<?=WEBRoot?>/admin/Ajouter-Utilisateur">Ajouter un utilisateurs</a></li>
                    <li><a href="<?=WEBRoot?>/admin/liste">Liste des utilisateurs</a></li>
                    <li><a href="<?=WEBRoot?>/admin/liste-a-supprimer">Demande d'effacer</a></li>
                    <li><a href="<?=WEBRoot?>/admin/liste-a-valider">Demande d'ajout</a></li>
                    <li><a href="<?=WEBRoot?>/admin/liste-supprimer">Liste archive</a></li>
                    <li><a href="<?=WEBRoot?>/admin/Liste-demandes">Demande effacer</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-codepen"></i> <span>Configuration</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="<?=WEBRoot?>/General/Secteur">Gestion des Secteur</a></li>
                    <li><a href="<?=WEBRoot?>/General/Deleg">Gestion des délégations</a></li>
                    <li><a href="<?=WEBRoot?>/General/Spec">Gestion des spécialités</a></li>
                    <li><a href="<?=WEBRoot?>/General/etablissement">Gestion des établissements</a></li>

                </ul>
            </li>
            <li class=" ">
                <a href="<?=WEBRoot?>/products/ajouter"><i class="fa fa-barcode"></i> <span>Produits</span> </a>
                
            </li>
            <?  endif;?>
            <li class=" ">
                <a href="<?=WEBRoot?>/GestDoc"><i class="fa fa-desktop"></i> <span>Gestion des documents</span> </a>
                
            </li>
           <!-- <li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>-->
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>