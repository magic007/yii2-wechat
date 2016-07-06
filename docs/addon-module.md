扩展模块开发
==========
##1.增加GII支持、修改配置文件

```

$config['modules']['gii']=[

        'class' => 'yii\gii\Module',

        'allowedIPs' => ['::1','127.0.0.1'], //只允许本地访问gii

        'generators'=> [

            /*重新定义gii model & crud的生成模板*/

            'module'=> [

                'class' => 'callmez\wechat\generators\module\Generator',

                'templates'=> [

                    'backend'=>'@callmez/wechat/generators/module/default'

                ]

            ],

        ]

    ];

```



## 2.GIi 生成模块

1. 填写模板名称信息，例如叫 `abc`

2. 点击生成模板

3. 项目多出这个文件夹<code>/root/modules/wechat/modules/abc</code>



##3.安装模块

1.进入系统模板安装 ，地址：`http://www.explorer.com/wechat/module/install?id=abc`

2.选择所属类目，点击提交

3.左侧栏目里面就多出你添加的模块 地址：`http://www.explorer.com/wechat/abc/admin`

