<?php $this->layout('layout', ['title' => 'Accueil']) ?>

<?php $this->start('header_content') ?>
    <header id="myCarousel" class="carousel slide">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
            <li data-target="#myCarousel" data-slide-to="3"></li>
        </ol>
       
        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <a href="<?=$this->url('front_service_add')?>" class="test"> C'est parti</a>
            <div class="item active">
                <div class="fill" style="background-image:url('<?= $this->assetUrl('img/alliance.jpg') ?>');"></div>
                <div class="carousel-caption">
                    <h2>&Eacute;vènements</h2>
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('<?= $this->assetUrl('img/alliance.jpg') ?>');"></div>
                <div class="carousel-caption">
                    <h2>Services à la Personne</h2>
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('<?= $this->assetUrl('img/travaux2.jpg') ?>');"></div>
                <div class="carousel-caption">
                    <h2>Construction, Rénovation</h2>
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('<?= $this->assetUrl('img/repair.jpg') ?>');"></div>
                <div class="carousel-caption">
                    <h2>Transport, Logistique</h2>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>
   
    </header>
<?php $this->stop('header_content') ?>


<?php $this->start('banniere_content') ?>
 <!-- BANNIERE -->
    <section id="banner">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <p><i class="fa fa-fw fa-check"></i>&nbsp;Gratuit pour les particuliers</p>
                </div>
                <div class="col-md-4">
                    <p><i class="fa fa-fw fa-check"></i>&nbsp;Gratuit pour les professionnels</p>
                </div>
                <div class="col-md-4">
                    <p><i class="fa fa-fw fa-check"></i>&nbsp;Nombre de devis illimités et sans engagement</p>
                </div>
            </div>
        </div>
    </section>
<?php $this->stop('banniere_content') ?>


<?php $this->start('main_content') ?>

    <div class="container">

        <!-- COLONNE DERNIER PROJET -->
        <div class="row">

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="text-center"><i style="color:green;" class="fa fa-fw fa-check"></i>&nbsp;Dernier Projets</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="text-center list-group">
                            <li class="list-group-item">Cras justo odio</li>
                            <li class="list-group-item">Dapibus ac facilisis in</li>
                            <li class="list-group-item">Morbi leo risus</li>
                            <li class="list-group-item">Porta ac consectetur ac</li>
                            <li class="list-group-item">Vestibulum at eros</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- COLONNE COMMENT CA MARCHE -->
            <div class="col-md-4">
                <div class="panel panel-default commentcamarche">
                    <div class="panel-heading">
                        <h3 class="text-center"><i style="color:orange" class="fa fa-question-circle fa-fw" aria-hidden="true"></i>&nbsp;Comment ça marche ?</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <span class="pucecolor">1</span>
                                Vous décrivez votre demande de service avec un maximum de détails.
                            </li>
                            <li class="list-group-item">
                                <span class="pucecolor">2</span>
                                Des professionnels émettent des propositions de devis adaptés.
                            </li>
                            <li class="list-group-item">
                                <span class="pucecolor">3</span>
                                Vous comparez alors les devis des professionnels et validez ceux de votre choix.
                            </li>
                            <li class="list-group-item">
                                <span class="pucecolor">4</span>
                                Les coordonnées des professionnels retenus vous sont alors mises à disposition et vous entrez directement en relation avec eux.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- COLLONE TOP ARTISANS -->
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="text-center"><i style="color:gold" class="fa fa-list-ol" aria-hidden="true"></i>&nbsp; Top Artisans</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="text-center list-group">
                            <li class="list-group-item">Cras justo odio</li>
                            <li class="list-group-item">Dapibus ac facilisis in</li>
                            <li class="list-group-item">Morbi leo risus</li>
                            <li class="list-group-item">Porta ac consectetur ac</li>
                            <li class="list-group-item">Vestibulum at eros</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    	<hr>

    </div>

<!-- /.container -->
<?php $this->stop('main_content') ?>

<?php $this->start('js') ?>
<?php $this->stop('js') ?>