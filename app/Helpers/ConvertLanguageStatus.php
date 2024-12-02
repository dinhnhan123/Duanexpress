<?php
if(!function_exists('translate')){
    function translate($key){
        $translations = [
            'public' => 'Công khai',
            'pending' => 'Chờ duyệt',
            'stocking' => 'Còn hàng',
            'out_of_stock' => 'Hết hàng',
            'processing' => 'Đang xử lý',
            'are_delivering' => 'Đang giao hàng',
            'cancelled' => 'Đã hủy',
            'complete' => 'Hoàn thành',
            'cod' => 'Thanh toán khi nhận hàng',
            'payUrl' => 'Thanh toán online'
        ];
        return $translations[$key];
    }
}

?>