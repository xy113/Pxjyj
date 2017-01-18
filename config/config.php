<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2011-10-18
 * $Id: config.php
 **/
$config = array();
$config['db']['dbhost']   = 'localhost';
$config['db']['dbuser']   = 'root';
$config['db']['dbpwd']    = '123123';
$config['db']['dbname']   = 'pxedu';
$config['db']['pconnect'] = 0;
$config['db']['tablepre'] = 'sdw_';
$config['db']['charset']  = 'GBK';
// COOKIE 设置
$config['cookie']['cookiepre'] 	   = 'pxedu_'; 	// COOKIE前缀
$config['cookie']['cookiedomain']  = ''; 		// COOKIE作用域
$config['cookie']['cookiepath']    = '/'; 		// COOKIE作用路径
// 后台设置
$config['admincp']['founders']	   = '1';		// 站点创始人：拥有站点管理后台的最高权限，每个站点可以设置 1名或多名创始人
												// 可以使用uid，也可以使用用户名；多个创始人之间请使用逗号“,”分开;
$config['admincp']['runquery']	   = 1;		// 是否允许后台运行 SQL 语句 1=是 0=否[安全]
$config['admincp']['edittemplate'] = 1;     // 是否允许后台编辑模板 1=是 0=否[安全]
// 页面输出设置
$config['output']['charset'] 	   = 'gbk';	// 页面字符集
$config['output']['forceheader']   = 1;		// 强制输出页面字符集，用于避免某些环境乱码
$config['output']['gzip'] 		   = 0;		// 是否采用 Gzip 压缩输出
$config['output']['tplrefresh']    = 1;		// 模板自动刷新开关 0=关闭, 1=打开
$config['output']['staticurl'] 	   = 'static/';	// 站点静态文件路径，“/”结尾
$config['output']['ajaxvalidate']  = 0;		// 是否严格验证 Ajax 页面的真实性 0=关闭，1=打开
// 站点安全设置
$config['language']  = 'zh_cn';	// 页面语言 zh_cn/zh_tw
$config['authkey']	 = '123456';	// 站点加密密钥
?>