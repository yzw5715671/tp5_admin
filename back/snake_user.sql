SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `snake_user`;
CREATE TABLE `snake_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '用户名',
  `password` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '密码',
  `loginnum` int(11) DEFAULT '0' COMMENT '登陆次数',
  `last_login_ip` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '最后登录IP',
  `last_login_time` int(11) DEFAULT '0' COMMENT '最后登录时间',
  `real_name` varchar(255) COLLATE utf8_bin DEFAULT '' COMMENT '真实姓名',
  `status` int(1) DEFAULT '0' COMMENT '状态',
  `typeid` int(11) DEFAULT '1' COMMENT '用户角色id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

insert into `snake_user`(`id`,`username`,`password`,`loginnum`,`last_login_ip`,`last_login_time`,`real_name`,`status`,`typeid`) values('1','admin','d4a936d3c1f8a3407e7bcaa15c51f839','57','127.0.0.1','1494052546','admin','1','1');
insert into `snake_user`(`id`,`username`,`password`,`loginnum`,`last_login_ip`,`last_login_time`,`real_name`,`status`,`typeid`) values('2','xiaobai','d4a936d3c1f8a3407e7bcaa15c51f839','8','123.125.226.190','1493988387','小白','1','2');
