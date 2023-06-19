<?php

namespace App\Controllers;

use CodeIgniter\Test\ControllerTester;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Config\Factories;

use App\Models\SlikaGotovNamestaj;
use App\Models\TipNamestaja;
use App\Models\ModelNamestaja;

class ModeratorControllerTest extends CIUnitTestCase
{
	use ControllerTester;

	/**
	 * The seed file(s) used for all tests within this test case.
	 * Should be fully-namespaced or relative to $basePath
	 *
	 * @var string|array
	 */
	protected $seed = 'Tests\Support\Database\Seeds\ModeratorSeeder';
        
        //------------------------------------------------------------------------dodaj sliku u galeriju testovi
        public function testdodajSlikuUGaleriju1() {
            $_REQUEST['slikaModela'] = '';
            $_REQUEST['flag'] = true;
            
            $results = $this->controller('\App\Controllers\Moderator')->execute("dodajSlikuUGaleriju");
            $this->assertTrue($results->see('pokusali'));
        }
        
        public function testdodajSlikuUGaleriju2() {
            $_REQUEST['slikaModela'] = 'slike/ormar.jpg';
            $_REQUEST['flag'] = true;
            
            $results = $this->controller('\App\Controllers\Moderator')->execute("dodajSlikuUGaleriju");
            $this->assertTrue($results->see('uspesno'));
        }
        
        //------------------------------------------------------------------------dodaj tip testovi
        public function testdodavanjeTipaMetodUspesno() {
            $_REQUEST['naziv'] = 'KREDENCI';
            $_REQUEST['slikaTipa'] = 'slike/ormar.jpg';
            
            $_REQUEST['flag'] = true;
            
            $results = $this->controller('\App\Controllers\Moderator')->execute("dodavanjeTipaMetod");
            $this->assertTrue($results->see('uspesno'));
        }
        
        public function testdodavanjeTipaMetodNeuspesnoPrazanUnos() {
            $_REQUEST['naziv'] = '';
            $_REQUEST['slikaTipa'] = '';
            
            $_REQUEST['flag'] = true;
            
            $results = $this->controller('\App\Controllers\Moderator')->execute("dodavanjeTipaMetod");
            $this->assertTrue($results->see('pokusali'));
        }
        
        public function testdodavanjeTipaMetodNeuspesnoVecPostojiTip() {
            $_REQUEST['naziv'] = 'STOLOVI';
            $_REQUEST['slikaTipa'] = 'slike/sofa1.jpg';
            
            $_REQUEST['flag'] = true;
            
            $results = $this->controller('\App\Controllers\Moderator')->execute("dodavanjeTipaMetod");
            $this->assertTrue($results->see('pokusali'));
        }
        
        //------------------------------------------------------------------------dodaj model testovi
        public function testdododavanjeModelaMetodUspesno() {
            $_REQUEST['naziv'] = 'ug1';
            $_REQUEST['slikaModela'] = 'slike/sofa3.jpg';
            $_REQUEST['tipModela'] = 'UGAONA GARNITURA';
            
            $_REQUEST['flag'] = true;
            
            $results = $this->controller('\App\Controllers\Moderator')->execute("dodavanjeModelaMetod");
            $this->assertTrue($results->see('uspesno'));
        }
        
        public function testdododavanjeModelaMetodNeuspesnoPrazanUnos() {
            $_REQUEST['naziv'] = '';
            $_REQUEST['slikaModela'] = '';
            $_REQUEST['tipModela'] = '';
            
            $_REQUEST['flag'] = true;
            
            $results = $this->controller('\App\Controllers\Moderator')->execute("dodavanjeModelaMetod");
            $this->assertTrue($results->see('pokusali'));
        }
        
        public function testdododavanjeModelaMetodNeuspesnoPostojiVecModel() {
            $_REQUEST['naziv'] = 'NISKI STO';
            $_REQUEST['slikaModela'] = 'slike/sto3a.jpg';
            $_REQUEST['tipModela'] = 'STOLOVI';
            
            $_REQUEST['flag'] = true;
            
            $results = $this->controller('\App\Controllers\Moderator')->execute("dodavanjeModelaMetod");
            $this->assertTrue($results->see('pokusali'));
        }
        
        public function testdododavanjeModelaMetodNeuspesnoNePostojiTip() {
            $_REQUEST['naziv'] = 'stoNema';
            $_REQUEST['slikaModela'] = 'slike/sto3a.jpg';
            $_REQUEST['tipModela'] = 'csdhbcskbcw';
            
            $_REQUEST['flag'] = true;
            
            $results = $this->controller('\App\Controllers\Moderator')->execute("dodavanjeModelaMetod");
            $this->assertTrue($results->see('pokusali'));
        }
        
       
        
        
        //----Lidija--------------------------
                
        // test za uspesan insert u bazu
        public function testDodajBoju1() {
            $_REQUEST['naziv']='zelena';
            $_REQUEST['cena']= 549;    
            $_REQUEST['slikaBoje']='slike/zelena.jpg';
            $_REQUEST['flag'] = 1;
            $_REQUEST['flag2']=1;
            
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("dodajBoju");
            $this->assertTrue($results->see('uspesno'));
            
        }
        
        //test kad nisu popunjena sva polja
        public function testDodajBoju2() {
            $_REQUEST['naziv']='tirkizna'; 
          
            $_REQUEST['flag'] = 1;
            
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("dodajBoju");
            $this->assertTrue($results->see('Niste'));
            
        }
        
        //test za negativnu cenu
        public function testDodajBojuNegativnaCena(){
            $_REQUEST['naziv']='tirkizna';
            $_REQUEST['cena']= -99;    
            $_REQUEST['slikaBoje']='slike/tirkizna.jpg';
            $_REQUEST['flag'] = 1;
            
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("dodajBoju");
            $this->assertTrue($results->see('pravilno'));
        }
        
        //test kada cena nije broj
        public function testDodajBojuCenaNijeBroj(){
            $_REQUEST['naziv']='tirkizna';
            $_REQUEST['cena']= 'lll';    
            $_REQUEST['slikaBoje']='slike/tirkizna.jpg';
            $_REQUEST['flag'] = 1;
            
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("dodajBoju");
            $this->assertTrue($results->see('pravilno'));
        }
        
         // test za uspesan insert u bazu
        public function testDodajBojuVecUBazi() {
            $_REQUEST['naziv']='braon';
            $_REQUEST['cena']= 549;    
            $_REQUEST['slikaBoje']='slike/tirkizna.jpg';
            $_REQUEST['flag'] = 1;
            
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("dodajBoju");
            $this->assertTrue($results->see('vec'));
            
        }
        
        
        //testiranje funkcionalnosti dodajMaterijal
        
        //test za materjal uspesan unos
        public function testDodajMaterijal1(){
            //'materijal'=> 'required','materijalCena' => 'required','proizvodi' =>'required','slikaMat' => 'required'
            $_REQUEST['materijal']='sirova iverica';
            $_REQUEST['materijalCena']= 5899;
            $_REQUEST['proizvodi']='1,2';
            $_REQUEST['slikaMat']='slike/sirova_iverica.webp';
            $_REQUEST['flag'] = 1;
            $_REQUEST['flag2']=1;
            
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("dodajMaterijal");
            $this->assertTrue($results->see('uspesno'));
            
        }
        
        public function testDodajMaterijal2(){
            //'materijal'=> 'required','materijalCena' => 'required','proizvodi' =>'required','slikaMat' => 'required'
            $_REQUEST['materijal']='sirova iverica';
            
            $_REQUEST['flag'] = 1;
            $_REQUEST['flag2']=1;
            
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("dodajMaterijal");
            $this->assertTrue($results->see('Niste popunili sva polja!'));
            
        }
        
        public function testDodajMaterijalCenaNegativna(){
            //'materijal'=> 'required','materijalCena' => 'required','proizvodi' =>'required','slikaMat' => 'required'
            $_REQUEST['materijal']='sirova iverica';
            $_REQUEST['materijalCena']= -900;
            $_REQUEST['proizvodi']='1,2';
            $_REQUEST['slikaMat']='slike/sirova_iverica.webp';
            $_REQUEST['flag'] = 1;
            $_REQUEST['flag2']=1;
            
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("dodajMaterijal");
            $this->assertTrue($results->see('Unesite pravilno cenu!'));
            
        }
        
        
        public function testDodajMaterijalCenaNijeBroj(){
            //'materijal'=> 'required','materijalCena' => 'required','proizvodi' =>'required','slikaMat' => 'required'
            $_REQUEST['materijal']='sirova iverica';
            $_REQUEST['materijalCena']= 'lll';
            $_REQUEST['proizvodi']='1,2';
            $_REQUEST['slikaMat']='slike/sirova_iverica.webp';
            $_REQUEST['flag'] = 1;
            $_REQUEST['flag2']=1;
            
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("dodajMaterijal");
            $this->assertTrue($results->see('Unesite pravilno cenu!'));
            
        }
        
        public function testDodajMaterijalVecUBazi() {
             $_REQUEST['materijal']='sirova iverica';
            $_REQUEST['materijalCena']= 5899;
            $_REQUEST['proizvodi']='1,2';
            $_REQUEST['slikaMat']='slike/sirova_iverica.webp';
            $_REQUEST['flag'] = 1;
            $_REQUEST['flag2']=1;
            
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("dodajMaterijal");
            $this->assertTrue($results->see('vec'));
        }
        
        public function testDodajMaterijalSamoSifre() {
             $_REQUEST['materijal']='sirova iverica3';
            $_REQUEST['materijalCena']= 5899;
            $_REQUEST['proizvodi']='l,j';
            $_REQUEST['slikaMat']='slike/sirova_iverica.webp';
            $_REQUEST['flag'] = 1;
            $_REQUEST['flag2']=1;
            
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("dodajMaterijal");
            $this->assertTrue($results->see('Unesite samo brojeve'));
        }
        
        
       //test cena nije uneta
        public function testIzmenaCene1() {
            $vrsta =['boja'];
            $_REQUEST['vrsta']=$vrsta;
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("izmeniCenu");
            $this->assertTrue($results->see('Niste'));
        }
        
        //cena negativna
         public function testIzmenaCeneNegativna() {
            $vrsta =['boja'];
            $_REQUEST['vrsta']=$vrsta;
            $_REQUEST['cena'] = -900;
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("izmeniCenu");
            $this->assertTrue($results->see('pravilno'));
        }
        
        
        //cena negativna
         public function testIzmenaCeneNijeBroj() {
            $vrsta =['boja'];
            $_REQUEST['vrsta']=$vrsta;
            $_REQUEST['cena'] = 'lll';
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("izmeniCenu");
            $this->assertTrue($results->see('pravilno'));
        }
        
        
        //test nema naziva boje
        public function testIzmenaCeneBojaNema() {
            $vrsta =['boja'];
            $_REQUEST['vrsta']=$vrsta;
            $_REQUEST['cena'] = 1299;
            
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("izmeniCenu");
            $this->assertTrue($results->see('boje'));
        }
        
        //test uspesno izmenjena boja
        public function testIzmenaCeneBoja() {
            $vrsta =['boja'];
            $_REQUEST['vrsta']=$vrsta;
            $_REQUEST['cena'] = 1299;
            $_REQUEST['nazivBoje']='braon';
            
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("izmeniCenu");
            $this->assertTrue($results->see('uspesno'));
        }
        
        //test nepostojecaBoja
        public function testIzmenaCeneBojaNepostojeca() {
            $vrsta =['boja'];
            $_REQUEST['vrsta']=$vrsta;
            $_REQUEST['cena'] = 1299;
            $_REQUEST['nazivBoje']='zlatna';
            
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("izmeniCenu");
            $this->assertTrue($results->see('Nepostojeca boja'));
        }
        
        //test naziv materijala nije unet
        public function testIzmenaCeneMaterijalaNema() {
            $vrsta =['materijal'];
            $_REQUEST['vrsta']=$vrsta;
            $_REQUEST['cena'] = 8999;
            
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("izmeniCenu");
            $this->assertTrue($results->see('materijala'));
        }
        
        //test uspesno izmenjena cena materijala
        public function testIzmenaCeneMaterijala() {
            $vrsta =['materijal'];
            $_REQUEST['vrsta']=$vrsta;
            $_REQUEST['cena'] = 1899;
            $_REQUEST['nazivMaterijala']='hrast';
            
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("izmeniCenu");
            $this->assertTrue($results->see('uspesno'));
        }
        
        //test nepostojeci materijal
        public function testIzmenaCeneMaterijalNepostojeci() {
            $vrsta =['materijal'];
            $_REQUEST['vrsta']=$vrsta;
            $_REQUEST['cena'] = 1299;
            $_REQUEST['nazivMaterijala']='bor';
            
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("izmeniCenu");
            $this->assertTrue($results->see('Nepostojeci materijal'));
        }
        
        //test naziv proizvoda nije unet
        public function testIzmenaCeneProizvodaNema() {
            $vrsta =['proizvod'];
            $_REQUEST['vrsta']=$vrsta;
            $_REQUEST['cena'] = 8999;
            
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("izmeniCenu");
            $this->assertTrue($results->see('proizvoda'));
        }
        
        //test uspesna izmena cene proizvoda
        public function testIzmenaCeneProizvoda() {
            $vrsta =['proizvod'];
            $_REQUEST['vrsta']=$vrsta;
            $_REQUEST['cena'] = 8999;
            $_REQUEST['nazivProizvoda']=1;
            
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("izmeniCenu");
            $this->assertTrue($results->see('uspesno'));
        }
        
        //test nepostojeci proizvod
         public function testIzmenaCeneProizvodNepostojeci() {
            $vrsta =['proizvod'];
            $_REQUEST['vrsta']=$vrsta;
            $_REQUEST['cena'] = 1299;
            $_REQUEST['nazivProizvoda']=899;
            
            $results = $this->controller('\App\Controllers\Moderator')
                ->execute("izmeniCenu");
            $this->assertTrue($results->see('Nepostojeci proizvod'));
        }
        
        
        //test uspesno postavljanje recenzije od strane moderatora
        //test uspesno postavljanje recenzije
        public function testPostaviRecenziju2(){
            $_POST['komentar'] = 'Vitrine su najbolje!';
            $_POST['ocena'] = 5;
            $_REQUEST['flag'] = 1;
            /*$_SESSION['korisnik'] = null;
            $_SESSION['moderator'] = null;
            $_SESSION['administrator'] = null;*/
            $results = $this->controller('\App\Controllers\Prijavljen')
                ->execute("postaviRecenziju");
            $this->assertTrue($results->see('uspesno'));
        }
        
        //test za postavljanje recenzija- fali komentar
        public function testPostaviRecenziju1() {
                       
            $results = $this->controller('\App\Controllers\Prijavljen')
                ->execute("postaviRecenziju");
            $this->assertTrue($results->see('Niste ostavili komentar!'));
        }
        
        
       //---------------------------------------------------------------------------------------------
        
        
        
        
        
        
	
}

