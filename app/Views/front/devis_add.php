<?php $this->layout('layout', ['title' => 'Ajout d\'un devis']) ?>

<?php $this->start('main_content') ?>

	<div class="page-header">
		<h1>Proposition de devis</h1>
	</div>

	<!-- Code postal du lieu du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Code postal du lieu du service:</label>  
		<div class="col-md-9"><?=$projectSubsector['zip_code'];?></div>
	</div>

	<!-- Objet du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Objet du service:</label>  
		<div class="col-md-9"><?=$projectSubsector['title'];?></div>
	</div>

	<br>

	<!-- Description du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Description:</label>  
		<div class="col-md-9"><?=nl2br($projectSubsector['description']);?></div>
	</div>

	<br>

	<!-- Date prévisionnelle du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Date prévisonnelle:</label>  
		<div class="col-md-9"><?=DateTime::createFromFormat('Y-m-d', $projectSubsector['predicted_date'])->format('d/m/Y');?></div>
	</div>

	<br>

	<!-- Catégorie / Ss Catégorie du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Catégorie / Sous Catégorie:</label>
		<div class="col-md-9"><span class="tag label label-default"><?=$projectSubsector['titlesector'];?> - <?=$projectSubsector['titlesubsector'];?></span></div> 
	</div>

	<!-- ########### -->
	<!-- PARTIE DEVIS-->
	<!-- ########### -->

	<br>
		<form method="post">
	<div class="panel panel-default">
	  <!-- Default panel contents -->
	  <div class="panel-heading">Devis</div>
		<div class="panel-body">
			<div class="row">
				<label class="col-md-12 control-label" for="zip_code">Descriptif</label>
				<div class="col-md-12">
					<textarea class="form-control input-md" placeholder="(Détails, précsions, autres ...)"></textarea>
				</div>
			</div>
		</div>

		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Désignation</th>
					<th>Montant HT (€)</th>
					<th>TVA</th>
					<th>Montant TTC (€)</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td>
						<input class="form-control input-md" type="text">
					</td>
					<td>
						<input class="form-control input-md text-right" type="text">
					</td>
					<td>
						<select class="form-control">
							<option value="5.5">5.5</option>
							<option value="10">10</option>
							<option value="18">18</option>
						</select>
					</td>
					<td>
						<span class="col-md-12 text-right">0.00</span>	
					</td>
				</tr>
			</tbody>
		</table>

	</div>
	
	<!-- Bouton de validation -->
			<div class="form-group">
				<div class="col-md-3 col-md-offset-9">
					<button type="submit" class="btn btn-success btn-block">Valider</a>
				</div>
			</div>

		</form>

<?php $this->stop('main_content') ?>
