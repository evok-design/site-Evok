<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190326153652 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE slide (id INT AUTO_INCREMENT NOT NULL, slider_id INT NOT NULL, url_image VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_72EFEE622CCC9638 (slider_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slider (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE slide ADD CONSTRAINT FK_72EFEE622CCC9638 FOREIGN KEY (slider_id) REFERENCES slider (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C778955A989D9B62 ON bloc (slug)');
        $this->addSql('ALTER TABLE creation ADD CONSTRAINT FK_57EE857419EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_57EE857419EB6921 ON creation (client_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE slide DROP FOREIGN KEY FK_72EFEE622CCC9638');
        $this->addSql('DROP TABLE slide');
        $this->addSql('DROP TABLE slider');
        $this->addSql('DROP INDEX UNIQ_C778955A989D9B62 ON bloc');
        $this->addSql('ALTER TABLE creation DROP FOREIGN KEY FK_57EE857419EB6921');
        $this->addSql('DROP INDEX IDX_57EE857419EB6921 ON creation');
    }
}
