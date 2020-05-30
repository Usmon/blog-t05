<?php

use yii\db\Migration;

/**
 * Class m200530_185928_create_posts
 */
class m200530_185928_create_posts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //Create table
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'short' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ]);

        //Creates index for column `author_id`
        $this->createIndex(
            'idx-post-author_id',
            'post',
            'author_id'
        );

        //Add foreign key for table `user`
        $this->addForeignKey(
            'fk-post-author_id',
            'post',
            'author_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        //Drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-post-author_id',
            'post'
        );

        //Drops index for column `author_id`
        $this->dropIndex(
            'idx-post-author_id',
            'post'
        );
        //Drop table
        $this->dropTable('post');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200530_185928_create_post cannot be reverted.\n";

        return false;
    }
    */
}
