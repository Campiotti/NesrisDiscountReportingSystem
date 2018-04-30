<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 21.12.2017
 * Time: 09:36
 */

namespace helper;


class fileUploader
{
    /**
     * This FileUploader allows the uploading of images and videos with sufficient checks to
     * validate the upload's success if the file given is indeed valid.
     * @author Campiotti (in collaboration with W3Schools)
     * @param $file string file to upload
     * @param int $type int type of file (0=video , 1=image)
     * @return string new name of file if renamed, if not then just name of file.
     */
    public function upload($file, int $type)
    {
        //type 0 == image , type 1 == video
        if($type==0)
        $target_dir = __DIR__."/../assets/images/products/";
        elseif($type==1)
            $target_dir = __DIR__."/../assets/movies/";
        else
            $target_dir = __DIR__."/../assets/audio/";
        $target_file = $target_dir . basename($file["name"]);
        $extension= substr($file['name'], strripos($file['name'],'.'));
        $uploadOk = 1;
        $pictureExtensions= ['jpg','png','jpeg','gif'];
        $videoExtensions=['mp4','ogg','webm'];
        $audioExtensions=['mp3'];
        $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($file["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
// Check if file already exists
        if (file_exists($target_file)) {
            $file["name"]=uniqid().$extension;
            $target_file = $target_dir .  basename($file["name"]);
            //$uploadOk = 1;
        }
// Check file size
        //Images can be 6bit deep 1920x1080 images max.
        if ($file["size"] > 1920*1080*6 && $type==0) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
// Allow certain file formats
        if(($type==0 && array_search(strtolower($fileType),$pictureExtensions)<0) ||
            ($type==1 && !array_search(strtolower($fileType),$videoExtensions)<0) ||
            ($type==2 && !array_search(strtolower($fileType),$audioExtensions)<0)) {
            if($type==0)
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            elseif($type==1)
                echo "Sorry, only MP4, OGG & WEBM files are allowed.";
            else
                echo"Sorry, only MP3 files are allowed.";
            $uploadOk = 0;
        }
// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file '".$file["name"]."'was not uploaded. Type:";
// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                echo "The file ". basename( $file["name"]). " has been uploaded.";
                return$file["name"];
            } else {
                echo "Sorry, there was an error uploading your file.";
                return"";
            }
        }

    }
}