<?php

function getPrice($priceDecimal)
{
        // dd(floatval($price));

        $price= floatval($priceDecimal)/100;
       return number_format($price,2,',',' ').' €';
}
