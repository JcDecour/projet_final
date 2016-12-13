<?php $this->layout('layout', ['title' => 'Supprimer un service']); ?>

<?php $this->start('main_content') ?>
	
	<div class="page-header">
		<h1> Supprimer un service</h1>
	</div>

	<?php if(empty($project)): ?>
		<div class="alert alert-danger">
				Ce service n'existe !
		</div>
	<?php else: ?>
		<div class="container">
			<p class="alert alert-danger">Voulez-vous vraiment supprimer le service &laquo; <?=$project['title'];?> &raquo; ?</p>

			<form method="post">

				<a href="<?=$this->url('front_list_services');?>" class="btn btn-default" title="Retour à la liste des services">
				Annuler
				</a>

			 	<input type="submit" name="delete" value="Oui, je veux supprimer ce  service" class="btn btn-success">
			</form>
		</div>
	<?php endif; ?>
<?php $this->start('main_content') ?>