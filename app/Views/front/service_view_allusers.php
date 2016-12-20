<?php $this->layout('layout', ['title' => 'Vue d\'un service']) ?>

<?php $this->start('main_content') ?>

<div class="content-site">
	
	<div class="page-header">
		<h1>Consultation d'un service</h1>
	</div>
	
	<!-- N° de l'offre -->
	<div class="row">
		<label class="col-md-4 control-label text-right">N° Offre:</label>  
		<div class="col-md-8"><?=sprintf("%06d", $project['id'])?>&nbsp;( Ajoutée le <?=DateTime::createFromFormat('Y-m-d H:i:s', $project['created_at'])->format('d/m/Y');?> )</div>
	</div>

	<!-- Code postal du lieu du service -->
	<div class="row">
		<label class="col-md-4 control-label text-right">Code postal du lieu du service:</label>  
		<div class="col-md-8"><?=$project['zip_code'];?></div>
	</div>

	<!-- Objet du service -->
	<div class="row">
		<label class="col-md-4 control-label text-right">Objet du service:</label>  
		<div class="col-md-8"><?=$project['title'];?></div>
	</div>

    <br>
    
    <!-- Catégorie / Ss Catégorie du service -->
	<div class="row">
		<label class="col-md-4 control-label text-right">Catégorie / Sous Catégorie:</label>  
		<div class="col-md-8">
			<?php if(!empty($contenuSsSector)): ?>
				<?=$contenuSsSector;?>	
			<?php endif; ?>	
		</div>
	</div>

	<br>
    
	<!-- Description du service -->
	<div class="row">
		<label class="col-md-4 control-label text-right">Description:</label>  
		<div class="col-md-7 withbackground"><?=nl2br($project['description']);?></div>
	</div>

	<br>

	<!-- Date prévisionnelle du service -->
	<div class="row">
		<label class="col-md-4 control-label text-right">Date prévisionnelle:</label>  
		<div class="col-md-8"><?=DateTime::createFromFormat('Y-m-d', $project['predicted_date'])->format('d/m/Y');?></div>
	</div>

	<br>

    <div class="row">
		<div class="col-md-12 text-right">
			<a href="<?=$this->url('front_service_list_allusers');?>" class="btn btn-default" title="Ajouter un nouveau service">Retour liste</a>
		</div>
    </div>

</div>

<?php $this->stop('main_content') ?>