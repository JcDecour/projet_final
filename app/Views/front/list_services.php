<?php $this->layout('layout', ['title' => 'Liste des services']); ?>

<?php $this->start('main_content') ?>

<div class="content-site">
	
	<div class="page-header">
		<h1>Liste des services</h1>
	</div>


	<div class="well well-sm">
		<form method="get" class="form-inline">
			
				<!-- Service (Recherche selon le statut) -->
			<div class="form-group">
				<label class="radio-inline">
					<input type="radio" name="statut" id="all" value="all" checked=""> Tous les services
				</label>
				<label class="radio-inline">
					<input type="radio" name="statut" id="opened" value="opened"> Services ouverts
				</label>
				<label class="radio-inline">
					<input type="radio" name="statut" id="closed" value="closed"> Services cloturés
				</label>					
			</div>
			&nbsp;
			<div class="form-group">					
				<button class="btn btn-info" type="submit">
					<i class="fa fa-search"></i>
				</button>
			</div>	

		</form>
	</div>
	
		
	<?php if(isset($errorConsult) && $errorConsult): ?>
		<div class="row">
			<div class="col-md-12 text-right">
				<a href="<?=$this->url('front_customer_profil');?>" title="Compléter votre profil">Veuillez compléter votre profil pour consulter les devis</a>
			</div>
		</div>
	<?php endif; ?>

	<?php if(!empty($projects)): ?>	
	<table class="table table-bordered table-responsive">

		<thead>
			<tr>
				<th>N° Offre</th>
				<th>Service</th>
				<th>Créé le</th>
				<th>Prévu le</th>
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
				<td class="text-center">
					<?php if($project['closed']): ?>
						<span class="text-danger">Cloturé</span>
					<?php else: ?>
						<span class="text-success">Ouvert</span>
					<?php endif; ?>	
				</td>
                <td class="text-center"><span class="badge badge-success"><?=$project['nb_devis'];?></span></td>
				<td class="text-center">
                    <?php if(!$project['closed']): ?>
                        <div class="col-md-3">
                            <a href="<?=$this->url('front_view_service', ['id' => $project['id']]);?>" class="btn btn-success btn-sm btn_margin" title="Consulter ce service">
                             Consulter
                            </a>
                        </div>
                        &nbsp;
                    <?php if($project['nb_devis'] == 0):?>
                        <div class="col-md-3">
                            <a href="<?=$this->url('front_edit_service', ['idProject' => $project['id']]);?>" class="btn btn-info btn-sm btn_margin" title="Modifier ce service">
                             Modifier
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if($project['nb_devis'] > 0):?>
                    	<div class="col-md-3">
                            &nbsp;
                        </div>
                    <?php endif; ?>
                        <div class="col-md-3">
                            <a href="<?=$this->url('front_delete_service', ['id' => $project['id']]);?>" class="btn btn-danger btn-sm btn_margin" title="Supprimer ce service">
                             Supprimer
                            </a>
                        </div>
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
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>

	</table>

	<?php elseif(empty($projects) && !empty($_GET['statut'])): ?>
		<?php if($_GET['statut'] == 'opened'): ?>
			<p class="text-danger">Vous n'avez aucun service ouvert</p>
		<?php endif; ?>
		<?php if($_GET['statut'] == 'closed'): ?>
			<p class="text-danger">Vous n'avez aucun service cloturé</p>
		<?php endif; ?>

	<?php else: ?>
		<p class="text-danger">Vous n'avez aucun service encours</p>
	<?php endif; ?>

	<div class="text-right">
		<a href="<?=$this->url('front_service_add');?>" class="btn btn-info" title="Ajouter un nouveau service">Nouveau service</a>
	</div>

</div>

<?php $this->stop('main_content') ?>