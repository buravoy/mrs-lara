<?php

// (Рабочая) Получаем артикул товара
function newArticle($offer) {
  if (isset($offer['vendorCode'])) {
    $newArticle = $offer['vendorCode'];
    return $newArticle;
  } else return null;
}

function category($offer) {
  return ['Рабочая The North Face'];
}

function cvet($offer) {
  // Цвет указан не у всех и с маленькой буквы
  if (isset($offer['params']['Цвет']['val_'])) {
    $newCvet = $offer['params']['Цвет']['val_'];
  return $newCvet;
  } else return null;
}

function magazin($offer) {
  return 'The North Face';
}

function vozrast($offer) {
  // Возраст в оффере можно определить по ID категории. Но малышей в товарах нет.
  // Поэтому определим по полу
  
  if (isset($offer['params']['Пол']['val_'])) {
    $newVozrast = $offer['params']['Пол']['val_'];
    if ($newVozrast == 'Мужчинам') $newVozrast = 'Для взрослых';
    if ($newVozrast == 'Женщинам') $newVozrast = 'Для взрослых';
    if ($newVozrast == 'Унисекс') $newVozrast = 'Для взрослых';
    if ($newVozrast == 'Детям') $newVozrast = 'Для детей';
  return $newVozrast;
  } else return 'Не определено The North Face';
}

function pol($offer) {
  // Пол в оффере указан так - Мужчинам/Детям/Женщинам/Унисекс
  // Пол в оффере можно определить также по ID категории. Унисекс - это взрослые, поэтому работаем только с детьми.
  
  if (isset($offer['params']['Пол']['val_'], $offer['name'])) {
    $newPol = $offer['params']['Пол']['val_'];
    $name = mb_strtolower($offer['name']);
    if ($newPol == 'Мужчинам') return 'Для мужчин';
    if ($newPol == 'Женщинам') return 'Для женщин';
    if ($newPol == 'Унисекс'&& strstr($name, 'жен')) return 'Для женщин';
    if ($newPol == 'Унисекс'&& strstr($name, 'муж')) return 'Для мужчин';
    if ($newPol == 'Унисекс') return ['Для мужчин', 'Для женщин'];
    if ($newPol == 'Детям' && strstr($name, 'мальч')) return 'Для мальчиков';
    if ($newPol == 'Детям' && strstr($name, 'девоч')) return 'Для девочек';
    if ($newPol == 'Детям' && !strstr($name, 'девоч') && !strstr($name, 'мальч')) return ['Для девочек', 'Для мальчиков'];
  return 'Не определено The North Face';
  } else return 'Не определено The North Face';
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

function brend($offer) {
  return 'The North Face';
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

function descFirst($offer) {
  $text = 'Модель ' . newArticle($offer) . ' от The North Face. Купить в интернет-магазине с доставкой. ' . category($offer)[0] . ' по супер цене.';
  return $text;
}



function descSecond($offer) {
  return null;
}