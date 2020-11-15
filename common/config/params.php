<?php
/*backend*/
Yii::setAlias('@backend_theme','/backend/themes/gentella');
Yii::setAlias('@backend_layouts','@backend/themes/gentella/views/layouts/');


/*frontend*/
Yii::setAlias('@frontend_theme','/frontend/themes/vse');
Yii::setAlias('@theme_layouts','@frontend/themes/vse/views/layouts');
Yii::setAlias('@frontend_theme_img',Yii::getAlias('@frontend_theme').'/img');


//Изображения
//Категория
Yii::setAlias('@categories-bg','/common/modules/order/images');


//Профиль
Yii::setAlias('@profile-img','/common/modules/profile/images');

return [
    'adminEmail' => 'Artbele@yandex.ru',
    'supportEmail' => 'Artbele@yandex.ru',
    'senderEmail' => 'Artbele@yandex.ru',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'defaultTheme' => Yii::getAlias('@frontend_theme'),
    'defaultThemeLayout' => Yii::getAlias('@theme_layouts'),
    'categoryTitle' => 'Заказывайте всё',
    'categorySubTitle' => 'Товары и услуги',
    //Фотографии
    'categoryImg' => 'main-bg.jpg',
    'profileImg' => 'default.png',
    'categoryUrl' => '/',
    //Default
    'defaultCategoryBg' => Yii::getAlias('@categories-bg').'/main-bg.jpg',
    'swearWords' => [
        'Хуй',
        'Сука',
        'Сучка',
        'Cука',
        'Cучка',
        'Сволоч',
        'Гнида',
        'Член',
        'Коток',
        'Кутак',
        'Долбаеб',
        'Иди нахуй',
        'Писька',
        'Пизда',
        'Вагина',
        'Клитор',
        'Сгейн',
        'Скейн',
        'Жалап',
        'Джалап',
        'Fuck',
        'Шлюха',
        'Проститутка',
        'Шмара',
        'Конопля',
        'Наркотик',
        'Наркотики',
        'Ганжубас',
        'Ганджубас',
        'Кокаин',
        'Кокс',
        'Манда',
        'Эмчек',
        'Емчек',
        'Сиськи',
        'Пиписька',
        'Писька',
        'Пидарас',
        'Пидараз',
        'Педорас',
        'Пидорас',
        'Ебаный',
        'Ебанный',
        'Ебанная',
        'Ебаная',
        'Ебаное',
        'Ебанное',
        'Ебал',
        'Ебать',
        'Ебу',
        'Ебусь',
        'Гандон',
        'Мырк',
        'Чмо',
        'Лох',
        'Ебанат',
        'Ебантяй',
        'Ташак',
        'Пидораз',
        'Пидорас',
        'Пидараз',
        'Гандон',
        'Гондон',
        'Героин',
        'Гераин',
        'Пизду',
        'Жопу',
        'Жопе',
        'Ебаться',
        'Шалава',
        'Шмаль',
        'Очко',
        'pussy',
        'shit',
        'pizda',
        'gandon',
        'gondon',
        'jopa',
        'pidor',
        'suka',
        'blya',
        'kotok',
        'shluha',
        'jalap',
        'pidaraz',
        'pidoraz',
        'pedoras',
        'pidaras',
        'pidoras',
        'suka',
        'suchka',
    ],
];

