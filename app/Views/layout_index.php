	<!DOCTYPE html>
	<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<title><?= $this->e($title) ?></title>
		
		<link rel="stylesheet" href="<?= $this->assetUrl('css/bootstrap.min.css') ?>">
		<link rel="stylesheet" href="<?= $this->assetUrl('css/modern-business.css') ?>">
		<!-- Custom Fonts -->
	    <link rel="stylesheet" type="text/css" href="<?= $this->assetUrl('font-awesome/css/font-awesome.min.css') ?>">
		<link rel="stylesheet" href="<?= $this->assetUrl('css/styles.css') ?>">
	</head>
	<body>
	 <!--barre de  Navigation -->
	    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	        <div class="container">

	            <!-- Brand and toggle get grouped for better mobile display -->
	            <div class="navbar-header">
	                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	                    <span class="sr-only">Toggle navigation</span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                </button>
	                <a class="navbar-brand" href="index.html">Start Bootstrap</a>
	            </div>
	            <!-- Collect the nav links, forms, and other content for toggling -->
	            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	                <ul class="nav navbar-nav navbar-right">
		                    <li><a href="contact.html">login</a></li>
	                    <li><a href="contact.html">logout</a></li>

	                    <li class="dropdown">
	                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Espace particulier<b class="caret"></b></a>
	                        <ul class="dropdown-menu">
	                            <li>
	                                <a href="blog-home-1.html">Comment ça marche ?</a>
	                            </li>
	                            <li>
	                                <a href="blog-home-2.html">Suivi</a>
	                            </li>
	                            <li>
	                                <a href="blog-post.html">Inscription</a>
	                            </li>
	                        </ul>
	                    </li>
	                    <li class="dropdown">
	                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Espace professionel<b class="caret"></b></a>
	                        <ul class="dropdown-menu">
	                            <li>
	                                <a href="full-width.html">Comment ça marche</a>
	                            </li>
	                            <li>
	                                <a href="sidebar.html">Consulter les demandes</a>
	                            </li>
	                            <li>
	                                <a href="faq.html">Inscription</a>
	                            </li>
							</ul>
	                    </li>
	                    <li>
	                        <a href="contact.html">Offre</a>
	                    </li>
	                </ul>
	            </div>
	            <!-- /.navbar-collapse -->
	        </div>
	        <!-- /.container -->
	    </nav>
	   
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
			


			<section>
				<?= $this->section('main_content') ?>
			</section>

			<footer>
				<div class="row">
	            <div id="update_footer" class="col-lg-12">
	                <div class="container">
	                    <ul class="footer_links">
	                        <li><a href="">Mention Légales</a></li>
	                        <li><a href="">Condition Générales d'utilisation</a></li>
	                        <li>
	                            <p>Copyright &copy; Your Website 2014</p>
	                        </li>
	                    </ul>
	                </div>
	            </div>
	        </div>
			</footer>

		<!-- jQuery -->	
	    
	    <script src="<?= $this->assetUrl('js/jquery.js') ?>"></script>

	    <!-- Bootstrap Core JavaScript -->
	    
	    <script src="<?= $this->assetUrl('js/bootstrap.min.js') ?>"></script>

		<?= $this->section('js') ?>
	

	    <!-- Script du Carousel -->
	    <script>
	    $(document).ready(function(){
	        $('.carousel').carousel({
	            interval: 5000, //vitesse de changement
	            pause: null, // défini l'activité du slider si il y a une activité de l'utilisateur ou pas
	            wrap: true,	// défillement en continue
	        });

	    });

	    </script>
	</body>
	</html>