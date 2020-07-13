<div class="card-columns">
    <?php foreach($cards as $card) : ?>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nom : <?= $card->getName(); ?></h5>
                <p class="card-text">Entreprise : <?= $card->getCompany(); ?></p>
                <p class="card-text">Email : <?= $card->getEmail(); ?></p>
                <p class="card-text">Téléphone : <?= $card->getTelephone(); ?></p>  
            </div>
        </div>
    <?php endforeach ?>
</div>