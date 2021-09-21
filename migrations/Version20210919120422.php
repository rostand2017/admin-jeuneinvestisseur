<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210919120422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(254) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, createdAt DATETIME DEFAULT CURRENT_TIMESTAMP, UNIQUE INDEX UNIQ_880E0D76E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(254) NOT NULL, createdat DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, news INT DEFAULT NULL, user INT DEFAULT NULL, comment INT DEFAULT NULL, content VARCHAR(254) NOT NULL, name VARCHAR(254) NOT NULL, email VARCHAR(254) NOT NULL, createdat DATETIME DEFAULT NULL, INDEX fk_association3 (user), INDEX fk_association2 (news), INDEX fk_association5 (comment), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contacts (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(254) NOT NULL, tel VARCHAR(254) NOT NULL, email VARCHAR(254) NOT NULL, message VARCHAR(254) NOT NULL, createdat DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emails (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(254) NOT NULL, createdat DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, category INT DEFAULT NULL, admin INT DEFAULT NULL, title VARCHAR(254) NOT NULL, content LONGTEXT NOT NULL, is_deleted TINYINT(1) NOT NULL, image VARCHAR(254) NOT NULL, createdat DATETIME NOT NULL, updatedat DATETIME NOT NULL, INDEX fk_association6 (admin), INDEX fk_association4 (category), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(254) NOT NULL, name VARCHAR(254) NOT NULL, password VARCHAR(254) NOT NULL, roles JSON DEFAULT NULL, createdat DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE viewers (id INT AUTO_INCREMENT NOT NULL, news INT DEFAULT NULL, viewerkey VARCHAR(254) NOT NULL, createdat DATETIME DEFAULT NULL, INDEX fk_association1 (news), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C1DD39950 FOREIGN KEY (news) REFERENCES news (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C8D93D649 FOREIGN KEY (user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9474526C FOREIGN KEY (comment) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD3995064C19C1 FOREIGN KEY (category) REFERENCES category (id)');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD39950880E0D76 FOREIGN KEY (admin) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE viewers ADD CONSTRAINT FK_C36DC1DD39950 FOREIGN KEY (news) REFERENCES news (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD39950880E0D76');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD3995064C19C1');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9474526C');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C1DD39950');
        $this->addSql('ALTER TABLE viewers DROP FOREIGN KEY FK_C36DC1DD39950');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C8D93D649');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE contacts');
        $this->addSql('DROP TABLE emails');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE viewers');
    }
}
