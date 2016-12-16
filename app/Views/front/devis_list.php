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
					<th>Objet du service</th>
					<th>Catégorie</th>
					<th>Sous Catégorie</th>
					<th>Créé le</th>
					<th>Prévu le</th>
					<th class="text-center">Devis proposés</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>

			<tbody>
				<?php $cpt = 0; ?>
				<?php foreach($projects as $project): ?>

					<?php if(empty($project['designation'])): ?> <!-- Si le champ désignation est renseigné c'est que le provider a fait une estimation sur cette sous catégorie de projet, il ne faut donc pas l'ajouter-->
						<?php $cpt++; ?>
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

					<?php endif; ?>

				<?php endforeach; ?>

				<?php if($cpt == 0): ?>
					<tr><td colspan="8">Aucun service.</td></tr>
				<?php endif; ?>

			</tbody>

		</table>

	<?php else: ?>
		<p>Aucun service.</p>
	<?php endif; ?>

	<!-- ######################################################## -->

	<div class="page-header">
		<h1>Mes devis proposés</h1>
	</div>

	<!-- Liste des projets -->
	<?php if(!empty($listdevis)): ?>	

		<table class="table table-responsive table-bordered">

			<thead>
				<tr>
					<th>Devis</th>
					<th>Lieu du service</th>
					<th>Objet du service</th>
					<th>Catégorie</th>
					<th>Sous Catégorie</th>
					<th>Prévu le</th>
					<th>Montant TTC (€)</th>
					<th>Etat</th>
					<th>Action</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($listdevis as $devis): ?>
				<tr>
					<td><?=$devis['id'] ?></td>
					<td><?=$devis['projectZipCode'] ?></td>
					<td><?=$devis['projectTitle'] ?></td>
					<td><?=$devis['titleSector'];?></td>
					<td><?=$devis['titleSubsector'];?></td>
					<td><?=DateTime::createFromFormat('Y-m-d', $devis['projectPredicted'])->format('d/m/Y');?></td>
					<?php 
						$montantTTC = $devis['ht_amount'] * (1 +($devis['tva_amount']/100));
					?>
					<td class="text-right"><?=$montantTTC;?></td>
					<td>
						<?php if($devis['accepted']): ?>
							Accepté
						<?php elseif($devis['projectClosed']): ?>
							Non retenu
						<?php else: ?>
							En cours d'étude
						<?php endif; ?>
					</td>
					<td class="text-center">
						<a href="<?=$this->url('front_devis_add', ['id' => $project['idprojetsubsector']]);?>" class="btn btn-info btn-sm" title="Proposer un devis">
					 		Consulter mon devis
						</a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>

		</table>

	<?php else: ?>
		<p>Aucun devis proposé.</p>
	<?php endif; ?>



</div>

<?php $this->stop('main_content') ?>
