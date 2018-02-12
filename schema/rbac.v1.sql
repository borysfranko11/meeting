CREATE TABLE `login_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0' COMMENT '关联用户',
  `ip` varchar(15) DEFAULT '' COMMENT '登录IP',
  `status` tinyint(2) DEFAULT '0' COMMENT '状态位: 0.未知 1.登录 2.退出',
  `login_time` datetime DEFAULT '0000-01-01 00:00:00' COMMENT '登录时间',
  `logout_time` datetime DEFAULT '0000-01-01 00:00:00' COMMENT '退出时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='登录日志';

CREATE TABLE `resources` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT '' COMMENT '资源中文名称',
  `alias` varchar(32) DEFAULT '' COMMENT '资源英文名称',
  `pid` int(11) DEFAULT '0' COMMENT '父级ID',
  `url` varchar(64) DEFAULT '' COMMENT '节点访问地址',
  `icon` varchar(64) DEFAULT '' COMMENT '',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) DEFAULT '1' COMMENT '状态: 1.正常 2.异常',
  `remark` varchar(64) DEFAULT '' COMMENT '备注',
  `created_time` datetime DEFAULT '0000-01-01 00:00:00',
  `updated_time` datetime DEFAULT '0000-01-01 00:00:00',
  PRIMARY KEY (`id`),
  KEY `node` (`url`,`name`,`sort`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='权限部分 - 资源';

CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT '' COMMENT '角色名称',
  `pid` int(10) DEFAULT '0' COMMENT '父级ID',
  `remark` varchar(255) DEFAULT '' COMMENT '备注',
  `status` tinyint(3) DEFAULT '1' COMMENT '状态: 1.正常 2.异常',
  `created_time` datetime DEFAULT '0000-01-01 00:00:00',
  `udpated_time` datetime DEFAULT '0000-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='权限部分 - 角色';

CREATE TABLE `role_resource` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT '0' COMMENT '关联角色',
  `resource_id` int(11) DEFAULT '0' COMMENT '关联资源',
  PRIMARY KEY (`id`),
  KEY `roleID` (`role_id`),
  KEY `resourceID` (`resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='权限部分 - 角色&资源';

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户编码',
  `login_name` varchar(32) DEFAULT '' COMMENT '登录名称',
  `username` varchar(32) DEFAULT '' COMMENT '姓名',  
  `password` varchar(225) DEFAULT '' COMMENT '密码',
  `status` tinyint(3) DEFAULT '1' COMMENT '状态: 1.正常 2.异常',
  `phone` varchar(20) DEFAULT '',
  `email` varchar(32) DEFAULT '' COMMENT '邮箱地址',
  `token` varchar(64) DEFAULT '' COMMENT '免登录秘钥',
  `marketorgcode` varchar(16) NOT NULL DEFAULT '' COMMENT '成本中心code',
  `marketorgdesc` varchar(64) NOT NULL DEFAULT '' COMMENT '成本中心中文描述',
  `created_time` datetime DEFAULT '0000-01-01 00:00:00',
  `updated_time` datetime DEFAULT '0000-01-01 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_name` (`login_name`),
  UNIQUE KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8mb4 COMMENT='权限部分 - 用户';

CREATE TABLE `user_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0' COMMENT '关联用户',
  `role_id` int(11) DEFAULT '0' COMMENT '关联角色',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='权限部分 - 用户&角色';


