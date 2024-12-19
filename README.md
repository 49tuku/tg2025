电报中文版下载|[TG中文版下载](https://www.tg398.net/)|Telegram中文版下载-Telegram中文版源码，是一款基于ThinkPHP+Bootstrap的极速后台开发框架。仅供学习参考。

## TG中文版 运行环境
* PHP5.5及以上，推荐使用PHP7.1
* nginx或其他Web Server，root目录绑定到public文件夹并设置伪静态到index.php
* MySQL或兼容MySQL的其他数据库，推荐MySQL5.7
* redis 缓存服务器
* spinx 搜索引擎(可选)

## [电报中文版下载](https://www.telegrbm.com/)|TG中文版下载|[Telegram中文版下载](https://www.telagran.top/)主要特性

* 基于`Auth`验证的权限管理系统
    * 支持无限级父子级权限继承，父级的管理员可任意增删改子级管理员及权限设置
    * 支持单管理员多角色
    * 支持管理子级数据或个人数据
* 强大的一键生成功能
    * 一键生成CRUD,包括控制器、模型、视图、JS、语言包、菜单、回收站等
    * 一键压缩打包JS和CSS文件，一键CDN静态资源部署
    * 一键生成控制器菜单和规则
    * 一键生成API接口文档
* 完善的前端功能组件开发
    * 基于`AdminLTE`二次开发
    * 基于`Bootstrap`开发，自适应手机、平板、PC
    * 基于`RequireJS`进行JS模块管理，按需加载
    * 基于`Less`进行样式开发
* 强大的插件扩展功能，在线安装卸载升级插件
* 通用的会员模块和API模块
* 共用同一账号体系的Web端会员中心权限验证和API接口会员权限验证
* 无缝整合第三方云存储(七牛云、阿里云OSS、又拍云)功能，支持云储存分片上传
* 第三方富文本编辑器支持(Summernote、Kindeditor、百度编辑器)
* 第三方登录(QQ、微信、微博)整合
* 第三方支付(微信、支付宝)无缝整合，微信支持PC端扫码支付
* 丰富的插件应用市场

## 部署方法
```
git clone https://github.com/iceyhexman/onlinetools.git
cd onlinetools
pip3 install -r requirements.txt
nohup python3 main.py &
```


## Docker 部署
```
git clone https://github.com/iceyhexman/onlinetools.git
cd onlinetools
docker build -t onlinetools .
docker run -d -p 8000:8000 onlinetools
```

浏览器打开：http : / / localhost:8000/



## 界面截图
![电报中文版下载](https://www.telegrbm.com/index_files/pc.png "电报中文版下载")

## 问题反馈

在使用中有任何问题，请使用以下联系方式联系我们

交流社区: [https://ask.fastadmin.net](https://www.telegrbm.com/)

QQ 1 群（满）、QQ 2 群（满）、QQ 3 群（满）、QQ 4 群（满）、QQ 5 群（满）、QQ 6 群（满）、[QQ 7 群]。


## 特别鸣谢

感谢以下的项目,排名不分先后

telegrbm：https://www.telegrbm.com/
telagran：https://www.telagran.top/
tuku325：https://www.tuku325.cc/

* 有什么建议或者要修改的地方请直接提issue就行 懒癌犯了好几个月了... 下一版本最主要的变化应该是插件中心吧..各位dalao欢迎提poc(`・ω・´)


## 电报中文版下载|TG中文版下载|Telegram中文版下载-版权信息

电报中文版下载遵循Apache2开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2017-2026 by telagran (https://www.telagran.top/)

All rights reserved。
