<?php

namespace App\Utils;

class Utils
{
    /**
     * Generate a random alphanumeric coupon code.
     *
     * @param int $length The length of the coupon code. Default is 10.
     * @return string The generated coupon code.
     */
    public static function generateCouponCode($length = 10): string
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $couponCode = '';

        for ($i = 0; $i < $length; $i++) {
            $couponCode .= $characters[rand(0, $charactersLength - 1)];
        }

        return $couponCode;
    }
}