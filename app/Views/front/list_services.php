<?php $this->layout('layout', ['title' => 'Liste des services']); ?>

<?php $this->start('main_content') ?>

	<div class="page-header">
		<h1>Liste des services</h1>
	</div>

	<?php if(!empty($projects)): ?>
	<table class="table">

		<thead>
			<tr>
				<th>Service</th>
				<th>Date du création</th>
				<th>Délai</th>
				<th>Etat d'avancement</th>
				<th>Action</th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($projects as $project): ?>
			<tr>
				<td><?=$project['title'] ?></td>
				<td><?=DateTime::createFromFormat('Y-m-d H:i:s', $project['created_at'])->format('d/m/Y');?></td>
				<td><?=DateTime::createFromFormat('Y-m-d H:i:s', $project['predicted_date'])->format('d/m/Y');?></td>
				<td></td>
				<td>
					<a href="<?=$this->url('front_delete_service', ['id' => $project['id']]);?>" class="text-danger" title="Supprimer ce service">
					 Supprimer
					</a>
					&nbsp; 
					<a href="<?=$this->url('front_edit_service', ['id' => $project['id']]);?>" class="text-info" title="Modifier ce service">
					 Modifier
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