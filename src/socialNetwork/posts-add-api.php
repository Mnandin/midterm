<?php
    require __DIR__ . '/parts/db_connect.php';
    $output = [
        "success" => false,
        "error" => "",
        "code" => 0,
        "postData" => $_POST,
        "errors" => [],
    ];
    // TODO: 資料輸入之前, 要做檢查
    # filter_var('bob@example.com', FILTER_VALIDATE_EMAIL);

    // $birthday = empty($_POST['birthday']) ? null : $_POST['birthday'];
    // $birthday = strtotime($birthday); #轉換為timestamp
    // if($birthday===false) {
    //     $birthday = null;
    // }else {
    //     $birthday = date('Y-m-d', $birthday);
    // }

    $sql = "INSERT INTO `sn_posts` SET 
    `user_id`=?,
    `content`=?,
    `image_url`=?,
    `video_url`=?,
    `location`=?,
    `tagged_users`=?,
    `posts_timestamp`=?";

    $stmt = $pdo->prepare($sql);
    try{
        $stmt->execute([
        $_POST['user_id'],
        $_POST['content'],
        $_POST['image_url'],
        $_POST['video_url'],
        $_POST['location'],
        $_POST['tagged_users'],
        $_POST['posts_timestamp'],
        ]);
    }catch(PDOException $e) {
        $output['error'] = 'SQL failed : ' . $e->getMessage();
    }


    $stmt->rowCount(); # 新增幾筆
    $output['success'] = boolval($stmt->rowCount());
    $output['lastInsertId'] = $pdo-> lastInsertId();  // 取得最新建立資料的 PK

    header('Content-Type: application/json');
    echo json_encode($output);
    // if(!empty($_POST)) {
    //     echo json_encode($_POST, JSON_UNESCAPED_UNICODE);
    // }else {
    //     echo json_encode([]);
    // }