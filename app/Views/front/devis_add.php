<?php $this->layout('layout', ['title' => 'Ajout d\'un devis']) ?>

<?php $this->start('main_content') ?>

<div class="content-site">
	<div class="page-header">
		<h1>Consultation d'une offre</h1>
	</div>
	
	<?php if(isset($formErrors['global'])): ?>
		<div class="alert alert-danger">
			<?=$formErrors['global'];?>
		</div>
	<?php endif; ?>

    <!-- N° de l'offre -->
	<div class="row">
		<label class="col-md-3 control-label text-right">N° Offre:</label>  
		<div class="col-md-9"><?=sprintf("%06d", $projectSubsector['id'])?>&nbsp;( Ajoutée le <?=DateTime::createFromFormat('Y-m-d H:i:s', $projectSubsector['created_at'])->format('d/m/Y');?> )</div>
	</div>
    
	<!-- Code postal du lieu du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right">Code postal du lieu du service:</label>  
		<div class="col-md-9"><?=$projectSubsector['zip_code'];?></div>
	</div>

	<!-- Objet du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right">Objet du service:</label>  
		<div class="col-md-9"><?=$projectSubsector['title'];?></div>
	</div>

	<br>

        <!-- Catégorie / Ss Catégorie du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right">Catégorie / Sous Catégorie:</label>
		<div class="col-md-9"><span class="tag label label-categories"><?=$projectSubsector['titlesector'];?> - <?=$projectSubsector['titlesubsector'];?></span></div> 
	</div>
    
    <br>
    
	<!-- Description du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right">Description:</label>  
		<div class="col-md-7 withbackground"><?=nl2br($projectSubsector['description']);?></div>
	</div>

	<br>

	<!-- Date prévisionnelle du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right">Date prévisionnelle:</label>  
		<div class="col-md-9"><?=DateTime::createFromFormat('Y-m-d', $projectSubsector['predicted_date'])->format('d/m/Y');?></div>
	</div>

	<!-- Bouton de proposition de devis et retour liste des devis-->
	<div class="row ">
		<div class="col-md-12 text-right">
			<a href="<?=$this->url('front_devis_list');?>" class="btn btn-default" title="Retour liste des devis">Retour liste</a>
		</div>
	</div>	

	<!-- ########### -->
	<!-- PARTIE DEVIS-->
	<!-- ########### -->

		<br>
		<div class="page-header">
			<h1>Proposition de devis</h1>
		</div>

		<br>
		<form method="post" class="forms">
			<div class="panel panel-default">
			  <!-- Default panel contents -->
			  <div class="panel-heading">Devis</div>
				<div class="panel-body">

					<div class="row">
						<label class="col-md-12 control-label" for="description">Informations complémentaires</label>
						<div class="col-md-12">
							<textarea id="description" name="description" class="form-control input-md" placeholder="Toute précision, détail ou autre permettant de décrire au mieux votre offre de devis..."><?=isset($post['description']) ? $post['description'] : '';?></textarea>
						</div>
						<!-- Gestion des erreurs -->
						<?php if(isset($formErrors['description'])): ?>
							<div class="error col-md-12"><?=$formErrors['description']?></div>
						<?php endif; ?>
					</div>
				</div>

				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Désignation<span class="obligatoire">*</span></th>
							<th class="text-right">Montant HT(€)<span class="obligatoire">*</span></th>
							<th class="text-right">Taux de TVA(%)</th>
							<th class="text-right">Montant TTC(€)</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>
								<input id="designation" name="designation" class="form-control input-md" type="text" placeholder="Libellé" value="<?=isset($post['designation']) ? $post['designation'] : '';?>">
								<!-- Gestion des erreurs -->
								<?php if(isset($formErrors['designation'])): ?>
									<div class="error col-md-12"><?=$formErrors['designation']?></div>
								<?php endif; ?>
							</td>
							<td>
								<input id="ht_amount" name="ht_amount" class="form-control input-md text-right-basic-table" type="text" placeholder="0.00" value="<?=isset($post['ht_amount']) ? $post['ht_amount'] : '';?>">
								<!-- Gestion des erreurs -->
								<?php if(isset($formErrors['ht_amount'])): ?>
									<div class="error col-md-12"><?=$formErrors['ht_amount']?></div>
								<?php endif; ?>
							</td>
							<td>
								<select id="tva_amount" name="tva_amount" class="form-control text-right-basic-table">
									<option value="2.1" <?=(isset($post['tva_amount']) && ($post['tva_amount'] == '2.1')) ? 'selected' : '';?>>2.1</option>
									<option value="5.5" <?=(isset($post['tva_amount']) && ($post['tva_amount'] == '5.5')) ? 'selected' : '';?>>5.5</option>
									<option value="10" <?=(isset($post['tva_amount']) && ($post['tva_amount'] == '10')) ? 'selected' : '';?>>10</option>
									<option value="20" <?=(isset($post['tva_amount']) && ($post['tva_amount'] == '20')) ? 'selected' : '';?>>20</option>
								</select>
							</td>
							<td>
								<?php if(isset($post['ht_amount']) && isset($post['tva_amount'])): ?>
									<span id="ttc_amount" name="ttc_amount" class="col-md-12 text-right-basic-table"><?=number_format($post['ht_amount'] * (1  + ($post['tva_amount'] / 100)), 2 , "." , " ");?></span>
								<?php else: ?>
									<span id="ttc_amount" name="ttc_amount" class="col-md-12 text-right-basic-table">0.00</span>
								<?php endif; ?>
							</td>
						</tr>
					</tbody>
				</table>

			</div>

			<p class="text-required-filed">
				<span class="obligatoire">*</span>
				Champs obligatoires
			</p>
			
			<!-- Bouton de validation -->
			<div class="row">
				<div class="form-group">
					<div class="col-md-2 col-md-offset-10">
						<button type="submit" class="btn btn-success btn-block">Valider</button>
					</div>
				</div>
			</div> 

		</form>

	

</div>

<?php $this->stop('main_content') ?>

<?php $this->start('js') ?>
<script>

	

	$(document).ready(function(){



		$('#test').click(function(){
			

			if($("#update_footer").hasClass("fixed")){
				
				$("#update_footer").removeClass("fixed");


			}
			else
			{
				$("#update_footer").addClass("fixed");
			}
       
		});

		/*Gestion du changement de taux de TVA*/
		$('#tva_amount').change(function(){
			calculTtcAmount();
		});

		/*Gestion du changement de montant HT*/
		$('#ht_amount').change(function(){
			calculTtcAmount();
		});

	});

//Fonction permettant de calculer le montant TTC du devis
function calculTtcAmount()
{
	var tva_amount = parseFloat($('#tva_amount').find(":selected").attr('value'));
	var ht_amount = parseFloat($('#ht_amount').val());

	var ttc_amount = ht_amount * (1 + (tva_amount/100));
	ttc_amount = Math.round(ttc_amount*100)/100;
	ttc_amount = ttc_amount.toFixed(2)

	$('#ttc_amount').text(ttc_amount);
}	

 var fot = function() {
        var e = $(window).height(),
            t = 0;
        $("body").children().each(function() {
            t += $(this).outerHeight(!0)
        }), e > t ? $("#update_footer").addClass("fixed") : $("#update_footer").removeClass("fixed")
    };


</script>
<?php $this->stop('js') ?>