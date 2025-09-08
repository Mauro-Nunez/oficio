<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251209_createdAt extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add createdAt field to recomendacion and registro tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recomendacion ADD created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE registro ADD created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE registro ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recomendacion DROP created_at');
        $this->addSql('ALTER TABLE registro DROP created_at');
        $this->addSql('ALTER TABLE registro DROP updated_at');
    }
}