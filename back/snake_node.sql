SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `snake_node`;
CREATE TABLE `snake_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_name` varchar(155) NOT NULL DEFAULT '' COMMENT '节点名称',
  `module_name` varchar(155) NOT NULL DEFAULT '' COMMENT '模块名',
  `control_name` varchar(155) NOT NULL DEFAULT '' COMMENT '控制器名',
  `action_name` varchar(155) NOT NULL COMMENT '方法名',
  `is_menu` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否是菜单项 1不是 2是',
  `typeid` int(11) NOT NULL COMMENT '父级节点id',
  `level` int(11) NOT NULL DEFAULT '1' COMMENT '等级',
  `path` varchar(256) NOT NULL DEFAULT '0,',
  `style` varchar(155) NOT NULL DEFAULT '' COMMENT '菜单样式',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

insert into `snake_node`(`id`,`node_name`,`module_name`,`control_name`,`action_name`,`is_menu`,`typeid`,`level`,`path`,`style`) values('1','管理员管理','#','#','#','2','0','1','0,','fa fa-users');
insert into `snake_node`(`id`,`node_name`,`module_name`,`control_name`,`action_name`,`is_menu`,`typeid`,`level`,`path`,`style`) values('2','管理员列表','admin','admin','index','2','1','2','0,1,','');
insert into `snake_node`(`id`,`node_name`,`module_name`,`control_name`,`action_name`,`is_menu`,`typeid`,`level`,`path`,`style`) values('3','添加管理员','admin','admin','useradd','1','2','3','0,1,2,','');
insert into `snake_node`(`id`,`node_name`,`module_name`,`control_name`,`action_name`,`is_menu`,`typeid`,`level`,`path`,`style`) values('4','编辑管理员','admin','admin','useredit','1','2','3','0,1,2,','');
insert into `snake_node`(`id`,`node_name`,`module_name`,`control_name`,`action_name`,`is_menu`,`typeid`,`level`,`path`,`style`) values('5','删除管理员','admin','admin','userdel','1','2','3','0,1,2,','');
insert into `snake_node`(`id`,`node_name`,`module_name`,`control_name`,`action_name`,`is_menu`,`typeid`,`level`,`path`,`style`) values('6','角色列表','admin','role','index','2','1','2','0,1,','');
insert into `snake_node`(`id`,`node_name`,`module_name`,`control_name`,`action_name`,`is_menu`,`typeid`,`level`,`path`,`style`) values('7','添加角色','admin','role','roleadd','1','6','3','0,1,6,','');
insert into `snake_node`(`id`,`node_name`,`module_name`,`control_name`,`action_name`,`is_menu`,`typeid`,`level`,`path`,`style`) values('8','编辑角色','admin','role','roleedit','1','6','3','0,1,6,','');
insert into `snake_node`(`id`,`node_name`,`module_name`,`control_name`,`action_name`,`is_menu`,`typeid`,`level`,`path`,`style`) values('9','删除角色','admin','role','roledel','1','6','3','0,1,6,','');
insert into `snake_node`(`id`,`node_name`,`module_name`,`control_name`,`action_name`,`is_menu`,`typeid`,`level`,`path`,`style`) values('10','分配权限','admin','role','giveaccess','1','6','3','0,1,6,','');
insert into `snake_node`(`id`,`node_name`,`module_name`,`control_name`,`action_name`,`is_menu`,`typeid`,`level`,`path`,`style`) values('11','节点列表','admin','node','index','2','1','2','0,1,','');
insert into `snake_node`(`id`,`node_name`,`module_name`,`control_name`,`action_name`,`is_menu`,`typeid`,`level`,`path`,`style`) values('12','添加节点','admin','node','nodeadd','1','11','3','0,1,11,','');
insert into `snake_node`(`id`,`node_name`,`module_name`,`control_name`,`action_name`,`is_menu`,`typeid`,`level`,`path`,`style`) values('13','编辑节点','admin','node','nodeedit','1','11','3','0,1,11,','');
insert into `snake_node`(`id`,`node_name`,`module_name`,`control_name`,`action_name`,`is_menu`,`typeid`,`level`,`path`,`style`) values('14','系统管理','#','#','#','2','0','1','0,','fa fa-cog');
insert into `snake_node`(`id`,`node_name`,`module_name`,`control_name`,`action_name`,`is_menu`,`typeid`,`level`,`path`,`style`) values('15','数据备份/还原','admin','data','index','2','14','2','0,14,','');
insert into `snake_node`(`id`,`node_name`,`module_name`,`control_name`,`action_name`,`is_menu`,`typeid`,`level`,`path`,`style`) values('16','备份数据','admin','data','importdata','1','15','3','0,14,15,','');
insert into `snake_node`(`id`,`node_name`,`module_name`,`control_name`,`action_name`,`is_menu`,`typeid`,`level`,`path`,`style`) values('17','还原数据','admin','data','backdata','1','15','3','0,14,15,','');