<?php

require_once '../../../include/configuration.php';
// Parameters
$city = $_POST["city"];
$sql_inner = "SELECT `id`, `district_id`, `name_en`, `name_si`, `name_ta`, `sub_name_en`, `sub_name_si`, `sub_name_ta`, `postcode`, `latitude`, `longitude` FROM `cities` WHERE `id` LIKE '$city'";
$inner_result = $link->query($sql_inner);
while ($row = $inner_result->fetch_assoc()) {
    $city_name_en = $row['name_en'];
    $city_name_si = $row['name_si'];
    $city_name_ta = $row['name_ta'];
    $postcode = $row['postcode'];
    $district_id = $row['district_id'];

    $sql_inner = "SELECT `id`, `province_id`, `name_en`, `name_si`, `name_ta` FROM `districts` WHERE `id` LIKE '$district_id'";
    $inner_result = $link->query($sql_inner);
    while ($row = $inner_result->fetch_assoc()) {
        $district_name_en = $row['name_en'];
        $district_name_si = $row['name_si'];
        $district_name_ta = $row['name_ta'];
        $province_id = $row['province_id'];
    }
}
echo $postcode;
