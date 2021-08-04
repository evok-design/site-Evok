<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191003073531 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE slide CHANGE slider_id slider_id INT DEFAULT NULL, CHANGE tabindex tabindex INT DEFAULT NULL');
        $this->addSql('ALTER TABLE actualites ADD video VARCHAR(255) DEFAULT NULL, CHANGE slider_id slider_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE nom nom VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE creation CHANGE slider_id slider_id INT DEFAULT NULL, CHANGE image_content image_content VARCHAR(255) DEFAULT NULL, CHANGE image_corps_2 image_corps_2 VARCHAR(255) DEFAULT NULL, CHANGE ordre ordre INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bloc CHANGE slider_id slider_id INT DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE img_content2 img_content2 VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actualites DROP video, CHANGE slider_id slider_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bloc CHANGE slider_id slider_id INT DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE img_content2 img_content2 VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE creation CHANGE slider_id slider_id INT DEFAULT NULL, CHANGE image_content image_content VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE image_corps_2 image_corps_2 VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE ordre ordre INT DEFAULT NULL');
        $this->addSql('ALTER TABLE slide CHANGE slider_id slider_id INT DEFAULT NULL, CHANGE tabindex tabindex INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE nom nom VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
