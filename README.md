# thenx discuz
## 使用
镜像拉取：`$ docker pull tencentci/discuz`

镜像运行：项目代码位于容器中 /var/www/html ，可将此目录中的代码 Copy 到宿主机后再映射至容器中完成容器的持久化挂载，如下代码所示：

**1. 首先运行一个临时容器，待 copy 代码出来后只需要执行 docker stop discuz/[容器ID] 即可销毁**

`$ docker run --rm --name discuz -it -p 80:80 -d tencentci/discuz`


**2. copy 容器中的 discuz 代码到宿主机，其中 $PWD 表示当前目录。随后可根据上述步骤销毁临时容器**

`$ docker cp discuz:/var/www/html/ $PWD/`

**3. 运行并使用容器**

`$ docker run -it --name discuz -p 80:80 -p 443:443 -v /var/www/html/:$PWD/html/ -d tencentci/discuz`

## 环境要求

我们强烈建议您使用仍在开发团队支持期内的操作系统、Web服务器、PHP、数据库、内存缓存等软件，超出支持期的软件可能会对您的站点带来未知的安全隐患。 性能提示：当 MySQL < 5.7 或 MariaDB < 10.2 时， InnoDB 性能下降较为严重，因此在生产系统上运行的站点应升级版本至 MySQL >= 5.7 或 MariaDB >= 10.2 以避免此问题。

- PHP	>= 5.6.0	7.3 - 8.1	依赖 XML 扩展、 JSON 扩展、 GD 扩展 >= 1.0 ，PHP 8.0 - 8.1 为测试性支持

- MySQL	>= 5.5.3	5.7 - 8.0	如使用 MariaDB ，推荐版本为 >= 10.2

## IP地址获取

IP地址获取，现在默认只信任REMOTE_ADDR，其它的因为太容易仿造，默认禁止。获取的方式也可以扩展，在配置文件中增加了以下配置项

```php
/**
 * IP获取扩展
 * 考虑到不同的CDN服务供应商提供的判断CDN源IP的策略不同，您可以定义自己服务供应商的IP获取扩展。
 * 为空为使用默认体系，非空情况下会自动调用source/class/ip/getter_值.php内的get方法获取IP地址。
 * 系统提供dnslist(IP反解析域名白名单)、serverlist(IP地址白名单，支持CIDR)、header扩展，具体请参考扩展文件。
 * 性能提示：自带的两款工具由于依赖RDNS、CIDR判定等操作，对系统效率有较大影响，建议大流量站点使用HTTP Server
 * 或CDN/SLB/WAF上的IP黑白名单等逻辑实现CDN IP地址白名单，随后使用header扩展指定服务商提供的IP头的方式实现。
 * 安全提示：由于UCenter、UC_Client独立性及扩展性原因，您需要单独修改相关文件的相关业务逻辑，从而实现此类功能。
 * $_config['ipgetter']下除setting外均可用作自定义IP获取模型设置选项，也欢迎大家PR自己的扩展IP获取模型。
 * 扩展IP获取模型的设置，请使用格式：
 *         $_config['ipgetter']['IP获取扩展名称']['设置项名称'] = '值';
 * 比如：
 *         $_config['ipgetter']['onlinechk']['server'] = '100.64.10.24';
 */
$_config['ipgetter']['setting'] = '';
$_config['ipgetter']['header']['header'] = 'HTTP_X_FORWARDED_FOR';
$_config['ipgetter']['iplist']['header'] = 'HTTP_X_FORWARDED_FOR';
$_config['ipgetter']['iplist']['list']['0'] = '127.0.0.1';
$_config['ipgetter']['dnslist']['header'] = 'HTTP_X_FORWARDED_FOR';
$_config['ipgetter']['dnslist']['list']['0'] = 'comsenz.com';
```

## License

Thenx Discuz is Open Source software released under the [Apache 2.0 license](https://www.apache.org/licenses/LICENSE-2.0.html).
