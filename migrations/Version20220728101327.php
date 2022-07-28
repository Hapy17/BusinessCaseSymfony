<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220728101327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_animal (product_id INT NOT NULL, animal_id INT NOT NULL, INDEX IDX_8D762BB4584665A (product_id), INDEX IDX_8D762BB8E962C16 (animal_id), PRIMARY KEY(product_id, animal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_user (product_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_7BF4E84584665A (product_id), INDEX IDX_7BF4E8A76ED395 (user_id), PRIMARY KEY(product_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_animal ADD CONSTRAINT FK_8D762BB4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_animal ADD CONSTRAINT FK_8D762BB8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_user ADD CONSTRAINT FK_7BF4E84584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_user ADD CONSTRAINT FK_7BF4E8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE basket ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE basket ADD CONSTRAINT FK_2246507BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2246507BA76ED395 ON basket (user_id)');
        $this->addSql('ALTER TABLE category ADD related_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1D9ADE366 FOREIGN KEY (related_category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_64C19C1D9ADE366 ON category (related_category_id)');
        $this->addSql('ALTER TABLE contain ADD product_id INT NOT NULL, ADD basket_id INT NOT NULL');
        $this->addSql('ALTER TABLE contain ADD CONSTRAINT FK_4BEFF7C84584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE contain ADD CONSTRAINT FK_4BEFF7C81BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id)');
        $this->addSql('CREATE INDEX IDX_4BEFF7C84584665A ON contain (product_id)');
        $this->addSql('CREATE INDEX IDX_4BEFF7C81BE1FB52 ON contain (basket_id)');
        $this->addSql('ALTER TABLE `order` ADD basket_id INT NOT NULL, ADD postal_address_id INT NOT NULL, ADD order_state_id INT NOT NULL, ADD payment_method_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993981BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398FD54954B FOREIGN KEY (postal_address_id) REFERENCES postal_address (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398E420DE70 FOREIGN KEY (order_state_id) REFERENCES order_state (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993985AA1164F FOREIGN KEY (payment_method_id) REFERENCES payment_method (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F52993981BE1FB52 ON `order` (basket_id)');
        $this->addSql('CREATE INDEX IDX_F5299398FD54954B ON `order` (postal_address_id)');
        $this->addSql('CREATE INDEX IDX_F5299398E420DE70 ON `order` (order_state_id)');
        $this->addSql('CREATE INDEX IDX_F52993985AA1164F ON `order` (payment_method_id)');
        $this->addSql('ALTER TABLE picture ADD picture_path_id INT NOT NULL, ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89C44AA2B9 FOREIGN KEY (picture_path_id) REFERENCES picture_path (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F894584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_16DB4F89C44AA2B9 ON picture (picture_path_id)');
        $this->addSql('CREATE INDEX IDX_16DB4F894584665A ON picture (product_id)');
        $this->addSql('ALTER TABLE review ADD product_id INT NOT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C64584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_794381C64584665A ON review (product_id)');
        $this->addSql('CREATE INDEX IDX_794381C6A76ED395 ON review (user_id)');
        $this->addSql('ALTER TABLE user ADD postal_address_id INT DEFAULT NULL, ADD gender_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649FD54954B FOREIGN KEY (postal_address_id) REFERENCES postal_address (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649708A0E0 FOREIGN KEY (gender_id) REFERENCES gender (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649FD54954B ON user (postal_address_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649708A0E0 ON user (gender_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product_animal');
        $this->addSql('DROP TABLE product_user');
        $this->addSql('ALTER TABLE basket DROP FOREIGN KEY FK_2246507BA76ED395');
        $this->addSql('DROP INDEX IDX_2246507BA76ED395 ON basket');
        $this->addSql('ALTER TABLE basket DROP user_id');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1D9ADE366');
        $this->addSql('DROP INDEX IDX_64C19C1D9ADE366 ON category');
        $this->addSql('ALTER TABLE category DROP related_category_id');
        $this->addSql('ALTER TABLE contain DROP FOREIGN KEY FK_4BEFF7C84584665A');
        $this->addSql('ALTER TABLE contain DROP FOREIGN KEY FK_4BEFF7C81BE1FB52');
        $this->addSql('DROP INDEX IDX_4BEFF7C84584665A ON contain');
        $this->addSql('DROP INDEX IDX_4BEFF7C81BE1FB52 ON contain');
        $this->addSql('ALTER TABLE contain DROP product_id, DROP basket_id');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993981BE1FB52');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398FD54954B');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398E420DE70');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993985AA1164F');
        $this->addSql('DROP INDEX UNIQ_F52993981BE1FB52 ON `order`');
        $this->addSql('DROP INDEX IDX_F5299398FD54954B ON `order`');
        $this->addSql('DROP INDEX IDX_F5299398E420DE70 ON `order`');
        $this->addSql('DROP INDEX IDX_F52993985AA1164F ON `order`');
        $this->addSql('ALTER TABLE `order` DROP basket_id, DROP postal_address_id, DROP order_state_id, DROP payment_method_id');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89C44AA2B9');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F894584665A');
        $this->addSql('DROP INDEX IDX_16DB4F89C44AA2B9 ON picture');
        $this->addSql('DROP INDEX IDX_16DB4F894584665A ON picture');
        $this->addSql('ALTER TABLE picture DROP picture_path_id, DROP product_id');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C64584665A');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6A76ED395');
        $this->addSql('DROP INDEX IDX_794381C64584665A ON review');
        $this->addSql('DROP INDEX IDX_794381C6A76ED395 ON review');
        $this->addSql('ALTER TABLE review DROP product_id, DROP user_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649FD54954B');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649708A0E0');
        $this->addSql('DROP INDEX IDX_8D93D649FD54954B ON user');
        $this->addSql('DROP INDEX IDX_8D93D649708A0E0 ON user');
        $this->addSql('ALTER TABLE user DROP postal_address_id, DROP gender_id');
    }
}
