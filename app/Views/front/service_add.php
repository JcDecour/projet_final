<?php $this->layout('layout_eal_asupp', ['title' => 'Accueil']) ?>

<?php $this->start('main_content') ?>
	
	<div class="forms">

		<div class="page-header">
			<h1>Description du service</h1>
		</div>

		<form method="post" class="form-horizontal" enctype="multipart/form-data">

			<p class="text-required-filed">
				<span class="obligatoire">*</span>
				Champs obligatoires
			</p>

			<!-- Zone géographique concernée par le devis -->
			<div class="form-group">
				<label class="col-md-4 control-label" for="zip_code">
					Code postal du lieu des travaux
					<span class="obligatoire">*</span>
				</label>  
				<div class="col-md-1">
					<input id="zip_code" name="title" type="text" class="form-control input-md">
				</div>
			</div>

			<!-- Objet de l'estimation -->
			<div class="form-group">
				<label class="col-md-4 control-label" for="title">
					Objet du devis
					<span class="obligatoire">*</span>
				</label>  
				<div class="col-md-4">
					<input id="title" name="title" type="text" class="form-control input-md">
				</div>
			</div>

			<!-- Description du projet -->
			<div class="form-group">
				<label class="col-md-4 control-label" for="description">
					Descriptif du service
					<span class="obligatoire">*</span>
				</label>  
				<div class="col-md-6">
					<textarea id="description" name="description" rows="4" placeholder="Soyez le plus précis possible dans les éléments de description" class="form-control"></textarea>
				</div>
			</div>

			<!-- Date prévisionnelle du projet -->
			<div class="form-group">
				<label class="col-md-4 control-label" for="description">
					Date prévisonnelle (jj/mm/aaaa)
					<span class="obligatoire">*</span>
				</label>  
				<div class="col-md-2">
					<input id="title" name="title" type="text" class="form-control input-md">
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label" for="sector" >
					Catégorie
					<span class="obligatoire">*</span>
				</label>
				<div class="col-md-2">
					<select id="sector" name="sector" class="form-control">
						<option value="" selected disabled>Catégorie</option>
						<?php var_dump($sectors); ?>
						<?php foreach($sectors as $sector) :; ?>
							<option value="<?=$sector['id'];?>"><?=$sector['title'];?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-2">
					<select id="sub-sector" name="sub-sector" class="form-control">
						<option value="" selected disabled>Sous-Catégorie</option>
					</select>
				</div>
			</div>	

			<!-- Si le User est déja connecté, ses infos de connexion ne lui sont pas demandées -->
			<?php if(!$w_user): ?>
				<div class="form-group">
					<label class="col-md-4 control-label" for="email">
						Email
						<span class="obligatoire">*</span>
					</label>  
					<div class="col-md-4">
						<input id="email" name="email" type="email" placeholder="votre@email.fr" class="form-control input-md">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label" for="password">
						Mot de passe
						<span class="obligatoire">*</span>
					</label>  
					<div class="col-md-4">
						<input id="email" name="password" type="password" class="form-control input-md">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label" for="confirm-password">
						Confirmation du mot de passe
						<span class="obligatoire">*</span>
					</label>  
					<div class="col-md-4">
						<input id="email" name="confirm-password" type="confirm-password" class="form-control input-md">
					</div>
				</div>
			<?php endif; ?>

			<div class="form-group">
				<div class="col-md-3 col-md-offset-9">
					<button type="submit" class="btn btn-info btn-block">Valider</a>
				</div>
			</div>

		</form>
	</div>

<?php $this->stop('main_content') ?>



<?php $this->start('js') ?>

<script type="text/javascript">

	$(document).ready(function(){

		 $('button[type="submit"]').click(function(e){

			e.preventDefault(); //Empeche la soumission du formulaire
			
		
		});
	});

</script>

<?php $this->stop('js') ?>
