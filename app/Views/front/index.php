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
                <div class="fill" style="background-image:url('<?= $this->assetUrl('img/baby.jpg') ?>');"></div>
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
                    <p><i class="fa fa-fw fa-check"></i>&nbsp;Gratuit pour les particuliers et professionnels</p>
                </div>
                <div class="col-md-4">
                    <p><i class="fa fa-fw fa-check"></i>&nbsp;Pas d'intermédiaires</p>
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
                <div class="panel panel-default recentservice">
                    <div class="panel-heading">
                        <h3 class="text-center"><i style="color:orange;" class="fa fa-fw fa-check"></i>&nbsp;Les derniers Services</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <?php foreach($topProjects as $key => $topProject): ?>
                                <li class="list-group-item">
                                    <span class="pucerecentservice">&#10004;</span>
                                    <span class="markup"><?=DateTime::createFromFormat('Y-m-d H:i:s', $topProject['created_at'])->format('d/m/y');?></span>
                                    <?=$topProject['title']; ?>
                                    &nbsp;(<i class="fa fa-fw fa-map-marker"></i><?=$topProject['zip_code']; ?>)
                            </li>
                            <?php endforeach; ?>
                        
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
                                <span class="pucecommentcamarche">1</span>
                                Vous effectuez <span class="markup">gratuitement</span> votre demande de service.
                            </li>
                            <li class="list-group-item">
                                <span class="pucecommentcamarche">2</span>
                                Des professionnels émettent <span class="markup">gratuitement</span> leurs propositions de devis.
                            </li>
                            <li class="list-group-item">
                                <span class="pucecommentcamarche">3</span>
                                <span class="markup">Comparez</span> et sélectionnez les devis reçus et validez ceux de votre <span class="markup">choix</span>.
                            </li>
                            <li class="list-group-item">
                                <span class="pucecommentcamarche">4</span>
                                Les coordonnées des professionnels retenus vous sont alors accessibles et vous pouvez entrer <span class="markup">directement</span> en contact avec eux.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- COLLONE TOP ARTISANS -->
            <div class="col-md-4">
                <div class="panel panel-default topartisans">
                    <div class="panel-heading">
                        <h3 class="text-center"><i style="color:orange" class="fa fa-list-ol" aria-hidden="true"></i>&nbsp;Le Top des professionnels</h3>
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