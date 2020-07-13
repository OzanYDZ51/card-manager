<?php

use App\Models\UserModel;
?>
<?= $this->layout('layout', ['myTitle' => 'Mon profil']); ?>

<!-- content -->
<div class="container">
<h1>Mon profil</h1>
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#user-profile" role="tab" aria-controls="user-profile" aria-selected="true">Mon Profil</a>
    <a class="nav-item nav-link" id="nav-card-tab" data-toggle="tab" href="#card" role="tab" aria-controls="card" aria-selected="false">Mes Contacts</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane py-4 fade show active" id="user-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
    <p>Mon nom : <?= $connectedUser->getLast_name() ?></p>
    <p>Mon prénom : <?= $connectedUser->getFirst_name() ?></p>
    <?= $this->insert('user/_card-creation-form', ['card' => $user_card, 'route' => $router->generate('profil_new_card')]) ?>
  </div>
  <div class="tab-pane py-4 fade" id="card" role="tabpanel" aria-labelledby="nav-card-tab">
    <p>Mes cartes de visite :</p>
    <?php if(!empty($cards)): ?>
    <?= $this->insert('user/_user-card', ['cards' => $cards]) ?>
    <?php else: ?>
    <p>Vous n'avez encore aucune carte de visite pour le moment. Lancez-vous ! </p>
    <?php endif ?>
    <?= $this->insert('user/_card-creation-form', ['card' => $new_card, 'route' => $router->generate('user_new_card')]) ?>
  </div>
</div>

</div>