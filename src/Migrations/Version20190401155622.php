<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190401155622 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actualites ADD slider_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE actualites ADD CONSTRAINT FK_75315B6D2CCC9638 FOREIGN KEY (slider_id) REFERENCES slider (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_75315B6D2CCC9638 ON actualites (slider_id)');
        $this->addSql('ALTER TABLE slide CHANGE slider_id slider_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actualites DROP FOREIGN KEY FK_75315B6D2CCC9638');
        $this->addSql('DROP INDEX UNIQ_75315B6D2CCC9638 ON actualites');
        $this->addSql('ALTER TABLE actualites DROP slider_id');
        $this->addSql('ALTER TABLE slide CHANGE slider_id slider_id INT NOT NULL');
    }
}
