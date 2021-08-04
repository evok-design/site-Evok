<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190426153112 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE slide CHANGE slider_id slider_id INT DEFAULT NULL, CHANGE tabindex tabindex INT DEFAULT NULL');
        $this->addSql('ALTER TABLE actualites CHANGE slider_id slider_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE creation ADD ordre INT DEFAULT NULL, CHANGE slider_id slider_id INT DEFAULT NULL, CHANGE image_content image_content VARCHAR(255) DEFAULT NULL, CHANGE image_corps_2 image_corps_2 VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE bloc CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE img_content2 img_content2 VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE actualites CHANGE slider_id slider_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bloc CHANGE image image VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_general_ci, CHANGE img_content2 img_content2 VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE creation DROP ordre, CHANGE slider_id slider_id INT DEFAULT NULL, CHANGE image_content image_content VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_general_ci, CHANGE image_corps_2 image_corps_2 VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE slide CHANGE slider_id slider_id INT DEFAULT NULL, CHANGE tabindex tabindex INT DEFAULT NULL');
    }
}
