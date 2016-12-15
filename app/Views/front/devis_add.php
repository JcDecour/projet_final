<?php $this->layout('layout', ['title' => 'Ajout d\'un devis']) ?>

<?php $this->start('main_content') ?>

	<div class="page-header">
		<h1>Proposition de devis</h1>
	</div>

	<!-- Code postal du lieu du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Code postal du lieu du service:</label>  
		<div class="col-md-9"><?=$projectSubsector['zip_code'];?></div>
	</div>

	<!-- Objet du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Objet du service:</label>  
		<div class="col-md-9"><?=$projectSubsector['title'];?></div>
	</div>

	<br>

	<!-- Description du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Description:</label>  
		<div class="col-md-9"><?=nl2br($projectSubsector['description']);?></div>
	</div>

	<br>

	<!-- Date prévisionnelle du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Date prévisonnelle:</label>  
		<div class="col-md-9"><?=DateTime::createFromFormat('Y-m-d', $projectSubsector['predicted_date'])->format('d/m/Y');?></div>
	</div>

	<br>

	<!-- Catégorie / Ss Catégorie du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Catégorie / Sous Catégorie:</label>
		<div class="col-md-9"><span class="tag label label-default"><?=$projectSubsector['titlesector'];?> - <?=$projectSubsector['titlesubsector'];?></span></div> 
	</div>

	<!-- ########### -->
	<!-- PARTIE DEVIS-->
	<!-- ########### -->

	<br>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Devis</h3>
		</div>
		<div class="panel-body">
			<form method="post">
				<table class="table table-bordered">
 
				</table>
			</form>
		</div>
	</div>



<?php $this->stop('main_content') ?>
