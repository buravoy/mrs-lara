<?php

// (Рабочая) Получаем артикул для описания
function newArticle($offer) {
  if (isset($offer['vendorCode'])) {
    $newArticle = $offer['vendorCode'];
    if (strpos($newArticle, '/')) $newArticle = explode('/', $newArticle)[0];
    if (strpos($newArticle, ' ')) $newArticle = explode(' ', $newArticle)[0];
    return $newArticle;
  } else return null;
}

// (Рабочая) Получаем цвет для описания
function colorDesc($offer) {
  if (isset($offer['params']['Цвет']['val_'])) {
    $newColor = $offer['params']['Цвет']['val_'];
    if ($newColor == 'Не задано') $newColor = 'не указан';
    return $newColor;
  } else return null;
}

// (Рабочая) Получаем страну для описания
function countryDesc($offer) {
  if (isset($offer['country_of_origin'])) {
    $country = $offer['country_of_origin'];
    return 'Стоит отметить, что страна изготовления этой модели - ' . $country . '.';
  } else return null;
}  

function category($offer) {
  if (isset($offer['name'])) {
  $haystack = mb_strtolower($offer['name']);
  if (strstr($haystack, 'балетки')) return ['Женские балетки', 'Балетки'];
  if (strstr($haystack, 'берет')) return ['Женские береты', 'Береты'];
  if (strstr($haystack, 'бизнес сумка')) return ['Женские бизнес сумки', 'Бизнес сумки'];
  if (strstr($haystack, 'ботинки')) return ['Женские ботинки', 'Ботинки'];
  if (strstr($haystack, 'полустельки')) return ['Женские полустельки для обуви', 'Полустельки для обуви'];
  if (strstr($haystack, 'термо-стельки')) return ['Женские термостельки для обуви', 'Термостельки для обуви'];
  if (strstr($haystack, 'гелевые стельки')) return ['Женские гелевые стельки для обуви', 'Гелевые стельки для обуви'];
  if (strstr($haystack, 'кожаные стельки')) return ['Женские кожаные стельки для обуви', 'Кожаные стельки для обуви'];
  if (strstr($haystack, 'ортопедические стельки')) return ['Женские ортопедические стельки для обуви', 'Ортопедические стельки для обуви'];
  if (strstr($haystack, 'стельки из мериносовой шерсти')) return ['Женские шерстяные стельки для обуви', 'Шерстяные стельки для обуви'];
  if (strstr($haystack, 'универсальные шерстяные стельки')) return ['Женские шерстяные стельки для обуви', 'Шерстяные стельки для обуви'];
  if (strstr($haystack, 'стельки')) return ['Женские стельки для обуви', 'Стельки для обуви'];
  if (strstr($haystack, 'дорожная косметичка')) return ['Женские дорожные косметички', 'Дорожные косметички'];
  if (strstr($haystack, 'зонт автомат')) return ['Женские складные зонты', 'Складные зонты'];
  if (strstr($haystack, 'кепи')) return ['Женские кепки', 'Кепки'];
  if (strstr($haystack, 'кепка')) return ['Женские кепки', 'Кепки'];
  if (strstr($haystack, 'клатч')) return ['Женские клатчи', 'Клатчи'];
  if (strstr($haystack, 'косметичка')) return ['Женские косметички', 'Косметички'];
  if (strstr($haystack, 'кошелек')) return ['Женские кошельки', 'Кошельки'];
  if (strstr($haystack, 'лодочки')) return ['Женские лодочки', 'Лодочки'];
  if (strstr($haystack, 'мягкий ластик для сухой чистки обуви')) return ['Средства по уходу за обувью'];
  if (strstr($haystack, 'панама')) return ['Женские панамы', 'Панамы'];
  if (strstr($haystack, 'повязка на голову')) return ['Женские повязки на голову', 'Повязки на голову'];
  if (strstr($haystack, 'полусапоги')) return ['Женские полусапоги', 'Полусапоги'];
  if (strstr($haystack, 'ремень')) return ['Женские ремни', 'Ремни'];
  if (strstr($haystack, 'рюкзак')) return ['Женские рюкзаки', 'Рюкзаки'];
  if (strstr($haystack, 'сапоги')) return ['Женские сапоги', 'Сапоги'];
  if (strstr($haystack, 'сумка для ноутбука')) return ['Женские сумки для ноутбуков', 'Сумки для ноутбуков'];
  if (strstr($haystack, 'сумка для телефона')) return ['Женские сумки для телефонов', 'Сумки для телефонов'];
  if (strstr($haystack, 'дорожная сумка')) return ['Женские дорожные сумки', 'Дорожные сумки'];
  if (strstr($haystack, 'сумка дорожная')) return ['Женские дорожные сумки', 'Дорожные сумки'];
  if (strstr($haystack, 'сумка на замке')) return ['Женские сумки', 'Сумки'];
  if (strstr($haystack, 'сумка на клапане')) return ['Женские сумки', 'Сумки'];
  if (strstr($haystack, 'сумка на короткой ручке')) return ['Женские сумки', 'Сумки'];
  if (strstr($haystack, 'сумка на шнуровке')) return ['Женские сумки', 'Сумки'];
  if (strstr($haystack, 'сумка пауч')) return ['Женские сумки', 'Сумки'];
  // Первая буква анлийская (опечатка в оффере Tamaris)
  if (strstr($haystack, 'cумка поясная')) return ['Женские поясные сумки', 'Поясные сумки'];
  // Первая буква анлийская (опечатка в оффере Tamaris)
  if (strstr($haystack, 'cумка через плечо')) return ['Женские сумки через плечо', 'Сумки через плечо'];
  if (strstr($haystack, 'сумка шоппер')) return ['Женские сумки-шоперы', 'Сумки-шоперы'];
  if (strstr($haystack, 'сумка')) return ['Женские сумки', 'Сумки'];
  if (strstr($haystack, 'туфли летние открытые')) return ['Женские открытые туфли', 'Открытые туфли'];
  if (strstr($haystack, 'туфли')) return ['Женские туфли', 'Туфли'];
  if (strstr($haystack, 'чемодан')) return ['Женские чемоданы', 'Чемоданы'];
  if (strstr($haystack, 'шапка вязаная')) return ['Женские вязаные шапки', 'Вязаные шапки'];
  if (strstr($haystack, 'шарф')) return ['женские шарфы', 'Шарфы'];
  if (strstr($haystack, 'шляпа')) return ['Женские шляпы', 'Шляпы'];

  return ['Ошибки Tamaris'];
  }
  return null;
}

function name($offer) {
  if (isset($offer['vendorCode'])) {
    $prefixCode = $offer['vendorCode'];
    if (strpos($prefixCode, '/')) $prefixCode = explode('/', $prefixCode)[0];
    if (strpos($prefixCode, ' ')) $prefixCode = explode(' ', $prefixCode)[0];
  } else $prefixCode = null;
  if (isset($offer['name'])) {
    $prefixName = $offer['name'];
    if (strpos($prefixName, ', р. ')) $prefixName = explode(', р. ', $prefixName)[0];
  } else $prefixName = 'Товар';
  
  return $prefixName . ' ' . 'Tamaris' . ' ' . $prefixCode;
}

function price($offer) {
  return $offer['price'];
}

function oldprice($offer) {
  return $offer['oldprice'] ?? null;
}

function image($offer) {
  return $offer['picture'];
}

function href($offer) {
  return $offer['url'];
}

function brend($offer) {
  return 'Tamaris';
}

function vozrast($offer) {
  return 'Для взрослых';
}

function pol($offer) {
  return 'Для женщин';
}

function uniq($offer) {
  $prefix = $offer['vendorCode'];
  if (strpos($prefix, '/')) $prefix = explode('/', $prefix)[0];
  if (strpos($prefix, ' ')) $prefix = explode(' ', $prefix)[0];
  return $prefix;
}

function magazin($offer) {
  return 'Tamaris';
}

function country($offer) {
  if (isset($offer['country_of_origin'])) {
    $country = $offer['country_of_origin'];
    if ($country == 'Китай') return 'Китай';
    if ($country == 'Республика Индия') return 'Индия';
    if ($country == 'Германия') return 'Германия';
    if ($country == 'Болгария') return 'Болгария';
    if ($country == 'Вьетнам') return 'Вьетнам';
    if ($country == 'Бангладеш') return 'Бангладеш';
    if ($country == 'Португальская Республика') return 'Португалия';
    if ($country == 'Мьянма') return 'Мьянма';
    if ($country == 'Мьянма') return 'Мьянма';
    if ($country == 'Румыния') return 'Румыния';
    if ($country == 'Албания') return 'Албания';
    if ($country == 'Камбоджа') return 'Камбоджа';
    if ($country == 'Индонезия') return 'Индонезия';
    if ($country == 'Турция') return 'Турция';
    if ($country == 'Тунис') return 'Тунис';
    if ($country == 'Босния и Герцеговина') return 'Босния и Герцеговина';
    return $country;
  }
  return null;
}

function cvet($offer) {
  if (isset($offer['params']['Цвет']['val_'])) {
    $color = $offer['params']['Цвет']['val_'];
    if ($color == 'Не задано') return null;
    if ($color == 'Белый; синий') return ['Белый', 'Синий'];
    if ($color == 'Рыжий/желтый') return ['Рыжий', 'Желтый'];
    if ($color == 'Красный/крокодиловый узор') return ['Красный', 'Крокодиловый'];
    if ($color == 'Белый/светло-серый') return ['Белый', 'Светло-серый'];
    if ($color == 'Бежевый/черный') return ['Бежевый', 'Черный'];
    if ($color == 'Красный/бордовый') return ['Красный', 'Бордовый'];
    if ($color == 'Черный лаковый') return ['Черный', 'Лакированный'];
    if ($color == 'Коричневый/светло-коричневый') return ['Коричневый', 'Светло-коричневый'];
    if ($color == 'Серый/синий') return ['Серый', 'Синий'];
    if ($color == 'Синий лак') return ['Синий', 'Лакированный'];
    if ($color == 'Черный комб.') return 'Черный';
    if ($color == 'Черный/золото') return ['Черный', 'Золотой'];
    if ($color == 'Мультицвет') return 'Разноцветный';
    if ($color == 'Серебристый/белый') return ['Серебристый', 'Белый'];
    if ($color == 'Розовый/коричневый') return ['Розовый', 'Коричневый'];
    if ($color == 'Бежевый/шампань') return ['Бежевый', 'Шампань'];
    if ($color == 'Белый/розовый') return ['Белый', 'Розовый'];
    if ($color == 'Черный/темно-серый') return ['Черный', 'Темно-серый'];
    if ($color == 'Белый/черный') return ['Белый', 'Черный'];
    if ($color == 'Бежевый/оливковый') return ['Бежевый', 'Оливковый'];
    if ($color == 'Белый/темно-синий') return ['Белый', 'Темно-синий'];
    if ($color == 'Белый; светло-коричневый') return ['Белый', 'Светло-коричневый'];
    if ($color == 'Желтый/шафран') return ['Желтый', 'Шафран'];
    if ($color == 'Светло-синий/голубой') return ['Светло-синий', 'Голубой'];
    if ($color == 'Белый/сиреневый') return ['Белый', 'Сиреневый'];
    if ($color == 'Оливковый комб.') return 'Оливковый';
    if ($color == 'Белый/песочный') return ['Белый', 'Песочный'];
    if ($color == 'Песочный; бежевый') return ['Песочный', 'Бежевый'];
    if ($color == 'Песочный комб.') return 'Песочный';
    if ($color == 'Коричневый комб.') return 'Коричневый';
    if ($color == 'Белый/цветочный') return ['Белый', 'Цветочный'];
    if ($color == 'Черный/розовый') return ['Черный', 'Розовый'];
    if ($color == 'Черный матовый') return ['Черный', 'Матовый'];
    if ($color == 'Черный/красный') return ['Черный', 'Красный'];
    if ($color == 'Розовый комб.') return 'Розовый';
    if ($color == 'Голубой/черный') return ['Голубой', 'Черный'];
    if ($color == 'Пудровый/розовый') return ['Пудровый', 'Розовый'];
    if ($color == 'Серый/голубой') return ['Серый', 'Голубой'];
    if ($color == 'Небесный голубой') return 'Небесно-голубой';
    if ($color == 'Красный/белый') return ['Красный', 'Белый'];
    if ($color == 'Фисташковый комб.') return 'Фисташковый';
    if ($color == 'Синий/перламутровый') return ['Синий', 'Перламутровый'];
    if ($color == 'Бежевый/пудровый') return ['Бежевый', 'Пудровый'];
    if ($color == 'Бежевый комб.') return 'Бежевый';
    if ($color == 'Синий комб.') return 'Синий';
    if ($color == 'Белый/синий') return ['Белый', 'Синий'];
    if ($color == 'Белый/серебристый') return ['Белый', 'Серебристый'];
    if ($color == 'Черный/белый') return ['Черный', 'Белый'];
    if ($color == 'Коричневый/золотой') return ['Коричневый', 'Золотой'];
    if ($color == 'Бело?зелёный') return ['Белый', 'Зеленый'];
    if ($color == 'Пихтовый зелёный') return ['Пихтовый', 'Зелёный'];
    if ($color == 'Голубой комб.') return 'Голубой';
    if ($color == 'Черный/крокодиловый рисунок') return ['Черный', 'Крокодиловый'];
    if ($color == 'Белый/золотистый') return ['Белый', 'Золотистый'];
    if ($color == 'Белый/голубой') return ['Белый', 'Голубой'];
    if ($color == 'Медный/металлик') return ['Медный', 'Металлик'];
    if ($color == 'Белый/фисташковый') return ['Белый', 'Фисташковый'];
    if ($color == 'Коричневый; крокодиловый узор') return ['Коричневый', 'Крокодиловый'];
    if ($color == 'Ореховый замша') return 'Ореховый';
    if ($color == 'Голубой/серебряный') return ['Голубой', 'Серебряный'];
    if ($color == 'Синий/золотой') return ['Синий', 'Золотой'];
    if ($color == 'Коричневый/махагон') return ['Коричневый', 'Махагон'];
    if ($color == 'Белый/золотой') return ['Белый', 'Золотой'];
    if ($color == 'Светло-розовый-лак') return ['Светло-розовый', 'Лакированный'];
    if ($color == 'Красный-лак') return ['Красный', 'Лакированный'];
    if ($color == 'Синий комбинированный') return 'Синий';
    if ($color == 'Черный; белый') return ['Черный', 'Белый'];
    if ($color == 'Синий; в полоску') return 'Синий';
    if ($color == 'Мультиколор') return 'Разноцветный';
    if ($color == 'Коричневый/крокодиловый узор') return ['Коричневый', 'Крокодиловый'];
    if ($color == 'Красный; в полоску') return 'Красный';
    if ($color == 'Кремовый лак') return ['Кремовый', 'Лакированный'];
    if ($color == 'Темно-коричневый/змеиный узор') return ['Темно-коричневый', 'Змеиный'];
    if ($color == 'Зеленый/черный') return ['Зеленый', 'Черный'];
    if ($color == 'Красный/синий') return ['Красный', 'Синий'];
    if ($color == 'Бежевый лак') return ['Бежевый', 'Лакированный'];
    if ($color == 'Черный/коричневый') return ['Черный', 'Коричневый'];
    if ($color == 'Белый комб.') return 'Белый';
    if ($color == 'Белый/коричневый') return ['Белый', 'Коричневый'];
    if ($color == 'Черный/жемчуг') return ['Черный', 'Жемчужный'];
    if ($color == 'Черный/серебристый') return ['Черный', 'Серебристый'];
    if ($color == 'Пудровый/черный') return ['Пудровый', 'Черный'];
    if ($color == 'Коралловый комб.') return 'Коралловый';
    if ($color == 'Белый/кремовый') return ['Белый', 'Кремовый'];
    if ($color == 'Серый/бронзовый') return ['Серый', 'Бронзовый'];
    if ($color == 'Красный лак') return ['Красный', 'Лакированный'];
    
    return $color;
  }
  return null;
}

function descFirst($offer) {
  $text = 'Модель ' . newArticle($offer) . ' от Tamaris. Купить в интернет-магазине с доставкой. ' . category($offer)[0] . ' по низкой цене.';
  return $text;
}


function descSecond($offer) {
  if (isset($offer['name'])) {
    $name = $offer['name'];
  } else $name = 'Товар';
  $text = $name .' от бренда Tamaris. Артикул модели - ' . newArticle($offer) . ', цвет ' . colorDesc($offer) . ', дизайн разработан специально для девушек и женщин. В этом каталоге цена указана уже со скидкой. Обратите внимание, что в нашем интернет-магазине можно купить с доставкой по Москве и России, либо самовывозом из магазина. ' . countryDesc($offer);
  return $text;
}