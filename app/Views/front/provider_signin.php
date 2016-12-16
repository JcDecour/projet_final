<?php $this->layout('layout', ['title' => 'Inscription Professionnel']) ?>
<?php $this->start('main_content') ?>
<div class="content-site">
	<div class="forms">
		
		<div class="page-header">
			<h1 style="text-align: center;">Inscription Professionnel</h1>
		</div>
	
		<form method="post" class="form-horizontal">
			<p class="text-required-filed">
				<span class="obligatoire">*</span>
				Champs obligatoires
			</p>
			<fieldset>
			<!-- affichage erreurs générale -->
			<?php if(isset($formErrors['global'])): ?>
	      		<div class="alert alert-danger">
	        		<?=$formErrors['global'];?>
	      		</div>
	      	<?php endif; ?>

				<!-- raison sociale-->
				<div class="form-group">
					<label class="col-md-4 control-label" for="company_name">Raison sociale:
						<span class="obligatoire">*</span>
					</label>
					<div class="col-md-4">
						<input id="company_name" name="company_name" type="text" placeholder="EURL Ptit travaux" class="form-control input-md">
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
						<textarea class="form-control" id="company_description" name="company_description" placeholder="Un petit mot sur l'entreprise"></textarea>
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
						<input id="siret" name="siret" type="text" placeholder="01234567891122" class="form-control input-md">
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
						<select id="civilite" name="civilite" class="form-control" required="">
							<option value="" selected disabled>-- Sélection --</option>
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
						<input id="firstname" name="firstname" type="text" placeholder="jean" class="form-control input-md">
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
						<input id="lastname" name="lastname" type="text" placeholder="Durandet" class="form-control input-md">
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
						<input id="email" name="email" type="text" placeholder="jean.durandet@gmail.com" class="form-control input-md">
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
						<span class="obligatoire">*</span>
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
						<input id="fixed_phone" name="fixed_phone" type="text" placeholder="0123456789" class="form-control input-md">
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
						<input id="mobile_phone" name="mobile_phone" type="text" placeholder="0612345678" class="form-control input-md">
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
						<input id="street" name="street" type="text" placeholder="Rue de la paix" class="form-control input-md">
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
						<input id="zipcode" name="zipcode" type="text" placeholder="75000" class="form-control input-md">
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
						<input id="city" name="city" type="text" placeholder="Paris" class="form-control input-md">
					</div>
						<!-- gestion des erreurs -->	
					<?php if(isset($formErrors['city'])): ?>
	        			<div class="error col-md-offset-4 col-md-8"><?=$formErrors['city']?></div>
	        		<?php endif; ?>	
				</div>

				<!-- validation inscription -->
				<div class="form-group">
					<label class="col-md-4 control-label" for="signin"></label>
					<div class="col-md-4">
						<button id="signin" name="signin" class="btn btn-info">Inscription</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<?php $this->stop('main_content') ?>