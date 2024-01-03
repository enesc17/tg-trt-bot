<?php
// İstek yapılan URL
$url = "https://www.trthaber.com/xml_mobile.php?tur=xml_genel&kategori=spor&adet=1";

// URL'den XML çekme
$xml = simplexml_load_file($url);

// XML içindeki bilgileri çekme
$foto = (string)$xml->haber->haber_resim;
$baslik = (string)$xml->haber->haber_manset;
$aciklama = (string)$xml->haber->haber_aciklama;
$haber_id = (string)$xml->haber->haber_id;

// Çekilen bilgileri ekrana yazdırma


// Dosya ismi
$file = "son.txt";

// Dosya kontrolü ve işlemler
if(file_exists($file)) {
    // Dosya varsa, içeriğini oku
    $content = file_get_contents($file);

    // İçerik ile haber id eşleşiyor mu kontrol et
    if($content == $haber_id) {
        // Eşleşiyorsa, zaten kayıtlı mesajı yazdır
        echo "Zaten kayıtlı.";
    } else {
        // Eşleşmiyorsa, yeni haber id'yi dosyaya yaz
        file_put_contents($file, $haber_id);
        echo "Foto: $foto <br>";
        echo "Başlık: $baslik <br>";
        echo "Açıklama: $aciklama <br>";
        echo "Haber ID: $haber_id <br>";


        $id="@trt_son_haber";  //telegram için

        $fr="<strong>$baslik</strong>\n\n$aciklama";  //içerik telegram
        $fr=urlencode($fr);

        file_get_contents("https://api.telegram.org/bot6241327226:AAEx609GG39qLHxdw04yR9-XnpeeWzU9YiY/sendPhoto?chat_id=$id&photo=$foto&parse_mode=HTML&caption=$fr");



    }
} else {
    // Dosya yoksa, yeni haber id'yi dosyaya yaz
    file_put_contents($file, $haber_id);
}

?>

