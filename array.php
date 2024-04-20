<?php
function generateCredential() {

/*$data = "username:zenal.w
password:neverquit
username:agin.an
password:neverquit
username:Silvia.n
password:neverquit
username:dian.sya
password:neverquit
username:kiki.n
password:P@ssw0rd2K23
username:C.iman
password:neverquit
username:andi.wg
password:P@ssw0rd2K23
username:haldy.fazar
password:P@ssw0rd2K23
username:dani.k
password:P@ssw0rd2K23
username:ngudi
password:tigersquad7
username:indra.n
password:P@ssw0rd2K22
username:lufty.a
password:P@ssw0rd2K23
username:m.yusup
password:P@ssw0rd2K23
username:rizki.suwanta
password:P@ssw0rd2K23
username:soleh
password:P@ssw0rd2K23
username:Ani.meilani
password:neverquit
username:Iswarotun
password:P@ssw0rd2K20
username:andri.tz
password:P@ssw0rd2K23";*/
$data = "username:Silvia.n
password:neverquit";


// Pecah string menjadi baris
$lines = explode("\n", $data);

$credentials = [];
$temp = [];

foreach ($lines as $line) {
    // Pecah setiap baris menjadi kunci dan nilai
    list($key, $value) = explode(":", $line);

    $temp[trim($key)] = trim($value);

    // Jika telah menemukan pasangan username dan password, tambahkan ke array credentials
    if (isset($temp['username']) && isset($temp['password'])) {
        $credentials[] = $temp;
        $temp = []; // Reset temp untuk pasangan berikutnya
    }
}

// Cetak array untuk melihat strukturnya

return $credentials;
}
?>