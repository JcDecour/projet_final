<?php $this->layout('layout', ['title' => 'Devirama']) ?>

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

        <div class="txt">
            <p>Un service à faire réaliser par un professionnel ?
              <a href="<?=$this->url('front_service_add')?>" class=""> C'est parti</a>
            </p>
        </div>

            <div class="item active">
                <div class="fill" style="background-image:url('<?= $this->assetUrl('img/evenement.jpg') ?>');"></div>
                <div class="carousel-caption">
                    <h2>&Eacute;vénements</h2>
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('<?= $this->assetUrl('img/cours.jpg') ?>');"></div>
                <div class="carousel-caption">
                    <h2>Services à la personne</h2>
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('<?= $this->assetUrl('img/maison.jpg') ?>');"></div>
                <div class="carousel-caption">
                    <h2>Construction <span class="trait">-</span> Rénovation</h2>
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('<?= $this->assetUrl('img/transport.jpg') ?>');"></div>
                <div class="carousel-caption">
                    <h2>Transport <span class="trait">-</span> Logistique</h2>
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
                    <p><i class="fa fa-fw fa-check"></i>&nbsp;Gratuit pour les particuliers et les professionnels</p>
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
                        <h3 class="text-center"><i style="color:#ffb400;" class="fa fa-fw fa-check"></i>&nbsp;Les derniers services</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <?php foreach($topProjects as $key => $topProject): ?>
                                <li class="list-group-item">
                                    <span class="puce pucerecentservice">&#10004;</span>
                                   <?=DateTime::createFromFormat('Y-m-d H:i:s', $topProject['created_at'])->format('d/m/y');?>
                                    -&nbsp;<?=$topProject['title']; ?><br>
                                    (<i class="fa fa-fw fa-map-marker"></i><?=$topProject['zip_code']; ?> )
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
                        <h3 class="text-center"><i style="color:#ffb400" class="fa fa-question-circle fa-fw" aria-hidden="true"></i>&nbsp;Comment ça marche ?</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <span class="puce pucecommentcamarche">1</span>
                                Vous effectuez <span class="settofront">gratuitement</span> votre demande de service.
                            </li>
                            <li class="list-group-item">
                                <span class="puce pucecommentcamarche">2</span>
                                Des professionnels émettent <span class="settofront">gratuitement</span> leurs propositions de devis.
                            </li>
                            <li class="list-group-item">
                                <span class="puce pucecommentcamarche">3</span>
                                <span class="settofront">Comparez</span> et sélectionnez les devis reçus et validez ceux de votre <span class="settofront">choix</span>.
                            </li>
                            <li class="list-group-item">
                                <span class="puce pucecommentcamarche">4</span>
                                Les coordonnées des professionnels retenus vous sont alors <span class="settofront">instantanément</span> communiqués.
                            </li>
                            <li class="list-group-item">
                                <span class="puce pucecommentcamarche">5</span>
                                Vous entrez <span class="settofront">directement</span> en contact avec eux.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- COLLONE TOP ARTISANS -->
            <div class="col-md-4">
                <div class="panel panel-default topartisans">
                    <div class="panel-heading">
                        <h3 class="text-center"><i style="color:#ffb400" class="fa fa-thumbs-o-up " aria-hidden="true"></i>&nbsp;Le Top des professionnels</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <?php foreach($devis as $key => $devisVal): ?>
                                <li class="list-group-item">
                                    <span class="puce pucetopartisans"><i class="fa fa-fw fa-thumbs-o-up "></i></span>
                                    <?=$devisVal['company_name']; ?><br>
                                    (<i class="fa fa-fw fa-map-marker"></i><?=$devisVal['zipcode']; ?> )
                                </li>
                            <?php endforeach; ?>
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
