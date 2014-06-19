<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20140101010101_HcCore extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS `locale` (
                          `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                          `priority` TINYINT UNSIGNED NOT NULL,
                          `title` VARCHAR(100) NOT NULL,
                          `lang` VARCHAR(2) NOT NULL,
                          `locale` VARCHAR(5) NOT NULL,
                          `priority` TINYINT NOT NULL DEFAULT 1,
                          `is_default` TINYINT UNSIGNED NOT NULL DEFAULT 0,
                          PRIMARY KEY (`id`),
                          UNIQUE INDEX `locale_UNIQUE` (`locale` ASC))
                       ENGINE = InnoDB');
    }

    public function down(Schema $schema)
    {
        $schema->dropTable('locale');
    }
}
