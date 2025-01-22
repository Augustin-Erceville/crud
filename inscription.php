<?php
include ("config.php");
class inscription{
    public $bdd;
    public function getBdd(){
        return $this->bdd;
    }
    public function setBdd($bdd){
        $this->bdd=$bdd;
    }
    public function __construct($bdd) {
        $this->bdd=$bdd;
    }
    public function envoisFormulaire() {
        if (isset($_POST['envoyer'])) {
            $prenom=$_POST['prenom'];
            $nom=$_POST['nom'];
            $naissance=$_POST['naissance'];
            $telephone=$_POST['telephone'];
            $email=$_POST['email'];
            $password=$_POST['password'];
            if ($this->validationDonnee($prenom, $nom, $naissance, $telephone, $email, $password)) {
                if ($this->ajoutUtilisateur($prenom, $nom, $naissance, $telephone, $email, $password)) {
                    $_SESSION['email'] = $email;
                    header('Location: index.php');
                    exit();
                } else {
                    return "Erreur lors de l'inscription. Veuillez réessayer.";
                }
            } else {
                return "Tous les champs sont obligatoires ou invalides.";
            }
        }
        return null;
    }
    public function validationDonnee($prenom, $nom, $naissance, $telephone, $email, $password) {
        return !empty($prenom)&&!empty($nom) &&!empty($naissance) &&!empty($telephone)&&!empty($email)&&!empty($password)&&filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    private function ajoutUtilisateur($prenom, $nom, $naissance, $telephone, $email, $password) {
        $req = $this->bdd->prepare(
            'INSERT INTO utilisateur (prenom, nom, telephone, email, password, naissance) VALUES (:prenom, :nom, :telephone, :email, :password, :naissance)'
        );
        return $req->execute([
            'prenom' => $prenom,
            'nom' => $nom,
            'telephone' => $telephone,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'naissance' => $naissance
        ]);
    }
}
$inscription = new Inscription($bdd);
$message = $inscription->envoisFormulaire();
?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Inscription</h1>
    <form action="" method="post">
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text">Prénom & Nom</span>
                <input type="text" name="prenom" id="prenom" placeholder="Prénom" aria-label="First name" class="form-control" required>
                <input type="text" name="nom" id="nom" placeholder="Nom de famille" aria-label="Last name" class="form-control" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="naissance">Date de naissance</label>
            <input type="date" name="naissance" class="form-control" id="naissance" aria-label="default input example" required/>
            <div class="valid-feedback">
                Champ valide
            </div>
        </div>
        <div class="mb-3">
            <label for="telephone">Numéro de téléphone</label>
            <input type="tel" name="telephone" class="form-control" id="telephone" placeholder="Votre numéro de téléphone" aria-label="default input example" required>
        </div>
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="adresse@email.com" required>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Votremotdepasse" aria-describedby="passwordHelpBlock" required>
                </div>
            </div>
        </div>
        <div class="d-grid gap-2">
            <input type="submit" class="btn btn-outline-success" name="envoyer" id="envoyer" value="S'inscrire"/>
        </div>
    </form>
    <p>
        Déjà un compte ? <a href="connexion.php">Se connecter</a>

        <?php if (isset($message)) : ?>
    <?= $message ?><p></p>
    <div class="alert alert-success" role="alert">
        Vous êtes connecter
    </div>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
