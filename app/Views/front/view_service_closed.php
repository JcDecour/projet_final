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
    
    <!-- Partie devis par catégrorie / ss-categorie-->
    <?php foreach($projectSubSectors as $key => $projectSubSector): ?>
    
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <?=$projectSubSector['sectorTitle'];?>&nbsp;-&nbsp;<?=$projectSubSector['subsectorTitle'];?>
            </div>
            <div class="panel-body">
                
                <!-- Cas d'absence de devis pour cette sous-catégorie, ou de non acceptation de l'un d'entre eux-->
                <?php if(empty($projectSubSector['id_provider'])): ?>
                    Aucun devis retenu.
                <?php endif; ?>
                
                
                <div class="row">
                    <label class="col-md-12 control-label" for="description">Informations complémentaires:</label>
                    <div class="col-md-12">

                    </div>
                </div>

            </div>
        </div>
    
    <?php endforeach; ?>
    
    
</div>

<?php $this->stop('main_content') ?>