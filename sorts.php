<?php
/**
 * Created by PhpStorm.
 * User: syw
 * Date: 17-5-5
 * Time: 下午4:28
 * Title:每天一个排序算法
 */

/**
 * 插入排序
 * @param array $arr
 * @return array
 */
function insert_sort(array $arr)
{
    for ($i = 1; $i < count($arr); $i++) {
        $key = $arr[$i];
        for ($j = $i - 1; $j >= 0 && $arr[$j] > $key; $j--) {
            $arr[$j + 1] = $arr[$j];
            $arr[$j] = $key;
        }
    }
    return $arr;
}

/**
 * 希尔排序 标准
 *
 * @param array $arr
 * @return array
 */
function shell_sort(array $arr)
{
    $n = count($arr);
    $step = 2;
    $gap = intval($n / $step);
    while ($gap > 0) {
        for ($gi = 0; $gi < $gap; $gi++) {
            for ($i = $gi; $i < $n; $i += $gap) {
                $key = $arr[$i];
                for ($j = $i - $gap; $j >= 0 && $arr[$j] > $key; $j -= $gap) {
                    $arr[$j + $gap] = $arr[$j];
                    $arr[$j] = $key;
                }
            }
        }
        $gap = intval($gap / $step);
    }
    return $arr;
}
function shell_sort1($arr)
{
    //计算数组长度
    $length = count($arr);
    //计算增量
    for ($gap = $length >> 1; $gap > 0; $gap >>= 1) {
        //根据增量进行分组，进行直接插入排序
        for ($i = $gap; $i < $length; $i++) {
            $tmp = $arr[$i];
            for ($j = $i - $gap; $j > 0 && $tmp < $arr[$j]; $j -= $gap) {
                $arr[$j + $gap] = $arr[$j];
                $arr[$j] = $tmp;
            }
        }
    }
    return $arr;
}


/**
 * 冒泡排序
 *
 * @param array $arr
 * @return array
 */
function bubble_sort($arr)
{
    $count = count($arr);
    //外层控制排序轮次
    for ($i = 0; $i < $count - 1; $i++) {
        //内层控制每轮比较次数
        for ($j = 0; $j < $count - 1 - $i; $j++) {
            if ($arr[$j] > $arr[$j + 1]) {
                $temp = $arr[$j];
                $arr[$j] = $arr[$j + 1];
                $arr[$j + 1] = $temp;
            }
        }
    }
    return $arr;
}


/**
 * 快速排序
 *
 * @param array $arr
 * @param $left
 * @param $right
 * @return array
 */
function quick_sort(array &$arr, $left = 0, $right = null)
{
    if (is_null($right)) {//是否为null，是就初始化
        $right = count($arr) - 1;
    }
    if ($left >= $right) {//如果左下标大于等于右小标则说明排序完成，退出
        return $arr;
    }
    $key = $arr[$left];//基准默认为left
    //备份左右下标
    $low = $left;
    $high = $right;

    while ($left < $right) {
        while ($left < $right && $arr[$right] > $key) {
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

/**
 * 直接选择排序
 *
 * @param array $arr
 * @return array
 */
function select_sort(array $arr)
{
    $len = count($arr);
    for ($i = 0; $i < $len - 1; $i++) {
        $key = $i;
        for ($j = $i + 1; $j < $len; $j++) {
            if ($arr[$j] < $arr[$key]) {
                $key = $j;
            }
        }
        $val = $arr[$key];
        $arr[$key] = $arr[$i];
        $arr[$i] = $val;
    }
    return $arr;
}

/**
 * 堆排序
 *
 * @param array $arr
 * @return array
 */
function heap_sort(array $arr)
{
    $len = count($arr);
    build_heap($arr);//生成一个堆

    while (--$len) {
        swap($arr[0], $arr[$len]);
        heap_adjust($arr, 0, $len);//重新调整堆
    }
    return $arr;
}

//第一次构建堆
function build_heap(array &$arr)
{
    $len = count($arr);
    for ($i = floor(($len) / 2) - 1; $i >= 0; $i--) {
        heap_adjust($arr, $i, $len);
    }
}

//调整堆
function heap_adjust(array &$arr, $i, $num)
{
    if ($i > $num / 2) return;
    $key = $i;
    //因为从下标0开始，所以不是2*i和2*i + 1
    $left_child = $i * 2 + 1;
    $right_child = $i * 2 + 2;

    if ($left_child < $num && $arr[$left_child] > $arr[$key]) {
        $key = $left_child;
    }

    if ($right_child < $num && $arr[$right_child] > $arr[$key]) {
        $key = $right_child;
    }

    if ($key != $i) {
        swap($arr[$i], $arr[$key]);
        heap_adjust($arr, $key, $num);
    }
}

function swap(&$v1, &$v2)
{
    $tmp = $v1;
    $v1 = $v2;
    $v2 = $tmp;
}


/**
 * 归并排序
 *
 * @param array $arr
 * @return array
 */
function merge_sort(array $arr)
{
    $n = count($arr);
    if ($n <= 1) {
        return $arr;
    }
    $left = merge_sort(array_slice($arr, 0, floor($n / 2)));
    $right = merge_sort(array_slice($arr, floor($n / 2)));
    $arr = merge($left, $right);
    return $arr;
}

function merge(array $left, array $right)
{
    $arr = [];
    $i = $j = 0;
    while ($i < count($left) && $j < count($right)) {
        if ($left[$i] < $right[$j]) {
            $arr[] = $left[$i];
            $i++;
        } else {
            $arr[] = $right[$j];
            $j++;
        }
    }
    $arr = array_merge($arr, array_slice($left, $i));
    $arr = array_merge($arr, array_slice($right, $j));
    return $arr;
}

var_dump(merge_sort([13, 2, 89, 10, 56]));exit();

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