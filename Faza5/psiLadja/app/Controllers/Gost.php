<?php

namespace App\Controllers;
use App\Models\Korisnik;
use App\Models\Recenzija;

class Gost extends BaseController
{
   protected function prikaz($page, $data) {
        $data['controller']='Gost';
        echo view ("prototip/$page", $data);
    }
    public function index(){
        //$this->session->destroy();
        $this->prikaz("pocetna", null);
    }
    
    public function login($puruka=null){
        $this->prikaz('prijava', ['poruka'=>$puruka]);
    }
    
    public function prikaziRecenzijuPre() {
        $this->prikaz('dodajRecenziju', []);
    }
    
    public function postaviRecenziju(){
        $this->prikaz("greska", null);
    }
    
    public function pregledRecenzija() {
        $recenzijaModel = new Recenzija();
        $recenzije = $recenzijaModel()->findAll();
    }
    
    
    public function loginSubmit(){
        if(!$this->validate(['KorisnickoIme'=>'required', 'Lozinka'=>'required']))
            return $this->login("Niste uneli sve podatke");
        $korisnik=new Korisnik();
        $korisnik=$korisnik->dohvati($this->request->getVar('KorisnickoIme'));
        if($korisnik==null)
            return $this->login("Korisnik ne postoji");
        if($korisnik->Lozinka!=$this->request->getVar('Lozinka'))
            return $this->login('Pogresna lozinka');
        if($korisnik->Flag==0){
        $this->session->set('korisnik', $korisnik);
        return redirect()->to(site_url('Prijavljen/index'));
        }
        if($korisnik->Flag==1){
        $this->session->set('moderator', $korisnik);
        unset($_SESSION['korisnik']);
        return redirect()->to(site_url('Moderator/index'));
        }
        if($korisnik->Flag==2){
        $this->session->set('administrator', $korisnik);
        unset($_SESSION['korisnik']);
        unset($_SESSION['moderator']);
        return redirect()->to(site_url('Administrator/index'));
        }
    }
    
    public function registracija($poruka=null){
        $this->prikaz("registracija", $poruka);
    }
    
    public function register(){
        $username = $this->request->getPost('KorisnickoIme');
        $password = $this->request->getPost('Lozinka');
        $confirmPassword = $this->request->getPost('LozinkaPotvrda');
        $firstName = $this->request->getPost('Ime');
        $lastName = $this->request->getPost('Prezime');
        $email = $this->request->getPost('Mejl');

        if (empty($username) || empty($password) || empty($confirmPassword) || empty($firstName) || empty($lastName) || empty($email)) {
            return $this->registracija("Niste popunili sva polja!");
        }

        if ($password !== $confirmPassword) {
            return $this->registracija("Lozinke se ne podudaraju!");
        }
        $korisnik = new Korisnik();
        $postoji = $korisnik->dohvati($username);
        if ($postoji!=null) {
            return $this->registracija("Korisnicko ime je vec zauzeto!");
        }
        $data = [
            'KorisnickoIme' => $username,
            'Lozinka' => $password,
            'Ime' => $firstName,
            'Prezime' => $lastName,
            'Mejl' => $email,
            'Flag' =>0
        ];
        $korisnik->insert($data);
        $this->session->set('korisnik', $korisnik);
        unset($_SESSION['moderator']);
        unset($_SESSION['administrator']);
        return redirect()->to(site_url('Prijavljen/index'));
    
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
        $this->prikaz('modeli',null);
    }
    function prikaziStranicuProizvodPMeri()
    {
        $this->prikaz('proizvodPoMeriGost',null);
    }
    function prikaziStranicuProizvodPMeri2()
    {
        $this->prikaz('proizvodPoMeriGost2',null);
    }
    function prikaziStranicuProizvodPMeri3()
    {
        $this->prikaz('proizvodPoMeriGost3',null);
    }
    function prikaziStranicuModelOrmari()
    {
        $this->prikaz('modeliOrmari',null);
    }
    function prikaziStranicuProizvodPoMeriOrmar1()
    {
        $this->prikaz('proizvodPoMeriOrmarGost1',null);
    }
    function prikaziStranicuProizvodPoMeriOrmar2()
    {
        $this->prikaz('proizvodPoMeriOrmarGost2',null);
    }

    //-----------------linkovi za navbar---------------------------
    
    
    //------ana gost-------------------------------------------
    
   
    
    
    //------ana gost-------------------------------------------
    
    
    public function prikaziRegistraciju() {
        $this->prikaz('registracija', null);
    }
    
    public function prikaziPrijavu() {
        $this->prikaz('prijava', null);
    }
    
    
    // prikazi stranica za gosta proizvodi i modeli
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
        $this->prikaz('praznaProizvodPoMeriGost', $data);
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
        $this->prikaz('praznaGotovProizvodGost',$data);
    }
     
}
