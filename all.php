
<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include 'randomData.php';
include 'db.php';
include 'array.php';
//set_time_limit(0);

//$conn->begin_transaction();

                           
$sql = "INSERT INTO log_proses (note, created_at, updated_at) VALUES ('Start', now(), now())";
 if ($conn->query($sql) === TRUE) {
     echo "Start\n";
 }
                                        
// URL halaman
$startTime = microtime(true);
$credentials=generateCredential();

foreach ($credentials as $credential) {
    // Mengakses username dan password dari setiap array asosiatif
    $username = $credential['username'];
    $password = $credential['password'];
    echo  "Username: ".$username."\n";
    // Mencetak atau memproses data

    $url = 'https://salesvisit.cbn.net.id';
    $cookieJar = tempnam(sys_get_temp_dir(), 'cookie');
    // Inisialisasi cURL session
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
    $html = curl_exec($ch);
    curl_close($ch);
    
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
            if ($response) {
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
                        $x = 0;
                        $y = 0;
                        $z = 0;
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
                                try {
                                    $checkResult = $conn->query($checkSql);
                                } catch (mysqli_sql_exception $e) {
                                    if ($e->getCode() == 2006) { // 2006 adalah kode eror untuk "MySQL server has gone away"
                                    $servername = "151.106.119.252"; // Host server, biasanya localhost
                                    $username_mysql = "cbnb9676_cbnbandung_user"; // Username untuk akses database
                                    $password = "Arkan@199003"; // Password untuk akses database
                                    $dbname = "cbnb9676_cbnbandung"; // Nama database yang akan digunakan
                                    
                                    // Membuat koneksi ke database
                                    $conn = new mysqli($servername, $username_mysql, $password, $dbname);
                                       
                                        $checkResult = $conn->query($checkSql); // Coba query lagi
                                    } else {
                                        throw $e; // Lempar kembali jika eror bukan karena MySQL server has gone away
                                    }
                                }
                               // $checkResult = $conn->query($checkSql);
                                
                                if ($checkResult->num_rows > 0) {
                                    // Jika home_id sudah ada
                                    $x++;
                                    //echo $x++.". Home Id: $value -> sudah di submit.<br>";
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
                                        if( $jsonObject->message = "Store Data Successfully"){
                                            $y++;    
                                        }else{
                                            $z++;
                                        }
                                        
                                    } else {
                                        
                                        echo "Error: " . $sql . "<br>" . $conn->error;
                                    }
        
                                }    
                            }
                            
                        }
                    } else {
                        echo  "Elemen select tidak ditemukan\n";
                    }
                } else {
                    echo  "Gagal mengambil HTML\n";
                }
            }
            unlink($cookieJar);
            echo "Result: ".$x."-".$y."-".$z."\n";
        } else {
            echo  "Token tidak ditemukan\n";
        }
        
    } else {
        echo  "Gagal mengambil HTML\n";
    }
}


 
//$conn->commit();


try {
                                    $sql = "INSERT INTO log_proses (note, created_at, updated_at) VALUES ('End', now(), now())";
                                       
                                        if ($conn->query($sql) === TRUE) {
                                             echo "End\n";
                                         }
                                } catch (mysqli_sql_exception $e) {
                                    if ($e->getCode() == 2006) { // 2006 adalah kode eror untuk "MySQL server has gone away"
                                    $servername = "151.106.119.252"; // Host server, biasanya localhost
                                    $username_mysql = "cbnb9676_cbnbandung_user"; // Username untuk akses database
                                    $password = "Arkan@199003"; // Password untuk akses database
                                    $dbname = "cbnb9676_cbnbandung"; // Nama database yang akan digunakan
                                    
                                    // Membuat koneksi ke database
                                    $conn = new mysqli($servername, $username_mysql, $password, $dbname);
                                       $sql = "INSERT INTO log_proses (note, created_at, updated_at) VALUES ('End', now(), now())";
                                       
                                        if ($conn->query($sql) === TRUE) {
                                             echo "End\n";
                                         }
                                         // Coba query lagi
                                    } else {
                                        throw $e; // Lempar kembali jika eror bukan karena MySQL server has gone away
                                    }
                                }

$conn->close();

 
$endTime = microtime(true);

// Hitung durasi
$duration = $endTime - $startTime;

$hours = floor($duration / 3600);
$minutes = floor(floor($duration % 3600) / 60);
$seconds = floor($duration % 60);

// Format output: HH:MM:SS
echo ("Durasi: " . sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds));


?>