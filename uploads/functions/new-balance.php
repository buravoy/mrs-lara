<?php 
    
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
  if ($newPrefix == 'Аксессуары для обуви другие') $newPrefix = 'Аксессуар для обуви';
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
    $prefix = $offer['typePrefix'];
    $catId = $offer['categoryId'];

  if ($catId == '205' && $prefix == 'Носки') return ['Мужские носки', 'Носки', 'Мужские спортивные носки', 'Спортивные носки'];
  if ($catId == '239' && $prefix == 'Кепки') return ['Мужские кепки', 'Кепки', 'Мужские спортивные кепки', 'Спортивные кепки'];
  if ($catId == '204' && $prefix == 'Crossbody' && $offer['name'] == 'GRAPHIC CINCH SACK') return ['Мужские рюкзаки-мешки', 'Рюкзаки-мешки']; //Косяк в оффере
  if ($catId == '204' && $prefix == 'Crossbody') return ['Мужские поясные сумки', 'Поясные сумки'];
  if ($catId == '204' && $prefix == 'Messenger' && $offer['name'] == 'TM17 SHOE BAG') return ['Мужские сумки для обуви', 'Сумки для обуви']; //Косяк в оффере
  if ($catId == '204' && $prefix == 'Messenger') return ['Мужские поясные сумки', 'Поясные сумки'];
  if ($catId == '237' && $prefix == 'Шорты') return ['Мужские шорты', 'Шорты', 'Мужские спортивные шорты', 'Спортивные шорты'];
  if ($catId == '240' && $prefix == 'Брюки') return ['Женские брюки', 'Брюки', 'Женские спортивные брюки', 'Спортивные брюки'];
  if ($catId == '235' && $prefix == 'Куртки') return ['Мужские куртки', 'Куртки', 'Мужские спортивные куртки', 'Спортивные куртки'];
  if ($catId == '197' && $prefix == 'Кроссовки') return ['Мужские повседневные кроссовки', 'Повседневные кроссовки'];
  if ($catId == '197' && $prefix == 'Ботинки') return ['Мужские повседневные ботинки', 'Повседневные ботинки'];
  if ($catId == '240' && $prefix == 'Шорты') return ['Женские шорты', 'Шорты', 'Женские спортивные шорты', 'Спортивные шорты'];
  if ($catId == '268' && $prefix == 'Кроссовки') return ['Мужские бутсы', 'Мужские футбольные бутсы', 'Мужские спортивные бутсы', 'Бутсы', 'Футбольные бутсы', 'Спортивные бутсы'];
  if ($catId == '242' && $prefix == 'Куртки') return ['Женские куртки', 'Куртки', 'Женские спортивные куртки', 'Спортивные куртки'];
  if ($catId == '239' && $prefix == 'Шапки') return ['Мужские шапки', 'Шапки', 'Мужские спортивные шапки', 'Спортивные шапки'];
  if ($catId == '1223' && $prefix == 'Носки') return ['Детские носки', 'Детские спортивные носки'];
  if ($catId == '204' && $prefix == 'Backpack') return ['Мужские рюкзаки', 'Рюкзаки', 'Мужские спортивные рюкзаки', 'Спортивные рюкзаки'];
  if ($catId == '214' && $prefix == 'Кроссовки') return ['Женские повседневные кроссовки', 'Повседневные кроссовки'];
  if ($catId == '323' && $prefix == 'Топы, майки') return ['Женские топы', 'Топы', 'Женские спортивные топы', 'Спортивные топы'];
  if ($catId == '240' && $prefix == 'Леггинсы') return ['Женские леггинсы', 'Леггинсы', 'Женские спортивные леггинсы', 'Спортивные леггинсы'];
  if ($catId == '243' && $prefix == 'Толстовки') return ['Женские толстовки', 'Толстовки', 'Женские спортивные толстовки', 'Спортивные толстовки'];
  if ($catId == '206' && $prefix == 'Футболки') return ['Мужские футболки', 'Футболки', 'Мужские футболки для бега', 'Футболки для бега', 'Мужские спортивные футболки', 'Спортивные футболки'];
  if ($catId == '455' && $prefix == 'Аксессуары для обуви другие') return ['Женские шнурки для обуви', 'Шнурки для обуви'];
  if ($catId == '243' && $prefix == 'Куртки') return ['Женские куртки', 'Куртки', 'Женские спортивные куртки', 'Спортивные куртки'];
  if ($catId == '448' && $prefix == 'Шарфы') return ['Мужские шарфы', 'Шарфы', 'Мужские спортивные шарфы', 'Спортивные шарфы'];
  if ($catId == '241' && $prefix == 'Футболки') return ['Женские футболки', 'Футболки', 'Женские спортивные футболки', 'Спортивные футболки'];
  if ($catId == '238' && $prefix == 'Футболки') return ['Мужские футболки', 'Футболки', 'Мужские спортивные футболки', 'Спортивные футболки'];
  if ($catId == '237' && $prefix == 'Брюки') return ['Мужские брюки', 'Брюки', 'Мужские спортивные брюки', 'Спортивные брюки'];
  if ($catId == '236' && $prefix == 'Толстовки') return ['Мужские толстовки', 'Толстовки', 'Мужские спортивные толстовки', 'Спортивные толстовки'];
  if ($catId == '249' && $prefix == 'Кроссовки') return ['Женские кроссовки', 'Кроссовки', 'Женские кроссовки для бега', 'Кроссовки для бега', 'Женские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($catId == '2364' && $prefix == 'Кроссовки') return ['Кроссовки для малышей', 'Кроссовки'];
  if ($catId == '2365' && $prefix == 'Сандалии') return ['Детские сандалии', 'Сандалии', 'Детские спортивные сандалии', 'Спортивные сандалии'];
  if ($catId == '248' && $prefix == 'Кроссовки') return ['Мужские кроссовки', 'Кроссовки', 'Мужские кроссовки для бега', 'Кроссовки для бега', 'Мужские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($catId == '252' && $prefix == 'Кроссовки') return ['Женские кроссовки', 'Кроссовки', 'Женские кроссовки для бега', 'Кроссовки для бега', 'Женские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($catId == '2365' && $prefix == 'Кроссовки') return ['Детские кроссовки', 'Кроссовки', 'Детские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($catId == '2364' && $prefix == 'Сандалии') return ['Сандалии для малышей', 'Сандалии'];
  if ($catId == '206' && $prefix == 'Кроссовки') return ['Мужские кроссовки', 'Кроссовки', 'Мужские кроссовки для бега', 'Кроссовки для бега', 'Мужские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($catId == '1289' && $prefix == 'Кроссовки') return ['Женские кроссовки', 'Кроссовки', 'Женские трейловые кроссовки для бега', 'Трейловые кроссовки для бега', 'Женские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($catId == '1284' && $prefix == 'Кроссовки') return ['Мужские кроссовки', 'Кроссовки', 'Мужские темповые кроссовки для бега', 'Темповые кроссовки для бега', 'Мужские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($catId == '1286' && $prefix == 'Кроссовки') return ['Мужские кроссовки', 'Кроссовки', 'Мужские трейловые кроссовки для бега', 'Трейловые кроссовки для бега', 'Мужские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($catId == '204' && $prefix == 'Wristlet' && $offer['name'] == 'NB CINCH SACK') return ['Мужские рюкзаки-мешки', 'Рюкзаки-мешки']; //Косяк в оффере
  if ($catId == '204' && $prefix == 'Wristlet' && $offer['name'] == 'NB IMPACT RUNNING WAIST PACK') return ['Мужские поясные сумки', 'Поясные сумки']; //Косяк в оффере
  if ($catId == '204' && $prefix == 'Wristlet' && $offer['name'] == 'NB POOL TOTE') return ['Мужские сумки-шоперы', 'Сумки-шоперы']; //Косяк в оффере
  if ($catId == '204' && $prefix == 'Wristlet') return ['Мужские сумки', 'Сумки', 'Мужские спортивные сумки', 'Спортивные сумки'];
  if ($catId == '1290' && $prefix == 'Кроссовки') return ['Женские кроссовки', 'Кроссовки', 'Женские тренировочные кроссовки для бега', 'Тренировочные кроссовки для бега', 'Женские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($catId == '1287' && $prefix == 'Кроссовки') return ['Женские кроссовки', 'Кроссовки', 'Женские темповые кроссовки для бега', 'Темповые кроссовки для бега', 'Женские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($catId == '237' && $prefix == 'Леггинсы') return ['Мужские леггинсы', 'Леггинсы', 'Мужские спортивные леггинсы', 'Спортивные леггинсы'];
  if ($catId == '221' && $prefix == 'Messenger' && $offer['name'] == 'NB IMPACT RUNNING WAIST BELT') return ['Женские поясные сумки', 'Поясные сумки']; //Косяк в оффере
  if ($catId == '2452' && $prefix == 'Аксессуары прочие' && $offer['name'] == 'SOCCER BALLS') return ['Женские футбольные мячи', 'Футбольные мячи']; //Косяк в оффере
  if ($catId == '2452' && $prefix == 'Аксессуары прочие' && $offer['name'] == 'NB GEODESA MATCH FOOTBALL') return ['Женские футбольные мячи', 'Футбольные мячи']; //Косяк в оффере
  if ($catId == '235' && $prefix == 'Жилеты') return ['Мужские жилеты', 'Жилеты', 'Мужские спортивные жилеты', 'Спортивные жилеты'];
  if ($catId == '453' && $prefix == 'Средства по уходу') return ['Средства по уходу за обувью'];
  if ($catId == '220' && $prefix == 'Носки') return ['Женские носки', 'Носки', 'Женские спортивные носки', 'Спортивные носки'];
  if ($catId == '323' && $prefix == 'Футболки') return ['Женские топы', 'Топы', 'Женские спортивные топы', 'Спортивные топы'];
  if ($catId == '206' && $prefix == 'Куртки') return ['Мужские куртки', 'Куртки', 'Мужские куртки для бега', 'Куртки для бега', 'Мужские спортивные куртки', 'Спортивные куртки'];
  if ($catId == '206' && $prefix == 'Брюки') return ['Мужские брюки', 'Брюки', 'Мужские брюки для бега', 'Брюки для бега', 'Мужские спортивные брюки', 'Спортивные брюки'];
  if ($catId == '1283' && $prefix == 'Кроссовки') return ['Мужские кроссовки', 'Кроссовки', 'Мужские тренировочные кроссовки для бега', 'Тренировочные кроссовки для бега', 'Мужские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($catId == '207' && $prefix == 'Кроссовки') return ['Мужские кроссовки', 'Кроссовки', 'Мужские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($catId == '2366' && $prefix == 'Кроссовки') return ['Мужские кроссовки', 'Кроссовки', 'Мужские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($catId == '206' && $prefix == 'Шорты') return ['Мужские шорты', 'Шорты', 'Мужские шорты для бега', 'Шорты для бега', 'Мужские спортивные шорты', 'Спортивные шорты'];
  if ($catId == '236' && $prefix == 'Футболки') return ['Мужские толстовки', 'Толстовки', 'Мужские спортивные толстовки', 'Спортивные толстовки'];
  if ($catId == '241' && $prefix == 'Топы, майки') return ['Женские футболки', 'Футболки', 'Женские спортивные футболки', 'Спортивные футболки'];
  if ($catId == '238' && $prefix == 'Футболки с длинным рукавом') return ['Мужские футболки с длинным рукавом', 'Футболки с длинным рукавом', 'Мужские спортивные футболки с длинным рукавом', 'Спортивные футболки с длинным рукавом'];
  if ($catId == '238' && $prefix == 'Топы, майки') return ['Мужские футболки', 'Футболки', 'Мужские спортивные футболки', 'Спортивные футболки'];
  if ($catId == '2369' && $prefix == 'Кроссовки') return ['Мужские кроссовки', 'Кроссовки', 'Мужские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($catId == '2371' && $prefix == 'Кроссовки') return ['Женские кроссовки', 'Кроссовки', 'Женские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($catId == '236' && $prefix == 'Куртки') return ['Мужские толстовки', 'Толстовки', 'Мужские спортивные толстовки', 'Спортивные толстовки'];
  if ($catId == '236' && $prefix == 'Брюки') return ['Мужские брюки', 'Брюки', 'Мужские спортивные брюки', 'Спортивные брюки'];
  if ($catId == '240' && $prefix == 'Платья') return ['Женские платья', 'Платья', 'Женские спортивные платья', 'Спортивные платья'];
  if ($catId == '244' && $prefix == 'Кепки') return ['Женские кепки', 'Кепки', 'Женские спортивные кепки', 'Спортивные кепки'];

  return ['Ошибки New Balance'];
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
  $text = newPrefix($offer) .' от бренда New Balance. Артикул модели - ' . newArticle($offer) . ', цвет ' . cvet($offer) . ', дизайн разработан специально ' . vozrast($offer) . '. В интернет-магазине цена указана со скидкой и составляет ' . price($offer) . ' руб. ' . category($offer)[0] . ' можно купить с доставкой по Москве и России, либо самовывозом из магазина.';
  return $text . ' ' . $offer['description'];
}