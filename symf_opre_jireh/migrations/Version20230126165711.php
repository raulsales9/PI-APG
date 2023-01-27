<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126165711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorias (id_categoria INT NOT NULL, product_list_id INT NOT NULL, name_categoria VARCHAR(50) DEFAULT NULL, INDEX IDX_5E9F836CEC770D3B (product_list_id), PRIMARY KEY(id_categoria)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files (id_file INT NOT NULL, id_user_id INT NOT NULL, up_date DATE NOT NULL, name VARCHAR(50) NOT NULL, type VARCHAR(20) DEFAULT NULL, is_submitted TINYINT(1) NOT NULL, INDEX IDX_635405979F37AE5 (id_user_id), PRIMARY KEY(id_file)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id_product INT NOT NULL, name_product VARCHAR(255) NOT NULL, price NUMERIC(5, 2) DEFAULT NULL, PRIMARY KEY(id_product)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id_user INT NOT NULL, surname VARCHAR(100) DEFAULT NULL, phone VARCHAR(20) NOT NULL, name VARCHAR(20) NOT NULL, email VARCHAR(40) NOT NULL, is_admin TINYINT(1) NOT NULL, PRIMARY KEY(id_user)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorias ADD CONSTRAINT FK_5E9F836CEC770D3B FOREIGN KEY (product_list_id) REFERENCES products (id_product)');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_635405979F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id_user)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorias DROP FOREIGN KEY FK_5E9F836CEC770D3B');
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY FK_635405979F37AE5');
        $this->addSql('DROP TABLE categorias');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
