<!--Ana Bojovic-->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proizvod</title>
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
    <style>
        table {
          border-collapse: separate;
          border-spacing: 0;
        }
      
        td {
          border-bottom: 15px solid black;
          border-left: 0cap;
        }
      </style>
    <div class="container tek text-center">
        <div class="row mt-5">
            <div class="col-12 text-center naslov">
                <p id="hc">HOME CENTRE</p>
            </div>
        </div>
        <h1 class="pitanje" >UGAONE GARNITURE</h1><br>
        <br><div class="proizvod">
            <table class="proizvod text-center center">
                <tr>
                    <td class="slikeProizvoda"><img src="<?php echo base_url('slike/aldo.png') ?>"></td>
                    <td class="pTekst"><div class="card-body">
                        <h4 class="card-title">Tara</h4>
                        <p class="card-text">Ugaona garnitura sa metalnim nogarima, uklapa se u svaki enterijer. </p>
                    </div></td>
                </tr>
                <tr>
                    
                    <td class="slikeProizvoda"><img src="<?php echo base_url('slike/brisel.jpg') ?>"></td>
                    <td class="pTekst"><div class="card-body">
                        <h4 class="card-title">Zlatibor</h4>
                        <p class="card-text">Ugaona garnitura za svaki enterijer. </p>
                    </div></td>
                </tr>
                <tr>
                    
                    <td class="slikeProizvoda"><img src="<?php echo base_url('slike/marsej.jpg') ?>"></td>
                    <td class="pTekst"><div class="card-body">
                        <h4 class="card-title">Kopaonik</h4>
                        <p class="card-text">Ugaona garnitura za svaki enterijer. </p>
                    </div></td>
                </tr>
            </table>
        </div>
        
    </div>


