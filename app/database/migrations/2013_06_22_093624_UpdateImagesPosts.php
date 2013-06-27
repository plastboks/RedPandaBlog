<?php

use Illuminate\Database\Migrations\Migration;

class UpdateImagesPosts extends Migration {

   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
       Schema::table('image_post', function($table)
       {
           $table->string('placement');
       });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
       Schema::table('image_post', function($table)
       {
           $table->dropColumn('placement');
       });
   }

}
