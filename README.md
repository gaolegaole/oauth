### 微信多个域名网页授权
> 授权页面跳转网址：`http://oauth.domain/index.php?target=http://user.domain&scope=snsapi_userinfo`
* oauth.domain: 本系统的网址；
* user.domain: 需要网页授权的网址；
* scope: 默认snsapi_base,可选两个值`snsapi_base`,`snsapi_userinfo`
* 授权后会跳转到：`http://user.domain?openid=xxx`，其中openid即是用户的openid

#### 使用方法
1. 将你的appid和secret设置到index.php中相应的位置
2. 将域名解析到如`oauth.xxx.com`
3. 将微信公众平台的网页授权地址添加一项 `oauth.xxx.com`（上一步设置的域名
4. 将那个验证文件上传到`oauth.xxx.com`的根目录，验证
5. 再次解析一个域名`shop.xxx.com`
6. 在`shop.xxx.com`域名创建index.html，并设置a标签<a href="http://oauth.xxx.com/index.php?target=http://shop.xxx.com&scope=snsapi_userinfo">授权</a>
7. 用微信开发者工具访问`http://shop.xxx.com`，并点击授权，查看浏览器地址返回`http://shop.xxx.com?openid=xxx`

