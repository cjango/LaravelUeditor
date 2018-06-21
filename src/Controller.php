<?php

namespace RuLong\Ueditor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{

    public function server(Request $request)
    {
        $config = config('ueditor.upload');
        $action = $request->get('action');
        switch ($action) {
            case 'config':
                $result = $config;
                break;
            default:
                $result = '';
                break;
        }
        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
