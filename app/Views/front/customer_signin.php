<?php $this->layout('layout', ['title' => 'Inscription Particulier']) ?>
<?php $this->start('main_content') ?>

<div class="forms">

<div class="content-site">
  <div class="page-header">
    <h1">Inscription Particulier</h1>
  </div>
 
    <form method="post" class="form-horizontal">
      <p class="text-required-filed">
        <span class="obligatoire">*</span>
        Champs obligatoires
      </p>
      <fieldset>
        <?php if(isset($formErrors['global'])): ?>
        <div class="alert alert-danger">
          <?=$formErrors['global'];?>

        </div>
        <?php endif; ?>

        <!-- Select civilité -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="civilite">Civilité :
            <span class="obligatoire">*</span>
          </label>
          <div class="col-md-2">
            <select id="civilite" name="civilite" class="form-control" required="">
              <option value="" selected disabled>- Sélection -</option>
              <option value="Monsieur">Mr</option>
              <option value="Madame">Mme</option>
              <option value="Mademoiselle">Melle</option>
            </select>
          </div>
        </div>
        <!-- Firstname-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="firstname">Prénom :
            <span class="obligatoire">*</span>
          </label>
          <div class="col-md-4">
            <input id="firstname" name="firstname" type="text" placeholder="jean" value="<?=isset($post['firstname']) ? $post['firstname'] : '';?>"  class="form-control input-md">
            
          </div>
          <!-- Gestion des erreurs -->
          <?php if(isset($formErrors['firstname'])): ?>
          <div class="error col-md-offset-4 col-md-8"><?=$formErrors['firstname']?></div>
          <?php endif; ?>
        </div>
        <!-- Lastname-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="lastname">Nom :
            <span class="obligatoire">*</span>
          </label>
          <div class="col-md-4">
            <input id="lastname" name="lastname" type="text" placeholder="Durandet" value="<?=isset($post['lastname']) ? $post['lastname'] : '';?>" class="form-control input-md">
            
          </div>
          <!-- Gestion des erreurs -->
          <?php if(isset($formErrors['lastname'])): ?>
          <div class="error col-md-offset-4 col-md-8"><?=$formErrors['lastname']?></div>
          <?php endif; ?>
        </div>
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="email">Email:
            <span class="obligatoire">*</span>
          </label>
          <div class="col-md-4">
            <input id="email" name="email" type="email" placeholder="jean.durandet@gmail.com" value="<?=isset($post['email']) ? $post['email'] : '';?>" class="form-control input-md">
            
          </div>
          <!-- Gestion des erreurs -->
          <?php if(isset($formErrors['email'])): ?>
          <div class="error col-md-offset-4 col-md-8"><?=$formErrors['email']?></div>
          <?php endif; ?>
        </div>
        <!-- Password input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="password">Mot de passe:
            <span class="obligatoire">*</span>
          </label>
          <div class="col-md-4">
            <input id="password" name="password" type="password" placeholder="" class="form-control input-md">
            
          </div>
          <!-- Gestion des erreurs -->
          <?php if(isset($formErrors['password'])): ?>
          <div class="error col-md-offset-4 col-md-8"><?=$formErrors['password']?></div>
          <?php endif; ?>
        </div>
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="fixed_phone">Téléphone fixe:
          </label>
          <div class="col-md-4">
            <input id="fixed_phone" name="fixed_phone" type="text" placeholder="0123456789" value="<?=isset($post['fixed_phone']) ? $post['fixed_phone'] : '';?>" class="form-control input-md">
            
          </div>
          <!-- Gestion des erreurs -->
          <?php if(isset($formErrors['fixed_phone'])): ?>
          <div class="error col-md-offset-4 col-md-8"><?=$formErrors['fixed_phone']?></div>
          <?php endif; ?>
        </div>
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="mobile_phone">Téléphone mobile:
          </label>
          <div class="col-md-4">
            <input id="mobile_phone" name="mobile_phone" type="text" placeholder="0612345678" value="<?=isset($post['mobile_phone']) ? $post['mobile_phone'] : '';?>" class="form-control input-md">
            
          </div>
          <!-- Gestion des erreurs -->
          <?php if(isset($formErrors['mobile_phone'])): ?>
          <div class="error col-md-offset-4 col-md-8"><?=$formErrors['mobile_phone']?></div>
          <?php endif; ?>
        </div>
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="street">Adresse:
          </label>
          <div class="col-md-4">
            <input id="street" name="street" type="text" placeholder="Rue de la paix" value="<?=isset($post['street']) ? $post['street'] : '';?>" class="form-control input-md">
            
          </div>
          <!-- Gestion des erreurs -->
          <?php if(isset($formErrors['street'])): ?>
          <div class="error col-md-offset-4 col-md-8"><?=$formErrors['street']?></div>
          <?php endif; ?>
        </div>
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="zipcode">Code postal:
          </label>
          <div class="col-md-2">
            <input id="zipcode" name="zipcode" type="text" placeholder="75000" value="<?=isset($post['zipcode']) ? $post['zipcode'] : '';?>" class="form-control input-md">
            
          </div>
          <!-- Gestion des erreurs -->
          <?php if(isset($formErrors['zipcode'])): ?>
          <div class="error col-md-offset-4 col-md-8"><?=$formErrors['zipcode']?></div>
          <?php endif; ?>
        </div>
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="city">Ville:
          </label>
          <div class="col-md-4">
            <input id="city" name="city" type="text" placeholder="Paris" value="<?=isset($post['city']) ? $post['city'] : '';?>" class="form-control input-md">
            
          </div>
          <!-- Gestion des erreurs -->
          <?php if(isset($formErrors['city'])): ?>
          <div class="error col-md-offset-4 col-md-8"><?=$formErrors['city']?></div>
          <?php endif; ?>
        </div>
        <!-- Button -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="signin"></label>
          <div class="col-md-4">
            <button id="signin" name="signin" class="btn btn-devirama">Inscription</button>
          </div>
        </div>
      </fieldset>
    </form>
  </div>
</div>
<?php $this->stop('main_content') ?>