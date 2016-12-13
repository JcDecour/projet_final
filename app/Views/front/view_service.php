<?php $this->layout('layout', ['title' => 'Détail des offres sur le service']); ?>

<?php $this->start('my_header') ?>

<?php $this->stop('my_header') ?>

<?php $this->start('main_content') ?>

	<div class="page-header">
		<h1>Détail des offres sur le service</h1>
	</div>

	<?php if(!empty($project)): ?>
	<ul class="list-group col-md-4">
	  <li class="list-group-item">Service&nbsp;:&nbsp;<?=$project['title'] ?></li>
	  <li class="list-group-item">Crée le&nbsp;:&nbsp;<?=DateTime::createFromFormat('Y-m-d H:i:s', $project['created_at'])->format('d/m/Y');?></li>
	  <li class="list-group-item">Délai&nbsp;:&nbsp;<?=DateTime::createFromFormat('Y-m-d', $project['predicted_date'])->format('d/m/Y');?></li>
	</ul>

	<ul>
	<?php foreach($datas as $data): ?>
		<li><?=$data['title'] ?></li>
	<?php endforeach; ?>
	</ul>
	<?php else: ?>
		<p>Aucune offre enregistrée</p>
	<?php endif; ?>

<?php $this->stop('main_content') ?>