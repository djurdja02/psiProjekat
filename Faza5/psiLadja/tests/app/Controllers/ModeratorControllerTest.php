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
}