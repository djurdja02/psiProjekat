<!DOCTYPE html>

<!--Ana Bojovic-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt informacije</title>
    <link href='<?php echo base_url("style.css") ?>' rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
</head>
<body class="tek">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <img src="<?php echo base_url('slike/logo1.jpeg') ?>" alt="Logo" style="width:50px;" class="rounded-pill">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="<?= site_url("{$controller}/prikaziStranicuPocetna") ?>">Početna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url("{$controller}/prikaziStranicuPostaviPitanje") ?>">Postavite pitanje</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url("{$controller}/prikaziStranicuPregledRecenzija") ?>">Pogledajte recenzije</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url("{$controller}/prikaziStranicuOnama") ?>">Kontakt informacije</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container tek text-center">
        <h1 class="pitanje">O nama</h1>

    <div class="text-center tekst">
        <p>Mi smo mala porodična firma iz Raške koja se bavi proizvodnjom nameštaja po meri od 2006.godine.</p>
        <br><p>Adresa: Raška Ibarska bb </p><br>
        <p>Kontakt telefon:063666407</p><br>
        <p>E-mail: ivan.joksimovic@yahoo.com</p>
    </div>

</body>
</html>