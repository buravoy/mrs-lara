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
    $pol = $offer['params']['Пол']['val_'];
    $cat = $offer['params']['Тип']['val_'];
    
  if ($cat == 'Балетки женские') return ['Женские балетки', 'Балетки'];
  if ($cat == 'Берет женский') return ['Женские береты', 'Береты'];
  if ($cat == 'Босоножки женские') return ['Женские босоножки', 'Босоножки'];
  if ($cat == 'Ботильоны женские') return ['Женские ботильоны', 'Ботильоны'];
  if ($cat == 'Ботинки девичьи') return ['Ботинки для девочек', 'Ботинки'];
  if ($cat == 'Ботинки для активного отдыха девичьи') return ['Ботинки для активного отдыха для девочек', 'Ботинки для активного отдыха'];
  if ($cat == 'Ботинки для активного отдыха женские') return ['Женские ботинки для активного отдыха', 'Ботинки для активного отдыха'];
  if ($cat == 'Ботинки для активного отдыха мальчиковые') return ['Ботинки для активного отдыха для мальчиков', 'Ботинки для активного отдыха'];
  if ($cat == 'Ботинки для активного отдыха мужские') return ['Мужские ботинки для активного отдыха', 'Ботинки для активного отдыха'];
  if ($cat == 'Ботинки женские') return ['Женские ботинки', 'Ботинки'];
  if ($cat == 'Ботинки мальчиковые') return ['Ботинки для мальчиков', 'Ботинки'];
  if ($cat == 'Ботинки мужские') return ['Мужские ботинки', 'Ботинки'];
  if ($cat == 'Ботфорты женские') return ['Женские ботфорты', 'Ботфорты'];
  if ($cat == 'Зонт мужской') return ['Мужские зонты', 'Зонты'];
  if ($cat == 'Клатч женский') return ['Женские клатчи', 'Клатчи'];
  if ($cat == 'Кроссбоди женский') return ['Женские сумки кросс-боди', 'Сумки кросс-боди'];
  if ($cat == 'Кроссбоди мужской') return ['Мужские сумки кросс-боди', 'Сумки кросс-боди'];
  if ($cat == 'Кроссовки высокие женские') return ['Женские высокие кроссовки', 'Высокие кроссовки'];
  if ($cat == 'Кроссовки высокие мужские') return ['Мужские высокие кроссовки', 'Высокие кроссовки'];
  if ($cat == 'Кроссовки девичьи') return ['Кроссовки для девочек', 'Кроссовки'];
  if ($cat == 'Кроссовки женские') return ['Женские кроссовки', 'Кроссовки'];
  if ($cat == 'Кроссовки мальчиковые') return ['Кроссовки для мальчиков', 'Кроссовки'];
  if ($cat == 'Кроссовки мужские') return ['Мужские кроссовки', 'Кроссовки'];
  if ($cat == 'Мессенджер женский') return ['Женские сумки мессенджеры', 'Сумки мессенджеры'];
  if ($cat == 'Мессенджер мужской') return ['Мужские сумки мессенджеры', 'Сумки мессенджеры'];
  if ($cat == 'Мокасины женские') return ['Женские мокасины', 'Мокасины'];
  if ($cat == 'Мокасины мужские') return ['Мужские мокасины', 'Мокасины'];
  if ($cat == 'Палантин женский') return ['Женские палантины', 'Палантины'];
  if ($cat == 'Пантолеты (шлепанцы) пляжные мужские') return ['Мужские шлепанцы', 'Шлепанцы'];
  if ($cat == 'Парэо') return ['Женские парео', 'Парео'];
  if ($cat == 'Пляжная сумка женская') return ['Женские пляжные сумки', 'Пляжные сумки'];
  if ($cat == 'Полуботинки девичьи') return ['Полуботинки для девочек', 'Полуботинки'];
  if ($cat == 'Полуботинки для активного отдыха девичьи') return ['Полуботинки для активного отдыха для девочек', 'Полуботинки для активного отдыха'];
  if ($cat == 'Полуботинки для активного отдыха женские') return ['Женские полуботинки для активного отдыха', 'Полуботинки для активного отдыха'];
  if ($cat == 'Полуботинки для активного отдыха мальчиковые') return ['Полуботинки для активного отдыха для мальчиков', 'Полуботинки для активного отдыха'];
  if ($cat == 'Полуботинки для активного отдыха мужские') return ['Мужские полуботинки для активного отдыха', 'Полуботинки для активного отдыха'];
  if ($cat == 'Полуботинки женские') return ['Женские полуботинки', 'Полуботинки'];
  if ($cat == 'Полуботинки мальчиковые') return ['Полуботинки для девочек', 'Полуботинки'];
  if ($cat == 'Полуботинки мужские') return ['Мужские полуботинки', 'Полуботинки'];
  if ($cat == 'Полусапоги девичьи') return ['Полусапоги для девочек', 'Полусапоги'];
  if ($cat == 'Полусапоги для активного отдыха девичьи') return ['Полусапоги для активного отдыха для девочек', 'Полусапоги для активного отдыха'];
  if ($cat == 'Полусапоги для активного отдыха мальчиковые') return ['Полусапоги для активного отдыха для мальчиков', 'Полусапоги для активного отдыха'];
  if ($cat == 'Полусапоги женские') return ['Женские полусапоги', 'Полусапоги'];
  if ($cat == 'Полусапоги мальчиковые') return ['Полусапоги для мальчиков', 'Полусапоги'];
  if ($cat == 'Портфель мужской') return ['Мужские портфели', 'Портфели'];
  if ($cat == 'Рюкзак женский') return ['Женские рюкзаки', 'Рюкзаки'];
  if ($cat == 'Рюкзак мужской') return ['Мужские рюкзаки', 'Рюкзаки'];
  if ($cat == 'Сабо женские') return ['Женские сабо', 'Сабо'];
  if ($cat == 'Сабо мужские') return ['Мужские сабо', 'Сабо'];
  if ($cat == 'Сандалии девичьи') return ['Сандалии для девочек', 'Сандалии'];
  if ($cat == 'Сандалии женские') return ['Женские сандалии', 'Сандалии'];
  if ($cat == 'Сандалии мальчиковые') return ['Сандалии для мальчиков', 'Сандалии'];
  if ($cat == 'Сандалии мужские') return ['Мужские сандалии', 'Сандалии'];
  if ($cat == 'Сапоги девичьи') return ['Сапоги для девочек', 'Сапоги'];
  if ($cat == 'Сапоги для активного отдыха девичьи') return ['Сапоги для активного отдыха для девочек', 'Сапоги для активного отдыха'];
  if ($cat == 'Сапоги женские') return ['Женские сапоги', 'Сапоги'];
  if ($cat == 'Сумка дамская') return ['Женские сумки', 'Сумки'];
  if ($cat == 'Сумка женская') return ['Женские сумки', 'Сумки'];
  if ($cat == 'Сумка поясная женская') return ['Женские поясные сумки', 'Поясные сумки'];
  if ($cat == 'Туфли девичьи') return ['Туфли для девочек', 'Туфли'];
  if ($cat == 'Туфли женские') return ['Женские туфли', 'Туфли'];
  if ($cat == 'Туфли мальчиковые') return ['Туфли для мальчиков', 'Туфли'];
  if ($cat == 'Туфли мужские') return ['Мужские туфли', 'Туфли'];
  if ($cat == 'Шапка женская') return ['Женские шапки', 'Шапки'];
  if ($cat == 'Шарф женский') return ['Женские шарфы', 'Шарфы'];
  if ($cat == 'Шарф мужской') return ['Мужские шарфы', 'Шарфы'];
  if ($cat == 'Шарф-труба женский') return ['Женские шарфы-трубы', 'Шарфы-трубы'];
  if ($cat == 'кеды' && $pol == 'Жен.') return ['Женские кеды', 'Кеды'];
  if ($cat == 'кеды' && $pol == 'Муж.') return ['Мужские кеды', 'Кеды'];
  if ($cat == 'кеды' && $pol == 'Девич.') return ['Кеды для девочек', 'Кеды'];
  if ($cat == 'кеды' && $pol == 'Мальч.') return ['Кеды для мальчиков', 'Кеды'];
  if ($cat == 'слипоны' && $pol == 'Жен.') return ['Женские слипоны', 'Слипоны'];
  if ($cat == 'слипоны' && $pol == 'Муж.') return ['Мужские слипоны', 'Слипоны'];
  if ($cat == 'слипоны' && $pol == 'Девич.') return ['Слипоны для девочек', 'Слипоны'];
  if ($cat == 'слипоны' && $pol == 'Мальч.') return ['Слипоны для мальчиков', 'Слипоны'];
  if ($cat == 'Шапка молодежная' && $pol == 'Жен.') return ['Женские шапки', 'Шапки'];
  if ($cat == 'Шапка молодежная' && $pol == 'Муж.') return ['Мужские шапки', 'Шапки'];
  if ($cat == 'Шапка молодежная' && $pol == 'Девич.') return ['Шапки для девочек', 'Шапки'];
  if ($cat == 'Шапка молодежная' && $pol == 'Мальч.') return ['Шапки для мальчиков', 'Шапки'];

  return ['Ошибки Thomas Munz'];
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