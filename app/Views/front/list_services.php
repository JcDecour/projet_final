<?php $this->layout('layout', ['title' => 'Liste des services']); ?>

<?php $this->start('main_content') ?>

<div class="content-site">
	
	<div class="page-header">
		<h1>Liste des services</h1>
	</div>
	
		
	<?php if(isset($errorConsult) && $errorConsult): ?>
		<div class="row">
			<div class="col-md-12 text-right">
				<a href="<?=$this->url('front_customer_signin');?>" title="Compléter votre profil">Veuillez compléter votre profil pour consulter les devis</a>
			</div>
		</div>
	<?php endif; ?>

	<?php if(!empty($projects)): ?>	
	<table class="table table-bordered table-responsive">

		<thead>
			<tr>
				<th>Service</th>
				<th>Créé le</th>
				<th>Prévu le</th>
				<th class="text-center">Devis</th>
				<th class="text-center">Action</th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($projects as $project): ?>
			<tr>
				<td><?=$project['title'] ?></td>
				<td><?=DateTime::createFromFormat('Y-m-d H:i:s', $project['created_at'])->format('d/m/Y');?></td>
				<td><?=DateTime::createFromFormat('Y-m-d', $project['predicted_date'])->format('d/m/Y');?></td>
				<td class="text-center">
					<?php if($project['closed']): ?>
						<span class="text-danger">Cloturé</span>
					<?php else: ?>
						<span class="badge badge-success"><?=$project['nb_devis'];?></span>
					<?php endif; ?>	
				</td>
				<td class="text-center">
				<?php if(!$project['closed']): ?>
					<a href="<?=$this->url('front_delete_service', ['id' => $project['id']]);?>" class="btn btn-danger btn-sm" title="Supprimer ce service">
					 Supprimer
					</a>
					&nbsp; 
					<a href="<?=$this->url('front_edit_service', ['idProject' => $project['id']]);?>" class="btn btn-info btn-sm" title="Modifier ce service">
					 Modifier
					</a>
					&nbsp; 
                    <a href="<?=$this->url('front_view_service', ['id' => $project['id']]);?>" class="btn btn-success btn-sm" title="Consulter ce service">
					 Consulter
					</a>
                <?php else: ?>
                    <a href="<?=$this->url('front_devis_view_customer', ['id' => $project['id']]);?>" class="btn btn-success btn-sm" title="Consulter ce service">
					 Consulter
					</a>
				<?php endif; ?>
					
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php else: ?>
		<p>Vous n'avez aucun service encours</p>
	<?php endif; ?>
	<div>
		<a href="<?=$this->url('front_service_add');?>" class="btn btn-info" title="Ajouter un nouveau service">Nouveau service</a>
	</div>

</div>

<?php $this->stop('main_content') ?>