<?php

/**
 * @param $a
 * @param $b
 */
function swap(&$a, &$b)
{
    $tmp = $a;
    $a = $b;
    $b = $tmp;
}

/**
 * 冒泡排序
 * @param array $arr
 * @return array
 */
function bubble_sort(array $arr): array
{
    $len = count($arr);
    for ($i = 0; $i < $len - 1; $i++) {
        for ($j = 0; $j < $len - 1 - $i; $j++) {
            if ($arr[$j] > $arr[$j + 1]) swap($arr[$j], $arr[$j + 1]);
        }
    }
    return $arr;
}

/**
 * 插入排序
 * @param array $arr
 * @return array
 */
function insert_sort(array $arr): array
{
    $len = count($arr);
    for ($i = 1; $i < $len; $i++) {
        $key = $arr[$i];
        for ($j = $i - 1; $j >= 0 && $arr[$j] > $key; $j--) {
            $arr[$j + 1] = $arr[$j];
            $arr[$j] = $key;
        }
    }
    return $arr;

}

/**
 * 插入排序的改进-希尔排序
 * @param array $arr
 * @return array
 */
function shell_sort(array $arr) : array
{
    $len = count($arr);
    for ($gap = $len >> 1; $gap > 0; $gap >>= 1) {
        for ($i = $gap; $i < $len; $i++) {
            $key = $arr[$i];
            for ($j = $i - $gap; $j >= 0 && $key < $arr[$j]; $j -= $gap) {
                $arr[$j + $gap] = $arr[$j];
                $arr[$j] = $key;
            }
        }
    }
    return $arr;
}


/**
 * 选择排序
 * @param array $arr
 * @return array
 */
function select_sort(array $arr) : array
{
    $len = count($arr);
    for ($i = 0; $i < $len - 1; $i++) {
        $key = $i;
        for ($j = $i + 1; $j < $len; $j++) {
            if ($arr[$j] < $arr[$key]) $key = $j;
        }
        swap($arr[$i], $arr[$key]);
    }
    return $arr;
}

/**
 * 选择排序的改进--堆排序
 * @param array $arr
 * @return array
 */
function heap_sort(array $arr) : array
{
    $len = count($arr);
    build_heap($arr);//第一次构建堆
    while (--$len) {
        swap($arr[0], $arr[$len]);//交换首尾
        heap_adjust($arr, 0, $len);//重新调整堆
    }
    return $arr;
}

/**
 * 第一次构建堆
 * @param array $arr
 */
function build_heap(array &$arr)
{
    $len = count($arr);
    for ($i = floor($len / 2) - 1; $i >= 0; $i--) {
        heap_adjust($arr, $i, $len);
    }
}

/**
 * 调整堆
 * @param array $arr
 * @param int $i
 * @param int $num
 */
function heap_adjust(array &$arr, $i, $num)
{
    if ($i > $num / 2) return;
    $key = $i;
    $left_child = 2 * $i + 1;
    $right_child = 2 * $i + 2;
    if ($left_child < $num && $arr[$key] < $arr[$left_child]) {
        $key = $left_child;
    }
    if ($right_child < $num && $arr[$key] < $arr[$right_child]) {
        $key = $right_child;
    }
    if ($key != $i) {
        swap($arr[$i], $arr[$key]);
        heap_adjust($arr, $key, $num);
    }
}

/**
 * 归并排序
 * @param array $arr
 * @return array
 */
function merge_sort(array $arr) : array
{
    $len = count($arr);
    if ($len <= 1) return $arr;

    $left = merge_sort(array_slice($arr, 0, floor($len / 2)));
    $right = merge_sort(array_slice($arr, floor($len / 2)));
    return merge($left, $right);
}

/**
 * 归并排序合并函数
 * @param array $left
 * @param array $right
 * @return array
 */
function merge(array $left, array $right) : array
{
    $res = [];
    $i = $j = 0;
    while ($i < count($left) && $j < count($right)) {
        if ($left[$i] < $right[$j]) {
            $res[] = $left[$i];
            $i++;
        } else {
            $res[] = $right[$j];
            $j++;
        }
    }

    /*将剩下的放到后面*/
    if ($i < count($left)) {
        $res = array_merge($res, array_slice($left, $i));
    }
    if ($j < count($right)) {
        $res = array_merge($res, array_slice($right, $j));
    }

    return $res;
}

/**
 * 快速排序
 * @param array $arr
 * @param int $left
 * @param null $right
 * @return array
 */
function quick_sort(array &$arr, $left = 0, $right = null) : array
{
    $len = count($arr);
    if (is_null($right)) $right = $len - 1;
    if ($left >= $right) return $arr;

    $key = $arr[$left];
    $low = $left;
    $high = $right;

    while ($left < $right) {
        while ($left < $right && $arr[$right] >= $key) {
            $right--;
        }
        $arr[$left] = $arr[$right];
        while ($left < $right && $arr[$left] < $key) {
            $left++;
        }
        $arr[$right] = $arr[$left];
    }
    $arr[$right] = $key;
    quick_sort($arr, $low, $left - 1);
    quick_sort($arr, $left + 1, $high);
    return $arr;
}


###########################下面的排序未测###########################
/**
 * 基数排序
 *
 * @param array $arr
 * @return array
 */
function radix_sort(array $arr)
{
    $radix = 10;
    $max = max($arr);
    $k = ceil(log($max, $radix));
    if ($max == pow($radix, $k)) {
        $k++;
    }
    for ($i = 1; $i <= $k; $i++) {
        $newLists = array_fill(0, $radix, []);
        for ($j = 0; $j < count($arr); $j++) {
            $key = $arr[$j] / pow($radix, $i - 1) % $radix;
            $newLists[$key][] = $arr[$j];
        }
        $arr = [];
        for ($j = 0; $j < $radix; $j++) {
            $arr = array_merge($arr, $newLists[$j]);
        }
    }
    return $arr;
}


/**
 * 计数排序
 *
 * @param array $arr
 * @return array
 */
function counting_sort($arr)
{

    $length = count($arr);
    if ($length <= 1) return $arr;

    $size = count($arr);
    $max = $arr[0];

    //找出数组中最大的数
    for ($i = 1; $i < $size; $i++) {
        if ($max < $arr[$i]) $max = $arr[$i];
    }

    //初始化用来计数的数组
    for ($i = 0; $i <= $max; $i++) {
        $count_arr[$i] = 0;
    }

    //对计数数组中键值等于$arr[$i]的加1
    for ($i = 0; $i < $size; $i++) {
        $count_arr[$arr[$i]]++;
    }

    //相邻的两个值相加
    for ($i = 1; $i <= $max; $i++) {
        $count_arr[$i] = $count_arr[$i - 1] + $count_arr[$i];
    }

    //键与值翻转
    for ($i = $size - 1; $i >= 0; $i--) {
        $over_turn[$count_arr[$arr[$i]]] = $arr[$i];
        $count_arr[$arr[$i]]--; // 前一个数找到位置后，那么和它值相同的数位置往前一步
    }

    //按照顺序排列
    $result = array();
    for ($i = 1; $i <= $size; $i++) {
        array_push($result, $over_turn[$i]);
    }

    return $result;
}

/**
 * 梳排序
 *
 * @param array $arr
 * @return array
 */
function comb_sort($arr)
{
    $length = count($arr);
    $step = (int)floor($length / 1.3);
    while ($step >= 1) {
        for ($i = 0; $i < $length; $i++) {

            if ($i + $step < $length && $arr[$i] > $arr[$i + $step]) {
                $temp = $arr[$i];
                $arr[$i] = $arr[$i + $step];
                $arr[$i + $step] = $temp;
            }

            if ($i + $step > $length) {
                break;
            }

        }
        $step = (int)floor($step / 1.3);
    }
    return $arr;
}


/**
 * 桶排序
 * @param array $arr
 * @return array
 */
function bucket_sort($arr)
{
    $result = [];
    $length = count($arr);
    //入桶
    for ($i = 0, $max = $arr[$i]; $i < $length; $i++) {
        if ($max < $arr[$i]) {
            $max = $arr[$i];
        }
        $bucket[$arr[$i]] = [];
        array_push($bucket[$arr[$i]], $arr[$i]);
    }
    //出桶
    for ($i = 0; $i <= $max; $i++) {
        if (!empty($bucket[$i])) {
            $l = count($bucket[$i]);
            for ($j = 0; $j < $l; $j++) {
                $result[] = $bucket[$i][$j];
            }
        }
    }
    return $result;
}
