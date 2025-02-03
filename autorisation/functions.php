<?php
function safe_html($data){
    return htmlspecialchars($data , ENT_QUOTES, 'UTF-8');
}

function get_projects(){
    global $conn;
    $stmt = $conn->query("SELECT * FROM projects ORDER BY id DESC");
    return $stmt->fetchAll();
}

function handle_file_upload(){
    if(isset($_FILES['photo'])){
        $allowed = ['jpg', 'jpeg', 'png', 'mp4', 'avi', 'mov'];
        $file = $_FILES['photo']['name'];
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if(in_array($ext, $allowed)){
            $new_filename = uniqid() . '.' . $ext;
            $target_path = __DIR__ . '/uploads/' . $new_filename;
            if(move_uploaded_file($_FILES['photo']['tmp_name'], $target_path)){
                return $new_filename;
            }
        }
    }
}
return null


?>