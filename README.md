# Simple-PHP-image-or-file-upload-API
使用PHP编写的图片上传API,可以通过api向服务器上传图片(或文件)

## ❓ 项目是怎么工作的
#### 本项目类似于图床的后端，可以通过API接收来自用户的请求并将请求的图片(或文件)存储在本地

## ⭐ 项目优势
#### 依托于PHP，轻量易部署，无需单独监听端口
#### 允许自定义最大文件上传大小及允许上传的文件后缀
#### 配套相关的上传脚本，方便用户上传图片(或文件)

## 🖼 演示
1.基本功能
![动画](https://user-images.githubusercontent.com/79984712/185925428-22f513af-480f-4be2-bf24-36eb60a1f9a0.gif)
2.配套上传程序
![动画1](https://user-images.githubusercontent.com/79984712/185928295-c4809953-9b14-4f38-9c6e-624e47b9ebeb.gif)
3.搭配 Typora 上传
![动画2](https://user-images.githubusercontent.com/79984712/185929851-bfad172a-c0e5-429e-8a5c-34ec5aaa9160.gif)

## 🖊 使用
#### 估计把演示的几个Gif看一下就大概知道了~
#### 贴一张 Postman 的请求图
![image](https://user-images.githubusercontent.com/79984712/185935938-b1da9112-bcde-4838-95cc-205849d29660.png)
#### curl示例
```bash
curl --location --request POST 'http://192.168.31.2/img/update.php' \
--form 'file=@"/F:/Desktop/eg.gif"' \
--form 'key="5grAtvQ0v5Ktq73TmaRM"'
```
