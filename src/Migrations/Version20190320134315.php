<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190320134315 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bloc ADD img_header VARCHAR(255) NOT NULL, ADD description1 LONGTEXT NOT NULL, ADD img_content1 VARCHAR(255) NOT NULL, ADD description2 LONGTEXT DEFAULT NULL, ADD img_content2 VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE creation ADD CONSTRAINT FK_57EE857419EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_57EE857419EB6921 ON creation (client_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bloc DROP img_header, DROP description1, DROP img_content1, DROP description2, DROP img_content2');
        $this->addSql('ALTER TABLE creation DROP FOREIGN KEY FK_57EE857419EB6921');
        $this->addSql('DROP INDEX IDX_57EE857419EB6921 ON creation');
    }
}
