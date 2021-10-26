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
 
  if (strstr($haystack, 'берет')) return ['женские береты', 'береты'];
  if (strstr($haystack, 'бизнес сумка')) return ['женские бизнес сумки', 'бизнес сумки'];
  if (strstr($haystack, 'ботинки')) return ['женские ботинки', 'ботинки'];
  if (strstr($haystack, 'полустельки')) return ['женские полустельки для обуви', 'полустельки для обуви'];
  if (strstr($haystack, 'термо-стельки')) return ['женские термостельки для обуви', 'термостельки для обуви'];
  if (strstr($haystack, 'гелевые стельки')) return ['женские гелевые стельки для обуви', 'гелевые стельки для обуви'];
  if (strstr($haystack, 'кожаные стельки')) return ['женские кожаные стельки для обуви', 'кожаные стельки для обуви'];
  if (strstr($haystack, 'ортопедические стельки')) return ['женские ортопедические стельки для обуви', 'ортопедические стельки для обуви'];
  if (strstr($haystack, 'стельки из мериносовой шерсти')) return ['женские шерстяные стельки для обуви', 'шерстяные стельки для обуви'];
  if (strstr($haystack, 'универсальные шерстяные стельки')) return ['женские шерстяные стельки для обуви', 'шерстяные стельки для обуви'];
  if (strstr($haystack, 'стельки')) return ['женские стельки для обуви', 'стельки для обуви'];
  if (strstr($haystack, 'дорожная косметичка')) return ['женские дорожные косметички', 'дорожные косметички'];
  if (strstr($haystack, 'зонт автомат')) return ['женские складные зонты', 'складные зонты']; //Косяк с пробелом в парсере
  if (strstr($haystack, 'кепи')) return ['женские кепки', 'кепки'];
  if (strstr($haystack, 'кепка')) return ['женские кепки', 'кепки'];
  if (strstr($haystack, 'клатч')) return ['женские клатчи', 'клатчи'];
  if (strstr($haystack, 'косметичка')) return ['женские косметички', 'косметички'];
  if (strstr($haystack, 'кошелек')) return ['женские кошельки', 'кошельки'];
  if (strstr($haystack, 'лодочки')) return ['женские лодочки', 'лодочки'];
  if (strstr($haystack, 'мягкий ластик для сухой чистки обуви')) return ['средства по уходу за обувью'];
  if (strstr($haystack, 'ластик для чистки обуви')) return ['средства по уходу за обувью'];
  if (strstr($haystack, 'панама')) return ['женские панамы', 'панамы'];
  if (strstr($haystack, 'повязка на голову')) return ['женские повязки на голову', 'повязки на голову'];
  if (strstr($haystack, 'полусапоги')) return ['женские полусапоги', 'полусапоги'];
  if (strstr($haystack, 'ремень')) return ['женские ремни', 'ремни'];
  if (strstr($haystack, 'рюкзак')) return ['женские рюкзаки', 'рюкзаки'];
  if (strstr($haystack, 'сапоги')) return ['женские сапоги', 'сапоги'];
  if (strstr($haystack, 'сумка для ноутбука')) return ['женские сумки для ноутбуков', 'сумки для ноутбуков'];
  if (strstr($haystack, 'сумка для телефона')) return ['женские сумки для телефонов', 'сумки для телефонов'];
  if (strstr($haystack, 'дорожная сумка')) return ['женские дорожные сумки', 'дорожные сумки'];
  if (strstr($haystack, 'сумка дорожная')) return ['женские дорожные сумки', 'дорожные сумки'];
  if (strstr($haystack, 'сумка на замке')) return ['женские сумки', 'сумки'];
  if (strstr($haystack, 'сумка на клапане')) return ['женские сумки', 'сумки'];
  if (strstr($haystack, 'сумка на короткой ручке')) return ['женские сумки', 'сумки'];
  if (strstr($haystack, 'сумка на шнуровке')) return ['женские сумки', 'сумки'];
  if (strstr($haystack, 'сумка пауч')) return ['женские сумки', 'сумки'];
  // первая буква анлийская (опечатка в оффере tamaris)
  if (strstr($haystack, 'cумка поясная')) return ['женские поясные сумки', 'поясные сумки'];
  // первая буква анлийская (опечатка в оффере tamaris)
  if (strstr($haystack, 'cумка через плечо')) return ['женские сумки через плечо', 'сумки через плечо'];
  if (strstr($haystack, 'сумка шоппер')) return ['женские сумки-шоперы', 'сумки-шоперы'];
  if (strstr($haystack, 'сумка')) return ['женские сумки', 'сумки'];
  if (strstr($haystack, 'туфли летние открытые')) return ['женские открытые туфли', 'открытые туфли'];
  if (strstr($haystack, 'туфли')) return ['женские туфли', 'туфли'];
  if (strstr($haystack, 'чемодан')) return ['женские чемоданы', 'чемоданы'];
  if (strstr($haystack, 'шапка вязаная')) return ['женские вязаные шапки', 'вязаные шапки'];
  if (strstr($haystack, 'шарф')) return ['женские шарфы', 'шарфы'];
  if (strstr($haystack, 'шляпа')) return ['женские шляпы', 'шляпы'];
  if (strstr($haystack, 'балетки')) return ['женские балетки', 'балетки'];
  if (strstr($haystack, 'босоножки')) return ['женские босоножки', 'босоножки'];
  if (strstr($haystack, 'ботильоны челси')) return ['женские челси', 'челси'];
  if (strstr($haystack, 'челси')) return ['женские челси', 'челси'];
  if (strstr($haystack, 'ботильоны')) return ['женские ботильоны', 'ботильоны'];
  if (strstr($haystack, 'ботфорты')) return ['женские ботфорты', 'ботфорты'];
  if (strstr($haystack, 'дерби')) return ['женские дерби', 'дерби'];
  if (strstr($haystack, 'бьюти кейс')) return ['женские бьюти кейсы', 'бьюти кейсы'];
  if (strstr($haystack, 'дутики')) return ['женские дутики', 'дутики'];
  if (strstr($haystack, 'кеды')) return ['женские кеды', 'кеды'];
  if (strstr($haystack, 'кроссовки')) return ['женские кроссовки', 'кроссовки'];
  if (strstr($haystack, 'лоферы')) return ['женские лоферы', 'лоферы'];
  if (strstr($haystack, 'сабо')) return ['женские сабо', 'сабо'];
  if (strstr($haystack, 'сандалии')) return ['женские сандалии', 'сандалии'];
  if (strstr($haystack, 'шапка')) return ['женские шапки', 'шапки'];
  if (strstr($haystack, 'эспадрильи')) return ['женские эспадрильи', 'эспадрильи'];

  return ['ошибки tamaris'];
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

    $color = str_replace('не задано', null, $color);
    $color = str_replace(' узор', '', $color);
    $color = str_replace('; ', '/', $color);
    $color = str_replace('в полоску', '', $color);
    $color = str_replace('золото', 'золотой', $color);
    $color = str_replace('золотойй', 'золотой', $color); //Чиним то, что сломали верхним правилом
    $color = str_replace('шафран', 'шафрановый', $color);
    $color = str_replace('шафрановыйовый', 'шафрановый', $color); //Чиним то, что сломали верхним правилом
    $color = str_replace(' рисунок', '', $color);
    $color = str_replace(' лаковый', '', $color);
    $color = str_replace('-лак', '', $color);
    $color = str_replace(' лак', '', $color);
    $color = str_replace(' комб.', '', $color);
    $color = str_replace('мультицвет', 'разноцветный', $color);
    $color = str_replace(' матовый', '', $color);
    $color = str_replace('небесный голубой', 'небесный/голубой', $color);
    $color = str_replace('?', '/', $color);
    $color = str_replace('бело', 'белый', $color);
    $color = str_replace('пихтовый зелёный', 'пихтовый/зелёный', $color);
    $color = str_replace(' замша', '', $color);
    $color = str_replace(' комбинированный', '', $color);
    $color = str_replace('мультиколор', 'разноцветный', $color);
    $color = str_replace('бронзово-', 'бронзовый/', $color);
    $color = str_replace('серо-', 'серый/', $color);
    $color = str_replace('сине-', 'синий/', $color);
    $color = str_replace('красно-', 'красный/', $color);
    $color = str_replace(' неон', '', $color);
    $color = str_replace('розовато-', 'розовый/', $color);
    $color = str_replace('бежево-', 'бежевый', $color);
    $color = str_replace('коньяк', 'коньячный', $color);
    $color = str_replace('жемчуг', 'жемчужный', $color);
    $color = str_replace('синяя', 'синий', $color);
    $color = str_replace('коньяк', 'коньячный', $color);

    if (strpos($color, '/')) $color = explode('/', $color);
 
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