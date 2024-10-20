CREATE TABLE `user`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `role` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `no_hp` BIGINT NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    `updated_at` TIMESTAMP NOT NULL,
    `is_active` TINYINT(1) NOT NULL,
    `is_deleted` TINYINT(1) NOT NULL
);
CREATE TABLE `log_item`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT NOT NULL,
    `item` BIGINT NOT NULL,
    `notes` BIGINT NOT NULL,
    `jumlah` BIGINT NOT NULL,
    `tanggal_pengembalian` BIGINT NOT NULL,
    `status` BIGINT NOT NULL,
    `status_approval` BIGINT NOT NULL,
    `notes_approval` BIGINT NOT NULL,
    `tanggal_approval` BIGINT NOT NULL,
    `approval_by` BIGINT NOT NULL,
    `created_at` BIGINT NOT NULL,
    `updated_at` BIGINT NOT NULL
);
ALTER TABLE
    `log_item` ADD CONSTRAINT `log_item_user_id_foreign` FOREIGN KEY(`user_id`) REFERENCES `user`(`id`);