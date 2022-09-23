<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220902101832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add shopping_list and item_list tables and relations';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE department_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE item_list_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE shopping_list_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql(
            'CREATE TABLE department (
                id INT NOT NULL,
                owner_id INT DEFAULT NULL,
                name VARCHAR(255) NOT NULL,
                color VARCHAR(255) NOT NULL,
                icon VARCHAR(255) NOT NULL,
                PRIMARY KEY(id)
            )'
        );
        $this->addSql('CREATE INDEX IDX_CD1DE18A7E3C61F9 ON department (owner_id)');
        $this->addSql(
            'CREATE TABLE item_list (
                id INT NOT NULL,
                shopping_list_id INT NOT NULL,
                product_id INT NOT NULL,
                quantity INT NOT NULL,
                PRIMARY KEY(id)
            )'
        );
        $this->addSql('CREATE INDEX IDX_8CF8BCE323245BF9 ON item_list (shopping_list_id)');
        $this->addSql('CREATE INDEX IDX_8CF8BCE34584665A ON item_list (product_id)');
        $this->addSql(
            'CREATE TABLE shopping_list (
                id INT NOT NULL,
                name VARCHAR(120) NOT NULL,
                PRIMARY KEY(id)
            )'
        );
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18A7E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item_list ADD CONSTRAINT FK_8CF8BCE323245BF9 FOREIGN KEY (shopping_list_id) REFERENCES shopping_list (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item_list ADD CONSTRAINT FK_8CF8BCE34584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product ADD department_id INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADAE80F5DF FOREIGN KEY (department_id) REFERENCES department (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D34A04ADAE80F5DF ON product (department_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('ALTER TABLE "user" ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04ADAE80F5DF');
        $this->addSql('DROP SEQUENCE department_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE item_list_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE shopping_list_id_seq CASCADE');
        $this->addSql('ALTER TABLE department DROP CONSTRAINT FK_CD1DE18A7E3C61F9');
        $this->addSql('ALTER TABLE item_list DROP CONSTRAINT FK_8CF8BCE323245BF9');
        $this->addSql('ALTER TABLE item_list DROP CONSTRAINT FK_8CF8BCE34584665A');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE item_list');
        $this->addSql('DROP TABLE shopping_list');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('DROP INDEX "primary"');
        $this->addSql('DROP INDEX IDX_D34A04ADAE80F5DF');
        $this->addSql('ALTER TABLE product DROP department_id');
    }
}
