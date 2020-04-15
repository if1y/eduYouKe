<?php 

return [
    'use_sandbox' => true, // 是否使用沙盒模式

    'app_id'    => '2016081600256429',
    'sign_type' => 'RSA2', // RSA  RSA2


    // 支付宝公钥字符串
    'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAlxR2adyzlwLN3OPkkd2a1sc9o9x6kWYEwf61aq7+w21SGwfQ9TdqLhe815gXqDzKI1xlkysW8nYNOWR+HJAZq0DvGp/PXkbXDH6aMS+IhFt5FT0ynaOq1fdWc6tEQEzUiaXVr67NbhzlBN8eDBqJr6KhxSHRXdRr/Ytv91sRJZXILfKQ2ymCAwRxQPwpdeXOnYss5bs83UWWQQoHrliwENzcc8YB9BpI7KJRnF9f1nthxcLsqwnjhAJwyfibfGqY3+Ae7D+kQKW2aaAewSvqI9zcVZWNMhL3uO+lXmzIHqSvf+cSGZXN9w/WsOOtpk9l6G2lsttjaJh6OungoVU7HwIDAQAB',

    // 自己生成的密钥字符串
    'rsa_private_key' => 'MIIEpgIBAAKCAQEApf/SVIjc5hO7sZcZF7eVD/MAK/lJFLQlNWLTrlJyYt8IoIrVMK5V4gijQJthmZKu5marXJ9+1pCzRmQic0byFkhecKuFPmqUAufg43MXJAWfV9RewsohzpwMQ2Pn5k9axlmFuBP5t4FGzegAIyqFK2oUwzkUm0MAdZKzXr4NAqj9wL5oAzLj71DmW3g8g1u5VV3LdLaf+71DSnz+0uA/bHKhACfLBOWoS5kJoZ9VymdgjK2kpMwYM2CTwBgK+hW8w28Yk4cnlaNU1u5DbKF+dF9IGHcnriPvAgdtQiiTWdqr7Wops1r+7o3iLr/S9DgG0ixfv77bLau2SrSLTMvmIQIDAQABAoIBAQCdCGXDfHlj2bUMKgEd05harykxcDB3OnecijHvzaTR7WVu4gcNd05ddohhPNxWeFGmOefPxj4p4lcFtwJ0BOBMvgdBFLEGu7HrEcpHwH9an0r+vjMqmCblGe/r7F3bHKSl0NhTq+nmc5A0h01h9v5ldIPRrnTU78xGbRHsBWOvZ/o2t0ySTklh/LLGmuyE9PYu143FGWVlFquQxSLX5yk5jKKS3JbiXPd+/6EuGWRmuevp9gNuBW9wfW49wXWhbegIMUahNMzUrwuL018Rbe6uY8NYjq+siNinef6GB0/bV6E/fmCaRF80nFtGKBSlFbhpzxaOPZYII0gCkABjXEY1AoGBAPwiI9TIlfVwnhbcSH55JNpZTsQlebeg2zej6HNp0krloOVyGyiCWEHM49+c05ZmuIMpbL5722eXafXB7L4hvUp5gkDGnzpNkNSWu1CYbY5xQXY9M9WPqyCUVxm5w6yI3X64WKnGni4N0afHt2PypmkeuOszjwjd0h82vmc1Y5xHAoGBAKiLhk7CeT1lKKn3CNk9WUiR45QH8z6FllVVxK49gwGI8CohKSxIML2xLLRlAS+iQZDFMe/vBR+gyW2OYkEo6r9SxMpHgVYBT2TREs6anuiyrmwjyeZWP1bMlYgeU8Yn0yBNjVfeWOg+yeE98hQqnbIzT4NO6ZxvUUq2bRNRJuZXAoGBAIeSN+AHRxLlTiwOoHBY5Wb+1GqFmBATzyv411mPkgKxvDUDiPTcOWaQLAslwWPCsf3cvVsjMBNgiBob/xcw/x5XfaEk66Mm5/RXZDru6yHHZiKUwBVaHfLzsG3lxAA2y5qCtzH62Tz8MzpbGhIE/FPTsCzP2V40H/KmtfS68WerAoGBAJKmK+tVfOY1oYcZgeJ7Zbcl8Q05SaVp2J9RbDtrHBT20Hjnt4pnGbnDcjFX/Qs0M7ZCTiwFHcEiRoEDtWwarP5hhwa15swtgaYn4CRSFthDuE4xaZf4DU553dW9BYlR13qw373HojYZg9Bu9LYlSmbmDFYlEFDj7qiCSC/ZmW4rAoGBAI6yilrRQqzt3c9S8bUvulPOxWlth3plWcPj3VgKc1e1vY18wl12mjP9tJDur+Lkk7ii70ZH0xdnMkw/UXD5JJT9OwPYdbkTjVUvUzi7pyVcDhi+YOSWebUKHts4j+ePYsuA5+nvHQ4v7ptHssT6IV586fix76Mi+m77q+sEHIcn',

    'limit_pay' => [
        //'balance',// 余额
        //'moneyFund',// 余额宝
        //'debitCardExpress',//     借记卡快捷
        //'creditCard',//信用卡
        //'creditCardExpress',// 信用卡快捷
        //'creditCardCartoon',//信用卡卡通
        //'credit_group',// 信用支付类型（包含信用卡卡通、信用卡快捷、花呗、花呗分期）
    ], // 用户不可用指定渠道支付当有多个渠道时用“,”分隔

    // 与业务相关参数
    'notify_url' => 'http://dayutalk.cn/notify/ali',
    'return_url' => 'http://dayutalk.cn',

    'fee_type' => 'CNY', // 货币类型  当前仅支持该字段
];

