<?php 
 
function specialName($offer) {
    return null;
}

function available($offer) {
  return true;
}

// (Рабочая) Получаем категорию в ед.числе
function newPrefix($offer) {
  // Переименовываем некоторые непонятные названия категорий
  if (isset($offer['typePrefix'])) {
  $newPrefix = $offer['typePrefix'];
  
    
  if ($newPrefix == 'Backpack') $newPrefix = 'Рюкзак';
  if ($newPrefix == 'Crossbody') $newPrefix = 'Сумка';
  if ($newPrefix == 'Messenger') $newPrefix = 'Сумка';
  if ($newPrefix == 'Wristlet') $newPrefix = 'Сумка';
  if ($newPrefix == 'Аксессуары для обуви другие') $newPrefix = 'Шнурки';
  if ($newPrefix == 'Аксессуары прочие') $newPrefix = 'Мяч';
  if ($newPrefix == 'Жилеты') $newPrefix = 'Жилет';
  if ($newPrefix == 'Кепки') $newPrefix = 'Кепка';
  if ($newPrefix == 'Куртки') $newPrefix = 'Куртка';
  if ($newPrefix == 'Платья') $newPrefix = 'Платье';
  if ($newPrefix == 'Средства по уходу') $newPrefix = 'Средство по уходу за обувью';
  if ($newPrefix == 'Толстовки') $newPrefix = 'Толстовка';
  if ($newPrefix == 'Топы, майки') $newPrefix = 'Топ/Майка';
  if ($newPrefix == 'Футболки') $newPrefix = 'Футболка';
  if ($newPrefix == 'Футболки с длинным рукавом') $newPrefix = 'Футболка с длинным рукавом';
  if ($newPrefix == 'Шапки') $newPrefix = 'Шапка';
  if ($newPrefix == 'Шарфы') $newPrefix = 'Шарф';
  return $newPrefix;
  } else return 'Товар';
}

// (Рабочая) Получаем новое имя товара
function newName($offer) {
  if (isset($offer['name'])) {
    $newName = $offer['name'];
  } else return '';
  // Удаляем "NB" из name товаров, у которых это указано
  $deleteNB = array("NB ", " NB", "NB");
  $newName = str_replace($deleteNB, "", $newName);
  return $newName;
}

// (Рабочая) Получаем новый артикул товара
function newArticle($offer) {
  if (isset($offer['params']['Артикул']['val_'])) {
    $newArticle = $offer['params']['Артикул']['val_'];
    return $newArticle;
  } else return '';
}

function name($offer) {
  return newPrefix($offer) . ' ' . newName($offer) . ' ' . 'New Balance' . ' ' . newArticle($offer);
}

function category($offer) {
  if (isset($offer['typePrefix'], $offer['categoryId'])) {
    $prefix = mb_strtolower($offer['typePrefix']);
    $catId = $offer['categoryId'];
    $prefixName = mb_strtolower($offer['name']);

  if ($catId == '205' && $prefix == 'носки') return ['мужские носки', 'носки'];
  if ($catId == '239' && $prefix == 'кепки') return ['мужские кепки', 'кепки'];
  if ($catId == '204' && $prefix == 'crossbody' && $prefixName == 'graphic cinch sack') return ['мужские рюкзаки-мешки', 'рюкзаки-мешки']; //косяк в оффере
  if ($catId == '204' && $prefix == 'crossbody') return ['мужские поясные сумки', 'поясные сумки'];
  if ($catId == '204' && $prefix == 'messenger' && $prefixName == 'tm17 shoe bag') return ['мужские сумки для обуви', 'сумки для обуви']; //косяк в оффере
  if ($catId == '204' && $prefix == 'messenger') return ['мужские поясные сумки', 'поясные сумки'];
  if ($catId == '237' && $prefix == 'шорты') return ['мужские шорты', 'шорты'];
  if ($catId == '240' && $prefix == 'брюки') return ['женские брюки', 'брюки'];
  if ($catId == '235' && $prefix == 'куртки') return ['мужские куртки', 'куртки'];
  if ($catId == '197' && $prefix == 'кроссовки') return ['мужские повседневные кроссовки', 'повседневные кроссовки'];
  if ($catId == '197' && $prefix == 'ботинки') return ['мужские повседневные ботинки', 'повседневные ботинки'];
  if ($catId == '240' && $prefix == 'шорты') return ['женские шорты', 'шорты'];
  if ($catId == '268' && $prefix == 'кроссовки') return ['мужские бутсы', 'бутсы'];
  if ($catId == '242' && $prefix == 'куртки') return ['женские куртки', 'куртки'];
  if ($catId == '239' && $prefix == 'шапки') return ['мужские шапки', 'шапки'];
  if ($catId == '1223' && $prefix == 'носки') return ['носки для девочек', 'носки для мальчиков', 'детские носки', 'носки'];
  if ($catId == '204' && $prefix == 'backpack') return ['мужские рюкзаки', 'рюкзаки'];
  if ($catId == '214' && $prefix == 'кроссовки') return ['женские повседневные кроссовки', 'повседневные кроссовки'];
  if ($catId == '323' && $prefix == 'топы, майки') return ['женские топы', 'топы'];
  if ($catId == '240' && $prefix == 'леггинсы') return ['женские леггинсы', 'леггинсы'];
  if ($catId == '243' && $prefix == 'толстовки') return ['женские толстовки', 'толстовки'];
  if ($catId == '206' && $prefix == 'футболки') return ['мужские футболки', 'футболки'];
  if ($catId == '455' && $prefix == 'аксессуары для обуви другие') return ['женские шнурки для обуви', 'шнурки для обуви'];
  if ($catId == '243' && $prefix == 'куртки') return ['женские куртки', 'куртки'];
  if ($catId == '448' && $prefix == 'шарфы') return ['мужские шарфы', 'шарфы'];
  if ($catId == '241' && $prefix == 'футболки') return ['женские футболки', 'футболки'];
  if ($catId == '238' && $prefix == 'футболки') return ['мужские футболки', 'футболки'];
  if ($catId == '237' && $prefix == 'брюки') return ['мужские брюки', 'брюки'];
  if ($catId == '236' && $prefix == 'толстовки') return ['мужские толстовки', 'толстовки'];
  if ($catId == '249' && $prefix == 'кроссовки') return ['женские кроссовки', 'кроссовки'];
  if ($catId == '2364' && $prefix == 'кроссовки') return ['кроссовки для малышей', 'детские кроссовки', 'кроссовки'];
  if ($catId == '2365' && $prefix == 'сандалии') return ['сандалии для девочек', 'сандалии для мальчиков', 'детские сандалии', 'сандалии'];
  if ($catId == '248' && $prefix == 'кроссовки') return ['мужские кроссовки', 'кроссовки'];
  if ($catId == '252' && $prefix == 'кроссовки') return ['женские кроссовки', 'кроссовки'];
  if ($catId == '2365' && $prefix == 'кроссовки') return ['кроссовки для девочек', 'кроссовки для мальчиков', 'детские кроссовки', 'кроссовки'];
  if ($catId == '2364' && $prefix == 'сандалии') return ['сандалии для малышей', 'детские сандалии', 'сандалии'];
  if ($catId == '206' && $prefix == 'кроссовки') return ['мужские кроссовки', 'кроссовки'];
  if ($catId == '1289' && $prefix == 'кроссовки') return ['женские кроссовки', 'кроссовки'];
  if ($catId == '1284' && $prefix == 'кроссовки') return ['мужские кроссовки', 'кроссовки'];
  if ($catId == '1286' && $prefix == 'кроссовки') return ['мужские кроссовки', 'кроссовки'];
  if ($catId == '204' && $prefix == 'wristlet' && $prefixName == 'nb cinch sack') return ['мужские рюкзаки-мешки', 'рюкзаки-мешки']; //косяк в оффере
  if ($catId == '204' && $prefix == 'wristlet' && $prefixName == 'nb impact running waist pack') return ['мужские поясные сумки', 'поясные сумки']; //косяк в оффере
  if ($catId == '204' && $prefix == 'wristlet' && $prefixName == 'nb pool tote') return ['мужские сумки-шоперы', 'сумки-шоперы']; //косяк в оффере
  if ($catId == '204' && $prefix == 'wristlet') return ['мужские сумки', 'сумки'];
  if ($catId == '1290' && $prefix == 'кроссовки') return ['женские кроссовки', 'кроссовки'];
  if ($catId == '1287' && $prefix == 'кроссовки') return ['женские кроссовки', 'кроссовки'];
  if ($catId == '237' && $prefix == 'леггинсы') return ['мужские леггинсы', 'леггинсы'];
  if ($catId == '221' && $prefix == 'messenger' && $prefixName == 'nb impact running waist belt') return ['женские поясные сумки', 'поясные сумки']; //косяк в оффере
  if ($catId == '2452' && $prefix == 'аксессуары прочие' && $prefixName == 'soccer balls') return ['женские мячи', 'мячи']; //косяк в оффере
  if ($catId == '2452' && $prefix == 'аксессуары прочие' && $prefixName == 'nb geodesa match football') return ['женские мячи', 'мячи']; //косяк в оффере
  if ($catId == '235' && $prefix == 'жилеты') return ['мужские жилеты', 'жилеты'];
  if ($catId == '453' && $prefix == 'средства по уходу') return ['средства по уходу за обувью'];
  if ($catId == '220' && $prefix == 'носки') return ['женские носки', 'носки'];
  if ($catId == '323' && $prefix == 'футболки') return ['женские топы', 'топы'];
  if ($catId == '206' && $prefix == 'куртки') return ['мужские куртки', 'куртки'];
  if ($catId == '206' && $prefix == 'брюки') return ['мужские брюки', 'брюки'];
  if ($catId == '1283' && $prefix == 'кроссовки') return ['мужские кроссовки', 'кроссовки'];
  if ($catId == '207' && $prefix == 'кроссовки') return ['мужские кроссовки', 'кроссовки'];
  if ($catId == '2366' && $prefix == 'кроссовки') return ['мужские кроссовки', 'кроссовки'];
  if ($catId == '206' && $prefix == 'шорты') return ['мужские шорты', 'шорты'];
  if ($catId == '236' && $prefix == 'футболки') return ['мужские толстовки', 'толстовки'];
  if ($catId == '241' && $prefix == 'топы, майки') return ['женские футболки', 'футболки'];
  if ($catId == '238' && $prefix == 'футболки с длинным рукавом') return ['мужские футболки', 'футболки'];
  if ($catId == '238' && $prefix == 'топы, майки') return ['мужские футболки', 'футболки'];
  if ($catId == '2369' && $prefix == 'кроссовки') return ['мужские кроссовки', 'кроссовки'];
  if ($catId == '2371' && $prefix == 'кроссовки') return ['женские кроссовки', 'кроссовки'];
  if ($catId == '236' && $prefix == 'куртки') return ['мужские толстовки', 'толстовки'];
  if ($catId == '236' && $prefix == 'брюки') return ['мужские брюки', 'брюки'];
  if ($catId == '240' && $prefix == 'платья') return ['женские платья', 'платья'];
  if ($catId == '240' && $prefix == 'юбки') return ['женские юбки', 'юбки'];
  if ($catId == '244' && $prefix == 'кепки') return ['женские кепки', 'кепки'];

  return ['ошибки new balance'];
}
 return null;
}

function cvet($offer) {
  if (isset($offer['params']['Цвет']['val_'])) {
    $newCvet = mb_strtolower($offer['params']['Цвет']['val_']);
    if ($newCvet == 'мульти') $newCvet = 'разноцветный';
    if ($newCvet == 'персик') $newCvet = 'персиковый';
  return $newCvet;
  } else return 'Не определено New Balance';
}

function price($offer) {
  return $offer['price'] ?? null;
}

function oldprice($offer) {
  return $offer['oldprice'] ?? null;
}

function image($offer) {
  return $offer['picture'] ?? null;
}

function href($offer) {
  return $offer['url'] ?? null;
}

function brend($offer) {
  return 'New balance';
}

function magazin($offer) {
  return 'New balance';
}

function vozrast($offer) {
  // Возраст в оффере указан только взрослый. У детей и малышей не указан вообще. Новорожденных товаров в офферее нет.
  // Поэтому определяем по categoryId (2364 - для малышей, 2365 - для детей, 1223 - смешанные, указываем для детей)
  $newVozrast = 'Не определено New Balance';
  if (isset($offer['params']['Возраст']['val_'])) {
    if ($offer['params']['Возраст']['val_'] == 'Взрослый') $newVozrast = 'Для взрослых';
  }
  if (isset($offer['categoryId'])) {
    if ($offer['categoryId'] == '2364') $newVozrast = 'Для малышей';
    if ($offer['categoryId'] == '2365' || $offer['categoryId'] == '1223') $newVozrast = 'Для детей';
  }
  return $newVozrast;
}

function pol($offer) {
  // Пол в оффере указан как gender и Пол. Пол только Мужской и Женский. Gender - Мужской, Женский и None.
  // У детей и малышей None
  // Поэтому там, где None - указываем как для девочек, так и для мальчиков
  if (isset($offer['params']['gender']['val_'])) {
    $newPol = 'Не определено New Balance';
    if ($offer['params']['gender']['val_'] == 'Мужской') $newPol = 'Для мужчин';
    if ($offer['params']['gender']['val_'] == 'Женский') $newPol = 'Для женщин';
    if ($offer['params']['gender']['val_'] == 'None') $newPol = ['Для девочек', 'Для мальчиков'];
  return $newPol;
  } else return 'Не определено New Balance';
}

function uniq($offer) {
  return $offer['params']['Артикул']['val_'];
}

function descFirst($offer) {
  $text = 'Модель ' . newArticle($offer) . ' от New Balance. Купить в интернет-магазине с доставкой. ' . category($offer)[0] . ' по выгодной цене.';
  return $text;
}

function descSecond($offer) {
    if (isset($offer['description'])) $description = $offer['description'];
    else $description = '';
    
  $text = newPrefix($offer) .' от бренда New Balance. Артикул модели - ' . newArticle($offer) . ', цвет ' . cvet($offer) . ', дизайн разработан специально ' . vozrast($offer) . '. В интернет-магазине цена указана со скидкой и составляет ' . price($offer) . ' руб. ' . category($offer)[0] . ' можно купить с доставкой по Москве и России, либо самовывозом из магазина.';
  return $text . ' ' . $description;
}