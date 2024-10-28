<?php
if (isset($_GET['url'])) {
    $url = $_GET['url'];

    // 기본 검증 (실제 공격에서는 우회할 수 있습니다)
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        // 서버 측 요청 수행
        $response = file_get_contents($url);
        echo "<h1>SSRF 공격 결과</h1>";
        echo "<pre>" . htmlspecialchars($response) . "</pre>";
    } else {
        echo "유효하지 않은 URL입니다.";
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSRF 공격</title>
</head>
<body>
    <h1>SSRF 공격 페이지</h1>
    <form method="GET" action="">
        <label for="url">URL 입력:</label>
        <input type="text" id="url" name="url" required>
        <input type="submit" value="공격">
    </form>
</body>
</html>
