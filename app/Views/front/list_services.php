<?php $this->layout('layout', ['title' => 'Liste des services']); ?>

<?php $this->start('main_content') ?>

<div class="content-site">
	
	<div class="page-header">
		<h1>Liste des services</h1>
	</div>


	<div class="well well-sm">
		<form id="my_form" method="get" class="form-inline">
			
				<!-- Service (Recherche selon le statut) -->
			<div class="form-group">
				<label class="radio-inline">
					<input type="radio" name="statut" id="all" value="all" checked=""> Tous les services
				</label>
				<label class="radio-inline">
					<input type="radio" name="statut" id="opened" value="opened" <?=(isset($get['statut']) && $get['statut'] == 'opened') ? 'checked' : '';?>> Services ouverts
				</label>
				<label class="radio-inline">
					<input type="radio" name="statut" id="closed" value="closed" <?=(isset($get['statut']) && $get['statut'] == 'closed') ? 'checked' : '';?>> Services cloturés
				</label>					
			</div>

		</form>
	</div>
	
		
	<?php if(isset($errorConsult) && $errorConsult): ?>
		<div class="row">
			<div class="col-md-12 text-right">
				<a href="<?=$this->url('front_customer_profil');?>" title="Compléter votre profil">Veuillez compléter votre profil pour consulter les devis</a>
			</div>
		</div>
		<br>
	<?php endif; ?>

	<?php if(!empty($projects)): ?>	
	<table class="table table-bordered table-responsive table-striped">

		<thead>
			<tr>
				<th>N° Offre
					&nbsp;
                    <i class="fa fa-fw fa-sort-amount-desc"></i>
                </th>
				<th>Service</th>
				<th>Ajoutée le</th>
				<th>Prévue le</th>
                <th class="text-center">Statut</th>
				<th class="text-center">Devis</th>
				<th class="text-center">Action</th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($projects as $project): ?>
			<tr>
				<td><?=sprintf("%06d", $project['id'])?></td>
				<td><?=$project['title'] ?></td>
				<td><?=DateTime::createFromFormat('Y-m-d H:i:s', $project['created_at'])->format('d/m/Y');?></td>
				<td><?=DateTime::createFromFormat('Y-m-d', $project['predicted_date'])->format('d/m/Y');?></td>
				<td class="text-center-basic-table">
					<?php if($project['closed']): ?>
						<span class="text-danger">Cloturé</span>
					<?php else: ?>
						<span class="text-success">Ouvert</span>
					<?php endif; ?>	
				</td>
                <td class="text-center-basic-table"><span class="badge badge-success"><?=$project['nb_devis'];?></span></td>

				<td class="text-center-basic-table">

    <!-- Beginning large screen -->
					<span id="action_list_services_largeScreen">
	                    <?php if(!$project['closed']): ?>
	                        <div class="col-md-3">
	                            <a href="<?=$this->url('front_view_service', ['id' => $project['id']]);?>" class="btn btn-success btn-sm btn_margin" title="Consulter ce service">
	                             Consulter
	                            </a>
	                        </div>
	                        &nbsp;
	                    <?php if($project['nb_devis'] == 0):?>
	                    	&nbsp;
	                        <div class="col-md-3">
	                            <a href="<?=$this->url('front_edit_service', ['idProject' => $project['id']]);?>" class="btn btn-info btn-sm btn_margin" title="Modifier ce service">
	                             Modifier
	                            </a>
	                        </div>
	                        <div class="col-md-3">
	                            <a href="<?=$this->url('front_delete_service', ['id' => $project['id']]);?>" class="btn btn-danger btn-sm btn_margin" title="Supprimer ce service">
	                             Supprimer
	                            </a>
	                        </div>
	                    <?php endif; ?>
	                   
	                    <?php else: ?>
	                        <div class="col-md-3">
	                            <a href="<?=$this->url('front_service_view_closed', ['id' => $project['id']]);?>" class="btn btn-success btn-sm btn_margin" title="Consulter ce service">
	                             Consulter
	                            </a>
	                        </div>
	                        <div class="col-md-3">
	                            &nbsp;
	                        </div>
	                        <div class="col-md-3">
	                            &nbsp;
	                        </div>
	                    <?php endif; ?>
	                </span>
		<!-- End large screen -->
		<!-- Beginning small screen -->
					<span id="action_list_services_smallScreen" class="text-center-basic-table">
	                    <?php if(!$project['closed']): ?>
	                        <div class="deletePaddingLeft" class="col-md-3">
	                            <a href="<?=$this->url('front_view_service', ['id' => $project['id']]);?>" title="Consulter ce service">
	                             <i class="fa fa-eye fa-lg text-success" aria-hidden="true"></i>

	                            </a>
	                       
	                        
	                    <?php if($project['nb_devis'] == 0):?>
	                        
	                            <a href="<?=$this->url('front_edit_service', ['idProject' => $project['id']]);?>" title="Modifier ce service">
	                             <i class="fa fa-pencil-square-o fa-lg text-info" aria-hidden="true"></i>

	                            </a>
	                        
	                       
	                       
	                            <a href="<?=$this->url('front_delete_service', ['id' => $project['id']]);?>" title="Supprimer ce service">
	                             <i class="fa fa-times fa-lg text-danger"></i>
	                            </a>
	                        </div>
	                    <?php endif; ?>
	                   
	                    <?php else: ?>
	                        <div class="deletePaddingLeft" class="col-md-3">
	                            <a href="<?=$this->url('front_service_view_closed', ['id' => $project['id']]);?>" title="Consulter ce service">
	                             <i class="fa fa-eye fa-lg text-success" aria-hidden="true"></i>

	                            </a>
	                        </div>
	                    <?php endif; ?>
					</span>

		<!-- End small screen -->
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>

	</table>

<?php else: ?>
	<p class="text-danger"><?=$msg ?></p>
<?php endif; ?>


	<div class="text-right">
		<a href="<?=$this->url('front_service_add');?>" class="btn btn-devirama" title="Ajouter un nouveau service">Nouveau service</a>
	</div>

</div>

<?php $this->stop('main_content') ?>

<?php $this->start('js') ?>

<script type="text/javascript">

$(document).ready(function() {
	
// on valide le formulaire en cochant un bouton radio

		$('input[type="radio"]').click(function() {
		

			$('#my_form').submit();

		});

});	

</script>

<?php $this->stop('js') ?>