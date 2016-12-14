<?php $this->layout('layout', ['title' => 'Supprimer un service']); ?>

<?php $this->start('main_content') ?>
	
	<div class="forms">
	<div class="page-header">
		<h1 class="text-center">Supprimer un service</h1>
	</div>

	<!-- Formulaire de déconnexion -->
	<form method="post" class="form-horizontal">
			
		<div class="form-group">
			<div class="col-md-6 col-md-offset-4">
				<h3>Confirmez la suppression du service</h3>

				<?php if(empty($project)): ?>
					<div class="alert alert-danger">
					Ce service n'existe !
					</div>
				<?php else: ?>
				<a href="<?=$this->url('front_list_services');?>" class="btn btn-default" title="Retour à la liste des services">
				Annuler
				</a>
				&nbsp; 
				<button type="submit" class="btn btn-info" name="delete">
				Supprimer
				</button>
				<?php endif; ?>
			</div>
		</div>
	</form>
</div>
<?php $this->start('main_content') ?>