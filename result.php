<a href="index.php">Back</a><br>
<?php
set_time_limit(0);
include 'randomData.php';
include 'array.php';
include 'db.php';
$startTime = microtime(true);
$credentials=generateCredential();

foreach ($credentials as $credential) {
    // Mengakses username dan password dari setiap array asosiatif
    $username = $credential['username'];
    $password = $credential['password'];
    echo "Username:".$username."<br>";
    // Mencetak atau memproses data

    // Query untuk menselect data berdasarkan username
$sql = "SELECT count(1) as jml FROM tbl_result WHERE username = '$username'  and date(created_at)=date(now())  group by username";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data setiap baris
    while($row = $result->fetch_assoc()) {
        echo "Result: " . $row["jml"]."<br>";
    }
} else {
    echo "Result: 0<br>";
}

// URL halaman

// $url = 'https://salesvisit.cbn.net.id';
// $cookieJar = tempnam(sys_get_temp_dir(), 'cookie');
// // Inisialisasi cURL session
// $ch = curl_init($url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
// $html = curl_exec($ch);
// curl_close($ch);


           
// // Mengecek jika HTML berhasil diambil
// if ($html) {
//     // Membuat DOMDocument dan memuat HTML
//     $doc = new DOMDocument();
//     @$doc->loadHTML($html);

//     // Membuat DOMXPath
//     $xpath = new DOMXPath($doc);

//     // Mencari elemen dengan name="_token"
//     $nodes = $xpath->query('//input[@name="_token"]');

//     // Mengecek jika elemen ditemukan
//     if ($nodes->length > 0) {
//         $token = $nodes->item(0)->getAttribute('value');
//         //echo "Token: " . $token;

//         //login
//         $urlLogin = 'https://salesvisit.cbn.net.id/CheckLogin';

//         // Data yang akan dikirim
//         $data = array(
          
//             'username' => $username, 
//             'password' =>  $password, 
//             '_token' => $token
//         );
       
//         $ch = curl_init($urlLogin);
//         curl_setopt($ch, CURLOPT_POST, true);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
//         $response = curl_exec($ch);
//         curl_close($ch);


       
//         $today=date('Y-m-d');
//         $url = 'https://salesvisit.cbn.net.id/dtListSalesVisiting?startdate='.$today.'&enddate='.$today.'&length=NaN&_=1704364715860';

//         // Inisialisasi cURL session
//         $ch = curl_init($url);

//         // Setelan cURL
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//         curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
//         // Eksekusi cURL
//         $html = curl_exec($ch);

//         // Tutup cURL session
//         curl_close($ch);

//         // Mengecek jika HTML berhasil diambil
//         if ($html) {
           
//             $jsonObject = json_decode($html);
//             echo "Result: ".$jsonObject->recordsTotal."<br>";
//         } else {
//             echo "Gagal mengambil HTML";
//         }
//         unlink($cookieJar);
//         //die;

//         //save



//     } else {
//         echo "Token tidak ditemukan";
//     }
// } else {
//     echo "Gagal mengambil HTML";
// }

}

$conn->close();
$endTime = microtime(true);

// Hitung durasi
$duration = $endTime - $startTime;

$hours = floor($duration / 3600);
$minutes = floor(($duration % 3600) / 60);
$seconds = $duration % 60;

// Format output: HH:MM:SS
echo ("Durasi: " . sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds));
?>