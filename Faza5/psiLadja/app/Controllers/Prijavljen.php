<?php

namespace App\Controllers;
use App\Models\TipNamestaja;
use App\Models\ModelNamestaja;
use App\Models\NamestajPoMeri;
use App\Models\Boja;
use App\Models\Materijal;
use App\Models\NarucenNamestajPoMeri;
use App\Models\Porudzbine;
use App\Models\StavkaGotovNamestaj;
use App\Models\StavkaNamestajPoMeri;
use App\Models\StavkaPorudzbine;
use App\Models\GNamestaj;

class Prijavljen extends BaseController
{
    protected function prikaz($page, $data) {
        $data['controller']='Prijavljen';
        echo view ("prototip/$page", $data);
    }
    public function index(){
        $this->prikaz("pocetna", null);
    }
    public function logout() {
        $this->session->destroy();
        return redirect()->to(site_url('/'));
    }
    
    public function postaviRecenziju(){
        $ocena = $this->request->getPost('ocena');
        $komentar = $this->request->getPost('komentar');
        $korisnik=$this->session->get("korisnik");
        $novaRecenzija=new Recenzija();
        $data = [
            'Ocena' => $ocena,
            'Komentar' =>$komentar,
            'IdKor' => $korisnik->IdKor
        ];
        $novaRecenzija->insert($data);
        $this->prikaz("uspeh", null);
    }
    
     public function postaviPitanje() {
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
    function prikaziStranicuModeli()
    {
        $this->session->set('tip','Stolovi');
        $this->prikaz('modeli',null);
    }
    function prikaziStranicuProizvodPMeri()
    {
        $this->session->set('model','Industrijski sto');
        $this->prikaz('proizvodPoMeri',null);
    }
    function prikaziStranicuProizvodPMeri2()
    {
        $this->prikaz('proizvodPoMeri2',null);
    }
    function prikaziStranicuProizvodPMeri3()
    {
        $this->prikaz('proizvodPoMeri3',null);
    }
    
    function prikaziStranicuModelOrmari()
    {
        $this->session->set('tip','Ormari');
        $this->prikaz('modeliOrmari',null);
    }
    function prikaziStranicuProizvodPoMeriOrmar1()
    {
        $this->session->set('model','Jednokrilni ormar');
        $this->prikaz('proizvodPoMeriOrmar1',null);
    }
    function prikaziStranicuProizvodPoMeriOrmar2()
    {
        $this->session->set('model','Dvokrilni ormar');
        $this->prikaz('proizvodPoMeriOrmar2',null);
    }
    
    function prikaziStranicuPorucivanjeProizvoda()
    {
        $this->prikaz('porucivanjeProizvoda',null);
    }
    function prikaziStranicuPorucivanjeGotovogProizvoda()
    {
        $this->prikaz('porucivanjeGotovogProizvoda',null);
    }
    function prikaziStranicuPlacanjePreuzimanje()
    {
        $this->prikaz('placanjePreuzimanje',null);
    }
    function prikaziStranicuUspesnaKupovina()
    {
        $this->prikaz('uspesnaKupovina',null);
    }
    //porucivanje proizvoda
    // TODO treba da se zavrsi popunjavanje ostalih tabela
    function poruci()
    {
        //dohvatamo iz forme
        $visina = $this->request->getVar('visina');
        $sirina = $this->request->getVar('sirina');
        $duzina = $this->request->getVar('duzina');
        $bojaNaziv = $this->request->getVar('boja');
        $materijalNaziv = $this->request->getVar('materijal');
        
        switch ($bojaNaziv) {
        case "color1":

            $bojaNaziv = "tamno-braon";
            break;
        case "color2":

            $bojaNaziv = "braon";
            break;
        case "color3":

            $bojaNaziv = "crna";
            break;
        case "color4":

            $bojaNaziv = "bela";
            break;

        default:
        break;
        }
        
        
        switch ($materijalNaziv) {
        case "drvo":

            $materijalNaziv = "medijapan";
            break;
        case "metal":

            $materijalNaziv = "univer aluminijum";
            break;
        case "plastika":

            $materijalNaziv = "oplemenjeni medijapan";
            break;

        default:
        break;
        }
        echo $materijalNaziv;
        echo $bojaNaziv;
                
        //modeli
        $modelNamj = new ModelNamestaja();
        $tipNamj = new TipNamestaja();
        $namestajPMeriModel = new NamestajPoMeri();
        $bojaModel = new Boja();
        $materijalModel = new Materijal();
        $narucenNamjPoMeri = new NarucenNamestajPoMeri();
        
        //dohvatanje tipa i modela iz sesije
        $idMod= $this->session->get('model');
        $idTip= $this->session->get('tip');
        $boja = $bojaModel->dohvati($bojaNaziv);
        $materijal = $materijalModel->dohvati($materijalNaziv);
        $idBoja;
        $idMaterijal;
        if($boja != null && $materijal != null)
        {
            $idBoja = $boja->IdBoj;
            $idMaterijal = $materijal->IdMat;
        }
        else
        {
            echo "Greska1";
            return;
        }
        
        $namjPoMeri = $namestajPMeriModel->dohvati($idMod);
        $idNamjPMeri;
        $dodatnaCena;
        if($namjPoMeri != null)
        {
            $idNamjPMeri = $namjPoMeri->IdNPM;
            $dodatnaCena = $namjPoMeri->DodatnaCenaUsluga;
        }
        else
        {
            echo "Greska3";
            return;
        }
        $dodatnaCena = $dodatnaCena * $visina * $sirina * $duzina;
        $this->session->set('cena',$dodatnaCena);
        $narucenNamjPoMeri->insert([
            'IdNPM' => $idNamjPMeri, 'IdMat' => $idMaterijal,
            'IdBoj' => $idBoja,'Visina' =>$visina,'Cena' =>$dodatnaCena,'Dubina' =>$duzina,'Sirina'=>$sirina,
            
        ]);
        
        $id = $namestajPMeriModel->getInsertID();
        $this->session->set('idNPM',$id);
        
        
        
        return redirect()->to(site_url('Prijavljen/prikaziStranicuPlacanjePreuzimanje'));
    }
    
    
    function plati()
    {
        $stavkaNPM = new StavkaNamestajPoMeri();
        $porudzbinaModel= new Porudzbine();
        $korisnik = $this->session->get('korisnik');
        //$IdKor = $korisnik->IdKor;
        $cena = $this->session->get('cena');
        
        $porudzbinaModel->insert([
            'Status' => 'p',
            'Opis' => 'kvalitetno',
            'IdKor' => 1,
            'Iznos' => $cena,
            'Adresa' => $this->request->getVar('adresa')
            
            
            
            
        ]);
        
        $id = $porudzbinaModel->getInsertID();
        $stavkaModel = new StavkaPorudzbine();
        $stavkaModel->insert([
            'IdPor' => $id,
             'Iznos' => $cena
            ]);
        
        /*$stavkaNPM = new StavkaNamestajPoMeri();
        $id = $this->session->get('idNPM');
        
        $stavkaNPM->insert([
            'IdNNPM' => $id    
        ]);*/
        
        return $this->prikaz('uspesnaKupovina', []);
        
        //trebalo bi uraditi dodavanje u stavka i porudzbina
    }
    
    function poruciGotov()
    {
        $gNamestajModel = new GNamestaj();
        $idMod= $this->session->get('model');
        
        $red = $gNamestajModel->where('IdMod', $idMod)->first();
        
        
        $dodatnaCena;
        if($red != null)
        {
            $idNamjPMeri = $red->IdGN;
            $dodatnaCena = $red->Cena;
        }
        else
        {
            echo "Greska3";
            return;
        }
        $dodatnaCena = $dodatnaCena;
        $this->session->set('cena',$dodatnaCena);
        
        
        
        
        
        
       return redirect()->to(site_url('Prijavljen/prikaziStranicuPlacanjePreuzimanje'));
    }

    
    
 
    //-----------------linkovi za navbar---------------------------
    
    
    
    
    
    
    //------ana prijvljen-------------------------------------------
    
    public function prikazPraznaModeli($idTipa) {
        $data['IdTipData'] = $idTipa;
        $this->session->set('tip',$idTipa);
        $this->prikaz('praznaModeli', $data);
    }
    public function prikazPraznaModeliGotovi($idTipa) {
        $data['IdTipData'] = $idTipa;
        $this->session->set('tip',$idTipa);
        $this->prikaz('praznaModeliGotovi', $data);
    }
    
    public function prikaziPraznaProizvodPoMeri($idModela) {
        $data['IdModelaData'] = $idModela;
         $this->session->set('model',$idModela);
        $this->prikaz('praznaProizvodPoMeri', $data);
    }
    
    public function prikaziPraznaMaterijal() {
        $this->prikaz('praznaMaterijal', []);
    }
    
    public function prikaziPraznaBoje() {
        $this->prikaz('praznaBoje', []);
    }
    
    function prikaziStranicuProizvodGotov($idModela)
    {
        $data['IdModelaData'] = $idModela;
         $this->session->set('model',$idModela);
        $this->prikaz('praznaGotovProizvod',$data);
    }
    //------ana prijvljen-------------------------------------------
}
