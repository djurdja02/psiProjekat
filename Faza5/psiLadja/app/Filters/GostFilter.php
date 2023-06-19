<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class GostFilter implements FilterInterface
{
    public function before(RequestInterface $request,$arguments = null)
    {
        $session=session();
        if($session->has('korisnik'))
            return redirect()->to(site_url('Prijavljen'));
         if($session->has('moderator'))
            return redirect()->to(site_url('Moderator'));
         if($session->has('administrator'))
            return redirect()->to(site_url('Administrator'));
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response,$arguments = null)
    {
        // Do something here
    }
}