<?php $this->layout('layout', ['title' => 'Mon profil']); ?>


<?php $this->start('main_content') ?>

<div class="content-site">
	<div class="forms">
		
		<div class="page-header">
			<h1>Mon profil</h1>
		</div>
	
		<form method="post" class="form-horizontal">
			<p class="text-required-filed">
				<span class="obligatoire">*</span>
				Champs obligatoires
			</p>
			<fieldset>
			<!-- affichage erreurs générale -->
			<?php if(isset($formErrors['global'])): ?>
	      		<div class="alert alert-danger" style="text-align:center;">
	        		<?=$formErrors['global'];?>
	      		</div>
	      	<?php elseif(isset($formValid['valid'])): ?>
	      		<div class="alert alert-info" style="text-align:center;">
	      			<?=$formValid['valid'];?>
	      		</div>
	      	<?php endif; ?>

				<!-- raison sociale-->
				<div class="form-group">
					<label class="col-md-4 control-label" for="company_name">Raison sociale:
						<span class="obligatoire">*</span>
					</label>
					<div class="col-md-4">
						<input id="company_name" name="company_name" type="text" value="<?=isset($provider['company_name']) ? $provider['company_name'] : '';?>" class="form-control input-md">
					</div>
						<!-- Gestion des erreurs -->
	        		<?php if(isset($formErrors['company_name'])): ?>
	        			<div class="error col-md-offset-4 col-md-8"><?=$formErrors['company_name']?>
	        			</div>
	        		<?php endif; ?>
	      		</div>
				

				<!-- description entreprise -->
				<div class="form-group">
					<label class="col-md-4 control-label" for="company_description">Description de l'entreprise:
						<span class="obligatoire">*</span>
					</label>
					<div class="col-md-4">
						<textarea class="form-control" id="company_description" name="company_description"><?=isset($provider['company_description']) ? $provider['company_description'] : '';?></textarea>
					</div>
						<!-- Gestion des erreurs -->
					<?php if(isset($formErrors['company_description'])): ?>
	        			<div class="error col-md-offset-4 col-md-8"><?=$formErrors['company_description']?>
	        			</div>
	        		<?php endif; ?>
				</div>

				<!-- siret-->
				<div class="form-group">
					<label class="col-md-4 control-label" for="siret">Siret:
						<span class="obligatoire">*</span>
					</label>
					<div class="col-md-4">
						<input id="siret" name="siret" type="text" value="<?=isset($provider['siret']) ? $provider['siret'] : '';?>" class="form-control input-md">
					</div>
						<!-- Gestion des erreurs -->
					<?php if(isset($formErrors['siret'])): ?>
	        			<div class="error col-md-offset-4 col-md-8"><?=$formErrors['siret']?>
	        			</div>
	        		<?php endif; ?>	
				</div>
				<!-- civilité -->
				<div class="form-group">
					<label class="col-md-4 control-label" for="civilite">Civilité :
						<span class="obligatoire">*</span>
					</label>
					<div class="col-md-2">
						<select id="civilite" name="civilite" class="form-control">
							<option><?=isset($provider['civilite']) ? $provider['civilite'] : '';?></option>
							<option value="Monsieur">Mr</option>
							<option value="Madame">Mme</option>
							<option value="Mademoiselle">Melle</option>
						</select>
					</div>
				</div>

				<!-- firstname-->
				<div class="form-group">
					<label class="col-md-4 control-label" for="firstname">Prénom:
						<span class="obligatoire">*</span>
					</label>
					<div class="col-md-4">
						<input id="firstname" name="firstname" type="text" value="<?=isset($provider['firstname']) ? $provider['firstname'] : '';?>" class="form-control input-md">
					</div>
						<!-- Gestion des erreurs -->
					<?php if(isset($formErrors['firstname'])): ?>
	        			<div class="error col-md-offset-4 col-md-8"><?=$formErrors['firstname']?>
	        			</div>
	        		<?php endif; ?>
				</div>

				<!-- lastname-->
				<div class="form-group">
					<label class="col-md-4 control-label" for="lastname">Nom :
						<span class="obligatoire">*</span>
					</label>
					<div class="col-md-4">
						<input id="lastname" name="lastname" type="text" value="<?=isset($provider['lastname']) ? $provider['lastname'] : '';?>" class="form-control input-md">
					</div>
						<!-- Gestion des erreurs -->
					<?php if(isset($formErrors['lastname'])): ?>
	        			<div class="error col-md-offset-4 col-md-8"><?=$formErrors['lastname']?>
	        			</div>
	        		<?php endif; ?>
				</div>

				<!-- email-->
				<div class="form-group">
					<label class="col-md-4 control-label" for="email">Email:
						<span class="obligatoire">*</span>
					</label>
					<div class="col-md-4">
						<input id="email" name="email" type="text" value="<?=isset($provider['email']) ? $provider['email'] : '';?>" class="form-control input-md">
					</div>
						<!-- Gestion des erreurs -->
					<?php if(isset($formErrors['email'])): ?>
	        			<div class="error col-md-offset-4 col-md-8"><?=$formErrors['email']?>
	        			</div>
	        		<?php endif; ?>	
				</div>
				<!-- password-->
				<div class="form-group">
					<label class="col-md-4 control-label" for="password">Mot de passe:
					</label>
					<div class="col-md-4">
						<input id="password" name="password" type="password" placeholder="" class="form-control input-md">
					</div>
						<!-- gestion des erreurs -->
					<?php if(isset($formErrors['password'])): ?>
						<div class="error col-md-offset-4 col-md-8"><?=$formErrors['password']?>		
						</div>
					<?php endif; ?>
				</div>

				<!-- fixed_phone-->
				<div class="form-group">
					<label class="col-md-4 control-label" for="fixed_phone">Téléphone fixe:
						<span class="obligatoire">*</span>
					</label>
					<div class="col-md-4">
						<input id="fixed_phone" name="fixed_phone" type="text" value="<?=isset($provider['fixed_phone']) ? $provider['fixed_phone'] : '';?>" class="form-control input-md">
					</div>
						<!-- gestion des erreurs -->
					<?php if(isset($formErrors['fixed_phone'])): ?>
	        			<div class="error col-md-offset-4 col-md-8"><?=$formErrors['fixed_phone']?>
	        			</div>
	        		<?php endif; ?>
				</div>

				<!-- mobile_phone-->
				<div class="form-group">
					<label class="col-md-4 control-label" for="mobile_phone">Téléphone mobile:
						<span class="obligatoire">*</span>
					</label>
					<div class="col-md-4">
						<input id="mobile_phone" name="mobile_phone" type="text" value="<?=isset($provider['mobile_phone']) ? $provider['mobile_phone'] : '';?>" class="form-control input-md">
					</div>
						<!-- gestion des erreurs -->
					<?php if(isset($formErrors['mobile_phone'])): ?>
	        			<div class="error col-md-offset-4 col-md-8"><?=$formErrors['mobile_phone']?>
	        			</div>
	        		<?php endif; ?>
				</div>

				<!-- adresse-->
				<div class="form-group">
					<label class="col-md-4 control-label" for="street">Adresse:
						<span class="obligatoire">*</span>
					</label>
					<div class="col-md-4">
						<input id="street" name="street" type="text" value="<?=isset($provider['street']) ? $provider['street'] : '';?>" class="form-control input-md">
					</div>
						<!-- gestion des erreurs -->
					<?php if(isset($formErrors['street'])): ?>
	        			<div class="error col-md-offset-4 col-md-8"><?=$formErrors['street']?>
	        			</div>
	        		<?php endif; ?>
				</div>

				<!-- zipcode-->
				<div class="form-group">
					<label class="col-md-4 control-label" for="zipcode">Code postal:
						<span class="obligatoire">*</span>
					</label>
					<div class="col-md-2">
						<input id="zipcode" name="zipcode" type="text" value="<?=isset($provider['zipcode']) ? $provider['zipcode'] : '';?>" class="form-control input-md">
					</div>
						<!-- gestion des erreurs -->
					<?php if(isset($formErrors['zipcode'])): ?>
	        			<div class="error col-md-offset-4 col-md-8"><?=$formErrors['zipcode']?>
	        			</div>
	        		<?php endif; ?>	
				</div>

				<!-- city-->
				<div class="form-group">
					<label class="col-md-4 control-label" for="city">Ville:
						<span class="obligatoire">*</span>
					</label>
					<div class="col-md-4">
						<input id="city" name="city" type="text" value="<?=isset($provider['city']) ? $provider['city'] : '';?>" class="form-control input-md">
					</div>
						<!-- gestion des erreurs -->	
					<?php if(isset($formErrors['city'])): ?>
	        			<div class="error col-md-offset-4 col-md-8"><?=$formErrors['city']?></div>
	        		<?php endif; ?>	
				</div>

				<!-- validation inscription -->
				<div class="form-group">
					<label class="col-md-4 control-label" for="edit"></label>
					<div class="col-md-4">
						<button id="edit" name="edit" class="btn btn-info">Modifier le profil</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>

<?php $this->stop('main_content') ?>
