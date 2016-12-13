<?php $this->layout('layout', ['title' => 'Accueil']) ?>

<?php $this->start('my_header') ?>

        <header id="myCarousel" class="carousel slide">

        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
       
        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item active">
                <div class="fill" style="background-image:url('<?= $this->assetUrl('img/repair.jpg') ?>');"></div>
                <div class="carousel-caption">
                    <h2>Travaux</h2>
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('<?= $this->assetUrl('img/repair.jpg') ?>');"></div>
                <div class="carousel-caption">
                    <h2>Réparation</h2>
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('<?= $this->assetUrl('img/repair.jpg') ?>');"></div>
                <div class="carousel-caption">
                    <h2>Service a la personne</h2>
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


<?php $this->stop('my_header') ?>


<?php $this->start('main_content') ?>

		<!-- BANNIERE -->
    
   	<section class="banner">
        <div id="banner" class="col-lg-12">
            <h1 class=" text-center page-header">Welcome to Modern Business</h1>    
        </div>

        <!-- CONTENU DE PAGE -->
    
    </section>
    <div class="container">

        <!-- COLONNE DERNIER PROJET -->
      
        <div class="row">

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="text-center"><i style="color:green;" class="fa fa-fw fa-check"></i>&nbsp;Dernier Projets</h4>
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

                <!-- COLONNE COMMENT çA MARCHE -->

                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="text-center"><i style="color:orange" class="fa fa-question-circle fa-fw" aria-hidden="true"></i>&nbsp;Comment ça marche ?</h3>
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