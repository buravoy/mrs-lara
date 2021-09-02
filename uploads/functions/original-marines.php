<?php

function available($offer) {
  return true;
}

function uniq($offer) {
  return $offer['vendorCode'];
}

// Пол указан у всех. 2 варианта - Девочки, Мальчики


// Возраст можно определить по атрибуту размер. Он не указан у 4 товаров, видимо опечатка.
function vozrast($offer) {
  if (isset($offer['params']['Размер']['val_'])) {
    $newVozrast = $offer['params']['Размер']['val_'];
    if ($newVozrast == 'Жен.') $newVozrast = 'Для взрослых';
    if ($newVozrast == 'Муж.') $newVozrast = 'Для взрослых';
    if ($newVozrast == 'Девич.') $newVozrast = 'Для детей';
    if ($newVozrast == 'Мальч.') $newVozrast = 'Для детей';
  return $newVozrast;
  } else return 'Не определено Thomas Munz';
}
// 
//