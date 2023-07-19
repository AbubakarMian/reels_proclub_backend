<?php

return [

	'status' => [
		'OK' => 200
	],

	'app-type' => [
		'android' => "khatmenabowat-app-mobile",
	],
    'request_status'=>[
        'pending'=>'pending',
        'partial'=>'partial',
        'completed'=>'completed',
        'cancelled'=>'cancelled',
    ],
    'promotion_type'=>[
        'extra_product'=>'extra_product',
        'discount_percent'=>'discount_percent',
    ],
	'social_login' => [
		'facebook'=>'facebook',
		'twitter'=>'twitter',
		'gmail'=>'gmail',
	],
    'sender' =>[
        'user'=>'user',
        'sholar'=>'scholar'
    ],

    'settings'=>[
        'shipping_terms_en_id'=>1,
        'shipping_terms_en'=>'shipping_terms',

        'shipping_terms_ar_id'=>2,
        'shipping_terms_ar'=>'shipping_terms_ar',

        'terms_and_conditions_en_id'=>3,
        'terms_and_conditions_en'=>'terms_and_conditions',

        'terms_and_conditions_ar_id'=>4,
        'terms_and_conditions_ar'=>'terms_and_conditions_ar',
    ],

    'payment_status'=>[
        'paid'=>'paid',
        'refunded'=>'refunded',
    ],

    'ajax_action'=>[
        'create'=>'create',
        'update'=>'update',
        'delete'=>'delete',
        'error'=>'error',
        'success'=>'success',
    ],
    'order_status'=>[
        'all'=>'all',
        'pending'=>'pending',
        'inprogress'=>'inprogress',
        'completed'=>'completed',
        'rejected'=>'rejected',
    ],
];
