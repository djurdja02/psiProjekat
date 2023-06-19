<?php
namespace App\Controllers;

use CodeIgniter\Test\ControllerTester;

class GostControllerTest extends \Tests\Support\DbTestCase
{
	use ControllerTester;

	/**
	 * The seed file(s) used for all tests within this test case.
	 * Should be fully-namespaced or relative to $basePath
	 *
	 * @var string|array
	 */
	protected $seed = 'Tests\Support\Database\Seeds\GostSeeder';
        public function test_When_access_news_Then_see_two_items()
	{	$observer=$this->createMock(Korisnik::class)	;
            $observer->expects($this->once())->method("update")->willReturn("koto");
		$results = $this->controller('\App\Controllers\Gost')
                ->execute("register");
		$this->assertFalse($results->see('Registruj se', 'a'));
                $this->assertFalse($results->see('Prijavi se', 'a'));
		$this->assertTrue($results->see('HOME CENTRE','p'));
	}
	
}
