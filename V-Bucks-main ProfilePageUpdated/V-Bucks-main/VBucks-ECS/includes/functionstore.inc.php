<?php
    function emptyInputSignup($name, $regnum, $pwd){
        $result = true;
        if(empty($name) || empty($regnum) || empty($pwd)){
            $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}
function uidExists($conn ,$regnum){
    $sql = "SELECT * FROM stores WHERE storesId = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../RegisterStore.html?error=stmtfail");
        exit();
    }
    mysqli_stmt_bind_param($stmt, 's', $regnum);
    mysqli_stmt_execute($stmt);

    $resultdata = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($resultdata)){
        return $row;
    } else{
        $result = false;
        return $result;
    }
}
function createUser($conn, $name, $regnum, $pwd){
    $sql = "INSERT INTO stores (storesName, storesId, storesPwd) VALUES (?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../RegisterStore.html?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sss", $name, $regnum, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../RegisterStore.html?error=none");
    exit();
}