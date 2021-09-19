<?php

function specialName($offer)
{
    return null;
}


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
    if ($newColor == 'Не задано') $newColor = 'насыщенный';
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
    $color = mb_strtolower($offer['params']['Цвет']['val_']);
    if ($color == 'не задано') return null;
    if ($color == 'белый; синий') return ['белый', 'синий'];
    if ($color == 'рыжий/желтый') return ['рыжий', 'желтый'];
    if ($color == 'красный/крокодиловый узор') return ['красный', 'крокодиловый'];
    if ($color == 'белый/светло-серый') return ['белый', 'светло-серый'];
    if ($color == 'бежевый/черный') return ['бежевый', 'черный'];
    if ($color == 'красный/бордовый') return ['красный', 'бордовый'];
    if ($color == 'черный лаковый') return ['черный', 'лакированный'];
    if ($color == 'коричневый/светло-коричневый') return ['коричневый', 'светло-коричневый'];
    if ($color == 'серый/синий') return ['серый', 'синий'];
    if ($color == 'синий лак') return ['синий', 'лакированный'];
    if ($color == 'черный комб.') return 'черный';
    if ($color == 'черный/золото') return ['черный', 'золотой'];
    if ($color == 'мультицвет') return 'разноцветный';
    if ($color == 'серебристый/белый') return ['серебристый', 'белый'];
    if ($color == 'розовый/коричневый') return ['розовый', 'коричневый'];
    if ($color == 'бежевый/шампань') return ['бежевый', 'шампань'];
    if ($color == 'белый/розовый') return ['белый', 'розовый'];
    if ($color == 'черный/темно-серый') return ['черный', 'темно-серый'];
    if ($color == 'белый/черный') return ['белый', 'черный'];
    if ($color == 'бежевый/оливковый') return ['бежевый', 'оливковый'];
    if ($color == 'белый/темно-синий') return ['белый', 'темно-синий'];
    if ($color == 'белый; светло-коричневый') return ['белый', 'светло-коричневый'];
    if ($color == 'желтый/шафран') return ['желтый', 'шафрановый'];
    if ($color == 'светло-синий/голубой') return ['светло-синий', 'голубой'];
    if ($color == 'белый/сиреневый') return ['белый', 'сиреневый'];
    if ($color == 'оливковый комб.') return 'оливковый';
    if ($color == 'белый/песочный') return ['белый', 'песочный'];
    if ($color == 'песочный; бежевый') return ['песочный', 'бежевый'];
    if ($color == 'песочный комб.') return 'песочный';
    if ($color == 'коричневый комб.') return 'коричневый';
    if ($color == 'белый/цветочный') return ['белый', 'цветочный'];
    if ($color == 'черный/розовый') return ['черный', 'розовый'];
    if ($color == 'черный матовый') return ['черный', 'матовый'];
    if ($color == 'черный/красный') return ['черный', 'красный'];
    if ($color == 'розовый комб.') return 'розовый';
    if ($color == 'голубой/черный') return ['голубой', 'черный'];
    if ($color == 'пудровый/розовый') return ['пудровый', 'розовый'];
    if ($color == 'серый/голубой') return ['серый', 'голубой'];
    if ($color == 'небесный голубой') return 'небесно-голубой';
    if ($color == 'красный/белый') return ['красный', 'белый'];
    if ($color == 'фисташковый комб.') return 'фисташковый';
    if ($color == 'синий/перламутровый') return ['синий', 'перламутровый'];
    if ($color == 'бежевый/пудровый') return ['бежевый', 'пудровый'];
    if ($color == 'бежевый комб.') return 'бежевый';
    if ($color == 'синий комб.') return 'синий';
    if ($color == 'белый/синий') return ['белый', 'синий'];
    if ($color == 'белый/серебристый') return ['белый', 'серебристый'];
    if ($color == 'черный/белый') return ['черный', 'белый'];
    if ($color == 'коричневый/золотой') return ['коричневый', 'золотой'];
    if ($color == 'бело?зелёный') return ['белый', 'зеленый'];
    if ($color == 'пихтовый зелёный') return ['пихтовый', 'зелёный'];
    if ($color == 'голубой комб.') return 'голубой';
    if ($color == 'черный/крокодиловый рисунок') return ['черный', 'крокодиловый'];
    if ($color == 'белый/золотистый') return ['белый', 'золотистый'];
    if ($color == 'белый/голубой') return ['белый', 'голубой'];
    if ($color == 'медный/металлик') return ['медный', 'металлик'];
    if ($color == 'белый/фисташковый') return ['белый', 'фисташковый'];
    if ($color == 'коричневый; крокодиловый узор') return ['коричневый', 'крокодиловый'];
    if ($color == 'ореховый замша') return 'ореховый';
    if ($color == 'голубой/серебряный') return ['голубой', 'серебряный'];
    if ($color == 'синий/золотой') return ['синий', 'золотой'];
    if ($color == 'коричневый/махагон') return ['коричневый', 'махагон'];
    if ($color == 'белый/золотой') return ['белый', 'золотой'];
    if ($color == 'светло-розовый-лак') return ['светло-розовый', 'лакированный'];
    if ($color == 'красный-лак') return ['красный', 'лакированный'];
    if ($color == 'синий комбинированный') return 'синий';
    if ($color == 'черный; белый') return ['черный', 'белый'];
    if ($color == 'синий; в полоску') return 'синий';
    if ($color == 'мультиколор') return 'разноцветный';
    if ($color == 'коричневый/крокодиловый узор') return ['коричневый', 'крокодиловый'];
    if ($color == 'красный; в полоску') return 'красный';
    if ($color == 'кремовый лак') return ['кремовый', 'лакированный'];
    if ($color == 'темно-коричневый/змеиный узор') return ['темно-коричневый', 'змеиный'];
    if ($color == 'зеленый/черный') return ['зеленый', 'черный'];
    if ($color == 'красный/синий') return ['красный', 'синий'];
    if ($color == 'бежевый лак') return ['бежевый', 'лакированный'];
    if ($color == 'черный/коричневый') return ['черный', 'коричневый'];
    if ($color == 'белый комб.') return 'белый';
    if ($color == 'белый/коричневый') return ['белый', 'коричневый'];
    if ($color == 'черный/жемчуг') return ['черный', 'жемчужный'];
    if ($color == 'черный/серебристый') return ['черный', 'серебристый'];
    if ($color == 'пудровый/черный') return ['пудровый', 'черный'];
    if ($color == 'коралловый комб.') return 'коралловый';
    if ($color == 'белый/кремовый') return ['белый', 'кремовый'];
    if ($color == 'серый/бронзовый') return ['серый', 'бронзовый'];
    if ($color == 'красный лак') return ['красный', 'лакированный'];
    if ($color == 'белый/красный') return ['белый', 'красный'];
    if ($color == 'бронзово-коричневый') return ['бронзовый', 'коричневый'];
    if ($color == 'серо-голубой') return ['серый', 'голубой'];
    if ($color == 'сине-коричневый') return ['серый', 'голубой'];
    if ($color == 'красно-коричневый') return ['красный', 'коричневый'];
    if ($color == 'шафран') return 'шафрановый';
    if ($color == 'зеленый неон') return ['зеленый', 'неоновый'];
    if ($color == 'розовато-лиловый') return ['розовый', 'лиловый'];
    if ($color == 'серо-коричневый') return ['серый', 'коричневый'];
    if ($color == 'синяя замша') return 'синий';
    if ($color == 'бежево-серый') return ['бежевый', 'серый'];
    if ($color == 'коньяк') return 'коньячный';
    if ($color == 'белый/красный') return ['белый', 'красный'];
    
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
  $text = $name .' от бренда Tamaris. Артикул модели - ' . newArticle($offer) . '. Цвет ' . colorDesc($offer) . ', а дизайн разработан специально для девушек и женщин. ' . category($offer)[0] . ' в каталоге по цене распродажи, учитывая скидку. Обратите внимание, что в нашем интернет-магазине можно купить с доставкой по Москве и России. К тому же, можно оформить самовывоз из магазина. ' . countryDesc($offer);
  return $text;
}