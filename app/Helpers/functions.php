<?php

function uploadfile($file, $directory) {
    $path = 'uploads/' . $directory;
    if (!file_exists($path)) {
        mkdir($path, 0775);
    }
    $datepath = date('m-Y', strtotime(\Carbon\Carbon::now()));
    if (!file_exists($path . '/' . $datepath)) {
        mkdir($path . '/' . $datepath, 0775);
    }
    $newdir = $path . '/' . $datepath;
    $exten = $file->getClientOriginalExtension();
    $filename = generateRandom($length = 15);
    $filename = $filename . '.' . $exten;
    $file->move($newdir, $filename);
    return $newdir . '/' . $filename;
}

function generateRandom($length = 11) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = time();
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}