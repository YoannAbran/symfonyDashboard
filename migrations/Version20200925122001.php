<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200925122001 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, ref VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, buy_price DOUBLE PRECISION NOT NULL, sold_price DOUBLE PRECISION NOT NULL, rent_price DOUBLE PRECISION NOT NULL, stock INT NOT NULL, sold INT NOT NULL, rent INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_flow (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, book_id INT NOT NULL, flow_id INT NOT NULL, INDEX IDX_6517207A76ED395 (user_id), INDEX IDX_651720716A2B381 (book_id), INDEX IDX_65172077EB60D1B (flow_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flow (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, buy_date DATE DEFAULT NULL, rent_date DATE DEFAULT NULL, return_date DATE DEFAULT NULL, return_ok TINYINT(1) DEFAULT NULL, INDEX IDX_52C0D67016A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE customer_flow ADD CONSTRAINT FK_6517207A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE customer_flow ADD CONSTRAINT FK_651720716A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE customer_flow ADD CONSTRAINT FK_65172077EB60D1B FOREIGN KEY (flow_id) REFERENCES flow (id)');
        $this->addSql('ALTER TABLE flow ADD CONSTRAINT FK_52C0D67016A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer_flow DROP FOREIGN KEY FK_651720716A2B381');
        $this->addSql('ALTER TABLE flow DROP FOREIGN KEY FK_52C0D67016A2B381');
        $this->addSql('ALTER TABLE customer_flow DROP FOREIGN KEY FK_65172077EB60D1B');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE customer_flow');
        $this->addSql('DROP TABLE flow');
    }
}
