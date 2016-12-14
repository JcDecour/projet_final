<?php $this->layout('layout', ['title' => 'Accueil']) ?>
<?php $this->start('main_content') ?>
<?php if(!empty($projet)): ?>
		<h2><?=$projet['title']; ?></h2>
		<ul>
			<li>Nom du projet: <?=$projet['title'];?></li>
			<li>Lieu des Travaux(code postal): <?=$projet['zip_code'];?></li>
			<li>Description: <?=$projet['description'];?></li>
			<li>Date de réalisation souhaitée: <?=$projet['predicted_date'];?></li>
			<li>Date de Création: <?=$projet['created_at'];?></li>
		</ul>
	<?php  else: ?>
		<div class="alert alert-danger">
			Le Projet n'éxiste pas !
		</div>
	<?php endif; ?>
	</div>
<?php $this->stop('main_content') ?>
<?php $this->start('js') ?>
<?php $this->stop('js') ?>