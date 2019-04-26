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
        $table = $schema->createTable('zend_log');
        $table->addColumn('interne_id', 'integer', ['autoincrement' => true]);
        $table->addColumn('timestamp', 'datetime', ['notnull' => true]);
        $table->addColumn('priority', 'integer', ['notnull' => true]);
        $table->addColumn('priorityName', 'string', ['notnull' => true]);
        $table->addColumn('message', 'string', ['notnull' => false]);
        $table->addColumn('extra_classMethod', 'string', ['notnull' => false]);
        $table->addColumn('extra_requestId', 'string', ['notnull' => false]);
        $table->addColumn('extra_requestMethod', 'string', ['notnull' => false]);
        $table->addColumn('extra_requestURI', 'string', ['notnull' => false]);
        $table->addColumn('extra_requestParams', 'string', ['notnull' => false]);
        $table->setPrimaryKey(['interne_id']);

        $table = $schema->createTable('partner');
        $table->addColumn('interne_id', 'integer', ['autoincrement' => true]);
        $table->addColumn('zeitstempel', 'datetime', ['notnull' => true]);
        $table->addColumn('aktiv', 'boolean', ['notnull' => true]);
        $table->addColumn('name', 'string', ['notnull' => true]);
        $table->addColumn('eigene_depot_kennung', 'string', ['notnull' => true]);
        $table->addColumn('bordero_import_pfad', 'string', ['notnull' => true]);
        $table->addColumn('bordero_import_pattern', 'string', ['notnull' => true]);
        $table->setPrimaryKey(['interne_id']);

        $table = $schema->createTable('hub');
        $table->addColumn('interne_id', 'integer', ['autoincrement' => true]);
        $table->addColumn('zeitstempel', 'datetime', ['notnull' => true]);
        $table->addColumn('aktiv', 'boolean', ['notnull' => true]);
        $table->addColumn('partner_id', 'integer', ['notnull' => true]);
        $table->addColumn('name', 'string', ['notnull' => true]);
        $table->addColumn('kennung', 'string', ['notnull' => true]);
        $table->setPrimaryKey(['interne_id']);
        $table->addForeignKeyConstraint('partner', ['partner_id'], ['interne_id'], [], 'hub_partner_id_fk');

        $table = $schema->createTable('bordero');
        $table->addColumn('interne_id', 'integer', ['autoincrement' => true]);
        $table->addColumn('zeitstempel', 'datetime', ['notnull' => true]);
        $table->addColumn('hub_id', 'integer', ['notnull' => true]);
        $table->addColumn('import_dateiname', 'string', ['notnull' => true]);
        $table->addColumn('nummer', 'string', ['notnull' => true]);
        $table->addColumn('datum', 'date', ['notnull' => true])->setComment('Borderodatum');
        $table->addColumn('empfangs_depot_kennung', 'string', ['notnull' => true]);
        $table->addColumn('release_kennung', 'string', ['notnull' => true]);
        $table->setPrimaryKey(['interne_id']);
        $table->addForeignKeyConstraint('hub', ['hub_id'], ['interne_id'], [], 'bordero_hub_id_fk');

        $table = $schema->createTable('sendung');
        $table->addColumn('interne_id', 'integer', ['autoincrement' => true]);
        $table->addColumn('zeitstempel', 'datetime', ['notnull' => true]);
        $table->addColumn('bordero_id', 'integer', ['notnull' => true]);
        $table->addColumn('bordero_position', 'integer', ['notnull' => true])->setComment('Position innerhalb des Bordero');
        $table->addColumn('versender_name1', 'string', ['notnull' => true]);
        $table->addColumn('versender_name2', 'string', ['notnull' => false]);
        $table->addColumn('versender_strasse', 'string', ['notnull' => true]);
        $table->addColumn('versender_plz', 'string', ['notnull' => true]);
        $table->addColumn('versender_ort', 'string', ['notnull' => true]);
        $table->addColumn('versender_land', 'string', ['notnull' => true]);
        $table->addColumn('empfaenger_name1', 'string', ['notnull' => true]);
        $table->addColumn('empfaenger_name2', 'string', ['notnull' => false]);
        $table->addColumn('empfaenger_strasse', 'string', ['notnull' => true]);
        $table->addColumn('empfaenger_plz', 'string', ['notnull' => true]);
        $table->addColumn('empfaenger_ort', 'string', ['notnull' => true]);
        $table->addColumn('empfaenger_land', 'string', ['notnull' => true]);
        $table->addColumn('sendungsnummer', 'string', ['notnull' => true])->setComment('Barcode der Sendung');
        $table->addColumn('gewicht', 'integer', ['notnull' => false]);
        $table->addColumn('hinweis_text', 'string', ['notnull' => false]);
        $table->setPrimaryKey(['interne_id']);
        $table->addForeignKeyConstraint('bordero', ['bordero_id'], ['interne_id'], ['onDelete' => 'CASCADE'], 'sendung_bordero_id_fk');

        $table = $schema->createTable('colli');
        $table->addColumn('interne_id', 'integer', ['autoincrement' => true]);
        $table->addColumn('zeitstempel', 'datetime', ['notnull' => true]);
        $table->addColumn('sendung_id', 'integer', ['notnull' => true]);
        $table->addColumn('barcode', 'string', ['notnull' => true]);
        $table->addColumn('anzahl_lademittel', 'integer', ['notnull' => true]);
        $table->addColumn('lademittelart', 'string', ['notnull' => true]);
        $table->addColumn('wareninhalt', 'string', ['notnull' => false]);
        $table->setPrimaryKey(['interne_id']);
        $table->addForeignKeyConstraint('sendung', ['sendung_id'], ['interne_id'], ['onDelete' => 'CASCADE'], 'colli_sendung_id_fk');
    }

    public function postUp(Schema $schema): void {
//        $this->connection->executeQuery('INSERT INTO partner VALUES (1, NOW(), 1, "CTL", "096", "\\\\\\\\BFSERVER\\\\apps\\\\CTL_FTP", "20*.096");');
//        $this->connection->executeQuery('INSERT INTO partner VALUES (2, NOW(), 0, "VTL", "04961", "\\\\\\\\BFSERVER\\\\apps\\\\VTL_FTP\\\\In", "04961_de_20*.txt");');
        $this->connection->executeQuery('INSERT INTO partner VALUES (1, NOW(), 1, "CTL", "096", "D:\\\\Temp\\\\hallenscan_testdata\\\\CTL_FTP", "20*.096");');
        $this->connection->executeQuery('INSERT INTO partner VALUES (2, NOW(), 0, "VTL", "04961", "D:\\\\Temp\\\\hallenscan_testdata\\\\VTL_FTP\\\\In", "04961_de_20*.txt");');
        $this->connection->executeQuery('INSERT INTO partner VALUES (3, NOW(), 0, "Test Inaktiv", "XYZ", "C:\\\\Temp\\\\Inaktiv", "*.txt");');
        
        $this->connection->executeQuery('INSERT INTO hub VALUES (1, 1, NOW(), 1, "Homberg", "900");');
        $this->connection->executeQuery('INSERT INTO hub VALUES (2, 1, NOW(), 1, "Grolsheim", "960");');
        $this->connection->executeQuery('INSERT INTO hub VALUES (3, 1, NOW(), 1, "Aurach", "980");');
        $this->connection->executeQuery('INSERT INTO hub VALUES (4, 1, NOW(), 0, "Bottrop", "930");');
        $this->connection->executeQuery('INSERT INTO hub VALUES (5, 1, NOW(), 0, "Lauenau", "950");');
        $this->connection->executeQuery('INSERT INTO hub VALUES (6, 2, NOW(), 1, "Fulda", "04001");');
        $this->connection->executeQuery('INSERT INTO hub VALUES (7, 2, NOW(), 0, "Hannover", "04003");');
        $this->connection->executeQuery('INSERT INTO hub VALUES (8, 2, NOW(), 0, "Gelsenkirchen", "04005");');
        $this->connection->executeQuery('INSERT INTO hub VALUES (9, 3, NOW(), 1, "Test Stuttgart", "ABC");');
    }

    public function down(Schema $schema): void {
        $schema->dropTable('colli');
        $schema->dropTable('sendung');
        $schema->dropTable('bordero');
        $schema->dropTable('hub');
        $schema->dropTable('partner');
        $schema->dropTable('zend_log');
    }

}
