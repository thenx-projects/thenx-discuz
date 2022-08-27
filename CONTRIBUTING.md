### 构建说明
基于腾讯官方 Discuz 及官方代码仓库 [Discuz X](https://gitee.com/ComsenzDiscuz/DiscuzX) 中的最新分支  [Discuz X3.5](https://gitee.com/ComsenzDiscuz/DiscuzX/tree/v3.5/) 来构建 Docker镜像。
可通过如下指令在终端中执行即可下载镜像

```
$ docker pull tencentci/discuz
```

### 附：如果你想基于当前这个Dockerfile构建一个属于自己的镜像，我们推荐中国大陆用户在Dockerfile同目录下创建一个sources.list（即Debian的包管理源地址），并追加如下源：
```
deb http://mirrors.163.com/debian/ stretch main non-free contrib
deb http://mirrors.163.com/debian/ stretch-updates main non-free contrib
deb http://mirrors.163.com/debian/ stretch-backports main non-free contrib
deb-src http://mirrors.163.com/debian/ stretch main non-free contrib
deb-src http://mirrors.163.com/debian/ stretch-updates main non-free contrib
deb-src http://mirrors.163.com/debian/ stretch-backports main non-free contrib
deb http://mirrors.163.com/debian-security/ stretch/updates main non-free contrib
deb-src http://mirrors.163.com/debian-security/ stretch/updates main non-free contrib
```
保存后我们可以在Dockerfile中添加如下指令：
```
ADD sources.list /etc/apt/
```
