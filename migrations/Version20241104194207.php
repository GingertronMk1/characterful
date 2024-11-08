<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241104194207 extends AbstractMigration
{
    private const TABLE_NAME = 'characters';

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable(self::TABLE_NAME);
        $table->addColumn('id', 'string');
        $table->addColumn('name', 'string');
        $table->addColumn('species', 'string');
        $table->addColumn('species_extra', 'string');
        $table->addColumn('slug', 'string');
        $table->addColumn('levels', 'json');
        $table->addColumn('armour_class', 'json');
        $table->addColumn('proficiency_bonus', 'integer');
        $table->addColumn('speed', 'integer');
        $table->addColumn('passive_perception', 'integer');
        $table->addColumn('current_hit_points', 'integer');
        $table->addColumn('max_hit_points', 'integer');
        $table->addColumn('temporary_hit_points', 'integer');
        $table->addColumn('weapons', 'json');
        $table->addColumn('armours', 'json');
        $table->addColumn('abilities', 'json');
        $table->addColumn('skills', 'json');
        $table->addColumn('saving_throws', 'json');
        $table->addColumn('hit_dice_type', 'integer');
        $table->addColumn('current_hit_dice', 'integer');
        $table->addColumn('max_hit_dice', 'integer');
        $table->addColumn('created_at', 'string');
        $table->addColumn('updated_at', 'string');
        $table->addColumn('deleted_at', 'string', ['notNull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['slug']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable(self::TABLE_NAME);
    }
}
