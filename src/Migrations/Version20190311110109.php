<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190311110109 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE creation ADD description2 LONGTEXT DEFAULT NULL, ADD image_corps_2 VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE creation ADD CONSTRAINT FK_57EE857419EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_57EE857419EB6921 ON creation (client_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE creation DROP FOREIGN KEY FK_57EE857419EB6921');
        $this->addSql('DROP INDEX IDX_57EE857419EB6921 ON creation');
        $this->addSql('ALTER TABLE creation DROP description2, DROP image_corps_2');
    }
}
