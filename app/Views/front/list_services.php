<?php $this->layout('layout', ['title' => 'Liste des services']); ?>


<?php $this->start('main_content') ?>

	<div class="page-header">
		<h1>Liste des services</h1>
	</div>

	<?php if(!empty($projects)): ?>	
	<table class="table table-striped table-responsive">

		<thead>
			<tr>
				<th>Service</th>
				<th>Créé le</th>
				<th>Prévu le</th>
				<th class="text-center">Offres</th>
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

<?php $this->stop('main_content') ?>