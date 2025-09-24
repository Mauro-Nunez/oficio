<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250924210904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registro_delegacion DROP FOREIGN KEY FK_EAAFB4E139C50FAE');
        $this->addSql('ALTER TABLE registro_delegacion DROP FOREIGN KEY FK_EAAFB4E1F4B21EB5');
        $this->addSql('DROP TABLE delegacion');
        $this->addSql('DROP TABLE registro_delegacion');
        $this->addSql('ALTER TABLE oficio ADD status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE registro ADD status TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE delegacion (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE registro_delegacion (registro_id INT NOT NULL, delegacion_id INT NOT NULL, INDEX IDX_EAAFB4E139C50FAE (registro_id), INDEX IDX_EAAFB4E1F4B21EB5 (delegacion_id), PRIMARY KEY(registro_id, delegacion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE registro_delegacion ADD CONSTRAINT FK_EAAFB4E139C50FAE FOREIGN KEY (registro_id) REFERENCES registro (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE registro_delegacion ADD CONSTRAINT FK_EAAFB4E1F4B21EB5 FOREIGN KEY (delegacion_id) REFERENCES delegacion (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE registro DROP status');
        $this->addSql('ALTER TABLE oficio DROP status');
    }
}
