<?php

use yii\db\Migration;

/**
 * Class m190517_173342_add_rooms_to_locations
 */
class m190517_173342_add_rooms_to_locations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        INSERT INTO `location` (`name`)
        VALUES
            ('Torrey Pines'),
            ('Belmont Park'),
            ('Balboa Park'),
            ('Hotel Del Coronado'),
            ('USS Midway'),
            ('Point Loma');
	    ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return $this->execute("DELETE * FROM `locations`");
    }
}
