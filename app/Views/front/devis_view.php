<?php $this->layout('layout', ['title' => 'Consultation d\'un devis']) ?>

<?php $this->start('main_content') ?>

<div class="content-site">
    
	<div class="page-header">
		<h1>Consultation d'un devis</h1>
	</div>
    
    
    <!-- Code postal du lieu du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Code postal du lieu du service:</label>  
		<div class="col-md-9"><?=$devis['projectZipCode'];?></div>
	</div>

	<!-- Objet du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Objet du service:</label>  
		<div class="col-md-9"><?=$devis['projectTitle'];?></div>
	</div>

	<br>

	<!-- Description du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Description:</label>  
		<div class="col-md-9"><?=nl2br($devis['projectDescription']);?></div>
	</div>
    
    <br>
    
    <!-- Date prévisionnelle du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Date prévisonnelle:</label>  
		<div class="col-md-9"><?=DateTime::createFromFormat('Y-m-d', $devis['projectPredicted'])->format('d/m/Y');?></div>
	</div>
    
    <!-- Catégorie / Ss Catégorie du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Catégorie / Sous Catégorie:</label>
		<div class="col-md-9"><span class="tag label label-default"><?=$devis['titleSector'];?> - <?=$devis['titleSubsector'];?></span></div> 
	</div>
    
    
    
    
</div>

<?php $this->stop('main_content') ?>