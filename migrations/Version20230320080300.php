<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320080300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alternative ADD etape_precedente_id INT DEFAULT NULL, ADD etape_suivante_id INT NOT NULL');
        $this->addSql('ALTER TABLE alternative ADD CONSTRAINT FK_EFF5DFA3F94EAC8 FOREIGN KEY (etape_precedente_id) REFERENCES etape (id)');
        $this->addSql('ALTER TABLE alternative ADD CONSTRAINT FK_EFF5DFA62A0957E FOREIGN KEY (etape_suivante_id) REFERENCES etape (id)');
        $this->addSql('CREATE INDEX IDX_EFF5DFA3F94EAC8 ON alternative (etape_precedente_id)');
        $this->addSql('CREATE INDEX IDX_EFF5DFA62A0957E ON alternative (etape_suivante_id)');
        $this->addSql('ALTER TABLE partie ADD aventure_id INT NOT NULL, ADD aventurier_id INT NOT NULL, ADD etape_id INT NOT NULL');
        $this->addSql('ALTER TABLE partie ADD CONSTRAINT FK_59B1F3D873DBB5F FOREIGN KEY (aventure_id) REFERENCES aventure (id)');
        $this->addSql('ALTER TABLE partie ADD CONSTRAINT FK_59B1F3DEDDC7141 FOREIGN KEY (aventurier_id) REFERENCES personnage (id)');
        $this->addSql('ALTER TABLE partie ADD CONSTRAINT FK_59B1F3D4A8CA2AD FOREIGN KEY (etape_id) REFERENCES etape (id)');
        $this->addSql('CREATE INDEX IDX_59B1F3D873DBB5F ON partie (aventure_id)');
        $this->addSql('CREATE INDEX IDX_59B1F3DEDDC7141 ON partie (aventurier_id)');
        $this->addSql('CREATE INDEX IDX_59B1F3D4A8CA2AD ON partie (etape_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alternative DROP FOREIGN KEY FK_EFF5DFA3F94EAC8');
        $this->addSql('ALTER TABLE alternative DROP FOREIGN KEY FK_EFF5DFA62A0957E');
        $this->addSql('DROP INDEX IDX_EFF5DFA3F94EAC8 ON alternative');
        $this->addSql('DROP INDEX IDX_EFF5DFA62A0957E ON alternative');
        $this->addSql('ALTER TABLE alternative DROP etape_precedente_id, DROP etape_suivante_id');
        $this->addSql('ALTER TABLE partie DROP FOREIGN KEY FK_59B1F3D873DBB5F');
        $this->addSql('ALTER TABLE partie DROP FOREIGN KEY FK_59B1F3DEDDC7141');
        $this->addSql('ALTER TABLE partie DROP FOREIGN KEY FK_59B1F3D4A8CA2AD');
        $this->addSql('DROP INDEX IDX_59B1F3D873DBB5F ON partie');
        $this->addSql('DROP INDEX IDX_59B1F3DEDDC7141 ON partie');
        $this->addSql('DROP INDEX IDX_59B1F3D4A8CA2AD ON partie');
        $this->addSql('ALTER TABLE partie DROP aventure_id, DROP aventurier_id, DROP etape_id');
    }
}
