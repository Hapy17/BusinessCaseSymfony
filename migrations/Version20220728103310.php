<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220728103310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89C44AA2B9');
        $this->addSql('DROP TABLE picture_path');
        $this->addSql('DROP INDEX IDX_16DB4F89C44AA2B9 ON picture');
        $this->addSql('ALTER TABLE picture ADD path VARCHAR(255) NOT NULL, DROP picture_path_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE picture_path (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE picture ADD picture_path_id INT NOT NULL, DROP path');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89C44AA2B9 FOREIGN KEY (picture_path_id) REFERENCES picture_path (id)');
        $this->addSql('CREATE INDEX IDX_16DB4F89C44AA2B9 ON picture (picture_path_id)');
    }
}
