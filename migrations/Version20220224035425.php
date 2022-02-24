<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220224035425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE destination DROP nbr_participants_dest, CHANGE nbr_part_dest nbr_part_dest INT DEFAULT NULL, CHANGE event_dest event_dest INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE destination ADD nbr_participants_dest INT DEFAULT NULL, CHANGE nbr_part_dest nbr_part_dest VARCHAR(255) DEFAULT NULL, CHANGE event_dest event_dest VARCHAR(255) DEFAULT NULL');
    }
}
