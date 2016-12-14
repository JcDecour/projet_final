<?php $this->layout('layout', ['title' => 'Liste des devis sur le service']); ?>

<?php $this->start('my_header') ?>

<?php $this->stop('my_header') ?>

<?php $this->start('main_content') ?>

	<div class="page-header">
		<h1>Liste des devis sur le service</h1>
	</div>

	<div class="row">
		<ul class="list-group col-md-4">
		  <li class="list-group-item">Service&nbsp;:&nbsp;<?=$project['title'] ?></li>
		  <li class="list-group-item">Crée le&nbsp;:&nbsp;<?=DateTime::createFromFormat('Y-m-d H:i:s', $project['created_at'])->format('d/m/Y');?></li>
		  <li class="list-group-item">Délai&nbsp;:&nbsp;<?=DateTime::createFromFormat('Y-m-d', $project['predicted_date'])->format('d/m/Y');?></li>
		</ul>
	</div>
<!-- on utilise un compteur pour gérer l'absence de devis pour un service -->
	<?php $cpt = 0;?>

	<?php foreach($projectsSubSector as $projectSubSector): ?>
	<div class="row">
		<div class="panel panel-primary">
		 
		  <div class="panel-heading"><?=$projectSubSector['title'] ?></div>

		  
		  <table class="table">
		    <thead>
		    	<th>Devis</th>
		    	<th>Société</th>
		    	<th>Prix HT</th>
		    	<th>TVA %</th>
		    	<th>Prix TTC</th>
		    	<th>Date de création</th>
		    	<th>Votre choix</th>
		    </thead>
		 
			<tbody>

			  	<?php foreach($datasDevis as $dataDevis): ?>

				  	<?php foreach($dataDevis as $data): ?>

				  		<?php if($projectSubSector['id'] == $data['id_project_subsector']):?>

						  	<tr>
						  		<td><?=$data['id'] ?></td>
						  		<td><?=$data['company_name'] ?></td>
						  		<td><?=$data['ht_amount'] ?></td>
						  		<td><?=$data['tva_amount'] ?></td>
						  		<td><?=$data['ht_amount']*(1 + $data['tva_amount']/100) ?></td>
						  		<td><?=DateTime::createFromFormat('Y-m-d H:i:s', $data['created_at'])->format('d/m/Y');?></td>
						  		<td>
						  			<input type="checkbox" name="choice" value="">
						  		</td>
						  	</tr>

							<?php $cpt++;?>

				 		<?php endif; ?>

				  	<?php endforeach; ?>
			  	 
			  	<?php endforeach; ?>
			 
			 </tbody>

			<?php if($cpt == 0):?>
				<tbody>
					<tr>
						<td colspan="7" class="text-danger">Aucun devis enregistré</td>
					</tr>
				</tbody>
			<?php endif;?>

			<?php $cpt=0;?>

		   </table>
		</div>
	</div>
	<?php endforeach; ?>

<?php $this->stop('main_content') ?>