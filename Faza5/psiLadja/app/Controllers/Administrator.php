<?php

namespace App\Controllers;
use App\Models\Recenzija;
use App\Models\Materijal;
use App\Models\Boja;
use App\Models\GNamestaj;
use App\Models\Korisnik;
use App\Models\SlikaGotovNamestaj;
use App\Models\ModelNamestaja;
use App\Models\TipNamestaja;
use App\Models\NamestajPoMeri;
use App\Models\SlikaNamestajPoMeri;

class Administrator extends Moderator
{
    protected function prikaz($page, $data) {
        $data['controller']='Administrator';
        echo view ("prototip/$page", $data);
    }
    public function index(){
        $this->session->destroy();
        $this->prikaz("opcijeAdministratora", null);
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
    
    public function logout() {
        $this->session->destroy();
        return redirect()->to(site_url('/'));
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
    
    public function izmeniCenuPre() {
        $this->prikaz('izmenaCene', []);
    }
    
    public function greske($page = 'izmenaCene',$poruka=null) {
        $this->prikaz($page, ['poruka'=>$poruka]);
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
    
    public function ukloniNalogPre() {
        $this->prikaz('ukloniNalog', []);
    }
    
    public function ukloniNalog() {
        $korime = $this->request->getVar('korIme');
        $korisnikModel = new Korisnik();
        $kor = $korisnikModel->where('KorisnickoIme', $korime)->first();
        
        if($kor){
            $id = $kor->IdKor;
            $korisnikModel->delete($id);
        }
        else{
            return $this->greske('ukloniNalog','Nepostojeci nalog');
        }
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
    
    public function postaviPitanje() {
        $this->prikaz('uspeh', []);
    }
    
    
    
    //-----------------opcije administratora ana-------------------
    
    public function prikaziStranicuDodajModeratora() {
        $this->prikaz('dodajModeratora', null);
    }
    
    public function dodajModeratora() {
        $moderatorD = $this->request->getVar('moderatorZaDodavanje');
        $korisnikD = new Korisnik();
        $kor = $korisnikD->where('KorisnickoIme', $moderatorD)->first();
        
        //'IdKor', 'Ime', 'Prezime','Mejl','KorisnickoIme','Lozinka','Flag'
        $dataReda = array(
            'IdKor' => $kor->IdKor,
            'Ime' => $kor->Ime,
            'Prezime' => $kor->Prezime,
            'Mejl' => $kor->Mejl, 
            'KorisnickoIme' => $kor->KorisnickoIme, 
            'Lozinka' => $kor->Lozinka, 
            'Flag' => 1
        );
        
        $korisnikD->update($kor->IdKor, $dataReda);
        
        $this->prikaz('uspeh', []);
    }
    
    public function prikazDodajSlikuUGaleriju() {
        $this->prikaz('dodajSlikuUGaleriju', null);
    }
    
    public function dodajSlikuUGaleriju() {
        
        $urlSlike = $this->request->getVar('slikaModela');
        $slikaGotovNamestajModel = new SlikaGotovNamestaj();
        
        // ['IdSlGN', 'Link', 'IdGN','IdKor'];
        $dataReda = array(
            //'IdSlGN' => ...,
            'Link' => $urlSlike,
            'IdGN' => 5000,
            'IdKor' => 5000
        );
        
        $slikaGotovNamestajModel->insert('Slika_Gotov_Namestaj', $dataReda);
        
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
    
    //-----------------opcije administratora ana-------------------
    
    
    //-----------------linkovi za navbar---------------------------
    public function prikaziStranicuPocetna() {
        $this->prikaz('pocetna', null);
    }
    
    public function prikaziStranicuPostaviPitanje() {
        $this->prikaz('postaviPitanje', null);
    }
    
    public function prikaziStranicuPregledRecenzija() {
        $this->prikaz('pregledRecenzija', null);
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

     public function prikaziPraznaProizvodPoMeri($idModela) {
        $data['IdModelaData'] = $idModela;
        $this->prikaz('praznaProizvodPoMeri', $data);
    }
    
    public function prikaziPraznaMaterijal() {
        $this->prikaz('praznaMaterijal', []);
    }
    public function prikaziStranicuDodavanjeProizvodaPoMeri() {
        $this->prikaz('dodavanjeProizvodaPoMeri', null);
    }
    
    
    
    //-----------------linkovi za navbar---------------------------
    
}
