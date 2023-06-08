<?php

namespace App\Controllers;
use App\Models\Recenzija;
use App\Models\Materijal;
use App\Models\Boja;
use App\Models\GNamestaj;
use App\Models\SlikaGotovNamestaj;
use App\Models\ModelNamestaja;
use App\Models\TipNamestaja;
use App\Models\SlikaMaterijal;
use App\Models\NamestajPoMeri;
use App\Models\SlikaNamestajPoMeri;
use App\Models\SlikaBoja;

class Moderator extends Prijavljen
{
   protected function prikaz($page, $data) {
        $data['controller']='Moderator';
        echo view ("prototip/$page", $data);
    }
    public function index(){
        $this->prikaz("opcijeModeratora", null);
    }
    
    public function prikaziRecenzijuPre() {
        $this->prikaz('dodajRecenziju', []);
    }
    
    public function postaviRecenziju(){
        $ocena = $this->request->getVar('ocena');
        $komentar = $this->request->getVar('komentar');
        $korisnik=$this->session->get("moderator");
        $novaRecenzija=new Recenzija();
        $data = [
            'Ocena' => $ocena,
            'Komentar' =>$komentar,
            'IdKor' => $korisnik->IdKor
        ];
        $novaRecenzija->insert($data);
        $this->prikaz("uspeh", null);
    }
    
    public function dodajMaterijalPre(){
        $this->prikaz('dodajMaterijal', []);
    }
    
    public function dodajMaterijal(){
        $materijal = $this->request->getVar('materijal');
        $cena = $this->request->getVar('materijalCena');
        $urlSlike = $this->request->getVar('slikaMat');
        $sifreProizvoda = $this->request->getVar('proizvodi');
        $sifreProizvoda = explode(",", $sifreProizvoda);
        $materijalModel= new Materijal();
        
        
        $materijalModel->insert([
            
            'Naziv'=>$materijal,
            'Cena'=> $cena
        ]);
        
        $id = $materijalModel->getInsertID();
        
        $slikaMaterijalModel = new SlikaMaterijal();
        
        $slikaMaterijalModel->insert([
            'IdMat' => $id,
            'IdKor' => 1,
            'Link' => $urlSlike 
        ]);
        
        
        $gotovNamestajModel = new GNamestaj();
        foreach ($sifreProizvoda as $proizvod) {
           $proizvod = $gotovNamestajModel->where('IdGN',$proizvod)->first();
           if($proizvod) $gotovNamestajModel->update($proizvod->IdGN,['IdMat' => $id]);
           
        }
        
        $this->prikaz('uspeh', []);
    }
    
    public function dodajBojuPre(){
        $this->prikaz('dodajBoju', []);
    }
    
    public function dodajBoju() {
        $bojaModel = new Boja();
        $naziv = $this->request->getVar('naziv');
        $urlSlike = $this->request->getVar('slikaBoje');
        $cena = $this->request->getVar('cena');
        
         $bojaModel->insert([
            
            'Naziv'=>$naziv,
            'Cena'=> $cena
        ]);
         $id = $bojaModel->getInsertID();
        
         $slikaBojaModel = new SlikaBoja();
        
        $slikaBojaModel->insert([
            'IdBoj' => $id,
            'IdKor' => 1,
            'Link' => $urlSlike 
        ]);
        $this->prikaz('uspeh', []);
    }


    public function izmeniCenuPre() {
        $this->prikaz('izmenaCene', []);
    }
    
    public function greske($poruka=null) {
        $this->prikaz('izmenaCene', ['poruka'=>$poruka]);
    }
    
    public function izmeniCenu() {
        $op = $this->request->getVar('vrsta[]');
        $op = $op[0];
        $cena = $this->request->getVar('cena');
        switch($op){
            case 'boja':
                $bojaModel = new Boja();
                $nazivBoje = $this->request->getVar('nazivBoje');
                if($nazivBoje==null) return $this->prikaz('izmenaCene', ['poruka'=>"Unesite naziv boje!"]);
                $boja = $bojaModel->where('Naziv',$nazivBoje)->first();
                if ($boja) {
                    $bojaModel->update($boja->IdBoj, ['Cena' => $cena]);
                }
                else{
                    return $this->greske('Nepostojeca boja');
                }
                break;
            case 'materijal':
                $materijalNaziv = $this->request->getVar('nazivMaterijala');
                if($materijalNaziv==null) return $this->prikaz('izmenaCene', ['poruka'=>"Unesite naziv materijala!"]);
                $materijalModel = new Materijal();
                $materijal = $materijalModel->where('Naziv',$materijalNaziv)->first();
                if($materijal){
                    $materijalModel->update($materijal->IdMat,['Cena' => $cena]);
                }
                else{
                    return $this->greske('Nepostojeci materijal');
                }
                break;
            case 'proizvod':
                $proizvodNaziv = $this->request->getVar('nazivProizvoda');
                if($proizvodNaziv==null) return $this->prikaz('izmenaCene', ['poruka'=>"Unesite naziv proizvoda!"]);
                $gotovNamestajModel = new GNamestaj();
                $proizvod = $gotovNamestajModel->where('IdGN',$proizvodNaziv)->first();
                if($proizvod){
                    $gotovNamestajModel->update($proizvod->IdGN,['Cena' => $cena]);
                }
                else{
                    return $this->greske('Nepostojeci proizvod');
                }
                break;
        }
         //return redirect()->to(site_url("Moderator/index"));
        $this->prikaz('uspeh', []);
    }
    
    public function postaviPitanje() {
        $this->prikaz('uspeh', []);
    }
    
    public function ukloniProizvodPre() {
        $this->prikaz('ukloniProizvod', []);
    }
    
    public function ukloniProizvod() {
        $sifra = $this->request->getVar('sifra');
        $gNamestajModel = new GNamestaj();
        $gNamestaj = $gNamestajModel->where('IdGN',$sifra)->first();
        
        if($gNamestaj){
            $id = $gNamestaj->IdGN;
            $gNamestajModel->delete($id);
        }
        else{
            return $this->greske('ukloniProizvod','Nepostojeci proizvod');
        }
        $this->prikaz('uspeh', []);
    }
    
    
    
    
    //-----------------linkovi za navbar---------------------------
    public function prikaziStranicuPocetna() {
        $this->prikaz('pocetna', null);
    }
    
    public function prikaziStranicuPostaviPitanje() {
        $this->prikaz('postaviPitanje', null);
    }
    
    public function prikaziStranicuPregledRecenzija() {
        $recenzijaModel = new Recenzija();
        $recenzije = $recenzijaModel->findAll();
        $this->prikaz('pregledRecenzija', ['recenzije' => $recenzije]);
    }
    
    public function prikaziStranicuOnama() {
        $this->prikaz('onama', null);
    }
    
    public function prikaziStranicuRegistracija() {
        $this->prikaz('registracija', null);
    }
    
    public function prikaziStranicuGalerija() {
        $this->prikaz('galerija', null);
    }
    
    
    public function prikaziStranicuTipovi() {
        $this->prikaz('tipovi', null);
    }
    
    public function logout() {
        $this->session->destroy();
        return redirect()->to(site_url('/'));
    }

    //-----------------linkovi za navbar---------------------------
    
    
     //-----------------moderator funkcionalnosti ana---------------
    
    public function prikazDodajSlikuUGaleriju() {
        $this->prikaz('dodajSlikuUGaleriju', null);
    }
    
    public function dodajSlikuUGaleriju() {
        
        $urlSlike = $this->request->getVar('slikaModela');
        $slikaGotovNamestajModel = new SlikaGotovNamestaj();
        
        // ['IdSlGN', 'Link', 'IdGN','IdKor'];
        $dataReda = array(
            //'IdSlGN' => 7000,
            'Link' => $urlSlike,
            'IdGN' => 5000,
            'IdKor' => 5000
        );
        
        $slikaGotovNamestajModel->insert($dataReda);
        
        $this->prikaz('uspeh', []);
    }
    
    public function prikazDodavanjeModela() {
        $this->prikaz('dodavanjeModela', null);
    }
    
    public function prikazDodavanjeTipa() {
        $this->prikaz('dodavanjeTipa', null);
    }
    
    
    
    
    public function prikazPraznaModeli($idTipa) {
        $data['IdTipData'] = $idTipa;
        $this->prikaz('praznaModeli', $data);
    }
    
    public function prikaziPraznaProizvodPoMeri($idModela) {
        $data['IdModelaData'] = $idModela;
        $this->prikaz('praznaProizvodPoMeri', $data);
    }
    
    public function prikaziPraznaMaterijal() {
        $this->prikaz('praznaMaterijal', []);
    }
    
    public function prikaziPraznaBoje() {
        $this->prikaz('praznaBoje', []);
    }
    
    
    
    
    public function dodavanjeModelaMetod() {
        $nazivModela = $this->request->getVar('naziv');
        $slikaModela = $this->request->getVar('slikaModela');
        $kategorijaTipa = $this->request->getVar('tipModela');
        $modelModel = new ModelNamestaja();
        $modelTip = new TipNamestaja();
        
        $tipRow = $modelTip->dohvati($kategorijaTipa);
        $idTipa = $tipRow->IdTip;
        
        //['IdMod', 'Naziv', 'IdTip','Slika'];
        $dataZaInsert = array(
            //'IdMod' => 7000, 
            'Naziv' => $nazivModela, 
            'IdTip' => $idTipa, 
            'Slika' => $slikaModela
        );
        
        $modelModel->insert($dataZaInsert);
        
        $this->prikaz('uspeh', []);
    }
    
    public function dodavanjeTipaMetod() {
        $kategorija = $this->request->getVar('naziv');
        $slikaTipa = $this->request->getVar('slikaTipa');
        
        $modelTip = new TipNamestaja();
        
        //['IdTip', 'Kategorija', 'Slika'];
        $dataZaInsert = array(
            'Kategorija' => $kategorija, 
            'Slika' => $slikaTipa
        );
        
        $modelTip->insert($dataZaInsert);
        
        $this->prikaz('uspeh', []);
    }
    public function prikaziStranicuDodavanjeProizvodaPoMeri() {
        $this->prikaz('dodavanjeProizvodaPoMeri', null);
    }
    
    public function dodavanjeNamestajaPoMeri()
    {
        $cena = $this->request->getVar('cenaPr');
        $modelNaziv = $this->request->getVar('model');
        $naziv = $this->request->getVar('naziv');
        $slikaProizvoda = $this->request->getVar('slikaProizvoda');
        $modelModelNamestaja = new ModelNamestaja();
        $modelSlika = new SlikaNamestajPoMeri();
        $rowModel = $modelModelNamestaja->dohvati($modelNaziv);
        $idModel = $rowModel->IdMod;
        $modelNamestajPoMeri = new NamestajPoMeri();
        /*$dataZaInsert = array(
            'IdMod' =>$idModel, 'DodatnaCenaUsluga'=>$cena, `Naziv`=>$naziv
        );
        $modelNamestajPoMeri->insert($dataZaInsert);*/
        $modelNamestajPoMeri->insert([
            'Naziv'=>$naziv,
            'DodatnaCenaUsluga'=>$cena,
            'IdMod' =>$idModel
            
            
            
        ]);
        $urlSlike = $this->request->getVar('slikaProizvoda');
        
        
        echo "$naziv";
        //$idNpm = $modelNamestajPoMeri->getInsertID();
        //$dataZaInsert1 = array(
         //   `Link`=>$slikaProizvoda, `IdNPM` =>$idNpm, `IdKor`=>1
       // );
        
        //$modelSlika->insert($dataZaInsert1);
        
        
        $id = $modelNamestajPoMeri->getInsertID();
        
        $slikaModel = new SlikaNamestajPoMeri();
        
        $slikaModel->insert([
            'IdNPM' => $id,
            'IdKor' => 1,
            'Link' => $urlSlike 
        ]);
        
        
        $this->prikaz('uspeh', []);
    }

    //-----------------moderator funkcionalnosti ana---------------
    public function dodajGotovProizvodPre() {
        $this->prikaz('dodavanjeGotovogProizvoda', []);
    }
    
    public function dodajGotovProizvod() {
        $tipModel = new TipNamestaja();
        $modelModel = new ModelNamestaja();
        
        $naziv = $this->request->getVar('naziv');
        $sifra = $this->request->getVar('sifra');
        $urlSlike = $this->request->getVar('slikaProizvoda');
        $cena = $this->request->getVar('cenaPr');
        $visina = $this->request->getVar('visina');
        $sirina = $this->request->getVar('sirina');
        $dubina = $this->request->getVar('dubina');
        $nazivTipa = $this->request->getVar('tip');
        
        $nazivModela = $this->request->getVar('model');
        $IdMod = $modelModel->where('Naziv', $nazivModela)->find()[0]->IdMod;
        
        
        
        $boje = $this->request->getVar('boje');
        $IdMat = $this->request->getVar('materijali');
      
        
          
        $gNamestajModel = new GNamestaj();
        
        $gNamestajModel->insert([
            
            'Naziv'=>$naziv,
            'Cena'=> $cena,
            'IdMat' =>$IdMat,
            'Visina'=> $visina,
            'Sirina' => $sirina,
            'Dubina' => $dubina,
            'IdBoj' => $boje,
            'IdMod' => $IdMod,
        ]);
        
        
        
        $id = $gNamestajModel->getInsertID();
        
        $slikaModel = new SlikaGotovNamestaj();
        
        $slikaModel->insert([
            'IdGN' => $id,
            'IdKor' => 1,
            'Link' => $urlSlike 
        ]);
        
     
        
         $this->prikaz('uspeh', []);
        
        
    }
    
}
