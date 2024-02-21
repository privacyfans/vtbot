<a href="index.php">Back</a><br>
<?php
include 'randomData.php';
include 'db.php';



// URL halaman
$startTime = microtime(true);
$url = 'https://salesvisit.cbn.net.id';
$cookieJar = tempnam(sys_get_temp_dir(), 'cookie');
// Inisialisasi cURL session
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
$html = curl_exec($ch);
curl_close($ch);

$username=$_POST['username'];
echo "Username: ".$username."<br>";
echo "Result:<br>";
if($username == 'kiki.n'){
    $password = 'P@ssw0rd2K23';
}elseif($username == 'C.iman'){
    $password = 'neverquit';
}elseif($username == 'andi.wg'){
    $password = 'P@ssw0rd2K23';
}elseif($username == 'haldy.fazar'){
    $password = 'P@ssw0rd2K23';
}elseif($username == 'Iswarotun'){
    $password = 'P@ssw0rd2K20';
}elseif($username == 'andri.tz'){
    $password = 'P@ssw0rd2K23';
}elseif($username == 'dani.k'){
    $password = 'P@ssw0rd2K23';
}elseif($username == 'ngudi'){
    $password = 'tigersquad7';
}elseif($username == 'indra.n'){
    $password = 'P@ssw0rd2K22';
}elseif($username == 'lufty.a'){
    $password = 'P@ssw0rd2K23';
}elseif($username == 'm.yusup'){
    $password = 'P@ssw0rd2K23';
}elseif($username == 'rizki.suwanta'){
    $password = 'P@ssw0rd2K23';
}elseif($username == 'soleh'){
    $password = 'P@ssw0rd2K23';
}elseif($username == 'Ani.meilani'){
    $password = 'neverquit';
}elseif($username == 'Silvia.n'){
    $password = 'neverquit';
}elseif($username == 'dian.sya'){
    $password = 'neverquit';
}elseif($username == 'zenal.w'){
    $password = 'neverquit';
}elseif($username == 'agin.an'){
    $password = 'neverquit';
}

            //'username' => 'kiki.n', 
            //'password' => 'P@ssw0rd2K23', 
            //'username' => 'C.iman', 
            //'password' => 'neverquit', 
            //'username' => 'andi.wg', 
            //'password' => 'P@ssw0rd2K23', 
            //'username' => 'haldy.fazar', 
            //'password' => 'P@ssw0rd2K23', 
            // 'username' => 'Iswarotun', 
            // 'password' => 'P@ssw0rd2K20', 
            // 'username' => 'andri.tz', 
            // 'password' => 'P@ssw0rd2K23', 
            // 'username' => 'dani.k', 
            // 'password' => 'P@ssw0rd2K23', 
            // 'username' => 'ngudi', 
            // 'password' => 'tigersquad7', 
            // 'username' => 'indra.n', 
            // 'password' => 'P@ssw0rd2K22', 
            // 'username' => 'lufty.a', 
            // 'password' => 'P@ssw0rd2K23', 
            // 'username' => 'm.yusup', 
            // 'password' => 'P@ssw0rd2K23', 
            // 'username' => 'rizki.suwanta', 
            // 'password' => 'P@ssw0rd2K23', 
            // 'username' => 'soleh', 
            // 'password' => 'P@ssw0rd2K23', 
            // 'username' => 'Ani.meilani', 
            // 'password' => 'neverquit', 
            // 'username' => 'Silvia.n', 
            // 'password' => 'neverquit', 
            // 'username' => 'dian.sya', 
            // 'password' => 'neverquit', 
// Mengecek jika HTML berhasil diambil
if ($html) {
    // Membuat DOMDocument dan memuat HTML
    $doc = new DOMDocument();
    @$doc->loadHTML($html);

    // Membuat DOMXPath
    $xpath = new DOMXPath($doc);

    // Mencari elemen dengan name="_token"
    $nodes = $xpath->query('//input[@name="_token"]');

    // Mengecek jika elemen ditemukan
    if ($nodes->length > 0) {
        $token = $nodes->item(0)->getAttribute('value');
        //echo "Token: " . $token;

        //login
        $urlLogin = 'https://salesvisit.cbn.net.id/CheckLogin';

        // Data yang akan dikirim
        $data = array(
          
            'username' => $username, 
            'password' => $password, 
            '_token' => $token
        );
       
        $ch = curl_init($urlLogin);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
        $response = curl_exec($ch);
        curl_close($ch);


        //get homeid

        $url = 'https://salesvisit.cbn.net.id/FormVisitWeb';

        // Inisialisasi cURL session
        $ch = curl_init($url);

        // Setelan cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
        // Eksekusi cURL
        $html = curl_exec($ch);

        // Tutup cURL session
        curl_close($ch);

        // Mengecek jika HTML berhasil diambil
        if ($html) {
            // Membuat DOMDocument dan memuat HTML
            $doc = new DOMDocument();
            @$doc->loadHTML($html);

            // Membuat DOMXPath
            $xpath = new DOMXPath($doc);

            // Mencari elemen select dengan id 'inptHomeId'
            $selectElement = $xpath->query('//select[@id="inptHomeId"]')->item(0);

            if ($selectElement) {
                // Iterasi melalui semua elemen option di dalam select
                $x = 1;
                foreach ($selectElement->getElementsByTagName('option') as $option) {
                    $value = $option->getAttribute('value');
                    $text = $option->nodeValue;
                    //echo "Value: $value, Text: $text\n";
                    if ($value != "") {
                        $urlPost = 'https://salesvisit.cbn.net.id/saveSalesVisiting';

                        if (strpos($text, 'Occupied') !== false) {
                            $result = "ACTIV";
                            $remark = "-";
                        } else {
                            $nonOccupiedResults = [
                                "XTHER",
                                "XINTR",
                                "OTISP",
                                "DISCS"
                            ];
                            $result = $nonOccupiedResults[array_rand($nonOccupiedResults)];
                            $remark = "-";
                        }

                        // Data yang akan dikirim
                        $data = array(
                            '_token' => $token,
                            'HomeId' => $value,
                            'NamaCustomer' => generateRandomName(),
                            'TelpNoCustomer' => generateRandomPhoneNumber(),
                            'TypeOfBuilding' => 'RESI',
                            'Activity' => 'PROB',
                            'Hasil' => $result,
                            'ProviderExisting' => 'INDI',
                            'Otherprovider' => '',
                            'ProductType' => 'JR',
                            'Notes' => '-',
                            'HomeIdName' => $text,
                            'latitude' => '-6.914426748720025',
                            'longitude' => '107.59474479479847',
                        );


                        $checkSql = "SELECT * FROM tbl_result WHERE home_id = '$value' AND DATE(created_at) = DATE(NOW())";
                        $checkResult = $conn->query($checkSql);
                        if ($checkResult->num_rows > 0) {
                            // Jika home_id sudah ada
                            echo $x++.". Home Id: $value -> sudah di submit.<br>";
                        } else {
                            $ch = curl_init($urlPost);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
                            $response = curl_exec($ch);
    
                            curl_close($ch);
                            $jsonObject = json_decode($response);
                            
                            $created_at = date('Y-m-d H:i:s'); // Menggunakan tanggal dan waktu saat ini
                            $updated_at = date('Y-m-d H:i:s'); // Menggunakan tanggal dan waktu saat ini
    
                           
    
                            // Query untuk insert data
                            $sql = "INSERT INTO tbl_result (username, home_id, result, created_at, updated_at) VALUES ('$username', '$value', '$jsonObject->message', '$created_at', '$updated_at')";
    
                            if ($conn->query($sql) === TRUE) {
                                echo ($x++ . ". Home Id: " . $value . " -> " . $jsonObject->message) . "<br>";
                            } else {
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }

                        }    
                    }
                    
                }
            } else {
                echo "Elemen select tidak ditemukan";
            }
        } else {
            echo "Gagal mengambil HTML";
        }
        unlink($cookieJar);
        //die;

        //save



    } else {
        echo "Token tidak ditemukan";
    }
} else {
    echo "Gagal mengambil HTML";
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