<?php

namespace App;

class PosCart 
{
    protected $cart = [];
    // unit price of all items
    protected $unitcost = [
        'A' => 50,
        'B' => 30,
        'C' => 20,
        'D' => 15,
        'E' => 5
    ];
    // Discount price of the items
    protected $specialprice = [
        'A' => [
            'count' => 3,
            'price' => 130,
        ],
        'B' => [
            'count' => 2,
            'price' => 45,
        ],
        'C' => [
            'count' => [2,3],
            'price' => [38,50],
        ],
        'D' => [
            'count' => 'A',
            'price' => 5,
        ],
    ];

    // Add items in cart
    public function additem($item)
    {
        if (array_key_exists($item, $this->cart)) {
            $this->cart[$item]['quantity'] = $this->cart[$item]['quantity'] + 1;
        }else{
            $this->cart[$item] = [
                'item' => $item,
                'cost' => $this->unitcost[$item],
                'quantity' => 1,
            ];
        }
    }
    // caculate total price after discount
    public function total()
    {   
        $total = 0;
        foreach ($this->cart as $key => $val) {
            $total += $val['cost']*$val['quantity'];
            
        }
        
        $discountrate = 0;
        foreach ($this->specialprice as $key => $discount) {
            $discountamt = 0;
            
            if(is_array($discount['count']) == "" && ctype_alpha($discount['count'])){
                if (array_key_exists($discount['count'],$this->cart) && array_key_exists($key,$this->cart)){
                    if($this->cart[$key]['quantity'] >= $this->cart[$discount['count']]['quantity']){
                        $totalcost = $this->cart[$key]['quantity']*$this->unitcost[$key];
                        $discountamt = $totalcost - (($this->cart[$discount['count']]['quantity']*$discount['price'])+(($this->cart[$key]['quantity']-$this->cart[$discount['count']]['quantity'])*$this->unitcost[$key]));
                        $discountrate += $discountamt;
                    } 
                }
            }
           
            if(is_array($discount['count'])== "" && ctype_digit(strval($discount['count']))){
               
                if($this->cart[$key]['quantity'] >= $discount['count']){
                    $quantityset = floor($this->cart[$key]['quantity']/$discount['count']);
                    $quantitysettotalamt = ($quantityset*$discount['count'])*$this->unitcost[$key];
                    $discountamt = $quantitysettotalamt-($quantityset*$discount['price']);
                    $discountrate += $discountamt;
                }
            }
      
            if(is_array($discount['count']) == 1){
                $Check_chepest_order = [];
                $discount_price = [];
                $div_qty = 0;
                $mod_qty = 0;
                $total_price = 0;
                // calculating the cheapest combination
                $specialprice = array_combine($discount['count'],$discount['price']);
                $pd_qty = array_keys($specialprice);
                $count_of_price = count($specialprice);
              
                foreach($specialprice as $price){
                    foreach($pd_qty as $k){        
                        $discount_price[$k] = ($this->unitcost[$key]*$k)-$specialprice[$k];
                    }
                    break;
                }
                $large_dis = array_keys($discount_price,max($discount_price));
              
                if($this->cart[$key]['quantity'] >= $large_dis[0]){
                    $div_qty = intval($this->cart[$key]['quantity']/$large_dis[0])*$specialprice[$large_dis[0]];
                    $mod_qty = intval($this->cart[$key]['quantity']%$large_dis[0]);
                    if($mod_qty == 1){
                        $mod_qty = $this->unitcost[$key];
                    }else if($mod_qty == 2){
                        $mod_qty = $specialprice[$mod_qty];
                    }
                    (int)$total_price = $div_qty+$mod_qty;
                    $totalcost = $this->cart[$key]['quantity']*$this->unitcost[$key];
                    $discountamt = $totalcost - $total_price;
                    $discountrate += $discountamt;
                }
                
            }
            
            
        }
         return $total - $discountrate;
     }
}
?>
