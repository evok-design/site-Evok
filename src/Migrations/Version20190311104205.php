<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190311104205 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE creation ADD client_id INT NOT NULL, ADD image1 VARCHAR(255) NOT NULL, ADD image2 VARCHAR(255) NOT NULL, ADD image_header VARCHAR(255) NOT NULL, ADD image_content VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE creation ADD CONSTRAINT FK_57EE857419EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_57EE857419EB6921 ON creation (client_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE creation DROP FOREIGN KEY FK_57EE857419EB6921');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP INDEX IDX_57EE857419EB6921 ON creation');
        $this->addSql('ALTER TABLE creation DROP client_id, DROP image1, DROP image2, DROP image_header, DROP image_content');
    }
}
