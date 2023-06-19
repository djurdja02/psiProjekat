<!DOCTYPE html>

<!--Andrej Davidovic-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator</title>
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

    <div class="container tekst text-center">
        <h1 id="pitanje">Izaberite opciju:</h1>

    <div class="text-center tekst">   
        <a  href="<?= site_url('Administrator/dodajBojuPre') ?>" > Dodaj novu boju</a> <br>
        <a  href="<?= site_url('Administrator/dodajMaterijalPre') ?>" > Dodaj nove vrste materijala</a> <br>
        <a  href="<?= site_url('Administrator/izmeniCenuPre') ?>" > Unesi izmenu cena</a> <br>
        <a href="<?= site_url('Administrator/prikazDodajSlikuUGaleriju') ?>">Dodaj sliku u galeriju proizvoda</a><br>
        <a href="<?= site_url('Administrator/prikaziStranicuDodavanjeProizvodaPoMeri') ?>">Dodaj proizvod po meri</a><br>
        <a  href="<?= site_url('Administrator/dodajGotovProizvodPre') ?>" > Dodaj gotov proizvod</a> <br>
        <a href="<?= site_url('Administrator/prikaziStranicuDodajModeratora') ?>">Dodaj moderatora</a><br>
        <a  href="<?= site_url('Administrator/ukloniProizvodPre') ?>" >Ukloni proizvod</a> <br>
        <a  href="<?= site_url('Administrator/ukloniNalogPre') ?>" >Ukloni nalog</a> <br>
        <a href="<?= site_url('Administrator/prikazDodavanjeTipa') ?>">Dodaj tip</a> <br>
        <a href="<?= site_url('Administrator/prikazDodavanjeModela') ?>">Dodaj model</a> <br>
    </div>

</body>
</html>