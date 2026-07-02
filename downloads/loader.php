<?php
// Hàm tính CRC32 file từ server
function getFileCRC32Stream($filePath) {
    if (!file_exists($filePath)) return false;

    $crc = hash_init('crc32b');
    $handle = fopen($filePath, 'rb');
    if (!$handle) return false;

    while (!feof($handle)) {
        $data = fread($handle, 1024);
        hash_update($crc, $data);
    }
    fclose($handle);

    return hexdec(hash_final($crc));
}

$clientAbi = $_POST['abi'] ?? $_GET['abi'] ?? 'unknown';
$clientCrc = $_POST['crc'] ?? $_GET['crc'] ?? 0;

$filePath = __DIR__ . '/release/' . $clientAbi . '.so';
$serverCrc = getFileCRC32Stream($filePath);

if ($serverCrc === 0) {
    http_response_code(404);
    echo "File does not exist on server.";
    exit;
}

if ($clientCrc == $serverCrc) {
    echo '';
} else {
    if (file_exists($filePath)) {
        header('Content-Type: application/octet-stream');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
    } else {
        echo "File does not exist on server.";
        http_response_code(404);
    }
}
?>
