<?php $this->layout('layout', ['title' => 'Liste des devis sur le service']); ?>

<?php $this->start('my_header') ?>

<?php $this->stop('my_header') ?>

<?php $this->start('main_content') ?>

	<div class="page-header">
		<h1>Liste des devis sur le service</h1>
	</div>

	<?php if(!empty($project)): ?>
	<div class="row">
		<ul class="list-group col-md-4">
		  <li class="list-group-item">Service&nbsp;:&nbsp;<?=$project['title'] ?></li>
		  <li class="list-group-item">Crée le&nbsp;:&nbsp;<?=DateTime::createFromFormat('Y-m-d H:i:s', $project['created_at'])->format('d/m/Y');?></li>
		  <li class="list-group-item">Délai&nbsp;:&nbsp;<?=DateTime::createFromFormat('Y-m-d', $project['predicted_date'])->format('d/m/Y');?></li>
		</ul>
	</div>

	<?php foreach($subSectors as $subSector): ?>
	<div class="row">
		<div class="panel panel-primary">
		 
		  <div class="panel-heading"><?=$subSector['title'] ?></div>

		  
		  <table class="table">
		    <thead>
		    	<th>Devis</th>
		    	<th>Désignation</th>
		    	<th>Prix HT</th>
		    	<th>TVA %</th>
		    	<th>Prix TTC</th>
		    	<th>Date de création</th>
		    	<th>Votre choix</th>
		    </thead>
		 
			<tbody>
			  	<?php foreach($datasDevis as $dataDevis): ?>
			  	<tr>
			  		<td><?=$dataDevis['id'] ?></td>
			  		<td><?=$dataDevis['company_name'] ?></td>
			  		<td><?=$dataDevis['ht_amount'] ?></td>
			  		<td><?=$dataDevis['tva_amount'] ?></td>
			  		<td><?=$dataDevis['ht_amount']*(1 + $dataDevis['tva_amount']/100) ?></td>
			  		<td><?=DateTime::createFromFormat('Y-m-d H:i:s', $dataDevis['created_at'])->format('d/m/Y');?></td>
			  		<td></td>
			  	</tr>
			  	<?php endforeach; ?>
			 </tbody>
		   </table>
		</div>
	</div>
	<?php endforeach; ?>
	<?php else: ?>
		<p>Aucune offre enregistrée</p>
	<?php endif; ?>

<?php $this->stop('main_content') ?>