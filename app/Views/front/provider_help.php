<?php $this->layout('layout', ['title' => 'Comment ça marche']) ?>

<?php $this->start('main_content') ?>

<div class="content-site help">
	
	<div class="page-header">
		<h1>Professionnel: Comment ça marche</h1>
	</div>
	
	<br>

	<div class="row">
		
		<div class="col-md-12">
			<div class="col-lg-1 col-md-12 text-center">
				<img src="<?= $this->assetUrl('img/help_prof.jpg') ?>" alt="..."  class="img-rounded">
			</div>
			<div class="col-lg-11 col-md-12 helperol">
				<ol id="help">
					<h4><li>Inscrivez vous gratuitement en décrivant votre activité avec un maximum de détails.</li></h4>
					
					<h4><li>Consultez gratuitement les propositions de services ou de projets déposées par les particuliers.</li></h4>
					
					<h4><li>Proposez des devis sur des services ou projets qui vous correspondent.</li></h4>
					
					<h4><li>Si une de votre offre est retenue par un particulier, vous avez dès alors accès au coordonnées de celui-ci.</li></h4>
					
					<h4><li style="color:orange;"><bold>Aucun intermédiaire.</bold></li></h4>
				</ol>
			</div>
		</div>

	</div>
	
</div>

<!-- /.container -->
<?php $this->stop('main_content') ?>