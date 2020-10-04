<?php

use Base\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Products extends Migration {
	
    public function up() {
        $this->schema->create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('live')->default(false);
            $table->string('slug', 255);
            $table->string('title', 160);
            $table->text('description');
            $table->float('price');
            $table->integer('stock');
            $table->boolean('sale')->default(false);
            $table->string('image', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down() {
        $this->schema->drop('products');
    }
	
}

/********************************************************************
Available Column Types
Of course, the schema builder contains a variety of column
types that you may specify when building your tables:

Example:
Schema::table('users', function (Blueprint $table) {
    $table->increments('id');
});

Schema::table('users_permissions', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('user_id')->unsigned()->index();

    $table->foreign('user_id')->references('id')->on('users_permissions')->onDelete('cascade');
});

Command ----------------------------------------------- Description
$table->bigIncrements('id');                            Auto-incrementing UNSIGNED BIGINT (primary key) equivalent column.
$table->bigInteger('votes');                            BIGINT equivalent column.
$table->binary('data');                                 BLOB equivalent column.
$table->boolean('confirmed');                           BOOLEAN equivalent column.
$table->char('name', 100);                              CHAR equivalent column with an optional length.
$table->date('created_at');                             DATE equivalent column.
$table->dateTime('created_at');                         DATETIME equivalent column.
$table->dateTimeTz('created_at');                       DATETIME (with timezone) equivalent column.
$table->decimal('amount', 8, 2);                        DECIMAL equivalent column with a precision (total digits) and scale (decimal digits).
$table->double('amount', 8, 2);                         DOUBLE equivalent column with a precision (total digits) and scale (decimal digits).
$table->enum('level', ['easy', 'hard']);                ENUM equivalent column.
$table->float('amount', 8, 2);                          FLOAT equivalent column with a precision (total digits) and scale (decimal digits).
$table->geometry('positions');                          GEOMETRY equivalent column.
$table->geometryCollection('positions');                GEOMETRYCOLLECTION equivalent column.
$table->increments('id');                               Auto-incrementing UNSIGNED INTEGER (primary key) equivalent column.
$table->integer('votes');                               INTEGER equivalent column.
$table->ipAddress('visitor');                           IP address equivalent column.
$table->json('options');                                JSON equivalent column.
$table->jsonb('options');                               JSONB equivalent column.
$table->lineString('positions');                        LINESTRING equivalent column.
$table->longText('description');                        LONGTEXT equivalent column.
$table->macAddress('device');                           MAC address equivalent column.
$table->mediumIncrements('id');                         Auto-incrementing UNSIGNED MEDIUMINT (primary key) equivalent column.
$table->mediumInteger('votes');                         MEDIUMINT equivalent column.
$table->mediumText('description');                      MEDIUMTEXT equivalent column.
$table->morphs('taggable');                             Adds taggable_id UNSIGNED INTEGER and taggable_type VARCHAR equivalent columns.
$table->multiLineString('positions');                   MULTILINESTRING equivalent column.
$table->multiPoint('positions');                        MULTIPOINT equivalent column.
$table->multiPolygon('positions');                      MULTIPOLYGON equivalent column.
$table->nullableMorphs('taggable');                     Adds nullable versions of morphs() columns.
$table->nullableTimestamps();                           Alias of timestamps() method.
$table->point('position');                              POINT equivalent column.
$table->polygon('positions');                           POLYGON equivalent column.
$table->rememberToken();                                Adds a nullable remember_token VARCHAR(100) equivalent column.
$table->smallIncrements('id');                          Auto-incrementing UNSIGNED SMALLINT (primary key) equivalent column.
$table->smallInteger('votes');                          SMALLINT equivalent column.
$table->softDeletes();                                  Adds a nullable deleted_at TIMESTAMP equivalent column for soft deletes.
$table->softDeletesTz();                                Adds a nullable deleted_at TIMESTAMP (with timezone) equivalent column for soft deletes.
$table->string('name', 100);                            VARCHAR equivalent column with a optional length.
$table->text('description');                            TEXT equivalent column.
$table->time('sunrise');                                TIME equivalent column.
$table->timeTz('sunrise');                              TIME (with timezone) equivalent column.
$table->timestamp('added_on');                          TIMESTAMP equivalent column.
$table->timestampTz('added_on');                        TIMESTAMP (with timezone) equivalent column.
$table->timestamps();                                   Adds nullable created_at and updated_at TIMESTAMP equivalent columns.
$table->timestampsTz();                                 Adds nullable created_at and updated_at TIMESTAMP (with timezone) equivalent columns.
$table->tinyIncrements('id');                           Auto-incrementing UNSIGNED TINYINT (primary key) equivalent column.
$table->tinyInteger('votes');                           TINYINT equivalent column.
$table->unsignedBigInteger('votes');                    UNSIGNED BIGINT equivalent column.
$table->unsignedDecimal('amount', 8, 2);                UNSIGNED DECIMAL equivalent column with a precision (total digits) and scale (decimal digits).
$table->unsignedInteger('votes');                       UNSIGNED INTEGER equivalent column.
$table->unsignedMediumInteger('votes');                 UNSIGNED MEDIUMINT equivalent column.
$table->unsignedSmallInteger('votes');                  UNSIGNED SMALLINT equivalent column.
$table->unsignedTinyInteger('votes');                   UNSIGNED TINYINT equivalent column.
$table->uuid('id');                                     UUID equivalent column.
$table->year('birth_year');                             YEAR equivalent column.
~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~

Column Modifiers
In addition to the column types listed above, there are several
column "modifiers" you may use while adding a column to a database table.
For example, to make the column "nullable", you may use the nullable method:

Modifier ---------------------------------------------- Description
->after('column')                                       Place the column "after" another column (MySQL)
->autoIncrement()                                       Set INTEGER columns as auto-increment (primary key)
->charset('utf8')                                       Specify a character set for the column (MySQL)
->collation('utf8_unicode_ci')                          Specify a collation for the column (MySQL/SQL Server)
->comment('my comment')                                 Add a comment to a column (MySQL)
->default($value)                                       Specify a "default" value for the column
->first()                                               Place the column "first" in the table (MySQL)
->nullable($value = true)                               Allows (by default) NULL values to be inserted into the column
->storedAs($expression)                                 Create a stored generated column (MySQL)
->unsigned()                                            Set INTEGER columns as UNSIGNED (MySQL)
->useCurrent()                                          Set TIMESTAMP columns to use CURRENT_TIMESTAMP as default value
->virtualAs($expression)                                Create a virtual generated column (MySQL)
~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~

Dropping Columns
To drop a column, use the dropColumn method on the Schema builder.
Before dropping columns from a SQLite database, you will need to 
add the doctrine/dbal dependency to your composer.json file and run 
the composer update command in your terminal to install the library:

Command ----------------------------------------------- Description
$table->dropColumn('votes');                            Drop a column.
$table->dropColumn(['votes', 'avatar', 'location']);    Drop array of columns.
$table->dropRememberToken();                            Drop the remember_token column.
$table->dropSoftDeletes();                              Drop the deleted_at column.
$table->dropSoftDeletesTz();                            Alias of dropSoftDeletes() method.
$table->dropTimestamps();                               Drop the created_at and updated_at columns.
$table->dropTimestampsTz();                             Alias of dropTimestamps() method.
~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~

Creating Indexes
The schema builder supports several types of indexes. First, let's
look at an example that specifies a column's values should be unique.
To create the index, we can chain the unique method onto the column definition:

Command ----------------------------------------------- Description
$table->primary('id');                                  Adds a primary key.
$table->primary(['id', 'parent_id']);                   Adds composite keys.
$table->unique('email');                                Adds a unique index.
$table->index('state');                                 Adds a plain index.
$table->spatialIndex('location');                       Adds a spatial index. (except SQLite)
~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~

Dropping Indexes
To drop an index, you must specify the index's name. By default,
Laravel automatically assigns a reasonable name to the indexes. 
Concatenate the table name, the name of the indexed column, and 
the index type. Here are some examples:

Command ----------------------------------------------- Description
$table->dropPrimary('users_id_primary');                Drop a primary key from the "users" table.
$table->dropUnique('users_email_unique');               Drop a unique index from the "users" table.
$table->dropIndex('geo_state_index');                   Drop a basic index from the "geo" table.
$table->dropSpatialIndex('geo_location_spatialindex');	Drop a spatial index from the "geo" table (except SQLite).

*********************************************************************/