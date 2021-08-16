<?php

function category($offer) {
  return 'Рабочая The North Face';
}


function uniq($offer) {
  return $offer['vendorCode'];
}


function name($offer) {
  return $offer['name'].' '.$offer['vendorCode'];
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
  return 'The North Face';
}


function vozrast($offer) {
  // Возраст в оффере можно определить только по ID категории
  
  //if ($offer['categoryId'] == '') return 'Для малышей';
  //if ($offer['categoryId'] == '' || $offer['categoryId'] == '1223') return 'Для детей';
  //if ($offer['categoryId'] == '') return 'Для взрослых';
  
  //return 'Не определено The North Face';
  return null; //Временно
}


function pol($offer) {
  // Пол в оффере указан так - Мужчинам/Детям/Женщинам/Унисекс
  // Пол в оффере можно определить только по ID категории
  
  //if ($offer['categoryId'] == '') return 'Для мужчин';
  //if ($offer['categoryId'] == '') return 'Для женщин';
  //if ($offer['categoryId'] == '') return 'Для девочек';
  //if ($offer['categoryId'] == '') return 'Для мальчиков';
  //if ($offer['categoryId'] == '') return ['Для девочек', 'Для мальчиков'];
  
  //return 'Не определено The North Face';
  return null; //Временно
}


function cvet($offer) {
  //Указан цвет с маленькой буквы. И не у всех указан цвет.
  $cvet = $offer['params']['Цвет']['val_'];
   
  return $cvet ?? null;
}