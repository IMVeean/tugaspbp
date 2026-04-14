//tugas array function
<?php
//count function
$cars = ['pisang', 'mangga', 'jeruk'];
$panjang = count($cars);
echo "jumlah elemen array: $panjang \n";

//sort function
$tes = sort($cars);
echo "urutan elemen:";
print_r($cars);

//shufle function
$acak = shuffle($cars);
echo "elemen array acak:";
print_r($cars);

// string
$namabuah = $cars[0];
$sub = substr($namabuah, 0, 2);
echo "string: $namabuah \n";
echo "substring: $sub \n";
?>