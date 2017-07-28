<?php



/*

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */



include ('include.php');



$response = file_get_contents(BASE_URL . 'make-pair');



echo '<pre>';

print_r ($response);