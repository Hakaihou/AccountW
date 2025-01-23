<?php

require_once '/var/php-files/conf.php';
// Список запрещенных доменов
$blockedDomains = include '/var/php-files/blocked_domains.php';

//Список запрещенных слов
$forbiddenWords = include '/var/php-files/forbidden_words.php';

// Получаем путь к текущему скрипту
$currentScriptPath = dirname(__FILE__);

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname, $port);
// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}


$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$country = $_POST['countryCode'];
$ip = $_SERVER['REMOTE_ADDR'];  // Получаем IP пользователя
$aff_sub = $_POST['aff_sub'];
$aff_sub11 = $_POST['aff_sub11'] ?? 'empty';
$aff_sub14 = $_POST['langCode'];
$aff_sub4 = $_POST['address']  ?? 'empty';
$aff_sub5 = '';  // Или любое другое значение
$aff_sub2 = $_POST['aff_sub2'];
$aff_sub3 = $_POST['aff_sub3'];
$widget = $_POST['widget'] ?? 'empty';
$offer_id = '2';  // Значение по умолчанию
$affiliate_id = '67';  // Значение по умолчанию
$response = '{response.json}';


// Проверка наличия обязательных данных в $_POST
if (!isset($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['phone'], $_POST['aff_sub'], $_POST['aff_sub3'], $_POST['widget'],)) {
    die('Отсутствуют обязательные данные в форме.');
}


// Получаем домен из email
$emailDomain = substr(strrchr($_POST['email'], "@"), 1);

// Проверка, входит ли домен в список запрещенных
if (in_array($emailDomain, $blockedDomains)) {
    // Если входит, перенаправляем на фейковую страницу спасибо
    header("Location: uoykcuf.php");
    exit();
}

function containsForbiddenWords($input, $forbiddenWords)
{
    foreach ($forbiddenWords as $word) {
        if (stripos($input, $word) !== false) {
            return true;
        }
    }
    return false;
}


//Проверка на наличие в инпутах запрещенных слов
if (containsForbiddenWords($firstName, $forbiddenWords) || containsForbiddenWords($lastName, $forbiddenWords) || containsForbiddenWords($email, $forbiddenWords)) {
    // Если содержат, перенаправляем на фейковую страницу спасибо
    header("Location: uoykcuf.php");
    exit();
}

$utmCampaign = $_POST['utm_campaign'] ?? '';

// Функция для генерации пароля
function generatePassword()
{
    $chars = 'abcdefghijklmnopqrstuvwxyz';
    $upperChars = strtoupper($chars);
    $digits = '0123456789';

    // Генерируем пароль
    $password = '';

    // Генерируем одну большую букву
    $password .= $upperChars[rand(0, strlen($upperChars) - 1)];

    // Генерируем одну цифру
    $password .= $digits[rand(0, strlen($digits) - 1)];

    // Генерируем остальные символы пароля
    for ($i = 0; $i < 6; $i++) {
        $password .= $chars[rand(0, strlen($chars) - 1)];
    }

    // Перемешиваем символы
    $password = str_shuffle($password);

    return $password;
}

function getUserIP()
{
    // Проверяем, определен ли IP-адрес пользователя
    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

$user_ip = getUserIP();
$user_mail = $_POST['email'];

// Путь к файлу, где хранятся данные о заявках
$logFile = 'ip_log.json';
$logFileMail = 'email_log.json';

// Загрузка данных о заявках
if (file_exists($logFile)) {
    $ipLog = json_decode(file_get_contents($logFile), true);
} else {
    $ipLog = [];
}

if (file_exists($logFileMail)) {
    $emailLog = json_decode(file_get_contents($logFileMail), true);
} else {
    $emailLog = [];
}

// Проверка количества заявок с одного IP за последние 7 дней
$limit = 1; // Максимальное количество заявок с одного IP или почты в неделю
$timeLimit = 7 * 24 * 60 * 60; // Время в секундах (7 дней)

if (isset($ipLog[$user_ip])) {
    $ipData = $ipLog[$user_ip]['timestamps'];
    $ipCount = $ipLog[$user_ip]['count'];

    // Удаление старых записей
    $ipData = array_filter($ipData, function ($timestamp) use ($timeLimit) {
        return (time() - $timestamp) < $timeLimit;
    });

    if (count($ipData) >= $limit) {
        // Увеличиваем счетчик повторяющихся заявок
        $ipLog[$user_ip]['count'] = $ipCount + 1;
        file_put_contents($logFile, json_encode($ipLog));

        //Перенаправляем на страницу "Вы уже зарегистрированы"
        header("Location: duplicate.php");
        exit();
    }

    $ipData[] = time();
    $ipLog[$user_ip]['timestamps'] = $ipData;
} else {
    $ipLog[$user_ip] = [
        'timestamps' => [time()],
        'count' => 1
    ];
}


// Проверка количества заявок с одной почты за последние 7 дней

if (isset($emailLog[$user_mail])) {
    $mailData = $emailLog[$user_mail]['timestamps'];
    $mailCount = $emailLog[$user_mail]['count'];

    // Удаление старых записей
    $mailData = array_filter($mailData, function ($timestamp) use ($timeLimit) {
        return (time() - $timestamp) < $timeLimit;
    });

    if (count($mailData) >= $limit) {
        // Увеличиваем счетчик повторяющихся заявок
        $emailLog[$user_mail]['count'] = $mailCount + 1;
        file_put_contents($logFileMail, json_encode($emailLog));

        //Перенаправляем на страницу "Вы уже зарегистрированы"
        header("Location: duplicate.php");
        exit();
    }

    $mailData[] = time();
    $emailLog[$user_mail]['timestamps'] = $mailData;
} else {
    $emailLog[$user_mail] = [
        'timestamps' => [time()],
        'count' => 1
    ];
}


// Сохранение обновленных данных о заявках
file_put_contents($logFile, json_encode($ipLog)); // для IP
file_put_contents($logFileMail, json_encode($emailLog)); //для почты

$apiData = [
    'first_name' => $_POST['firstName'],
    'last_name' => $_POST['lastName'],
    'email' => $_POST['email'],
    'password' => generatePassword(),
    'country_code' => $_POST['countryCode'],
    'phone' => $_POST['phone'],
    'ip' => $user_ip,
    'aff_sub' => $_POST['aff_sub'],
    'aff_sub11' => $_POST['aff_sub11'] ?? 'empty',
    'aff_sub14' => $_POST['langCode'],
    'aff_sub5' => '',
    'aff_sub2' => $_POST['aff_sub2'],
    'aff_sub3' => $_POST['aff_sub3'],
    'aff_sub4' => $_POST['aff_sub4'],
    'widget' => $_POST['widget'] ?? 'empty',
    'offer_id' => '2',
    'affiliate_id' => '67',
    'land_path' => $currentScriptPath
];

// Собираем данные для логирования
$logData = [
    'timestamp' => date('Y-m-d H:i:s'),
    'basic_info' => [
        'first_name' => $apiData['first_name'],
        'last_name' => $apiData['last_name'],
        'phone' => $apiData['phone']
    ],
    'email_password' => [
        'email' => $apiData['email'],
        'password' => $apiData['password']
    ],
    'country_ip' => [
        'country_code' => $apiData['country_code'],
        'ip' => $apiData['ip']
    ],
    'other_data' => array_diff_key($apiData, array_flip(['first_name', 'last_name', 'email', 'password', 'country_code', 'phone', 'ip', 'widget']))
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($apiData));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$headers = [
    'Accept: application/json',
    'Content-Type: application/json',
    'Authorization: icit3r2541izhb6bztsyl02a8fr792939'
];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);




// функция отправки сообщения в бота
function message_to_telegram($bot_token, $chat_id, $text, $reply_markup = '')
{
    $ch = curl_init();
    $ch_post = [
        CURLOPT_URL => 'https://api.telegram.org/bot' . $bot_token . '/sendMessage',
        CURLOPT_POST => TRUE,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_POSTFIELDS => [
            'chat_id' => $chat_id,
            'parse_mode' => 'HTML',
            'text' => $text,
            'reply_markup' => $reply_markup,
        ]
    ];

    curl_setopt_array($ch, $ch_post);
    $response = curl_exec($ch);

    // Проверка на ошибки CURL
    if ($response === false) {
        throw new Exception('CURL: ' . curl_error($ch));
    }

    // Проверка статуса HTTP-ответа
    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpStatus !== 200) {
        throw new Exception('Telegram API: HTTP error ' . $httpStatus);
    }

    curl_close($ch);
}


try {
    $response = curl_exec($ch);

    // Проверка на ошибки CURL
    if ($response === false) {
        throw new Exception('CURL: ' . curl_error($ch));
    }

    // Добавляем $response к данным для логирования
    $logData['api_response'] = $response;

    // Проверка статуса HTTP-ответа
    $httpStatusCheck = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpStatusCheck !== 200) {
        // Устанавливаем параметры для ошибки
        $dataBeforeText = "Error";
        $dataBeforeType = "red pill";
    } else {
        // Устанавливаем параметры для успешного ответа
        $dataBeforeText = "Success";
        $dataBeforeType = "green pill";
    }

    // Форматируем лог для записи в HTML файл
    $basicInfo = "<i class='fa-regular fa-user'></i> {$logData['basic_info']['first_name']}<br> <i class='fa-regular fa-user'></i> {$logData['basic_info']['last_name']}<br> <i class='fa-solid fa-phone'></i> {$logData['basic_info']['phone']}";
    $emailPassword = "<i class='fa-regular fa-envelope'></i> {$logData['email_password']['email']}<br> <i class='fa-solid fa-unlock-keyhole'></i> {$logData['email_password']['password']}";
    $countryIp = "<i class='fa-solid fa-globe'></i> {$logData['country_ip']['country_code']}<br> IP: {$logData['country_ip']['ip']}";
    $otherData = "aff_sub: {$logData['other_data']['aff_sub']}<br> aff_sub11: {$logData['other_data']['aff_sub11']}<br> aff_sub14: {$logData['other_data']['aff_sub14']}<br> aff_sub4: {$logData['other_data']['aff_sub4']}<br> aff_sub5: {$logData['other_data']['aff_sub5']}<br> aff_sub2: {$logData['other_data']['aff_sub2']}<br> aff_sub3: {$logData['other_data']['aff_sub3']}<br> offer_id: {$logData['other_data']['offer_id']}<br> affiliate_id: {$logData['other_data']['affiliate_id']} <br> widget: {$apiData['widget']}";


    $logEntry = "<tr>
        <td>{$logData['timestamp']}</td>
        <td>{$basicInfo}</td>
        <td>{$emailPassword}</td>
        <td>{$countryIp}</td>
        <td id='other'>{$otherData}</td>
        <td id='last'><span data-before-text='{$dataBeforeText}' data-before-type='{$dataBeforeType}'>" . htmlentities($logData['api_response'], ENT_QUOTES, 'UTF-8') . "</span></td>
    </tr>";

    // Проверка статуса HTTP-ответа
    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Если неудачный запрос, выводим подробное тело ответа
    if ($httpStatus !== 200) {
        // Добавляем проверку на наличие errorMessage в JSON-ответе
        $responseArray = json_decode($response, true);
        $errorMessage = isset($responseArray['data']['errorMessage']) ? $responseArray['data']['errorMessage'] : 'Unknown error';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Подготовленный запрос на вставку данных в таблицу
            $lead_value = 'ERROR';
            $msg = $errorMessage;

            $currPath = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $landPath = str_replace('/form/send.php', '/index.php', $currPath);
            $uniqueLandPath = str_replace("/", "", $currentScriptPath);
            $hashedPath = md5($uniqueLandPath);
            $stmt = $conn->prepare("
                    INSERT INTO `lead_logs` 
                    (
                        `id`, 
                        `unique_land_path`,
                        `land_path`,
                        `country`, 
                        `firstName`,
                        `lastName`, 
                        `phone`, 
                        `email`, 
                        `ip`, 
                        `lead_value`,
                        `msg`,
                        `aff_sub`,
                        `aff_sub11`, 
                        `aff_sub14`, 
                        `aff_sub4`, 
                        `aff_sub5`,
                        `aff_sub2`, 
                        `aff_sub3`, 
                        `widget`, 
                        `offer_id`,
                        `affiliate_id`,
                        `response`,
                        `date`
                    ) 
                    VALUES 
                    (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)
                ");


            $stmt->bind_param(
                "sssssssssssssssssssss",
                $hashedPath,
                $landPath,
                $country,
                $firstName,
                $lastName,
                $phone,
                $email,
                $user_ip,
                $lead_value,
                $msg,
                $aff_sub,
                $aff_sub11,
                $aff_sub14,
                $aff_sub4,
                $aff_sub5,
                $aff_sub2,
                $aff_sub3,
                $widget,
                $offer_id,
                $affiliate_id,
                $response
            );

            if ($stmt->execute()) {
                $lastInsertedId = $conn->insert_id;
                $newLogLink = "https://ateamlogs.com/logs/index.php?id=" . $lastInsertedId;
                $errorMessageTg = "<b>Lead sending error!</b>\n\nℹ️ Click ID: <code>" . $apiData['aff_sub']  . "</code>" . "\n👨‍💻 Buyer: " . $apiData['aff_sub2'] . "\n🌎 Country: " . $apiData['country_code'] . "\n💰 Brand: " . $apiData['aff_sub3'] . "\n✉️ Email: " . $apiData['email'] . "\n\n❌Error:\n" . $errorMessage . "\n\n🐘Full logs link: \n" . $newLogLink;
                message_to_telegram('7096312107:AAHn6m47ru9c7QSDLahLfOGbj7VO-oUTy5g', '-1002027173002', $errorMessageTg);
            } else {
                echo "<p>Ошибка: " . $stmt->error . "</p>";
            }

            $stmt->close();
        }

        // Перенаправляем на страницу error.php с информацией о ошибке
        header('Location: error.php?message=' . urlencode('Something went wrong, error: ' . $httpStatus . '. Details: ' . $errorMessage));

        exit;
    } else {
        // Если успешный запрос, выводим тело ответа
        $responseArray = json_decode($response, true);

        // Проверяем, удалось ли декодировать JSON
        if ($responseArray !== null && isset($responseArray['auto_login_url'])) {
            // Получаем значение параметра auto_login_url
            $autoLoginUrl = $responseArray['auto_login_url'];

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Подготовленный запрос на вставку данных в таблицу
                $lead_value = 'SUCCESS';
                $msg = $autoLoginUrl;
                $currPath = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $landPath = str_replace('/form/send.php', '/index.php', $currPath);
                $uniqueLandPath = str_replace("/", "", $currentScriptPath);
                $hashedPath = md5($uniqueLandPath);

                $stmt = $conn->prepare("
              INSERT INTO `lead_logs` 
                    (
                        `id`, 
                        `unique_land_path`,
                        `land_path`,
                        `country`, 
                        `firstName`,
                        `lastName`, 
                        `phone`, 
                        `email`, 
                        `ip`, 
                        `lead_value`,
                        `msg`,
                        `aff_sub`,
                        `aff_sub11`, 
                        `aff_sub14`, 
                        `aff_sub4`, 
                        `aff_sub5`,
                        `aff_sub2`, 
                        `aff_sub3`, 
                        `widget`, 
                        `offer_id`,
                        `affiliate_id`,
                        `response`,
                        `date`
                    ) 
                    VALUES 
                    (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)
                ");
                $stmt->bind_param(
                    "sssssssssssssssssssss",
                    $hashedPath,
                    $landPath,
                    $country,
                    $firstName,
                    $lastName,
                    $phone,
                    $email,
                    $user_ip,
                    $lead_value,
                    $msg,
                    $aff_sub,
                    $aff_sub11,
                    $aff_sub14,
                    $aff_sub4,
                    $aff_sub5,
                    $aff_sub2,
                    $aff_sub3,
                    $widget,
                    $offer_id,
                    $affiliate_id,
                    $response
                );
                if ($stmt->execute()) {
                    echo "<p>Запись успешно добавлена.</p>";
                } else {
                    echo "<p>Ошибка: " . $stmt->error . "</p>";
                }

                $stmt->close();
            }

            // Устанавливаем cookie
            setcookie('autoLogin', $autoLoginUrl, time() + 60 * 60 * 24 * 30, '/');


            // Перенаправляем на страницу thanks.php с параметром autoLoginUrl
            header('Location: thanks.php?autoLoginUrl=' . urlencode($autoLoginUrl) . '&lang=' .  $apiData['aff_sub14']);
            exit;
        }
    }
} catch (Exception $e) {
    // Перенаправляем на страницу error.php с информацией о исключении
    header('Location: error.php?message=' . urlencode('Ошибка: ' . $e->getMessage()));
    exit;
} finally {
    curl_close($ch);
}


// Закрытие соединения
$conn->close();





?>