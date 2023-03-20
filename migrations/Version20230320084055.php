<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320084055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etape DROP FOREIGN KEY FK_285F75DDF58143C1');
        $this->addSql('ALTER TABLE etape DROP FOREIGN KEY FK_285F75DDC3DCFBBF');
        $this->addSql('DROP INDEX IDX_285F75DDF58143C1 ON etape');
        $this->addSql('ALTER TABLE etape CHANGE fin_adventure_id aventure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE etape ADD CONSTRAINT FK_285F75DD873DBB5F FOREIGN KEY (aventure_id) REFERENCES aventure (id)');
        $this->addSql('ALTER TABLE etape ADD CONSTRAINT FK_285F75DDC3DCFBBF FOREIGN KEY (fin_aventure_id) REFERENCES aventure (id)');
        $this->addSql('CREATE INDEX IDX_285F75DD873DBB5F ON etape (aventure_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etape DROP FOREIGN KEY FK_285F75DD873DBB5F');
        $this->addSql('ALTER TABLE etape DROP FOREIGN KEY FK_285F75DDC3DCFBBF');
        $this->addSql('DROP INDEX IDX_285F75DD873DBB5F ON etape');
        $this->addSql('ALTER TABLE etape CHANGE aventure_id fin_adventure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE etape ADD CONSTRAINT FK_285F75DDF58143C1 FOREIGN KEY (fin_adventure_id) REFERENCES avatar (id)');
        $this->addSql('ALTER TABLE etape ADD CONSTRAINT FK_285F75DDC3DCFBBF FOREIGN KEY (fin_aventure_id) REFERENCES avatar (id)');
        $this->addSql('CREATE INDEX IDX_285F75DDF58143C1 ON etape (fin_adventure_id)');
    }
}
