
CREATE DATABASE IF NOT EXISTS `populatedeshop`;
USE `populatedeshop`;

CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `popular` tinyint NOT NULL DEFAULT '0',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `status`, `popular`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'smartphones', 'smartphones', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.', 1, 1, 'https://picsum.photos/id/46/200/300', '2023-06-19 20:58:40', '2023-06-22 18:51:03', NULL),
	(3, 'laptops', 'laptops', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.', 1, 1, 'https://picsum.photos/id/56/200/300', '2023-06-19 20:58:40', '2023-06-19 20:58:40', NULL),
	(4, 'fragrances', 'fragrances', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.', 0, 1, 'https://picsum.photos/id/45/200/300', '2023-06-19 20:58:40', '2023-06-19 20:58:40', NULL),
	(5, 'skincare', 'skincare', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.', 1, 1, 'https://picsum.photos/id/68/200/300', '2023-06-19 20:58:40', '2023-06-19 20:58:40', NULL),
	(6, 'groceries', 'groceries', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.', 1, 0, 'https://picsum.photos/id/78/200/300', '2023-06-19 20:58:40', '2023-06-19 20:58:40', NULL),
	(7, 'home-decoration', 'home_decoration', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.', 1, 1, 'https://picsum.photos/id/62/200/300', '2023-06-19 20:58:40', '2023-06-19 20:58:40', NULL);

CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `discountPercentage` decimal(15,2) DEFAULT NULL,
  `rating` decimal(15,2) DEFAULT NULL,
  `stock` int NOT NULL,
  `brand` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `products` (`id`, `title`, `slug`, `category_id`, `description`, `price`, `discountPercentage`, `rating`, `stock`, `brand`, `thumbnail`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(36, 'iPhone 9', 'iphone_9', 5, 'An apple mobile which is nothing like apple', 549.00, 12.96, 4.69, 94, 'Apple', 'https://picsum.photos/id/86/200/300', '2023-06-22 18:05:30', '2023-06-22 18:17:10', NULL),
	(37, 'iPhone X', 'iphone_x', 1, 'SIM-Free, Model A19211 6.5-inch Super Retina HD display with OLED technology A12 Bionic chip with ...', 899.00, 17.94, 4.44, 31, 'Apple', 'https://picsum.photos/id/16/200/300', '2023-06-22 18:05:32', '2023-06-22 18:05:32', NULL),
	(38, 'Samsung Universe 9', 'samsung_universe_9', 1, 'Samsung\'s new variant which goes beyond Galaxy to the Universe', 1249.00, 15.46, 4.09, 36, 'Samsung', 'https://picsum.photos/id/76/200/300', '2023-06-22 18:05:33', '2023-06-22 18:05:33', NULL),
	(39, 'OPPOF19', 'oppof19', 1, 'OPPO F19 is officially announced on April 2021.', 280.00, 17.91, 4.30, 123, 'OPPO', 'https://picsum.photos/id/66/200/300', '2023-06-22 18:05:34', '2023-06-22 18:05:34', NULL),
	(40, 'Huawei P30', 'huawei_p30', 3, 'Huawei’s re-badged P30 Pro New Edition was officially unveiled yesterday in Germany and now the device has made its way to the UK.', 499.00, 10.58, 4.09, 31, 'Huawei', 'https://picsum.photos/id/13/200/300', '2023-06-22 18:05:35', '2023-06-22 18:05:35', NULL),
	(41, 'MacBook Pro', 'macbook_pro', 1, 'MacBook Pro 2021 with mini-LED display may launch between September, November', 1749.00, 11.02, 4.57, 83, 'Apple', '1687446337.png', '2023-06-22 18:05:37', '2023-06-22 18:05:37', NULL),
	(42, 'Samsung Galaxy Book', 'samsung_galaxy_book', 1, 'Samsung Galaxy Book S (2020) Laptop With Intel Lakefield Chip, 8GB of RAM Launched', 1499.00, 4.15, 4.25, 50, 'Samsung', 'https://picsum.photos/id/44/200/300', '2023-06-22 18:05:38', '2023-06-22 18:05:38', NULL),
	(43, 'Microsoft Surface Laptop 4', 'microsoft_surface_laptop_4', 1, 'Style and speed. Stand out on HD video calls backed by Studio Mics. Capture ideas on the vibrant touchscreen.', 1499.00, 10.23, 4.43, 68, 'Microsoft Surface', 'https://picsum.photos/id/64/200/300', '2023-06-22 18:05:39', '2023-06-22 18:05:39', NULL),
	(44, 'Infinix INBOOK', 'infinix_inbook', 1, 'Infinix Inbook X1 Ci3 10th 8GB 256GB 14 Win10 Grey – 1 Year Warranty', 1099.00, 11.83, 4.54, 96, 'Infinix', 'https://picsum.photos/id/45/200/300', '2023-06-22 18:05:40', '2023-06-22 18:05:40', NULL),
	(45, 'HP Pavilion 15-DK1056WM', 'hp_pavilion_15_dk1056wm', 1, 'HP Pavilion 15-DK1056WM Gaming Laptop 10th Gen Core i5, 8GB, 256GB SSD, GTX 1650 4GB, Windows 10', 1099.00, 6.18, 4.43, 88, 'HP Pavilion', '1687446342.jpeg', '2023-06-22 18:05:42', '2023-06-22 18:05:42', NULL),
	(46, 'perfume Oil', 'perfume_oil', 1, 'Mega Discount, Impression of Acqua Di Gio by GiorgioArmani concentrated attar perfume Oil', 13.00, 8.40, 4.26, 65, 'Impression of Acqua Di Gio', 'https://picsum.photos/id/77/200/300', '2023-06-22 18:05:43', '2023-06-22 18:05:43', NULL),
	(47, 'Brown Perfume', 'brown_perfume', 1, 'Royal_Mirage Sport Brown Perfume for Men & Women - 120ml', 40.00, 15.66, 4.00, 52, 'Royal_Mirage', 'https://picsum.photos/id/48/200/300', '2023-06-22 18:05:44', '2023-06-22 18:05:44', NULL),
	(48, 'Fog Scent Xpressio Perfume', 'fog_scent_xpressio_perfume', 1, 'Product details of Best Fog Scent Xpressio Perfume 100ml For Men cool long lasting perfumes for Men', 13.00, 8.14, 4.59, 61, 'Fog Scent Xpressio', '1687446346.webp', '2023-06-22 18:05:46', '2023-06-22 18:05:46', NULL),
	(49, 'Non-Alcoholic Concentrated Perfume Oil', 'non_alcoholic_concentrated_perfume_oil', 1, 'Original Al Munakh® by Mahal Al Musk | Our Impression of Climate | 6ml Non-Alcoholic Concentrated Perfume Oil', 120.00, 15.60, 4.21, 114, 'Al Munakh', 'https://picsum.photos/id/88/200/300', '2023-06-22 18:05:47', '2023-06-22 18:05:47', NULL),
	(50, 'Eau De Perfume Spray', 'eau_de_perfume_spray', 1, 'Genuine  Al-Rehab spray perfume from UAE/Saudi Arabia/Yemen High Quality', 30.00, 10.99, 4.70, 105, 'Lord - Al-Rehab', 'https://picsum.photos/id/11/200/300', '2023-06-22 18:05:48', '2023-06-22 18:05:48', NULL),
	(51, 'Hyaluronic Acid Serum', 'hyaluronic_acid_serum', 1, 'L\'OrÃ©al Paris introduces Hyaluron Expert Replumping Serum formulated with 1.5% Hyaluronic Acid', 19.00, 13.31, 4.83, 110, 'L\'Oreal Paris', 'https://picsum.photos/id/99/200/300', '2023-06-22 18:05:49', '2023-06-22 18:05:49', NULL),
	(52, 'Tree Oil 30ml', 'tree_oil_30ml', 1, 'Tea tree oil contains a number of compounds, including terpinen-4-ol, that have been shown to kill certain bacteria,', 12.00, 4.09, 4.52, 78, 'Hemani Tea', 'https://picsum.photos/id/51/200/300', '2023-06-22 18:05:51', '2023-06-22 18:05:51', NULL),
	(53, 'Oil Free Moisturizer 100ml', 'oil_free_moisturizer_100ml', 1, 'Dermive Oil Free Moisturizer with SPF 20 is specifically formulated with ceramides, hyaluronic acid & sunscreen.', 40.00, 13.10, 4.56, 88, 'Dermive', 'https://picsum.photos/id/71/200/300', '2023-06-22 18:05:52', '2023-06-22 18:05:52', NULL),
	(54, 'Skin Beauty Serum.', 'skin_beauty_serum', 1, 'Product name: rorec collagen hyaluronic acid white face serum riceNet weight: 15 m', 46.00, 10.68, 4.42, 54, 'ROREC White Rice', 'https://picsum.photos/id/42/200/300', '2023-06-22 18:05:53', '2023-06-22 18:05:53', NULL),
	(55, 'Freckle Treatment Cream- 15gm', 'freckle_treatment_cream_15gm', 1, 'Fair & Clear is Pakistan\'s only pure Freckle cream which helpsfade Freckles, Darkspots and pigments. Mercury level is 0%, so there are no side effects.', 70.00, 16.99, 4.06, 140, 'Fair & Clear', 'https://picsum.photos/id/46/200/300', '2023-06-22 18:05:54', '2023-06-22 18:05:54', NULL),
	(56, '- Daal Masoor 500 grams', 'daal_masoor_500_grams', 1, 'Fine quality Branded Product Keep in a cool and dry place', 20.00, 4.81, 4.44, 133, 'Saaf & Khaas', '1687446356.png', '2023-06-22 18:05:56', '2023-06-22 18:05:56', NULL),
	(57, 'Elbow Macaroni - 400 gm', 'elbow_macaroni_400_gm', 1, 'Product details of Bake Parlor Big Elbow Macaroni - 400 gm', 14.00, 15.58, 4.57, 146, 'Bake Parlor Big', 'https://picsum.photos/id/25/200/300', '2023-06-22 18:05:57', '2023-06-22 18:05:57', NULL),
	(58, 'Orange Essence Food Flavou', 'orange_essence_food_flavou', 1, 'Specifications of Orange Essence Food Flavour For Cakes and Baking Food Item', 14.00, 8.04, 4.85, 26, 'Baking Food Items', 'https://picsum.photos/id/24/200/300', '2023-06-22 18:05:58', '2023-06-22 18:05:58', NULL),
	(59, 'cereals muesli fruit nuts', 'cereals_muesli_fruit_nuts', 1, 'original fauji cereal muesli 250gm box pack original fauji cereals muesli fruit nuts flakes breakfast cereal break fast faujicereals cerels cerel foji fouji', 46.00, 16.80, 4.94, 113, 'fauji', 'https://picsum.photos/id/12/200/300', '2023-06-22 18:06:00', '2023-06-22 18:06:00', NULL),
	(60, 'Gulab Powder 50 Gram', 'gulab_powder_50_gram', 1, 'Dry Rose Flower Powder Gulab Powder 50 Gram • Treats Wounds', 70.00, 13.58, 4.87, 47, 'Dry Rose', 'https://picsum.photos/id/23/200/300', '2023-06-22 18:06:01', '2023-06-22 18:06:01', NULL),
	(61, 'Plant Hanger For Home', 'plant_hanger_for_home', 1, 'Boho Decor Plant Hanger For Home Wall Decoration Macrame Wall Hanging Shelf', 41.00, 17.86, 4.08, 131, 'Boho Decor', 'https://picsum.photos/id/22/200/300', '2023-06-22 18:06:02', '2023-06-22 18:06:02', NULL),
	(62, 'Flying Wooden Bird', 'flying_wooden_bird', 1, 'Package Include 6 Birds with Adhesive Tape Shape: 3D Shaped Wooden Birds Material: Wooden MDF, Laminated 3.5mm', 51.00, 15.58, 4.41, 17, 'Flying Wooden', '1687446364.webp', '2023-06-22 18:06:04', '2023-06-22 18:06:04', NULL),
	(63, '3D Embellishment Art Lamp', '3d_embellishment_art_lamp', 1, '3D led lamp sticker Wall sticker 3d wall art light on/off button  cell operated (included)', 20.00, 16.49, 4.82, 54, 'LED Lights', 'https://picsum.photos/id/21/200/300', '2023-06-22 18:06:05', '2023-06-22 18:06:05', NULL),
	(64, 'Handcraft Chinese style', 'handcraft_chinese_style', 1, 'Handcraft Chinese style art luxury palace hotel villa mansion home decor ceramic vase with brass fruit plate', 60.00, 15.34, 4.44, 7, 'luxury palace', '1687446367.webp', '2023-06-22 18:06:07', '2023-06-22 18:06:07', NULL),
	(65, 'Key Holder', 'key_holder', 1, 'Attractive DesignMetallic materialFour key hooksReliable & DurablePremium Quality', 30.00, 2.92, 4.92, 54, 'Golden', 'https://picsum.photos/id/19/200/300', '2023-06-22 18:06:08', '2023-06-22 18:06:08', NULL);

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `cpf` varchar(14) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_as` tinyint NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_cpf_unique` (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `cpf`, `state`, `city`, `status`, `password`, `role_as`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Kevin Lucas de Oliveira Brito', 'kevinbrito2012@gmail.com', NULL, NULL, NULL, NULL, NULL, '$2y$10$QYYDYWq1/DJif.DxOzZiteGgL1yw3sag3en4UGqT7jKiFg4NQO.TC', 1, 'S59LNQ30fqVMlELnt3yCDPGQ4HxJrzQgKFC1nGi95hCrJQfEktb0fFZlBOwr', '2023-06-22 18:09:24', '2023-06-22 18:09:24', NULL);

CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpf_cnpj` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `total_price` decimal(15,2) NOT NULL,
  `payment_mode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracking_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `orders` (`id`, `user_id`, `username`, `email`, `state`, `city`, `cpf_cnpj`, `phone`, `status`, `total_price`, `payment_mode`, `payment_id`, `message`, `tracking_number`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(10, 1, 'Kevin Lucas de Oliveira Brito', 'kevinbrito2012@gmail.com', NULL, NULL, NULL, NULL, 0, 881.06, 'COD', NULL, NULL, 'samambaia2193', '2024-01-09 17:54:37', '2024-01-09 17:54:37', NULL),
	(11, 1, 'Kevin Lucas de Oliveira Brito', 'kevinbrito2012@gmail.com', NULL, NULL, NULL, NULL, 0, 881.06, 'COD', NULL, NULL, 'samambaia8158', '2024-01-09 17:54:48', '2024-01-09 17:54:48', NULL),
	(12, 1, 'Kevin Lucas de Oliveira Brito', 'kevinbrito2012@gmail.com', NULL, NULL, NULL, NULL, 0, 881.06, 'COD', NULL, NULL, 'samambaia9252', '2024-01-09 17:55:28', '2024-01-09 17:55:28', NULL),
	(13, 1, 'Kevin Lucas de Oliveira Brito', 'kevinbrito2012@gmail.com', 'MG', 'João Monlevade', '022.470.916-01', '33991264594', 0, 1092.82, 'COD', NULL, NULL, 'samambaia3995', '2024-01-09 17:56:45', '2024-01-09 17:56:45', NULL),
	(14, 1, 'Kevin Lucas de Oliveira Brito', 'kevinbrito2012@gmail.com', 'MG', 'João Monlevade', '99.999.999/9999-99', '33991264594', 1, 488.42, 'COD', NULL, NULL, 'samambaia3130', '2024-01-09 18:14:01', '2024-01-09 18:14:01', NULL);

CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(19, 10, 37, 1, 881.06, NULL, NULL, NULL),
	(20, 11, 37, 1, 881.06, NULL, NULL, NULL),
	(21, 12, 37, 1, 881.06, NULL, NULL, NULL),
	(22, 13, 45, 1, 1092.82, NULL, NULL, NULL),
	(23, 14, 40, 1, 488.42, NULL, NULL, NULL);

CREATE TABLE IF NOT EXISTS `ratings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `rating` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ratings_user_id_foreign` (`user_id`),
  KEY `ratings_product_id_foreign` (`product_id`),
  CONSTRAINT `ratings_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ratings` (`id`, `user_id`, `product_id`, `rating`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(6, 1, 40, 4, NULL, NULL, NULL),
	(7, 1, 40, 3, NULL, NULL, NULL),
	(8, 1, 40, 5, '2024-01-09 15:15:43', '2024-01-09 15:15:43', NULL);

CREATE TABLE IF NOT EXISTS `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `review` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  KEY `reviews_product_id_foreign` (`product_id`),
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `review`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(6, 1, 40, 'teste 2200sdafasdf', '2024-01-09 18:19:21', '2024-01-09 18:24:07', NULL);

CREATE TABLE IF NOT EXISTS `carts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `items` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_user_id_foreign` (`user_id`),
  KEY `carts_product_id_foreign` (`product_id`),
  CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `items`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(31, 1, 40, 1, NULL, NULL, NULL);

CREATE TABLE IF NOT EXISTS `wishlists` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wishlists_user_id_foreign` (`user_id`),
  KEY `wishlists_product_id_foreign` (`product_id`),
  CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
