<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180121095812 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, item_category_id INT NOT NULL, item_genre_id INT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(1000) DEFAULT NULL, INDEX IDX_1F1B251EA76ED395 (user_id), INDEX IDX_1F1B251EF22EC5D4 (item_category_id), INDEX IDX_1F1B251E2E9B1BD4 (item_genre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_6A41D10A5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_genre (id INT AUTO_INCREMENT NOT NULL, item_category_id INT NOT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_A9F72828F22EC5D4 (item_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(32) NOT NULL, password VARCHAR(32) NOT NULL, UNIQUE INDEX UNIQ_8D93D649AA08CB10 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EF22EC5D4 FOREIGN KEY (item_category_id) REFERENCES item_category (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E2E9B1BD4 FOREIGN KEY (item_genre_id) REFERENCES item_genre (id)');
        $this->addSql('ALTER TABLE item_genre ADD CONSTRAINT FK_A9F72828F22EC5D4 FOREIGN KEY (item_category_id) REFERENCES item_category (id)');

        // fulfill categories
        $this->addSql('
        INSERT INTO `item_category` (`id`, `name`) VALUES
            (3, \'Book\'),
            (4, \'Movie\'),
            (1, \'Music\'),
            (2, \'Video Game\');
        ');

        // fulfill genres
        $this->addSql('
        INSERT INTO `item_genre` (`id`, `item_category_id`, `name`) VALUES
            (1, 1, \'Rock\'),
            (2, 1, \'Techno\'),
            (3, 1, \'Reggae\'),
            (4, 1, \'Pop\'),
            (6, 2, \'Shooter\'),
            (7, 2, \'Strategy\'),
            (8, 2, \'RPG\'),
            (10, 4, \'Thriller\'),
            (11, 4, \'Comedy\'),
            (12, 4, \'Sci-fi\'),
            (13, 3, \'Thriller\'),
            (14, 3, \'Adventure\'),
            (15, 3, \'Romance\');
        ');

        // fulfill users
        $this->addSql('
        INSERT INTO `user` (`id`, `username`, `password`) VALUES
	      (1, \'admin\', \'60d5653c635f58d04958fcd2e3a6c36a\');
        ');

        // fulfill items
        $this->addSql('
        INSERT INTO `item` (`id`, `user_id`, `item_category_id`, `item_genre_id`, `name`, `description`) VALUES
            (1, 1, 4, 12, \'Star Wars a New Hope\', \'First movie of original Star Wars Trilogy\'),
            (2, 1, 1, 3, \'Bob Marley - The Best of\', NULL),
            (4, 1, 3, 14, \'Witcher: The Last Wisch\', \'First book of Witcher saga\'),
            (5, 1, 1, 1, \'Metallica - Master of Puppets\', \'Best album ever !\'),
            (6, 1, 2, 8, \'Baldurs Game\', \'Best RPG ever !\'),
            (7, 1, 2, 6, \'Quake 3 Arena\', \'A multiplayer arena shooter\');
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251EF22EC5D4');
        $this->addSql('ALTER TABLE item_genre DROP FOREIGN KEY FK_A9F72828F22EC5D4');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E2E9B1BD4');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251EA76ED395');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE item_category');
        $this->addSql('DROP TABLE item_genre');
        $this->addSql('DROP TABLE user');
    }
}
