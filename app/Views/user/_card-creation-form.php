<div class="card p-3">
    <form method="POST" action="<?= $route ?>">
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Entrez un nom" required value="<?=$card->getName();?>">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Entrez un email" value="<?=$card->getEmail();?>">
        </div>
        <div class="form-group">
            <label for="company">Entreprise</label>
            <input type="text" class="form-control" name="company" id="company" placeholder="Entrez une entreprise" value="<?=$card->getCompany();?>">
        </div>
        <div class="form-group">
            <label for="telephone">Téléphone</label>
            <input type="tel" class="form-control" name="telephone" id="telephone" placeholder="Entrez un numéro de téléphone" value="<?=$card->getTelephone();?>">
        </div>
    <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>