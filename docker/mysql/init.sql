-- 初始化資料庫
CREATE DATABASE IF NOT EXISTS bonus_shoes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE bonus_shoes;

-- 建立鞋子資料表
CREATE TABLE IF NOT EXISTS `shoes_show_inf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `images` varchar(255) DEFAULT NULL,
  `eng_name` varchar(255) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `hope_price` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `action` enum('新增','更新','刪除') DEFAULT '新增',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_code` (`code`),
  KEY `idx_action` (`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 插入測試資料
INSERT INTO `shoes_show_inf` (`eng_name`, `code`, `hope_price`, `price`, `point`, `size`, `action`) VALUES
('Nike Air Max 90', 'NAM90-001', 3500.00, 2800.00, 280, '25-28', '新增'),
('Adidas Ultraboost', 'AUB-002', 5200.00, 4500.00, 450, '24-29', '更新'),
('New Balance 574', 'NB574-003', 2800.00, 2200.00, 220, '25-27', '新增'),
('Puma RS-X', 'PRX-004', 3200.00, 2600.00, 260, '26-30', '刪除'),
('Asics Gel-Kayano', 'AGK-005', 4500.00, 3800.00, 380, '25-29', '更新');
