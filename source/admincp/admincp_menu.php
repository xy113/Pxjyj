<?php
$menus = $headers = '';
$headers .= checkmenu('settings') ? getheader('settings','settings&operation=basic') : '';
$headers .= checkmenu('member') ? getheader('member','member') : '';
$headers .= checkmenu('articles') ? getheader('articles','articles') : '';
$headers .= checkmenu('image') ? getheader('image','image') : '';
$headers .= checkmenu('inter') ? getheader('inter','leads') : '';
$headers .= checkmenu('branch') ? getheader('branch','branch') : getheader('branch','brancharticles');
$headers .= $isfounder ? getheader('template','template') : '';
$headers .= $isfounder ? getheader('tool','db') : '';
$headers .= checkmenu('other') ? getheader('other','about') : '';
$smarty->assign('headers',$headers);
$menus .= checkmenu('settings') ? getmenu('settings',array(
	checkmenu('settings_basic') ? array('menu_setting_basic','settings&operation=basic') : array(),
	checkmenu('settings_optimization') ? array('menu_setting_optimization','settings&operation=optimization') : array(),
	checkmenu('settings_attachment') ? array('menu_setting_attachment','settings&operation=attachment') : array(),
	checkmenu('settings_image') ? array('menu_setting_image','settings&operation=image') : array(),
	checkmenu('settings_register') ? array('menu_setting_register','settings&operation=register') : array(),
	checkmenu('settings_randcode') ? array('menu_setting_randcode','settings&operation=randcode') : array(),
	checkmenu('settings_contact') ? array('menu_setting_contact','settings&operation=contact') : array(),
	//checkmenu('settings') ? array('menu_nav','nav') : array(),
	checkmenu('cplog') ? array('menu_cplog','cplog') : array()
)) : '';

$menus .= checkmenu('member') ? getmenu('member',array(
	checkmenu('admingroups') ? array('menu_admingroup','admingroups') : array(),
	checkmenu('usergroups') ? array('menu_usergroup','usergroups') : array(),
	checkmenu('member_add') ? array('menu_member_addnew','member&operation=add') : array(),
	checkmenu('member') ? array('menu_member_list','member') : array()
)) : '';

$menus .= checkmenu('articles') ? getmenu('articles',array(
	checkmenu('articles_add') ? array('menu_article_addnew','articles&operation=add') : array(),
	checkmenu('articles') ? array('menu_article_list','articles') : array(),
	checkmenu('articles') ? array('menu_article_unaudit','articles&audited=0') : array(),
	checkmenu('articlecat') ? array('menu_articlecat_list','articlecat') : array(),
	$admincp['adminid']==1 ? array('menu_article_source','source&type=article') : array()
)) : '';

$menus .= checkmenu('image') ? getmenu('image',array(
	checkmenu('image_add') ? array('menu_image_addnew','image&operation=add') : array(),
	checkmenu('image') ? array('menu_image_list','image') : array(),
	checkmenu('imagecat') ? array('menu_imagecat_list','imagecat') : array(),
	$admincp['adminid']==1 ? array('menu_image_source','source&type=image') : array()
)) : '';

$menus .= checkmenu('inter') ? getmenu('inter',array(
	checkmenu('leads') ? array('menu_leads','leads') : array(),
	checkmenu('leadmails') ? array('menu_leadmails','leadmails') : array(),
	checkmenu('forum') ? array('menu_forum','forum') : array(),
	checkmenu('thread') ? array('menu_thread','thread') : array()
)) : '';

$menus .= checkmenu('branch') ? getmenu('branch',array(
	array('menu_branch','branch'),
		//checkmenu('branch_category') ? array('menu_branch_category','branch&operation=category') : array(),
		checkmenu('branch_articles') ? array('menu_branch_article','branch&operation=articles') : array(),
		checkmenu('branch_articles') ? array('menu_article_unaudit','branch&operation=articles&audited=0') : array()
)) : '';

$menus .= $isfounder ? getmenu('template',array(
	array('menu_template_edit','template'),
	array('menu_template_select','template&operation=select')
)) : '';

$menus .= $isfounder ? getmenu('tool',array(
	array('menu_db_backup','db'),
	array('menu_db_resume','db&operation=resume'),
	array('menu_db_sql','db&operation=sql'),
	array('menu_email','email')
)) : '';

$menus .= checkmenu('other') ? getmenu('other',array(
	checkmenu('about') ? array('menu_about','about') : array(),
	checkmenu('slide') ? array('menu_slide','slide') : array(),
	checkmenu('friendlink') ? array('menu_friendlink','friendlink') : array(),
	checkmenu('poll') ? array('menu_poll','poll') : array(),
	checkmenu('faq') ? array('menu_faq','faq') : array(),
	checkmenu('announce') ? array('menu_announce','announce') : array(),
	checkmenu('lifebox') ? array('menu_lifebox','lifebox') : array()
)) : '';
$smarty->assign('menus',$menus);
?>