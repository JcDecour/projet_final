<?php $this->layout('layout', ['title' => 'Consultation d\'un devis']) ?>

<?php $this->start('main_content') ?>

<div class="content-site">
    
	<div class="page-header">
		<h1>Consultation d'un devis</h1>
	</div>
    
    <!--Partie entete du devis (Récapitulatif)-->
        <!-- Code postal du lieu du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Code postal du lieu du service:</label>  
		<div class="col-md-9"><?=$project['zip_code'];?></div>
	</div>

	   <!-- Objet du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Objet du service:</label>  
		<div class="col-md-9"><?=$project['title'];?></div>
	</div>

	<br>

	   <!-- Description du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Description:</label>  
		<div class="col-md-9"><?=nl2br($project['description']);?></div>
	</div>
    
    <br>
    
        <!-- Date prévisionnelle du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Date prévisonnelle:</label>  
		<div class="col-md-9"><?=DateTime::createFromFormat('Y-m-d', $project['predicted_date'])->format('d/m/Y');?></div>
	</div>
    
    
    
    
</div>

<?php $this->stop('main_content') ?>