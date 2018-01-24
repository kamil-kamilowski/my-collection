<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180124212933 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE user CHANGE COLUMN password password VARCHAR(64) NOT NULL');

        // fulfill users
        $this->addSql('
          UPDATE user SET password = \'$2a$12$7lte2j3DILU8gDGEBIccYui.mzsYm8Ngiv7fqgBoTPLhJyZ6RVnBi\' WHERE user.id = 1
        ');
        $this->addSql('
          INSERT INTO user (id, username, password) VALUES
	      (2, \'kamil\', \'$2a$12$1ISYyQZNRPYmfnDHZ2rdeOX/zM7xG.ANWfy8POmLfYPGH3M3yCxhe\');
        ');

        // fulfill items
        $this->addSql('
        INSERT INTO item (id, user_id, item_category_id, item_genre_id, name, description) VALUES
            (8, 2, 4, 12, \'Star Wars - The Empire Strikes Back\', \'Best SW movie !\'),
            (9, 2, 1, 1, \'Sepultura\', NULL)
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema) {

    }
}
