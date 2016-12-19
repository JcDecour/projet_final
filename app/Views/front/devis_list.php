<?php $this->layout('layout', ['title' => 'Mes devis']); ?>


<?php $this->start('main_content') ?>

<div class="content-site">	
	<div class="page-header">
		<h1>Liste des offres de services disponibles</h1>
	</div>
    
    <!-- Formulaire de recherche -->
	<div class="well well-sm">
		<form method="get" class="form-inline">
			<!-- Code postal -->
			<div class="form-group">
				<label class="sr-only" for="zip_code">Code postal</label>
				<input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="CP" value="<?=isset($search['zip_code']) ? $search['zip_code'] : '';?>">
			</div>

			<!-- Service (Recherche dans le sujet ou la description) -->
			<div class="form-group">
				<label class="sr-only" for="title">Un type de contenu de service</label>
				<input type="text" class="form-control" id="title" name="title" placeholder="Libellé service" value="<?=isset($search['title']) ? $search['title'] : '';?>">
			</div>

			<!-- Catégorie -->
			<select id="sector" name="sector" class="form-control">
				<option value="" selected>Catégorie</option>
				<?php foreach($sectors as $sector) :; ?>
					<option value="<?=$sector['id'];?>" <?=(isset($search['sector']) && $search['sector'] == $sector['id']) ? 'selected' : '';?>><?=$sector['title'];?></option>
				<?php endforeach; ?>
			</select>

			<!-- Sous-Catégorie -->
			<select id="sub-sector" name="sub-sector" class="form-control">
				<?php if(!empty($optionSubSector)):?>
					<?=$optionSubSector;?>
				<?php else: ?>
					<option value="" selected>Sous-Catégorie</option>
				<?php endif; ?>
			</select>
				
			<button class="btn btn-default" type="submit">
				Rechercher
			</button>
				
			
		</form>
	</div>
    
	<!-- Liste des projets -->
    <table class="table table-responsive table-bordered">
        <thead>
            <tr>
                <th>
                    N° Offre
                    &nbsp;
                    <i class="fa fa-fw fa-sort-amount-desc"></i>
                </th>
                <th>Lieu</th>
                <th>Service</th>
                <th>Catégorie</th>
                <th>Ss Catégorie</th>
                <th>Ajoutée le</th>
                <th>Prévue le</th>
                <th class="text-center">Devis</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php if(!empty($projects)): ?>	

                <?php $cpt = 0; ?>
                <?php foreach($projects as $project): ?>

                    <?php if(empty($project['designation'])): ?> <!-- Si le champ désignation est renseigné c'est que le provider a fait une estimation sur cette sous catégorie de projet, il ne faut donc pas l'ajouter-->
                        <?php $cpt++; ?>
                        <tr>
                            <td><?=sprintf("%06d", $project['id'])?></td>
                            <td><?=$project['zip_code'];?></td>
                            <td><?=$project['title'];?></td>
                            <td><?=$project['titlesector'];?></td>
                            <td><?=$project['titlesubsector'];?></td>
                            <td><?=DateTime::createFromFormat('Y-m-d H:i:s', $project['created_at'])->format('d/m/Y');?></td>
                            <td><?=DateTime::createFromFormat('Y-m-d', $project['predicted_date'])->format('d/m/Y');?></td>
                            <td class="text-center">
                                <?php if($project['closed']): ?>
                                    <span class="text-danger">Cloturé</span>
                                <?php else: ?>
                                    <span class="badge badge-success"><?=$project['nbdevisprojetsubsector'];?></span>
                                <?php endif; ?>	
                            </td>
                            <td class="text-center">
                                <a href="<?=$this->url('front_devis_add', ['id' => $project['idprojetsubsector']]);?>" class="btn btn-default btn-sm" title="Proposer un devis">
                                    Proposer devis
                                </a>
                            </td>
                        </tr>

                    <?php endif; ?>

                <?php endforeach; ?>

                <?php if($cpt == 0): ?>
                    <tr><td colspan="8">Aucune offre de services n'est disponible.</td></tr>
                <?php endif; ?>

            <?php else: ?>
                <tr><td colspan="8">Aucune offre de services n'est disponible.</td></tr>
            <?php endif; ?>

        </tbody>
    </table>

	<!-- ######################################################## -->

	<div class="page-header">
		<h1>Mes devis proposés</h1>
	</div>

	<!-- Liste des projets -->
	<?php if(!empty($listdevis)): ?>	

		<table class="table table-responsive table-bordered">

			<thead>
				<tr>
					<th>
                        N° Devis
                        &nbsp;
                        <i class="fa fa-fw fa-sort-amount-desc"></i>
                    </th>
                    <th>N° Offre</th>
					<th>Lieu</th>
					<th>Service</th>
					<th>Catégorie</th>
					<th>Ss Catégorie</th>
					<th>Mont. TTC (€)</th>
					<th class="text-center">Etat</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($listdevis as $devis): ?>
				<tr>
					<td><?=sprintf("%06d", $devis['id'])?></td>
                    <td><?=sprintf("%06d", $devis['projectId'])?></td>
					<td><?=$devis['projectZipCode'] ?></td>
					<td><?=$devis['projectTitle'] ?></td>
					<td><?=$devis['titleSector'];?></td>
					<td><?=$devis['titleSubsector'];?></td>
					<?php 
						$montantTTC = number_format($devis['ht_amount'] * (1 +($devis['tva_amount']/100)), 2, "." , " ");
					?>
                    <td class="text-right"><span id="ttc_amount"><?=$montantTTC;?></span></td>
					<td class="text-center">
						<?php if($devis['accepted']): ?>
                            <span class="devis_status accepted">Accepté</span>
						<?php elseif($devis['projectClosed']): ?>
							<span class="devis_status not_accepted">Non retenu</span>
						<?php else: ?>
							<span class="devis_status pending">Non statué</span>
						<?php endif; ?>
					</td>
					<td class="text-center">
						<a href="<?=$this->url('front_devis_view', ['id' => $devis['id']]);?>" class="btn btn-default btn-sm" title="Consulter mon devis">
					 		Consulter
						</a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>

		</table>

	<?php else: ?>
		<p>Aucun devis proposé.</p>
	<?php endif; ?>

</div>

<?php $this->stop('main_content') ?>

<?php $this->start('js') ?>
<script>
	$(document).ready(function(){

		/*Gestion des menu déroulants liés (Carégories -> Sous Catégories)*/
		$('#sector').change(function(){
			$.ajax({
				url: '<?=$this->url('ajax_refreshSubSector'); ?>',
				type: 'get',
				cache: false,
				data: {idsector: $('#sector').find(":selected").attr('value') }, 
				dataType: 'json', 
				success: function(result) {
					console.log(result);
					$('#sub-sector').html(result.option);
				}
			});
		});

	});
</script>
<?php $this->stop('js') ?>
