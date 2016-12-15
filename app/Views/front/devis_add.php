<?php $this->layout('layout', ['title' => 'Ajout d\'un devis']) ?>

<?php $this->start('main_content') ?>

	<div class="page-header">
		<h1>Ajouter un devis</h1>
	</div>

	<!-- Code postal du lieu du service -->
	<div class="row">
		<label class="col-md-4 control-label text-right" for="zip_code">Code postal du lieu du service:</label>  
		<div class="col-md-8"><?=$projectSubsector['zip_code'];?></div>
	</div>

	<!-- Objet du service -->
	<div class="row">
		<label class="col-md-4 control-label text-right" for="zip_code">Objet du service:</label>  
		<div class="col-md-8"><?=$projectSubsector['title'];?></div>
	</div>

	<br>

	<!-- Description du service -->
	<div class="row">
		<label class="col-md-4 control-label text-right" for="zip_code">Description:</label>  
		<div class="col-md-8"><?=nl2br($projectSubsector['description']);?></div>
	</div>

	<br>

	<!-- Date prévisionnelle du service -->
	<div class="row">
		<label class="col-md-4 control-label text-right" for="zip_code">Date prévisonnelle:</label>  
		<div class="col-md-8"><?=DateTime::createFromFormat('Y-m-d', $projectSubsector['predicted_date'])->format('d/m/Y');?></div>
	</div>

	<br>

	<!-- Catégorie / Ss Catégorie du service -->
	<div class="row">
		<label class="col-md-4 control-label text-right" for="zip_code">Catégorie / Sous Catégorie:</label>
		<div class="col-md-8"><span class="tag label label-default"><?=$projectSubsector['titlesector'];?> - <?=$projectSubsector['titlesubsector'];?></span></div> 
	</div>



<?php $this->stop('main_content') ?>
