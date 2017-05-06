SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `snake_role`;
CREATE TABLE `snake_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `rolename` varchar(155) NOT NULL COMMENT '角色名称',
  `rule` varchar(255) DEFAULT '' COMMENT '权限节点数据',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

insert into `snake_role`(`id`,`rolename`,`rule`) values('1','超级管理员','1,2,3,4,5,6,7,8,9,10,17,27,28,11,12,13,14,15,16,29,18,19,30,38,22,23,34,20,21,24,25,26,31,37,32,33,35,36,39,40');
insert into `snake_role`(`id`,`rolename`,`rule`) values('2','系统维护员','15,16,29,18,19,30,20,21,32,33,35,36');
insert into `snake_role`(`id`,`rolename`,`rule`) values('3','财务专员','22,23,34');
