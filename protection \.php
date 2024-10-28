<?php
// ssrf_protection.php

// 허용된 도메인 목록
$allowed_domains = [
    'example.com', // 예시 도메인
    'localhost',    // 로컬호스트
];

// 요청된 URL이 허용된 도메인 목록에 있는지 확인하는 함수
function isAllowedDomain($url) {
    global $allowed_domains;
    $parsed_url = parse_url($url);

    // 도메인만 추출
    $domain = $parsed_url['host'] ?? '';

    // 허용된 도메인 목록에 있는지 확인
    return in_array($domain, $allowed_domains);
}

// SSRF 요청 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $_POST['url'] ?? '';

    // URL 검증
    if (filter_var($url, FILTER_VALIDATE_URL) && isAllowedDomain($url)) {
        // 안전한 요청인 경우
        $response = file_get_contents($url);
        echo "서버로부터 응답을 받았습니다:<br><br>";
        echo nl2br(htmlspecialchars($response)); // HTML 특수 문자를 변환하여 안전하게 출력
    } else {
        // 허용되지 않은 URL인 경우
        echo "허용되지 않은 URL입니다!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSRF 방어 실습</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        input[type="text"] {
            width: 300px;
            padding: 8px;
        }
        input[type="submit"] {
            padding: 8px 12px;
        }
    </style>
</head>
<body>
    <h1>SSRF 방어 실습</h1>
    <form method="POST" action="">
        <label for="url">URL 입력:</label>
        <input type="text" id="url" name="url" required>
        <input type="submit" value="요청 보내기">
    </form>
</body>
</html>
