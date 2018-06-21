<?php

namespace RuLong\Ueditor;

use Illuminate\Support\Facades\Blade;

class BladeExtends
{

    public static function ueditor()
    {
        Blade::directive('ueditor', function ($content) {
            $editor = '<script src=' . asset('/assets/ueditor/ueditor.config.js') . '></script>';
            $editor .= '<script src=' . asset('/assets/ueditor/ueditor.all.min.js') . '></script>';
            $editor .= '<script id="ueditor" name="content" type="text/plain">';
            $editor .= $content;
            $editor .= '</script>';
            $editor .= '<script type="text/javascript">';
            $editor .= 'var ue = UE.getEditor("ueditor", {autoHeightEnabled:false,initialFrameHeight:400,serverUrl:"/ueditor/server?_token=' . csrf_token() . '"});';
            $editor .= '</script>';
            return $editor;
        });
    }

    public static function umeditor()
    {
        Blade::directive('umeditor', function ($content) {
            $umid   = 'umeditor' . uniqid();
            $editor = '<link rel="stylesheet" href="' . asset('/assets/umeditor/themes/default/css/umeditor.css') . '" >';
            $editor .= '<script src=' . asset('/assets/umeditor/third-party/jquery.min.js') . '></script>';
            $editor .= '<script src=' . asset('/assets/umeditor/umeditor.config.js') . '></script>';
            $editor .= '<script src=' . asset('/assets/umeditor/umeditor.min.js') . '></script>';
            $editor .= '<script id="' . $umid . '" name="content[]" type="text/plain">';
            $editor .= $content;
            $editor .= '</script>';
            $editor .= '<script type="text/javascript">';
            $editor .= 'var um = UM.getEditor("' . $umid . '", {initialFrameHeight:300,initialFrameWidth:"100%",imageUrl:"/ueditor/server?_token=' . csrf_token() . '&action=uploadImage",imagePath:"",imageFieldName:"upfile"});';
            $editor .= '</script>';
            return $editor;
        });
    }
}
