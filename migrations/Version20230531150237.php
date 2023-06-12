<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230531150237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE actor_programm (actor_id INT NOT NULL, programm_id INT NOT NULL, INDEX IDX_A603253010DAF24A (actor_id), INDEX IDX_A6032530B75CCC90 (programm_id), PRIMARY KEY(actor_id, programm_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actor_programm ADD CONSTRAINT FK_A603253010DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE actor_programm ADD CONSTRAINT FK_A6032530B75CCC90 FOREIGN KEY (programm_id) REFERENCES programm (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actor_programm DROP FOREIGN KEY FK_A603253010DAF24A');
        $this->addSql('ALTER TABLE actor_programm DROP FOREIGN KEY FK_A6032530B75CCC90');
        $this->addSql('DROP TABLE actor');
        $this->addSql('DROP TABLE actor_programm');
    }
}
