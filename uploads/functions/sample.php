<?php

function category($offer)
{
    return [1];
}

function uniq($offer)
{
    return $offer['typePrefix'] . $offer['param']['gender'] . $offer['name'];
}

function name($offer)
{
    if ($offer['typePrefix'] == 'Crossbody') $offer['typePrefix'] = 'Кросс-боди';

    return $offer['typePrefix'] . ' ' . $offer['name'];
}

function descFirst($offer)
{
    return $offer['description'];
}

function descSecond($offer)
{
    return null;
}

function price($offer)
{
    return $offer['price'];
}

function oldprice($offer)
{
    return $offer['oldprice'] ?? null;
}

function image($offer)
{
    return $offer['picture'];
}

function href($offer)
{
    return $offer['url'];
}
