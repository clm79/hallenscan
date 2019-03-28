<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190328153518 extends AbstractMigration {

    public function getDescription(): string {
        return 'Initial Migration';
    }

    public function up(Schema $schema): void {
        $table = $schema->createTable('partner');
        $table->addColumn('interne_id', 'integer', ['autoincrement' => true]);
        $table->addColumn('zeitstempel', 'datetime', ['notnull' => true]);
        $table->addColumn('aktiv', 'boolean', ['notnull' => true]);
        $table->addColumn('name', 'string', ['notnull' => true]);
        $table->setPrimaryKey(['interne_id']);

        $table = $schema->createTable('hub');
        $table->addColumn('interne_id', 'integer', ['autoincrement' => true]);
        $table->addColumn('zeitstempel', 'datetime', ['notnull' => true]);
        $table->addColumn('aktiv', 'boolean', ['notnull' => true]);
        $table->addColumn('partner_id', 'integer', ['notnull' => true]);
        $table->addColumn('name', 'string', ['notnull' => true]);
        $table->setPrimaryKey(['interne_id']);
        $table->addForeignKeyConstraint('partner', ['partner_id'], ['interne_id'], [], 'hub_partner_id_fk');

        $table = $schema->createTable('bordero');
        $table->addColumn('interne_id', 'integer', ['autoincrement' => true]);
        $table->addColumn('zeitstempel', 'datetime', ['notnull' => true]);
        $table->addColumn('hub_id', 'integer', ['notnull' => true]);
        $table->addColumn('nummer', 'string', ['notnull' => true]);
        $table->setPrimaryKey(['interne_id']);
        $table->addForeignKeyConstraint('hub', ['hub_id'], ['interne_id'], [], 'bordero_hub_id_fk');

        $table = $schema->createTable('sendung');
        $table->addColumn('interne_id', 'integer', ['autoincrement' => true]);
        $table->addColumn('zeitstempel', 'datetime', ['notnull' => true]);
        $table->addColumn('bordero_id', 'integer', ['notnull' => true]);
        $table->addColumn('barcode', 'string', ['notnull' => true]);
        $table->setPrimaryKey(['interne_id']);
        $table->addForeignKeyConstraint('bordero', ['bordero_id'], ['interne_id'], [], 'sendung_bordero_id_fk');

        $table = $schema->createTable('colli');
        $table->addColumn('interne_id', 'integer', ['autoincrement' => true]);
        $table->addColumn('zeitstempel', 'datetime', ['notnull' => true]);
        $table->addColumn('sendung_id', 'integer', ['notnull' => true]);
        $table->addColumn('barcode', 'string', ['notnull' => true]);
        $table->setPrimaryKey(['interne_id']);
        $table->addForeignKeyConstraint('sendung', ['sendung_id'], ['interne_id'], [], 'colli_sendung_id_fk');
    }

    public function down(Schema $schema): void {
        $schema->dropTable('colli');
        $schema->dropTable('sendung');
        $schema->dropTable('bordero');
        $schema->dropTable('hub');
        $schema->dropTable('partner');
    }

}
