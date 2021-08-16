<?php

function category($offer) {
  $haystack = mb_strtolower($offer['name']);
  
  if (strstr($haystack, 'балетки')) return ['Женские балетки', 'Балетки'];
  if (strstr($haystack, 'берет')) return ['Женские береты', 'Береты'];
  if (strstr($haystack, 'бизнес сумка')) return ['Женские бизнес сумки', 'Бизнес сумки'];
  if (strstr($haystack, 'ботинки')) return ['Женские ботинки', 'Ботинки'];
  if (strstr($haystack, 'полустельки')) return ['Полустельки для женской обуви', 'Полустельки для обуви'];
  if (strstr($haystack, 'термо-стельки')) return ['Термостельки для женской обуви', 'Термостельки для обуви'];
  if (strstr($haystack, 'гелевые стельки')) return ['Гелевые стельки для женской обуви', 'Гелевые стельки для обуви'];
  if (strstr($haystack, 'кожаные стельки')) return ['Кожаные стельки для женской обуви', 'Кожаные стельки для обуви'];
  if (strstr($haystack, 'ортопедические стельки')) return ['Ортопедические стельки для женской обуви', 'Ортопедические стельки для обуви'];
  if (strstr($haystack, 'стельки из мериносовой шерсти')) return ['Шерстяные стельки для женской обуви', 'Шерстяные стельки для обуви'];
  if (strstr($haystack, 'универсальные шерстяные стельки')) return ['Шерстяные стельки для женской обуви', 'Шерстяные стельки для обуви'];
  if (strstr($haystack, 'стельки')) return ['Стельки для женской обуви', 'Стельки для обуви'];
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


function name($offer) {
  $prefixCode = $offer['vendorCode'];
  if (strpos($prefixCode, '/')) $prefixCode = explode('/', $prefixCode)[0];
  if (strpos($prefixCode, ' ')) $prefixCode = explode(' ', $prefixCode)[0];
  
  $prefixName = $offer['name'];
  if (strpos($prefixName, ', р. ')) $prefixName = explode(', р. ', $prefixName)[0];
  
  return $prefixName . ' ' . 'Tamaris' . ' ' . $prefixCode;
}


function descFirst($offer) {
  return null;
}


function descSecond($offer) {
  return null;
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


function cvet($offer) {
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Не задано') return null;
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Белый; синий') return ['Белый', 'Синий'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Рыжий/желтый') return ['Рыжий', 'Желтый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Красный/крокодиловый узор') return ['Красный', 'Крокодиловый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Белый/светло-серый') return ['Белый', 'Светло-серый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Бежевый/черный') return ['Бежевый', 'Черный'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Красный/бордовый') return ['Красный', 'Бордовый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Черный лаковый') return ['Черный', 'Лакированный'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Коричневый/светло-коричневый') return ['Коричневый', 'Светло-коричневый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Серый/синий') return ['Серый', 'Синий'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Синий лак') return ['Синий', 'Лакированный'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Черный комб.') return 'Черный';
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Черный/золото') return ['Черный', 'Золотой'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Мультицвет') return 'Разноцветный';
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Серебристый/белый') return ['Серебристый', 'Белый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Розовый/коричневый') return ['Розовый', 'Коричневый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Бежевый/шампань') return ['Бежевый', 'Шампань'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Белый/розовый') return ['Белый', 'Розовый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Черный/темно-серый') return ['Черный', 'Темно-серый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Белый/черный') return ['Белый', 'Черный'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Бежевый/оливковый') return ['Бежевый', 'Оливковый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Белый/темно-синий') return ['Белый', 'Темно-синий'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Белый; светло-коричневый') return ['Белый', 'Светло-коричневый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Желтый/шафран') return ['Желтый', 'Шафран'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Светло-синий/голубой') return ['Светло-синий', 'Голубой'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Белый/сиреневый') return ['Белый', 'Сиреневый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Оливковый комб.') return 'Оливковый';
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Белый/песочный') return ['Белый', 'Песочный'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Песочный; бежевый') return ['Песочный', 'Бежевый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Песочный комб.') return 'Песочный';
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Коричневый комб.') return 'Коричневый';
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Белый/цветочный') return ['Белый', 'Цветочный'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Черный/розовый') return ['Черный', 'Розовый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Черный матовый') return ['Черный', 'Матовый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Черный/красный') return ['Черный', 'Красный'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Розовый комб.') return 'Розовый';
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Голубой/черный') return ['Голубой', 'Черный'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Пудровый/розовый') return ['Пудровый', 'Розовый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Серый/голубой') return ['Серый', 'Голубой'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Небесный голубой') return 'Небесно-голубой';
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Красный/белый') return ['Красный', 'Белый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Фисташковый комб.') return 'Фисташковый';
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Синий/перламутровый') return ['Синий', 'Перламутровый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Бежевый/пудровый') return ['Бежевый', 'Пудровый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Бежевый комб.') return 'Бежевый';
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Синий комб.') return 'Синий';
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Белый/синий') return ['Белый', 'Синий'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Белый/серебристый') return ['Белый', 'Серебристый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Черный/белый') return ['Черный', 'Белый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Коричневый/золотой') return ['Коричневый', 'Золотой'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Бело?зелёный') return ['Белый', 'Зеленый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Пихтовый зелёный') return ['Пихтовый', 'Зелёный'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Голубой комб.') return 'Голубой';
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Черный/крокодиловый рисунок') return ['Черный', 'Крокодиловый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Белый/золотистый') return ['Белый', 'Золотистый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Белый/голубой') return ['Белый', 'Голубой'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Медный/металлик') return ['Медный', 'Металлик'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Белый/фисташковый') return ['Белый', 'Фисташковый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Коричневый; крокодиловый узор') return ['Коричневый', 'Крокодиловый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Ореховый замша') return 'Ореховый';
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Голубой/серебряный') return ['Голубой', 'Серебряный'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Синий/золотой') return ['Синий', 'Золотой'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Коричневый/махагон') return ['Коричневый', 'Махагон'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Белый/золотой') return ['Белый', 'Золотой'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Светло-розовый-лак') return ['Светло-розовый', 'Лакированный'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Красный-лак') return ['Красный', 'Лакированный'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Синий комбинированный') return 'Синий';
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Черный; белый') return ['Черный', 'Белый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Синий; в полоску') return 'Синий';
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Мультиколор') return 'Разноцветный';
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Коричневый/крокодиловый узор') return ['Коричневый', 'Крокодиловый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Красный; в полоску') return 'Красный';
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Кремовый лак') return ['Кремовый', 'Лакированный'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Темно-коричневый/змеиный узор') return ['Темно-коричневый', 'Змеиный'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Зеленый/черный') return ['Зеленый', 'Черный'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Красный/синий') return ['Красный', 'Синий'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Бежевый лак') return ['Бежевый', 'Лакированный'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Черный/коричневый') return ['Черный', 'Коричневый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Белый комб.') return 'Белый';
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Белый/коричневый') return ['Белый', 'Коричневый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Черный/жемчуг') return ['Черный', 'Жемчужный'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Черный/серебристый') return ['Черный', 'Серебристый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Пудровый/черный') return ['Пудровый', 'Черный'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Коралловый комб.') return 'Коралловый';
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Белый/кремовый') return ['Белый', 'Кремовый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Серый/бронзовый') return ['Серый', 'Бронзовый'];
  if (isset($offer['params']['Цвет']) && $offer['params']['Цвет']['val_'] == 'Красный лак') return ['Красный', 'Лакированный'];

  return $offer['params']['Цвет']['val_'] ?? null;
}


function pol($offer) {
  return 'Для женщин';
}


function country($offer) {
  if (isset($offer['country_of_origin']) && $offer['country_of_origin'] == 'Китай') return 'Китай';
  if (isset($offer['country_of_origin']) && $offer['country_of_origin'] == 'Республика Индия') return 'Индия';
  if (isset($offer['country_of_origin']) && $offer['country_of_origin'] == 'Германия') return 'Германия';
  if (isset($offer['country_of_origin']) && $offer['country_of_origin'] == 'Болгария') return 'Болгария';
  if (isset($offer['country_of_origin']) && $offer['country_of_origin'] == 'Вьетнам') return 'Вьетнам';
  if (isset($offer['country_of_origin']) && $offer['country_of_origin'] == 'Бангладеш') return 'Бангладеш';
  if (isset($offer['country_of_origin']) && $offer['country_of_origin'] == 'Португальская Республика') return 'Португалия';
  if (isset($offer['country_of_origin']) && $offer['country_of_origin'] == 'Мьянма') return 'Мьянма';
  if (isset($offer['country_of_origin']) && $offer['country_of_origin'] == 'Мьянма') return 'Мьянма';
  if (isset($offer['country_of_origin']) && $offer['country_of_origin'] == 'Румыния') return 'Румыния';
  if (isset($offer['country_of_origin']) && $offer['country_of_origin'] == 'Албания') return 'Албания';
  if (isset($offer['country_of_origin']) && $offer['country_of_origin'] == 'Камбоджа') return 'Камбоджа';
  if (isset($offer['country_of_origin']) && $offer['country_of_origin'] == 'Индонезия') return 'Индонезия';
  if (isset($offer['country_of_origin']) && $offer['country_of_origin'] == 'Турция') return 'Турция';
  if (isset($offer['country_of_origin']) && $offer['country_of_origin'] == 'Тунис') return 'Тунис';
  if (isset($offer['country_of_origin']) && $offer['country_of_origin'] == 'Босния и Герцеговина') return 'Босния и Герцеговина';
  
  return $offer['country_of_origin'] ?? null;
}


function uniq($offer) {
  $prefix = $offer['vendorCode'];
  if (strpos($prefix, '/')) $prefix = explode('/', $prefix)[0];
  if (strpos($prefix, ' ')) $prefix = explode(' ', $prefix)[0];
  
  return $prefix;
}