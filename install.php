<?php
$this->db->query('CREATE TABLE `' . DB_PREFIX . 'order_recurring_moip` (`invoice_id` bigint(20) NOT NULL AUTO_INCREMENT,`invoice_amount` float DEFAULT NULL,`invoice_identify` bigint(20) DEFAULT NULL,`invoice_moip_id` bigint(20) DEFAULT NULL,`payment_method` mediumtext,`next_invoice_date` varchar(10) DEFAULT \'----/--/--\',`recurring_id` int(11) NOT NULL,`customer_id` int(11) NOT NULL,PRIMARY KEY (`invoice_id`)) ENGINE=MyISAM AUTO_INCREMENT=8631464 DEFAULT CHARSET=utf8;');
$this->db->query('CREATE TABLE `' . DB_PREFIX . 'customer_moip` (`customer_moip_id` int(11) NOT NULL AUTO_INCREMENT,`customer_id` int(11) DEFAULT NULL,`register` tinyint(3) DEFAULT NULL,`credit_card` tinyint(3) DEFAULT NULL,`hash` varchar(255) DEFAULT NULL,`date_added` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',`date_modified` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\', PRIMARY KEY (`customer_moip_id`)) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;');

$this->load->model('extension/event');

$this->model_extension_event->addEvent('moip_assinatura', 'pre.admin.recurring.add', 'admin/controller/event/moip_assinatura/preAdminRecurringAdd');
$this->model_extension_event->addEvent('moip_assinatura', 'post.admin.recurring.edit', 'admin/controller/event/moip_assinatura/postAdminRecurringEdit');