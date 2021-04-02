<?php


namespace App\Functions;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImagesFunctions
{

    public function checkImage($req_image){





        $imgtypeid = exif_imagetype($req_image);
//	1 IMAGETYPE_GIF
//	2 IMAGETYPE_JPEG
//	3 IMAGETYPE_PNG
//	4 IMAGETYPE_SWF
//	5 IMAGETYPE_PSD
//	6 IMAGETYPE_BMP
//	7 IMAGETYPE_TIFF_II (intel byte order)
//	8 IMAGETYPE_TIFF_MM (motorola byte order)
//	9 IMAGETYPE_JPC
//	10 IMAGETYPE_JP2
//	11 IMAGETYPE_JPX
//	12 IMAGETYPE_JB2
//	13 IMAGETYPE_SWC
//	14 IMAGETYPE_IFF
//	15 IMAGETYPE_WBMP
//	16 IMAGETYPE_XBM


        if (($imgtypeid == 1) || ($imgtypeid == 2) || ($imgtypeid == 3)) {
            //1 GIF
            //2 JPEG
            //3 PNG

            $file_original_name = $req_image->getClientOriginalName();
            //$file_name = pathinfo($file_original_name, PATHINFO_FILENAME);
            $file_extension = strtolower(pathinfo($file_original_name, PATHINFO_EXTENSION));
            $file_size = $req_image->getSize();

            $allow_extensions = true;
            //$valid_exts = array('jpeg', 'jpg', 'png', 'gif', 'bmp');

            if(!in_array($file_extension, $allow_extensions)){
                return 2;//نوع الصورة ليس من الانواع المحددة
            }

            $max_size = 3000;
            if($max_size==''){$max_size=0;}
            if($max_size <1){
                $max_size = 30000 * 1024; // max file size in bytes
            }
            if($file_size > $max_size){
                return 3;//خطأ حجم الصور اكبر من الحجم المحدد
            }
        } else {
            return 1; //خطأ نوع الصورة غير مناسب
        }
        return 0; //لا يوجد اي اخطاء
    }


    public function UploadImage($req_image, $folder, $addDataTimeFolder = true, $returnFullPath = false, $resize_width_value = 0){



        $chk = $this->checkImage($req_image);
        if($chk>0){
            //اذا وجد اخطاء عند فحص الصورة فانه يلغي
            return $chk;
        }

        $file_original_name = $req_image->getClientOriginalName();
        $file_name_only = pathinfo($file_original_name, PATHINFO_FILENAME);
        $file_extension = strtolower(pathinfo($file_original_name, PATHINFO_EXTENSION));


        //$sub_folder = date('Y/m');
        $main_path = 'public/uploads/';
        //$image_path = config('my_website.images_path').'/'.$folder.'/';
        if(!file_exists($main_path.'/'.$folder)){
            try{
                mkdir($main_path.'/'.$folder);
            }catch (\Exception $exception) {
                Storage::disk('public_uploads')->makeDirectory($folder);
            }
        }

        if($addDataTimeFolder==true){
            $sub_folder = date('Y/m');
            if(!file_exists($main_path.'/'.$folder.'/'.$sub_folder)) {
                $sub_folder = date('Y');
                if(!file_exists($main_path.'/'.$folder.'/'.$sub_folder)){
                    try{
                        mkdir($main_path.'/'.$folder.'/'.$sub_folder);
                    }catch (\Exception $exception){
                        Storage::disk('public_uploads')->makeDirectory($folder.'/'.$sub_folder);
                    }
                }

                $sub_folder .= '/'.date('m');
                if(!file_exists($main_path.'/'.$folder.'/'.$sub_folder)){
                    try{
                        mkdir($main_path.'/'.$folder.'/'.$sub_folder);
                    }catch (\Exception $exception){
                        Storage::disk('public_uploads')->makeDirectory($folder.'/'.$sub_folder);
                    }
                }
            }
        }

        $new_name = time().$file_name_only.time();
        $new_name = md5($new_name);
        if(strlen($new_name)>50){
            $new_name = substr($new_name, 0,50);
        }
        $new_name .='.'.$file_extension;
        if($addDataTimeFolder==true) {
            $new_name = date('Y/m/') . $new_name;
        }
        try{
            if($resize_width_value>0){
                //اذا كان طلب اعادة تحجيم للصورة
                Image::make($req_image)
                    ->resize($resize_width_value, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save( $main_path.'/'.$folder.'/'.$new_name);
            } else {
                Image::make($req_image)
                    ->save( $main_path.'/'.$folder.'/'.$new_name);
            }

            if($returnFullPath==true){
                return '/'.$main_path.'/'.$folder.'/'.$new_name;
            } else {
                return $new_name;
            }
        } catch (\Exception $ex){
            return '';
        }
    }


    public function getNewSizeFromImage($folder, $image, $size_width, $size_height){
        //جلب الصور في مقاس معين
        $main_path = 'public/uploads/';
        if(!file_exists($main_path.'/'.$folder.'/'.$image)){
            return '';
        }

        if(($size_width<1) && ($size_height<1)){
            //اذا لم يكن هناك عرض او ارتفاع فانه يرجع الصورة نفسها
            return $image;
        }

        $file_name_only = pathinfo($image, PATHINFO_FILENAME);
        $file_extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));


        $thumb_folder = $image;
        $thumb_folder = str_replace($file_name_only.'.'.$file_extension, '', $thumb_folder);
        $thumb_folder .= 'thumbs';
        if(!file_exists($main_path.'/'.$folder.'/'.$thumb_folder)){
            try{
                mkdir($main_path.'/'.$folder.'/'.$thumb_folder);
            }catch (\Exception $exception){
                Storage::disk('public_uploads')->makeDirectory($folder.'/'.$thumb_folder);
            }
        }


        $new_file = str_replace($file_name_only.'.'.$file_extension, $file_name_only.'_'.$size_width.'_'.$size_height.'.'.$file_extension,$image);

        $new_file = $thumb_folder.'/'.$file_name_only.'_'.$size_width.'_'.$size_height.'.'.$file_extension;
        if(file_exists($main_path.'/'.$folder.'/'.$new_file)){
            //اذا كان الملف الذي بالمقاس الجديد موجود من قبل فانه يسترجعه فقط
            return $new_file;
        }

        //اذا لم يكن موجود فانه يقوم بإنشائه
        if(($size_width>0) && ($size_height>0)){
            Image::make($main_path.'/'.$folder.'/'.$image)
                ->resize($size_width, $size_height)
                ->save( $main_path.'/'.$folder.'/'.$new_file);
        } else if ($size_width>0){
            Image::make($main_path.'/'.$folder.'/'.$image)
                ->resize($size_width, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save( $main_path.'/'.$folder.'/'.$new_file);
        } else if ($size_height>0){
            Image::make($main_path.'/'.$folder.'/'.$image)
                ->resize(null, $size_height, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save( $main_path.'/'.$folder.'/'.$new_file);
        }

        return $new_file;

    }

    public function getImageFromContent($folder, $content)
    {
        $image = '';
        $content = stripslashes($content);
        if (preg_match('/<img[^>]+src=["\']([^=]*)["\'][^>]*>/i', $content, $ret)) {
            $p = strpos($ret[1],'"');
            if($p === false){
                $image = $ret[1];
            }else{
                $image = substr($ret[1],0,$p);
            }
            if($image !=''){
                $main_path = '/public/uploads/'.$folder.'/';
                if(Str::contains($image, $main_path)){
                    //if(Str::startsWith($image,$main_path)){
                    $image = str_replace($main_path, '', $image);
                }
                //dd($image);
            }
        }
        return $image;
    }
}
