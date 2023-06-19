<?php

namespace App\Controllers;

use CodeIgniter\Test\ControllerTester;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Config\Factories;

use App\Models\SlikaGotovNamestaj;
use App\Models\TipNamestaja;
use App\Models\ModelNamestaja;

class PrijavljenControllerTest extends CIUnitTestCase
{
	use ControllerTester;

        
        
	/**
	 * The seed file(s) used for all tests within this test case.
	 * Should be fully-namespaced or relative to $basePath
	 *
	 * @var string|array
	 */
	protected $seed = 'Tests\Support\Database\Seeds\PrijavljenSeeder';
        
        //Recenzije
        
        //test za postavljanje recenzija- fali komentar
        public function testPostaviRecenziju1() {
                       
            $results = $this->controller('\App\Controllers\Prijavljen')
                ->execute("postaviRecenziju");
            $this->assertTrue($results->see('Niste ostavili komentar!'));
        }
        
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
        
        //postavljanje pitanja neuspesno
        public function testPostaviPitanje1() {           
            $results = $this->controller('\App\Controllers\Prijavljen')
                ->execute("postaviPitanje");
            $this->assertTrue($results->see('Unesite pitanje'));
        }
        
        //postavi pitanje- uspesno
        public function testPostaviPitanje2() {
            $_REQUEST['pitanje']="Koje su cene medijapana?";
            $results = $this->controller('\App\Controllers\Prijavljen')
                ->execute("postaviPitanje");
            $this->assertTrue($results->see('uspesno'));
        }
        
        //test za logout
        public function testLogout() {
            $results = $this->controller('\App\Controllers\Prijavljen')
                ->execute("logout");
            $this->assertFalse($results->see('Odjavi se'));
        }
        
        
        
        
        
        
        
        
        
}