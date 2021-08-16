<?php

function available($offer) {
  return true;
}


function category($offer) {
  if ($offer['categoryId'] == '205' && $offer['typePrefix'] == 'Носки') return ['Мужские носки', 'Носки', 'Мужские спортивные носки', 'Спортивные носки'];
  if ($offer['categoryId'] == '239' && $offer['typePrefix'] == 'Кепки') return ['Мужские кепки', 'Кепки', 'Мужские спортивные кепки', 'Спортивные кепки'];
  if ($offer['categoryId'] == '204' && $offer['typePrefix'] == 'Crossbody' && $offer['name'] == 'GRAPHIC CINCH SACK') return ['Мужские рюкзаки-мешки', 'Рюкзаки-мешки']; //Косяк в оффере
  if ($offer['categoryId'] == '204' && $offer['typePrefix'] == 'Crossbody') return ['Мужские поясные сумки', 'Поясные сумки'];
  if ($offer['categoryId'] == '204' && $offer['typePrefix'] == 'Messenger' && $offer['name'] == 'TM17 SHOE BAG') return ['Мужские сумки для обуви', 'Сумки для обуви']; //Косяк в оффере
  if ($offer['categoryId'] == '204' && $offer['typePrefix'] == 'Messenger') return ['Мужские поясные сумки', 'Поясные сумки'];
  if ($offer['categoryId'] == '237' && $offer['typePrefix'] == 'Шорты') return ['Мужские шорты', 'Шорты', 'Мужские спортивные шорты', 'Спортивные шорты'];
  if ($offer['categoryId'] == '240' && $offer['typePrefix'] == 'Брюки') return ['Женские брюки', 'Брюки', 'Женские спортивные брюки', 'Спортивные брюки'];
  if ($offer['categoryId'] == '235' && $offer['typePrefix'] == 'Куртки') return ['Мужские куртки', 'Куртки', 'Мужские спортивные куртки', 'Спортивные куртки'];
  if ($offer['categoryId'] == '197' && $offer['typePrefix'] == 'Кроссовки') return ['Мужские повседневные кроссовки', 'Повседневные кроссовки'];
  if ($offer['categoryId'] == '197' && $offer['typePrefix'] == 'Ботинки') return ['Мужские повседневные ботинки', 'Повседневные ботинки'];
  if ($offer['categoryId'] == '240' && $offer['typePrefix'] == 'Шорты') return ['Женские шорты', 'Шорты', 'Женские спортивные шорты', 'Спортивные шорты'];
  if ($offer['categoryId'] == '268' && $offer['typePrefix'] == 'Кроссовки') return ['Мужские бутсы', 'Мужские бутсы для футбола', 'Мужские спортивные бутсы', 'Бутсы', 'Бутсы для футбола', 'Спортивные бутсы'];
  if ($offer['categoryId'] == '242' && $offer['typePrefix'] == 'Куртки') return ['Женские куртки', 'Куртки', 'Женские спортивные куртки', 'Спортивные куртки'];
  if ($offer['categoryId'] == '239' && $offer['typePrefix'] == 'Шапки') return ['Мужские шапки', 'Шапки', 'Мужские спортивные шапки', 'Спортивные шапки'];
  if ($offer['categoryId'] == '1223' && $offer['typePrefix'] == 'Носки') return ['Детские носки', 'Детские спортивные носки'];
  if ($offer['categoryId'] == '204' && $offer['typePrefix'] == 'Backpack') return ['Мужские рюкзаки', 'Рюкзаки', 'Мужские спортивные рюкзаки', 'Спортивные рюкзаки'];
  if ($offer['categoryId'] == '214' && $offer['typePrefix'] == 'Кроссовки') return ['Женские повседневные кроссовки', 'Повседневные кроссовки'];
  if ($offer['categoryId'] == '323' && $offer['typePrefix'] == 'Топы, майки') return ['Женские топы', 'Топы', 'Женские спортивные топы', 'Спортивные топы'];
  if ($offer['categoryId'] == '240' && $offer['typePrefix'] == 'Леггинсы') return ['Женские леггинсы', 'Леггинсы', 'Женские спортивные леггинсы', 'Спортивные леггинсы'];
  if ($offer['categoryId'] == '243' && $offer['typePrefix'] == 'Толстовки') return ['Женские толстовки', 'Толстовки', 'Женские спортивные толстовки', 'Спортивные толстовки'];
  if ($offer['categoryId'] == '206' && $offer['typePrefix'] == 'Футболки') return ['Мужские футболки', 'Футболки', 'Мужские футболки для бега', 'Футболки для бега', 'Мужские спортивные футболки', 'Спортивные футболки'];
  if ($offer['categoryId'] == '455' && $offer['typePrefix'] == 'Аксессуары для обуви другие') return ['Шнурки для женской обуви', 'Шнурки для обуви'];
  if ($offer['categoryId'] == '243' && $offer['typePrefix'] == 'Куртки') return ['Женские куртки', 'Куртки', 'Женские спортивные куртки', 'Спортивные куртки'];
  if ($offer['categoryId'] == '448' && $offer['typePrefix'] == 'Шарфы') return ['Мужские шарфы', 'Шарфы', 'Мужские спортивные шарфы', 'Спортивные шарфы'];
  if ($offer['categoryId'] == '241' && $offer['typePrefix'] == 'Футболки') return ['Женские футболки', 'Футболки', 'Женские спортивные футболки', 'Спортивные футболки'];
  if ($offer['categoryId'] == '238' && $offer['typePrefix'] == 'Футболки') return ['Мужские футболки', 'Футболки', 'Мужские спортивные футболки', 'Спортивные футболки'];
  if ($offer['categoryId'] == '237' && $offer['typePrefix'] == 'Брюки') return ['Мужские брюки', 'Брюки', 'Мужские спортивные брюки', 'Спортивные брюки'];
  if ($offer['categoryId'] == '236' && $offer['typePrefix'] == 'Толстовки') return ['Мужские толстовки', 'Толстовки', 'Мужские спортивные толстовки', 'Спортивные толстовки'];
  if ($offer['categoryId'] == '249' && $offer['typePrefix'] == 'Кроссовки') return ['Женские кроссовки', 'Кроссовки', 'Женские кроссовки для бега', 'Кроссовки для бега', 'Женские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($offer['categoryId'] == '2364' && $offer['typePrefix'] == 'Кроссовки') return ['Кроссовки для малышей', 'Кроссовки'];
  if ($offer['categoryId'] == '2365' && $offer['typePrefix'] == 'Сандалии') return ['Детские сандалии', 'Сандалии', 'Детские спортивные сандалии', 'Спортивные сандалии'];
  if ($offer['categoryId'] == '248' && $offer['typePrefix'] == 'Кроссовки') return ['Мужские кроссовки', 'Кроссовки', 'Мужские кроссовки для бега', 'Кроссовки для бега', 'Мужские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($offer['categoryId'] == '252' && $offer['typePrefix'] == 'Кроссовки') return ['Женские кроссовки', 'Кроссовки', 'Женские кроссовки для бега', 'Кроссовки для бега', 'Женские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($offer['categoryId'] == '2365' && $offer['typePrefix'] == 'Кроссовки') return ['Детские кроссовки', 'Кроссовки', 'Детские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($offer['categoryId'] == '2364' && $offer['typePrefix'] == 'Сандалии') return ['Сандалии для малышей', 'Сандалии'];
  if ($offer['categoryId'] == '206' && $offer['typePrefix'] == 'Кроссовки') return ['Мужские кроссовки', 'Кроссовки', 'Мужские кроссовки для бега', 'Кроссовки для бега', 'Мужские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($offer['categoryId'] == '1289' && $offer['typePrefix'] == 'Кроссовки') return ['Женские кроссовки', 'Кроссовки', 'Женские трейловые кроссовки для бега', 'Трейловые кроссовки для бега', 'Женские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($offer['categoryId'] == '1284' && $offer['typePrefix'] == 'Кроссовки') return ['Мужские кроссовки', 'Кроссовки', 'Мужские темповые кроссовки для бега', 'Темповые кроссовки для бега', 'Мужские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($offer['categoryId'] == '1286' && $offer['typePrefix'] == 'Кроссовки') return ['Мужские кроссовки', 'Кроссовки', 'Мужские трейловые кроссовки для бега', 'Трейловые кроссовки для бега', 'Мужские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($offer['categoryId'] == '204' && $offer['typePrefix'] == 'Wristlet' && $offer['name'] == 'NB CINCH SACK') return ['Мужские рюкзаки-мешки', 'Рюкзаки-мешки']; //Косяк в оффере
  if ($offer['categoryId'] == '204' && $offer['typePrefix'] == 'Wristlet' && $offer['name'] == 'NB IMPACT RUNNING WAIST PACK') return ['Мужские поясные сумки', 'Поясные сумки']; //Косяк в оффере
  if ($offer['categoryId'] == '204' && $offer['typePrefix'] == 'Wristlet' && $offer['name'] == 'NB POOL TOTE') return ['Мужские сумки-шоперы', 'Сумки-шоперы']; //Косяк в оффере
  if ($offer['categoryId'] == '204' && $offer['typePrefix'] == 'Wristlet') return ['Мужские сумки', 'Сумки', 'Мужские спортивные сумки', 'Спортивные сумки'];
  if ($offer['categoryId'] == '1290' && $offer['typePrefix'] == 'Кроссовки') return ['Женские кроссовки', 'Кроссовки', 'Женские тренировочные кроссовки для бега', 'Тренировочные кроссовки для бега', 'Женские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($offer['categoryId'] == '1287' && $offer['typePrefix'] == 'Кроссовки') return ['Женские кроссовки', 'Кроссовки', 'Женские темповые кроссовки для бега', 'Темповые кроссовки для бега', 'Женские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($offer['categoryId'] == '237' && $offer['typePrefix'] == 'Леггинсы') return ['Мужские леггинсы', 'Леггинсы', 'Мужские спортивные леггинсы', 'Спортивные леггинсы'];
  if ($offer['categoryId'] == '221' && $offer['typePrefix'] == 'Messenger' && $offer['name'] == 'NB IMPACT RUNNING WAIST BELT') return ['Женские поясные сумки', 'Поясные сумки']; //Косяк в оффере
  if ($offer['categoryId'] == '2452' && $offer['typePrefix'] == 'Аксессуары прочие' && $offer['name'] == 'SOCCER BALLS') return ['Женские мячи для футбола', 'Мячи для футбола']; //Косяк в оффере
  if ($offer['categoryId'] == '2452' && $offer['typePrefix'] == 'Аксессуары прочие' && $offer['name'] == 'NB GEODESA MATCH FOOTBALL') return ['Женские мячи для футбола', 'Мячи для футбола']; //Косяк в оффере
  if ($offer['categoryId'] == '235' && $offer['typePrefix'] == 'Жилеты') return ['Мужские жилеты', 'Жилеты', 'Мужские спортивные жилеты', 'Спортивные жилеты'];
  if ($offer['categoryId'] == '453' && $offer['typePrefix'] == 'Средства по уходу') return ['Средства по уходу за обувью'];
  if ($offer['categoryId'] == '220' && $offer['typePrefix'] == 'Носки') return ['Женские носки', 'Носки', 'Женские спортивные носки', 'Спортивные носки'];
  if ($offer['categoryId'] == '323' && $offer['typePrefix'] == 'Футболки') return ['Женские топы', 'Топы', 'Женские спортивные топы', 'Спортивные топы'];
  if ($offer['categoryId'] == '206' && $offer['typePrefix'] == 'Куртки') return ['Мужские куртки', 'Куртки', 'Мужские куртки для бега', 'Куртки для бега', 'Мужские спортивные куртки', 'Спортивные куртки'];
  if ($offer['categoryId'] == '206' && $offer['typePrefix'] == 'Брюки') return ['Мужские брюки', 'Брюки', 'Мужские брюки для бега', 'Брюки для бега', 'Мужские спортивные брюки', 'Спортивные брюки'];
  if ($offer['categoryId'] == '1283' && $offer['typePrefix'] == 'Кроссовки') return ['Мужские кроссовки', 'Кроссовки', 'Мужские тренировочные кроссовки для бега', 'Тренировочные кроссовки для бега', 'Мужские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($offer['categoryId'] == '207' && $offer['typePrefix'] == 'Кроссовки') return ['Мужские кроссовки', 'Кроссовки', 'Мужские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($offer['categoryId'] == '2366' && $offer['typePrefix'] == 'Кроссовки') return ['Мужские кроссовки', 'Кроссовки', 'Мужские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($offer['categoryId'] == '206' && $offer['typePrefix'] == 'Шорты') return ['Мужские шорты', 'Шорты', 'Мужские шорты для бега', 'Шорты для бега', 'Мужские спортивные шорты', 'Спортивные шорты'];
  if ($offer['categoryId'] == '236' && $offer['typePrefix'] == 'Футболки') return ['Мужские толстовки', 'Толстовки', 'Мужские спортивные толстовки', 'Спортивные толстовки'];
  if ($offer['categoryId'] == '241' && $offer['typePrefix'] == 'Топы, майки') return ['Женские футболки', 'Футболки', 'Женские спортивные футболки', 'Спортивные футболки'];
  if ($offer['categoryId'] == '238' && $offer['typePrefix'] == 'Футболки с длинным рукавом') return ['Мужские футболки с длинным рукавом', 'Футболки с длинным рукавом', 'Мужские спортивные футболки с длинным рукавом', 'Спортивные футболки с длинным рукавом'];
  if ($offer['categoryId'] == '238' && $offer['typePrefix'] == 'Топы, майки') return ['Мужские футболки', 'Футболки', 'Мужские спортивные футболки', 'Спортивные футболки'];
  if ($offer['categoryId'] == '2369' && $offer['typePrefix'] == 'Кроссовки') return ['Мужские кроссовки', 'Кроссовки', 'Мужские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($offer['categoryId'] == '2371' && $offer['typePrefix'] == 'Кроссовки') return ['Женские кроссовки', 'Кроссовки', 'Женские спортивные кроссовки', 'Спортивные кроссовки'];
  if ($offer['categoryId'] == '236' && $offer['typePrefix'] == 'Куртки') return ['Мужские толстовки', 'Толстовки', 'Мужские спортивные толстовки', 'Спортивные толстовки'];
  if ($offer['categoryId'] == '236' && $offer['typePrefix'] == 'Брюки') return ['Мужские брюки', 'Брюки', 'Мужские спортивные брюки', 'Спортивные брюки'];
  if ($offer['categoryId'] == '240' && $offer['typePrefix'] == 'Платья') return ['Женские платья', 'Платья', 'Женские спортивные платья', 'Спортивные платья'];
  
  return ['Ошибки New Balance'];
}


function name($offer) {
  // Переименовываем некоторые непонятные названия категорий
  $prefix = $offer['typePrefix'];
  
  if ($offer['typePrefix'] == 'Backpack') $prefix = 'Рюкзак';
  if ($offer['typePrefix'] == 'Crossbody') $prefix = 'Сумка';
  if ($offer['typePrefix'] == 'Messenger') $prefix = 'Сумка';
  if ($offer['typePrefix'] == 'Wristlet') $prefix = 'Сумка';
  if ($offer['typePrefix'] == 'Аксессуары для обуви другие') $prefix = 'Аксессуар для обуви';
  if ($offer['typePrefix'] == 'Аксессуары прочие') $prefix = 'Мяч';
  if ($offer['typePrefix'] == 'Жилеты') $prefix = 'Жилет';
  if ($offer['typePrefix'] == 'Кепки') $prefix = 'Кепка';
  if ($offer['typePrefix'] == 'Куртки') $prefix = 'Куртка';
  if ($offer['typePrefix'] == 'Платья') $prefix = 'Платье';
  if ($offer['typePrefix'] == 'Средства по уходу') $prefix = 'Средство по уходу за обувью';
  if ($offer['typePrefix'] == 'Толстовки') $prefix = 'Толстовка';
  if ($offer['typePrefix'] == 'Топы, майки') $prefix = 'Топ/Майка';
  if ($offer['typePrefix'] == 'Футболки') $prefix = 'Футболка';
  if ($offer['typePrefix'] == 'Футболки с длинным рукавом') $prefix = 'Футболка с длинным рукавом';
  if ($offer['typePrefix'] == 'Шапки') $prefix = 'Шапка';
  if ($offer['typePrefix'] == 'Шарфы') $prefix = 'Шарф';
  
  // Удаляем "NB" из name товаров, у котрых это указано
  $newName = $offer['name'];
  
  $deleteNB = array("NB ", " NB", "NB");
  $newName = str_replace($deleteNB, "", $newName);
  
  return $prefix . ' ' . $newName . ' ' . 'New Balance' . ' ' . $offer['params']['Артикул']['val_'];
} 


function cvet($offer) {

  $cvet = $offer['params']['Цвет']['val_'];
  
  if ($cvet == 'Мульти') $cvet = 'Разноцветный';
   
  return $cvet ?? null;
}


function descFirst($offer) {
  
  return $offer['description'] ?? null;
}


function descSecond($offer) {
 	$a = category($offer)[0].' со скидкой '.brend($offer).' по цене '. price($offer);
  
  return $a;
}


function price($offer) {
  return $offer['price'] ?? null;
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
  return 'New balance';
}


function vozrast($offer) {
  // Возраст в оффере указан только взрослый. У детей и малышей и детей не указан вообще. Новорожденных товаров в офферее нет.
  // Поэтому определяем по categoryId (2364 - для малышей, 2365 - для детей, 1223 - смешанные, указываем для детей)
  
   if ($offer['categoryId'] == '2364') return 'Для малышей';
   if ($offer['categoryId'] == '2365' || $offer['categoryId'] == '1223') return 'Для детей';
   if ($offer['params']['Возраст']['val_'] == 'Взрослый') return 'Для взрослых';
  
   return 'Не определено New Balance';
  
}


function pol($offer) {
  // Пол в оффере указан как gender и Пол. Пол только Мужской и Женский. Gender - Мужской, Женский и None.
  // У детей и малышей None
  // Поэтому там, где None - указываем как для девочек, так и для мальчиков
  
  if ($offer['params']['gender']['val_'] == 'Мужской') return 'Для мужчин';
  if ($offer['params']['gender']['val_'] == 'Женский') return 'Для женщин';
  if ($offer['params']['gender']['val_'] == 'None') return ['Для девочек', 'Для мальчиков'];
  
  return 'Не определено New Balance';
}

function uniq($offer) {
  return $offer['params']['Артикул']['val_'];
}