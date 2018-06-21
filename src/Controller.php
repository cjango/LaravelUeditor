<?php

namespace RuLong\Ueditor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $config;
    protected $request;

    public function __construct(Request $request)
    {
        $this->middleware(config('ueditor.route.middleware'));
        $this->request = $request;
        $this->config  = config('ueditor.upload');
    }

    public function server(Request $request)
    {
        $action = $request->get('action');

        if (method_exists($this, $action)) {
            $result = call_user_func_array([$this, $action], []);
            return json_encode($result);
        } else {
            return '';
        }
    }

    protected function config()
    {
        return $this->config;
    }

    protected function uploadImage()
    {
        $upConfig = [
            "pathFormat" => $this->config['imagePathFormat'],
            "maxSize"    => $this->config['imageMaxSize'],
            "allowFiles" => $this->config['imageAllowFiles'],
            'fieldName'  => $this->config['imageFieldName'],
        ];
        return with(new Uploader\UploadFile($upConfig, $this->request))->upload();
    }

    protected function uploadFile()
    {
        $upConfig = [
            "pathFormat" => $this->config['filePathFormat'],
            "maxSize"    => $this->config['fileMaxSize'],
            "allowFiles" => $this->config['fileAllowFiles'],
            'fieldName'  => $this->config['fileFieldName'],
        ];
        return with(new Uploader\UploadFile($upConfig, $this->request))->upload();
    }

    protected function uploadScrawl()
    {
        $upConfig = [
            "pathFormat" => $this->config['scrawlPathFormat'],
            "maxSize"    => $this->config['scrawlMaxSize'],
            "oriName"    => "scrawl.png",
            'fieldName'  => $this->config['scrawlFieldName'],
        ];
        return with(new Uploader\UploadScrawl($upConfig, $this->request))->upload();
    }

    protected function uploadVideo()
    {
        $upConfig = [
            "pathFormat" => $this->config['videoPathFormat'],
            "maxSize"    => $this->config['videoMaxSize'],
            "allowFiles" => $this->config['videoAllowFiles'],
            'fieldName'  => $this->config['videoFieldName'],
        ];
        return with(new Uploader\UploadFile($upConfig, $this->request))->upload();
    }

    protected function catchImage()
    {
        $upConfig = [
            "pathFormat" => $this->config['catcherPathFormat'],
            "maxSize"    => $this->config['catcherMaxSize'],
            "allowFiles" => $this->config['catcherAllowFiles'],
            "oriName"    => "remote.png",
            'fieldName'  => $this->config['catcherFieldName'],
        ];
        $sources = $request->post($this->config['catcherFieldName']);

        $list = [];
        foreach ($sources as $imgUrl) {
            $upConfig['imgUrl'] = $imgUrl;
            $info               = with(new Uploader\UploadCatch($upConfig, $this->request))->upload();
            array_push($list, [
                "state"    => $info["state"],
                "url"      => $info["url"],
                "size"     => $info["size"],
                "title"    => htmlspecialchars($info["title"]),
                "original" => htmlspecialchars($info["original"]),
                "source"   => htmlspecialchars($imgUrl),
            ]);
        }
        return [
            'state' => count($list) ? 'SUCCESS' : 'ERROR',
            'list'  => $list,
        ];
    }

    protected function listImage()
    {
        return with(new Uploader\Lists(
            $this->config['imageManagerAllowFiles'],
            $this->config['imageManagerListSize'],
            $this->config['imageManagerListPath'],
            $this->request))->getList();
    }

    protected function listFile()
    {
        return with(new Uploader\Lists(
            $this->config['fileManagerAllowFiles'],
            $this->config['fileManagerListSize'],
            $this->config['fileManagerListPath'],
            $this->request))->getList();
    }
}
