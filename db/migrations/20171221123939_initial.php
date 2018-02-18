<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Initial extends AbstractMigration
{
    public function change()
    {
        $this->execute("ALTER DATABASE CHARACTER SET 'latin1';");
        $this->execute("ALTER DATABASE COLLATE='latin1_swedish_ci';");
        $this->execute("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $table = $this->table("forum", ['engine' => "InnoDB", 'encoding' => "latin1", 'collation' => "latin1_swedish_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('forum')->hasColumn('id')) {
            $this->table("forum")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("forum")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('title', 'string', ['null' => false, 'limit' => 64, 'collation' => "latin1_swedish_ci", 'encoding' => "latin1", 'after' => 'id'])->update();
        $table->addColumn('description', 'string', ['null' => true, 'limit' => 255, 'collation' => "latin1_swedish_ci", 'encoding' => "latin1", 'after' => 'title'])->update();
        $table->addColumn('forum_category_id', 'integer', ['null' => true, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'description'])->update();
        $table->addColumn('minimum_access', 'enum', ['null' => false, 'limit' => 6, 'values' => ['member','admin','staff','banned'], 'after' => 'forum_category_id'])->update();
        $table->save();
        if($this->table('forum')->hasIndex('forum_category_id')) {
            $this->table("forum")->removeIndexByName('forum_category_id');
        }
        $this->table("forum")->addIndex(['forum_category_id'], ['name' => "forum_category_id", 'unique' => false])->save();
        $table = $this->table("post", ['engine' => "InnoDB", 'encoding' => "latin1", 'collation' => "latin1_swedish_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('post')->hasColumn('id')) {
            $this->table("post")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("post")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('date_added', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'after' => 'id'])->update();
        $table->addColumn('user_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'date_added'])->update();
        $table->addColumn('thread_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'user_id'])->update();
        $table->addColumn('content', 'text', ['null' => false, 'limit' => 65535, 'collation' => "latin1_swedish_ci", 'encoding' => "latin1", 'after' => 'thread_id'])->update();
        $table->addColumn('last_updated', 'timestamp', ['null' => true, 'after' => 'content'])->update();
        $table->save();
        if($this->table('post')->hasIndex('user_id')) {
            $this->table("post")->removeIndexByName('user_id');
        }
        $this->table("post")->addIndex(['user_id'], ['name' => "user_id", 'unique' => false])->save();
        if($this->table('post')->hasIndex('thread_id')) {
            $this->table("post")->removeIndexByName('thread_id');
        }
        $this->table("post")->addIndex(['thread_id'], ['name' => "thread_id", 'unique' => false])->save();
        $table = $this->table("thread", ['engine' => "InnoDB", 'encoding' => "latin1", 'collation' => "latin1_swedish_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('thread')->hasColumn('id')) {
            $this->table("thread")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("thread")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('title', 'string', ['null' => false, 'limit' => 96, 'collation' => "latin1_swedish_ci", 'encoding' => "latin1", 'after' => 'id'])->update();
        $table->addColumn('date_added', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'after' => 'title'])->update();
        $table->addColumn('user_id', 'integer', ['null' => true, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'date_added'])->update();
        $table->addColumn('forum_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'user_id'])->update();
        $table->addColumn('view_count', 'integer', ['null' => false, 'default' => '0', 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'forum_id'])->update();
        $table->addColumn('date_updated', 'datetime', ['null' => false, 'after' => 'view_count'])->update();
        $table->addColumn('sticky', 'integer', ['null' => false, 'default' => '0', 'limit' => MysqlAdapter::INT_TINY, 'precision' => 3, 'after' => 'date_updated'])->update();
        $table->addColumn('deleted', 'integer', ['null' => false, 'default' => '0', 'limit' => MysqlAdapter::INT_TINY, 'precision' => 3, 'after' => 'sticky'])->update();
        $table->save();
        if($this->table('thread')->hasIndex('forum_id')) {
            $this->table("thread")->removeIndexByName('forum_id');
        }
        $this->table("thread")->addIndex(['forum_id'], ['name' => "forum_id", 'unique' => false])->save();
        if($this->table('thread')->hasIndex('user_id')) {
            $this->table("thread")->removeIndexByName('user_id');
        }
        $this->table("thread")->addIndex(['user_id'], ['name' => "user_id", 'unique' => false])->save();
        $table = $this->table("forum_category", ['engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('forum_category')->hasColumn('id')) {
            $this->table("forum_category")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("forum_category")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('category', 'char', ['null' => false, 'limit' => 64, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'id'])->update();
        $table->save();
        if($this->table('forum_category')->hasIndex('category')) {
            $this->table("forum_category")->removeIndexByName('category');
        }
        $this->table("forum_category")->addIndex(['category'], ['name' => "category", 'unique' => true])->save();
        $table = $this->table("static_email_content", ['engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => ""]);
        $table->save();
        if ($this->table('static_email_content')->hasColumn('id')) {
            $this->table("static_email_content")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("static_email_content")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $table->addColumn('type', 'enum', ['null' => false, 'limit' => 14, 'values' => ['reset_password','food_order'], 'after' => 'id'])->update();
        $table->addColumn('content', 'text', ['null' => false, 'limit' => 65535, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'type'])->update();
        $table->save();
        $table = $this->table("user", ['id' => false, 'primary_key' => ["user_id"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => ""]);
        $table->addColumn('user_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable']);
        $table->addColumn('username', 'string', ['null' => true, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'user_id']);
        $table->addColumn('email', 'string', ['null' => true, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'username']);
        $table->addColumn('display_name', 'string', ['null' => true, 'limit' => 50, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'email']);
        $table->addColumn('password', 'string', ['null' => false, 'limit' => 128, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'display_name']);
        $table->addColumn('date_joined', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'after' => 'password']);
        $table->addColumn('role', 'enum', ['null' => false, 'default' => 'member', 'limit' => 9, 'values' => ['banned','member','admin','staff','superuser',''], 'after' => 'date_joined']);
        $table->addColumn('title', 'string', ['null' => false, 'default' => 'newbie', 'limit' => 64, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'role']);
        $table->addColumn('avatar', 'string', ['null' => true, 'default' => 'http://dmvgs.co.uk/uploads/default-avatar.jpg', 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'title']);
        $table->addColumn('post_signature', 'text', ['null' => true, 'limit' => 65535, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'avatar']);
        $table->addColumn('state', 'integer', ['null' => true, 'limit' => MysqlAdapter::INT_SMALL, 'precision' => 5, 'signed' => false, 'after' => 'post_signature']);
        $table->save();
        if($this->table('user')->hasIndex('username')) {
            $this->table("user")->removeIndexByName('username');
        }
        $this->table("user")->addIndex(['username'], ['name' => "username", 'unique' => true])->save();
        if($this->table('user')->hasIndex('email')) {
            $this->table("user")->removeIndexByName('email');
        }
        $this->table("user")->addIndex(['email'], ['name' => "email", 'unique' => true])->save();
        $table = $this->table("user_uuid", ['id' => false, 'primary_key' => ["user_id", "uuid"], 'engine' => "InnoDB", 'encoding' => "utf8", 'collation' => "utf8_unicode_ci", 'comment' => ""]);
        $table->addColumn('user_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10]);
        $table->addColumn('uuid', 'char', ['null' => false, 'limit' => 36, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'user_id']);
        $table->addColumn('type', 'enum', ['null' => false, 'default' => 'reset_password', 'limit' => 14, 'values' => ['reset_password'], 'after' => 'uuid']);
        $table->save();
    }
}
