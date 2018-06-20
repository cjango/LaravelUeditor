<?php

return [
    'core'   => [
        'route' => [
            'middleware' => ['web'],
        ],
    ],

    'upload' => [
        'imageActionName'         => 'uploadImage',
        'imageFieldName'          => 'upfile',
        'imageMaxSize'            => 2048000,
        'imageAllowFiles'         => ['.png', '.jpg', '.jpeg', '.gif', '.bmp'],
        'imageCompressEnable'     => true,
        'imageCompressBorder'     => 1600,
        'imageInsertAlign'        => 'none',
        'imageUrlPrefix'          => '',
        'imagePathFormat'         => '/uploads/images/{yyyy}-{mm}/{dd}/{hash}',
        /* {filename} 会替换成原文件名,配置这项需要注意中文乱码问题 */
        /* {rand:6} 会替换成随机数,后面的数字是随机数的位数 */
        /* {time} 会替换成时间戳 */
        /* {yyyy} 会替换成四位年份 */
        /* {yy} 会替换成两位年份 */
        /* {mm} 会替换成两位月份 */
        /* {dd} 会替换成两位日期 */
        /* {hh} 会替换成两位小时 */
        /* {ii} 会替换成两位分钟 */
        /* {ss} 会替换成两位秒 */
        /* 非法字符 \ : * ? ' < > | */

        /* 涂鸦图片上传配置项 */
        'scrawlActionName'        => 'uploadScrawl',
        'scrawlFieldName'         => 'upfile',
        'scrawlPathFormat'        => '/uploads/images/{yyyy}/{mm}/{dd}/{hash}',
        'scrawlMaxSize'           => 2048000,
        'scrawlUrlPrefix'         => '',
        'scrawlInsertAlign'       => 'none',

        /* 截图工具上传 */
        'snapscreenActionName'    => 'uploadImage',
        'snapscreenPathFormat'    => '/uploads/images/{yyyy}/{mm}/{dd}/{hash}',
        'snapscreenUrlPrefix'     => '',
        'snapscreenInsertAlign'   => 'none',

        /* 抓取远程图片配置 */
        'catcherActionName'       => 'catchImage',
        'catcherLocalDomain'      => [],
        'catcherFieldName'        => 'source',
        'catcherPathFormat'       => '/uploads/images/{yyyy}/{mm}/{dd}/{hash}',
        'catcherUrlPrefix'        => '',
        'catcherMaxSize'          => 2048000,
        'catcherAllowFiles'       => ['.png', '.jpg', '.jpeg', '.gif', '.bmp'],

        /* 上传视频配置 */
        'videoActionName'         => 'uploadVideo',
        'videoFieldName'          => 'upfile',
        'videoPathFormat'         => '/uploads/videos/{yyyy}/{mm}/{dd}/{hash}',
        'videoUrlPrefix'          => '',
        'videoMaxSize'            => 102400000,
        'videoAllowFiles'         => [
            '.flv', '.swf', '.mkv', '.avi', '.rm', '.rmvb', '.mpeg', '.mpg',
            '.ogg', '.ogv', '.mov', '.wmv', '.mp4', '.webm', '.mp3', '.wav', '.mid',
        ],

        /* 上传文件配置 */
        'fileActionName'          => 'uploadFile',
        'fileFieldName'           => 'upfile',
        'filePathFormat'          => '/uploads/files/{yyyy}/{mm}/{dd}/{hash}',
        'fileUrlPrefix'           => '',
        'fileMaxSize'             => 51200000,
        'fileAllowFiles'          => [
            '.png', '.jpg', '.jpeg', '.gif', '.bmp',
            '.flv', '.swf', '.mkv', '.avi', '.rm', '.rmvb', '.mpeg', '.mpg',
            '.ogg', '.ogv', '.mov', '.wmv', '.mp4', '.webm', '.mp3', '.wav', '.mid',
            '.rar', '.zip', '.tar', '.gz', '.7z', '.bz2', '.cab', '.iso',
            '.doc', '.docx', '.xls', '.xlsx', '.ppt', '.pptx', '.pdf', '.txt', '.md', '.xml',
        ],

        /* 列出指定目录下的图片 */
        'imageManagerActionName'  => 'listImage',
        'imageManagerListPath'    => '/uploads/images/',
        'imageManagerListSize'    => 20,
        'imageManagerUrlPrefix'   => '',
        'imageManagerInsertAlign' => 'none',
        'imageManagerAllowFiles'  => ['.png', '.jpg', '.jpeg', '.gif', '.bmp'],

        /* 列出指定目录下的文件 */
        'fileManagerActionName'   => 'listFile',
        'fileManagerListPath'     => '/uploads/files/',
        'fileManagerUrlPrefix'    => '',
        'fileManagerListSize'     => 20,
        'fileManagerAllowFiles'   => [
            '.png', '.jpg', '.jpeg', '.gif', '.bmp',
            '.flv', '.swf', '.mkv', '.avi', '.rm', '.rmvb', '.mpeg', '.mpg',
            '.ogg', '.ogv', '.mov', '.wmv', '.mp4', '.webm', '.mp3', '.wav', '.mid',
            '.rar', '.zip', '.tar', '.gz', '.7z', '.bz2', '.cab', '.iso',
            '.doc', '.docx', '.xls', '.xlsx', '.ppt', '.pptx', '.pdf', '.txt', '.md', '.xml',
        ],
    ],
];
