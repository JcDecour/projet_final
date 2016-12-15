<?php $this->layout('layout', ['title' => 'Liste des propositions']); ?>


<?php $this->start('main_content') ?>



	<div class="page-header">
		<h1>Liste des offres de services des particuliers</h1>
	</div>

	<!-- Liste des projets -->
	<?php if(!empty($projects)): ?>	

		<table class="table table-responsive table-bordered">

			<thead>
				<tr>
					<th>Lieu</th>
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
					<td><?=$project['zip_code'] ?></td>
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
						<a href="<?=$this->url('front_service_view_allusers', ['id' => $project['id']]);?>" class="btn btn-success btn-sm" title="Consulter ce service">
					 		Faire une offre
						</a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>

		</table>

	<?php else: ?>
		<p>Aucun service.</p>
	<?php endif; ?>

	<!-- ######################################################## -->

	<div class="page-header">
		<h1>Mes devis</h1>
	</div>



<?php $this->stop('main_content') ?>
