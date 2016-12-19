<?php $this->layout('layout', ['title' => 'Liste des devis pour le service']); ?>

<?php $this->start('my_header') ?>

<?php $this->stop('my_header') ?>

<?php $this->start('main_content') ?>

<div class="content-site">
	<div class="row">
		<div class="page-header">
			<h1>Liste des devis pour le service</h1>
		</div>
	</div>
	
	 <!--Partie entete du service (Récapitulatif)-->
        <!-- Code postal du lieu du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Code postal du lieu du service:</label>  
		<div class="col-md-9"><?=$project['zip_code'];?></div>
	</div>

	   <!-- Objet du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Objet du service:</label>  
		<div class="col-md-9"><?=$project['title'];?></div>
	</div>

	<br>

	   <!-- Description du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Description:</label>  
		<div class="col-md-9"><?=nl2br($project['description']);?></div>
	</div>
    
    <br>
    
        <!-- Date de création du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Date de création:</label>  
		<div class="col-md-9"><?=DateTime::createFromFormat('Y-m-d H:i:s', $project['created_at'])->format('d/m/Y');?></div>
	</div>
    
    <br>

     <!-- Date prévisionnelle du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Date prévisonnelle:</label>  
		<div class="col-md-9">
			<?=DateTime::createFromFormat('Y-m-d', $project['predicted_date'])->format('d/m/Y');?>		
		</div>
	</div>

	<br>
    
<?php $cpt = 0;?>



<?php if(!$project['closed']): ?>
<form method="POST">

	<?php foreach($sectors as $sector): ?>

	<!-- Partie devis-->
	<div class="row">
	    <div class="panel panel-default">
			  <!-- Default panel contents -->
				<div class="panel-heading">
				  	
				  		<?=$sector['sectorTitle'];?> - <?=$sector['subSectorTitle'];?>		  		
				  	
				</div>

				<div class="panel-body">

					<div class="row">
						<label class="col-md-12 control-label" for="description">Informations complémentaires:</label>
						<div class="col-md-12">
							Choisissez un seul devis par sous catégorie
	                    </div>
					</div>
				</div>
			  
			  	<table class="table table-bordered table-responsive ">
				    <thead>
				    	<th>Votre choix</th>
				    	<th>Devis</th>
				    	<th>Date de création</th>
				    	<th>Société</th>
				    	<th>Prix HT (€)</th>
				    	<th>TVA (%)</th>
				    	<th>Prix TTC (€)</th>
				    </thead>
				 
					<tbody>

					  	<?php foreach($datasDevis as $dataDevis): ?>
						
						  		<?php if($sector['projectSubSectorId'] == $dataDevis['projectSubsectorId']):?>

								  	<tr>
								  		<td>
								  			<input id="<?= $dataDevis['devisId'] ?>" type="checkbox" name="" value="<?= $dataDevis['ttc_amount'] ?>">
								  		</td>
								  		<td><?=$dataDevis['devisId'] ?></td>
								  		<td><?=DateTime::createFromFormat('Y-m-d H:i:s', $dataDevis['devisDateCreat'])->format('d/m/Y');?></td>
								  		<td><?=$dataDevis['companyName'] ?></td>
								  		<td class="text-right"><?=number_format($dataDevis['ht_amount'], 2, ',', ' ') ?></td>
								  		<td class="text-right"><?=$dataDevis['tva_amount'] ?></td>
								  		<td class="text-right"><?=number_format($dataDevis['ttc_amount'], 2, ',', ' ') ?></td>
								  	</tr>

									<?php $cpt++;?>

						 		<?php endif; ?>					  	
					  	 
					  	<?php endforeach; ?>
					 
					</tbody>

					<?php if($cpt == 0):?>
						<tbody>
							<tr>
								<td colspan="7" class="text-danger">Aucun devis enregistré</td>
							</tr>
						</tbody>
					<?php endif;?>

					<?php $cpt=0;?>
			   	</table>
		</div>
	</div>
	<?php endforeach; ?>

	<div class="row" >
		<div class="col-md-8"></div>
		<div class="col-md-2 ">
			<strong>Total TTC :</strong>
		</div>
		<div class="col-md-2 text-right "><span id="totalResult">0.00 €</span></div>
	</div>
	
	<div class="row">
		<div class="col-md-4 col-md-offset-8">
			<button type="submit" class="btn btn-success btn-block">Accepter</button>
		</div>
	</div>
	<div id="inputHidden"></div>
</form>

<?php endif; ?>

	</div>
</div>

<?php $this->stop('main_content') ?>

<?php $this->start('js') ?>

<script type="text/javascript">

$(document).ready(function() {

		$('input[type=checkbox]').click(function(){

			var total= 0;

			$('#inputHidden').empty();

			$('input[type=checkbox]:checked').each(function() {

				total += parseFloat($(this).val());

				var idCheckbox = $(this).attr("id");



				$('#inputHidden').append('<input type="hidden" name="acceptedDevis'+idCheckbox+'" value='+idCheckbox+'>');


			});
	
		 	$('#totalResult').html(new Intl.NumberFormat("fr-FR",   {style: "currency", currency: "EUR"}).format(total));

		});



});

</script>

<?php $this->stop('js') ?>
