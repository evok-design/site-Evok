<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181204141100 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE group_categorie DROP FOREIGN KEY FK_89CE8AD5FE54D947');
        $this->addSql('CREATE TABLE bloc (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bloc_categorie (bloc_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_5CDA4DF95582E9C0 (bloc_id), INDEX IDX_5CDA4DF9BCF5E72D (categorie_id), PRIMARY KEY(bloc_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bloc_categorie ADD CONSTRAINT FK_5CDA4DF95582E9C0 FOREIGN KEY (bloc_id) REFERENCES bloc (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bloc_categorie ADD CONSTRAINT FK_5CDA4DF9BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE group_categorie');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bloc_categorie DROP FOREIGN KEY FK_5CDA4DF95582E9C0');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, image VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_categorie (group_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_89CE8AD5FE54D947 (group_id), INDEX IDX_89CE8AD5BCF5E72D (categorie_id), PRIMARY KEY(group_id, categorie_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE group_categorie ADD CONSTRAINT FK_89CE8AD5BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_categorie ADD CONSTRAINT FK_89CE8AD5FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE bloc');
        $this->addSql('DROP TABLE bloc_categorie');
    }
}
