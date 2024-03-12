<?php

namespace App\Repositories\Cart ;

interface CartRepository 
{
    
    public function all ();


    public function add ($item , $qty=1);
    

    public function remove ($id);

   
    public function empty ();
    

    public function total ();
}