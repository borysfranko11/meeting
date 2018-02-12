CREATE TABLE `zsh_marketorg` (
  `marketorgcode` varchar(16) NOT NULL DEFAULT '' AUTO_INCREMENT COMMENT '负责单位code',
  `marketorgdesc` varchar(32) NOT NULL DEFAULT '' COMMENT '负责单位名称',
  PRIMARY KEY (`marketorgcode`)
) ENGINE=MyISAM AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='负责单位';