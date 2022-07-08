<?php
namespace Tests;

use App\PosCart;
use PHPUnit\Framework\TestCase;

class PosTest extends TestCase
{   
    // Scan items without discount
    public function test_add_items()
    {
        $poscart= new PosCart();

        $poscart->additem('A');
        $poscart->additem('B');
        $poscart->additem('C');
        $poscart->additem('E');
        $this->assertEquals(105, $poscart->total(), 'Checkout total does not equal expected value of 105');
    }
    // Scan items with discount type 1 i.e 2 for 45
    public function test_add_items_discount1()
    {
        $poscart= new PosCart();

        $poscart->additem('A');
        $poscart->additem('A');
        $poscart->additem('A');
        $poscart->additem('B');
        $poscart->additem('B');
        $poscart->additem('C');
        $poscart->additem('E');
        $this->assertEquals(200, $poscart->total(), 'Checkout total does not equal expected value of 200');
    }
     // Scan items with discount type 1 i.e with A 
     public function test_add_items_discount2()
     {
         $poscart= new PosCart();
 
         $poscart->additem('A');
         $poscart->additem('A');
         $poscart->additem('A');
         $poscart->additem('B');
         $poscart->additem('D');
         $poscart->additem('D');
         $poscart->additem('D');
         $poscart->additem('D');
         $poscart->additem('C');
         $poscart->additem('E');
         $this->assertEquals(215, $poscart->total(), 'Checkout total does not equal expected value of 215');
     }
      // Scan items with mix of all discount types 
     public function test_add_items_discount3()
     {
         $poscart= new PosCart();
         $poscart->additem('A');
         $poscart->additem('A');
         $poscart->additem('A');
         $poscart->additem('B');
         $poscart->additem('B');
         $poscart->additem('D');
         $poscart->additem('D');
         $poscart->additem('D');
         $poscart->additem('D');
         $poscart->additem('C');
         $poscart->additem('C');
         $poscart->additem('C');
         $poscart->additem('C');
         $poscart->additem('C');
         $poscart->additem('E');
         $this->assertEquals(298, $poscart->total(), 'Checkout total does not equal expected value of 298');
     }
}
?>
