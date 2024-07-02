<?php

namespace System\Migrations;

/**
 * The migration class
 */
class api_table_29062024_225137
{

	/**
	 * NSY Migration
	 */

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Mig::connect()->create_table('api_table', [
			Mig::bigint('id', 20)->auto_increment(),
			Mig::varchar('usercode')->not_null(),
			Mig::varchar('username')->not_null(),
			Mig::text('password')->not_null(),
			Mig::varchar('status')->null(),
			Mig::primary('id')
		])->index('BTREE', 'id');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Mig::connect()->drop_exist_table(['api_table']);
	}
}
