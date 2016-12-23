<?php $this->layout('layout', ['title' => 'Comment ça marche']); ?>

<?php $this->start('main_content') ?>

<div class="content-site help">
	
	<div class="page-header">
		<h1>Particulier: Comment ça marche</h1>
	</div>
	
	<br>

	<div class="row">
		
		<div class="col-md-12">
			<div class="col-lg-1 col-md-12 text-center">
				<img src="<?= $this->assetUrl('img/devis.jpg') ?>" alt="..."  class="img-rounded">
			</div>
			<div class="col-lg-11 col-md-12 helperol">
				<ol>
					<h4><li>Vous effectuez gratuitement votre demande de service avec un maximum de détails.</li><h4>
					
					<h4><li>Des professionnels vous font des propositions de devis.</li></h4>
					
					<h4><li>Comparez les devis reçus.</li></h4>
					
					<h4><li>Sélectionnez et validez ceux que vous souhaitez retenir.</li></h4>
					
					<h4><li>Vous entrez alors directement en contact avec les professionnels.</li></h4>
					
					<h4><li style="color:orange;"><bold>Aucun intermédiaire.</bold></li></h4>
				</ol>
			</div>
		</div>



	</div>
	
</div>

<?php $this->stop('main_content') ?>