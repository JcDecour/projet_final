<?php $this->layout('layout', ['title' => 'Mes devis']); ?>


<?php $this->start('main_content') ?>

<div class="content-site">
	<div class="page-header">
		<h1>Liste des offres de services des particuliers</h1>
	</div>

	<!-- Liste des projets -->
	<?php if(!empty($projects)): ?>	

		<table class="table table-responsive table-bordered">

			<thead>
				<tr>
					<th>Lieu</th>
					<th>Libellé du service</th>
					<th>Catégorie</th>
					<th>Sous Catégorie</th>
					<th>Créé le</th>
					<th>Prévu le</th>
					<th class="text-center">Devis</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($projects as $project): ?>
				<tr>
					<td><?=$project['zip_code'] ?></td>
					<td><?=$project['title'] ?></td>
					<td><?=$project['titlesector'];?></td>
					<td><?=$project['titlesubsector'];?></td>
					<td><?=DateTime::createFromFormat('Y-m-d H:i:s', $project['created_at'])->format('d/m/Y');?></td>
					<td><?=DateTime::createFromFormat('Y-m-d', $project['predicted_date'])->format('d/m/Y');?></td>
					<td class="text-center">
						<?php if($project['closed']): ?>
							<span class="text-danger">Cloturé</span>
						<?php else: ?>
							<span class="badge badge-success"><?=$project['nbdevisprojetsubsector'];?></span>
						<?php endif; ?>	
					</td>
					<td class="text-center">
						<a href="<?=$this->url('front_devis_add', ['id' => $project['idprojetsubsector']]);?>" class="btn btn-success btn-sm" title="Proposer un devis">
					 		Proposer un devis
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

</div>

<?php $this->stop('main_content') ?>
