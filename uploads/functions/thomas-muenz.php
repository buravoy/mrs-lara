<?php

function specialName($offer)
{
    return null;
}


function available($offer) {
  return true;
}

// (Рабочая) Получаем артикул товара
function newArticle($offer) {
  if (isset($offer['vendorCode'])) {
    $newArticle = $offer['vendorCode'];
    return $newArticle;
  } else return null;
}

// (Рабочая) Получаем категорию общую для описания
function catOne($offer) {
  if (isset($offer['params']['Тип']['val_'])) {
    $catOneNew = $offer['params']['Тип']['val_'];
    $deleteGender = array(" женские", " женская", " женское", " женский", " мужские", " мужская", " мужское", " мужской", " девичьи"," мальчиковые");
    $catOneNew = str_replace($deleteGender, "", $catOneNew);
  } else $catOneNew = 'Товар';
  return $catOneNew;
}

// (Рабочая) Получаем сезон для описания
function sezonDesc($offer) {
  if (isset($offer['params']['Сезон']['val_'])) {
    $newSezon = $offer['params']['Сезон']['val_'];
    if ($newSezon == 'Межсезонная') return ' исключительно для межсезона';
    if ($newSezon == 'Демисезонная') return ' исключительно для демисезона';
    if ($newSezon == 'Лето') return ' исключительно для лета';
    if ($newSezon == 'Всесезонная') return ' - для всех сезонов';
    if ($newSezon == 'Весна-осень') return ' и для весны и для осени';
    if ($newSezon == 'Зима') return ' исключительно для зимы';
  return $newSezon;
  } else return null;
}

// (Рабочая) Получаем коллекцию для описания
function collection($offer) {
  if (isset($offer['params']['Коллекция']['val_'])) {
    $newCollection = $offer['params']['Коллекция']['val_'];
    if ($newCollection == 'Прошлые коллекции') $newCollection = 'прошлогодним';
  return 'Стоит обратить внимание, что данная модель относится к коллекциям ' . $newCollection . '.';
  } else return null;
}

// (Рабочая) Получаем материал верха для описания
function materialDesc($offer) {
  if (isset($offer['params']['Материал верха']['val_'])) {
    $newMaterialDesc = $offer['params']['Материал верха']['val_'];
  return ' Нельзя не отметить, что материал изделия - ' . $newMaterialDesc . '.';
  } else return null;
}

// (Рабочая) Получаем материал подкладки для описания
function podkladkaDesc($offer) {
  if ((isset($offer['params']['Материал подкладки']['val_'])) && $offer['params']['Материал подкладки']['val_'] != 'Нет'){
    $newPodkladkaDesc = $offer['params']['Материал подкладки']['val_'];
  return ' А материал подкладки - это ' . $newPodkladkaDesc . '.';
  } else return null;
}

// (Рабочая) Получаем высоту каблука для описания
function vysota_kablukaDesc($offer) {
  if (isset($offer['params']['Высота каблука']['val_'])){
    $newVysota_kablukaDesc = $offer['params']['Высота каблука']['val_'];
  return ' Высота каблука, если быть точным, ' . $newVysota_kablukaDesc . ' мм.';
  } else return null;
}

function category($offer) {
  if (isset($offer['params']['Тип']['val_'], $offer['params']['Пол']['val_'])) {
    $pol = mb_strtolower($offer['params']['Пол']['val_']);
    $cat = mb_strtolower($offer['params']['Тип']['val_']);
    
  if ($cat == 'балетки женские') return ['женские балетки', 'балетки'];
  if ($cat == 'берет женский') return ['женские береты', 'береты'];
  if ($cat == 'босоножки женские') return ['женские босоножки', 'босоножки'];
  if ($cat == 'ботильоны женские') return ['женские ботильоны', 'ботильоны'];
  if ($cat == 'ботильоны' && $pol == 'женские') return ['женские ботильоны', 'ботильоны']; //Косяк в парсере, пол назван не как обычно
  if ($cat == 'ботинки девичьи') return ['ботинки для девочек', 'детские ботинки', 'ботинки'];
  if ($cat == 'борсетка мужская') return ['мужские борсетки', 'борсетки'];
  if ($cat == 'ботинки для активного отдыха девичьи') return ['ботинки для девочек', 'детские ботинки', 'ботинки'];
  if ($cat == 'ботинки для активного отдыха женские') return ['женские ботинки', 'ботинки'];
  if ($cat == 'ботинки для активного отдыха мальчиковые') return ['ботинки для мальчиков', 'детские ботинки', 'ботинки'];
  if ($cat == 'ботинки для активного отдыха мужские') return ['мужские ботинки', 'ботинки'];
  if ($cat == 'ботинки женские') return ['женские ботинки', 'ботинки'];
  if ($cat == 'ботинки мальчиковые') return ['ботинки для мальчиков', 'детские ботинки', 'ботинки'];
  if ($cat == 'ботинки мужские') return ['мужские ботинки', 'ботинки'];
  if ($cat == 'ботфорты женские') return ['женские ботфорты', 'ботфорты'];
  if ($cat == 'зонт мужской') return ['мужские зонты', 'зонты'];
  if ($cat == 'клатч женский') return ['женские клатчи', 'клатчи'];
  if ($cat == 'кроссбоди женский') return ['женские сумки кросс-боди', 'сумки кросс-боди'];
  if ($cat == 'кроссбоди мужской') return ['мужские сумки кросс-боди', 'сумки кросс-боди'];
  if ($cat == 'кроссовки высокие женские') return ['женские высокие кроссовки', 'высокие кроссовки'];
  if ($cat == 'кроссовки высокие мужские') return ['мужские высокие кроссовки', 'высокие кроссовки'];
  if ($cat == 'кроссовки девичьи') return ['кроссовки для девочек', 'детские кроссовки', 'кроссовки'];
  if ($cat == 'кроссовки женские') return ['женские кроссовки', 'кроссовки'];
  if ($cat == 'кроссовки мальчиковые') return ['кроссовки для мальчиков', 'детские кроссовки', 'кроссовки'];
  if ($cat == 'кроссовки мужские') return ['мужские кроссовки', 'кроссовки'];
  if ($cat == 'мессенджер женский') return ['женские сумки мессенджеры', 'сумки мессенджеры'];
  if ($cat == 'мессенджер мужской') return ['мужские сумки мессенджеры', 'сумки мессенджеры'];
  if ($cat == 'мокасины женские') return ['женские мокасины', 'мокасины'];
  if ($cat == 'мокасины мужские') return ['мужские мокасины', 'мокасины'];
  if ($cat == 'палантин женский') return ['женские палантины', 'палантины'];
  if ($cat == 'пантолеты (шлепанцы) пляжные мужские') return ['мужские шлепанцы', 'шлепанцы'];
  if ($cat == 'парэо') return ['женские парео', 'парео'];
  if ($cat == 'платок женский') return ['женские платки', 'платки'];
  if ($cat == 'пляжная сумка женская') return ['женские пляжные сумки', 'пляжные сумки'];
  if ($cat == 'полуботинки девичьи') return ['полуботинки для девочек', 'детские полуботинки', 'полуботинки'];
  if ($cat == 'полуботинки для активного отдыха девичьи') return ['полуботинки для девочек', 'детские полуботинки', 'полуботинки'];
  if ($cat == 'полуботинки для активного отдыха женские') return ['женские полуботинки', 'полуботинки'];
  if ($cat == 'полуботинки для активного отдыха мальчиковые') return ['полуботинки для мальчиков', 'детские полуботинки', 'полуботинки'];
  if ($cat == 'полуботинки для активного отдыха мужские') return ['мужские полуботинки', 'полуботинки'];
  if ($cat == 'полуботинки женские') return ['женские полуботинки', 'полуботинки'];
  if ($cat == 'полуботинки мальчиковые') return ['полуботинки для девочек', 'детские полуботинки', 'полуботинки'];
  if ($cat == 'полуботинки мужские') return ['мужские полуботинки', 'полуботинки'];
  if ($cat == 'полусапоги девичьи') return ['полусапоги для девочек', 'детские полусапоги', 'полусапоги'];
  if ($cat == 'полусапоги для активного отдыха девичьи') return ['полусапоги для девочек', 'детские полусапоги', 'полусапоги'];
  if ($cat == 'полусапоги для активного отдыха мальчиковые') return ['полусапоги для мальчиков', 'детские полусапоги', 'полусапоги'];
  if ($cat == 'полусапоги женские') return ['женские полусапоги', 'полусапоги'];
  if ($cat == 'полусапоги мальчиковые') return ['полусапоги для мальчиков', 'детские полусапоги', 'полусапоги'];
  if ($cat == 'портфель мужской') return ['мужские портфели', 'портфели'];
  if ($cat == 'рюкзак женский') return ['женские рюкзаки', 'рюкзаки'];
  if ($cat == 'рюкзак мужской') return ['мужские рюкзаки', 'рюкзаки'];
  if ($cat == 'сабо женские') return ['женские сабо', 'сабо'];
  if ($cat == 'сабо мужские') return ['мужские сабо', 'сабо'];
  if ($cat == 'сандалии девичьи') return ['сандалии для девочек', 'детские сандалии', 'сандалии'];
  if ($cat == 'сандалии женские') return ['женские сандалии', 'сандалии'];
  if ($cat == 'сандалии мальчиковые') return ['сандалии для мальчиков', 'детские сандалии', 'сандалии'];
  if ($cat == 'сандалии мужские') return ['мужские сандалии', 'сандалии'];
  if ($cat == 'сапоги девичьи') return ['сапоги для девочек', 'детские сапоги', 'сапоги'];
  if ($cat == 'сапоги для активного отдыха девичьи') return ['сапоги для девочек', 'детские сапоги', 'сапоги'];
  if ($cat == 'сапоги женские') return ['женские сапоги', 'сапоги'];
  if ($cat == 'сумка дамская') return ['женские сумки', 'сумки'];
  if ($cat == 'сумка женская') return ['женские сумки', 'сумки'];
  if ($cat == 'сумка поясная женская') return ['женские поясные сумки', 'поясные сумки'];
  if ($cat == 'туфли девичьи') return ['туфли для девочек', 'детские туфли', 'туфли'];
  if ($cat == 'туфли женские') return ['женские туфли', 'туфли'];
  if ($cat == 'туфли мальчиковые') return ['туфли для мальчиков', 'детские туфли', 'туфли'];
  if ($cat == 'туфли мужские') return ['мужские туфли', 'туфли'];
  if ($cat == 'шапка женская') return ['женские шапки', 'шапки'];
  if ($cat == 'шарф женский') return ['женские шарфы', 'шарфы'];
  if ($cat == 'шарф мужской') return ['мужские шарфы', 'шарфы'];
  if ($cat == 'шарф-труба женский') return ['женские шарфы-трубы', 'шарфы-трубы'];
  if ($cat == 'кеды' && $pol == 'жен.') return ['женские кеды', 'кеды'];
  if ($cat == 'кеды' && $pol == 'муж.') return ['мужские кеды', 'кеды'];
  if ($cat == 'кеды' && $pol == 'девич.') return ['кеды для девочек', 'детские кеды', 'кеды'];
  if ($cat == 'кеды' && $pol == 'мальч.') return ['кеды для мальчиков', 'детские кеды', 'кеды'];
  if ($cat == 'слипоны' && $pol == 'жен.') return ['женские слипоны', 'слипоны'];
  if ($cat == 'слипоны' && $pol == 'муж.') return ['мужские слипоны', 'слипоны'];
  if ($cat == 'слипоны' && $pol == 'девич.') return ['слипоны для девочек', 'детские слипоны', 'слипоны'];
  if ($cat == 'слипоны' && $pol == 'мальч.') return ['слипоны для мальчиков', 'детские слипоны', 'слипоны'];
  if ($cat == 'шапка молодежная' && $pol == 'жен.') return ['женские шапки', 'шапки'];
  if ($cat == 'шапка молодежная' && $pol == 'муж.') return ['мужские шапки', 'шапки'];
  if ($cat == 'шапка молодежная' && $pol == 'девич.') return ['шапки для девочек', 'детские шапки', 'шапки'];
  if ($cat == 'шапка молодежная' && $pol == 'мальч.') return ['шапки для мальчиков', 'детские шапки', 'шапки'];
  if ($cat == 'угги' && $pol == 'жен.') return ['женские угги', 'угги'];
  if ($cat == 'угги' && $pol == 'муж.') return ['мужские угги', 'угги'];
  if ($cat == 'угги' && $pol == 'девич.') return ['угги для девочек', 'детские угги', 'угги'];
  if ($cat == 'угги' && $pol == 'мальч.') return ['угги для мальчиков', 'детские угги', 'угги'];

  return ['ошибки thomas munz'];
}
  return null;
}

function cvet($offer) {
  if (isset($offer['params']['Цвет']['val_'])) {
    $newCvet = mb_strtolower($offer['params']['Цвет']['val_']);
    if ($newCvet == 'мульти') $newCvet = 'разноцветный';
    if ($newCvet == 'комбинированный') $newCvet = 'разноцветный';
  return $newCvet;
  } else return null;
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
  return $offer['vendor'] ?? 'Ошибки Thomas Munz';
}

function magazin($offer) {
  return 'Thomas Munz';
}

function vozrast($offer) {
  // В офеере у всех товаров указан Пол, от него и отталкиваемся
  if (isset($offer['params']['Пол']['val_'])) {
    $newVozrast = $offer['params']['Пол']['val_'];
    if ($newVozrast == 'Жен.') $newVozrast = 'для взрослых';
    if ($newVozrast == 'Женские') $newVozrast = 'для взрослых';
    if ($newVozrast == 'Муж.') $newVozrast = 'для взрослых';
    if ($newVozrast == 'Девич.') $newVozrast = 'для детей';
    if ($newVozrast == 'Мальч.') $newVozrast = 'для детей';
  return $newVozrast;
  } else return 'Не определено Thomas Munz';
}

function pol($offer) {
  // В офеере нет товаров для малышей и новорожденных, но у всех товаров указан Пол, от него и отталкиваемся
  if (isset($offer['params']['Пол']['val_'])) {
    $newPol = $offer['params']['Пол']['val_'];
    if ($newPol == 'Жен.') $newPol = 'для женщин';
    if ($newPol == 'Женские') $newPol = 'для женщин';
    if ($newPol == 'Муж.') $newPol = 'для мужчин';
    if ($newPol == 'Девич.') $newPol = 'для девочек';
    if ($newPol == 'Мальч.') $newPol = 'для мальчиков';
  return $newPol;
  } else return 'Не определено Thomas Munz';
}

function name($offer) {
  if (isset($offer['name'])) {
    $newName = $offer['name'];
  } else $newName = 'Товар';
   if (isset($offer['vendorCode'])) {
    $newArticle = $offer['vendorCode'];
  } else $newArticle = null;
  return $newName . ' ' .  $newArticle;
}

function sezon($offer) {
  if (isset($offer['params']['Сезон']['val_'])) {
    $newSezon = mb_strtolower($offer['params']['Сезон']['val_']);
    if ($newSezon == 'межсезонная') return 'демисезон';
    if ($newSezon == 'демисезонная') return 'демисезон';
    if ($newSezon == 'лето') return 'лето';
    if ($newSezon == 'всесезонная') return 'всесезон';
    if ($newSezon == 'весна-осень') return ['весна', 'осень'];
    if ($newSezon == 'зима') return 'зима';
  return $newSezon;
  } else return null;
}

function vysota_kabluka($offer) {
  if (isset($offer['params']['Высота каблука']['val_'])) {
    $newVysota = $offer['params']['Высота каблука']['val_']/10;
    $newVysota = round($newVysota) . ' ' . 'см';
    return $newVysota;
  } else return null;
}

function material_verha($offer) {
  if (isset($offer['params']['Материал верха']['val_'])) {
    $newMaterial = mb_strtolower($offer['params']['Материал верха']['val_']);
    if ($newMaterial == 'кожа из спилка') return 'спилок';
    return $newMaterial;
  } else return null;
}

function material_podkladki($offer) {
  if (isset($offer['params']['Материал подкладки']['val_'])) {
    $newMaterial = mb_strtolower($offer['params']['Материал подкладки']['val_']);
    if ($newMaterial == 'нет') return null;
    return $newMaterial;
  } else return null;
}

function uniq($offer) {
  return $offer['name'] . ' ' .  $offer['vendorCode'];
}

function descFirst($offer) {
  $text = 'Модель ' . newArticle($offer) . ' от ' . brend($offer) . '. Купить в интернет-магазине с доставкой. ' . category($offer)[0] . ' по недорогой цене.';
  return $text;
}

function descSecond($offer) {
  if (isset($offer['params']['Тип']['val_'])) {
    $cat = $offer['params']['Тип']['val_'];
  } else $cat = 'Товар';
  $text = $cat .' от бренда ' . brend($offer) . '. Артикул модели - ' . newArticle($offer) . ', цвет ' . cvet($offer) . ', дизайн разработан специально ' . vozrast($offer) . '. В интернет-магазине цена указана со скидкой и можно купить с доставкой по Москве и России, либо самовывозом из магазина. ' . catOne($offer) . ' ' . pol($offer) . sezonDesc($offer) . '. ' . collection($offer) . materialDesc($offer) . podkladkaDesc($offer) . vysota_kablukaDesc($offer);
  return $text;
}