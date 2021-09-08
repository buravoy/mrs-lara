<?php

function available($offer) {
  return true;
}

function uniq($offer) {
  return $offer['vendorCode'];
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

function category($offer) {
    return ['Рабочая Original Marines'];
}

// Пол указан не у всех. 2 варианта - Девочки, Мальчики
// Возраст указан у всех детский, в т.ч. и у новорожденных.
// Поэтому возраст определяем по размеру, у кого не указан размер - по росту.
// Возраст можно определить по атрибуту размер. Он не указан у 4 товаров, видимо опечатка.
function vozrast($offer) {
  if (isset($offer['params']['Размер']['val_'])) {
    $newVozrast = $offer['params']['Размер']['val_'];
    if(in_array($newVozrast, ["0 месяцев", "0-1 месяцев", "0-3 месяцев", "0-6 месяцев", "1 месяц", "3 месяца", "3-6 месяцев (Рост 62-68)", "44/46 (6-12 мес)", "6 месяцев", "6-12 месяцев", "6-9 месяцев (Рост 68-74)", "9 месяцев", "9-12 месяцев (Рост 74-80)", "15/18", "42", "44", "Универсальный"], TRUE))
      return 'для новорожденных';
    if(in_array($newVozrast, ["12-18 месяцев (Рост 80-86)", "12-24 месяцев", "18-24 месяцев (Рост 86-92)", "2-4 лет", "24-36 месяцев (Рост 92-98)", "30-36 месяцев (Рост 92-98)", "46/48 (12-24 мес)", "48/50 (24-36 мес)", "19/21", "22/24", "23/27"], TRUE))
      return 'для малышей';
    if(in_array($newVozrast, ["10-11 лет (Рост 140-146)", "10-12 лет (Рост 140-152)", "11-12 лет (Рост 146-152)", "12-13 лет (Рост 152-158)", "13-14 лет (Рост 158-164)", "3-4 года (Рост 98-104)", "3-6 лет", "3-8 лет", "4-5 лет (Рост 104-110)", "4-6 лет", "6-7 лет (Рост 116-122)", "6-8 лет", "7-14 лет", "7-8 лет (Рост 122-128)", "8-10 лет", "8-14 лет", "8-9 лет (Рост 128-134)", "9-10 лет (Рост 134-140)", "25/30", "28/30", "31/33", "31/36", "34/36", "37/39", "37/41", "5-6 лет (Рост 110-116)", "50/53 (3-8 лет)", "53/56 (8-14 лет)", "52", "56", "58", "S"], TRUE))
      return 'для детей';
  } else if (isset($offer['params']['Рост']['val_'])) {
    $newVozrastRost = $offer['params']['Рост']['val_'];
    if ($newVozrastRost >= '97') return 'для детей';
  }
    return 'Не определено Original Marines';
}

function pol($offer) {
    $vozrast = vozrast($offer);
  if (isset($offer['params']['Пол']['val_'])) {
    $newPol = $offer['params']['Пол']['val_'];
    if ($vozrast == 'для новорожденных') return null;
    if ($newPol == 'Девочки' && $vozrast == 'для малышей') return 'для девочек';
    if ($newPol == 'Мальчики' && $vozrast == 'для малышей') return 'для мальчиков';
    if ($newPol == 'Девочки' && $vozrast == 'для детей') return 'для девочек';
    if ($newPol == 'Мальчики' && $vozrast == 'для детей') return 'для мальчиков';
  }
    return 'Не определено Original Marines';
}

function name($offer) {
  if (isset($offer['name'])) {
    $name = $offer['name'];
  } else $name = 'Товар';
  if (isset($offer['vendorCode'])) {
    $article = ' ' . $offer['vendorCode'];
  } else $article = null;
  $newName = $name . $article;
  return $newName;
}

function cvet($offer) {
  if (isset($offer['params']['Цвет']['val_'])) {
    $name = $offer['params']['Цвет']['val_'];
    return $name;
  }
  return null;
}

function brend($offer) {
  return 'Original Marines';
}

function magazin($offer) {
  return 'Original Marines';
}

function descFirst($offer) {
  return null;
}

function descSecond($offer) {
  return null;
}



// 
//