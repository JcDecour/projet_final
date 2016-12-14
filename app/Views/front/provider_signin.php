<?php $this->layout('layout', ['title' => 'Inscription Particulier']) ?>
<?php $this->start('main_content') ?>
<div class="page-header">
	<h1>Inscription Professionnel</h1>
</div>

<?php var_dump($formErrors); ?>
<?php var_dump($stock); ?>
<div class="container">
	<form method="post" class="form-horizontal">
		<fieldset>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="company_name">Raison sociale:</label>
				<div class="col-md-4">
					<input id="company_name" name="company_name" type="text" placeholder="EURL Ptit travaux" class="form-control input-md">
					
				</div>
			</div>
			<!-- Textarea -->
			<div class="form-group">
				<label class="col-md-4 control-label" for="company_description">Description de l'entreprise</label>
				<div class="col-md-4">
					<textarea class="form-control" id="company_description" name="company_description" placeholder="Un petit mot sur l'entreprise"></textarea>
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="siret">Siret:</label>
				<div class="col-md-4">
					<input id="siret" name="siret" type="text" placeholder="01234567891122" class="form-control input-md">
					
				</div>
			</div>
			<!-- Select Basic -->
			<div class="form-group">
				<label class="col-md-4 control-label" for="civilité">Civilité :</label>
				<div class="col-md-2">
					<select id="civilité" name="civilité" class="form-control" required="">
						<option value="" selected disabled>-- Sélection --</option>
						<option value="Monsieur">Mr</option>
						<option value="Madame">Mme</option>
						<option value="Mademoiselle">Melle</option>
					</select>
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="firstname">Prénom:</label>
				<div class="col-md-4">
					<input id="firstname" name="firstname" type="text" placeholder="jean" class="form-control input-md">
					
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="lastname">Nom :</label>
				<div class="col-md-4">
					<input id="lastname" name="lastname" type="text" placeholder="Durandet" class="form-control input-md">
					
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="email">Email:</label>
				<div class="col-md-4">
					<input id="email" name="email" type="text" placeholder="jean.durandet@gmail.com" class="form-control input-md">
					
				</div>
			</div>
			<!-- Password input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="password">Mot de passe:</label>
				<div class="col-md-4">
					<input id="password" name="password" type="password" placeholder="" class="form-control input-md">
					
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="fixed_phone">Téléphone fixe:</label>
				<div class="col-md-4">
					<input id="fixed_phone" name="fixed_phone" type="text" placeholder="0123456789" class="form-control input-md">
					
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="mobile_phone">Téléphone mobile:</label>
				<div class="col-md-4">
					<input id="mobile_phone" name="mobile_phone" type="text" placeholder="0612345678" class="form-control input-md">
					
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="street">Adresse:</label>
				<div class="col-md-4">
					<input id="street" name="street" type="text" placeholder="Rue de la paix" class="form-control input-md">
					
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="zipcode">Code postal:</label>
				<div class="col-md-2">
					<input id="zipcode" name="zipcode" type="text" placeholder="75000" class="form-control input-md">
					
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="city">Ville:</label>
				<div class="col-md-4">
					<input id="city" name="city" type="text" placeholder="Paris" class="form-control input-md">
					
				</div>
			</div>
			<!-- Button -->
			<div class="form-group">
				<label class="col-md-4 control-label" for="signin"></label>
				<div class="col-md-4">
					<button id="signin" name="signin" class="btn btn-info">Inscription</button>
				</div>
			</div>
		</fieldset>
	</form>
</div
<?php $this->stop('main_content') ?>