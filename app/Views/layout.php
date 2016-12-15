<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->e($title) ?></title>
    
    <link rel="stylesheet" href="<?= $this->assetUrl('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= $this->assetUrl('css/modern-business.css') ?>">
    <!-- Custom Fonts -->
    <link rel="stylesheet" type="text/css" href="<?= $this->assetUrl('font-awesome/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= $this->assetUrl('css/styles.css') ?>">
</head>
<body>

    <!--Barre de  Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= $this->url('front_default_index') ?>">DevisCible</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                   
                    <?php if((!$w_user) || (!isset($w_user['siret']))): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Espace particulier<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?= $this->url('front_customer_help') ?>">Comment ça marche ?</a>
                                </li>
                                <li>
                                    <a href="<?= $this->url('front_list_services') ?>">Mes demandes de services</a>
                                </li>
                                <li>
                                    <?php if($w_user): ?>
                                        <a href="blog-post.html">Mon profil</a>
                                    <?php else: ?>
                                        <a href="<?= $this->url('front_customer_signin')?>">S'inscrire</a>
                                    <?php endif; ?>
                                </li>
                                 <li>
                                    <?php if($w_user): ?>
                                        <a href="<?= $this->url('front_customer_logout') ?>">Se déconnecter</a> 
                                    <?php else: ?>
                                        <a href="<?= $this->url('front_customer_login') ?>">Se connecter</a>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>    

                    <?php if((!$w_user) || (isset($w_user['siret']))): ?>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Espace professionel<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="full-width.html">Comment ça marche ?</a>
                                </li>
                                <li>
                                    <a href="sidebar.html">Consulter les services</a>
                                </li>
                                <li>
                                    <a href="<?= $this->url('front_provider_signin') ?>">S'inscrire</a>
                                </li>
                                <li>
                                    <?php if($w_user): ?>
                                        <a href="<?= $this->url('front_customer_logout') ?>">Se déconnecter</a> 
                                    <?php else: ?>
                                        <a href="<?= $this->url('front_provider_login') ?>">Se connecter</a>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="<?= $this->url('front_service_list_allusers') ?>">Consulter les demandes de services</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
   
    <!-- Entete -->
    <?= $this->section('header_content') ?>

    <!-- Banière -->
    <?= $this->section('banniere_content') ?>

    <!-- Contenu -->
    <main class="container">
        <?= $this->section('main_content') ?>
    </main>

    <!-- Pied de page -->
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
            wrap: true, // défillement en continue
        });

    });

    </script>
</body>
</html>