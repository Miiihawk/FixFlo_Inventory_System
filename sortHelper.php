<?php

function mergeSortProducts(array $products, string $key): array {
    $count = count($products);
    if ($count <= 1) {
        return $products;
    }

    $middle = (int) ($count / 2);
    $left = array_slice($products, 0, $middle);
    $right = array_slice($products, $middle);

    $left = mergeSortProducts($left, $key);
    $right = mergeSortProducts($right, $key);

    return merge($left, $right, $key);
}

function merge(array $left, array $right, string $key): array {
    $result = [];

    while (!empty($left) && !empty($right)) {
        $leftVal = $left[0][$key];
        $rightVal = $right[0][$key];

        if (is_string($leftVal) && is_string($rightVal)) {
            $leftVal = strtolower($leftVal);
            $rightVal = strtolower($rightVal);
        }

        if ($leftVal <= $rightVal) {
            $result[] = array_shift($left);
        } else {
            $result[] = array_shift($right);
        }
    }

    return array_merge($result, $left, $right);
}
