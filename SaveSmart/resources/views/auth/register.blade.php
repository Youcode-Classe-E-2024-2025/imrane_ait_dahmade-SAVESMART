<form>
    <div class="mb-3">
      <label for="name" class="form-label">Nom complet</label>
      <input type="text" class="form-control" id="name" placeholder="Entrez votre nom" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Adresse Email</label>
      <input type="email" class="form-control" id="email" placeholder="Entrez votre email" required>
    </div>
    
    <div class="mb-3">
      <label for="password" class="form-label">Mot de passe</label>
      <input type="password" class="form-control" id="password" placeholder="Créez un mot de passe" required>
    </div>

    <div class="mb-3">
      <label for="confirm-password" class="form-label">Confirmez le mot de passe</label>
      <input type="password" class="form-control" id="confirm-password" placeholder="Confirmez votre mot de passe" required>
    </div>

    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" id="terms" required>
      <label class="form-check-label" for="terms">
        J'accepte les <a href="#">termes et conditions</a>
      </label>
    </div>

    <div class="d-grid">
      <button type="submit" class="btn btn-success">S'inscrire</button>
    </div>

    <div class="text-center mt-3">
      <p>Vous avez déjà un compte ? <a href="#">Se connecter</a></p>
    </div>
  </form>
</div>