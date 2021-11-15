<?php

function upload_file($target, $file, $src){
    $file_arr = explode(".", $file);
    $filename = $file_arr[0];
    $file_ext = end($file_arr);

    $dest = $target.$filename.".".$file_ext;

    // check for duplicate files
    if(file_exists($dest)){
        $count = 1;
        while(file_exists($target.$filename.$count.".".$file_ext)){
            $count++;
        }
        $dest = $target.$filename.$count.".".$file_ext;
    }

    if(move_uploaded_file($src, $dest)){
        $dest_arr = explode("/", $dest);
        return end($dest_arr);
    }

    return FALSE;
}

?>